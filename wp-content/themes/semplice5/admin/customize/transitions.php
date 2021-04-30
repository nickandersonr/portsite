<?php

// -----------------------------------------
// semplice
// /admin/transitions.php
// -----------------------------------------

if(!class_exists('transitions')) {
	class transitions {

		// constructor
		public function __construct() {}

		// output
		public function output() {
			// output air
			$output['content'] = 'output';

			return $output;
		}

		// loader css
		public function get_css() {
			// output
			$transitions_css = '';

			// get transition settings
			$transitions = json_decode(get_option('semplice_customize_transitions'), true);

			// check if options defined
			if(is_array($transitions) && isset($transitions['status']) && $transitions['status'] == 'enabled') {
				// extract values
				extract( shortcode_atts(
					array(
						'loader_bg_color'		=> '#ffffff',
						'loader_image'			=> '',
						'loader_width'			=> '6.666666666666667rem',
						'loader_animation'		=> 'pulsating',
					), $transitions)
				);
				// css for the transition preloader
				if(isset($transitions['optimize']) && $transitions['optimize'] == 'enabled') {
					// add to css
					$transitions_css .= '
						.transitions-preloader { background-color: ' . $loader_bg_color . '; }
						.transitions-preloader .loader-image img { width: ' . $loader_width . '; }
					';
					// pulsating
					if($loader_animation == 'pulsating') {
						$transitions_css .= '
							.transitions-preloader .loader-image img {
								animation-name: sliderPreloader;
								animation-duration: 1s;
								animation-iteration-count: infinite;
							}
						';
					}
				}
			}

			// output
			return $transitions_css;
		}
	}

	// instance
	admin_api::$customize['transitions'] = new transitions;
}

?>