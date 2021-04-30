<?php

// -----------------------------------------
// thumb hover css
// -----------------------------------------

function semplice_thumb_hover_css($id, $options, $is_global, $prefix_id, $is_editor) {

	// is frontend?
	$detect = new Mobile_Detect;
	if(false === $is_editor && false === $detect->isMobile()) {

		// output
		$output = '';

		// is global?
		if($is_global) {
			// set id
			$id = '.thumb';
		} else {
			$id = '#' . $id;
		}

		// extract options
		extract( shortcode_atts(
			array(
				'hover_scale'					=> 'noscale',
				'hover_scale_amount'			=> 15,
				'hover_scale_duration'			=> .3,
				'hover_bg_type'					=> 'img',
				'hover_bg_color'				=> array('r' => 0,'g' => 0,'b' => 0),
				'hover_bg_color_opacity'		=> .5,
				'hover_bg_image'				=> false,
				'hover_bg_size'					=> 'auto',
				'hover_bg_position'				=> '0% 0%',
				'hover_bg_repeat'				=> 'no-repeat',
				'bg_video_opacity'				=> '1',
				'hover_title_color'				=> '#ffffff',
				'hover_title_font'				=> 'regular',
				'hover_title_fontsize'			=> '1.33rem',
				'hover_title_text_transform'	=> 'none',
				'hover_title_padding'			=> '2.22rem',
				'hover_category_fontsize'		=> '1rem',
				'hover_category_color'			=> '#999999',
				'hover_category_font'			=> 'regular',
				'hover_category_text_transform'	=> 'none',
				'hover_box_shadow'				=> 'none',
				'hover_box_shadow_duration'		=> .3,
			), $options )
		);

		// thumb hover start
		$output .= $prefix_id . ' ' . $id . ' .thumb-inner .thumb-hover {';

		// bg color
		if(!is_array($hover_bg_color)) {
			if($hover_bg_color != 'transparent') {
				$hover_bg_color = semplice_hex_to_rgb($hover_bg_color);
			} else if($hover_bg_color == 'transparent') {
				$hover_bg_color = 'transparent';
			}
			if(!$is_global && empty($hover_bg_image)) {
				$output .= 'background-image: none;';
			}
		}

		if($hover_bg_color == 'transparent') {
			$output .= 'background-color: transparent;';
		} else {
			$output .= 'background-color: rgba(' . $hover_bg_color['r'] . ', ' . $hover_bg_color['g'] . ', ' . $hover_bg_color['b'] . ', ' . $hover_bg_color_opacity . ');';
		}


		// hover bg image
		if(is_numeric($hover_bg_image) && $hover_bg_type != 'vid') {

			// get image
			$image = wp_get_attachment_image_src($hover_bg_image, 'full', false);

			// is image?
			if($image) {
				$output .= 'background-image: url(' . $image[0] . ');';
			}
		}

		// hover bg size
		$output .= 'background-size: ' . $hover_bg_size . ';';

		// hover bg position
		$output .= 'background-position: ' . $hover_bg_position . ';';

		// hover bg repeat
		$output .= 'background-repeat: ' . $hover_bg_repeat . ';';

		// thumb hover close
		$output .= '}';

		// box shadow
		if($hover_box_shadow != 'none') {
			if(true === $is_editor) {
				$output .= '.thumb-hover-preview .thumb-inner { box-shadow: ' . $hover_box_shadow . '; }'; 
			} else {
				$output .= $prefix_id . ' ' . $id . ' .thumb-inner { transition: box-shadow ' . $hover_box_shadow_duration . 's ease; }';
				$output .= $prefix_id . ' ' . $id . ' .thumb-inner:hover, .is-frontend ' . $prefix_id . ' ' . $id . ' .wrap-focus { box-shadow: ' . $hover_box_shadow . '; }'; 
			}
		}

		// scale thumb on hover
		if($hover_scale == 'scale') {
			$output .= $prefix_id . ' ' . $id . ' .thumb-inner img { transition: all ' . $hover_scale_duration . 's ease; }';
			if($hover_scale_amount < 10) {
				$hover_scale_amount = '0' . $hover_scale_amount;
			}
			$output .= $prefix_id . ' ' . $id . ' .thumb-inner:hover img, .is-frontend ' . $prefix_id . ' ' . $id . ' .wrap-focus img { transform: scale(1.' . $hover_scale_amount . '); }';
		}

		// meta padding
		$output .= $prefix_id . ' ' . $id . ' .thumb-hover-meta { padding: ' . $hover_title_padding . '; }';

		// title options
		$output .= $prefix_id . ' ' . $id . ' .thumb-hover-meta .title { color: ' . $hover_title_color . '; font-size: ' . $hover_title_fontsize . '; text-transform: ' . $hover_title_text_transform . '; }';

		// category options
		$output .= $prefix_id . ' ' . $id . ' .thumb-hover-meta .category { color: ' . $hover_category_color . '; font-size: ' . $hover_category_fontsize . '; text-transform: ' . $hover_category_text_transform . '; }';

		// video opacity
		$output .= $prefix_id . ' ' . $id . ' video { opacity: ' . $bg_video_opacity . '; }';

		// return
		return $output;
	}
}

// -----------------------------------------
// thumb hover html
// -----------------------------------------

function semplice_thumb_hover_html($hover, $project, $is_frontend) {

	// is frontend?
	$detect = new Mobile_Detect;
	if($is_frontend && false === $detect->isMobile()) {
		// extract options
		extract( shortcode_atts(
			array(
				'hover_title_visibility'	=> 'hide-both',
				'hover_title_alignment' 	=> 'top-left',
				'hover_title_transition'	=> 'fade',
				'hover_title_font'	  		=> 'regular',
				'hover_category_font'	  	=> 'regular',
				'hover_bg_type'				=> 'img',
			), $hover)
		);

		// get global video hover
		$video_hover = '';
		if($hover_bg_type == 'vid' && $project != 'noproject') {
			$video_hover = semplice_background_video($hover, 'frontend', '');
		}

		// is project?
		if(isset($project) && is_array($project)) {
			if(isset($project['thumb_hover'])) {	
				// title font family
				if(isset($project['thumb_hover']['hover_title_font'])) {
					$hover_title_font = $project['thumb_hover']['hover_title_font'];
				}

				// category font family
				if(isset($project['thumb_hover']['hover_category_font'])) {
					$hover_category_font = $project['thumb_hover']['hover_category_font'];
				}

				// title alignment
				if(isset($project['thumb_hover']['hover_title_alignment'])) {
					$hover_title_alignment = $project['thumb_hover']['hover_title_alignment'];
				}

				// visibility
				if(isset($project['thumb_hover']['hover_title_visibility'])) {
					$hover_title_visibility = $project['thumb_hover']['hover_title_visibility'];
				}

				// title transition
				if(isset($project['thumb_hover']['hover_title_transition'])) {
					$hover_title_transition = $project['thumb_hover']['hover_title_transition'];
				}

				// is video hover?
				if(isset($project['thumb_hover']['hover_bg_type']) && $project['thumb_hover']['hover_bg_type'] == 'vid') {
					$video_hover = semplice_background_video($project['thumb_hover'], 'frontend', '');
				} else {
					// empty video hover for this thumbnail
					$video_hover = '';
				}
			}
		} else {
			// set defaults
			$project = array(
				'post_title'   => 'Sample project title',
				'project_type' => 'Project Type'
			);
		}

		// masonry items open
		return '
			<div class="thumb-hover">
				' . $video_hover . '
				<div class="thumb-hover-meta ' . $hover_title_alignment . ' ' . $hover_title_visibility . ' ' . $hover_title_transition . '">
					<p>
						<span class="title" data-font="' . $hover_title_font . '">' . $project['post_title'] . '</span><br />
						<span class="category" data-font="' . $hover_category_font. '">' . $project['project_type'] . '</span>
					</p>			
				</div>
			</div>
		';
	}
}

// -----------------------------------------
// get thumbnail
// -----------------------------------------

function semplice_get_thumbnail($post_id, $all_types) {

	// get post settings from meta
	$post_settings = json_decode(get_post_meta($post_id, '_semplice_post_settings', true), true);

	// types
	if(true === $all_types) {
		$types = array('image', 'project_panel', 'nextprev');
	} else {
		$types = array('image');
	}

	// thumbnails
	$thumbnails = array();

	// define defaults
	$defaults = array(
		'src' => '',
		'width' => '',
		'height' => '',
		'grid_width' => ''
	);

	// iterate types
	foreach ($types as $type) {
		// add defaults to thumbnails
		$thumbnails[$type] = $defaults;
		// get img src
		if(is_array($post_settings)) {
			if(isset($post_settings['thumbnail'][$type]) && is_numeric($post_settings['thumbnail'][$type])) {
				$thumbnail_src = wp_get_attachment_image_src($post_settings['thumbnail'][$type], 'full', false);
				// image still exists?
				if($thumbnail_src) {
					// image src
					$thumbnails[$type]['src'] = $thumbnail_src[0];
					// image width
					$thumbnails[$type]['width'] = $thumbnail_src[1];
					// image height
					$thumbnails[$type]['height'] = $thumbnail_src[2];

				} else {
					$thumbnails[$type]['src'] = get_template_directory_uri() . '/assets/images/admin/no_thumbnail.png';
				}
			} else {
				$thumbnails[$type]['src'] = get_template_directory_uri() . '/assets/images/admin/no_thumbnail.png';
			}
			// size
			if(isset($post_settings['thumbnail']['width']) && !empty($post_settings['thumbnail']['width'])) {
				$thumbnails[$type]['grid_width'] = $post_settings['thumbnail']['width'];
			} else {
				$thumbnails[$type]['grid_width'] = 4;
			}
			
		} else {
			$thumbnails[$type]['src'] = get_template_directory_uri() . '/assets/images/admin/no_thumbnail.png';
			// set default size to 4
			$thumbnails[$type]['grid_width'] = 4;
		}
		// check if type is not image and if there is a thumbnail set, if not use the grid thumbnail
		if($type != 'image' && strpos($thumbnails[$type]['src'], 'no_thumbnail') !== false) {
			$thumbnails[$type]['src'] = $thumbnails['image']['src'];
		} 
	}

	// return
	if(true === $all_types) {
		return $thumbnails;
	} else {
		return $thumbnails['image'];
	}
}

// -----------------------------------------
// get thumbnail id
// -----------------------------------------

function semplice_get_thumbnail_id($post_settings, $post_id) {

	// define thumbnail
	$thumbnail = '';

	// get img src
	if(is_array($post_settings)) {
		if(isset($post_settings['thumbnail']['image']) && is_numeric($post_settings['thumbnail']['image'])) {
			$thumbnail = $post_settings['thumbnail']['image'];
		}				
	}

	return $thumbnail;
}

// -----------------------------------------
// portfolio order
// -----------------------------------------

function semplice_portfolio_order($post_id) {
	// if project, add it to the order list
	if(get_post_status($post_id) != 'trash' && get_post_type($post_id) == 'project') {
		// get list
		$portfolio_order = json_decode(get_option('semplice_portfolio_order'),true);
		// check if in array
		if(is_array($portfolio_order) && !in_array($post_id, $portfolio_order)) {
			// add and save
			array_unshift($portfolio_order , $post_id);
		} else if(!is_array($portfolio_order)) {
			// looks like we are #1
			$portfolio_order = array(0 => $post_id);
		}
		// save
		update_option('semplice_portfolio_order', json_encode($portfolio_order));
	}
}

?>