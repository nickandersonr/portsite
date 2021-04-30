<?php

// -----------------------------------------
// semplice
// admin/editor/modules/lottie.php
// -----------------------------------------

if(!class_exists('sm_lottie')) {
	class sm_lottie {

		public $output;
		public $is_editor;

		// constructor
		public function __construct() {
			// define output
			$this->output = array(
				'html' => '',
				'css'  => '',
			);
			// set is editor
			$this->is_editor = true;
		}

		// output editor
		public function output_editor($values, $id) {
			
			// admin?
			if(true === $this->is_editor) {
				$this->output['html'] = '
					<div class="is-content semplice-lottie"><div id="' . $id . '_lottie" class="lottie-holder"></div></div>
					' . semplice_module_placeholder('lottie', false, false, $this->is_editor) . '
				';
			} else {
				// valid lottie
				$is_valid = false;
				// get content
				$content = $values['content']['xl'];
				// get lottie url
				if(isset($content['id'])) {
					$url = wp_get_attachment_url($content['id']);
					// has content + width and height defined?
					if(false !== $url && isset($content['width']) && isset($content['height'])) {
						$is_valid = true;
					}
				}
				// is valid lottie?
				if(true === $is_valid) {
					$this->output['html'] = '<div class="is-content semplice-lottie"><div id="' . $id . '_lottie" class="lottie-holder"></div></div>';
				} else {
					$this->output['html'] = semplice_module_placeholder('lottie', false, false, $this->is_editor);
				}
			}
			// output
			return $this->output;
		}

		// output frontend
		public function output_frontend($values, $id) {
			// same as editor
			$this->is_editor = false;
			return $this->output_editor($values, $id);
		}
	}

	// instance
	$this->module['lottie'] = new sm_lottie;
}