<?php

// -----------------------------------------
// semplice
// admin/editor/modules/button/module.php
// -----------------------------------------

if(!class_exists('sm_button')) {

	class sm_button {

		public $output;

		// constructor
		public function __construct() {
			// define output
			$this->output = array(
				'html' => '',
				'css'  => '',
			);
		}

		// output editor
		public function output_editor($values, $id) {

			// editor output
			return $this->general_output($values, $id, 'editor');
		}

		// output frontend
		public function output_frontend($values, $id) {

			// frontend output
			return $this->general_output($values, $id, 'frontend');
		}

		public function general_output($values, $id, $mode) {

			// get label
			$label = $values['content']['xl'];
			$content_styles = $values['styles']['xl'];
			$css = '';

			// extract options
			extract( shortcode_atts(
				array(
					'label'						=> 'Semplice Button',
					'font_family'				=> 'font-family',
					'align' 					=> 'center',
					'width'						=> 'auto',
					'link'						=> 'https://www.semplice.com',
					'link_target'				=> '_blank',
					'link_type'					=> 'url',
					'link_page'					=> '',
					'link_project'				=> '',
					'link_post'					=> '',
					'hover-color'				=> '#000000',
					'hover-background-color'	=> '#ffe152',
					'hover-border-color'		=> 'transparent',
					'hover-letter-spacing'		=> '0px',
					'box_shadow_opacity'		=> 100,
				), $values['options'] )
			);

			// add default label if empty
			if(empty($label)) {
				$label = 'Semplice Button';
			}

			// font family
			if(!empty($font_family)) {
				$font_family = ' data-font="' . $font_family . '"';
			}

			// css atts
			$css_atts = array(
				'parent' => array('background-color', 'border-width', 'border-radius', 'border-color'),
				'child'  => array('font-size', 'color', 'letter-spacing', 'border-radius', 'color', 'padding-bottom', 'padding-left', 'padding-right', 'padding-top'),
			);

			// define inline css output
			$normal_css = array('parent' => '', 'child' => '');
			$hover_css = array('parent' => '', 'child' => '');

			foreach ($css_atts as $type => $attributes) {
				foreach ($values['options'] as $attribute => $value) {
					if(in_array($attribute, $css_atts[$type])) {
						$normal_css[$type] .= $attribute . ': ' . $value . ';';
						// if letter spacing add negative margin
						if($attribute == 'letter-spacing' && $mode == 'frontend') {
							if(strpos($value, '-') === false) {
								$normal_css[$type] .= 'margin-right: -' . $value . ';'; 
							} else {
								$normal_css[$type] .= 'margin-right: ' . str_replace('-', '', $value) . ';'; 
							}
							
						}
					} else if(strpos($attribute, 'hover') !== false && in_array(str_replace('hover-', '', $attribute), $css_atts[$type]) || $attribute == 'color') {
						$hover_css[$type] .= str_replace('hover-', '', $attribute) . ': ' . $value . ' !important;'; 
						// if letter spacing add negative margin
						if($attribute == 'hover-letter-spacing' && $type == 'child' && $mode == 'frontend') {
							if(strpos($value, '-') === false) {
								$hover_css[$type] .= 'margin-right: -' . $value . ';'; 
							} else {

								$hover_css[$type] .= 'margin-right: ' . str_replace('-', '', $value) . ';'; 
							}
						}
					}
				}
			}

			// output css
			$css .= '
				#content-holder #' . $id . ' .is-content {' . $normal_css['parent'] . '}
				#content-holder #' . $id . ' .is-content:hover {' . $hover_css['parent'] . '}
				#content-holder #' . $id . ' .is-content a{' . $normal_css['child'] . '}
				#content-holder #' . $id . ' .is-content:hover a {' . $hover_css['child'] . '}
			';

			// drop shadow?
			if(isset($content_styles['box-shadow']) && !empty($content_styles['box-shadow'])) {
				// get existing box shadow without rgba
				$box_shadow = explode(",", $content_styles['box-shadow']);
				// change opacity
				$box_shadow = $box_shadow[0] . ',' . $box_shadow[1] . ',' . $box_shadow[2] . ',' . $box_shadow_opacity / 100 . ')';
				// get opacity
				$css .= '.is-frontend #content-holder #' . $id . ' .is-content:hover { box-shadow: ' . $box_shadow . '; }';
			}

			// $link array
			$link = array(
				'type'		=> $link_type,
				'url'		=> $link,
				'page'		=> $link_page,
				'project'	=> $link_project,
				'post'		=> $link_post, 
			);

			// only display link on e ditor
			if($mode == 'frontend') {
				// set prefix to false
				$link_prefix = false;
				// check link type
				if($link['type'] == 'url' || $link['type'] == 'email') {
					// check if its an email
					if(filter_var($link['url'], FILTER_VALIDATE_EMAIL)) {
						$link_prefix = 'mailto:';
					}
					// assign url
					$link = $link['url'];
				} else {
					if(!empty($link[$link['type']])) {
						$link = get_permalink($link[$link_type]);
					} else {
						$link = get_home_url();
					}
				}
				// link target
				if($link_target == 'same') {
					$link_target = '_self';
				} else {
					$link_target = '_blank';
				}
				// link
				$link = 'href="' . $link_prefix . $link . '" target="' . $link_target . '"';
			} else {
				$link = '';
			}

			// is still default?
			$this->output['html'] = '
				<div class="ce-button" data-align="' . $align . '">
					<div class="is-content" data-width="' . $width . '">
						<a ' . $font_family . ' ' . $link . '>' . $label . '</a>
					</div>
				</div>
			';

			// 
			$this->output['css'] = $css;

			// output
			return $this->output;
		}
	}

	// instance
	$this->module['button'] = new sm_button;
}