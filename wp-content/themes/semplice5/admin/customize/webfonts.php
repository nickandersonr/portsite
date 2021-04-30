<?php

// -----------------------------------------
// semplice
// /admin/webfonts.php
// -----------------------------------------

if(!class_exists('webfonts')) {
	class webfonts {

		// constructor
		public function __construct() {}

		// output
		public function output() {
			// output air
			$output['content'] = 'output';
		}

		// get fonts
		public function get() {

			// output
			$output = '';

			// get fonts
			$webfonts = json_decode(get_option('semplice_customize_webfonts'), true);

			// webfonts installed?
			if(is_array($webfonts) && !empty($webfonts['ressources'])) {

				// define self hosted css
				$self_hosted_css = '';

				// get ressources
				foreach ($webfonts['ressources'] as $id => $ressource) {
					// service
					if($ressource['ressource-type'] == 'service') {
						// only embed if valid css, js file
						if(strpos($ressource['ressource-src'], '<link') !== false || strpos($ressource['ressource-src'], '<script') !== false) {
							$output .= $ressource['ressource-src'];
						}
					} else {
						$self_hosted_css .= $ressource['ressource-src'];
					}
				}
				// self hosted tag
				if(!empty($self_hosted_css)) {
					$output .= '<style type="text/css" id="semplice-webfonts-selfhosted">' . $self_hosted_css . '</style>';
				}

			} else {
				// load default fonts
				$output .= '<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i|Lora:400,400i,700,700i" rel="stylesheet">';
			}

			// generate fonts css
			$fonts_css = $this->generate_css($webfonts);

			$output .= '<style type="text/css" id="semplice-webfonts-css">' . $fonts_css . '</style>';

			// return
			return $output;
		}

		// generate css
		public function generate_css($webfonts) {

			// is webfonts already defined?
			if(!$webfonts) {
				// get fonts
				$webfonts = json_decode(get_option('semplice_customize_webfonts'), true);
			}

			// define css
			$css = '';

			// get typography settings
			$typography = json_decode(get_option('semplice_customize_typography'), true);

			// typography attributes
			$attributes = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p');

			// webfonts?
			if(is_array($webfonts) && !empty($webfonts['fonts'])) {

				foreach ($webfonts['fonts'] as $id => $font) {
					// font array
					$font_atts = array(
						'family'   => '',
						'weight'   => '',
						'style'	   => '',
						'variable' => ''
					);
					// font family
					if(strpos($font['system-name'],',') !== false) {
						$font_name = explode(',', $font['system-name']);
						$font_atts['family'] = 'font-family: "' . $font_name['0'] . '", "' . $font_name['1'] . '", ' . $font['category'] . ';';
					} else {
						$font_atts['family'] = 'font-family: "' . $font['system-name'] . '", ' . $font['category'] . ';';
					}
					// font type
					if(isset($font['font_type']) && $font['font_type'] == 'variable') {
						// variable styles
						if(isset($font['styles']) && is_array($font['styles']) && !empty($font['styles'])) {
							foreach ($font['styles'] as $style_id => $style) {
								// get selector
								$typo_selector = $this->get_selector($typography, $style_id, $attributes, false);
								// css
								$style_css = '';
								$exclude = array('name', 'font-size', 'line-height', 'letter-spacing');
								foreach ($style as $axis => $val) {
									if(!in_array($axis, $exclude)) {
										$style_css .= "'" . $axis . "' " . $val . ", ";
									}
								}
								// cut off last 2 chars
								$style_css = substr($style_css, 0, -2);
								// add to variable
								$font_atts['variable'] = 'font-variation-settings: ' . $style_css . ';';
								// get font css
								$css .= $this->get_font_css($font_atts, $style_id, $typo_selector);
							}
						}
					} else {
						// get selector
						$typo_selector = $this->get_selector($typography, $id, $attributes, false);
						// font weight
						if($font['font-weight-usage'] == 'css') {
							$font_atts['weight'] = 'font-weight: ' . $font['font-weight'] . ';';
						} else {
							$font_atts['weight'] = 'font-weight: normal;';
						}
						// style
						$font_atts['style'] = 'font-style: ' . $font['font-style'] . ';';
						// get font css
						$css .= $this->get_font_css($font_atts, $id, $typo_selector);
					}
				}
			} else {
				// get default fonts
				$default_fonts = semplice_get_default_fonts('work', false);

				foreach ($default_fonts as $id => $values) {

					// get typo selector
					$typo_selector = $this->get_selector($typography, $id, $attributes, true);
					
					// add to css
					if(!empty($typo_selector)) {
						// css open
						$css .= $typo_selector . ', .blog-settings [data-font="' . $id . '"] {';
						// font name
						$css .= 'font-family: "' . $values['system-name'] . '", ' . $values['category'] . ';';
						// fontweight
						$css .= 'font-weight: ' . $values['font-weight'] . ';';
						// font style
						$css .= 'font-style: ' . $values['font-style'] . ';';
						// close
						$css .= '}';
					}
				}

			}

			return $css;
		}

		// get font css
		public function get_font_css($font_atts, $id, $typo_selector) {
			// selector
			$selector = '.' . $id . ', [data-font="' . $id . '"], [data-font="' . $id . '"] li a' . $typo_selector . ' {';
			// css
			return $selector . $font_atts['family'] . $font_atts['weight'] . $font_atts['style'] . $font_atts['variable'] . '}';
		}

		// get selector
		public function get_selector($typography, $id, $attributes, $defaultFonts) {

			// define
			$typo_selector = '';

			if(is_array($typography) && in_array($id, $typography)) {

				// count
				$count = 0;

				foreach ($attributes as $attribute) {
					if(isset($typography[$attribute . '_font_family']) && $id == $typography[$attribute . '_font_family']) {
						if(isset($typography[$attribute . '_customize']) && $typography[$attribute . '_customize'] == 'on' || $attribute == 'p') {
							if($attribute == 'p') {
								$attribute = 'p, #content-holder li';
							}
							if(!$defaultFonts) {
								$typo_selector .= ', #content-holder ' . $attribute;
							} else {
								if($count == 0) {
									$typo_selector .= '#content-holder ' . $attribute;
								} else {
									$typo_selector .= ', #content-holder ' . $attribute;
								}
							}
							// inc count
							$count++;
						}
					}
				}
			}

			return $typo_selector;
		}
	}

	// instance
	admin_api::$customize['webfonts'] = new webfonts;
}

?>