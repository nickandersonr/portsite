<?php

// -----------------------------------------
// semplice
// includes/custom_css.php
// -----------------------------------------

class custom_css {

	// -----------------------------------------
	// grid 
	// -----------------------------------------

	public function grid($mode) {
		// get grid
		if($mode == 'editor') {
			return semplice_grid('editor');
		} else {
			return semplice_grid('frontend');
		}
	}

	// -----------------------------------------
	// webfonts
	// -----------------------------------------

	public function webfonts() {
		// get fonts
		return admin_api::$customize['webfonts']->get();
	}

	// -----------------------------------------
	// typography
	// -----------------------------------------

	public function typography($is_admin) {
		// get fonts
		return admin_api::$customize['typography']->get('css', $is_admin, false);
	}
	
	// -----------------------------------------
	// navigation
	// -----------------------------------------

	public function navigation() {
		// get fonts
		return admin_api::$customize['navigations']->get('css', false, false, false);
	}

	// -----------------------------------------
	// blog
	// -----------------------------------------

	public function blog($is_admin) {
		// get blog css
		return admin_api::$customize['blog']->get_css($is_admin);
	}

	// -----------------------------------------
	// transitions custom css
	// -----------------------------------------

	public function transitions($is_frontend) {
		// get css
		return admin_api::$customize['transitions']->get_css($is_frontend);
	}

	// -----------------------------------------
	// advanced custom css
	// -----------------------------------------

	public function advanced($is_frontend) {
		// get css
		return admin_api::$customize['advanced']->generate_css($is_frontend);
	}

	// -----------------------------------------
	// project nav css
	// -----------------------------------------

	public function projectnav($is_frontend) {
		// get css
		return semplice_project_nav_css($is_frontend);
	}
}

$semplice_custom_css = new custom_css;

?>