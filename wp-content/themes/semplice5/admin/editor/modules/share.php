<?php

// -----------------------------------------
// semplice
// admin/editor/modules/share.php
// -----------------------------------------

if(!class_exists('sm_share')) {
	class sm_share {

		public $output;

		// constructor
		public function __construct() {
			// define output
			$this->output = array(
				'html' => '',
				'css'  => '',
			);
		}

		// output frontend
		public function output_editor($values, $id) {

			// output
			$this->output['html'] = semplice_share_box_html($values['options'], $values['post_id']);

			// css output
			$this->output['css'] = semplice_share_box_css($values['options'], $id);

			// output
			return $this->output;
		}

		// output frontend
		public function output_frontend($values, $id) {

			// save as editor
			return $this->output_editor($values, $id);
		}
	}

	// instance
	$this->module['share'] = new sm_share;
}