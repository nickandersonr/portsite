<?php

// -----------------------------------------
// semplice
// admin/editor/modules/beforeafter.php
// -----------------------------------------

if(!class_exists('sm_beforeafter')) {
	class sm_beforeafter {

		public $output;
		public $is_editor;

		// constructor
		public function __construct() {
			// define output
			$this->output = array(
				'html' => '',
				'css'  => '',
			);
			// is frontend
			$this->is_editor = true;
		}

		// output editor
		public function output_editor($values, $id) {
			// extract options
			extract( shortcode_atts(
				array(
					'before' 			=> '',
					'after'  			=> '',
					'start'	 			=> 50,
					'width'  			=> 3,
					'height'			=> 3,
					'stroke'			=> '#ffffff',
					'arrow_spacing'		=> 15,
					'arrow_width'		=> '0.8889rem',
					'direction'			=> 'horizontal',
				), $values['options'] )
			);

			// content
			$content = '';
			
			// before after
			$states = array('before', 'after');

			// bg color
			$bg_color = '#ffffff';
			if(isset($values['options']['background-color'])) {
				$bg_color = $values['options']['background-color'];
			}

			// stroke width
			$stroke_width = 3;
			if(isset($values['options']['stroke-width'])) {
				$stroke_width = $values['options']['stroke-width'];
			}

			// switch between editor and frontend
			if(true === $this->is_editor) {
				// get content
				foreach ($states as $state) {
					$image = false;
					if(isset($values['options'][$state])) {
						$image = $values['options'][$state];
					}
					$content .= semplice_get_ba_content($id, $state, $image);
				}
				// arrow direction
				$arrow = array('left', 'right');	
				if($direction == 'vertical') {
					$arrow = array('down', 'up');	
				}
				// output html
				$this->output['html'] = '
					<div class="before-after-editor is-content module-placeholder" data-ba-direction="' . $direction . '">
						' . $content . '
						<div class="ba-handle">
							<div class="ba-arrow" data-ba-arrow-direction="' . $arrow[0] . '">' . get_svg('frontend', 'icons/beforeafter_arrow') . '</div>
							<div class="ba-bar"></div>
							<div class="ba-arrow" data-ba-arrow-direction="' . $arrow[1] . '">' . get_svg('frontend', 'icons/beforeafter_arrow') . '</div>
						</div>
					</div>
				';
			} else {
				// get images
				if(!empty($before) && !empty($after)) {
					// before image
					$images['before'] = wp_get_attachment_image_src($before, 'full', false);
					// after
					$images['after'] = wp_get_attachment_image_src($after, 'full', false);
					// output
					$this->output['html'] = '
						<div id="' . $id . '-beforeafter" class="is-content">
							<img src="' . $images['before'][0] . '" data-label="Before" />
							<img src="' . $images['after'][0] . '" data-label="After" />
						</div>
						<script>
							(function($) {
								$(document).ready(function () {
									$("#' . $id . '-beforeafter").imagesLoaded( function() {
										$("#' . $id . '-beforeafter").twentytwenty({
											default_offset_pct: ' . ($start / 100) . ',
											orientation: "' . $direction . '",
											no_overlay: true,
											move_with_handle_only: false,
											click_to_move: true,
										});
									});
								});
							})(jQuery);
						</script>
					';
				} else {
					// no images
					$this->output['html'] = semplice_module_placeholder('beforeafter', 'Please make sure to add both the before and after image in the content editor.', false, false);
				}
			}

			// output css
			$this->output['css'] = '
				#' . $id . ' [data-ba-direction="horizontal"] .ba-bar, #' . $id . ' .twentytwenty-horizontal .ba-bar { width: ' . $width . 'px; background-color: ' . $bg_color . '; }
				#' . $id . ' [data-ba-direction="horizontal"] .ba-arrow svg path, #' . $id . ' .twentytwenty-horizontal .ba-arrow svg path { stroke-width: ' . $stroke_width . 'px; stroke: ' . $stroke . '; }
				#' . $id . ' [data-ba-direction="horizontal"] .ba-arrow, #' . $id . ' .twentytwenty-horizontal .ba-arrow { width: ' . $arrow_width . ';}
				#' . $id . ' [data-ba-direction="horizontal"] .ba-arrow svg, #' . $id . ' .twentytwenty-horizontal .ba-arrow svg { width: ' . $arrow_width . ';}
				#' . $id . ' [data-ba-direction="horizontal"] [data-ba-arrow-direction="left"], #' . $id . ' .twentytwenty-horizontal [data-ba-arrow-direction="left"] { margin-right: ' . $arrow_spacing . 'px; }
				#' . $id . ' [data-ba-direction="horizontal"] [data-ba-arrow-direction="right"], #' . $id . ' .twentytwenty-horizontal [data-ba-arrow-direction="right"] { margin-left: ' . $arrow_spacing . 'px; }
				#' . $id . ' [data-ba-direction="vertical"] .ba-bar, #' . $id . ' .twentytwenty-vertical .ba-bar { height: ' . $height . 'px; background-color: ' . $bg_color . '; }
				#' . $id . ' [data-ba-direction="vertical"] .ba-arrow svg path, #' . $id . ' .twentytwenty-vertical .ba-arrow svg path { stroke-width: ' . $stroke_width . 'px; stroke: ' . $stroke . '; }
				#' . $id . ' [data-ba-direction="vertical"] [data-ba-arrow-direction="down"], #' . $id . ' .twentytwenty-vertical [data-ba-arrow-direction="down"] { margin-bottom: ' . $arrow_spacing . 'px; }
				#' . $id . ' [data-ba-direction="vertical"] [data-ba-arrow-direction="up"], #' . $id . ' .twentytwenty-vertical [data-ba-arrow-direction="up"] { margin-top: ' . $arrow_spacing . 'px; }
				#' . $id . ' [data-ba-direction="vertical"] .ba-arrow, #' . $id . ' .twentytwenty-vertical .ba-arrow { width: ' . $arrow_width . ';}
				#' . $id . ' [data-ba-direction="vertical"] .ba-arrow svg, #' . $id . ' .twentytwenty-vertical .ba-arrow svg { width: ' . $arrow_width . ';}
			';
			

			// return
			return $this->output;
		}

		// output frtonend
		public function output_frontend($values, $id) {
			// set is frontend
			$this->is_editor = false;
			// same as editor
			return $this->output_editor($values, $id);
		}
	}
	// instance
	$this->module['beforeafter'] = new sm_beforeafter;
}