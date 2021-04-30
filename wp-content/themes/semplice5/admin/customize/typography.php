<?php

// -----------------------------------------
// semplice
// /admin/typography.php
// -----------------------------------------

if(!class_exists('typography')) {
	class typography {

		// constructor
		public function __construct() {}

		// output
		public function output() {
			// output air
			$output = $this->get('html', true, true);

			return $output;
		}

		// get css
		public function get($mode, $is_admin, $is_customize) {

			// vars
			global $post;
			$output = array(
				'html' => '',
				'css'  => '',
			);
			$fonts = array();

			// get navigation json
			$typography = json_decode(get_option('semplice_customize_typography'), true);

			// has changes?
			if(is_array($typography)) {
				$options = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p');

				foreach ($options as $attribute) {

					// set default to fonts array
					$fonts[$attribute] = '';

					// is paragraph?
					if($attribute == 'p') {
						$attribute_css = 'p, #content-holder li';
					} else {
						$attribute_css = $attribute;
					}

					// prefix
					if($is_admin) {
						$prefix = '#content-holder ' . $attribute_css . ', .typography ' . $attribute . ' { ';
					} else {
						$prefix = '#content-holder ' . $attribute_css . ' { ';
					}

					// is customization on?
					if(isset($typography[$attribute . '_customize']) && $typography[$attribute . '_customize'] == 'on' || $attribute == 'p') {
						// attribute css
						$attr_css = '';
						// font family
						if(isset($typography[$attribute . '_font_family'])) {
							// add font to array
							$fonts[$attribute] = ' data-font="' . $typography[$attribute . '_font_family'] . '"';
						}
						// font size
						if(isset($typography[$attribute . '_font_size'])) {
							$attr_css .= 'font-size: ' . $typography[$attribute . '_font_size'] . ';';
						}
						// line height
						if(isset($typography[$attribute . '_line_height'])) {
							$attr_css .= 'line-height: ' . $typography[$attribute . '_line_height'] . ';';
						}
						// letter spacing
						if(isset($typography[$attribute . '_letter_spacing'])) {
							$attr_css .= 'letter-spacing: ' . $typography[$attribute . '_letter_spacing'] . ';';
						}
						// is empty?
						if(!empty($attr_css)) {
							// css open
							$output['css'] .= $prefix;
							// add attr css
							$output['css'] .= $attr_css;
							// css close
							$output['css'] .= '}';
						}
					}
				}

				// change margin bottom of the paragraph
				if(isset($typography['p_line_height'])) {
					$output['css'] .= '#content-holder .is-content p { margin-bottom: ' . $typography['p_line_height'] . 'em; }';
				}
			} else {
				$fonts = array(
					'h1' => '',
					'h2' => '',
					'h3' => '',
					'h4' => '',
					'h5' => '',
					'h6' => '',
					'p'  => '',
				);
			}

			// html
			$output['html'] = $this->get_html($fonts);

			// add custom styles css
			$output['css'] .= $this->custom_styles($typography, $is_admin, $is_customize);

			// add mobile scaling to css
			$output['css'] .= $this->mobile_scaling($typography, $is_admin);

			//echo $output['css'];

			return $output[$mode];
		}

		// html
		public function get_html($fonts) {
			return '
				<div class="typography-preview">
					<div class="heading-previews">
						<div class="heading-preview">
							<p class="preview-label">Heading H1</p>
							<h1 class="preview-h1"' . $fonts['h1'] . '>The quick brown fox<br />jumps over the lazy dog.</h1>
						</div>
						<div class="heading-preview">
							<p class="preview-label">Heading H2</p>
							<h2 class="preview-h2"' . $fonts['h2'] . '>The quick brown fox<br />jumps over the lazy dog.</h2>
						</div>
						<div class="heading-preview">
							<p class="preview-label">Heading H3</p>
							<h3 class="preview-h3"' . $fonts['h3'] . '>The quick brown fox<br />jumps over the lazy dog.</h3>
						</div>
						<div class="heading-preview">
							<p class="preview-label">Heading H4</p>
							<h4 class="preview-h4"' . $fonts['h4'] . '>The quick brown fox<br />jumps over the lazy dog.</h4>
						</div>
						<div class="heading-preview">
							<p class="preview-label">Heading H5</p>
							<h5 class="preview-h5"' . $fonts['h5'] . '>The quick brown fox<br />jumps over the lazy dog.</h5>
						</div>
						<div class="heading-preview">
							<p class="preview-label">Heading H6</p>
							<h6 class="preview-h6"' . $fonts['h6'] . '>The quick brown fox<br />jumps over the lazy dog.</h6>
						</div>
					</div>
					<div class="other-previews is-content">
						<p class="preview-label">H1 / Paragraph Combination</p>
						<h1 class="preview-h1"' . $fonts['h1'] . '>The quick brown fox<br />jumps over the lazy dog.</h1>
						<p class="preview-paragraph"' . $fonts['p'] . '>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.</p>
						<p class="preview-paragraph"' . $fonts['p'] . '>Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation X is on the runway heading towards a streamlined cloud solution. User generated content in real-time will have multiple touchpoints for offshoring.</p>
						<p class="preview-paragraph"' . $fonts['p'] . '>Capitalise on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital divide with additional clickthroughs from DevOps. Nanotechnology immersion along the information highway will close the loop on focusing solely on the bottom line.</p>
					</div>
				</div>
				<div class="typography-preview-custom"></div>
			';
		}

		// custom styles
		public function custom_styles($typography, $is_admin, $is_customize) {
			// define vars
			$output = '';
			// get breakpoints
			$breakpoints = semplice_get_breakpoints();
			// css attributes
			$css_attributes = array('color', 'text-transform', 'font-family', 'font-size', 'line-height', 'letter-spacing', 'text-decoration', 'text-decoration-color', 'background-color', 'text-stroke', 'padding', 'border-color', 'border-width', 'border-style');
			// has any custom styles?
			if(isset($typography['custom']) && is_array($typography['custom'])) {
				// iterate custom styles
				foreach ($typography['custom'] as $id => $style) {
					// css
					$css = '';
					// empty mobile css
					$mobile_css = array(
						'lg' => '',
						'md' => '',
						'sm' => '',
						'xs' => ''
					);
					// styles list
					$styles_list = $css_attributes;
					// element
					$element = 'span';
					if($style['custom_style_element'] == 'block') {
						$element = 'p';
					} else {
						// remove line-height from inline styles
						unset($styles_list[4]);
					}
					// start output
					$selector = '#customize #' . $id . ' ' . $element . ', #content-holder .' . $id;
					// search and replace
					$search = array('custom_style_', '_', '-lg', '-md', '-sm', '-xs');
					$replace = array('', '-', '', '', '', '');
					// iterate styles
					foreach ($style as $attribute => $value) {
						$css_attribute = str_replace($search, $replace, $attribute);
						if(in_array($css_attribute, $styles_list)) {
							// is mobile style
							$is_mobile = false;
							// mobile css
							foreach ($breakpoints as $breakpoint => $width) {
								if(strpos($attribute, '_' . $breakpoint) !== false) {
									$mobile_css[$breakpoint] .= $this->get_custom_style_css($css_attribute, $value, $style['custom_style_text_stroke_color']);
									$is_mobile = true;
								}
							}
							// regular css
							if(false === $is_mobile) {
								$css .= $this->get_custom_style_css($css_attribute, $value, $style['custom_style_text_stroke_color']);
							}
						}
					}
					// add regular css
					$output .= $selector . ' { ' . $css . ' }';
					// iterate breakpoints for mobile css
					foreach ($breakpoints as $breakpoint => $width) {
						if(!empty($mobile_css[$breakpoint])) {
							if(true === $is_admin) {
								$selector = '[data-breakpoint="' . $breakpoint . '"] #content-holder .' . $id;
								$output .= $selector . ' { ' . $mobile_css[$breakpoint] . ' }';
							} else {
								$output .= '@media screen' . $width['min'] . $width['max'] . ' { ' . $selector . ' { ' . $mobile_css[$breakpoint] . ' } }';
							}
						}
					}
				}
			}
			// return
			return $output;
		}

		// get custom style css
		public function get_custom_style_css($attribute, $value, $text_stroke_color) {
			// switch attribute
			switch($attribute) {
				case 'text-stroke':
					return '-webkit-text-stroke: ' . $value . ' ' . $text_stroke_color . ';';
				break;
				case 'font-family':
					return semplice_get_font_family($value);
				break;
				default:
					return $attribute . ':' . $value . ';';
			}
		}

		// mobile scaling
		public function mobile_scaling($typography, $is_admin) {
			// output start
			$output = '';

			// get typography settings
			$typography = json_decode(get_option('semplice_customize_typography'), true);

			// breakpoints
			$breakpoints = array(
				'lg' => '@media screen and (min-width: 992px) and (max-width: 1169.98px) { ',
				'md' => '@media screen and (min-width: 768px) and (max-width: 991.98px) { ',
				'sm' => '@media screen and (min-width: 544px) and (max-width: 767.98px) { ',
				'xs' => '@media screen and (max-width: 543.98px) { ',
			);

			// values
			$attributes = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p');

			// loop through
			foreach ($breakpoints as $breakpoint => $prefix) {

				// empty css
				$css = '';

				// is editor
				if($is_admin) {
					$attr_prefix = '[data-breakpoint="' . $breakpoint . '"] #content-holder ';
				} else {
					// prefix
					$attr_prefix = '#content-holder ';
				}

				// loop throught defaults
				foreach ($attributes as $attribute) {
					// check if user has a size set in typography
					if(isset($typography[$attribute . '_font_size_' . $breakpoint])) {
						$size = str_replace('rem', '', $typography[$attribute . '_font_size_' . $breakpoint]) * 18;
						// add to css
						$css .= $attr_prefix . $attribute . ' { font-size: ' . round($size / 18, 2) . 'rem;}';
					}
					// check if user has a line height set in typography, if not use semplice multiplier
					if(isset($typography[$attribute . '_line_height_' . $breakpoint])) {
						if($attribute == 'p') {
							$lh = $typography[$attribute . '_line_height_' . $breakpoint];
						} else {
							$lh = str_replace('rem', '', $typography[$attribute . '_line_height_' . $breakpoint]) * 18;
							$lh = round($lh / 18, 2) . 'rem';
						}
						// add to css
						$css .= $attr_prefix . $attribute . ' { line-height: ' . $lh . '; }';
					}
					// check if user has a letter spacing set in typography
					if(isset($typography[$attribute . '_letter_spacing_' . $breakpoint])) {
						$size = str_replace('rem', '', $typography[$attribute . '_letter_spacing_' . $breakpoint]) * 18;
						// add to css
						$css .= $attr_prefix . $attribute . ' { letter-spacing: ' . round($size / 18, 2) . 'rem;}';
					}
				}

				// output start
				if($is_admin) {
					$output .= $css;
				} else {
					$output .= $prefix . $css . '}';
				}
			}

			// return
			return $output;
		}
	}

	// instance
	admin_api::$customize['typography'] = new typography;
}

?>