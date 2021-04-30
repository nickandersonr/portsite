<?php

// -----------------------------------------
// semplice
// admin/editor/modules/code.php
// -----------------------------------------

if(!class_exists('sm_advancedportfoliogrid')) {
	class sm_advancedportfoliogrid {

		public $output;
		public $is_editor;
		public $detect;

		// constructor
		public function __construct() {
			// define output
			$this->output = array(
				'html' => '',
				'css'  => '',
			);
			// set is editor
			$this->is_editor = true;
			// mobile detect
			global $detect;
			$this->detect = $detect;
		}

		// output frontend
		public function output_editor($values, $id) {

			// get grid
			$this->output = $this->get($values, $id);

			// output
			return $this->output;
		}

		// output frontend
		public function output_frontend($values, $id) {

			// set editor to false
			$this->is_editor = false;
			// get grid
			$this->output = $this->get($values, $id);

			// output
			return $this->output;
		}

		// get grid
		public function get($content, $id) {

			// output
			$output = array(
				'html' => '',
				'css'  => '',
			);

			// status
			$has_posts = true;

			// preset set?
			$preset = 'horizontal-fullscreen';
			if(isset($content['options']['preset']) && !empty($content['options']['preset'])) {
				$preset = $content['options']['preset'];
			}

			// are there posts?
			if(isset($content['options']['order']) && !empty($content['options']['order']) && is_array($content['options']['order'])) {
				// get posts
				$posts = semplice_get_apg_posts('content', $content['options']['order']);
				// grids
				switch($preset) {
					case 'horizontal-fullscreen':
						$output = $this->horizontal_fullscreen($content, $posts, $id);
					break;
					case 'text':
						$output = $this->text($content, $posts, $id);
					break;
					case 'splitscreen':
						$output = $this->splitscreen($content, $posts, $id);
					break;
				}
			} else {
				$output['html'] = '
					<div class="empty-apg">
						' . get_svg('backend', 'icons/module_advancedportfoliogrid') . '
						<h3>Your grid is empty!<br />Start adding content to your grid.</h3>
						<a class="semplice-button apg-add-content" data-content-id="' . $id . '">Add pages / projects</a>
					</div>
				';
				// set status to false
				$has_posts = false;
				// set posts
				$posts = false;
			}

			return array(
				'html' 			=> $output['html'],
				'css' 			=> $output['css'],
				'hasProjects' 	=> $has_posts,
				'preset' 		=> $preset,
			);
		}

		// basic grid
		public function horizontal_fullscreen($content, $posts, $id) {

			// output
			$output = array(
				'html' => '',
				'css'  => '',
			);

			// section element
			$section_element = '';
			// is normal loadout?
			if(isset($content['section_element'])) {
				$section_element = $content['section_element'];
			}

			// attributes
			extract(shortcode_atts(
				array(
					'hor_full_width'				=> '6',
					'hor_full_width_lg'				=> '6',
					'hor_full_width_md'				=> '6',
					'hor_full_width_sm'				=> '12',
					'hor_full_width_xs'				=> '12',
					'hor_full_object_fit'			=> 'cover',
					'hor_full_object_position'		=> 'top-center',
					'hor_full_bg_even'				=> '#000000',
					'hor_full_bg_odd'				=> '#cccccc',
					'hor_full_transition'			=> 'disabled',
					'hor_full_title_position'		=> 'bottom-center',
					'hor_full_title_visibility'		=> 'both',
					'hor_full_title_padding'		=> '4rem',
					'hor_full_title_offset'			=> '0rem',
					'hor_full_title_color'			=> 'white',
					'hor_full_title_font_family'	=> 'bold',
					'hor_full_title_fontsize'		=> '2.333333333333333rem',
					'hor_full_title_letter_spacing'	=> '0rem',
					'hor_full_title_line_height'	=> '100',
					'hor_full_title_text_transform' => 'none',
					'hor_full_type_color'			=> 'white',
					'hor_full_type_font_family'		=> 'regúlar',
					'hor_full_type_fontsize'		=> '1.111111111111111‬rem',
					'hor_full_type_text_transform' 	=> 'none',
					'hor_full_type_padding_top'		=> '0.5555555555555556rem',
					'hor_full_arrow_visibility'		=> 'visible',
					'hor_full_arrow'				=> 'default',
					'hor_full_arrow_custom'			=> false,
					'hor_full_arrow_size'			=> 'small',
					'hor_full_arrow_color'			=> '#ffffff',
					'hor_full_arrow_bg_color'		=> '#000000',
					'hor_full_arrow_bg_opacity'		=> 0,
					'hor_full_hover'				=> 'scale-opacity',
					'hor_full_hover_so_opacity'		=> 40,
					'hor_full_hover_so_scale'		=> 7,
					'hor_full_hover_dimdown_opacity'=> 40,
					'hor_full_hover_border_width'	=> '0.8333333333333333rem',
					'hor_full_hover_border_color'	=> '#ffffff',
					'hor_full_hover_title_fade'		=> 'none',
					'hor_full_attraction'			=> '0.025',
					'hor_full_friction'				=> '0.28',
				), $content['options'] )
			);

			// group cells
			$group_cells = array(
				'6' => 2,
				'4' => 3,
			);

			// custom transition
			if($hor_full_transition == 'enabled') {
				$custom_transition = ' data-custom-transition="horizontal-fullscreen"';
			} else {
				$custom_transition = '';
			}

			// create apg wrapper
			$output['html'] .= '<div class="apg apg-hor-full" data-object-fit="' . $hor_full_object_fit . '" data-title-visibility="' . $hor_full_title_visibility . '" data-arrow-visibility="' . $hor_full_arrow_visibility . '" data-arrow-size="' . $hor_full_arrow_size . '" data-mouseover="' . $hor_full_hover . '">';

			// css open (even odd needs to be defined earlier to be able to get overwritten without important statement)
			$selector = '#' . $id . ' .apg-hor-full';
			$output['css'] .= $selector . ' .even { background-color: ' . $hor_full_bg_even . '; }' . $selector . ' .odd { background-color: ' . $hor_full_bg_odd . '; }';

			// remove hover on mobile
			if(true === $this->detect->isMobile()) {
				$hor_full_hover = 'none';
				$hor_full_hover_title_fade = 'none';
			}

			// iterate projects
			foreach ($posts as $key => $post) {
				// bg color class
				$bg_color_class = 'odd';
				// is even?
				if ($key % 2 == 0) {
					$bg_color_class = 'even';
				}
				// options
				$values = $this->get_custom_options($post['post_id'], $post['thumbnail']['src'], $content['options']);
				// project type
				$project_type = '';
				if($post['post_type'] == 'project') {
					$project_type = '<div class="type" data-font="' . $hor_full_type_font_family . '">' . $post['project_type'] . '</div>';
				}
				// output
				$output['html'] .= '
					<div class="post-' . $post['post_id'] . ' apg-post apg-post-hor-full carousel-cell ' . $bg_color_class . $values['custom_class'] . '" data-xl-width="' . $hor_full_width . '" data-lg-width="' . $hor_full_width_lg . '" data-md-width="' . $hor_full_width_md . '" data-sm-width="' . $hor_full_width_sm . '" data-xs-width="' . $hor_full_width_xs . '" data-apg-object-position="' . $hor_full_object_position . '">
						' . $this->set_custom_styles($id, 'hor-full', $post, $values) . '
						<a class="apg-link" href="' . $post['permalink'] . '"' . $custom_transition . ' data-transition-element="transition_' . substr(md5(rand()), 0, 9) . '"></a>
						<div class="apg-grid-item">
							<div class="post-thumbnail" data-scale="' . $hor_full_hover_so_scale . '">
								' . $this->get_thumbnail($values['thumbnail'], 'hor-full', $id, $post) . '
							</div>
							<div class="apg-post-title ' . $hor_full_hover_title_fade . '" data-title-align="' . $hor_full_title_position . '">
								<div class="title" data-font="' . $hor_full_title_font_family . '">' . $post['post_title'] . '</div>
								' . $project_type . '
							</div>
						</div>
					</div>
				';

				// css output for background color
				if(isset($values['background-color']) && false !== $values['background-color']) {
					$output['css'] .= $selector . ' .post-' . $post['post_id'] . ' { background-color: ' . $values['background-color'] . '; }';
				}
			}

			// arrows
			$default_arrows = array(
				'default'	  => 'M95.849,46.323H14.1L40.364,20.15a4.166,4.166,0,0,0-5.9-5.881L1.076,47.537a4.162,4.162,0,0,0,0,5.891L34.462,86.7a4.166,4.166,0,0,0,5.9-5.881L14.1,54.642H95.849A4.159,4.159,0,1,0,95.849,46.323Z',
				'alternative' => 'M67.37,100L28.195,50,67.37,0,71.8,5.5,37.581,50,71.8,94.5Z',
			);
			if($hor_full_arrow == 'custom') {
				if(!empty($hor_full_arrow_custom)) {
					$arrow = htmlentities($hor_full_arrow_custom);	
				} else {
					$arrow = $default_arrows['default'];
				}
			} else {
				$arrow = $default_arrows[$hor_full_arrow];
			}

			// arrow color
			if($hor_full_arrow_bg_color != 'transparent') {
				$arrow_bg_color = semplice_hex_to_rgb($hor_full_arrow_bg_color);
				$arrow_bg_color = 'rgba(' . $arrow_bg_color['r'] . ', ' . $arrow_bg_color['g'] . ', ' . $arrow_bg_color['b'] . ', ' . ($hor_full_arrow_bg_opacity / 100) . ')';
			} else {
				$arrow_bg_color = 'transparent';
			}

			// css
			$output['css'] .= '
				' . $section_element . ' .row, ' . $section_element . ' .row .column { height: 100% !important; } ' . $section_element . ' .column-content { height: 100vh; }
				' . $selector . ' .apg-post .apg-post-title, #apg-transition-' . $id . ' .apg-grid-item .apg-post-title { padding: ' . $hor_full_title_padding . '; margin: ' . $hor_full_title_offset . ' 0; }
				' . $selector . ' .apg-post .apg-post-title .title, #apg-transition-' . $id . ' .apg-grid-item .apg-post-title .title { font-size: ' . $hor_full_title_fontsize . '; color: ' . $hor_full_title_color . '; text-transform: ' . $hor_full_title_text_transform . '; letter-spacing: ' . $hor_full_title_letter_spacing . '; line-height: ' . $hor_full_title_line_height . '%;}
				' . $selector . ' .apg-post .apg-post-title .type, #apg-transition-' . $id . ' .apg-grid-item .apg-post-title .type { font-size: ' . $hor_full_type_fontsize . '; color: ' . $hor_full_type_color . '; text-transform: ' . $hor_full_type_text_transform . '; padding-top: ' . $hor_full_type_padding_top . ';}
				' . $selector . ' .flickity-button-icon path { fill: ' . $hor_full_arrow_color . ';}
				' . $selector . ' .flickity-prev-next-button { background-color: ' . $arrow_bg_color . ';}
			';

			// responsive css and mouseover
			if(false === $this->is_editor) {
				//mouseover
				if(false === $this->detect->isMobile()) {
					switch($hor_full_hover) {
						case 'scale-opacity':
							$output['css'] .= '
								' . $selector . ' .flickity-slider:hover .apg-post .apg-grid-item { opacity: ' . ($hor_full_hover_so_opacity / 100) . '; }
								' . $selector . ' .flickity-slider .apg-post:hover .apg-grid-item .post-thumbnail img { transform: scale(' . (($hor_full_hover_so_scale / 100) + 1) . '); }
							';
						break;
						case 'dim-down':
							$output['css'] .= '
								' . $selector . ' .apg-post:hover .post-thumbnail { opacity: ' . ($hor_full_hover_dimdown_opacity / 100) . '; }
							';
						break;
						case 'border':
							$output['css'] .= '
								' . $selector . ' .apg-grid-item:hover:after { border-width: ' . $hor_full_hover_border_width . '; border-color: ' . $hor_full_hover_border_color . '; }
							';
						break;
					}
				}
				$output['css'] .= $this->get_breakpoints_css($id, 'hor-full', $content['options'], false);
			}

			// close apg wrapper
			$output['html'] .= '</div>';

			// frontend options
			$frontend_options = '';
			if(false === $this->is_editor) {
				$frontend_options .= 'draggable: true,';
				$click_handler = '
					$("#' . $id . '").on("staticClick.flickity", function(event, pointer, cellElement, cellIndex) {
						var $el = $(cellElement);
						if(semplice.frontend_mode == "static" && semplice.static_transitions == "disabled") {
							history.replaceState({
								apg: s4.helper.setApgHistory()
							}, "", window.location.href);
							window.location = $el.find(".apg-link").attr("href");
						} else {
							$el.find(".apg-link").click();
						}
					});
				';
			} else {
				$frontend_options .= 'draggable: false,';
				$click_handler = '';
			}

			// flickity
			$output['html'] .= '
				<script>
					(function($) {
						$(document).ready(function () {
							// is already initialized?
							if($("#' . $id . '").find(".flickity-slider").length > 0) {
								var flickityHtml = $("#' . $id . '").find(".flickity-slider").html();
								$("#' . $id . '").find(".apg").html(flickityHtml);
							}
							$("#' . $id . '").find(".apg").flickity({
								prevNextButtons: true,
								contain: true,
								pageDots: false,
								groupCells: true,
								percentPosition: true,
								setGallerySize: false,
								wrapAround: true,
								imagesLoaded: true,
								' . $frontend_options . '
								cellAlign: "left",
								arrowShape: "' . $arrow . '",
								pauseAutoPlayOnHover: false,
								selectedAttraction: ' . $hor_full_attraction . ',
								friction: ' . $hor_full_friction . ',
							});
							' . $click_handler. '
						});
					})(jQuery);
				</script>
			';

			// ret
			return $output;
		}

		// text grid
		public function text($content, $posts, $id) {

			// output
			$output = array(
				'html' => '',
				'css'  => '',
			);

			// section element
			$section_element = '';
			if(isset($content['section_element'])) {
				$section_element = $content['section_element'];
			}

			// attributes
			extract(shortcode_atts(
				array(
					'text_transition'				=> 'enabled',
					'text_hover_image_mode'			=> 'cover',
					'text_hover_image_width'		=> '60',
					'text_hover_effect'				=> 'fade_both',
					'text_hover_title_color'		=> '',
					'text_hover_title_opacity'		=> '20',
					'text_hover_title_mask'			=> 'disabled',
					'text_hover_title_mask_color'	=> '#ffffff',
					'text_title_direction'			=> 'column-dir',
					'text_title_position'			=> 'middle-center',
					'text_title_padding'			=> '4rem',
					'text_title_item_padding_ver'	=> '0.5555555555555556rem',
					'text_title_item_padding_hor'	=> '1rem',
					'text_title_color'				=> 'white',
					'text_title_font_family'		=> 'bold',
					'text_title_fontsize'			=> '5',
					'text_title_line_height'		=> '100',
					'text_title_text_transform'		=> 'none',
					'text_title_letter_spacing'		=> '0',
					'text_seperator_color'			=> 'white',
					'text_seperator_font_family'	=> 'bold',
					'text_seperator_fontsize'		=> '5',
					'text_seperator_text_transform'	=> 'none',
					'text_seperator'				=> '/',
				), $content['options'] )
			);

			// custom transition
			if($text_transition == 'enabled') {
				$custom_transition = ' data-custom-transition="text"';
			} else {
				$custom_transition = '';
			}

			// get item padding
			$text_title_item_padding_ver = floatval(str_replace('rem', '', $text_title_item_padding_ver)) / 2;
			$text_title_item_padding_hor = floatval(str_replace('rem', '', $text_title_item_padding_hor)) / 2;

			// create apg wrapper
			$output['html'] .= '<div class="apg apg-text ' . $text_title_direction . '" data-image-mode="' . $text_hover_image_mode . '" data-mask-effect="' . $text_hover_title_mask . '" data-mouseover-effect="' . $text_hover_effect . '" data-title-align="' . $text_title_position . '">';

			// count
			$max = count($posts);
			$i = 1;

			// seperator
			$seperator = '<div class="apg-text-seperator" data-font="' . $text_seperator_font_family . '">' . $text_seperator . '</div>';

			// iterate projects
			foreach ($posts as $key => $post) {
				// options
				$values = $this->get_custom_options($post['post_id'], $post['thumbnail']['src'], $content['options']);
				// add seperator
				if($i == $max) {
					$seperator = '';
				}
				// output
				$output['html'] .= '
					<div class="post-' . $post['post_id'] . ' apg-post apg-post-text ' . $values['custom_class'] . '" data-post-id="' . $post['post_id'] . '">
						' . $this->set_custom_styles($id, 'text', $post, $values) . '
						<a class="apg-grid-item" href="' . $post['permalink'] . '">
							<div class="post-thumbnail" data-image-width="' . $text_hover_image_width . '">
								' . $this->get_thumbnail($values['thumbnail'], 'hor-full', $id, $post) . '
							</div>
							<div class="apg-post-title">
								<div class="title" data-font="' . $text_title_font_family . '">' . $post['post_title'] . '</div>
							</div>
						</a>
						' . $seperator . '
					</div>
				';
				
				// inc
				$i++;
			}		

			// css
			$selector = '#' . $id . ' .apg-text';
			$output['css'] .= '
				' . $section_element . ' .row, ' . $section_element . ' .row .column { height: 100% !important; } ' . $section_element . ' .column-content { min-height: 100vh; height: auto; }
				' . $selector . ' { padding: ' . $text_title_padding . '; }
				' . $selector . ' .apg-post .apg-post-title .title, #' . $id . ' .apg-text-seperator { font-size: ' . $text_title_fontsize . '; color: ' . $text_title_color . '; text-transform: ' . $text_title_text_transform . '; letter-spacing: ' . $text_title_letter_spacing . '; line-height: ' . $text_title_line_height . '%; }
				' . $selector . ' .apg-text-seperator { color: ' . $text_seperator_color . '; }
				' . $selector . ' .apg-text-active .apg-post-title .title, #' . $id . ' .apg-text .apg-text-active .apg-text-active.apg-text-seperator { opacity: ' . ($text_hover_title_opacity / 100) . '; }
				' . $selector . ' .apg-post-title .title-hover { color: ' . $text_hover_title_mask_color . ' !important; }
				#' . $id . ' .row-dir { margin: -' . $text_title_item_padding_ver . 'rem -' . $text_title_item_padding_hor . 'rem; }
			';

			// mouseover title color
			if(!empty($text_hover_title_color)) {
				$output['css'] .= $selector . ' .apg-post-title .title:hover { color: ' . $text_hover_title_color . ' !important; }';
			}

			// padding
			if($text_title_direction == 'column-dir') {
				$output['css'] .= $selector . ' .apg-post-title { padding-top: ' . $text_title_item_padding_ver . 'rem; padding-bottom: ' . $text_title_item_padding_ver . 'rem; }';
			} else {
				$output['css'] .= $selector . ' .apg-post-text { padding-top: ' . $text_title_item_padding_ver . 'rem; padding-bottom: ' . $text_title_item_padding_ver . 'rem; }';
				$output['css'] .= $selector . ' .apg-grid-item { padding-left: ' . $text_title_item_padding_hor . 'rem; padding-right: ' . $text_title_item_padding_hor . 'rem; }';
			}

			// responsive css
			if(false === $this->is_editor) {
				$output['css'] .= $this->get_breakpoints_css($id, 'text', $content['options'], $text_title_direction);
			}

			// close apg wrapper
			$output['html'] .= '</div>';

			// ret
			return $output;
		}

		// fifty fifty
		public function splitscreen($content, $posts, $id) {
			// output
			$output = array(
				'html' => '',
				'css'  => '',
			);

			// section element
			$section_element = '';
			if(isset($content['section_element'])) {
				$section_element = $content['section_element'];
			}

			// content editable
			$editable = '';		

			// attributes
			extract(shortcode_atts(
				array(
					'splitscreen_layout'				=> 'left',
					'splitscreen_object_fit'			=> 'cover',
					'splitscreen_object_position'		=> 'top-center',
					'splitscreen_title_position'		=> 'middle-left',
					'splitscreen_transition'			=> 'disabled',
					'splitscreen_column_width'			=> '40',
					'splitscreen_column_bg'				=> '#ffffff',
					'splitscreen_image_bg'				=> '#dddddd',
					'splitscreen_scroll_reveal'			=> 'apg-reveal',
					'splitscreen_parallax'				=> 'subtle',
					'splitscreen_title_padding'			=> '4rem',
					'splitscreen_title_offset'			=> '0rem',
					'splitscreen_title_visibility'		=> 'both',
					'splitscreen_title_color'			=> '#000000',
					'splitscreen_title_font_family'		=> 'bold',
					'splitscreen_title_fontsize'		=> '2rem',
					'splitscreen_title_letter_spacing'	=> '0rem',
					'splitscreen_title_line_height'		=> '120',
					'splitscreen_title_text_transform' 	=> 'none',
					'splitscreen_type_color'			=> '#aaaaaa',
					'splitscreen_type_font_family'		=> 'regúlar',
					'splitscreen_type_fontsize'			=> '2rem',
					'splitscreen_type_line_height'		=> '120',
					'splitscreen_type_text_transform' 	=> 'none',
					'splitscreen_type_padding_top'		=> '2rem',
					'splitscreen_details_label'			=> 'View Project',
					'splitscreen_details_visibility'	=> 'visible',
					'splitscreen_details_type'			=> 'button',
					'splitscreen_details_bg_color'		=> '#efefef',
					'splitscreen_details_border'		=> 0,
					'splitscreen_details_border_color'	=> '#000000',
					'splitscreen_details_color'			=> '#000000',
					'splitscreen_details_font_family'	=> 'regúlar',
					'splitscreen_details_fontsize'		=> '0.7223rem',
					'splitscreen_details_text_transform'=> 'uppercase',
					'splitscreen_details_letter_spacing'=> '0.1111rem',
					'splitscreen_details_padding_top'	=> '2rem',
					'splitscreen_details_padding_hor'	=> '1.6667rem',
					'splitscreen_details_padding_ver'	=> '0.8888rem',
					'splitscreen_details_mouseover_background_color' => '#000000',
					'splitscreen_details_mouseover_color' => '#ffffff',
					'splitscreen_details_mouseover_border_color' => '#000000',
				), $content['options'])
			);

			// apg open
			$output['html'] .= '<div class="apg apg-splitscreen" data-layout="' . $splitscreen_layout . '" data-object-fit="' . $splitscreen_object_fit . '" data-title-align="' . $splitscreen_title_position . '" data-title-visibility="' . $splitscreen_title_visibility . '" data-details-visibility="' . $splitscreen_details_visibility . '" data-details-type="' . $splitscreen_details_type . '" data-parallax="' . $splitscreen_parallax . '">';

			// selector
			$selector = '#' . $id . ' .apg-splitscreen';

			// custom transition
			if($splitscreen_transition == 'enabled') {
				$custom_transition = ' data-custom-transition="splitscreen"';
			} else {
				$custom_transition = '';
			}

			// count
			$index = 1;

			// iterate posts
			foreach ($posts as $key => $post) {

				// is even/odd?
				if($index % 2 == 0) {
					$even_odd = 'even';
				} else {
					$even_odd = 'odd';
				}

				// options
				$values = $this->get_custom_options($post['post_id'], $post['thumbnail']['src'], $content['options']);

				// edtiable
				if(true === $this->is_editor) {
					$editable = ' data-splitscreen-editable="editable" data-content-id="' . $id . '" data-post-id="' . $post['post_id'] . '" contenteditable="true"';
				}

				// post title
				$post_title = $post['post_title'];
				if(isset($values['title']) && false !== $values['title']) {
					$post_title = $values['title'];
				}

				// custom transition
				$transition_id = ' data-transition-element="' . 'transition_' . substr(md5(rand()), 0, 9) . '"';

				// css output for background color
				$thumbnail_bg_color = '';
				if(isset($values['background-color']) && false !== $values['background-color']) {
					$thumbnail_bg_color = ' data-thumb-bg-color="' . $values['background-color'] . '" ';
					$output['css'] .= $selector . ' .post-' . $post['post_id'] . ' .apg-post-thumbnail { background-color: ' . $values['background-color'] . '; }';
				}

				$output['html'] .= '
					<div class="post-' . $post['post_id'] . ' apg-post apg-post-splitscreen ' . $splitscreen_scroll_reveal . '" data-post-id="' . $post['post_id'] . '" data-apg-object-position="' . $splitscreen_object_position . '">
						' . $this->set_custom_styles($id, 'splitscreen', $post, $values) . '
						<div class="splitscreen-half apg-post-meta ' . $even_odd . '">
							<div class="apg-post-title">
								<div class="title" data-font="' . $splitscreen_title_font_family . '"' . $editable . '>' . $post_title . '</div>
								<div class="description" data-font="' . $splitscreen_type_font_family . '"' . $editable . '>' . $values['description'] . '</div>
								<div class="details"><a class="apg-details-link" data-font="' . $splitscreen_details_font_family . '" href="' . $post['permalink'] . '"' . $custom_transition . $transition_id . '>' . $splitscreen_details_label . '</a></div>
							</div>
						</div>
						<div class="splitscreen-half apg-post-thumbnail"' . $thumbnail_bg_color . '>
							<a href="' . $post['permalink'] . '"' . $custom_transition . $transition_id . '>
								<div class="post-thumbnail">
									' . $this->get_thumbnail($values['thumbnail'], 'splitscreen', $id, $post) . '
								</div>
							</a>
						</div>
					</div>
				';

				// inc index
				$index++;
			}

			// close apg
			$output['html'] .= '</div>';

			// css
			$selector = '#' . $id . ' .apg-splitscreen';

			// border
			$border_css = 'border-width: 0rem 0rem ' . $splitscreen_details_border . ' 0rem;';
			if($splitscreen_details_type == 'button') {
				$border_css = 'border-width: ' . $splitscreen_details_border . ';';
			}

			// ausgleich letter spacing
			$neg_margin = '';
			if(false === $this->is_editor) {
				if(strpos($splitscreen_details_letter_spacing, '-') === false) {
					$neg_margin = 'margin-right: -' . $splitscreen_details_letter_spacing . ';'; 
				} else {
					$neg_margin = 'margin-right: ' . str_replace('-', '', $splitscreen_details_letter_spacing) . ';'; 
				}
			}

			$output['css'] .= '
				' . $selector . ' .apg-post { background-color: ' . $splitscreen_image_bg . ';}
				' . $selector . ' .apg-post-meta { width: ' . $splitscreen_column_width . '%; background-color: ' . $splitscreen_column_bg . ';}
				' . $selector . ' .apg-post-thumbnail { width: ' . (100 - $splitscreen_column_width) . '%; }
				' . $selector . ' .apg-post-title { padding: 0rem ' . $splitscreen_title_padding . '; }
				' . $selector . ' .apg-post-title { margin: ' . $splitscreen_title_offset . ' 0rem; }
				' . $selector . ' .apg-post-title .title { font-size: ' . $splitscreen_title_fontsize . '; letter-spacing: ' . $splitscreen_title_letter_spacing . '; line-height: ' . $splitscreen_title_line_height . '%; text-transform: ' . $splitscreen_title_text_transform . '; color: ' . $splitscreen_title_color . '; }
				' . $selector . ' .apg-post-title .description { font-size: ' . $splitscreen_type_fontsize . '; line-height: ' . $splitscreen_type_line_height . '%; color: ' . $splitscreen_type_color . '; text-transform: ' . $splitscreen_type_text_transform . '; padding-top: ' . $splitscreen_type_padding_top . ' }
				' . $selector . ' .apg-post-title .details { margin-top: ' . $splitscreen_details_padding_top . '; border-color: ' . $splitscreen_details_border_color . '; background-color: ' . $splitscreen_details_bg_color . '; ' . $border_css . ' }
				' . $selector . ' .apg-post-title .details:hover { border-color: ' . $splitscreen_details_mouseover_border_color . '; background-color: ' . $splitscreen_details_mouseover_background_color . '; }
				' . $selector . ' .apg-post-title .details a { font-size: ' . $splitscreen_details_fontsize . '; color: ' . $splitscreen_details_color . '; text-transform: ' . $splitscreen_details_text_transform . '; letter-spacing: ' . $splitscreen_details_letter_spacing. '; padding: ' . $splitscreen_details_padding_ver . ' ' . $splitscreen_details_padding_hor . '; ' . $neg_margin . ' }
				' . $selector . ' .apg-post-title .details a:hover { color: ' . $splitscreen_details_mouseover_color . '; }
			';
			// responsive css und onscroll
			if(false === $this->is_editor) {
				// responsive css
				$output['css'] .= $this->get_breakpoints_css($id, 'splitscreen', $content['options'], false);
				// onscroll
				$output['html'] .= '
					<script>
						(function($) {
							$(document).ready(function () {
								var screenHeight = $(window).height();
								var parallax = $("#' . $id . '").find(".apg").attr("data-parallax");
								var isFirst = $(".apg-post").first().addClass("first-apg-post");
								$(window).on("scroll", function() {
									$("#' . $id . '").find(".apg-post").each(function(index) {
										if($(this).isOnScreen(0.4, 0.4) && $(this).hasClass("apg-reveal")) {
											$(this).removeClass("apg-reveal");
											// fade in image
											gsap.to($(this).find(".post-thumbnail"), 1.5, {
												opacity: 1,
												scale: 1,
												ease: "Circ.easeOut",
											});
											// fade in text elements
											$(this).find(".title, .description, .details").each(function(index) {
												gsap.to($(this), .6, {
													y: 0,
													opacity: 1,
													delay: .25 * index,
													ease: "Circ.easeOut",
												});
											});
										}
										// parallax
										if(parallax != "off") {
											var intensity = { subtle: 10, medium: 6, intense: 2 };
											var alreadyScrolled = $(this).offset().top;
											var yPos = ($(window).scrollTop() - alreadyScrolled) / intensity[parallax];
											$(this).find(".post-thumbnail img").css({ 
												"transform" : "translate3d(0px, " + yPos + "px, 0px)"
											});
										}
									});
								});
								$(window).scroll();
							});
						})(jQuery);
					</script>
				';
			}

			// ret
			return $output;
		}

		// get breakpoints css
		public function get_breakpoints_css($id, $grid, $options, $gridDir) {
			// css
			$css = '';
			// define atts
			switch($grid) {
				case 'hor-full':
					$selector = '#' . $id . ' .apg-hor-full ';
					$atts = array(
						'hor_full_title_padding' => array('attribute' => 'padding', 'target' => '.apg-post-title'),
						'hor_full_title_fontsize' => array('attribute' => 'font-size', 'target' => '.apg-post-title .title, #' . $id . ' .apg-text-seperator'),
						'hor_full_title_letter_spacing' => array('attribute' => 'letter-spacing', 'target' => '.apg-post-title .title'),
						'hor_full_title_line_height' => array('attribute' => 'line-height', 'target' => '.apg-post-title .title'),
						'hor_full_type_fontsize' => array('attribute' => 'font-size', 'target' => '.apg-post-title .type'),
						'hor_full_type_padding_top' => array('attribute' => 'padding-top', 'target' => '.apg-post-title .type'),
					);
				break;
				case 'text':
					$selector = '#' . $id . ' ';
					$atts = array(
						'text_title_padding' => array('attribute' => 'padding', 'target' => '.apg-text'),
						'text_title_fontsize' => array('attribute' => 'font-size', 'target' => '.apg-text .apg-post-title .title, #' . $id . ' .apg-text-seperator'),
						'text_title_letter_spacing' => array('attribute' => 'letter-spacing', 'target' => '.apg-text .apg-post-title .title'),
						'text_title_line_height' => array('attribute' => 'line-height', 'target' => '.apg-text .apg-post-title .title'),
					);
				break;
				case 'splitscreen':
					$selector = '#' . $id . ' .apg-splitscreen ';
					$atts = array(
						'splitscreen_title_fontsize' => array('attribute' => 'font-size', 'target' => '.apg-post-title .title, #' . $id . ' .apg-text-seperator'),
						'splitscreen_title_letter_spacing' => array('attribute' => 'letter-spacing', 'target' => '.apg-post-title .title'),
						'splitscreen_title_line_height' => array('attribute' => 'line-height', 'target' => '.apg-post-title .title'),
						'splitscreen_type_fontsize' => array('attribute' => 'font-size', 'target' => '.apg-post-title .description'),
						'splitscreen_type_padding_top' => array('attribute' => 'padding-top', 'target' => '.apg-post-title .description'),
						'splitscreen_details_padding_top' => array('attribute' => 'margin-top', 'target' => '.apg-post-title .details'),
						'splitscreen_details_border' => array('attribute' => 'border-width', 'target' => '.apg-post-title .details'),
						'splitscreen_details_fontsize' => array('attribute' => 'font-size', 'target' => '.apg-post-title .details a'),
						'splitscreen_details_letter_spacing' => array('attribute' => 'letter-spacing', 'target' => '.apg-post-title .details a'),
					);
				break;
			}
			// breakpoints
			$breakpoints = semplice_get_breakpoints();
			// iterate breakpoints
			foreach ($breakpoints as $breakpoint => $width) {
				// iterate atts for this breakpoint
				$breakpoint_css = '';
				foreach ($atts as $attribute => $data) {
					if(isset($options[$attribute . '_' . $breakpoint])) {
						$value = $options[$attribute . '_' . $breakpoint];
						if (strpos($attribute, 'line_height') !== false) {
							$value = $value . '%';
						}
						$breakpoint_css .= $selector . $data['target'] . ' { ' . $data['attribute'] . ': ' . $value . ' !important; }';
					}
				}
				// special cases
				switch($grid) {
					case 'hor-full':
						// arrow size
						if(isset($options['hor_full_arrow_size_' . $breakpoint])) {
							$size = $options['hor_full_arrow_size_' . $breakpoint];
							$sizes = array('small' => 52, 'medium' => 64, 'large' => 78, 'insane' => 100);
							$breakpoint_css .= $selector . '.flickity-prev-next-button { width: ' . $sizes[$size] . 'px; height: ' . $sizes[$size] . 'px; }';
						}
						// offset
						if(isset($options['hor_full_title_offset_' . $breakpoint])) {
							$breakpoint_css .= $selector . '.apg-post-title { margin: ' . $options['hor_full_title_offset_' . $breakpoint] . ' 0 !important;}';
						}
					break;
					case 'text':
						// get paddings
						$paddings = array('ver' => '0.5555555555555556rem', 'hor' => '1rem');
						$prefix = 'text_title_item_padding_';
						foreach ($paddings as $dir => $value) {
							if(isset($options[$prefix . $dir . '_' . $breakpoint])) {
								$paddings[$dir] = $options[$prefix . $dir . '_' . $breakpoint];
							} else if(isset($options[$prefix . $dir])) {
								$paddings[$dir] = $options[$prefix . $dir];
							}
							// divide by 2
							$paddings[$dir] = (floatval(str_replace('rem', '', $paddings[$dir])) / 2) . 'rem';
						}
						// apply paddings
						if($gridDir == 'column-dir') {
							$breakpoint_css .= $selector . ' .apg-text .apg-post-title { padding-top: ' . $paddings['ver'] . '; padding-bottom: ' . $paddings['ver'] . '; }';
						} else {
							$breakpoint_css .= $selector . ' .apg-text .apg-post-text { padding-top: ' . $paddings['ver'] . '; padding-bottom: ' . $paddings['ver'] . '; }';
							$breakpoint_css .= $selector . ' .apg-text .apg-grid-item { padding-left: ' . $paddings['hor'] . '; padding-right: ' . $paddings['hor'] . '; }';
						}
						// negative margin
						$breakpoint_css .= '#' . $id . ' .row-dir { margin: -' . $paddings['ver'] . ' -' . $paddings['hor'] . '; }';
					break;
					case 'splitscreen':
						// padding
						if(isset($options['splitscreen_title_padding_' . $breakpoint])) {
							$breakpoint_css .= $selector . '.apg-post-title { padding: 0rem ' . $options['splitscreen_title_padding_' . $breakpoint] . '!important;}';
						}
						// offset
						if(isset($options['splitscreen_title_offset_' . $breakpoint])) {
							$breakpoint_css .= $selector . '.apg-post-title { margin: ' . $options['splitscreen_title_offset_' . $breakpoint] . ' 0rem !important;}';
						}
						// get button paddings
						$paddings = array('ver' => '0.8888rem', 'hor' => '1.6667rem');
						$prefix = 'splitscreen_details_padding_';
						foreach ($paddings as $dir => $value) {
							if(isset($options[$prefix . $dir . '_' . $breakpoint])) {
								$paddings[$dir] = $options[$prefix . $dir . '_' . $breakpoint];
							} else if(isset($options[$prefix . $dir])) {
								$paddings[$dir] = $options[$prefix . $dir];
							}
						}
						if(!isset($options['splitscreen_details_type']) || isset($options['splitscreen_details_type']) && $options['splitscreen_details_type'] == 'button') {
							$breakpoint_css .= $selector . '.apg-post-title .details a { padding: ' . $paddings['ver'] . ' ' . $paddings['hor'] . ' !important;}';
						}
					break;
				}
				// only add breakpoint if css is not empty
				if(!empty($breakpoint_css)) {
					// breakpoint open
					$css .= '@media screen' . $width['min'] . $width['max'] . ' { ' . $breakpoint_css . ' }';
				}	
			}
			// return
			return $css;
		}

		// set custom styles
		public function set_custom_styles($id, $grid, $post, $values) {

			// is editor?
			if(true === $this->is_editor) {
				// defaults
				if(isset($values['background-color']) && false !== $values['background-color']) {
					$bg_color = $values['background-color'];
				} else {
					$bg_color = 'transparent';
				}

				// thumb
				$upload_visibility = '';
				if(isset($values['thumbnail']) && false !== $values['has_custom_thumb']) {
					$thumb_src = '..' . substr($values['thumbnail'], -12);
				} else {
					$thumb_src = 'Upload Thumbnail';
					$upload_visibility = ' show-upload';
				}
				return '
					<div class="apg-custom-styles">
						<div class="acs-bgcolor attribute">
							<div class="apg-picker-holder"></div>
							<div class="cpt-holder">
								<div class="color-picker-toggle" data-picker-toggle="background-color" data-picker-mode="apg" style="background-color: ' . $bg_color . '"></div>
							</div>
							<div class="wp-color">
								<input type="text" value="' . $bg_color . '" data-input-type="color" class="color-picker admin-listen-handler" data-handler="colorPicker" data-picker="apgBg" name="background-color" data-unique-name="background-color" data-content-id="' . $id . '" data-target="' . $post['post_id'] . '">
							</div>
						</div>
						<div class="apg-custom-thumbnail" data-default-thumb="' . $post['thumbnail']['src'] . '">
							<div class="apg-thumb-icon no-ep">' . get_svg('backend', '/icons/apg_image_upload') . '</div>
							<div class="option apg-thumbnail-upload">

								<div class="media-upload-box' . $upload_visibility . '" data-upload-box="' . $id . '">
									<div class="upload-button admin-click-handler no-ep" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="image" data-media-type="image" data-upload="epPostThumbnail" name="post_thumbnail" data-content-id="' . $id . '" data-post-id="' . $post['post_id'] . '">
										<div class="upload-icon">
											' . get_svg('backend', '/icons/upload') . '
										</div>
									</div>
									<div class="image-preview-wrapper">
										<img class="image image-preview" src="' . $values['thumbnail'] . '">
										<div class="edit-image">
											<ul>
												<li><a class="admin-click-handler" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="image" data-media-type="image" data-upload="epPostThumbnail" name="post_thumbnail" data-content-id="' . $id . '" data-post-id="' . $post['post_id'] . '">' . get_svg('backend', '/icons/icon_edit') . '</a></li>
												<li><a class="admin-click-handler" data-handler="execute" data-action="image" data-action-type="delete" data-content-id="' . $id . '" name="post_thumbnail" data-post-id="' . $post['post_id'] . '">' . get_svg('backend', '/icons/icon_delete') . '</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				';
			}
		}

		// get custom options
		public function get_custom_options($post_id, $thumbnail, $options) {
			// output
			$values = array(
				'thumbnail' => $thumbnail,
				'has_custom_thumb' => false,
				'background-color' => false,
				'custom_class' => '',
				'description' => 'You can change this description and the title above by simply editing it.',
				'title' => false,
			);
			// posts set already?
			if(isset($options['posts']) && is_array($options['posts'])) {
				$posts = $options['posts'];
				// is post set?
				if(isset($posts[$post_id]) && is_array($posts[$post_id])) {
					foreach ($values as $attribute => $value) {
						if(isset($posts[$post_id][$attribute])) {
							// is thumbnail?
							if($attribute == 'thumbnail') {
								$values[$attribute] = semplice_get_image($posts[$post_id][$attribute], 'full');
								$values['has_custom_thumb'] = true;
							} else if($attribute == 'custom_class') {
								$values[$attribute] = ' ' . $posts[$post_id][$attribute];
							} else {
								$values[$attribute] = $posts[$post_id][$attribute];
							}
						}
					}
				}
			}
			// ret values
			return $values;
		}

		// get thumbnail
		public function get_thumbnail($thumbnail, $grid, $id, $post) {
			// no thumbnail?
			if (strpos($thumbnail, 'no_thumbnail') !== false) {
				// return button
				if(true === $this->is_editor) {
					return '<div class="missing-thumbnail"><p>Missing thumbnail for<br />"' . $post['post_title'] . '"</p><div class="semplice-button admin-click-handler no-ep trigger-apg-thumb-upload" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="image" data-media-type="image" data-upload="epPostThumbnail" name="post_thumbnail" data-content-id="' . $id . '" data-post-id="' . $post['post_id'] . '">Upload Thumbnail</div><img alt="missing-thumbnail" src="https://www.semplice.com/images/s4_missing_thumbnail.jpg"></div>';
				} else {
					return '<div class="missing-thumbnail"><p>Missing thumbnail for<br />"' . $post['post_title'] . '"</p></div>';
				}
			} else {
				// return image
				return '<img src="' . $thumbnail . '">';
			}
		}
	}
	// instance
	$this->module['advancedportfoliogrid'] = new sm_advancedportfoliogrid;
}