<?php

// -----------------------------------------
// semplice
// admin/editor/module.php
// -----------------------------------------

if(!class_exists('module_api')) {
	class module_api {

		// public vars
		public $module;
		public $animate_api;
		public $detect;
		public $post_id;
		public $script_execution;

		public function __construct() {
			global $detect;
			$this->detect = $detect;

			// include animate api
			require get_template_directory() . '/admin/editor/animate.php';
		}

		// -----------------------------------------
		// generate html output while iterate through ram
		// -----------------------------------------

		public function generate_output($ram, $section_id, $section) {
	
			// assign public vars
			$this->post_id = isset($ram['post_id']) ? $ram['post_id'] : 0;
			$this->script_execution = isset($ram['script_execution']) ? $ram['script_execution'] : 'normal';

			// output
			$output = array(
				'html'	=> '',
				'css'	=> '',
				'motion'	=> array(
					'css' => '',
					'js'  => '',
				),
			);
			$custom_height = '';
			$css_classes = '';
			$section_class = 'content-block';
			$section_element = $section_id;
			$append_content = '';
			$section_content = '';

			// add section element to ram
			$ram['section_element'] = $section_element;

			// section height
			$ram['section_height'] = array(
				'mode' => 'dynamic',
				'height' => 'auto',
			);

			// check if section is in ram
			if(isset($ram[$section_id])) {

				// assign styles
				$styles = $ram[$section_id]['styles']['xl'];

				// css classes
				if(isset($ram[$section_id]['classes']) && !empty($ram[$section_id]['classes'])) {
					$css_classes = ' ' . $ram[$section_id]['classes'];
				}

				// section only module?
				if(isset($ram[$section_id]['type']) && $ram[$section_id]['type'] == 'section-module') {
					$css_classes .= ' section-module';
				}

				// section height
				if(isset($ram[$section_id]['layout']['data-height'])) {
					if($ram[$section_id]['layout']['data-height'] == 'fullscreen') {
						$ram['section_height'] = array(
							'mode' => 'fullscreen',
							'height' => 'auto',
						);
					} else if($ram[$section_id]['layout']['data-height'] == 'custom') {
						$ram['section_height'] = array(
							'mode' => 'custom',
							'height' => $ram[$section_id]['customHeight']['xl']['height'],
						);
						$output['css'] .= $this->generate_css('container', $ram[$section_id]['customHeight'], $section_id, false);
					}
				}

				// desktop visibility
				if(isset($ram[$section_id]['options']['desktop_visibility']) && $ram[$section_id]['options']['desktop_visibility'] == 'hidden' && $ram['visibility'] == 'frontend') {
					$output['css'] .= '@media screen and (min-width: 1170px) { #' . $section_id . ' { display: none !important; }}';
				}

				// get row content
				$row_content = $this->row_iterate($ram, $section);

				// add section content
				$section_content = '<div class="container">' . $row_content['html'] . '</div>';

				// cover
				if($section_id == 'cover') {
					// cover visibility
					$cover_visibility = isset($ram['cover_visibility']) ? $ram['cover_visibility'] : 'hidden';
					// add cover visibility to layout attributes
					$ram[$section_id]['layout']['data-cover'] = $cover_visibility;
					// set cover as section class
					$section_class = 'semplice-cover';
					// is cover empty?
					$first_key = key($section);
					if(isset($section['columns']) && empty($section['columns']) || isset($section[$first_key]['columns']) && empty($section[$first_key]['columns'])) {
						$section_class .= ' is-empty-cover';
					}
					// arrow atts
					$arrow_visibility = isset($styles['arrow_visibility']) ? $styles['arrow_visibility'] : 'visible';
					$arrow_cover = isset($styles['arrow_cover']) ? $styles['arrow_cover'] : false;
					$arrow_width = isset($styles['arrow_width']) ? $styles['arrow_width'] : '2.9444rem';
					// add width to css
					$output['css'] .= '#content-holder .semplice-cover .show-more svg, #content-holder .semplice-cover .show-more img { width: ' . $arrow_width . '; }';
					// is custom arrow?
					if(false !== $arrow_cover) {
						$arrow_image = '<img src="' . semplice_get_image($arrow_cover, 'full') . '" alt="custom-cover-arrow">';
					} else {
						$arrow_image = get_svg('frontend', '/icons/arrow_down');
						// add color css
						if(isset($styles['arrow_color'])) {
							$output['css'] .= '#content-holder .semplice-cover .show-more svg { fill: ' . $styles['arrow_color'] . '; }';
						}
					}
					// arrow output
					$append_content .= '<a class="show-more show-more-' . $arrow_visibility . ' semplice-event" data-event-type="helper" data-event="scrollToContent">' . $arrow_image . '</a>';
					// frontend only options
					if($ram['visibility'] == 'frontend') {
						// transparent navbar while in cover
						$output['css'] .= '.cover-transparent { background: rgba(0,0,0,0) !important; }';
						// start at top
						$output['css'] .= '#content-holder .sections { margin-top: 0px !important; }';
						// on the frontend, change the section element id to avoid problems in the coverslider and single page app motions
						$section_element = 'cover-' . $this->post_id;
					}
				}

				// get bg video or image on frontend
				if(isset($styles['background_type']) && $styles['background_type'] == 'vid') {
					// get fallback
					$output['css'] .= semplice_background_video_fallback($styles, $section_element, $ram['visibility']);
					// get video on frontend desktiop only
					$append_content .= semplice_background_video($styles, $ram['visibility'], true);
					// get cover effects for the frontend
					if($ram['visibility'] == 'frontend') {
						// get cover effects
						$ram[$section_id]['layout'] = $this->get_cover_effects($styles, $ram[$section_id]['layout']);
					}		
				} else if($section_id == 'cover' && $ram['visibility'] == 'frontend') {
					// get cover image
					$append_content .= '<div class="cover-image-wrapper fp-bg"' . $this->get_cover_image_atts($styles) . '><div class="cover-image"></div></div>';
					// get cover effects
					$ram[$section_id]['layout'] = $this->get_cover_effects($styles, $ram[$section_id]['layout']);
					// is tilt scale set?
					if(isset($styles['mousemove_effect']) && $styles['mousemove_effect'] == 'tilt') {
						// set default perspective
						if(!empty($styles['tilt_perspective'])) {
							$output['css'] .= '#' . $section_element . ' .semplice-cover-inner { transform: translateZ(0) perspective(' . $styles['tilt_perspective'] . 'px); }';
						}
						// image scale
						if(!empty($styles['tilt_scale'])) {
							$output['css'] .= '#' . $section_element . ' .cover-image-wrapper { transform: scale(' . ($styles['tilt_scale'] / 100) . ') !important; }';
						}
					}
					// cover img css
					$output['css'] .= $this->generate_css('cover', $ram[$section_id]['styles'], $section_element, false);
				}

				// masterblock
				$masterblock = '';
				if(isset($ram[$section_id]['masterblock']) && strpos($ram[$section_id]['masterblock'], 'master_') !== false) {
					$masterblock = ' data-delete-master="' . $ram[$section_id]['masterblock'] . '"';
				}

				// append cover or background video
				$section_content = $append_content . $section_content;

				// if cover, add cover inner wrapper
				if($section_id == 'cover') {
					$section_content = '<div class="semplice-cover-inner"' . $this->get_cover_effect_settings($styles) . '>' . $section_content . '</div>';
				}

				// section start
				$output['html'] = '
					<section id="' . $section_element . '" class="' . $section_class . $css_classes . '"' . $masterblock . ' ' . $this->get_attributes($ram[$section_id]['layout']) . '>
						' . $section_content . '
					</section>				
				';

				// section css styles (not on cover)
				if($section_id != 'cover' || $ram['visibility'] == 'editor') {
					$output['css'] .= $this->generate_css('section', $ram[$section_id]['styles'], $section_id, false);
				}				

				// section styles
				$output['css'] .= $row_content['css'];

				// get motion css / js
				$output = $this->animate_api->get_motion_output($output, $ram, $section_id, 'section', $this->post_id);

				// add motion css from rows
				$output['motion']['css'] .= $row_content['motion']['css'];

				// add motion js from rows
				$output['motion']['js'] .= $row_content['motion']['js'];
			}

			// output
			return $output;
		}

		// -----------------------------------------
		// get cover image atts
		// -----------------------------------------

		public function get_cover_image_atts($styles) {
			$image = '';
			$size = 'auto';
			if(!empty($styles['background-image'])) {
				// get background image
				if(!is_numeric($styles['background-image'])) {
					$image = semplice_get_external_image($styles['background-image']);
					$image = array($image['url'], $image['width'], $image['height']);
				} else {
					$image = wp_get_attachment_image_src($styles['background-image'], 'full');
				}
				if(!empty($styles['background-size']) && $styles['background-size'] == 'cover') {
					$size = 'cover';
				}
				// image
				$image = ' data-src="' . $image[0] . '" data-width="' . $image[1] . '" data-height="' . $image[2] . '" data-size="' . $size . '"';
			}
			// return
			return $image;
		}

		// -----------------------------------------
		// cover effects
		// -----------------------------------------

		public function get_cover_effects($styles, $layout) {
			// backwards compatibility for older effects structure. Check if effect is set, if not look if older effects are already set
			if(isset($styles['image_effect'])) {
				$layout['data-cover-effect'] = $styles['image_effect'];
			} else if(isset($styles['zoom']) && $styles['zoom'] == 'on') {
				$layout['data-cover-effect'] = 'zoom';
			} else if(isset($styles['parallax']) && $styles['parallax'] == 'on') {
				$layout['data-cover-effect'] = 'parallax';
			}
			// mouse move effects
			if(isset($styles['mousemove_effect'])) {
				$layout['data-cover-mousemove'] = $styles['mousemove_effect'];
			}
			// return
			return $layout;
		}

		// -----------------------------------------
		// get cover effect setting
		// -----------------------------------------

		public function get_cover_effect_settings($styles) {
			// output
			$output = array();
			// settings
			$settings = array('tilt_scale', 'tilt_max', 'tilt_perspective', 'displacement_map', 'displacement_type', 'displacement_dir', 'displacement_speed', 'displacement_sprite_x', 'displacement_sprite_y', 'displacement_filter_x', 'displacement_filter_y', 'displacement_max_growth', 'displacement_grow_speed');
			// iterate settings
			foreach ($settings as $setting) {
				if(isset($styles[$setting])) {
					if($setting == 'displacement_map') {
						$image = wp_get_attachment_image_src($styles[$setting], 'full');
						$output[$setting] = $image[0];
					} else {
						$output[$setting] = $styles[$setting];
					}
				}
			}
			// output
			return ' data-effect-settings=\'' . json_encode($output) . '\'';
		}

		// -----------------------------------------
		// row, iterate through columns
		// -----------------------------------------

		public function row_iterate($ram, $section) {

			// output
			$output = array(
				'html' => '',
				'column_html' => '',
				'css'  => '',
				'motion'	=> array(
					'css' => '',
					'js'  => '',
				),
			);

			// is old single row mode?
			if(isset($section['columns'])) {
				// iterate columns
				foreach($section['columns'] as $column_id => $column_content) {
					$output = $this->get_columns($output, $ram, $column_id, $column_content);
				}
				// add row to output
				$output['html'] = '<div id="' . $section['row_id'] . '" class="row">' . $output['column_html'] . '</div>';
			} else {
				foreach($section as $row_id => $columns) {
					// rest column html before iterate
					$output['column_html'] = '';
					// iterate columns
					foreach($columns['columns'] as $column_id => $column_content) {
						// column html
						$output = $this->get_columns($output, $ram, $column_id, $column_content);
					}
					// add row to output
					$output['html'] .= '<div id="' . $row_id . '" class="row">' . $output['column_html'] . '</div>';
				}
			}

			return $output;
		}

		// -----------------------------------------
		// get columns and iterate through them
		// -----------------------------------------

		public function get_columns($output, $ram, $column_id, $column_content) {
			// column html
			$columns_content = $this->column_iterate($ram, $column_id, $column_content);
			// add to html output
			$output['column_html'] .= $columns_content['html'];
			// add to css output
			$output['css'] .= $columns_content['css'];
			// motion css
			$output['motion']['css'] .= $columns_content['motion']['css'];
			// motion js
			$output['motion']['js'] .= $columns_content['motion']['js'];
			// return output
			return $output;
		}

		// -----------------------------------------
		// iterate through column contents
		// -----------------------------------------

		public function column_iterate($ram, $column_id, $column_content) {

			// output
			$output = array(
				'html' => '',
				'css'  => '',
				'motion'	=> array(
					'css' => '',
					'js'  => '',
				),
			);
			$content_html = '';
			$column_classes = '';

			// check if column id is in ram
			if(isset($ram[$column_id])) {

				// column css
				$output['css'] = $this->generate_css('column', $ram[$column_id]['styles'], $column_id, false);

				// motion css / js
				$output = $this->animate_api->get_motion_output($output, $ram, $column_id, 'column', $this->post_id);

				// get column content
				foreach($column_content as $content_id) {

					// look if content id is in ram
					if(isset($ram[$content_id])) {
						// set module file
						$module = get_template_directory() . '/admin/editor/modules/' . $ram[$content_id]['module'] . '.php';

						// add section element to ram content
						$ram[$content_id]['section_element'] = '#' . $ram['section_element'];

						// add fullscreen
						$ram[$content_id]['section_height'] = $ram['section_height'];

						// check if module exists
						if(file_exists($module)) {
							$values = array(
								'module_name'		=> $ram[$content_id]['module'],
								'content_id'  		=> $content_id,
								'content'	  		=> $ram[$content_id],
							);
							
							// get content
							$content = $this->content($values, $ram['visibility'], false);

							// add to html output
							$content_html .= $content['html'];

							// add module specific css
							$output['css'] .= $content['css'];

							// add to css output
							$output['css'] .= $this->generate_css('content', $ram[$content_id]['styles'], $content_id, $ram[$content_id]['module']);

							// motion css / js
							$output = $this->animate_api->get_motion_output($output, $ram, $content_id, 'content', $this->post_id);
						}				
					}
				}
				
				// css classes
				if(isset($ram[$column_id]['classes']) && !empty($ram[$column_id]['classes'])) {
					$column_classes .= ' ' . $ram[$column_id]['classes'];
				}

				// column type
				if(isset($ram[$column_id]['type']) && $ram[$column_id]['type'] == 'spacer') {
					$column_classes .= ' spacer-column';
				}

				// get bg video on frontend
				$styles = $ram[$column_id]['styles']['xl'];
				if(isset($styles['background_type']) && $styles['background_type'] == 'vid') {
					// define default
					$bg_video = '<div class="background-video"></div>';
					// get fallback
					$output['css'] .= semplice_background_video_fallback($styles, $column_id, $ram['visibility']);
					// get video on frontend desktiop only
					if($ram['visibility'] == 'frontend') {
						$bg_video = semplice_background_video($styles, $ram['visibility'], true);
					}
				} else {
					$bg_video = '';
				}

				// column start
				$output['html'] = '<div id="' . $column_id . '" class="column' . $column_classes . '" ';

				// column width
				foreach ($ram[$column_id]['width'] as $width => $value) {
					if(!empty($width)) {
						$output['html'] .= 'data-' . $width . '-width="' . $value . '" ';
					}
				}

				// column end
				$output['html'] .= $this->get_attributes($ram[$column_id]['layout']) . '>';

				// bg video
				$output['html'] .= $bg_video;

				// column edit head
				if($ram['visibility'] == 'editor') {
					$type = '';
					if(isset($ram[$column_id]['type']) && $ram[$column_id]['type'] == 'spacer') {
						$type = 'Spacer ';
					}
					$output['html'] .= $this->column_edit_head($column_id, $type);	
				}

				// content wrapper
				$output['html'] .= '
					<div class="content-wrapper">
						' . $content_html . '
					</div>
				';

				// column end
				$output['html'] .= '</div>';
			}

			return $output;
		}

		// -----------------------------------------
		// create content
		// -----------------------------------------

		public function content($values, $visibility, $is_duplicate) {

			// output
			$output = array(
				'html' => '',
				'css'  => ''
			);

			// atts
			$atts = array();

			// include module
			require_once get_template_directory() . '/admin/editor/modules/' . $values['module_name'] . '.php';

			// vars
			$css_classes = '';

			// public values to content
			$values['content']['post_id'] = isset($this->post_id) ? $this->post_id : 0;
			$values['content']['script_execution'] = isset($this->script_execution) ? $this->script_execution : 'normal';

			// visibility
			if($visibility == 'editor') {
				$module_content = $this->module[$values['module_name']]->output_editor($values['content'], $values['content_id']);
			} else {
				$module_content = $this->module[$values['module_name']]->output_frontend($values['content'], $values['content_id']);
			}

			// css
			if($module_content['css'] && !empty($module_content['css'])) {
				$output['css'] = $module_content['css'];
			}

			// get css if is duplicate
			if($is_duplicate) {
				$output['css'] .= $this->generate_css('content', $values['content']['styles'], $values['content_id'], $values['content']['module']);
			}

			// css classes
			if(isset($values['content']['classes']) && !empty($values['content']['classes'])) {
				$css_classes .= ' ' . $values['content']['classes'];
			}

			// add css classes for individual modules
			switch($values['module_name']) {
				case "advancedportfoliogrid":
					// get preset
					$preset = 'horizontal-fullscreen';
					if(isset($values['content']['options']['preset']) && !empty($values['content']['options']['preset'])) {
						$preset = $values['content']['options']['preset'];
					}
					$atts['data-apg-preset'] = $preset;
				break;
			}

			// generate output
			$output['html'] = '
				<div id="' . $values['content_id'] . '" class="column-content' . $css_classes . '" data-module="' . $values['module_name'] . '" ' . $this->get_attributes($atts) . '>
					' . $module_content['html'] . '
				</div>
			';

			// return output
			return $output;
		}

		// -----------------------------------------
		// column edit head
		// -----------------------------------------

		public function column_edit_head($column_id, $type) {
			return '
				<div class="column-edit-head">
					<a class="column-handle">' . get_svg('backend', '/icons/column_reorder') . '</a>
					<p>' . $type . 'Col</p>
				</div>
			';
		}

		// -----------------------------------------
		// generate data attributes
		// -----------------------------------------

		public function get_attributes($values) {

			// vars
			$attributes = '';

			foreach ($values as $attribute => $value) {
				if ((array) $value !== $value) {
					$attributes .= $attribute . '="' . $value . '" ';
				}	
			}

			return $attributes;
		}

		// -----------------------------------------
		// styles
		// -----------------------------------------

		public function generate_css($mode, $css, $content_id, $module) {

			// define output
			$output = '';

			// desktop
			if(!empty($css['xl'])) {
				$output .= '#content-holder ' . $this->container_styles($mode, $css['xl'], $content_id, $module, 'xl');
			}

			// get breakpoints
			$breakpoints = semplice_get_breakpoints();

			// iterate breakpoints
			foreach ($breakpoints as $breakpoint => $width) {
				if(!empty($css[$breakpoint])) {
					// desktop
					$output .= '@media screen' . $width['min'] . $width['max'] . ' { #content-holder ' . $this->container_styles($mode, $css[$breakpoint], $content_id, $module, $breakpoint) . '}';
				}
			}

			return $output;
		}

		// -----------------------------------------
		// module container styles
		// -----------------------------------------

		public function container_styles($mode, $styles, $id, $module, $breakpoint) {
			// element css open
			if($mode == 'container') {
				$css = '#' . $id . ' .container {';
			} else if($mode == 'branding') {
				$css = $id . ' {';
			} else if($mode == 'cover') {
				$css = '#' . $id . ' .cover-image {';
			} else {
				$css = '#' . $id . ' {';
			}

			// directions
			$directions = array('top', 'right', 'bottom', 'left');

			// branding specific
			if($mode != 'branding') {
				foreach ($directions as $direction) {
					if(isset($styles['padding-' . $direction])) {
						$css .= 'padding-' . $direction . ': ' . $styles['padding-' . $direction] . ';';
					}
					if(isset($styles['margin-' . $direction])) {
						$css .= 'margin-' . $direction . ': ' . $styles['margin-' . $direction] . ';';
					}
				}
			}

			if($mode != 'content') {
				// border width
				$css .= $this->get_border($styles);
			}

			// get bg image and attributes. for non xl only get image and position
			if($breakpoint != 'xl') {
				$css .= semplice_responsive_bg_img($styles);
			} else {
				$css .= semplice_get_bg_css($styles);
			}
			
			// height
			if(isset($styles['height'])) {
				$css .= 'height: ' . $styles['height'] . ';';
			}

			// opacity
			if(isset($styles['opacity'])) {
				$css .= 'opacity: ' . $styles['opacity'] . ';';
			}

			// z-index
			if(isset($styles['z-index'])) {
				$css .= 'z-index: ' . $styles['z-index'] . ';';
			}

			// blend mode
			if($mode == 'section' && isset($styles['mix-blend-mode'])) {
				$css .= 'mix-blend-mode: ' . $styles['mix-blend-mode'] . ';';
			}

			// order
			if(isset($styles['order'])) {
				$css .= 'order: ' . $styles['order'] . ';';
			}

			// element css close
			$css .= '}';

			// apply to is content
			if($mode == 'content') {
				$css .= '#content-holder #' . $id . ' .is-content {';
					// box sahdow
					if(isset($styles['box-shadow']) && $module != 'paragraph') {
						$css .= 'box-shadow: ' . $styles['box-shadow'] . ';';
					} else if(isset($styles['text-shadow']) && $module == 'paragraph' || isset($styles['text-shadow']) && $module == 'text') {
						// only show shadow if values are set
						if(strpos($styles['text-shadow'], '0rem 0rem 0rem') === false) {
							$css .= 'text-shadow: ' . $styles['text-shadow'] . ';';
						}
					}
					if($module != 'button') {
						$css .= $this->get_border($styles);
					}
				$css .= '}';
			}

			return $css;
		}

		// -----------------------------------------
		// get border
		// -----------------------------------------

		public function get_border($styles) {

			$css = '';

			if(isset($styles['border-width'])) {
				$css .= 'border-width: ' . $styles['border-width'] . ';';
			}

			// border style
			if(isset($styles['border-style'])) {
				$css .= 'border-style: ' . $styles['border-style'] . ';';
			}

			// border radius
			if(isset($styles['border-radius'])) {
				$css .= 'border-radius: ' . $styles['border-radius'] . ';';
			}

			// border color
			if(isset($styles['border-color'])) {
				$css .= 'border-color: ' . $styles['border-color'] . ';';
			}

			return $css;
		}
	}

	// instance
	$this->module_api = new module_api;
}

?>