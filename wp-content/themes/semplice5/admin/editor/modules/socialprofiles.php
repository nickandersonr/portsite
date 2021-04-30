<?php

// -----------------------------------------
// semplice
// admin/editor/modules/socialprofiles.php
// -----------------------------------------

if(!class_exists('sm_socialprofiles')) {
	class sm_socialprofiles {

		public $output;
		public $is_editor;

		// constructor
		public function __construct() {
			// define output
			$this->output = array(
				'html' => '',
				'css'  => '',
			);
			// is frontend
			$this->is_editor = true;
		}

		// output editor
		public function output_editor($values, $id) {
			
			// extract options
			extract( shortcode_atts(
				array(
					'order'				=> '',
					'profiles'			=> '',
					'distributed'		=> 'default',
					'align'				=> 'center',
					'icon_color'		=> '#000000',
					'icon_scale'		=> '1.4444rem',
					'icon_padding'		=> '0.5556rem'
				), $values['options'])
			);

			// output
			$output = array(
				'html' => '',
				'css' => ''
			);

			// iterate order
			if(is_array($order) && !empty($order)) {
				foreach ($order as $index => $profile) {
					// get username
					$username = 'semplicelabs';
					$color = 'default';
					if(is_array($profiles) && isset($profiles[$profile])) {
						if(isset($profiles[$profile]['username'])) {
							$username = $profiles[$profile]['username'];
						}
						if(isset($profiles[$profile]['color']) && $profiles[$profile]['color'] != 'default' && $profiles[$profile]['color'] != 'transparent') {
							$color = $profiles[$profile]['color'];
							$output['css'] .= '#content-holder #' . $id . ' .socialprofiles .social-profile-' . $profile . ' a svg path { fill: ' . $color . '; }';
						}
						if(isset($profiles[$profile]['hoverColor']) && $profiles[$profile]['hoverColor'] != 'default' && $profiles[$profile]['hoverColor'] != 'transparent') {
							$hoverColor = $profiles[$profile]['hoverColor'];
							$output['css'] .= '.is-frontend #content-holder #' . $id . ' .socialprofiles .social-profile-' . $profile . ' a:hover svg path { fill: ' . $hoverColor . ' !important; }';
						}
					}
					$output['html'] .= '<li class="social-profile social-profile-' . $profile . '"><a href="' . $this->get_link($profile, $username) . '" target="_blank">' . get_svg('frontend', '/social-profiles/' . $profile) . '</a></li>';
				}
			} else {
				$output['html'] .= '<li class="empty">No social profiles added yet!</li>';
			}

			// prefix
			$prefix = '#content-holder #' . $id . ' .socialprofiles ';
			
			// default hover
			$output['css'] .= $prefix . ' .social-profile a:hover svg path { fill: #000000; }'; 

			// css attributes
			$attributes = array(
				'icon_color' 			=> array('.social-profile svg path', 'fill'),
				'icon_color_hover'		=> array('.social-profile a:hover svg path', 'fill'),
				'icon_scale'			=> array('.social-profile svg', 'height'),
				'icon_padding'			=> array('.social-profile a', 'padding'),
			);

			// iterate $values
			if(!empty($values['options'])) {
				foreach ($values['options'] as $option => $value) {
					// is option in attributes?
					if(isset($attributes[$option]) && !empty($value)) {
						// is padding?
						if($option == 'icon_padding') {
							$output['css'] .= $prefix . '{ margin: 0 -' . $value . '; }'; 
							$value = '0 ' . $value;
						}
						$output['css'] .= $prefix . $attributes[$option][0] . ' { ' . $attributes[$option][1] . ': ' . $value . '; }'; 
					}
				}
				// get css
				$output['css'] .= $this->get_breakpoints_css($values['options'], $attributes, $prefix, $id);
			}

			// define output
			$this->output['css'] = $output['css'];
			$this->output['html'] = '
				<div class="socialprofiles is-content" data-distributed="' . $distributed . '" data-align="' . $align . '">
					<div class="inner">
						<ul>
							' . $output['html'] . '
						</ul>
					</div>
				</div>
			';

			// output
			return $this->output;
		}

		// output frontend
		public function output_frontend($values, $id) {
			// set is frontend
			$this->is_editor = false;
			// same as editor
			return $this->output_editor($values, $id);
		}

		public function get_breakpoints_css($options, $attributes, $prefix, $id) {
			// css
			$css = '';
			// breakpoints
			$breakpoints = semplice_get_breakpoints();
			// iterate breakpoints
			foreach ($breakpoints as $breakpoint => $width) {
				// iterate atts for this breakpoint
				$breakpoint_css = '';
				// change prefix for editor
				if(true === $this->is_editor) {
					$prefix = '[data-breakpoint="' . $breakpoint . '"] ' . $prefix;
				}
				foreach ($options as $option => $value) {
					if($breakpoint != 'xl' && isset($options[$option . '_' . $breakpoint])) {
						$value = $options[$option . '_' . $breakpoint];
					}
					// is option in attributes?
					if(isset($attributes[$option]) && !empty($value)) {
						// is padding?
						if($option == 'icon_padding') {
							$breakpoint_css .= $prefix . '{ margin: 0 -' . $value . '; }'; 
							$value = '0 ' . $value;
						}
						$breakpoint_css .= $prefix . $attributes[$option][0] . ' { ' . $attributes[$option][1] . ': ' . $value . '; }'; 
					}
				}
				// only add breakpoint if css is not empty
				if(!empty($breakpoint_css)) {
					// breakpoint open
					if(false === $this->is_editor) {
						$css .= '@media screen' . $width['min'] . $width['max'] . ' { ' . $breakpoint_css . ' }';	
					} else {
						$css .= $breakpoint_css;
					}
				}
			}
			// ret
			return $css;
		}

		// get link
		public function get_link($profile, $username) {
			$profiles = semplice_get_social_profiles();
			// get link
			$link = $profiles[$profile]['url'] . $username;
			// exceptions
			if($profile == 'tumblr') {
				$link = 'https://' . $username . '.tumblr.com';
			} else if($profile == 'linkedin') {
				$link = $username;
			} else if($profile == 'youtube') {
				// is new format?
				if(strpos($username, 'youtube.com') !== false) {
					$link = $username;
				}
			}
			// return
			return $link;
		}
	}

	// instance
	$this->module['socialprofiles'] = new sm_socialprofiles;
}