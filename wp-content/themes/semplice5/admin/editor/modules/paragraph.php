<?php

// -----------------------------------------
// semplice
// admin/editor/modules/paragraph/module.php
// -----------------------------------------

if(!class_exists('sm_paragraph')) {
	class sm_paragraph {

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
				// define breakpoints
				$breakpoints = array('xl', 'lg', 'md', 'sm', 'xs');

				// vars
				$classes = '';
				$content = '';

				// has other content?
				foreach ($breakpoints as $breakpoint) {
					if(isset($values['content'][$breakpoint]) && !empty($values['content'][$breakpoint])) {
						if($breakpoint != 'xl') {
							$classes .= ' has-' . $breakpoint;
						}
						$content .= '<div data-content-for="' . $breakpoint . '">' . $values['content'][$breakpoint]  . '</div>';
					}
				}

				// add paragraph to content
				$this->output['html'] = '<div class="is-content' . $classes . semplice_has_animate_gradient($values['motions']) . '">' . $content . '</div>';
			}

			// output
			return $this->output;
		}
	}

	// instance
	$this->module['paragraph'] = new sm_paragraph;
}