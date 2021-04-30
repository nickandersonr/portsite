<?php

// -----------------------------------------
// semplice
// /rest_api.php
// -----------------------------------------

class frontend_api {

	// public vars
	public $db, $editor, $rev_table_name, $get_content, $module;

	public function __construct() {

		// call register routes on rest api init
		add_action('rest_api_init', array(&$this, 'register_routes'));
		
		// database
		global $wpdb;
		$this->db = $wpdb;
		$this->rev_table_name = $wpdb->prefix . 'semplice_revisions';

		// editor api
		global $editor_api;
		$this->editor = $editor_api;

		// get content class
		global $semplice_get_content;
		$this->get_content = $semplice_get_content;
	}

	// -----------------------------------------
	// rest routes
	// -----------------------------------------

	public function register_routes() {
		$version = '1';
		$namespace = 'semplice/v' . $version . '/frontend';

		// posts
		register_rest_route($namespace, '/posts', array(
			'methods'	=> WP_REST_Server::READABLE,
			'callback'	=> array($this, 'post'),
			'permission_callback' => '__return_true'
		));

		// single posts width ids
		register_rest_route($namespace, '/posts/(?P<id>\d+)', array(
			'methods'	=> WP_REST_Server::READABLE,
			'callback'	=> array($this, 'post'),
			'permission_callback' => '__return_true'
		));

		// not found
		register_rest_route($namespace, '/notfound', array(
			'methods'	=> WP_REST_Server::READABLE,
			'callback'	=> array($this, 'post'),
			'permission_callback' => '__return_true'
		));

		// lazy load
		register_rest_route($namespace, '/lazy-load/portfolio-grid', array(
			'methods'	=> WP_REST_Server::READABLE,
			'callback'	=> array($this, 'lazy_load_portfolio_grid'),
			'permission_callback' => '__return_true'
		));

		// get password protected post
		register_rest_route($namespace, '/post-password', array(
			'methods'	=> WP_REST_Server::READABLE,
			'callback'	=> array($this, 'post_password'),
			'permission_callback' => '__return_true'
		));
	}

	// -----------------------------------------
	// endpoints
	// -----------------------------------------

	// get a post for the frontend
	public function post($request) {
		// check if category
		if($request['taxonomy'] == 'category' || $request['taxonomy'] == 'post_tag') {
			// get category
			$term = get_term_by('slug', $request['term'], $request['taxonomy']);
			// is category?
			if($term) {
				// set id to category
				$id = $request['taxonomy'];
			} else {
				$id = 'notfound';
			}
		} else {
			// get post
			$post = get_post($request['id']);
			// format id
			$id = semplice_format_id($request['id'], false);
		}

		// has password?
		$has_password = false;
		if(post_password_required($id)) {
			$has_password = true;
		}
		
		// make array
		if(isset($post) && is_object($post)) {
			// output
			$output = $this->output($post->ID, $post->post_name, $post->post_title, $this->get_content->get($id, false, intval($request['page']), false, $request['script_execution']), $has_password, $post->post_type);
			// add post settings
			if($output['content']['is_semplice']) {
				$post_settings = json_decode(get_post_meta($post->ID, '_semplice_post_settings', true), true);
				if(null !== $post_settings) {
					$output['post_settings'] = $post_settings;
				}
			}
			// format title if yoast is defined
			$output['title'] = semplice_get_spa_title($output['title'], $id, $post);
		} else if($id == 'posts') {
			// default blog title
			$blog_title = get_bloginfo('name') . ' - ' . get_bloginfo('description');
			// blog has a page id?
			$blog_home = get_option('page_for_posts');
			if($blog_home > 0) {
				$post = get_post($blog_home);
				$blog_title = semplice_get_spa_title($post->post_title, $blog_home, $post);
			}
			// get blog overview
			$output = $this->output($id, '', $blog_title, $this->get_content->posts(false, intval($request['page'])), $has_password, 'posts');
		} else if($id == 'category' || $id == 'post_tag') {
			$output = $this->output($request['id'], '', $term->name . ' Archives - ' . get_bloginfo('description'), $this->get_content->posts($term, intval($request['page'])), $has_password, 'category');
		} else {
			// get 404 not found page
			$output = $this->output('notfound', '', '404 - Not found', $this->get_content->default_content('not-found'), $has_password, 'notfound');
		}

		// wrap sections
		if(isset($output['content']['html'])) {
			$output['content']['html'] = '<div class="transition-wrap"><div class="sections">' . $output['content']['html'] . '</div></div>';
		}
		
		return new WP_REST_Response($output, 200);
	}

	// lazy load for the portfolio grid
	public function lazy_load_portfolio_grid($request) {

		// output
		$output = array(
			'items'  => '',
			'css'	 => '',
			'fin' 	 => false, 
		);

		// get module
		require_once get_template_directory() . '/admin/editor/modules/portfoliogrid.php';

		// get options
		$options = json_decode($request['options'], true);

		// extract options
		extract( shortcode_atts(
			array(
				'categories'				=> '',
				'title_visibility'			=> 'both',
				'title_position'			=> 'below',
				'title_font'				=> 'regular',
				'category_font'				=> 'regular',
			), $options)
		);

		// get portfolio order
		$portfolio_order = json_decode(get_option('semplice_portfolio_order'));

		// categories
		$categories = explode(',', $categories);

		// get projects
		$projects = semplice_get_projects($portfolio_order, $categories, $request['load'], $request['offset'], false);

		// set status
		if(count($projects) < $request['load']) {
			$output['fin'] = true;
		}

		// get thumb hover options
		$global_hover_options = json_decode(get_option('semplice_customize_thumbhover'), true);

		// masonry items
		$masonry_items = '';

		// are there any published projects
		if(!empty($projects)) {

			// change title position to below if visibility is hidden
			if($title_visibility == 'hidden') {
				$title_position = 'below';
			}

			// get content
			$atts = array(
				'global_hover_options' => $global_hover_options,
				'title_visibility' => $title_visibility,
				'title_position' => $title_position,
				'category_font' => $category_font,
				'title_font' => $title_font,
			);

			foreach ($projects as $key => $project) {
				// get masonry items
				$output['items'] .= $this->module['portfoliogrid']->get_masonry_items($request['content_id'], $project, $atts, false, ' pg-lazy-load');
				// thumb hover css if custom thumb hover is set
				if(isset($project['thumb_hover'])) {
					$output['css'] .= semplice_thumb_hover_css('project-' . $project['post_id'], $project['thumb_hover'], false, '#content-holder', false);
				}
			}
		}

		// output
		return new WP_REST_Response($output, 200);
	}

	// get password protected post
	public function post_password($request) {
		// get post
		$post = get_post($request['id']);
		// password
		$password = $request['password'];
		// format id
		$id = semplice_format_id($request['id'], false);
		// check if post
		if(isset($post) && is_object($post)) {
			// check password
			if($post->post_password == $password) {
				$output = $this->get_content->get($id, false, 0, false, 'normal');
			} else {
				$output = 'wrong-password';
			}
		} else {
			$output = 'wrong-password';
		}
		return $output;
	}

	// generate output
	public function output($id, $name, $title, $content, $has_password, $post_type) {
		return array(
			'id'   			=> $id,
			'name' 			=> $name,
			'title' 		=> $title,
			'content'		=> $content,
			'has_password'  => $has_password,
			'post_type'		=> $post_type,
		);
	}
}

// -----------------------------------------
// build instance of frontend api
// -----------------------------------------

$frontend_api = new frontend_api();

?>