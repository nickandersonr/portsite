<?php

// -----------------------------------------
// semplice hex to rgb conversion
// -----------------------------------------

function semplice_hex_to_rgb($hex) {
	$hex = str_replace("#", "", $hex);
	$color = array();
	 
	if(strlen($hex) == 3) {
		$color['r'] = hexdec(substr($hex, 0, 1) . $r);
		$color['g'] = hexdec(substr($hex, 1, 1) . $g);
		$color['b'] = hexdec(substr($hex, 2, 1) . $b);
	}
	else if(strlen($hex) == 6) {
		$color['r'] = hexdec(substr($hex, 0, 2));
		$color['g'] = hexdec(substr($hex, 2, 2));
		$color['b'] = hexdec(substr($hex, 4, 2));
	}
	 
	return $color;
}

// -----------------------------------------
// get frontend css js
// -----------------------------------------

function semplice_get_post_css_js($mode, $post_id) {

	// globals
	global $semplice_content;

	// get content
	$content = $semplice_content;

	// has content?
	if(!empty($content)) {
		// check mode
		if($mode == 'css') {
			// define search and replace
			$search  = array('#content-holder', 'body ');
			$replace = array('#content-' . $post_id, '#content-' . $post_id . ' ');
			// str replace and output css
			return str_replace($search, $replace, $content['css']);
		} else {
			// return javascript
			if(isset($content['js'])) {
				return $content['js'];
			} else {
				return '';
			}			
		}
	}
}

// -----------------------------------------
// get bg css
// -----------------------------------------

function semplice_get_bg_css($styles) {

	// define
	$css = '';

	// create background css
	if(!empty($styles['background-image'])) {
		// background image
		$css .= semplice_get_bg_image($styles);
		// background attributes
		if(!empty($styles['background-repeat'])) {
			$css .= 'background-repeat: ' . $styles['background-repeat'] . ';';
		}
		if(!empty($styles['background-size']) && $styles['background-size'] == 'cover') {
			$css .= 'background-size: cover;';	
		} else if(!empty($styles['background-size']) && $styles['background-size'] == 'contain') {
			$css .= 'background-size: contain;';	
		} else if(!empty($styles['background-repeat']) && $styles['background-repeat'] != 'no-repeat') {
			$css .= 'background-size: auto;';
		}
		if(!empty($styles['background-position'])) {
			$css .= 'background-position: ' . $styles['background-position'] . ';';
		} else {
			$css .= 'background-position: top left;';
		}
		if(!empty($styles['background-attachment'])) {
			$css .= 'background-attachment: ' . $styles['background-attachment'] . ';';
		} else {
			$css .= 'background-attachment: scroll;';
		}
	}
	if(!empty($styles['background-color'])) {
		if(preg_match('/^#[a-f0-9]{6}$/i', $styles['background-color'])) {
			$has_color = true;
		}
		if(!empty($has_color) && $has_color === true) {
			$css .= 'background-color: ' . $styles['background-color'] . ';';
		} else {
			$css .= 'background-color: transparent;';
		}
	}

	// return
	return $css;
}

// -----------------------------------------
// get body bg for transitions
// -----------------------------------------

function semplice_body_bg() {
	$transitions = json_decode(get_option('semplice_customize_transitions'), true);
	// is array?
	if(is_array($transitions)) {
		// is set body bg?
		if(isset($transitions['background-color'])) {
			echo 'bgcolor="' . $transitions['background-color'] . '"';
		}
	}
}

// -----------------------------------------
// get bg image
// -----------------------------------------

function semplice_get_bg_image($styles) {
	$css = '';
	// get background image
	if(!empty($styles['background-image'])) {
		if(!isset($styles['background_type']) || $styles['background_type'] != 'vid') {
			if(!is_numeric($styles['background-image'])) {
				$bg_image = semplice_get_external_image($styles['background-image']);
				$bg_image[0] = $bg_image['url'];
			} else {
				$bg_image = wp_get_attachment_image_src($styles['background-image'], 'full');
			}
			if (false !== $bg_image) {
				$css = 'background-image: url(' . $bg_image[0] . ');';
			}
		}
	}
	// ret
	return $css;
}

// -----------------------------------------
// responsive cover
// -----------------------------------------

function semplice_responsive_bg_img($styles) {
	// output
	$css = '';
	// bg image
	if(!empty($styles['background-image'])) {
		$css .= semplice_get_bg_image($styles);
	}
	// bg position
	if(!empty($styles['background-position'])) {
		$css .= 'background-position: ' . $styles['background-position'] . ';';
	}
	// return
	return $css;
}

?>