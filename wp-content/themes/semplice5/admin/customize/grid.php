<?php

// -----------------------------------------
// semplice
// /admin/grid.php
// -----------------------------------------

if(!class_exists('grid')) {
	class grid {

		// constructor
		public function __construct() {}

		// output
		public function output() {

			// output
			$output = array();

			// ger recent values from the database
			$grid = json_decode(get_option('semplice_customize_grid'), true);

			// check if it is an grid array
			if(!is_array($grid) || empty($grid['grid_width'])) {
				$grid = array(
					'width'				=> '1170',
					'gutter'			=> '30',
				);
			}
			// output html
			$output['content'] = '
				<div id="grid-settings-grid" data-breakpoint="xl">
					<section class="content-block-grid">
						<div class="container grid-container">
							<div class="grid-row">
								<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
								<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
								<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
								<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
								<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
								<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
								<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
								<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
								<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
								<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
								<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
								<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
							</div>
						</div>
					</section>
				</div>
				<div class="grid-content" data-breakpoint="xl">
					<div class="container">
						<div class="row">
							<div class="grid-column" data-xl-width="4">
								<div class="content text"><img src="' . get_template_directory_uri() . '/assets/images/admin/grid_text.svg' . '" alt="grid-content"></div>
								<div class="content image"><img src="' . get_template_directory_uri() . '/assets/images/admin/grid_image.svg' . '" alt="grid-content"></div>
								<div class="content text"><img src="' . get_template_directory_uri() . '/assets/images/admin/grid_text.svg' . '" alt="grid-content"></div>
								<div class="content image"><img src="' . get_template_directory_uri() . '/assets/images/admin/grid_image.svg' . '" alt="grid-content"></div>
							</div>
							<div class="grid-column" data-xl-width="4">
								<div class="content image"><img src="' . get_template_directory_uri() . '/assets/images/admin/grid_image.svg' . '" alt="grid-content"></div>
								<div class="content text"><img src="' . get_template_directory_uri() . '/assets/images/admin/grid_text.svg' . '" alt="grid-content"></div>
								<div class="content image"><img src="' . get_template_directory_uri() . '/assets/images/admin/grid_image.svg' . '" alt="grid-content"></div>
								<div class="content text"><img src="' . get_template_directory_uri() . '/assets/images/admin/grid_text.svg' . '" alt="grid-content"></div>
							</div>
							<div class="grid-column" data-xl-width="4">
								<div class="content text"><img src="' . get_template_directory_uri() . '/assets/images/admin/grid_text.svg' . '" alt="grid-content"></div>
								<div class="content image"><img src="' . get_template_directory_uri() . '/assets/images/admin/grid_image.svg' . '" alt="grid-content"></div>
								<div class="content text"><img src="' . get_template_directory_uri() . '/assets/images/admin/grid_text.svg' . '" alt="grid-content"></div>
								<div class="content image"><img src="' . get_template_directory_uri() . '/assets/images/admin/grid_image.svg' . '" alt="grid-content"></div>
							</div>
						</div>
					</div>
				</div>
			';

			return $output;
		}
	}

	// instance
	admin_api::$customize['grid'] = new grid;
}

?>