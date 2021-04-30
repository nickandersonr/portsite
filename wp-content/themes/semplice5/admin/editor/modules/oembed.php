<?php

// -----------------------------------------
// semplice
// admin/editor/modules/oembed/module.php
// -----------------------------------------

if(!class_exists('sm_oembed')) {
	class sm_oembed {

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
			
			// add placeholder
			$this->output['html'] = semplice_module_placeholder('oembed', false, false, true);

			// output
			return $this->output;
		}

		// output frontend
		public function output_frontend($values, $id) {
			
			// values
			extract( shortcode_atts(
				array(
					'type'	=> 'video',
					'ratio'  => '',
				), $values['options'] )
			);

			// define output
			$padding = '';
			
			// get content
			$content = wp_oembed_get($values['content']['xl']);

			// is empty?
			if(!empty($content) && false !== $content) {
				// aspect ratio if video
				if($type == 'video') {
					// has custom aspect ratio
					if(!empty($ratio)) {
						// eleminate any spaces
						$ratio = str_replace(' ', '', $ratio);
						// make array
						$ratio = explode(':', $ratio);
						// padding
						$padding = ' style="padding-bottom: ' . ($ratio[1] / $ratio[0] * 100) . '%"';
					}

					$this->output['html'] = '<div class="is-content"><div class="responsive-video"' . $padding . '>' . $content . '</div></div>';
				} else {
					$this->output['html'] = '<div class="is-content">' . $content . '</div>';
				}
			} else {
				$this->output['html'] = semplice_module_placeholder('oembed', false, false, false);
			}

			// output
			return $this->output;
		}
	}

	// instance
	$this->module['oembed'] = new sm_oembed;
}