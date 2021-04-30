<?php

// -----------------------------------------
// semplice
// /admin/admin_api.php
// -----------------------------------------

class admin_api {

	// public vars
	public $db, $editor, $rev_table_name;

	// customize static property
	public static $customize;

	public function __construct() {

		// database
		global $wpdb;
		$this->db = $wpdb;
		$this->rev_table_name = $wpdb->prefix . 'semplice_revisions';

		// editor api
		global $editor_api;
		$this->editor = $editor_api;

		// customize list
		$customize_settings = array('grid', 'webfonts', 'navigations', 'typography', 'thumbhover', 'projectnav', 'transitions', 'footer', 'blog', 'advanced');

		// include files
		foreach ($customize_settings as $setting) {
			require get_template_directory() . '/admin/customize/' . $setting . '.php';
		}

		// add action
		add_action('init', array(&$this, 'register_semplice_folder'));

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
			'/dashboard'				=> array('readable', 'dashboard'),
			'/onboarding'				=> array('readable', 'onboarding'),
			'/onboarding/save'			=> array('creatable', 'onboarding_save'),
			'/category/add'				=> array('creatable', 'add_category'),
			'/category/delete'			=> array('creatable', 'delete_category'),
			'/license/save'				=> array('creatable', 'save_license'),
			'/license/release'			=> array('creatable', 'release_license'),
			'/activate-semplice'		=> array('creatable', 'activate_semplice'),
			'/edit/(?P<id>\d+)'			=> array('readable', 'init_editor'),
			'/portfolio-order'			=> array('creatable', 'save_portfolio_order'),
			'/enable-transitions'		=> array('creatable', 'enable_transitions'),
			'/backend-style'			=> array('creatable', 'backend_style'),
		);

		// register routes
		semplice_register_route($namespace, $routes, $this);
	}

	// -----------------------------------------
	// register semplice folder taxonomy
	// -----------------------------------------

	public function register_semplice_folder() {
		// registe taxonomy
		register_taxonomy(
			'semplice_folder', // name of the taxonomy
			'attachment', // object type
			array(
				'label' => __('Semplice Folder'),
				'hierarchical' => false,
				'query_var' => true,
			)
		);
	}

	// -----------------------------------------
	// endpoints
	// -----------------------------------------

	// build dashboard
	public function dashboard($request) {

		// output
		$output = array(
			'html' => '',
			'portfolio_order' => json_decode(get_option('semplice_portfolio_order'))
		);

		// open dashboard
		$output['html'] .= '<div class="semplice-dashboard">';

		// get license
		$license = json_decode(get_option('semplice_license'), true);

		// check if theme folder is correct and license is valid
		if(!is_array($license) || is_array($license) && true !== $license['is_valid']) {
			if(is_array($license) && isset($license['product']) && $license['product'] == 'subscription') {
				$message = 'Your subscription has expired, please make sure to re-enter your license key or subscribe to our Semplice Club.';
			} else {
				$message = 'Don\'t forget to activate Semplice to receive free one-click updates.';
			}
			$output['html'] .= '
				<div class="activate-now">
					<div class="admin-container">
						<div class="admin-row">
							<div class="admin-column" data-xl-width="12">
								<div class="icon">' . get_svg('backend', '/icons/popup_important') . '</div>
								<h4>' . $message . '</h4>
								<a class="activate-button" href="#settings/license">Activate Now</a>
							</div>
						</div>
					</div>
				</div>
			';
		}

		// get posts
		$output['html'] .= '
			<div class="projects posts admin-container">
				<div class="dashboard-projects-head">
					<div class="projects-heading">
						<h4>Recently edited</h4>
					</div>
					<div class="add-post-dashboard">
						<a class="semplice-button admin-click-handler" data-handler="addPostDashboard">Add new</a>
						<div class="add-post-dashboard-popup">
							<div class="add-page admin-click-handler" data-handler="execute" data-action="addPost" data-action-type="main" data-post-type="page">
								' . get_svg('backend', '/icons/dashboard_add_page') . '
								<span>Page</span>
							</div>
							<div class="add-project admin-click-handler" data-handler="execute" data-action="addPost" data-action-type="main" data-post-type="project">
								' . get_svg('backend', '/icons/dashboard_add_project') . '
								<span>Project</span>
							</div>
						</div>
					</div>
				</div>
				<div class="projects-list admin-row">
					' . semplice_dashboard_projects() . '
				</div>
			</div>
		';

		// divider
		$output['html'] .= '<div class="dashboard-divider"></div>';

		// get content from semplicelabs
		$news_content = wp_remote_get('https://news.semplice.com/wp-json/news/v1/news');

		// is error?
		if(!is_wp_error($news_content) && empty($news_content->errors)) {
			$news_content = json_decode($news_content['body'], true);
			// is content?
			if(null !== $news_content && is_array($news_content)) {
				// news
				$output['html'] .= '<div class="dashboard-news-wrapper"><div class="admin-container"><h4>Featured</h4><div class="admin-row">' . $news_content['news'] . '</div></div></div>';
				// divider
				$output['html'] .= '<div class="dashboard-divider"></div>';
				// changelog + misc headings
				$output['html'] .= '
					<div class="dashboard-changelog-wrapper">
						<div class="admin-container">
							<div class="admin-row">
								<div class="admin-column changelog-column" data-xl-width="8">
									<h4>Changelog</h4>
								</div>
								<div class="admin-column" data-xl-width="4">
									<h4>About</h4>
								</div>
							</div>
						</div>
						<div class="admin-container">
							<div class="admin-row">
								<div class="admin-column" data-xl-width="8">
									<div class="dashboard-changelog" data-changelog-version="' . semplice_theme('edition') . '">
										' . $news_content['changelog'] . '
										<div class="changelog-link"><a href="https://www.semplice.com/changelog-v5-' . semplice_theme('edition') . '" target="_blank">View complete changelog on semplice.com</a></div>
										<div class="changelog-expand">' . get_svg('frontend', '/icons/arrow_down') . '</div>
									</div>
								</div>
								<div class="admin-column" data-xl-width="4">
									<div class="about-semplice" data-update-status="uptodate">
										<h3>' . get_svg('backend', '/adler_about') . '</h3>
										' . semplice_about() . '
									</div>
								</div>
							</div>
						</div>
					</div>
				';
			}
		} else {
			// column open
			$error = '<div class="admin-column dashboard-error" data-xl-width="12"><p>An error occured while trying to fetch content from https://news.semplice.com.</p>';

			if(is_wp_error($news_content)) {
				$error .= '<p><span>Error Message: ' . $news_content->get_error_message() . '</span></p>';
			} else {
				$error .= '<p><span>Error Message: Unfortunately there were no detailed error message provided.</span></p>';
			}

			// column close
			$error .= '</div>';

			// output
			$output['html'] .= '<div class="admin-container"><h4>Problems connecting to semplice.com</h4><div class="admin-row"><div class="admin-column" data-xl-width="12">' . $error . '</div></div></div>';
		}

		// close dashboard
		$output['html'] .= '</div>';

		if(isset($request['is_post_settings'])) {
			return $output;
		} else {
			return new WP_REST_Response($output, 200);
		}
	}

	// get onboarding html
	public function onboarding($request) {

		// output array
		$output = array(
			'html' => semplice_get_onboarding($request['step']),
		);

		return new WP_REST_Response($output, 200);
	}

	// save onboarding
	public function onboarding_save($request) {

		// defaults
		$defaults = array(
			'site_title' 	=> 'Sergio Rambotta',
			'site_tagline' 	=> 'Graphic Designer',
			'theme' 		=> 'bright',
		);

		// get content and check slashes
		$content = $this->check_slashes($request['content']);

		// make array
		$content = json_decode($content, true);

		// loop throught data and fill with default if no data there
		foreach ($defaults as $attribute => $default) {
			// is empty?
			if(!isset($content[$attribute]) || empty($content[$attribute])) {
				$content[$attribute] = $default;
			}	
		}

		// save pages
		$pages = array('work', 'about');
		$savePages = array();

		// create new pages
		foreach ($pages as $page) {
			// first page
			$savePages[$page] = array(
				'post_title'   => ucfirst($page),
				'post_status'  => 'publish',
				'post_type'	   => 'page',
				'post_name'	   => wp_unique_post_slug(sanitize_title(ucfirst($page)), '', 'publish', 'page', 0),
			);
			// add first page
			$savePages[$page]['id'] = wp_insert_post($savePages[$page]);
			// get first page data
			$savePages[$page]['data'] = semplice_first_page($savePages[$page]['id'], $page, array('active' => 'latest_version', 'published' => 'latest_version'));
			// add content to first project
			$this->editor->save($savePages[$page]['data']);
			// created with s4 admin so per default set is semplice to true
			update_post_meta($savePages[$page]['id'], '_is_semplice', true, '');
			// is homepage
			if($page == 'work') {
				// set show on front to page
				update_option('show_on_front', 'page');
				// make homepage
				update_option('page_on_front', $savePages[$page]['id']);
			}
		}

		// set blog name
		update_option('blogname', $content['site_title']);

		// set blog description
		update_option('blogdescription', $content['site_tagline']);

		// first project
		$first_project = array(
		  'post_title'    => 'My First Project',
		  'post_status'   => 'draft',
		  'post_type'	  => 'project',
		  'post_name'	  => wp_unique_post_slug(sanitize_title('My First Project'), '', 'publish', 'project', 0),
		);

		// add first projects
		$first_project_id = wp_insert_post($first_project);

		// get first project data
		$first_project_data = semplice_first_project($first_project_id, array('active' => 'latest_version', 'published' => 'latest_version'));

		// portfolio order
		semplice_portfolio_order($first_project_id);

		// add content to first project
		$this->editor->save($first_project_data);

		// add a new menu called semplice menu
		$menu_name = 'Semplice Menu';
		$menu_object = wp_get_nav_menu_object($menu_name);

		// craate new menu if it doesnt already exist
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

		// add our new created homepage as first page
		wp_update_nav_menu_item($menu_id, 0, array(
			'menu-item-object' 		=> 'page',
			'menu-item-title'  	 	=> 'Work',
			'menu-item-object-id' 	=> $savePages['work']['id'],
			'menu-item-status' 	 	=> 'publish',
			'menu-item-type'	 	=> 'post_type',
			'menu-item-url'			=> '',
		));

		// add about page
		wp_update_nav_menu_item($menu_id, 0, array(
			'menu-item-object' 		=> 'page',
			'menu-item-title'  	 	=> 'About',
			'menu-item-object-id' 	=> $savePages['about']['id'],
			'menu-item-status' 	 	=> 'publish',
			'menu-item-type'	 	=> 'post_type',
			'menu-item-url'			=> '',
		));

		// save nav
		if(!empty($request['nav'])) {
			update_option('semplice_customize_navigations', $request['nav']);
		}

		// save backend style
		update_option('semplice_backend_style', $content['theme']);

		// set completed onboarding to true
		update_option('semplice_completed_onboarding', true);

		return new WP_REST_Response('Onboarding completed.', 200);
	}

	// init editor
	public function init_editor($request) {

		// post meta
		$post_id = $request['post_id']; // can be the real post id or the id of a exising page or project (template)
		$post_type = get_post_type($request['post_type_id']); // always needs the real id to get the right post type instead of the post type from the template (if a template is used)

		// get revision
		$post_revision = $this->editor->get_post_revision($post_id);

		// revision id
		$revision_id = $post_revision['active'];

		// get revision
		$revision = $this->db->get_row("SELECT * FROM $this->rev_table_name WHERE post_id = '$post_id' AND revision_id = '$revision_id'");
		// revision is not in the DB anymore or anything went wrwong? get latest version
		if(null === $revision) {
			$revision = $this->db->get_row("SELECT * FROM $this->rev_table_name WHERE post_id = '$post_id' AND revision_id = 'latest_version'");
		}

		// init masterblocks
		if(null !== $revision && isset($revision->content) && !empty($revision->content)) {
			$revision->content = $this->editor->init_masterblocks($revision->content);
		}

		// if template rewrite ram ids
		if(semplice_boolval($request['is_template']) === true && null !== $revision && isset($revision->content)) {
			// if not empty generate ids, otherwise return empty
			if(!empty($revision->content)) {
				$revision->content = json_encode(semplice_generate_ram_ids($revision->content, true, false), JSON_FORCE_OBJECT);
			} else {
				$revision->content = 'empty';
			}
		} 
		
		// get post
		$post = get_post($post_id);

		// check if row has content already, if not create latest_version revision
		if(null !== $revision) {
			$ram = json_decode($revision->content, true);
		} else {
			$ram = false;
			// dont add latest version to the original template post
			if(false === semplice_boolval($request['is_template'])) {
				// save revision in the database
				$this->db->insert(
					$this->rev_table_name,
					array(
						"post_id"		 => $post_id,
						"revision_id"  	 => 'latest_version',
						"revision_title" => 'Latest Version',
						"content"		 => '',
						"settings"		 => '',
						"wp_changes"	 => 0
					)
				);
			}
		}

		// get post settings from post meta
		$post_settings = json_decode(get_post_meta($post_id, '_semplice_post_settings', true), true);

		// generate post settings
		if($post_type != 'footer') {
			$post_settings = semplice_generate_post_settings($post_settings, $post);
		} else {
			// make sure to empty 'branding' for the footer so it will not overwrite things
			if(is_array($ram) && isset($ram['branding'])) {
				$ram['branding'] = array();
			}
			$post_settings = false;
		}

		// get post status
		$post_status = get_post_status($post_id);

		// get post password
		if(!empty($post->post_password)) {
			$post_password = $post->post_password;
		} else {
			$post_password = '';
		}

		// get thumbnail
		$thumbnail = semplice_get_thumbnail_id($post_settings, $post_id);

		// define images
		$images = array();

		if(!empty($thumbnail)) {
			$images[$thumbnail] = semplice_get_image_object($thumbnail, 'full');
		}

		// get cover slider
		$is_coverslider = semplice_boolval(get_post_meta($post->ID, '_is_coverslider', true));

		// get covers
		$covers = semplice_posts_with_covers();

		// post meta
		$post_meta = array(
			'post_title'		=> $post->post_title,
			'post_type'	 		=> $post_type,
			'post_password'		=> $post_password,
			'post_status' 		=> $post_status,
			'permalink'			=> $post->post_name,
		);

		// customize css
		$css = array(
			'post'				=> '',
			'typography'	=> admin_api::$customize['typography']->get('css', true, false),
			'grid'			=> semplice_grid('editor'),
			'webfonts'		=> admin_api::$customize['webfonts']->generate_css(false),
			'advanced'		=> admin_api::$customize['advanced']->generate_css(false),
			'thumbhover'	=> admin_api::$customize['thumbhover']->generate_sp_css(false)
		);

		// post select
		$post_select = array(
			'footer'  => semplice_get_post_dropdown('footer'),
			'project' => semplice_get_post_dropdown('project')
		);
		
		if(!empty($ram)) {

			// get content
			$content = $this->editor->get_content($ram, 'editor', false, $is_coverslider);

			// images
			if(is_array($ram['images'])) {

				// fetch all image urls in case they have chnaged (ex domain)
				foreach ($ram['images'] as $image_id => $image_url) {
					// fetch image
					$image = wp_get_attachment_image_src($image_id, 'full', false);
					// is array?
					if(is_array($image)) {
						// add image
						$images[$image_id] = array(
							'url'    => $image[0],
							'width'  => $image[1],
							'height' => $image[2],
						);
					}
				}
			}

			// add post css
			$css['post'] = $content['css'];

			// set output ram to revision content
			$output_ram = $revision->content;

			// set output html
			$output_html = $content['html'];
		} else {
			// is coverslider?
			if(true === $is_coverslider) {
				// if covers available use them all, if not make an empty slider
				if(!empty($covers)) {
					// create fake ram
					$fake_ram = array(
						'coverslider' => array(
							'covers' => array(),
						),
					);
					// make coverslider compatible list
					foreach ($covers as $post_id => $post_title) {
						array_push($fake_ram['coverslider']['covers'], $post_id);
					}
					// get content
					$content = $this->editor->get_content($fake_ram, 'editor', false, true);
					// add html
					$default_html = $content['html'];
					// css
					$css['post'] = $content['css'];
				} else {
					$default_html = semplice_empty_coverslider();
				}
			} else {
				$default_html = semplice_default_cover('hidden');
			}

			// set output ram to empty
			$output_ram = 'empty';

			// set output html
			$output_html = $default_html;
		}

		$output = array(
			'ram' 		 		=> $output_ram,
			'html'  	 		=> $output_html,
			'css'		 		=> $css,
			'images'  	 		=> !empty($images) ? $images : '',
			'meta'				=> $post_meta,
			'post_settings' 	=> $post_settings,
			'navigator'			=> $this->editor->navigator(),
			'post_select'		=> $post_select,
			'covers'			=> $covers,
			'is_coverslider'	=> $is_coverslider,
			'posts'				=> semplice_get_apg_posts('content', false),
			'revisions'			=> $this->editor->get_revisions($post->ID),
			'post_revision'  	=> $post_revision,
			'template_dropdown' => semplice_get_template_dropdown(),
		);

		return new WP_REST_Response($output, 200);
	}

	// add category
	public function add_category($request) {

		// define output
		$output = array();

		// return id of new category
		$output['id'] = wp_insert_term($request['name'], 'category', $args = array('parent' => $request['parent']));

		// get updated list of category dropdown
		$output['dropdown'] = '<div class="select-box"><div class="sb-arrow"></div>' . wp_dropdown_categories('hide_empty=0&echo=0&depth=5&hierarchical=1') . '</div>';

		return new WP_REST_Response($output, 200);
	}

	// remove category
	public function delete_category($request) {

		// define output
		$output = '';

		// remove category
		wp_delete_term($request['term_id'], 'category', '');

		// get updated list of category dropdown
		$output = '<div class="select-box"><div class="sb-arrow"></div>' . wp_dropdown_categories('hide_empty=0&echo=0&depth=5&hierarchical=1') . '</div>';

		return new WP_REST_Response($output, 200);	
	}

	// save portfolio order
	public function save_portfolio_order($request) {

		// get settings and add or remove slashes
		$order = $request['portfolio_order'];

		// save settings in the DB
		update_option('semplice_portfolio_order', $order);

		return new WP_REST_Response('saved', 200);
	}

	// license save
	public function save_license($request) {
		// check license
		$output = semplice_save_license($request['key'], $request['product']);
		// return
		return new WP_REST_Response($output, 200);
	}

	// license release
	public function release_license($request) {
		// set license to false
		update_option('semplice_license', false);
		// return
		return new WP_REST_Response('success', 200);
	}

	// activate semplice
	public function activate_semplice($request) {
		// created with s4 admin so per default set is semplice to true
		update_post_meta($request['post_id'], '_is_semplice', true, '');
		// return
		return new WP_REST_Response('Activated Semplice', 200);
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

	// enable transitions
	public function enable_transitions($request) {
		// get custmomize advanced
		$settings = json_decode(get_option('semplice_settings_general'), true);
		// chnage setting
		$settings['frontend_mode'] = 'dynamic';
		// save again
		update_option('semplice_settings_general', json_encode($settings));
		// return
		return new WP_REST_Response('Motions enabled.', 200);
	}

	// save backend style
	public function backend_style($request) {
		// save again
		update_option('semplice_backend_style', $request['style']);
		// return
		return new WP_REST_Response('Saved style.', 200);
	}

	// -----------------------------------------
	// check nonce and admin rights
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
// build instance of semplice api
// -----------------------------------------

$admin_api = new admin_api();

?>