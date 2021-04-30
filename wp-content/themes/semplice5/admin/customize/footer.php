<?php

// -----------------------------------------
// semplice
// /admin/footer.php
// -----------------------------------------

if(!class_exists('footer')) {
	class footer {

		// constructor
		public function __construct() {}

		// output
		public function output() {
			// output
			$output = array();
			// get footers
			$request = array(
				'post_type'		  => 'footer',
				'page'			  => 'show_all',
				'hide_row_header' => true,
			);
			// get posts
			$output['content'] = semplice_get_posts($request);
			// return
			return $output;
		}
	}

	// instance
	admin_api::$customize['footer'] = new footer;
}

?>