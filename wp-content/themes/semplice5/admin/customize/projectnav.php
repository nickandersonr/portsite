<?php

// -----------------------------------------
// semplice
// /admin/projectnav.php
// -----------------------------------------

if(!class_exists('projectnav')) {
	class projectnav {

		// constructor
		public function __construct() {}

		// output
		public function output() {

			return array(
				'css' => semplice_project_nav_css(false),
				'content' => semplice_project_nav_html('nextprev', false, false) . semplice_project_nav_html('projectpanel', false, false),
			);
		}
	}

	// instance
	admin_api::$customize['projectnav'] = new projectnav;
}

?>