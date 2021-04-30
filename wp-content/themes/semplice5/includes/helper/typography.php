<?php

// -----------------------------------------
// get font
// -----------------------------------------

function semplice_get_font($id) {
	// get fonts
	$webfonts = json_decode(get_option('semplice_customize_webfonts'), true);

	if(is_array($webfonts) && !empty($webfonts['fonts'])) {
		// is font there?
		if(array_key_exists($id, $webfonts['fonts'])) {
			$font = $webfonts['fonts'][$id]['system-name'];
		} else {
			$font = false;
		}
	} else {
		$font = semplice_get_default_fontname($id);
	}

	return $font;
}

// -----------------------------------------
// get default fontname
// -----------------------------------------

function semplice_get_default_fontname($font) {
	// get fontlist
	$fonts = semplice_get_default_fonts('display', false);
	// checkc if its default font
	if(isset($fonts[$font])) {
		return $fonts[$font];
	} else {
		return false;
	}	
}

// -----------------------------------------
// get default font list
// -----------------------------------------

function semplice_get_default_fonts($mode, $get_font) {

	$fonts = array(
		'regular' => array(
			'display-name' => 'Open Sans Regular',
			'system-name'  => 'Open Sans',
			'category'	   => 'Arial, sans-serif',
			'font-weight'  => 400,
			'font-style'   => 'normal',
		),
		'regular_italic' => array(
			'display-name' => 'Open Sans Regular Italic',
			'system-name'  => 'Open Sans',
			'category'	   => 'Arial, sans-serif',
			'font-weight'  => 400,
			'font-style'   => 'italic',
		),
		'bold' => array(
			'display-name' => 'Open Sans Bold',
			'system-name'  => 'Open Sans',
			'category'	   => 'Arial, sans-serif',
			'font-weight'  => 700,
			'font-style'   => 'normal',
		),
		'bold_italic' => array(
			'display-name' => 'Open Sans Bold Italic',
			'system-name'  => 'Open Sans',
			'category'	   => 'Arial, sans-serif',
			'font-weight'  => 700,
			'font-style'   => 'italic',
		),
		'serif_regular' => array(
			'display-name' => 'Lora Regular',
			'system-name'  => 'Lora',
			'category'	   => 'Georgia, serif',
			'font-weight'  => 400,
			'font-style'   => 'normal',
		),
		'serif_regular_italic' => array(
			'display-name' => 'Lora Regular Italic',
			'system-name'  => 'Lora',
			'category'	   => 'Georgia, serif',
			'font-weight'  => 400,
			'font-style'   => 'italic',
		),
		'serif_bold' => array(
			'display-name' => 'Lora Bold',
			'system-name'  => 'Lora',
			'category'	   => 'Georgia, serif',
			'font-weight'  => 700,
			'font-style'   => 'normal',
		),
		'serif_bold_italic' => array(
			'display-name' => 'Lora Bold Italic',
			'system-name'  => 'Lora',
			'category'	   => 'Georgia, serif',
			'font-weight'  => 700,
			'font-style'   => 'italic',
		),
		'inter_regular' => array(
			'display-name' => 'Inter Regular',
			'system-name'  => 'Inter',
			'category'	   => 'Arial, sans-serif',
			'font-weight'  => 400,
			'font-style'   => 'normal',
		),
		'inter_bold' => array(
			'display-name' => 'Inter Bold',
			'system-name'  => 'Inter',
			'category'	   => 'Arial, sans-serif',
			'font-weight'  => 700,
			'font-style'   => 'normal',
		),
	);

	if($mode == 'display') {

		$output = array();

		// create array to display names for the atts
		foreach ($fonts as $font => $values) {
			$output[$font] = $values['display-name'];
		}
	} else if($mode == 'get') {
		$output = $fonts[$get_font];
	} else {
		$output = $fonts;
	}

	// output
	return $output;
}

// ----------------------------------------
// get font family
// ----------------------------------------

function semplice_get_font_family($font_id) {

	// get webfonts
	$webfonts = json_decode(get_option('semplice_customize_webfonts'), true);

	// set default font to true
	$default_font = true;

	// check if webfont is there, else it has to be a default font
	if(is_array($webfonts) && !empty($webfonts['fonts']) && isset($webfonts['fonts'][$font_id])) {
		// grt font
		$font = $webfonts['fonts'][$font_id];
		// set default font to false
		$default_font = false;
	} else if(false !== semplice_get_default_fontname($font_id)) {
		$font = semplice_get_default_fonts('get', $font_id);
	} else {
		$font = semplice_get_default_fonts('get', 'regular');
	}

	// css
	$css = '';

	// valid array?
	if(is_array($font)) {
		// fontname
		$css .= 'font-family: "' . $font['system-name'] . '", ' . $font['category'] . ';';
		// font weight
		if(isset($font['font-weight-usage']) && $font['font-weight-usage'] == 'css' || true === $default_font) {
			$css .= 'font-weight: ' . $font['font-weight'] . ';';
		}
		// font style
		$css .= 'font-style: ' . $font['font-style'] . ';';
	}

	// return
	return $css;
}

?>