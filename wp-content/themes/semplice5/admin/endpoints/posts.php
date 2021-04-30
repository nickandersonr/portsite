<?php

// -----------------------------------------
// semplice
// /admin/endpoints/posts.php
// -----------------------------------------

class admin_api_posts extends admin_api {

	// public vars
	public $db, $editor, $rev_table_name;

	// constructor
	public function __construct() {
		// database
		global $wpdb;
		$this->db = $wpdb;
		$this->rev_table_name = $wpdb->prefix . 'semplice_revisions';

		// editor api
		global $editor_api;
		$this->editor = $editor_api;

		// call register routes on rest api init
		add_action('rest_api_init', array(&$this, 'register_routes'));
	}

	// -----------------------------------------
	// rest routes
	// -----------------------------------------

	public function register_routes() {
		$version = '1';
		$namespace = 'semplice/v' . $version . '/admin';

		// routes
		$routes = array(
			'/posts/(?P<id>\d+)'		=> array('readable', 'posts'),
			'/posts/show-all' 			=> array('readable', 'posts'),
			'/post/create'				=> array('creatable', 'create_post'),
			'/post/duplicate'			=> array('creatable', 'duplicate_post'),
			'/post/delete'				=> array('creatable', 'delete_post'),
			'/post/update-status'		=> array('creatable', 'update_post_status'),
			'/post/pin'					=> array('creatable', 'pin_post'),
			'/post/settings/get'		=> array('readable', 'get_post_settings'),
			'/post/settings/save'		=> array('creatable', 'save_post_settings'),
		);

		// register routes
		semplice_register_route($namespace, $routes, $this);
	}

	// -----------------------------------------
	// endpoints
	// -----------------------------------------

	// get a list of the latest posts
	public function posts($request) {
		// save sortby setting
		if(isset($request['sortby']) && !empty($request['sortby'])) {
			update_option('semplice_sortby', $request['sortby']);
		}
		// save projects view setting
		if(isset($request['projects_view']) && !empty($request['projects_view'])) {
			update_option('semplice_projects_view', $request['projects_view']);
		}
		// get posts
		return new WP_REST_Response(semplice_get_posts($request), 200);
	}

	// create post
	public function create_post($request) {

		// get post meta and check slashes
		$meta = $this->check_slashes($request['meta']);

		// make meta an array
		$meta = json_decode($meta, true);

		// save new post
		$create_post = array(
		  'post_title'    => $meta['post-title'],
		  'post_status'   => 'draft',
		  'post_type'	  => $request['post_type'],
		  'post_name'	  => wp_unique_post_slug(sanitize_title($meta['post-title']), '', 'publish', $request['post_type'], 0),
		);

		// Insert the post into the database
		$post_id = wp_insert_post($create_post);

		// project post settings
		if($request['post_type'] == 'project') {
			// post settings
			$post_settings = array(
				'thumbnail' => array(
					'image' => $meta['project-thumbnail'],
					'width'	=> '',
					'hover_visibility' => 'disabled',
				),
				'meta' => array(
					'post_title' 	=> $meta['post-title'],
					'permalink' 	=> sanitize_title($meta['post-title']),
					'project_type' 	=> $meta['project-type'],
				),
			);
			// save json
			$post_settings = json_encode($post_settings);
			// add to post meta
			update_post_meta($post_id, '_semplice_post_settings', wp_slash($post_settings), '');
		}

		// created with s4 admin so per default set is semplice to true
		update_post_meta($post_id, '_is_semplice', true, '');

		$output = array(
			'post_id' => $post_id
		);

		// portfolio order
		semplice_portfolio_order($post_id);

		// add to menu
		if(isset($meta['add_to_menu']) && $meta['add_to_menu'] == 'yes') {

			// get menu id
			$menu_name = 'Semplice Menu';
			$menu_object = wp_get_nav_menu_object($menu_name);
			
			// is menu there? if not create it
			if(!$menu_object) {
				$menu_id = wp_create_nav_menu($menu_name);
				// get menu localtions
				$locations = get_theme_mod('nav_menu_locations');
				// assign new menu
				$locations['semplice-main-menu'] = $menu_id;
				// set new menu
				set_theme_mod('nav_menu_locations', $locations);
			} else {
				// menu id
				$menu_id = $menu_object->term_id;
			}

			// update nav item
			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-object' 		=> 'page',
				'menu-item-object-id' 	=> $post_id,
				'menu-item-title'  	 	=> __($meta['post-title']),
				'menu-item-status' 	 	=> 'publish',
				'menu-item-type'	 	=> 'post_type',
				'menu-item-url'			=> '',
			));
		}

		// check if cover slider
		if(isset($meta['content_type']) && $meta['content_type'] == 'coverslider') {
			// set cover slider to true in page meta
			update_post_meta($post_id, '_is_coverslider', true, '');
		}

		return new WP_REST_Response($output, 200);
	}

	// duplicate post
	public function duplicate_post($request) {

	 	// post id
		$post_id = $request['post_id'];

		// get post data
		$post = get_post($post_id);

		// output
		$output = array();
		$output['html'] = '';
	 
		// if post data, duplicate
		if(isset($post) && $post != null) {

	 		// dont add another duplicate if there
			if (strpos($post->post_title, ' - Duplicate') === false) {
				$post->post_title = $post->post_title . ' - Duplicate';
			}

			// create new post data array
			$args = array(
				'ping_status'    => $post->ping_status,
				'post_author'    => $post->post_author,
				'post_content'   => $post->post_content,
				'post_excerpt'   => $post->post_excerpt,
				'post_name'      => wp_unique_post_slug(sanitize_title($post->post_title), '', 'publish', $post->post_type, 0),
				'post_parent'    => $post->post_parent,
				'post_password'  => $post->post_password,
				'post_status'    => 'draft',
				'post_title'     => $post->post_title,
				'post_type'      => $post->post_type,
				'to_ping'        => $post->to_ping,
				'menu_order'     => $post->menu_order
			);
	 
			// insert post
			$new_post_id = wp_insert_post($args);

			// set new post id for output
			$output['id'] = $new_post_id;

			//get all current post terms ad set them to the new post draft
			$taxonomies = get_object_taxonomies($post->post_type);

			foreach ($taxonomies as $taxonomy) {
				$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
				wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
			}

			// get revisions
			$revisions = $this->db->get_results( 
				"
				SELECT * 
				FROM $this->rev_table_name
				WHERE post_id = $post_id
				ORDER BY ID ASC
				"
			);

			// post revision
			$post_revision = $this->editor->get_post_revision($post_id);

			// add post revision
			update_post_meta($new_post_id, '_semplice_revisions', $post_revision);

			// published revision for the post meta
			$published_revision = '';
			if(!empty($revisions) && count($revisions) > 0) {
				foreach ($revisions as $revision) {
					// get latest version from the semplice revisions and save this to the new post meta field
					$revision_id = $revision->revision_id;
					$row = $this->db->get_row("SELECT * FROM $this->rev_table_name WHERE post_id = '$post_id' AND revision_id = '$revision_id'");
					// only add content to latest version if available. since its a draft no need to copy the meta field also
					if(null !== $row && !empty($row->content)) {
						// assign content
						$encoded_ram = json_encode(semplice_generate_ram_ids($row->content, true, false), JSON_FORCE_OBJECT);
						// published revision
						if($revision_id == $post_revision['published']) {
							$published_revision = $encoded_ram;
						}
					} else {
						// set encoded ram to false if there is no ram available
						$encoded_ram = '';
					}
					// save revision in the database
					$this->db->insert(
						$this->rev_table_name, 
						array(
							"post_id"		 => $new_post_id,
							"revision_id"  	 => $revision_id,
							"revision_title" => $revision->revision_title,
							"content"		 => $encoded_ram,
							"settings"		 => $row->settings,
							"wp_changes"	 => 0
						)
					);
				}
			}

			//duplicate all post meta just in two SQL queries
			$post_meta_infos = $this->db->get_results("SELECT meta_key, meta_value FROM {$this->db->postmeta} WHERE post_id=$post_id");

			// meta counter
			$meta_count = 0;

			// are there post metas?
			if(count($post_meta_infos) != 0) {
				// iterate post metas
				foreach ($post_meta_infos as $meta_info) {
					$meta_key = $meta_info->meta_key;
					// if semplice content, update post meta seperately for the json string
					if ($meta_key == '_semplice_content') {
						update_post_meta($new_post_id, '_semplice_content', wp_slash($published_revision));
					} else if($meta_key != '_is_semplice' && $meta_key != '_semplice_revisions') {
						$meta_count++;
						$meta_value = addslashes($meta_info->meta_value);
						$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
					}
				}
				// meta count > 0?
				if($meta_count > 0) {
					$sql_query = "INSERT INTO {$this->db->postmeta} (post_id, meta_key, meta_value)";
					$sql_query.= implode(" UNION ALL ", $sql_query_sel);
					$this->db->query($sql_query);
				}
			}

			// activate semplice
			update_post_meta($new_post_id, '_is_semplice', true, '');
		
			// get thumbnail
			if($request['post_type'] == 'project') {
				// post settings
				$thumbnail = semplice_get_thumbnail($post_id, false);
			} else {
				$thumbnail = false;
			}

			// if dashboard, set projects view to thumb
			$projects_view = semplice_get_projects_view();
			if($request['page'] == 'dashboard') {
				$projects_view = 'thumb';
				$request['post_type'] = 'project';
			}

			// format post
			$output['html'] .= semplice_post_row($new_post_id, $request['post_type'], $post->post_title, 'draft', true, $thumbnail, true, $args['post_name'], $projects_view);
		} else {
			$output['html'] = 'Post creation failed, could not find original post: ' . $post_id;
		}

		return new WP_REST_Response($output, 200);
	}

	// delete post
	public function delete_post($request) {

	 	// post id
		$post_id = $request['post_id'];

		// delete post
		if($post_id) {
			wp_trash_post($post_id, false);
		}

		return new WP_REST_Response('Deleted', 200);
	}

	// update post status
	public function update_post_status($request) {
		// update
		if(false !== get_post_status($request['id'])) {
			// change post status
			wp_update_post(array(
				'ID' => $request['id'],
				'post_status' => $request['status'],
			));
		}
		// return
		return new WP_REST_Response('Status Update', 200);
	}

	// pin post
	public function pin_post($request) {
		// vars
		$mode = $request['mode'];
		$id = $request['id'];
		// get pinned posts
		$pinned = semplice_get_pinned();
		if(false !== $pinned && !empty($pinned)) {
			if($mode == 'favorite') {
				$pinned[] = $id;
			} else {
				$pos = array_search($id, $pinned);
				unset($pinned[$pos]);
				// reconstruct array so it starts with 0, otherwise it would turn into object
				$pinned = array_values($pinned);
			}
		} else if(false === $pinned && $mode == 'favorite') {
			$pinned = array($id);
		}
		// update option
		update_option('semplice_pinned', json_encode($pinned));
		// return
		return new WP_REST_Response($pinned, 200);
	}

	// get post settings
	public function get_post_settings($request) {

		// vars
		$output = array(
			'settings' => '',
			'post_select' => array(
				'footer'  => semplice_get_post_dropdown('footer'),
				'project' => semplice_get_post_dropdown('project')
			),
		);
		$post_id = $request['post_id'];
		
		// get post
		$post = get_post($post_id);

		// get post settings from the meta options
		$post_settings = json_decode(get_post_meta($post_id, '_semplice_post_settings', true), true);
		
		// check if array
		if(!is_array($post_settings)) {
			$post_settings = false;
		}

		// get post settings
		$output['settings'] = semplice_generate_post_settings($post_settings, $post);

		// return settings
		return new WP_REST_Response($output, 200);
	}

	// publish post settings
	public function save_post_settings($request) {

		// save post settings
		$args = $this->editor->save_post_settings($request);

		// update post args
		$args['ID'] = $request['post_id'];

		// update post
		wp_update_post($args);

		// is dashboard?
		if($request['active_page'] == 'dashboard') {
			// set post settings
			$request['is_post_settings'] = true;
			$output = $this->dashboard($request, true);
		} else {
			$output = semplice_get_posts($request);
		}

		return new WP_REST_Response($output, 200);
	}
}

// -----------------------------------------
// build instance of endpoints
// -----------------------------------------

$admin_api_posts = new admin_api_posts();

?>