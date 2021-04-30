<?php

// -----------------------------------------
// semplice
// admin/editor/modules/code.php
// -----------------------------------------

if(!class_exists('sm_code')) {
	class sm_code {

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

			$this->output['html'] = semplice_module_placeholder('code', false, false, true);

			// output
			return $this->output;
		}

		// output frontend
		public function output_frontend($values, $id) {

			// values
			extract( shortcode_atts(
				array(
					'is_video' 	    		=> 'no',
					'is_shortcode'			=> 'no',
				), $values['options'] )
			);

			// get content
			$content = $values['content']['xl'];

			// is shortcode?
			if($is_shortcode == 'yes') {
				$content = do_shortcode($content);
			}

			// is video?
			if($is_video == 'yes') {
				$content = '<div class="responsive-video">' . $content . '</div>';
			}

			$this->output['html'] = '
				<div class="is-content ce-code">
					' . $content . '
				</div>
			';

			// output
			return $this->output;
		}
	}

	// instance
	$this->module['code'] = new sm_code;
}