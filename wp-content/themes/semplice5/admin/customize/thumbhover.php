<?php

// -----------------------------------------
// semplice
// /admin/thumbhover.php
// -----------------------------------------

if(!class_exists('thumbhover')) {
	class thumbhover {

		// constructor
		public function __construct() {}

		// output
		public function output() {

			$output = array(
				'css' => '',
				'content' => '',
			);

			// global hover options
			$global_hover_options = json_decode(get_option('semplice_customize_thumbhover'), true);

			// get thumb hover global
			$output['css'] .= semplice_thumb_hover_css(false, $global_hover_options, true, '', false);

			// output air
			$output['content'] .= '
				<div id="project-1337" class="masonry-item thumb" data-xl-width="8">
					<div class="thumb-inner">
						<img src="https://assets.semplice.com/customize/thumb_hover_2.jpg" alt="thumbnail">
						' . semplice_thumb_hover_html($global_hover_options, 'noproject', true) . '
					</div>
				</div>
				<div id="project-1338" class="masonry-item thumb" data-xl-width="4">
					<div class="thumb-inner">
						<img src="https://assets.semplice.com/customize/thumb_hover_1.jpg" alt="thumbnail">
						' . semplice_thumb_hover_html($global_hover_options, 'noproject', true) . '
					</div>
				</div>
			';

			return $output;
		}

		// generate css
		public function generate_sp_css($is_frontend) {
			// global thumb hover
			$thumb_hover = json_decode(get_option('semplice_customize_thumbhover'), true);
			return semplice_thumb_hover_css(false, $thumb_hover, true, '#content-holder [data-module="singleproject"]', false);
		}
	}

	// instance
	admin_api::$customize['thumbhover'] = new thumbhover;
}

?>