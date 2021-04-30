<?php

// -----------------------------------------
// semplice
// /admin/endpoints/customize.php
// -----------------------------------------

class admin_api_customize extends admin_api {

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
			'/customize'						=> array('readable', 'customize'),
			'/customize/save'					=> array('creatable', 'customize_settings_save'),
			'/setting'							=> array('readable', 'setting'),
			'/settings/save'					=> array('creatable', 'customize_settings_save'),
			'/customize/navigation/duplicate'	=> array('creatable', 'duplicate_navigation'),
			'/customize/navigation/edit'		=> array('creatable', 'edit_navigation'),
			'/customize/menu/get'				=> array('readable', 'get_menu'),
			'/customize/menu/activate'			=> array('creatable', 'activate_menu'),
			'/customize/menu/add'				=> array('creatable', 'add_menu_item'),
			'/customize/menu/delete'			=> array('creatable', 'delete_menu_item'),
			'/customize/menu/save'				=> array('creatable', 'save_menu'),
		);

		// register routes
		semplice_register_route($namespace, $routes, $this);
	}

	// -----------------------------------------
	// endpoints
	// -----------------------------------------

	// get customize page
	public function customize($request) {
		// output array
		$output = array(
			'content' 	=> admin_api::$customize[$request['setting']]->output(),
			'css'		=> array(
				'advanced'	 => admin_api::$customize['advanced']->generate_css(false),
				'typography' => admin_api::$customize['typography']->get('css', true, true),
				'grid'		 => semplice_grid('editor'),
				'webfonts'	 => admin_api::$customize['webfonts']->generate_css(false),
			),
			'post_select' => array(
				'footer'  => semplice_get_post_dropdown('footer'),
				'project' => semplice_get_post_dropdown('project')
			),
		);

		// post select
		$post_select = array(
			
		);

		return new WP_REST_Response($output, 200);
	}

	// get setting page
	public function setting($request) {

		// output
		$output = array('settings', 'atts');

		// get settings
		if($request['setting'] == 'general') {
			$output['settings'] = semplice_get_general_settings();
		} else {
			$output['settings'] = json_decode(get_option('semplice_settings_' . $request['setting'])); 
		}

		// get atts
		require get_template_directory() . '/admin/atts/settings.php';
		$output['atts'] = $settings[$request['setting']];

		return new WP_REST_Response($output, 200);
	}

	// save customize settings
	public function customize_settings_save($request) {

		// setting
		$category = $request['category'];

		// get settings and add or remove slashes
		$settings = $this->check_slashes($request['settings']);

		// get setting type
		$settings_type = $request['settings_type'];

		$output = $category;
		
		// save settings in the DB
		update_option('semplice_' . $category . '_' . $settings_type, $settings);
		update_option('semplice_admin_images', $request['images']);
		update_option('semplice_custom_colors', $request['custom_colors']);

		// changed menu order?
		if(!empty($request['menu_order'])) {
			semplice_update_menu_order($request['menu_order']);
		}

		// change project slug
		$output = array(
			'slug'	  	   => 'project',
			'slug_changed' => 'no'
		);

		// save frontpages
		if($category == 'settings' && $settings_type == 'general') {
			// decode settings
			$settings = json_decode($settings, true);
			// defaults
			$homepage = array(
				'show_on_front'  	=> 'posts',
				'page_for_posts' 	=> 0,
				'page_on_front' 	=> 0,
			);
			if($settings['show_on_front'] != 'posts') {
				// set homepage type
				$homepage['show_on_front'] = 'page';
				// blog homepage
				if(isset($settings['page_for_posts'])) {
					$homepage['page_for_posts'] = $settings['page_for_posts'];
				}
				// pages homepage
				if(isset($settings['page_on_front'])) {
					$homepage['page_on_front'] = $settings['page_on_front'];
				}
			}
			// project slug
			if(isset($settings['project_slug']) && !empty($settings['project_slug'])) {
				$settings['project_slug'] = sanitize_title($settings['project_slug']);
				// is new slug?
				if(false === get_option('semplice_project_slug') && $settings['project_slug'] != 'project' || false !== get_option('semplice_project_slug') && get_option('semplice_project_slug') != $settings['project_slug'] && $settings['project_slug'] != 'project') {
					update_option('semplice_flush_rewrite', true);
					$output = array(
						'slug'	  	   => $settings['project_slug'],
						'slug_changed' => 'yes'
					);
				} else if($settings['project_slug'] != 'project') {
					$output = array(
						'slug'	  	   => $settings['project_slug'],
						'slug_changed' => 'no'
					);
				}
				// update slug
				update_option('semplice_project_slug', $settings['project_slug']);
			}
			// update homepage
			update_option('show_on_front', $homepage['show_on_front']);
			update_option('page_for_posts', $homepage['page_for_posts']);
			update_option('page_on_front', $homepage['page_on_front']);

			// site title
			if(isset($settings['site_title'])) {
				update_option('blogname ', $settings['site_title']);
			}

			// site tagline
			if(isset($settings['site_tagline'])) {
				update_option('blogdescription', $settings['site_tagline']);
			}
		}

		return new WP_REST_Response($output, 200);
	}

	// duplicate navigation
	public function duplicate_navigation($request) {

		$output = '
			<li id="' . $request['new_id'] . '" style="opacity: 0; transform: scale(.8);">
				<a class="navigation ' . $request['preset'] . $request['last_in_row'] . '" href="#customize/navigations/edit/' . $request['new_id'] . '">
					<img alt="preset-two bg" class="preset-bg-img" src="' . get_template_directory_uri() . '/assets/images/admin/navigation/' . $request['preset_url'] . '_full.png">
					<p>' . $request['name'] . '</p>
				</a>
				<div class="edit-nav-hover">
					<ul>
						<li>
							<a class="navigation-duplicate" href="#customize/navigations/edit/' . $request['new_id'] . '">' . get_svg('backend', '/icons/icon_edit') . '</a>
							<div class="tooltip tt-edit">Edit</div>
						</li>
						<li>
							<a class="navigation-remove admin-click-handler" data-handler="execute" data-action="duplicate" data-setting-type="navigations" data-action-type="customize" data-nav-id="' . $request['new_id'] . '">' . get_svg('backend', '/icons/post_duplicate') . '</a>
							<div class="tooltip tt-remove">Duplicate</div>
						</li>
						<li>
							<a class="navigation-duplicate admin-click-handler" data-handler="execute" data-action="removePopup" data-setting-type="navigations" data-action-type="customize" data-nav-id="' . $request['new_id'] . '">' . get_svg('backend', '/icons/icon_delete') . '</a>
							<div class="tooltip tt-duplicate">Remove</div>
						</li>
						<li>
							<a class="navbar-default" data-nav-id="' . $request['new_id'] . '">' . get_svg('backend', '/icons/save_checkmark') . '</a>
							<div class="tooltip tt-default">Default</div>
						</li>
					</ul>
				</div>
			</li>
		';
		
		return new WP_REST_Response($output, 200);
	}

	// edit navigation
	public function edit_navigation($request) {

		// vars
		$output = admin_api::$customize['navigations']->get('both', $request['content'], true, false);

		// return settings
		return new WP_REST_Response($output, 200);
	}

	// get menu html
	public function get_menu($request) {
		// output
		$output = '';
		$notices = '';
		$menu_html = '';
		$hide_menu = '';

		// get menu
		$menu_name = 'Semplice Menu';
		$menu_items = wp_get_nav_menu_items($menu_name);
		$menu_object = wp_get_nav_menu_object($menu_name);

		// craate new menu if it doesnt already exist
		if(is_array($menu_items)) {
			// get menu id
			$menu_id = $menu_object->term_id;
			// get menu localtions
			$locations = get_theme_mod('nav_menu_locations');
			// get menu id location
			$menu_id_location = $locations['semplice-main-menu'];
			// check if menu is in location semplice main menu
			if($menu_id != $menu_id_location) {
				$notices = '
					<p class="notice-heading">Menu not active</p>
					<div class="edit-menu-notice">
						<p class="no-menu">The Semplice menu is not active. In order to edit your menu please first activate it.</p>
						<div class="save-new-menu-item">
							<a class="admin-click-handler semplice-button" data-handler="execute" data-action-type="menu" data-action="activate">Activate Menu</a>
						</div>
					</div>
				';
				$hide_menu = ' hide';
			}
			// build nav
			foreach ($menu_items as $key => $item) {
				$classes = '';
				$url = '';
				$target_blank = '';

				// target
				if($item->target == '_blank') {
					$target_blank = 'selected';
				}

				// classes
				if(is_array($item->classes) && !empty($item->classes)) {
					foreach ($item->classes as $class) {
						$classes .= $class . ' ';
					}
				}
				// url
				$link_class = '';
				if($item->type == 'custom') {
					$url = '
						<div class="option">
							<div class="option-inner">
								<div class="attribute span4">
									<h4>Link</h4>
									<input type="text" name="link" class="item-link admin-listen-handler" data-handler="updateMenu" value="' . $item->url . '" placeholder="https://www.semplice.com">
								</div>
							</div>
						</div>
					';
					$link_class = ' is-custom-link';
				}
				$menu_html .= '
					<li class="ep-menu-item' . $link_class . '" data-ep-menu-item-id="' . $item->ID . '" data-type="' . $item->type . '">
						<div class="ep-menu-item-inner">
							<div class="ep-menu-item-meta ep-menu-item-expand">
								<div class="ep-menu-item-handle ui-sortable-handle"></div>
								<div class="title">
									<p>' . $item->title . '</p>
								</div>
								<div class="ep-meta-right">
									<div class="ep-menu-item-remove ep-posts-icon admin-click-handler" data-handler="execute" data-action-type="menu" data-action="remove" data-id="' . $item->ID . '"></div>
									<div class="ep-posts-icon ep-posts-expand-icon"></div>
								</div>
							</div>
							<div class="ep-menu-item-options">
								<div class="option">
									<div class="option-inner menu-item-title">
										<div class="attribute span4">
											<h4>Title</h4>
											<input type="text" name="menu_title" class="item-title admin-listen-handler" data-handler="menuItemTitle" value="' . $item->title . '" placeholder="Title" data-id="' . $item->ID . '">
										</div>
									</div>
								</div>
								<div class="option">
									<div class="option-inner">
										<div class="attribute span2">
											<h4>Target</h4>
											<div class="select-box">
												<div class="sb-arrow"></div>
												<select name="menu_target" class="menu-target admin-listen-handler" data-handler="updateMenu">
													<option value="_self">Same Tab</option>
													<option value="_blank" ' . $target_blank . '>New Tab</option>
												</select>
											</div>
										</div>
										<div class="attribute span4">
											<h4>Classes</h4>
											<input type="text" name="menu_classes" class="item-classes admin-listen-handler" data-handler="updateMenu" value="' . $classes . '" placeholder="Classes">
										</div>
									</div>
								</div>
								' . $url . '
							</div>
						</div>
					</li>
				';
			}
		} else {
			$notices = '
				<p class="notice-heading">No menu found</p>
				<div class="edit-menu-notice">
					<p class="no-menu">Looks like you don\'t have<br />a semplice menu yet.</p>
					<div class="save-new-menu-item">
						<a class="admin-click-handler semplice-button" data-handler="execute" data-action-type="menu" data-action="create">Create Menu</a>
					</div>
				</div>
			';
			$hide_menu = ' hide';
		}

		// get pages, posts, projects
		$post_types = array('page', 'project', 'post');
		// select posts array
		$select_posts = array(
			'page' => '',
			'project' => '',
			'post' => '',

		);
		// iterate post types
		foreach ($post_types as $post_type) {
			$args = array(
				'posts_per_page' => -1,
				'post_type' => $post_type,
				'post_status' => 'publish',
			);
			$posts = get_posts($args);
			// pages there?
			if(is_array($posts)) {
				foreach ($posts as $key => $post) {
					$select_posts[$post->post_type] .= '<option data-post-id="' . $post->ID . '" value="' . $post->post_title . '">' . $post->post_title . '</option>';					
				}
			}
		}

		// output nav
		$output = '
			<div class="edit-menu">
				<div class="menu-notices">
					' . $notices . '
				</div>
				<div class="edit-menu-inner' . $hide_menu . '">
					<div class="add-new-item">
						<a class="add-menu-item admin-click-handler semplice-button" data-handler="execute" data-action-type="menu" data-action="showAddItemDropdown">Add Menu Item</a>
					</div>
					<ul class="ep-menu-items-list">
						' . $menu_html . '
					</ul>
					<div class="ep-add-item-dropdown">
						<p class="notice-heading">Add new item</p>
						<label class="first-label">Link Type</label>
						<div class="select-box menu-type-select">
							<div class="sb-arrow"></div>
							<select name="new_menu_item_type" data-input-type="select-box" class="admin-listen-handler new-menu-item-type" data-handler="changeMenuType">
								<option value="page">Page</option>
								<option value="project">Project</option>
								<option value="post">Post</option>
								<option value="custom">Custom</option>
							</select>
						</div>
						<div class="menu-item-type" data-type="custom">
							<label>Title</label>
							<input type="text" name="new_menu_item_title" class="new-menu-item new-menu-item-title" placeholder="Title">
							<label>Link</label>
							<input type="text" name="new_menu_item_link" class="new-menu-item" placeholder="https://www.semplice.com">
						</div>
						<div class="menu-item-type" data-type="page">
							<label>Select page</label>
							<div class="select-box">
								<div class="sb-arrow"></div>
								<select name="new_menu_item_page" class="new-menu-item">
									' . $select_posts['page'] . '
								</select>
							</div>
						</div>
						<div class="menu-item-type" data-type="project">
							<label>Select project</label>
							<div class="select-box">
								<div class="sb-arrow"></div>
								<select name="new_menu_item_project" class="new-menu-item">
									' . $select_posts['project'] . '
								</select>
							</div>
						</div>
						<div class="menu-item-type" data-type="post">
							<label>Select post</label>
							<div class="select-box">
								<div class="sb-arrow"></div>
								<select name="new_menu_item_post" class="new-menu-item">
									' . $select_posts['post'] . '
								</select>
							</div>
						</div>
						<div class="save-new-menu-item">
							<a class="admin-click-handler cancel" data-handler="execute" data-action-type="menu" data-action="hideAddItemDropdown">Cancel</a>
							<a class="admin-click-handler semplice-button" data-handler="execute" data-action-type="menu" data-action="add">Add Item</a>
							<svg class="semplice-spinner" width="30px" height="30px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
								<circle class="path" fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
							</svg>
						</div>
					</div>
				</div>
			</div>
		';

		// output
		return new WP_REST_Response($output, 200);
	}

	// activate menu
	public function activate_menu($request) {

		// add menu item and get id
		semplice_activate_menu();

		return new WP_REST_Response('Activated', 200);
	}

	// add menu item
	public function add_menu_item($request) {

		// add menu item and get id
		$id = semplice_add_menu_item($request['item']);

		return new WP_REST_Response($id, 200);
	}

	// delete menu item
	public function delete_menu_item($request) {
		// cceck if post is there
		if (false !== get_post_status($request['id'])) {
			wp_delete_post($request['id'], true);
		}

		return new WP_REST_Response('Delete menu item ' . $request['id'], 200);
	}

	// save menu
	public function save_menu($request) {
		// changed menu order?
		$output = semplice_update_menu_order($request['menu_order']);

		return new WP_REST_Response($output, 200);
	}
}

// -----------------------------------------
// build instance of endpoints
// -----------------------------------------

$admin_api_customize = new admin_api_customize();

?>