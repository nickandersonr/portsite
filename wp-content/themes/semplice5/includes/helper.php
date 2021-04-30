<?php

// -----------------------------------------
// semplice
// /includes/helper.php
// -----------------------------------------

// include helpers
$helpers = array('post_queries', 'images', 'videos', 'thumbnails', 'onboarding', 'grid', 'typography', 'navigation', 'sharebox', 'styles', 'covers', 'licensing', 'notices');

foreach ($helpers as $helper) {
	require get_template_directory() . '/includes/helper/' . $helper . '.php';
}

// -----------------------------------------
// show content
// -----------------------------------------

function semplice_show_content($id, $what) {

	// globals
	global $semplice_content;
	global $admin_api;

	// if password required show form instead of content (only on pages and projects)
	if($what != 'posts' && $what != 'taxonomy' && post_password_required()) {
		// get frontend mode
		$frontend_mode = semplice_get_mode('frontend_mode');
		// set spa
		$spa = false;
		// check if frontend mode is dynamic
		if($frontend_mode == 'dynamic') {
			$spa = true;
		}
		$semplice_content['html'] = get_the_password_form();
	}

	// echo content
	echo '
		<div id="content-holder" data-active-post="' . $id . '">
			' . admin_api::$customize['navigations']->get('html', false, false, false) . '
			<div id="content-' . $id . '" class="content-container active-content ' . semplice_hide_on_init($id) . '">
				<div class="transition-wrap">
					<div class="sections">
						' . $semplice_content['html'] . '
					</div>
				</div>
			</div>
		</div>
	';
}

// ----------------------------------------
// get template
// ----------------------------------------

function semplice_get_template($template, $atts) {
	// template dir
	$template = array(
		'parent' => get_template_directory() . '/partials/' . $template . '.php',
		'child'  => get_stylesheet_directory() . '/partials/' . $template . '.php',
	);
	// make sure the file exists
	if(!file_exists($template['child']) && !file_exists($template['parent'])) {
		return '';
	}
	// use template from child theme if avilable
	$type = 'parent';
	if(file_exists($template['child'])) {
		$type = 'child';
	}
	// extract atts
	if(is_array($atts)) {
		extract($atts);
	}
	// buffer output
	ob_start();
		include $template[$type];
	return ob_get_clean();
}

// -----------------------------------------
// generate ram ids
// -----------------------------------------

function semplice_generate_ram_ids($ram, $is_encoded, $is_block) {

	// is encoded?
	if($is_encoded) {
		// decode ram
		$ram = json_decode($ram, true);
	}

	// output
	$output = $ram;

	// images array
	$images = '';
	$image_modules = array('image', 'gallerygrid', 'video', 'gallery');

	// change ids
	foreach ($ram['order'] as $section_id => $section) {
		// is masterblock?
		if(isset($ram[$section_id]) && isset($ram[$section_id]['masterblock']) && strpos($ram[$section_id]['masterblock'], 'master_') !== false) {
			// isset?
			if(isset($ram[$section_id]) && $section_id != 'cover') {
				// get background image and add to images_array
				$images .= semplice_get_background_image($ram[$section_id]['styles']['xl']);
				// new section to iterate through
				$section_iterate = array();
				// delete masterblock from new order
				unset($output['order'][$section_id]);
				// add back masterblock to the order freshly (too keep correct order)
				$output['order'][$section_id] = $ram['order'][$section_id];
				// is old single row mode?
				if(isset($section['columns'])) {
					//move columns to a virtual row to make it compatible with the new multi row system
					$section_iterate['row_' . substr(md5(rand()), 0, 9)]['columns'] = $section['columns'];
				} else {
					$section_iterate = $section;
				}
				// iterate rows
				foreach($section_iterate as $row_id => $columns) {
					// iterate columns
					foreach ($columns['columns'] as $column_id => $column_content) {
						// get background image and add to images_array
						$images .= semplice_get_background_image($ram[$column_id]['styles']['xl']);
						foreach ($column_content as $content_id) {
							// get background image and add to images_array
							$images .= semplice_get_background_image($ram[$content_id]['styles']['xl']);
							// get all images used in module
							if(in_array($ram[$content_id]['module'], $image_modules)) {
								$images .= semplice_get_used_images($ram[$content_id]);
							}
						}
					}
				}
			}
		} else {
			// isset?
			if(isset($ram[$section_id]) && $section_id != 'cover') {
				// get background image and add to images_array
				$images .= semplice_get_background_image($ram[$section_id]['styles']['xl']);
				// create new seciton id
				$new_section_id = 'section_' . substr(md5(rand()), 0, 9);
				// add to array
				$output['order'][$new_section_id] = array();
				// add section content to the output
				$output[$new_section_id] = $ram[$section_id];
				// delete old id rom new ram
				unset($output[$section_id]);
				unset($output['order'][$section_id]);
				// new section to iterate through
				$section_iterate = array();
				// is old single row mode?
				if(isset($section['columns'])) {
					//move columns to a virtual row to make it compatible with the new multi row system
					$section_iterate['row_' . substr(md5(rand()), 0, 9)]['columns'] = $section['columns'];
				} else {
					$section_iterate = $section;
				}
				// iterate rows
				foreach($section_iterate as $row_id => $columns) {
					// new row id
					$new_row_id = 'row_' . substr(md5(rand()), 0, 9);
					// add row to ram
					$output['order'][$new_section_id][$new_row_id] = array(
						'columns' => array(),
					);
					// iterate columns
					foreach ($columns['columns'] as $column_id => $column_content) {
						// get background image and add to images_array
						$images .= semplice_get_background_image($ram[$column_id]['styles']['xl']);
						// create new id
						$new_column_id = 'column_' . substr(md5(rand()), 0, 9);
						// add content to array
						$output['order'][$new_section_id][$new_row_id]['columns'][$new_column_id] = array();
						// add section content to column
						$output[$new_column_id] = $ram[$column_id];
						// delete old id rom new ram
						unset($output[$column_id]);
						foreach ($column_content as $content_id) {
							// get background image and add to images_array
							$images .= semplice_get_background_image($ram[$content_id]['styles']['xl']);
							// get all images used in module
							if(in_array($ram[$content_id]['module'], $image_modules)) {
								$images .= semplice_get_used_images($ram[$content_id]);
							}
							// create new id
							$new_content_id = 'content_' . substr(md5(rand()), 0, 9);
							// add to array
							$output['order'][$new_section_id][$new_row_id]['columns'][$new_column_id][] = $new_content_id;
							// add section content to column
							$output[$new_content_id] = $ram[$content_id];
							// delete old id rom new ram
							unset($output[$content_id]);
						}
					}
				}
			}
		}
	}

	// add images to output if block
	if(true === $is_block) {
		// add images
		$output['images'] = semplice_blocks_image_array($images);
	}

	// return
	return $output;
}

function semplice_blocks_image_array($images) {
	// vars
	$images_arr = array();
	// check if images array is empty?
	if(!empty($images)) {
		// remove last , from string
		if(substr($images, -1) == ',') {
			$images = substr($images, 0, -1);
		}
		$images = explode(",", $images);
		// fetch all image urls in case they have chnaged (ex domain)
		foreach ($images as $image_id) {
			// get image
			$images_arr[$image_id] = semplice_get_image_object($image_id, 'full');
		}
	} else {
		$images_arr = 'noimages';
	}
	// return
	return $images_arr;
}

// -----------------------------------------
// get post settings
// -----------------------------------------

function semplice_generate_post_settings($settings, $post) {

	// check if row has page settings
	if(null !== $settings && is_array($settings)) {
		// always get the latest saved title and permalink to match wordpress
		$settings['meta']['post_title'] = $post->post_title;
		$settings['meta']['permalink'] = $post->post_name;
	} else {
		// define some post settings defaults
		$settings = array(
			'thumbnail' => array(
				'image' => '',
				'width'	=> '',
				'hover_visibility' => 'disabled',
			),
			'meta' => array(
				'post_title' 	=> $post->post_title,
				'permalink'  	=> $post->post_name,
			),
		);
	}

	// yoast seo settings
	$yoast = array('title', 'metadesc', 'opengraph-image', 'opengraph-title', 'opengraph-description', 'twitter-image', 'twitter-title', 'twitter-description', 'meta-robots-nofollow', 'meta-robots-noindex', 'canonical');
	$prefix = '_yoast_wpseo_';

	// get seo from db
	foreach ($yoast as $setting) {
		// get setting
		$setting = $prefix . $setting;
		// check if post meta is there
		$post_meta = get_post_meta($post->ID, $setting, true);
		if(!empty($post_meta)) {
			$settings['seo'][$setting] = get_post_meta($post->ID, $setting, true);
		} else {
			// is set still in semplice? delete it
			if(isset($settings['seo'][$setting])) {
				unset($settings['seo'][$setting]);
			}
		}
	}

	// still empty?
	if(!isset($settings['seo']) || empty($settings['seo'])) {
		$settings['seo'] = new stdClass();
	}
	
	return $settings;
}

// -----------------------------------------
// get single page app title
// -----------------------------------------

function semplice_get_spa_title($title, $id, $post) {
	if(function_exists('wpseo_replace_vars')) {
		// first of all get yoast seo title if there
		$seo_title = get_post_meta($id, '_yoast_wpseo_title', true);
		if(false !== $seo_title && strlen($seo_title) > 0) {
			$title = $seo_title;
		}
		$title = wpseo_replace_vars(semplice_yoast_page_title($id, $post), $post);
		$title = apply_filters('wpseo_title', $title);
	} else if(strpos($title, get_bloginfo('name')) === false) {
		$title = $title . ' - ' . get_bloginfo('name');
	}
	// return
	return $title;
}

// -----------------------------------------
// get yoast page title
// -----------------------------------------

function semplice_yoast_page_title($post_id, $post) {
	$fixed_title = WPSEO_Meta::get_value('title', $post_id);
	if ($fixed_title !== '') {
		return $fixed_title;
	}

	if (is_object($post) && WPSEO_Options::get('title-' . $post->post_type, '') !== '') {
		$title_template = WPSEO_Options::get( 'title-' . $post->post_type);
		$title_template = str_replace(' %%page%% ', ' ', $title_template);
		return wpseo_replace_vars($title_template, $post);
	}
	return wpseo_replace_vars('%%title%%', $post);
}

// -----------------------------------------
// save spinner
// -----------------------------------------

function semplice_save_spinner() {
	return '
		<div class="save-spinner">
			<div class="semplice-mini-loader">
				<svg class="semplice-spinner" width="20px" height="20px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
					<circle class="path" fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
				</svg>
				<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14">
					<path id="Form_1" data-name="Form 1" d="M6.679,13.758L0.494,7.224,1.878,5.762l4.8,5.072L16.153,0.825l1.384,1.462Z"/>
				</svg>
				<span class="saving">Saving...</span>
				<span class="saved">Saved</span>
			</div>
		</div>
	';
}

// -----------------------------------------
// ajax save button
// -----------------------------------------

function semplice_ajax_save_button($link) {
	return $link . '
			<svg class="semplice-spinner" width="20px" height="20px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
				<circle class="path" fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
			</svg>
			<svg class="ajax-save-checkmark" xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14">
				<path id="Form_1" data-name="Form 1" d="M6.679,13.758L0.494,7.224,1.878,5.762l4.8,5.072L16.153,0.825l1.384,1.462Z"/>
			</svg>
			<span class="save-button-text">Save</span>
		</a>
	';
}

// -----------------------------------------
// get the id we need
// -----------------------------------------

function semplice_get_id() {
	// get post id
	$post_id = get_the_ID();
	// format id
	$post_id = semplice_format_id($post_id, false);
	// return id
	return $post_id;
}

// -----------------------------------------
// format post id
// -----------------------------------------

function semplice_format_id($post_id, $is_crawler) {
	// get blog homepage id
	$blog_home = get_option('page_for_posts');
	// check if blog homepage is not set
	if($blog_home == 0) {
		$blog_home = 'posts';
	}
	// is blog home or not found?
	if(is_home() && !$is_crawler || $post_id == 'posts' || $post_id == $blog_home) {
		$post_id = 'posts';
	} else if(empty($post_id) || is_404()) {
		$post_id = 'notfound';
	}
	// return id
	return $post_id;
}

// -----------------------------------------
// set the init visibility of our content div
// -----------------------------------------

function semplice_hide_on_init($post_id) {

	// set hide on init
	$hide_on_init = ' hide-on-init';

	// mode defaults
	$frontend_mode = semplice_get_mode('frontend_mode');

	// only remove the hide on init status if sr is disabled and if the static transitions are disabled or the post is not found
	// if there is no scroll reveal on static frontend to fade in the content it will get faded in via GSAP but it will always be hide on init for static transitions to make sure there is a transition
	if(semplice_static_transitions($frontend_mode) == 'disabled') {
		if(semplice_get_sr_status() == 'disabled' || $post_id == 'notfound' || post_password_required()) {
			$hide_on_init = '';
		}
	} else if(true === post_password_required()) {
		$hide_on_init = '';
	}
	
	// output
	return $hide_on_init;
}

// -----------------------------------------
// semplice get post ids
// -----------------------------------------

function semplice_get_post_Ids() {

	// wpdb
	global $wpdb;

	// define post ids array
	$post_ids = array();

	// get posts
	$posts = $wpdb->get_results("SELECT ID, post_name FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' OR post_type = 'page' OR post_type = 'project'");

	// iterate posts
	foreach ($posts as $post) {
		$post_ids[$post->post_name] = $post->ID;
	}

	// return
	return $post_ids;
}

// -----------------------------------------
// get scroll reveal status on first post
// -----------------------------------------

function semplice_get_sr_status() {

	// vars
	global $post;
	$sr_status = 'enabled';

	// get content
	if(is_object($post)) {
		
		// format post id
		$post_id = semplice_format_id($post->ID, false);

		// instance of get smeplice content
		$semplice_get_content = new semplice_get_content;

		// get content
		$ram = $semplice_get_content->get_ram($post->ID, is_preview());

		// is semplice
		$is_semplice = get_post_meta($post->ID, '_is_semplice', true);

		// check sr status
		if($post_id == 'posts' || $post->post_type == 'post') {
			// is array?
			$sr_status = semplice_get_blog_sr_status();
		} else if(isset($ram['branding']['scroll_reveal']) && $ram['branding']['scroll_reveal'] == 'disabled' || $post_id == 'notfound' || !$is_semplice) {
			$sr_status = 'disabled';
		}
	}

	// return
	return $sr_status;
}

// -----------------------------------------
// get blog sr mode
// -----------------------------------------

function semplice_get_blog_sr_status() {

	// get options
	$blog_options = json_decode(get_option('semplice_customize_blog'), true);

	// status
	$status = 'enabled';

	// set blog sr status individually
	if(is_array($blog_options)) {
		if(isset($blog_options['blog_scroll_reveal']) && $blog_options['blog_scroll_reveal'] == 'disabled') {
			$status = 'disabled';
		}
	}

	// return
	return $status;
}

// -----------------------------------------
// get mode
// -----------------------------------------

function semplice_get_mode($mode) {

	// frontend settings
	$settings = semplice_settings('general');

	// defaults
	$defaults = array(
		'frontend_mode' 	=> 'static',
	);

	// check if mode option in the admin is already set
	if(semplice_rest_url() == 'no-rest-api') {
		return 'static';
	} if(isset($settings) && isset($settings[$mode])) {
		return $settings[$mode];
	} else {
		return $defaults[$mode];
	}
}

// -----------------------------------------
// get breakpoints
// -----------------------------------------

function semplice_get_breakpoints() {
	return array(
		'lg' => array(
			'min' => ' and (min-width: 992px)',
			'max' => ' and (max-width: 1169.98px)'
		),
		'md' => array(
			'min' => ' and (min-width: 768px)',
			'max' => ' and (max-width: 991.98px)',
		),
		'sm' => array(
			'min' => ' and (min-width: 544px)',
			'max' => ' and (max-width: 767.98px)',
		),
		'xs' => array(
			'min' => '',
			'max' => ' and (max-width: 543.98px)',
		),
	);
}

// -----------------------------------------
// static transitions
// -----------------------------------------

function semplice_static_transitions($mode) {

	// frontend settings
	$settings = semplice_settings('general');

	// check if mode option in the admin is already set
	if($mode == 'static') {
		if(isset($settings['static_transitions']) && $settings['static_transitions'] == 'disabled') {
			return 'disabled';
		} else {
			return 'enabled';
		}
	} else {
		return 'disabled';
	}
}

// -----------------------------------------
// get modules
// -----------------------------------------

function semplice_get_modules() {

	// modules
	$modules = array(
		'paragraph'				=> 'Paragraph<br />(Legacy)',
		'oembed' 				=> 'oEmbed',
		'portfoliogrid' 		=> 'Portfolio Grid',
		'singleproject'			=> 'Single Project',
		'advancedportfoliogrid' => 'Advanced<br />Portfolio Grid',
		'share'					=> 'Share',
		'socialprofiles'		=> 'Social Profiles',
		'code'					=> 'Code',
		'dribbble'				=> 'Dribbble',
		'instagram'				=> 'Instagram',
		'gallerygrid'   		=> 'Gallery Grid',
		'mailchimp'				=> 'Mailchimp',
		'beforeafter'			=> 'Before After',
		'lottie'				=> 'Lottie'
	);

	// studio modules
	$studio_modules = array('advancedportfoliogrid', 'instagram', 'gallerygrid', 'mailchimp', 'beforeafter');

	// list
	$list = '';

	foreach ($modules as $module => $content) {
		// add specific classes
		$classes = '';
		if($module == 'advancedportfoliogrid') {
			$classes = ' add-section-module section-only';
		}
		// add to list
		if(semplice_theme('edition') == 'single' && in_array($module, $studio_modules)) {
			$list .= '<li><a class="add-content-single admin-click-handler" data-module="' . $module . '" data-handler="execute" data-action="studioFeatures" data-action-type="popup" data-feature="' . $module . '"><span class="icon">' . get_svg('backend', 'icons/module_' . $module) . '</span><span>' . $content . '</span><i>Studio Edition</i></a></li>';
		} else {
			$list .= '<li><a class="add-content add-module' . $classes . '" data-module="' . $module . '"><span class="icon">' . get_svg('backend', 'icons/module_' . $module) . '</span><span>' . $content . '</span></a></li>';
		}
	}

	// output list
	return '
		<h4>Add Content with</br>our custom modules.</h4>
		<div class="modules">
			<ul class="modules-list">
				' . $list . '
			</ul>
		</div>
	';
}

// -----------------------------------------
// check wp version requirement
// -----------------------------------------

function semplice_wp_version_is($method, $version) {
	// get wp version
	global $wp_version;
	// version compare
	if(version_compare($wp_version, $version, $method)) {
		return true;
	} else {
		return false;
	}
}

// -----------------------------------------
// get rest api url
// -----------------------------------------

function semplice_rest_url() {
	// get rest url
	if(function_exists('rest_url')) {
		return rest_url();
	} else {
		return 'no-rest-api';
	}
}

// -----------------------------------------
// check if value is boolean
// -----------------------------------------

function semplice_boolval($val) {
	return filter_var($val, FILTER_VALIDATE_BOOLEAN);
}

// -----------------------------------------
// semplice head
// -----------------------------------------

function semplice_head($settings) {

	// define output
	$output = '';

	// settings?
	if(is_array($settings)) {
		// google analytics
		if(isset($settings['google_analytics']) && !empty($settings['google_analytics'])) {
			// is script?
			if (strpos($settings['google_analytics'], '<script') !== false) {
				$output .= $settings['google_analytics'];
			}
		}
		// favicon
		if(isset($settings['favicon']) && !empty($settings['favicon'])) {
			// get image url
			$favicon = wp_get_attachment_image_src($settings['favicon'], 'full', false);
			if($favicon) {
				$output .= '<link rel="shortcut icon" type="image/png" href="' . $favicon[0] . '" sizes="32x32">';
			}
		}
		// head
		if(isset($settings['head_code']) && !empty($settings['head_code'])) {
			$output .= $settings['head_code'];
		}
	}

	// output
	return $output;
}

// -----------------------------------------
// get category base
// ----------------------------------------

function semplice_get_category_base() {
	// category base
	global $wp_rewrite;
	$category_base = str_replace('%category%', '', $wp_rewrite->get_category_permastruct());
	// return
	return $category_base;
}

// ----------------------------------------
// get tag base
// ----------------------------------------

function semplice_get_tag_base() {
	// category base
	global $wp_rewrite;
	$tag_base = str_replace('%post_tag%', '', $wp_rewrite->get_tag_permastruct());
	// return
	return $tag_base;
}

// ----------------------------------------
// get project slug
// ----------------------------------------

function semplice_get_project_slug() {
	if(false !== get_option('semplice_project_slug')) {
		return get_option('semplice_project_slug');
	} else {
		return 'project';
	}
}

// ----------------------------------------
// get general settings
// ----------------------------------------

function semplice_get_general_settings() {
	// get general settings and add homepage settings
	$settings = json_decode(get_option('semplice_settings_general'), true);
	// add homepage settings from WP
	$settings['show_on_front'] = get_option('show_on_front');
	$settings['page_on_front']  = get_option('page_on_front');
	$settings['page_for_posts'] = get_option('page_for_posts ');
	// site meta
	$settings['site_title'] = get_option('blogname');
	$settings['site_tagline'] = get_option('blogdescription');
	// project slug
	if(false !== get_option('semplice_project_slug')) {
		$settings['project_slug'] = get_option('semplice_project_slug');
	}
	// return
	return $settings;
}

// ----------------------------------------
// semplice about
// ----------------------------------------

function semplice_about() {

	// get currect license
	$license = semplice_get_license();

	// define licenses
	$licenses = array(
		's5-single'				=> 'Single',
		's5-studio'				=> 'Studio',
		's5-single-to-studio'	=> 'Studio',
		's5-business'			=> 'Business',
		's5-single-to-business'	=> 'Business',
		's5-studio-to-business'	=> 'Business',
		'subscription'			=> 'Semplice club',
	);

	// license
	$about = array(
		'registered-to' => 'Unregistered',
		'license-type'  => 'Inactive'
	);

	if(false !== $license && $license['is_valid'] && isset($licenses[$license['product']])) {
		$about['registered-to'] = $license['name'];
		$about['license-type'] = $licenses[$license['product']] . ' License';
	}

	return '
		<p class="first">
			Semplice ' . ucfirst(semplice_theme('edition')) . ' ' . semplice_theme('version') . '<br />
		</p>
		<p class="about-update">
			<span class="title">Latest Version</span><br />
			<span class="new-version">5.0</span>
			<a class="semplice-button" href="' . admin_url('themes.php') . '">Update</a>
		</p>
		<p class="about-uptodate">
			<span class="about-update-icon">' . get_svg('backend', '/icons/dashboard_uptodate') . '</span>
			You\'re up to date
		</p>
		<p class="about-notactivated">
			<span class="about-update-icon">' . get_svg('backend', '/icons/popup_important') . '</span>
			Not Activated
		</p>
		<p>
			<span class="title">Owner</span><br />
			' . $about['registered-to'] . '
		</p>
	';
}

// ----------------------------------------
// semplice get mobile css
// ----------------------------------------

function semplice_get_css($selector, $attribute, $css_attributes, $values, $filters, $negative, $output) {
	// prefix
	$prefix = '';
	if(true === $negative) {
		$prefix = '-';
	}
	// transform
	$transform = array('translateY', 'translateX', 'scale', 'move', 'rotate');
	// css for xl breakpoint
	if(isset($values[$attribute]) && !empty($values[$attribute])) {
		foreach ($css_attributes as $css_attribute) {
			if(in_array($css_attribute, $transform)) {
				$output['css'] .= $selector . ' { transform: ' . $css_attribute . '(' . $prefix . semplice_get_value($values[$attribute], $filters) . '); }';
			} else {
				$output['css'] .= $selector . ' { ' . $css_attribute . ': ' . $prefix . semplice_get_value($values[$attribute], $filters) . '; }';
			}
		}
	}
	// get breakpoints
	$breakpoints = semplice_get_breakpoints();
	// iterate breakpoints
	foreach ($breakpoints as $breakpoint => $width) {
		if(isset($values[$attribute . '_' . $breakpoint]) && !empty($values[$attribute . '_' . $breakpoint])) {
			foreach ($css_attributes as $css_attribute) {
				if(in_array($css_attribute, $transform)) {
					$output['mobile_css'][$breakpoint] .= $selector . ' { transform: ' . $css_attribute . '(' . $prefix . semplice_get_value($values[$attribute . '_' . $breakpoint], $filters) . '); }';
				} else {
					$output['mobile_css'][$breakpoint] .= $selector . ' { ' . $css_attribute . ': ' . $prefix . semplice_get_value($values[$attribute . '_' . $breakpoint], $filters) . '; }';
				}
			}
			
		}
	}
	// return
	return $output;
}

// ----------------------------------------
// get semplice value
// ----------------------------------------

function semplice_get_value($value, $filters) {
	// apply filters
	if(false !== $filters) {
		foreach ($filters as $filter) {
			switch($filter) {
				case 'rem-split':
					$value = floatval(str_replace('rem', '', $value));
					$value = ($value / 2) . 'rem';
				break;
				case 'hamburger-area':
					$value_in_px = floatval(str_replace('rem', '', $value) * 18);
					if($value_in_px <= 20) {
						$value = ($value_in_px / 18) . 'rem';
					} else {
						$value = (20 / 18) . 'rem';
					}
				break;
				case 'hamburger-hover':
					$value = $value + 2;
				break;
				case 'add-px':
					$value = $value . 'px';
				break;
				case 'divide-half':
					$value = $value / 2;
				break;
			}
		}
	}
	// return
	return $value;
}

// ----------------------------------------
// get hamburger height
// ----------------------------------------

function semplice_get_hamburger_height($navigation) {
	// desktop height
	$navigation['hamburger_height'] = $navigation['hamburger_thickness'] + ($navigation['hamburger_padding'] * 2);
	// get breakpoints
	$breakpoints = semplice_get_breakpoints();
	// iterate breakpoints
	foreach ($breakpoints as $breakpoint => $width) {
		// hamburger thickness
		$hamburger_thickness = $navigation['hamburger_thickness'];
		if(isset($navigation['hamburger_thickness_' . $breakpoint]) && !empty($navigation['hamburger_thickness_' . $breakpoint])) {

			$hamburger_thickness = $navigation['hamburger_thickness_' . $breakpoint];
		}
		// hamburger padding
		$hamburger_padding = $navigation['hamburger_padding'];
		if(isset($navigation['hamburger_padding_' . $breakpoint]) && !empty($navigation['hamburger_padding_' . $breakpoint])) {
			$hamburger_padding = $navigation['hamburger_padding_' . $breakpoint];
		}
		// hamburger height
		$navigation['hamburger_height_' . $breakpoint] = $hamburger_thickness + ($hamburger_padding * 2);
	}

	return $navigation;
}

// ----------------------------------------
// get blog navbar
// ----------------------------------------

function semplice_get_blog_navbar() {
	// define
	$navbar = false;
	// blog customization
	$blog = json_decode(get_option('semplice_customize_blog'), true);
	// check nav
	if(isset($blog['blog_navbar']) && !empty($blog['blog_navbar']) && $blog['blog_navbar'] !== 'default') {
		$navbar = $blog['blog_navbar'];
	}
	return $navbar;
}

// ----------------------------------------
// get sort by
// ----------------------------------------

function semplice_get_sortby() {
	// get sortby
	$sortby = get_option('semplice_sortby');
	// has value?
	if(false !== $sortby) {
		return $sortby;
	} else {
		return 'date';
	}
}

// ----------------------------------------
// get pinned
// ----------------------------------------

function semplice_get_pinned() {
	// default
	$posts = false;
	// get pinned
	$pinned = json_decode(get_option('semplice_pinned'), true);
	// has value?
	if(null !== $pinned && is_array($pinned) && !empty($pinned)) {
		$posts = $pinned;
	} else if(null === $pinned) {
		// pin home
		$home = get_option('page_on_front');
		if($home != 0) {
			$posts = array($home);
			update_option('semplice_pinned', json_encode($posts));
		}
	}
	// return
	return $posts;
}

// ----------------------------------------
// projects view
// ----------------------------------------

function semplice_get_projects_view() {
	// get sortby
	$projects_view = get_option('semplice_projects_view');
	// has value?
	if(false !== $projects_view) {
		return $projects_view;
	} else {
		return 'thumb';
	}
}

// ----------------------------------------
// get a basic dropdown
// ----------------------------------------

function semplice_get_dropdown($atts, $selected) {
	// output
	$output = '';
	foreach ($atts as $attribute => $name) {
		// selected
		$sel_class = '';
		if($attribute == $selected) {
			$sel_class = ' selected';
		}
		// add option to output
		$output .= '<option value="' . $attribute . '"' . $sel_class . '>' . $name . '</option>';
	}
	// ret
	return $output;
}

// ----------------------------------------
// get the transitions preloader
// ----------------------------------------

function semplice_get_transitions_preloader() {

	// get trasnition settings
	$transitions = json_decode(get_option('semplice_customize_transitions'), true);

	// loader image
	$loader_image = '';
	if(isset($transitions['loader_image']) && is_numeric($transitions['loader_image'])) {
		// get image object
		$loader_image = wp_get_attachment_image_src($transitions['loader_image'], 'full', false);
		// url
		$loader_image = '<img src="' . $loader_image[0] . '">';
	}

	// output
	return '
		<div class="transitions-preloader">
			<div class="loader-image">' . $loader_image . '</div>
		</div>
	';
}

// ----------------------------------------
// get media library folders
// ----------------------------------------

function semplice_sml_get_folders($folder_id) {
	// active default
	$active_default = ' active-folder';
	// define custom folders
	$custom_folders = '';
	// get folders
	$folders = get_terms(array('taxonomy' => 'semplice_folder', 'hide_empty' => 0));
	// is array?
	if(is_array($folders) && !empty($folders)) {
		foreach ($folders as $folder) {
			// active folder
			$active_folder = '';
			if($folder_id == $folder->term_id) {
				$active_folder = ' active-folder';
				$active_default = '';
			}
			// title
			$edited_name = $folder->name;
			if(strlen($edited_name) > 20) {
				$edited_name = substr($folder->name, 0, 20) . '...';
			}
			// folders html
			$custom_folders .= '
				<li class="sml-folder' . $active_folder . '" data-folder-id="' . $folder->term_id . '">' . $edited_name . '
					<div class="folder-options">
						<a class="rename-folder admin-click-handler" data-handler="execute" data-action-type="popup" data-action="smlRenameFolder" data-folder-id="' . $folder->term_id . '" data-folder-name="' . $folder->name . '"></a>
						<a class="remove-folder admin-click-handler" data-handler="execute" data-action-type="popup" data-action="smlDeleteFolder" data-folder-id="' . $folder->term_id . '"></a>
					</div>
				</li>
			';
		}
	}
	// folders
	return '
		<div class="sml-folders">
			<div class="sml-folders-header">
				<h4>My Folders</h4>
			</div>
			<ul>
				<li class="sml-folder' . $active_default . '" data-folder-id="uncategorized">Unsorted</li>
				' . $custom_folders . '
			</ul>
			<div class="add-sml-folder admin-click-handler" data-handler="execute" data-action-type="popup" data-action="smlAddFolder"></div>
		</div>
	';
}

// ----------------------------------------
// semplice get sml attachment
// ----------------------------------------

function semplice_sml_get_attachment($attachment) {
	// defaults
	$ratio = 'landscape';
	$title = '';
	$thumbnail = '';
	$classes = '';
	$sizes = array(0 => 0, 1 => 0, 2 => 0);
	// get attachment url
	$attachment_url = wp_get_attachment_url($attachment->ID);
	// image attachment
	if(strpos($attachment->post_mime_type, 'image') !== false) {
		// ratio
		$ratio = 'landscape';
		$sizes = wp_get_attachment_image_src($attachment->ID, 'full', false);
		if($sizes[2] > $sizes[1]) {
			$ratio = 'portrait';
		}
		// thumbnail
		$thumbnail = '<img src="' . $attachment_url . '" onerror="this.onerror=null; this.src=\'' . get_template_directory_uri() . '/assets/images/admin/missing_image_' . semplice_get_backend_style() . '.png\'">';
		// add class
		$classes = 'sml-image';
	} else {
		// title
		$title = substr($attachment_url, strrpos($attachment_url, '/') + 1);
		// short version
		if(strlen($title) > 12) {
			$title = '...' . substr($title, -12);
		}
		// get title
		$title = '<div class="sml-title">' . $title . '</div>';
		// add class
		$classes = 'sml-non-image';
	}
	// add to output
	return '
		<div id="attachment-' . $attachment->ID . '" class="sml-attachment" data-attachment-mime="' . $attachment->post_mime_type . '" data-attachment-id="' . $attachment->ID. '" data-attachment-url="' . $attachment_url . '" data-attachment-width="' . $sizes[1] . '" data-attachment-height="' . $sizes[2] . '">
			<div class="sml-attachment-inner">
				<div class="sml-thumbnail ' . $classes . ' ' . $ratio . '" data-mime-type="' . $attachment->post_mime_type . '">
					<div class="centered">
						' . $thumbnail . '
					</div>
					' . $title . '
					<div class="sml-meta"><a class="sml-show-meta admin-click-handler" data-handler="execute" data-action-type="mediaLibrary" data-action="getMeta" data-attachment-id="' . $attachment->ID . '"></a></div>
				</div>
			</div>
		</div>
	';
}

// ----------------------------------------
// semplice register route
// ----------------------------------------

function semplice_register_route($namespace, $routes, $_this) {
	// rest method
	$rest_method = array(
		'readable'  => WP_REST_Server::READABLE,
		'creatable' => WP_REST_Server::CREATABLE,
	);
	// register endpoints
	foreach ($routes as $route => $options) {
		register_rest_route($namespace, $route, array(
			'methods' => $rest_method[$options[0]],
			'permission_callback' => array($_this, 'auth_user'),
			'callback' => array($_this, $options[1]),
		));
	}
}

// ----------------------------------------
// module placeholders
// ----------------------------------------

function semplice_module_placeholder($module, $description, $has_upload, $is_editor) {

	// vars
	$dropzone = '';
	$upload = '';
	$dribbble_connect = '';
	$instagram_connect = '';

	// prefix
	$prefix = 'mp_title_';
	if(false === $is_editor) {
		$prefix = 'mp_frontend_';
	}

	// media type
	$media_type = array(
		'image' 		=> 'image',
		'gallery' 		=> 'gallery',
		'gallerygrid' 	=> 'gallery',
		'video'			=> 'video',
		'oembed'		=> '',
		'portfoliogrid' => '',
		'singleproject' => '',
		'dribbble'		=> '',
		'instagram'		=> '',
		'code'			=> '',
		'beforeafter'	=> '',
		'lottie'		=> '',
	);

	// basic upload atts
	$upload_atts = array(
		'data-media-type' 	=> $media_type[$module],
		'data-module'		=> $module,
	);

	// gallery vs image
	if($module == 'gallery' || $module == 'gallerygrid') {
		$upload_atts['name'] = 'images';
	} else if($module == 'image') {
		$upload_atts['name'] = 'image';
		$upload_atts['data-upload'] = 'contentImage';
	}

	// iterate upload atts
	$upload_atts_html = '';
	foreach ($upload_atts as $name => $value) {
		$upload_atts_html .= ' ' . $name . '="' . $value . '"';
	}

	// description
	if(false !== $description) {
		$description = '<div class="mp-description"><p>' . $description . '</p></div>';
	} else {
		$description = '';
	}

	// dribbble? show connect button
	if($module == 'dribbble' && true === $is_editor) {
		$dribbble_connect = '<div class="mp-connect"><a class="oauth-connect semplice-button green-button" href="https://dribbble.com/oauth/authorize?client_id=1a12455a58abacba654732e07477faf1fe78d2990049fb9feabe2fd63550e93c&redirect_uri=http://redirect.semplice.com/?uri=' . admin_url('admin.php?page=semplice-admin-dribbble-auth') . '" target="_blank">Connect Dribbble</a></div>';
	}

	if($module == 'instagram' && true === $is_editor) {
		$instagram_connect = '<div class="mp-connect"><a href="https://api.instagram.com/oauth/authorize?app_id=1171348673061941&response_type=code&scope=user_profile,user_media&redirect_uri=https://re.semplice.com/&state=' . admin_url('admin.php?page=semplice-admin-instagram-auth') . '"  class="connect-instagram semplice-button green-button oauth-connect" target="_blank">Connect Instagram</a></div>';
	}

	// has upload?
	if(true === $has_upload) {
		// add dropzone class
		$dropzone = ' mp-dropzone';
		// upload
		$upload = '
			<div class="mp-upload">
				<a data-handler="execute" class="upload-button admin-click-handler" data-action="init" data-action-type="mediaLibrary" data-mode="content" data-content-id="" data-is-content="true" data-ep-visibility="hidden"' . $upload_atts_html . '>
					<div class="mp-upload-icon">' . get_svg('backend', 'icons/mp_upload') . '</div>
					<span class="wide">or add from media library</span><span class="narrow">Library</span>
				</a>
			</div>
			<div class="mp-upload-status">
				<div class="mp-loader">
					<svg class="semplice-spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
						<circle class="path" fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
					</svg>
				</div>
				<span>Uploading file 1 of 3</span>
			</div>
		';
	}

	return '
		<div class="module-placeholder is-content' . $dropzone . '" data-placeholder="' . $module . '">
			<div class="mp-inner">
				<div class="mp-icon">
					' . get_svg('backend', 'icons/module_' . $module) . '
				</div>
				<div class="mp-title">
					' . get_svg('backend', 'placeholders/' . $prefix . $module) . '
				</div>
				' . $description . '
				' . $upload . '
				' . $dribbble_connect . '
				' . $instagram_connect . '
			</div>
		</div>
	';
}

// ----------------------------------------
// get before after content
// ----------------------------------------

function semplice_get_ba_content($id, $state, $image) {
	// default if there are no images
	$default = '
		<div class="semplice-' . $state . ' semplice-' . $state . '-wrapper semplice-' . $state . '-empty">
			<div class="ba-inner">
				<div class="title">' . get_svg('backend', 'placeholders/beforeafter_title_' . $state) . '</div>
				<div class="mp-upload">
					<a data-handler="execute" class="upload-button admin-click-handler" data-action="init" data-action-type="mediaLibrary" data-mode="content" data-content-id="' . $id . '" data-ep-visibility="hidden" data-media-type="image" data-module="beforeafter" name="' . $state . '" data-upload="beforeAfter">
						<div class="mp-upload-icon">
							<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
								<circle cx="9" cy="9" r="8.5" stroke="black"></circle>
								<line x1="4" y1="8.5" x2="14" y2="8.5" stroke="black"></line>
								<line x1="9" y1="13.5" x2="9" y2="3.5" stroke="black"></line>
							</svg>
						</div>
						<span class="wide">add from media library</span><span class="narrow">Library</span>
					</a>
				</div>
			</div>
		</div>
	';
	if(false !== $image && !empty($image)) {
		// get image
		$image = wp_get_attachment_image_src($image, 'full', false);
		// is image?
		if(false === $image) {
			return $default;
		} else {
			return '<div class="semplice-' . $state . '-wrapper"><img class="semplice-' . $state . '" src="' . $image[0] . '" width="' . $image[1] . '" height="' . $image[2] . '" /></div>';
		}		
	} else {
		// default
		return $default;
	}
}

// ----------------------------------------
// get maxium upload size in bytes
// ----------------------------------------

function semplice_get_max_upload_size() {
	$val = trim(ini_get('upload_max_filesize'));
	if (is_numeric($val))
		return $val;
	$last = strtolower($val[strlen($val)-1]);
	$val  = substr($val, 0, -1);
	switch($last) {
		case 'g':
		$val *= 1024;
		case 'm':
		$val *= 1024;
		case 'k':
		$val *= 1024;
	}
	return $val;
}

// ----------------------------------------
// get studio popup
// ----------------------------------------

function semplice_studio_popup($feature, $title, $description) {

	// links
	$links = array(
		'blocks' 				=> 'https://www.semplice.com/blocks',
		'gallerygrid'			=> 'https://www.semplice.com/project/gallery-module',
		'advancedportfoliogrid' => 'https://www.semplice.com/advanced-portfolio-grid',
		'instagram' 			=> 'https://www.semplice.com/project/instagram-module',
		'mailchimp'				=> 'https://www.semplice.com/mailchimp-module',
		'navigations'			=> 'https://www.semplice.com',
		'beforeafter'			=> 'https://www.semplice.com/before-after',
	);

	$see_it_live = '';
	if($feature != 'navigations') {
		$see_it_live = '<a href="' . $links[$feature] . '" target="_blank">See it live</a>';
	}

	echo '
		<div id="studio-feature-' . $feature . '" class="popup studio-popup">
			<div class="popup-close-feature admin-click-handler" data-handler="hidePopup">
				' . get_svg('backend', '/icons/feature_popup_close') . '
			</div>
			<div class="popup-inner feature-popup-inner">
				<div class="popup-header">
					' . semplice_get_feature_gallery($feature) . '
				</div>
				<div class="popup-content">
					<div class="studio-edition">Studio Edition</div>
					<h2>' . $title . '</h2>
					<p>' . $description . '</p>
				</div>
				<div class="popup-footer">
					' . $see_it_live . '
					<a href="https://transactions.sendowl.com/products/78141125/751C7D69/add_to_cart" class="feature-purchase">Upgrade to Studio for $39</a>
				</div>					
			</div>
		</div>
	';
}

// ----------------------------------------
// get gallery for studio popup
// ----------------------------------------

function semplice_get_feature_gallery($feature) {

	// features
	$features = array(
		'gallerygrid' 			=> 3,
		'advancedportfoliogrid' => 2,
		'instagram'				=> 3,
		'mailchimp'				=> 1,
		'blocks'				=> 2,
		'navigations'			=> 2,
		'beforeafter'			=> 2,
	);

	// open output
	$output = '<div id="feature-gallery-' . $feature . '" class="is-content semplice-gallery-slider sgs-slide pagination-above sgs-pagination-true">';

	// create items
	for ($i=1; $i <= $features[$feature]; $i++) {
		$output .= '
			<div class="sgs-slide">
				<img src="https://assets.semplice.com/studio/' . $feature . '_' . $i . '.jpg" alt="' . $feature . '-feature-' . $i . '" />
			</div>
		';
	}
	
	// close html output
	$output .= '</div>';

	// return
	return $output;
}

// ----------------------------------------
// get module svgs for the ep switch
// ----------------------------------------

function semplice_get_module_svgs() {
	// output
	$output = '';

	// modules
	$modules = array('paragraph', 'text', 'image', 'gallery', 'video', 'spacer', 'button', 'oembed', 'portfoliogrid', 'singleproject', 'advancedportfoliogrid', 'code', 'share', 'socialprofiles', 'dribbble', 'instagram', 'gallerygrid', 'mailchimp', 'beforeafter', 'lottie');

	// iterate
	foreach ($modules as $module) {
		$output .= '<span class="ep-switch-icon ep-switch-' . $module . '">' . get_svg('backend', 'icons/ep_switch_' . $module) . '</span>';
	}

	// return
	return $output;
}

// ----------------------------------------
// get backend style
// ----------------------------------------

function semplice_get_backend_style() {
	// backkend style
	$style = get_option('semplice_backend_style');
	// has value?
	if(false !== $style) {
		return $style;
	} else {
		return 'bright';
	}
}

// ----------------------------------------
// get allowed mime types
// ----------------------------------------

function semplice_get_allowed_mime_types() {
	// output
	$output = array();
	// get allowed mime types
	$mimes = get_allowed_mime_types();
	// iterate
	foreach ($mimes as $ext => $type) {
		if (strpos($ext, '|') !== false) {
			$multi = explode("|", $ext);
			foreach ($multi as $multi_ext) {
				$output[] = $multi_ext; 
			}
		} else {
			$output[] = $ext;
		}
	}
	// ret
	return $output;
}

// ----------------------------------------
// get inter webfont
// ----------------------------------------

function semplice_inter_webfont($wrapped) {
	// include semplice default font (Inter)
	$inter = '
		@font-face {
			font-family: "Inter";
			font-style:  normal;
			font-weight: 100 900;
			font-display: swap;
			src: url("' . get_template_directory_uri() . '/assets/fonts/inter.woff2") format("woff2");
		}
	';

	// start output
	if(true === $wrapped) {
		return '<style type="text/css" id="semplice-inter-webfont">' . $inter . '</style>';
	} else {
		return $inter;
	}
}

// ----------------------------------------
// social profiles
// ----------------------------------------

function semplice_get_social_profiles() {
	return array(
		'artstation' => array(
			'name' => 'Artstation',
			'url'  => 'https://www.artstation.com/',
			'svg'  => get_svg('frontend', '/social-profiles/artstation')
		),
		'behance' => array(
			'name' => 'Behance',
			'url'  => 'https://www.behance.net/',
			'svg'  => get_svg('frontend', '/social-profiles/behance')			
		),
		'deviantart' => array(
			'name' => 'DeviantArt',
			'url'  => 'https://www.deviantart.com/',
			'svg'  => get_svg('frontend', '/social-profiles/deviantart')
		),
		'dribbble' => array(
			'name' => 'Dribbble',
			'url'  => 'https://dribbble.com/',
			'svg'  => get_svg('frontend', '/social-profiles/dribbble')
		),
		'etsy' => array(
			'name' => 'Etsy',
			'url'  => 'https://www.etsy.com/people/',
			'svg'  => get_svg('frontend', '/social-profiles/etsy')
		),
		'facebook' => array(
			'name' => 'Facebook',
			'url'  => 'https://www.facebook.com/',
			'svg'  => get_svg('frontend', '/social-profiles/facebook')
		),
		'github' => array(
			'name' => 'Github',
			'url'  => 'https://github.com/',
			'svg'  => get_svg('frontend', '/social-profiles/github')
		),
		'instagram' => array(
			'name' => 'Instagram',
			'url'  => 'https://www.instagram.com/',
			'svg'  => get_svg('frontend', '/social-profiles/instagram')
		),
		'linkedin' => array(
			'name' => 'LinkedIn',
			'url'  => '',
			'svg'  => get_svg('frontend', '/social-profiles/linkedin')
		),
		'medium' => array(
			'name' => 'Medium',
			'url'  => 'https://medium.com/@',
			'svg'  => get_svg('frontend', '/social-profiles/medium')
		),
		'unsplash' => array(
			'name' => 'Unsplash',
			'url'  => 'https://unsplash.com/',
			'svg'  => get_svg('frontend', '/social-profiles/unsplash')
		),
		'pinterest' => array(
			'name' => 'Pinterest',
			'url'  => 'https://www.pinterest.com/',
			'svg'  => get_svg('frontend', '/social-profiles/pinterest')
		),
		'tiktok' => array(
			'name' => 'TikTok',
			'url'  => 'https://www.tiktok.com/@',
			'svg'  => get_svg('frontend', '/social-profiles/tiktok')
		),
		'tumblr' => array(
			'name' => 'Tumblr',
			'url'  => '',
			'svg'  => get_svg('frontend', '/social-profiles/tumblr')
		),
		'twitch' => array(
			'name' => 'Twitch',
			'url'  => 'https://www.twitch.tv/',
			'svg'  => get_svg('frontend', '/social-profiles/twitch')
		),
		'twitter' => array(
			'name' => 'Twitter',
			'url'  => 'https://twitter.com/',
			'svg'  => get_svg('frontend', '/social-profiles/twitter')
		),
		'vimeo' => array(
			'name' => 'Vimeo',
			'url'  => 'https://vimeo.com/',
			'svg'  => get_svg('frontend', '/social-profiles/vimeo')
		),
		'youtube' => array(
			'name' => 'YouTube',
			'url'  => 'https://www.youtube.com/user/',
			'svg'  => get_svg('frontend', '/social-profiles/youtube')
		)
	);
}

// ----------------------------------------
// back to top arrow
// ----------------------------------------

function semplice_back_to_top_arrow() {
	// default
	$arrow = get_svg('frontend', '/icons/arrow_up');
	// options
	$advanced = json_decode(get_option('semplice_customize_advanced'), true);
	if(is_array($advanced) && isset($advanced['top_arrow'])) {
		// get image
		$image = semplice_get_image($advanced['top_arrow'], 'full');
		$arrow = '<img src="' . $image . '" alt="Back to top Arrow">';
	}
	// return
	return $arrow;
}

// ----------------------------------------
// get animate presets
// ----------------------------------------

function semplice_get_animate_presets() {
	// get json for preview presets
	$preview = file_get_contents(get_template_directory() . '/assets/json/animate_preview.json');
	// get json for premade presets
	$premade = file_get_contents(get_template_directory() . '/assets/json/animate_presets.json');
	// add to presets
	$presets = array(
		'preview' => json_decode($preview, true),
		'premade' => json_decode($premade, true),
		'custom' => false,
	);
	// get custom presets
	$custom = json_decode(get_option('semplice_animate_presets'), true);
	// are there custom presets?
	if(false !== $custom && is_array($custom) && !empty($custom)) {
		$presets['custom'] = $custom;
	}
	return $presets;
}

// ----------------------------------------
// has animate gradient
// ----------------------------------------

function semplice_has_animate_gradient($motions) {
	$clip_text = '';
	if(isset($motions['initial']) && isset($motions['initial']['gradient_applyto']) && $motions['initial']['gradient_applyto'] == 'text') {
		$clip_text = ' clip-text';
	}
	return $clip_text;
}

// -----------------------------------------
// whats new
// -----------------------------------------

function semplice_whats_new() {
	// version
	$version = semplice_theme('version');
	// whats new version
	$wn_version = get_option('semplice_whats_new');
	// dont do anything on onboarding
	if(true === semplice_is_onboarding()) {
		// set it to read
		update_option('semplice_whats_new', $version);
		return array('unread' => false);
	} else if($version != $wn_version) {
		// set it to read
		update_option('semplice_whats_new', $version);
		return array(
			'unread' => true,
			'html'	 => semplice_whats_new_html($version),
		);
	} else {
		return array('unread' => false);
	}
}

// -----------------------------------------
// whats new html
// -----------------------------------------

function semplice_whats_new_html($version) {
	// get json for changelog
	$json = file_get_contents(get_template_directory() . '/assets/json/changelog.json');
	// decode
	$json = json_decode($json, true);
	// changelog output and head
	$changelog_output = '';
	$changelog_head = '<p class="changelog-head">Changelog</p>';
	// get features html
	$features = '';
	if(isset($json['featured'])) {
		foreach ($json['featured'] as $feature => $values) {
			$link = '';
			if(isset($values['link'])) {
				$link = '<p class="feature-desc">&rarr; <a target="_blank" href="' . $values['link'] . '">' . $values['link_desc'] . '</a></p>';
			}
			$asset = '';
			if(isset($values['asset'])) {
				switch ($values['asset']['type']) {
					case 'image':
						$asset = '<img src="' . $values['asset']['link'] . '" alt="' . $values['title'] . '">';
					break;
				}
			}
			$features .= '
				<div class="feature">
					<p class="new-feature-heading"><span class="new-feature">New</span>' . $values['title'] . '</p>
					<p class="feature-desc">' . $values['description'] . '</p>
					' . $link . '
					' . $asset . '
				</div>
			';
		}
	} else {
		$changelog_head = '';
	}
	// iterate
	if(isset($json['changelog']) && is_array($json['changelog'])) {
		foreach ($json['changelog'] as $entry) {
			// add to output
			$changelog_output .= '<p><span class="' . $entry['label'] . '">' . strtoupper($entry['label']) . '</span>' . $entry['text'] . '</p>';
		}
	}
	// output
	$output = '
		<div id="semplice-whats-new" class="popup">
			<div class="popup-inner">
				<div class="popup-close admin-click-handler" data-handler="hidePopup">
					' . get_svg('backend', '/icons/popup_close') . '
				</div>
				<div class="popup-content whats-new-content">
					<p class="head">What’s new in<br />Semplice ' . $version . '</p>
					' . $features . '
					<div class="changelog">
						' . $changelog_head . '
						' . $changelog_output . '
						<div class="changelog-link"><a href="https://www.semplice.com/changelog-v5-' . semplice_theme('edition') . '" target="_blank">View complete changelog on semplice.com</a></div>
					</div>
				</div>				
			</div>
		</div>
	';
	
	// return output
	return $output;
}