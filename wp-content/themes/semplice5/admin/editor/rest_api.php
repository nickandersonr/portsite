<?php

// -----------------------------------------
// semplice
// admin/editor/rest_api.php
// -----------------------------------------

// include editor
require get_template_directory() . '/admin/editor/editor.php';

// include blocks
require get_template_directory() . '/admin/editor/blocks.php';

class editor_api extends editor {

	// public vars
	public $blocks;

	public function __construct() {

		// load constructor of editor
		parent::__construct();

		// call register routes on rest api init
		add_action('rest_api_init', array(&$this, 'register_routes'));

		// instance of blocks
		$this->blocks = new blocks;
	}

	// -----------------------------------------
	// endpoints
	// -----------------------------------------

	public function register_routes() {
		$version = '1';
		$namespace = 'semplice/v' . $version . '/editor';

		// routes
		$routes = array(
			'/version'				=> array('readable', 'version'),
			'/blocks/add'			=> array('readable', 'add_block'),
			'/blocks/save'			=> array('creatable', 'save_block'),
			'/blocks/delete'		=> array('creatable', 'delete_block'),
			'/module'				=> array('readable', 'module'),
			'/duplicate'			=> array('creatable', 'duplicate'),
			'/publish'				=> array('creatable', 'publish'),
			'/save'					=> array('creatable', 'save'),
			'/save/footer-settings'	=> array('creatable', 'save_footer_settings'),
			'/revision/save'		=> array('creatable', 'save_revision'),
			'/revision/rename'		=> array('creatable', 'rename_revision'),
			'/revision/load'		=> array('readable', 'load_revision'),
			'/revision/delete'		=> array('creatable', 'delete_revision'),
			'/masonry'				=> array('creatable', 'masonry'),
			'/single-project'		=> array('creatable', 'single_project'),
			'/apg/edit'				=> array('creatable', 'edit_apg'),
			'/coverslider'			=> array('creatable', 'coverslider'),
			'/remove-token'			=> array('creatable', 'remove_token'),
			'/import-cover'			=> array('creatable', 'import_cover'),
			'/save-animate-presets'  => array('creatable', 'save_animate_presets'),
		);
		
		// register routes
		semplice_register_route($namespace, $routes, $this);
	}

	// show semplice version information
	public function version($request) {

		$version = array(
			'editor_version'	=> '1.0',
			'php_version'		=> PHP_VERSION
		);

		return new WP_REST_Response($version, 200);
	}

	// add block
	public function add_block($request) {

		// get ram
		$ram = $this->blocks->get($request['id'], $request['type']);

		// is array?
		if(is_array($ram)) {
			// get html, css etc.
			$output = $this->get_content($ram, 'editor', true, false);

			// delete order from ram
			unset($ram['order']);

			// add images to output and then unset from ram
			$output['images'] = $ram['images'];
			unset($ram['images']);

			// add ram ro output
			$output['ram'] = json_encode($ram, JSON_FORCE_OBJECT);
		} else {
			$output['ram'] = $ram;
		}

		return new WP_REST_Response($output, 200);
	}

	// save block
	public function save_block($request) {

		// get ram
		$content = $this->check_slashes($request['content']);

		// save
		$output = $this->blocks->save($content, $request['name'], $request['mode'], $request['masterblock']);

		return new WP_REST_Response($output, 200);
	}

	// delete block
	public function delete_block($request) {

		// save
		$this->blocks->delete($request['id']);

		return new WP_REST_Response('Block deleted.', 200);
	}

	// get masonry
	public function masonry($request) {

		// get content and check slashes
		$content = $this->check_slashes($request['content']);

		// save dribbble token if set
		if(isset($request['token']) && !empty($request['token'])) {
			update_option('semplice_dribbble_token', $request['token']);
		}

		// decode
		$content = json_decode($content, true);

		// add script execution
		$content['script_execution'] = 'normal';

		// include module
		require_once get_template_directory() . '/admin/editor/modules/' . $request['module'] . '.php';
		
		// output
		$output = $this->module[$request['module']]->output_editor($content, $request['id']);

		return new WP_REST_Response($output, 200);
	}

	// get single project
	public function single_project($request) {

		// get content and check slashes
		$content = $this->check_slashes($request['content']);

		// decode
		$content = json_decode($content, true);

		// include module
		require_once get_template_directory() . '/admin/editor/modules/singleproject.php';
		
		// output
		$output = $this->module[$request['module']]->output_editor($content, $request['id']);

		return new WP_REST_Response($output, 200);
	}

	// get apg
	public function edit_apg($request) {

		// get content and check slashes
		$content = $this->check_slashes($request['content']);

		// decode
		$content = json_decode($content, true);

		// add section element
		$content['section_element'] = $request['section_element'];

		// include module
		require_once get_template_directory() . '/admin/editor/modules/advancedportfoliogrid.php';
		
		// output
		$output = $this->module['advancedportfoliogrid']->output_editor($content, $request['id']);

		return new WP_REST_Response($output, 200);
	}

	// duplicate
	public function duplicate($request) {
		$module = $this->generate_duplicate($request, 'editor');

		return new WP_REST_Response($module, 200);
	}
	
	// save and publish
	public function save($request) {

		// save mode
		$save_mode = $request['save_mode'];

		// change setatus
		$change_status = $request['change_status'];

		// get content and check slashes
		$content = $this->check_slashes($request['content']);

		// get masterblocks and check slasahes
		$masterblocks = json_decode($request['masterblocks'], true);

		if(!empty($masterblocks) && is_array($masterblocks)) {
			foreach ($masterblocks as $section_id => $masterblock) {
				// check slashes
				$masterblock_content = $this->check_slashes($masterblock['content']);
				// save content
				$this->blocks->save($masterblock_content, '', 'update', $masterblock['id']);
			}
		}

		// save custom animate presets
		if(isset($request['presets'])) {
			$presets = $this->check_slashes($request['presets']);
			update_option('semplice_animate_presets', $presets);
		}
		
		// as long as the user saves via the editor, set semplice as activated
		update_post_meta($request['post_id'], '_is_semplice', true, '');

		// save post settings
		if($request['post_type'] != 'footer') {
			$args = $this->save_post_settings($request);	
		} else {
			$args = array();
		}

		// only save to post if save mode is publish or post status is draft, otherwise just save to revision. add post meta. since wordpress strips slashes on post meta, add them before as a workaround
		if($save_mode == 'publish' || $save_mode == 'private' || get_post_status($request['post_id']) == 'draft') {
			if($save_mode == 'publish') {
				// if draft, change to publish
				$args['post_status'] = 'publish';
			} else if($save_mode == 'private') {
				$args['post_status'] = 'private';
			}
			// update post meta
			update_post_meta($request['post_id'], '_semplice_content', wp_slash($content), '');
		} else {
			// change status
			if($change_status == 'yes') {
				$args['post_status'] = 'draft';
			}
		}

		// post password
		$post_password = $request['post_password'];

		if($post_password && !empty($post_password)) {
			$args['post_password'] = $post_password;
		} else {
			$args['post_password'] = '';
		}

		// editor notices
		if(isset($request['editor_notices'])) {
			update_option('semplice_editor_notices', $request['editor_notices']);
		}

		// update post args
		$args['ID'] = $request['post_id'];

		// before publish, make sure this is saved to the latest version in the revisions
		$this->save_revision($request);

		// save colors
		if(isset($request['custom_colors'])) {
			update_option('semplice_custom_colors', $request['custom_colors']);
		}

		// update post
		wp_update_post($args);

		return new WP_REST_Response($this->get_revisions($request['post_id']), 200);
	}

	// load revision
	public function load_revision($request) {

		// post id
		$post_id = $request['post_id'];

		// revision id
		$revision_id = $request['revision_id'];

		// post revision
		$post_revision = $request['post_revision'];

		// get row
		$revision = $this->db->get_row("SELECT * FROM $this->rev_table_name WHERE post_id = '$post_id' AND revision_id = '$revision_id'");

		// init masterblocks
		if(null !== $revision && isset($revision->content) && !empty($revision->content)) {
			$revision->content = $this->init_masterblocks($revision->content);
		}

		// check if content
		if(null !== $revision) {
			if(!empty($revision->content)) {
				// get content
				$content = $this->get_content(json_decode($revision->content, true), 'editor', false, false);
				// output
				$output = array(
					'ram' 	=> $revision->content,
					'html' 	=> $content['html'],
					'css' 	=> $content['css'],
					'status'=> 'ok',
				);
			} else {
				// output
				$output = array(
					'ram' 	=> 'empty',
					'html'  => $default_html = semplice_default_cover('hidden'),
					'status'=> 'ok',
				);
			}
			// set active revision
			$post_revision['active'] = $revision_id;
			// update post meta
			update_post_meta($request['post_id'], '_semplice_revisions', $post_revision, '');
		} else {
			$output = array('status' == 'error');
		}

		// add list
		$output['list'] = $this->get_revisions($request['post_id']);

		return new WP_REST_Response($output, 200);
	}

	// save revision
	public function delete_revision($request) {

		// post revision
		$post_revision = $request['post_revision'];

		// update trigger
		$update_post_meta = false;

		// post id
		$post_id = $request['post_id'];

		// iterate post revision
		foreach ($post_revision as $status => $revision_id) {
			if($revision_id == $request['revision_id']) {
				$post_revision[$status] = 'latest_version';
				// trigger update
				$update_post_meta = true;
				// if published, make default version published
				if($status == 'published') {
					// get latest version and save to post meta
					$latest_version = $this->db->get_row("SELECT * FROM $this->rev_table_name WHERE post_id = '$post_id' AND revision_id = 'latest_version'");
					if(null !== $latest_version && !empty($latest_version->content)) {
						// assign content
						$encoded_ram = json_encode(semplice_generate_ram_ids($latest_version->content, true, false), JSON_FORCE_OBJECT);
					} else {
						// set encoded ram to false if there is no ram available
						$encoded_ram = '';
					}
					// save to post meta
					update_post_meta($post_id, '_semplice_content', wp_slash($encoded_ram));
				}
			}
		}

		// update post meta
		if(true === $update_post_meta) {
			update_post_meta($request['post_id'], '_semplice_revisions', $post_revision, '');
		}

		// delete from database
		$this->db->delete(
			$this->rev_table_name,
			array(
				'revision_id' => $request['revision_id'],
				'post_id'	  => $post_id,
			)
		);

		// output
		$output = array(
			'list' => $this->get_revisions($post_id),
			'post_revision' => $post_revision
		);

		return new WP_REST_Response($output, 200);
	}

	// save revision
	public function save_revision($request) {

		// revisions
		$post_revision = $request['post_revision'];

		// revision id
		$revision_id = $post_revision['active'];

		// update revisions in the db
		update_post_meta($request['post_id'], '_semplice_revisions', $post_revision, '');

		// revision title
		$revision_title = 'Latest Version';
		if(!empty($request['revision_title'])) {
			$revision_title = $request['revision_title'];
		}

		// post id
		$post_id = $request['post_id'];

		// get content and check slashes
		$content = $this->check_slashes($request['content']);
		
		// get row
		$row = $this->db->get_row("SELECT * FROM $this->rev_table_name WHERE post_id = '$post_id' AND revision_id = '$revision_id'");

		// check if this is the first save
		if(null === $row) {
			// save revision in the database
			$this->db->insert(
				$this->rev_table_name,
				array(
					"post_id"		 => $request['post_id'],
					"revision_id"  	 => $revision_id,
					"revision_title" => $revision_title,
					"content"		 => $content,
					"settings"		 => '',
					"wp_changes"	 => 0
				)
			);
		} else {
			// update unsaved changes
			$this->db->update(
				$this->rev_table_name, 
				array(
					"content"	  	=> $content,
				),
				array(
					"post_id" 		=> $request['post_id'],
					"revision_id"	=> $revision_id
				)
			);
		}
		// only return something if a new version is saved
		if(isset($request['save_version'])) {
			return new WP_REST_Response('Revision saved.', 200);
		}
	}

	// rename revision
	public function rename_revision($request) {
		// update title
		$this->db->update(
			$this->rev_table_name, 
			array(
				"revision_title" => $request['revision_title'],
			),
			array(
				"post_id" 		=> $request['post_id'],
				"revision_id"	=> $request['revision_id']
			)
		);
		// return list
		return new WP_REST_Response($this->get_revisions($request['post_id']), 200);
	}

	// post settings
	public function save_post_settings($request) {

		// get post settings and check slashes
		$post_settings_json = $this->check_slashes($request['post_settings']);

		// decode post settings
		$post_settings = json_decode($post_settings_json, true);

		// save admin images
		if(isset($request['images']) && !empty($request['images'])) {
			update_option('semplice_admin_images', $request['images']);
		}

		// save seo
		if(isset($post_settings['seo'])) {
			foreach ($post_settings['seo'] as $key => $value) {
				// update post meta
				update_post_meta($request['post_id'], $key, wp_slash($value), '');
			}	
		}
		
		//publish settings
		$args = array();

		// save post settings in post meta
		update_post_meta($request['post_id'], '_semplice_post_settings', wp_slash($post_settings_json), '');

		// get post
		$post = get_post($request['post_id']);

		// apply post settings
		if(!empty($post_settings['meta'])) {
			$args['post_title'] = $post_settings['meta']['post_title'];
			// page slug
			if($post->post_name != $post_settings['meta']['permalink']) {
				$args['post_name'] = wp_unique_post_slug(sanitize_title($post_settings['meta']['permalink']), $request['post_id'], 'publish', $request['post_type'], 0);
			}
			// has categories and is not post type page
			if($request['post_type'] != 'page') {
				// set categories
				if(!empty($post_settings['meta']['categories'])) {
					wp_set_post_categories($request['post_id'], $post_settings['meta']['categories'], false);
				} else {
					wp_set_post_categories($request['post_id'], array(), false);
				}
			}
		}

		// return args
		return $args;
	}

	// footer settings
	public function save_footer_settings($request) {

		// get post settings and check slashes
		$footer_settings_json = $this->check_slashes($request['settings']);

		// decode post settings
		$footer_settings = json_decode($footer_settings_json, true);

		// save title to post
		if(isset($footer_settings['title'])) {

			// update post
			wp_update_post(array(
				'ID' => $request['id'],
				'post_title' => $footer_settings['title'],
			));
		}

		return new WP_REST_Response('Footer settings saved successfully', 200);
	}

	// coverslider
	public function coverslider($request) {
		// return slider html
		return new WP_REST_Response(semplice_get_coverslider($request['covers'], 'editor', 'normal'), 200);
	}

	// remove token
	public function remove_token($request) {

		// define option
		$option = 'semplice_' . $request['vendor'] . '_token';

		// dribbble v2
		if($request['vendor'] == 'dribbble') {
			$option = 'semplice_' . $request['vendor'] . '_token_v2';
		}
		
		// is vendor set?
		if(isset($request['vendor'])) {
			update_option($option, false);
		}

		return new WP_REST_Response('Token removed', 200);
	}

	// import cover
	public function import_cover($request) {
		// output
		return new WP_REST_Response(semplice_import_cover($request['post_id']), 200);
	}

	// save animate preset
	public function save_animate_presets($request) {

		// vars
		$presets = $this->check_slashes($request['presets']);
		
		// save presets
		update_option('semplice_animate_presets', $presets);

		// output newest list
		return new WP_REST_Response('Saved.', 200);
	}

	// check slashes
	public function check_slashes($content) {

		// get first 3 chars of content json string
		$quote_status = mb_substr($content, 0, 2);

		if($quote_status !== '{"') {
			$content = stripcslashes($content);
		}

		// return content
		return $content;
	}

	// -----------------------------------------
	// check nonce to verify user
	// -----------------------------------------

	public function auth_user() {

		// get nonce
		$nonce = isset($_SERVER['HTTP_X_WP_NONCE']) ? $_SERVER['HTTP_X_WP_NONCE'] : '';

		// verfiy nonce
		$nonce = wp_verify_nonce($nonce, 'wp_rest');

		// check nonce and if current user has admin rights
		if($nonce && current_user_can('manage_options')) {
			return true;
		} else {
			return false;
		}
	}
}

// -----------------------------------------
// build instance of editor api and editor class
// -----------------------------------------

$editor_api = new editor_api();

?>