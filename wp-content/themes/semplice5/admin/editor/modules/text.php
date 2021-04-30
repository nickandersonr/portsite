<?php

// -----------------------------------------
// semplice
// admin/editor/modules/text.php
// -----------------------------------------

if(!class_exists('sm_text')) {
	class sm_text {

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

			// get content
			$content = $values['content']['xl'];
			

			// is still default?
			$this->output['html'] = '<div class="is-content wysiwyg-editor wysiwyg-edit" data-wysiwyg-id="' . $id . '">' . $content  . '</div>';

			// output
			return $this->output;
		}

		// output frontend
		public function output_frontend($values, $id) {

			// get content
			$content = $values['content']['xl'];
			
			// is still default?
			if($content == 'default') {
				$this->output['html'] = '
					<div class="is-content"><p>Hey there, this is the default text for a new paragraph. Feel free to edit this paragraph by double click on it. If you are dont with your editing just click on the \'Save\' button on the top right. Have Fun!
					</p></div>
				';
			} else {
				// add paragraph to content
				$this->output['html'] = '<div class="is-content' . semplice_has_animate_gradient($values['motions']) . '">' . $content . '</div>';
			}

			// output
			return $this->output;
		}
	}

	// instance
	$this->module['text'] = new sm_text;
}