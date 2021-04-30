<?php

// -----------------------------------------
// semplice
// admin/editor/modules/spacer/module.php
// -----------------------------------------

if(!class_exists('sm_spacer')) {
	class sm_spacer {

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
			
			// define styles
			$styles = '';

			// background-color
			if(isset($values['options']['background-color'])) {
				$styles .= '#content-holder #' . $id . ' .spacer { background-color: ' . $values['options']['background-color'] . '; }';
			}

			// height
			if(isset($values['options']['height'])) {
				$styles .= '#content-holder #' . $id . ' .spacer { height: ' . $values['options']['height'] . '; }';
			}

			// define output
			$this->output['css'] = $styles;
			$this->output['html'] = '
				<div class="spacer-container">
					<div class="is-content">
						<div class="spacer"><!-- horizontal spacer --></div>
					</div>
				</div>
			';

			// output
			return $this->output;
		}

		// output frontend
		public function output_frontend($values, $id) {
			// same as editor
			return $this->output_editor($values, $id);
		}
	}

	// instance
	$this->module['spacer'] = new sm_spacer;
}