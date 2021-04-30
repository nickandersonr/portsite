<?php

// -----------------------------------------
// semplice
// functions.php
// -----------------------------------------

// -----------------------------------------
// launch semplice after activation
// -----------------------------------------

function launch_semplice() {
	// home
	$home = '#dashboard';
	// if onboarding is true, set onboarding as homepage
	if(semplice_is_onboarding()) {
		$home = '#onboarding/start';
	}
	// launch semplice
	wp_redirect(admin_url('admin.php?page=semplice-admin' . $home));
}

add_action('after_switch_theme', 'launch_semplice');

// -----------------------------------------
// get theme info
// -----------------------------------------

function semplice_theme($meta) {

	// theme info array
	$theme_info = array(
		'version' => '5.3.1',
		'edition' => 'studio',
		'php_version' => PHP_VERSION
	);

	// return theme info
	return $theme_info[$meta]; 
}

// -----------------------------------------
// get theme settings
// -----------------------------------------

function semplice_settings($type) {
	// get settings
	return json_decode(get_option('semplice_settings_' . $type), true);
}

// -----------------------------------------
// basic semplice theme setup
// -----------------------------------------

if (!function_exists('semplice_setup')) {

	// semplice setup function
	function semplice_setup() {
		
		// add post-thumbnail support
		add_theme_support('post-thumbnails');

		// html5 support for the search form
		add_theme_support('html5', array('search-form'));
		
		// remove wp-texturize
		remove_filter('the_content', 'wptexturize');

		// add title tag support
		add_theme_support('title-tag');

		// register main menu
		register_nav_menu('semplice-main-menu', 'Semplice Main Menu');

		// admin notices
		semplice_admin_notices();
		
	}
}

// setup the theme
add_action('after_setup_theme','semplice_setup');

// add mime types for semplice to allowed file upload type
function semplice_mime_types($mimes){
	return array_merge($mimes,array (
		// svg images
		'svg' => 'image/svg+xml',
		// fonts
		'ttf' => 'font/ttf',
		'otf' => 'font/otf',
		'woff' => 'font/woff',
		'woff2' => 'font/woff2',
		// json
		'json' => 'application/json'
	));
}
add_filter('upload_mimes', 'semplice_mime_types');

// make sure allowed mime types can upload
function disable_real_mime_check($data, $file, $filename, $mimes) {
	$wp_filetype = wp_check_filetype( $filename, $mimes );	
	$ext = $wp_filetype['ext'];
	$type = $wp_filetype['type'];
	$proper_filename = $data['proper_filename'];
	return compact('ext', 'type', 'proper_filename');
}
add_filter('wp_check_filetype_and_ext', 'disable_real_mime_check', 10, 4);

// change archive url
function semplice_init() {
	global $wp_rewrite;
    $wp_rewrite->date_structure = 'archives/%year%/%monthnum%/%day%';
}
add_action('init', 'semplice_init');

// -----------------------------------------
// admin functions, custom css and api endpoints
// -----------------------------------------

// mobile detect
require get_template_directory() . '/includes/mobile_detect.php';
$detect = new Mobile_Detect;

// helper functions
require get_template_directory() . '/includes/helper.php';

// apis and classes
require get_template_directory() . '/admin/editor/rest_api.php';
require get_template_directory() . '/includes/content.php';
require get_template_directory() . '/admin/rest_api.php';
require get_template_directory() . '/admin/endpoints/posts.php';
require get_template_directory() . '/admin/endpoints/customize.php';
require get_template_directory() . '/admin/endpoints/media.php';
require get_template_directory() . '/rest_api.php';

// custom css
require get_template_directory() . '/includes/custom_css.php';

// admin functions
if(is_admin()) {
	require get_template_directory() . '/admin/functions.php';
}

// -----------------------------------------
// get semplice content
// -----------------------------------------

if(!is_admin()) {
	$semplice_content = array();

	function semplice_get_content() {

		// globals
		global $post;
		global $semplice_content;

		// paged
		$paged = get_query_var('paged', 1); 

		// instance of content class
		$content = new semplice_get_content;

		// check taxonomy
		$term = false;
		if(is_category()) {
			$term = get_term_by('id', get_query_var('cat'), 'category');
		} else if(is_tag()) {
			$term = get_term_by('id', get_queried_object()->term_id, 'post_tag');
		}

		// post id
		if(is_object($post)) {
			$post_id = $post->ID;
		} else {
			$post_id = 'notfound';
		}

		// fetch content
		$semplice_content = $content->get(semplice_format_id($post_id, false), is_preview(), $paged, $term, 'normal');
	}

	add_action('wp', 'semplice_get_content');
}

// -----------------------------------------
// frontend css
// -----------------------------------------

function frontend_css() {

	// globals
	global $semplice_custom_css;

	// webfonts
	$frontend_css = $semplice_custom_css->webfonts();

	// custom css
	$frontend_css .= '
		<style type="text/css" id="semplice-custom-css">
			' . $semplice_custom_css->grid('frontend') . '
			' . $semplice_custom_css->typography(false) . '
			' . $semplice_custom_css->transitions(true) . '
			' . $semplice_custom_css->projectnav(true) . '
			' . $semplice_custom_css->advanced(true) . '
		</style>
	';

	// get post id
	$post_id = semplice_get_id();

	// search and replace
	$search  = array('#content-holder', 'body');
	$replace = array('#content-' . $post_id, '#content-' . $post_id);

	// post css
	$frontend_css .= '
		<style type="text/css" id="' . $post_id . '-post-css">
			' . semplice_get_post_css_js('css', $post_id) . '
			' . str_replace($search, $replace, $semplice_custom_css->navigation()) . '
		</style>
	';

	// return
	echo $frontend_css;
}

add_action('wp_head', 'frontend_css');

// -----------------------------------------
// frontend js
// -----------------------------------------

function frontend_js() {
	// only include javascript if not password required
	if(false === post_password_required()) {
		// get post id
		$post_id = get_the_ID();

		// get motion js
		$motion_js = semplice_get_post_css_js('js', $post_id);

		if(!empty($post_id) && !empty($motion_js)) {
			// motion js
			echo '
				<script type="text/javascript" id="' . $post_id . '-motion-js">
					' . $motion_js . '
				</script>
			';
		}
	}
}

add_action('wp_footer', 'frontend_js', 300);

// -----------------------------------------
// global custom javascript
// -----------------------------------------

function custom_javascript() {
	// get frontend mode
	$frontend_mode = semplice_get_mode('frontend_mode');
	// get advanced content
	$advanced = json_decode(get_option('semplice_customize_advanced'), true);
	// is array?
	if(is_array($advanced)) {
		// check if custom js is there and not empty
		if(isset($advanced['custom_js']) && !empty($advanced['custom_js'])) {
			// custom js spa behavior
			if(isset($advanced['custom_js_spa']) && $advanced['custom_js_spa'] == 'pagechange' && $frontend_mode == 'dynamic') {
				$advanced['custom_js'] = '
					// custom javascript function
					function smp_custom_js() {
						' . $advanced['custom_js'] . '
					}
					// call custom javascript
					smp_custom_js();
					// call it again for every page change
					window.addEventListener("sempliceAppendContent", function (e) {
						smp_custom_js();
					}, false);
				';
			}
			// add custom javascript
			echo '<script type="text/javascript" id="semplice-custom-javascript">' . $advanced['custom_js'] . '</script>';
		}
	}
}

add_action('wp_footer', 'custom_javascript', 300);

// -----------------------------------------
// body classes
// -----------------------------------------

function semplice_body_classes($classes) {

	// check if dashboard or not
	if(!is_admin()) {
		$classes[] = 'is-frontend';
	}

	// app mode
	if(semplice_get_mode('frontend_mode') == 'static') {
		$classes[] = 'static-mode';
	} else {
		$classes[] = 'dynamic-mode';
	}

	// static transitions
	$frontend_mode = semplice_get_mode('frontend_mode');
	if(semplice_static_transitions($frontend_mode) != 'disabled') {
		$classes[] = 'static-transitions';
	}

	// preview
	if(is_preview()) {
		$classes[] = 'is-preview';
	}

	// media element ui for >3.9
	if(version_compare(get_bloginfo('version'),'4.9', '>=') ) {
		$classes[] = 'mejs-semplice-ui';
	}

	return $classes;
}

add_filter('body_class','semplice_body_classes');


// ----------------------------------------
// semplice password form
// ----------------------------------------

function semplice_post_password($spa) {
	// post object
	global $post;

	// check if post is active
	if(is_object($post)) {
		$post_id = $post->ID;
	} else {
		$post_id = 0;
	}

	// atts
	$atts = array(
		'submit' => '',
		'theme' => '',
	);

	// mode defaults
	$frontend_mode = semplice_get_mode('frontend_mode');

	// get an alternative submit button for the single page app form
	if($frontend_mode == 'dynamic') {
		$atts['submit'] = '<a class="post-password-submit semplice-event" data-event-type="helper" data-event="postPassword" data-id="' . $post_id . '">Submit</a>';
	} else {
		$atts['submit'] = '<input type="submit" name="Submit" value="Submit" />';
	}

	// get advanced content
	$advanced = json_decode(get_option('semplice_customize_advanced'), true);

	// version
	$atts['theme'] = '';
	if(isset($advanced['password_form_theme']) && $advanced['password_form_theme'] == 'dark') {
		$atts['theme'] = ' post-password-form-dark';
	}

	// form template
	$output = semplice_get_template('password_form', $atts);
	
	// only use the password form for pages and projects
	if(get_post_type($post_id) == 'page' || get_post_type($post_id) == 'project' || true === $spa || is_single()) {
		return $output;
	} else {
		return '';
	}
	
}

add_filter('the_password_form', 'semplice_post_password', 10, 1);

// -----------------------------------------
// custom post types
// -----------------------------------------

require get_template_directory() . '/includes/post-types/portfolio.php';
require get_template_directory() . '/includes/post-types/footer.php';

// -----------------------------------------
// localize script defaults
// -----------------------------------------

function semplice_localize_script_defaults() {

	// mode defaults
	$frontend_mode = semplice_get_mode('frontend_mode');

	// frontpage id
	if(get_option('page_on_front')) {
		$front_page = get_option('page_on_front');
	} else {
		$front_page = 'posts';
	}

	// create output array
	$output = array(
		'default_api_url' 		=> untrailingslashit(semplice_rest_url()),
		'semplice_api_url'		=> home_url() . '/wp-json/semplice/v1/frontend',
		'template_dir'			=> get_template_directory_uri(),
		'category_base'			=> semplice_get_category_base(),
		'tag_base'				=> semplice_get_tag_base(),
		'nonce'  				=> wp_create_nonce('wp_rest'),
		'frontend_mode'			=> $frontend_mode,
		'static_transitions'	=> semplice_static_transitions($frontend_mode),
		'site_name'				=> get_bloginfo('name'),
		'base_url'				=> home_url(),
		'frontpage_id'			=> $front_page,
		'blog_home'				=> get_post_type_archive_link('post'),
		'blog_navbar'			=> semplice_get_blog_navbar(),
		'sr_status'				=> semplice_get_sr_status(),
		'blog_sr_status'		=> semplice_get_blog_sr_status(),
		'is_preview'			=> is_preview(),
		'password_form'			=> semplice_post_password(true),
		'portfolio_order'		=> semplice_get_portfolio_order(),
		'gallery'				=> array(
			'prev'  => get_svg('frontend', 'icons/arrow_left'),
			'next'  => get_svg('frontend', 'icons/arrow_right'),
			//'lightbox_prev' => setIcon('lightbox_prev'),
			//'lightbox_next' => setIcon('lightbox_next'),
		),
	);

	// get transition options
	$transition_customize = json_decode(get_option('semplice_customize_transitions'), true);

	// add items for the dynamic version
	if($frontend_mode != 'static') {

		// assign navbars html and css
		$output['menus'] = semplice_get_menus();
		
		// assign post ids
		$output['post_ids'] = semplice_get_post_ids();

		// get transitions
		require get_template_directory() . '/includes/transitions.php';

		// set transition defaults
		$transitions = array(
			'in' => $transition_atts['presets']['fade']['in'],
			'out' => $transition_atts['presets']['fade']['out'],
			'reveal' => false,
			'optimize' => 'disabled',
		);

		// merge default options into array
		$transitions = array_merge($transitions, $transition_atts['options']);

		// get transition presets
		if(get_option('semplice_customize_transitions')) {
			
			// check it and add it to transitions
			if(null !== $transition_customize && isset($transition_customize['status']) && $transition_customize['status'] != 'disabled') {
				// get presets for in and out transition
				if(isset($transition_customize['preset']) && $transition_customize['preset'] != 'reveal') {
					// set preset
					$transitions['preset'] = $transition_customize['preset'];
					// set in and out defaults
					$transitions['in'] = $transition_atts['presets'][$transition_customize['preset']]['in'];
					$transitions['out'] = $transition_atts['presets'][$transition_customize['preset']]['out'];
				} else if(isset($transition_customize['preset']) && $transition_customize['preset'] == 'reveal') {
					// set preset
					$transitions['preset'] = 'reveal';
					// first add defults to reveal transition
					$transitions['reveal'] = $transition_atts['presets']['reveal'];
					// reveal transition options
					$rt_atts = array('rt_easing', 'rt_direction', 'rt_color', 'rt_duration', 'rt_image', 'rt_image_size', 'rt_image_effect', 'rt_image_align', 'rt_offset', 'rt_image_offset');
					// loop through atts
					foreach ($rt_atts as $attribute) {
						if(isset($transition_customize[$attribute])) {
							if($attribute != 'rt_image') {
								$transitions['reveal'][str_replace('rt_', '', $attribute)] = $transition_customize[$attribute];
							} else {
								// get image
								$image = semplice_get_image($transition_customize[$attribute], 'full');
								$transitions['reveal'][str_replace('rt_', '', $attribute)] = $image;
							}
						}
					}
					// create custom rt array
					$transitions['reveal']['custom'] = array();
					// get custom reveal transition image / bg
					global $wpdb;
					// search posts
					$posts = $wpdb->get_results(
						$wpdb->prepare (
							"
							SELECT *
							FROM $wpdb->postmeta
							WHERE meta_key = '%s'
							",
							'_semplice_post_settings'
						),
						ARRAY_A
					);
					// are there posts yes with post settings?
					if(is_array($posts) && !empty($posts)) {
						foreach ($posts as $post) {
							$post_settings = json_decode($post['meta_value'], true);
							// has settings?
							if(is_array($post_settings)) {
								// vars
								$post_id = $post['post_id'];
								$custom_rt = array();
								$rt_options = array('rt_image', 'rt_color', 'rt_image_size', 'rt_image_align');
								// iterate
								foreach ($rt_options as $option) {
									if(!empty($post_settings['meta'][$option])) {
										// is image?
										if($option == 'rt_image') {
											$post_settings['meta'][$option] = semplice_get_image($post_settings['meta'][$option], 'full');
										}
										$custom_rt[$option] = $post_settings['meta'][$option];
									}
								}
								// is custom rt empty? if not add to array
								if(!empty($custom_rt)) {
									$transitions['reveal']['custom'][$post_id] = $custom_rt;
								}
							}
						}
					}
				}
				
				// get option values
				$options = array(
					'out' => array('duration', 'easing'),
					'in' => array('duration', 'easing'),
				);

				foreach ($options as $option => $option_values) {
					foreach ($option_values as $key => $value) {
						if(isset($transition_customize[$value . '_' . $option]) && !empty($transition_customize[$value . '_' . $option])) {
							// assign value
							$transitions[$option][$value] = $transition_customize[$value . '_' . $option];
						}
					}
				}
				// optimize
				if(isset($transition_customize['optimize']) && $transition_customize['optimize'] == 'enabled') {
					$transitions['optimize'] = 'enabled';
				}
				// set status
				$transitions['status'] = 'enabled';
			}
		}
		// assign transitions to the array
		$output['transition'] = $transitions;
	}

	// scroll reveal options
	$sr_atts = array('sr_viewFactor', 'sr_distance', 'sr_easing', 'sr_duration', 'sr_opacity', 'sr_scale', 'sr_mobile');
	// loop through atts
	foreach ($sr_atts as $attribute) {
		if(isset($transition_customize[$attribute])) {
			$output['sr_options'][str_replace('sr_', '', $attribute)] = $transition_customize[$attribute];
		}
	}

	// return
	return $output;
}

// -----------------------------------------
// enqueue scripts
// -----------------------------------------

function semplice_frontend_scripts() {
	// style css
	wp_enqueue_style('semplice-stylesheet', get_stylesheet_uri(), array(), semplice_theme('version'));

	// fontend styles
	wp_enqueue_style('semplice-frontend-stylesheet', get_template_directory_uri() . '/assets/css/frontend.min.css', false, semplice_theme('version'));

	// mediaelement css
	wp_enqueue_style('mediaelement');

	// semplice shared scripts
	wp_enqueue_script('semplice-shared-scripts', get_template_directory_uri() . '/assets/js/shared.scripts.min.js', '', semplice_theme('version'), true);

	// semplice frontend scripts
	wp_enqueue_script('semplice-frontend-scripts', get_template_directory_uri() . '/assets/js/frontend.scripts.min.js', '', semplice_theme('version'), true);

	// semplice frontend javascript
	wp_enqueue_script('semplice-frontend-js', get_template_directory_uri() . '/assets/js/frontend.min.js', array('jquery', 'mediaelement'), semplice_theme('version'), true);
	wp_localize_script('semplice-frontend-js', 'semplice', semplice_localize_script_defaults());
}

add_action('wp_enqueue_scripts', 'semplice_frontend_scripts');

// -----------------------------------------
// misc functions
// -----------------------------------------

function get_svg($mode, $icon) {
	// mode
	if($mode == 'backend') {
		$svg = file_get_contents('assets/images/admin/' . $icon . '.svg', true);
	} else {
		$svg = file_get_contents('assets/images/frontend/' . $icon . '.svg', true);
	}
	// return the svg source code
	return $svg;
}

// get advanced content
function semplice_big_image_treshold() {
	$advanced = json_decode(get_option('semplice_customize_advanced'), true);
	if(isset($advanced['big_image_treshold']) && $advanced['big_image_treshold'] == 'disabled') {
		add_filter( 'big_image_size_threshold', '__return_false' );
	}
}

semplice_big_image_treshold();

// -----------------------------------------
// instagram refresh token wp-cron
// -----------------------------------------

add_filter( 'cron_schedules', 'cron_add_weekly' );

function cron_add_weekly( $schedules ) {
	$schedules['weekly'] = array(
		'interval' => 604800,
		'display' => __( 'Once Weekly' )
	);
	return $schedules;
}

add_action('semplice_refresh_instagram_token', 'semplice_instagram_token');

// refresh token function
function semplice_instagram_token() {
	
	// editor
	global $editor_api;

	// get instagram token
	$instagram = json_decode(get_option('semplice_instagram_token'), true);

	// only try to refresh token if a token is already set
	if(false !== $instagram && is_array($instagram) && !empty($instagram) && isset($instagram['access_token'])) {

		// get instagram json
		if(!function_exists('_isCurl')) {
			function _isCurl(){
			    return function_exists('curl_version');
			}
		}

		// if curl is installed get media
		if(_isCurl()) {
			// curl init
			$ch = curl_init();
			// curl setopt
			curl_setopt($ch, CURLOPT_URL, 'https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=' . $instagram['access_token']);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				"Accept: application/json",
				"Content-Type: application/json"
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// exec
			$response = curl_exec($ch);
			// close
			curl_close($ch);
			// return
			$response = json_decode($response, true);
			// is valid?
			if(!isset($response['error']) && isset($response['access_token']) && isset($response['expires_in'])) {
				// refresh token
				$instagram['access_token'] = $response['access_token'];
				$instagram['expires'] = $response['expires_in'];
				// save
				update_option('semplice_instagram_token', json_encode($instagram));
			}
		}
	}
}

// schedule event
if(!wp_next_scheduled('semplice_refresh_instagram_token')) {
	wp_schedule_event( time(), 'weekly', 'semplice_refresh_instagram_token' );
}

// deactivate cron on theme switch
add_action('switch_theme', 'semplice_instagram_cron_deactivate', 10 , 2);

function semplice_instagram_cron_deactivate($newname, $newtheme) {
	$timestamp = wp_next_scheduled('semplice_refresh_instagram_token');
	wp_unschedule_event($timestamp, 'semplice_refresh_instagram_token');
}
?>