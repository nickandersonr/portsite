<?php

// -----------------------------------------
// get default cover
// -----------------------------------------

function semplice_default_cover($cover_visibility) {
	// presets output
	$presets_html = '';
	// define presets
	$presets = array('one', 'two', 'three', 'four');
	// iterate presets
	foreach ($presets as $preset) {
		$presets_html .= '
			<a class="cover-preset admin-click-handler" data-handler="execute" data-action-type="mediaLibrary" data-action="init" data-upload="coverPreset" data-preset="' . $preset . '" data-media-type="image,video">
				' . get_svg('backend', 'cover-presets/preset_' . $preset) . '
			</a>
		';
	}

	return '
		<section id="cover" class="semplice-cover default-cover" data-cover="' . $cover_visibility . '" data-column-mode-xs="single" data-column-mode-sm="single" data-height="fullscreen">
			<div class="container">
				<div id="row_cover" class="row">
					<div class="empty-cover">
						<img src="' . get_template_directory_uri() . '/assets/images/admin/empty_cover_title.svg" alt="empty-cover-title">
						<div class="cover-presets">
							' . $presets_html . '
						</div>
						<a class="no-upload semplice-button white-button editor-action" data-handler="execute" data-action="createEmptyCover" data-action-type="helper" data-has-media="no">Start from scratch</a>
					</div>
				</div>
			</div>
			<a class="show-more show-more-hidden semplice-event" data-event-type="helper" data-event="scrollToContent">' . get_svg('frontend', '/icons/arrow_down') . '</a>
		</section>
	';
}

// ----------------------------------------
// get posts with covers
// ----------------------------------------

function semplice_posts_with_covers() {

	// fetch all pages and projects
	$args = array(
		'posts_per_page' => -1,
		'post_type' 	 => array('page', 'project'),
		'post_status'	 => 'publish',
	);

	// get posts
	$posts = get_posts($args);

	// covers
	$covers = array();

	// iterate throught posts
	if(is_array($posts) && !empty($posts)) {
		foreach ($posts as $id => $post) {
			// check if semplice
			$is_semplice = get_post_meta($post->ID, '_is_semplice', true);
			if($is_semplice) {
				// get ram
				$ram = json_decode(get_post_meta($post->ID, '_semplice_content', true), true);
				// check if cover
				if(isset($ram['cover']) && !empty($ram['cover']) && $ram['cover_visibility'] != 'hidden') {
					$covers[$post->ID] = $post->post_title;
				}
			}
		}
	}

	// return covers
	return $covers;
}

// ----------------------------------------
// get coverslider
// ----------------------------------------

function semplice_get_coverslider($coverslider, $visibility, $script_execution) {
	// output
	$output = array(
		'html' 		=> '',
		'css'  		=> '',
		'motion_css'=> '',
		'js'		=> '',
	);
	// get covers
	$posts_with_covers = semplice_posts_with_covers();
	// added covers
	$covers = $coverslider['covers'];
	// output covers
	$valid_covers = array();
	// are there any covers?
	if(!empty($posts_with_covers)) {
		// cover count
		$count = 0;
		// check if added covers are in the valid coverlist or maybe deleted or change to draft
		foreach ($covers as $post_id) {
			// add covers to valid covers
			if(isset($posts_with_covers[$post_id])) {
				$valid_covers[] = $post_id;
			}
		}
		// launch coverslider if count > 0
		if(!empty($valid_covers)) {
			// add valid covers
			$coverslider['covers'] = $valid_covers;
			// get output
			$output = semplice_coverslider_output($coverslider, $visibility, $script_execution);
		} else {
			$output['html'] = semplice_empty_coverslider();
		}
	} else {
		$output['html'] = semplice_empty_coverslider();
	}
	
	// return output
	return $output;
}

// ----------------------------------------
// get coverslider
// ----------------------------------------

function semplice_coverslider_output($coverslider, $visibility, $script_execution) {
	// globals
	global $detect;
	global $editor_api;
	global $semplice_get_content;

	// extract options
	extract( shortcode_atts(
		array(
			'orientation' 			=> 'vertical',
			'navigation'			=> 'dots',
			'color'					=> '#333333',
			'content_after_slider' 	=> false,
			'easing'				=> 'ease',
			'custom_easing'			=> '',
			'duration'				=> 900,
			'parallax'				=> 'disabled',
			'parallax_type' 		=> 'cover',
			'parallax_offset'		=> '60',
			'hide_post_cover'		=> 'disabled',
			'autoplay'				=> 'disabled',
			'infinite_slider'		=> 'enabled',
			'timeout'				=> 4000,
		), $coverslider)
	);

	// slider vars
	$covers = $coverslider['covers'];
	$slide_or_section = 'section';
	$has_navigation = 'true';
	$custom_options = '';
	$active_slider = '';
	$has_dots = '';

	// action / event vars
	$action_class = 'editor-action';
	$action_event = 'action';
	$action_type = 'coverslider';
	$set_interval = 's4.coverSliderTimeout';
	

	// is frontend?
	if($visibility != 'editor') {
		$action_class = 'semplice-event';
		$action_event = 'event';
		$action_type = 'helper';
		$active_slider = '
			s4.activeCoverSlider = true;
		';
	}

	// define
	$output = array(
		'html' 		=> '',
		'css'  		=> '',
		'motion_css'=> '',
		'js'		=> '',
	);
	// custom easing
	if(!empty($custom_easing) && strpos($custom_easing, 'cubic-bezier') !== false) {
		$easing = $custom_easing;
	}

	// add dots / arrows color
	$output['css'] .= '#fp-nav ul li a span, .fp-slidesNav ul li a span { background: ' . $color . '; } .fp-hor-nav a svg, .fp-vert-nav a svg { fill: ' . $color . '; } ';

	// content after slider
	if($orientation == 'horizontal' && !empty($content_after_slider) && $visibility != 'editor') {
		$custom_options .= 'autoScrolling: false, fitToSection: false,';
	}

	// parallax?
	if($parallax == 'enabled' && false === $detect->isMobile()) {

		$custom_options .= 'parallax: true, parallaxKey: "QU5ZXzE2ZmNHRnlZV3hzWVhnPTVVZg==",';
		// parallax options
		$custom_options .= 'parallaxOptions: {type: "' . $parallax_type . '", percentage: ' . $parallax_offset . ' },';
	}

	// coverslider navigation
	if($orientation == 'horizontal') {
		
		// set slide mode for the cover slider
		$slide_or_section = 'slide';
		
		if($navigation == 'arrows') {
			// add arrows
			$output['html'] .= '
				<div class="fp-hor-nav">
					<a class="prev ' . $action_class . '" data-' . $action_event . '-type="' . $action_type . '" data-' . $action_event . '="changeSlide" data-type="horizontal" data-direction="prev">' . get_svg('frontend', 'icons/arrow_left') . '</a>
					<a class="next ' . $action_class . '" data-' . $action_event . '-type="' . $action_type . '" data-' . $action_event . '="changeSlide" data-type="horizontal" data-direction="next">' . get_svg('frontend', 'icons/arrow_right') . '</a>
				</div>
			';
			// set vertical dots to true
			$has_navigation = 'false';
		} else {
			// show slides navigation
			$custom_options .= 'slidesNavigation: true,';
			// has dots
			$has_dots = 'has-dots';
			// set vertical dots to true
			$has_navigation = 'false';
		}
		
	} else {
		// vertical navigation with arrows
		if($navigation == 'arrows') {
			// add arrows
			$output['html'] .= '
				<div class="fp-vert-nav">
					<a class="prev ' . $action_class . '" data-' . $action_event . '-type="' . $action_type . '" data-' . $action_event . '="changeSlide" data-type="vertical" data-direction="prev">' . get_svg('frontend', 'icons/arrow_up') . '</a>
					<a class="next ' . $action_class . '" data-' . $action_event . '-type="' . $action_type . '" data-' . $action_event . '="changeSlide" data-type="vertical" data-direction="next">' . get_svg('frontend', 'icons/arrow_down') . '</a>
				</div>
			';
			// set dots to false
			$has_navigation = 'false';
		}
	}

	// autoplay
	if($autoplay == 'enabled') {
		// direction
		if($orientation == 'horizontal') {
			$direction = 'moveSlideRight';
		} else {
			$direction = 'moveSectionDown';
		}
		// javascript
		$autoplay_js = '
			// clear old timeout if set
			if(false !== ' . $set_interval . ') {
				clearInterval(' . $set_interval . ');
			}
			' . $set_interval . ' = setInterval(function() {
				$.fn.fullpage.' . $direction . '();
			}, ' . $timeout . ');
		';
	} else {
		$autoplay_js = '
			// clear old timeout if set
			if(false !== ' . $set_interval . ') {
				clearInterval(' . $set_interval . ');
			}
		';
	}

	// reset video
	$reset_video = '
		// reset video
		$("#coverslider").find(".slide, .fp-section").each(function() {
			if(!$(this).hasClass("active")) {
				$(this).find(".background-video video").each(function() {
					$(this)[0].pause();
					$(this)[0].currentTime = 0;
					$(this)[0].play();
				});
			}
		});
	';

	// cover effects
	$active_class = '.fp-section.active';
	if($orientation == 'horizontal') {
		$active_class = '.fp-slide.active';
	}
	$cover_effects = '';
	if($visibility == 'frontend') {
		$cover_effects = '
			setTimeout(function() {
				s4.helper.coverEffects($("' . $active_class . '").find(".semplice-cover").attr("id"));
			},0);
		';
	}

	// add global view project button css
	$output['css'] .= semplice_get_vp_button('css', 'global', false, $coverslider, $has_dots, $hide_post_cover);

	// slider start
	$output['html'] .= '<div id="coverslider">';

	// hide post cover
	if($hide_post_cover == 'enabled') {
		$output['html'] .= '<form id="coverslider-form" action="" method="post"><input type="hidden" name="hide_cover" value="true"></form>';
	}

	// if horizontal wrap in section
	if($orientation == 'horizontal') {
		$output['html'] .= '<div class="section">';
	}

	// infinite slider
	if($infinite_slider == 'enabled') {
		$custom_options .= 'loopBottom: true, loopTop: true, loopHorizontal: true,';
	} else {
		$custom_options .= 'loopBottom: false, loopTop: false, loopHorizontal: false,';
	}

	foreach ($covers as $key => $post_id) {
		// get status
		$status = get_post_status($post_id);
		// only get covers from published posts
		if($status == 'publish') {
			// get ram
			$ram = json_decode(get_post_meta($post_id, '_semplice_content', true), true);
			// styles
			$styles = $ram['cover']['styles']['xl'];
			// check if ram and cover are set
			if(null !== $ram && isset($ram['cover'])) {
				// overwrite order with cover order so that only the covers gets executed by get content
				$ram['order'] = array(
					'cover' => $ram['order']['cover'],
				);
				// to avoid id problems from duplicates we will change the content ids on the fly here
				$cover = array(
					'order' => array(
						'cover' => array(),
					),
					'cover_visibility' => 'visible',
					'cover' => $ram['cover'],
				);
				// cover iterate
				$cover_iterate = array();
				// is old single row mode?
				if(isset($ram['order']['cover']['columns'])) {
					//move columns to a virtual row to make it compatible with the new multi row system
					$cover_iterate['row_' . substr(md5(rand()), 0, 9)]['columns'] = $ram['order']['cover']['columns'];
				} else {
					$cover_iterate = $ram['order']['cover'];
				}
				// get cover content if there
				foreach ($cover_iterate as $row_id => $columns) {
					// new row id
					$new_row_id = 'row_' . substr(md5(rand()), 0, 9);
					// add row to ram
					$cover['order']['cover'][$new_row_id] = array(
						'columns' => array(),
					);
					// iterate columns
					if(!empty($columns['columns'])) {
						foreach ($columns['columns'] as $column_id => $column_content) {
							// create new id
							$new_column_id = 'column_' . substr(md5(rand()), 0, 9);
							// add column to new cover
							$cover[$new_column_id] = $ram[$column_id];
							// add new section to new order
							$cover['order']['cover'][$new_row_id]['columns'][$new_column_id] = array();
							// iterate column content
							foreach ($column_content as $content_id) {
								// create new id
								$new_content_id = 'content_' . substr(md5(rand()), 0, 9);
								// add content to new cover
								$cover[$new_content_id] = $ram[$content_id];
								// add to new order
								$cover['order']['cover'][$new_row_id]['columns'][$new_column_id][] = $new_content_id;
							}
						}
					}
				}
				// add post id and scroll reveal to ram
				$cover['post_id'] = $post_id;
				// get cover and contents
				$content = $editor_api->get_content($cover, 'frontend', false, false);
				// vp button visibility
				$vp_button_visibility = true;
				if(isset($styles['vp_button_type']) && $styles['vp_button_type'] == 'custom' && isset($styles['vp_button_visibility']) && $styles['vp_button_visibility'] == 'hidden') {
					$vp_button_visibility = false;
				}
				// get vp options if visible
				if(false !== $vp_button_visibility) {
					if(isset($styles['vp_button_type']) && $styles['vp_button_type'] == 'custom') {
						// add view project css
						$output['css'] .= semplice_get_vp_button('css', $post_id, get_the_permalink($post_id), $styles, $has_dots, $hide_post_cover);
						// add view project button
						$content['html'] .= semplice_get_vp_button('html', $post_id, get_the_permalink($post_id), $styles, $has_dots, $hide_post_cover);
					} else {
						// add view project button
						$content['html'] .= semplice_get_vp_button('html', 'global', get_the_permalink($post_id), $coverslider, $has_dots, $hide_post_cover);
					}
				}
				// add html and css content
				$output['html'] .= '<div class="' . $slide_or_section . '">' . $content['html'] . '</div>';
				// add cover css
				$output['css'] .= $content['css'];
			}
		}
	}

	// close section wrap
	if($orientation == 'horizontal') {
		$output['html'] .= '</div>';
	}

	// close slider
	$output['html'] .= '</div>';

	// js tags
	$js_open = '<script type="text/javascript">(function ($) { $(document).ready(function () {';
	$js_close = '});})(jQuery);</script>';

	// coverslider javascript
	$coverslider_js = $js_open . '
		' . $active_slider . '
		$("#coverslider").fullpage({
			navigation: ' . $has_navigation . ',
			' . $custom_options . '
			navigationPosition: "right",
			animateAnchor: false,
			scrollingSpeed: ' . $duration . ',
			controlArrows: false,
			css3: true,
			easingcss3: "' . $easing . '",
			normalScrollElements: "#overlay-menu, #admin-edit-popup",
			afterRender: function() {
				// remove autoplay for the coverslider
				$("#coverslider").find(".background-video video").each(function() {
					$(this).removeProp("autoplay");
				})
				$("#fp-nav, .fp-slidesNav").find("a").each(function() {
					$(this).removeAttr("href");
				});
				' . $autoplay_js . '
			},
			onSlideLeave: function(section, origin, destination, direction) {
				' . $cover_effects . '
				' . $autoplay_js . '
				' . $reset_video . '
			},
			onLeave: function(origin, destination, direction) {
				' . $cover_effects . '
				' . $autoplay_js . '
				' . $reset_video . '
			},
		});
	' . $js_close;

	// script execution
	if($script_execution == 'delayed') {
		// add html
		$coverslider_content = $output['html'] . $coverslider_js;
		// hide coverslider on delayed execution
		$output['css'] .= '
			#coverslider { opacity: 0; }
		';
		// add wrapper to output
		$output['html'] = '
			' . semplice_get_transitions_preloader() . '
			<div class="coverslider-holder"></div>
		';
		// add to semplice execute stack
		$output['html'] .= '
			<script type="text/javascript">
				s4.sempliceExecuteStack["coverslider"] = {
					"type": "coverslider",
					"id": "coverslider",
					"html": ' . json_encode($coverslider_content) . ',
				};
			</script>
		';
	} else {
		// wrap html
		$output['html'] = $output['html'] . $coverslider_js;
	}

	// content after slider
	if(false !== $content_after_slider && is_numeric($content_after_slider) && $visibility != 'editor') {
		// get ram
		$ram = json_decode(get_post_meta($content_after_slider, '_semplice_content', true), true);
		// add script execution
		$ram['script_execution'] = $script_execution;
		// make sure ram has content
		if(null !== $ram && isset($ram['order'])) {
			// delete cover if there
			if(isset($ram['order']['cover'])) {
				unset($ram['order']['cover']);
			}
			// get content
			$content = $editor_api->get_content($ram, 'frontend', false, false);
			// add content to output
			foreach ($output as $content_type => $output_content) {
				if(isset($content[$content_type])) {
					$output[$content_type] .= $content[$content_type];
				}
			}
		}
	}

	// return coverslider
	return $output;
}

// ----------------------------------------
// get view project button
// ----------------------------------------

function semplice_get_vp_button($mode, $post_id, $permalink, $options, $has_dots, $hide_post_cover) {
	// extract options
	extract( shortcode_atts(
		array(
			'vp_button_type'					=> 'default',
			'vp_button_label'					=> 'View Project',
			'vp_button_font_family'				=> '',
			'vp_button_font_size'				=> '0.7222222222222222rem',
			'vp_button_letter_spacing'			=> 0,
			'vp_button_padding_ver'				=> '0.4444444444444444rem',
			'vp_button_padding_hor'				=> '1.666666666666667rem',
			'vp_button_border_width'			=> '0.0555555555555556rem',
			'vp_button_border_radius'			=> '0.1111111111111111rem',
			'vp_button_font_color'				=> '#ffffff',
			'vp_button_bg_color'				=> 'transparent',
			'vp_button_border_color'			=> '#ffffff',
			'vp_button_font_mouseover_color'	=> '#000000',
			'vp_button_bg_mouseover_color'		=> '#ffffff',
			'vp_button_border_mouseover_color'	=> '#ffffff',
		), $options )
	);
	// mode
	if($mode == 'html') {
		// empty label?
		if(empty($vp_button_label)) {
			$vp_button_label = 'View Project';
		}
		// hide post cover
		if($hide_post_cover == 'enabled') {
			$hide_post_cover = 'class="cs-hide-covers"';
		} else {
			$hide_post_cover = '';
		}
		// return
		return '<div class="view-project vp-' . $post_id . ' ' . $has_dots . ' ' . $vp_button_font_family . '"><a href="' . $permalink . '"' . $hide_post_cover . '>' . $vp_button_label . '</a></div>';
	} else {
		// styles
		if($vp_button_type != 'default') {
			$css = '
				.vp-' . $post_id . ' a {
					font-size: ' . $vp_button_font_size . ';
					letter-spacing: ' . $vp_button_letter_spacing . ';
					color: ' . $vp_button_font_color . ';
					background-color: ' . $vp_button_bg_color . ';
					border-color: ' . $vp_button_border_color . ';
					padding: ' . $vp_button_padding_ver . ' ' . $vp_button_padding_hor . ';
					border-radius: ' . $vp_button_border_radius . ';
					border-width: ' . $vp_button_border_width . ';
				}
			';
			// styles mouseocver
			$css .= '
				.vp-' . $post_id . ':hover a {
					color: ' . $vp_button_font_mouseover_color . ';
					background-color: ' . $vp_button_bg_mouseover_color . ';
					border-color: ' . $vp_button_border_mouseover_color . ';
				}
			';
			// return
			return $css;
		} else {
			return '';
		}
	}
}

// ----------------------------------------
// empty cover slider
// ----------------------------------------

function semplice_empty_coverslider() {
	return '
		<section id="cs" class="semplice-cover default-cover" data-column-mode-xs="single" data-column-mode-sm="single" data-height="fullscreen">
			<div class="container">
				<div id="row_cover" class="row">
					<div class="empty-cover empty-coverslider">
						<img src="' . get_template_directory_uri() . '/assets/images/admin/missing_covers.svg" alt="missing-cover-title">
						<p class="missing-covers-desc">In order to select your covers for the cover slider you need to have a fullscreen cover enabled on your project or page. Also make sure your project or page is published and not set to draft.</p>
						<div class="help-videos">
							<a href="https://www.semplice.com/videos#cover-slider" target="_blank">Create a Coverslider</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	';
}

// ----------------------------------------
// import cover
// ----------------------------------------

function semplice_import_cover($post_id) {

	// content class
	global $editor_api;

	// output
	$output = array(
		'ram'  => array('cover' => array(), 'content' => array()),
		'html' => '',
		'css'  => '',
		'images' => array(),
	);

	// get ram
	$ram = json_decode(get_post_meta($post_id, '_semplice_content', true), true);

	// check ram
	if(null !== $ram && isset($ram['cover'])) {
		// assign only cover to order
		$ram['order'] = array(
			'cover' => $ram['order']['cover'],
		);
		// add new order
		$new_cover = array(
			'order' => array(
				'cover' => array(),
			),
			'cover_visibility' => 'visible',
			'cover' => $ram['cover'],
		);
		// add images to output
		$cover_styles = $ram['cover']['styles'];
		// iterate breakpoints
		if(is_array($cover_styles)) {
			foreach ($cover_styles as $bp => $bp_styles) {
				// bg image
				if(isset($bp_styles['background-image'])) {
					$output['images'][$bp_styles['background-image']] = semplice_get_image_object($bp_styles['background-image'], 'full');
				}
				// video fallback
				if(isset($bp_styles['bg_video_fallback'])) {
					$output['images'][$bp_styles['bg_video_fallback']] = semplice_get_image_object($bp_styles['bg_video_fallback'], 'full');
				}
			}
		}
		// cover iterate
		$cover_iterate = array();
		// is old single row mode?
		if(isset($ram['order']['cover']['columns']) && !empty($ram['order']['cover']['columns'])) {
			//move columns to a virtual row to make it compatible with the new multi row system
			$cover_iterate['row_' . substr(md5(rand()), 0, 9)]['columns'] = $ram['order']['cover']['columns'];
		} else {
			$cover_iterate = $ram['order']['cover'];
		}
		// get cover content if there
		foreach ($cover_iterate as $row_id => $columns) {
			// new row id
			$new_row_id = 'row_' . substr(md5(rand()), 0, 9);
			// add row to ram
			$new_cover['order']['cover'][$new_row_id] = array(
				'columns' => array(),
			);
			// iterate columns
			foreach ($columns['columns'] as $column_id => $column_content) {
				// create new id
				$new_column_id = 'column_' . substr(md5(rand()), 0, 9);
				// add column to content
				$output['ram']['content'][$new_column_id] = $ram[$column_id];
				// add column to new cover
				$new_cover[$new_column_id] = $ram[$column_id];
				// add new section to new order
				$new_cover['order']['cover'][$new_row_id]['columns'][$new_column_id] = array();
				// iterate column content
				foreach ($column_content as $content_id) {
					// create new id
					$new_content_id = 'content_' . substr(md5(rand()), 0, 9);
					// add to ram
					$output['ram']['content'][$new_content_id] = $ram[$content_id];
					// add content to new cover
					$new_cover[$new_content_id] = $ram[$content_id];
					// add to new order
					$new_cover['order']['cover'][$new_row_id]['columns'][$new_column_id][] = $new_content_id;
				}
			}
		}
		// get cover and contents
		$content = $editor_api->get_content($new_cover, 'editor', false, false);
		
		// add html and css content
		$output['ram']['cover'] = $ram['cover'];
		$output['html'] = $content['html'];
		$output['css'] = $content['css'];
	} else {
		$output['ram'] = 'nocover';
	}

	return $output;
}

?>