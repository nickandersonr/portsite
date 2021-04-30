<?php

// -----------------------------------------
// semplice
// admin/editor/modules/gallerygrid/module.php
// -----------------------------------------

if(!class_exists('sm_gallerygrid')) {

	class sm_gallerygrid {

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

		// output frontend
		public function output_editor($values, $id) {

			// extract options
			extract( shortcode_atts(
				array(
					'col'						=> 4,
					'target'					=> 'lightbox',
					'random'					=> 'disabled',
					'hor_gutter'				=> 30,
					'ver_gutter'				=> 30,
					'mouseover'					=> 'none',
					'mouseover_color'			=> '#000000',
					'mouseover_opacity'			=> 100,
					'title_visibility'			=> 'hidden',
					'title_position'			=> 'center',
					'title_padding'				=> '1rem',
					'title_color'				=> '#000000',
					'title_fontsize'			=> '16px',
					'title_font'				=> 'regular',
					'title_text_transform'		=> 'none',
					'caption_color'				=> '#999999',
					'caption_fontsize'			=> '14px',
					'caption_font'				=> 'regular',
					'caption_text_transform'	=> 'none',
					'caption_padding_top'		=> '0.4444444444444444rem',
				), $values['options'])
			);

			// get images
			$images = $values['content']['xl'];

			// generate items
			$masonry_items = '';

			// random
			if($random !== 'disabled') {
				$col_array = explode('.', $random);
				$small_col = $col_array[0];
				$big_col   = $col_array[1];
			}

			if(!function_exists('HexToRGB')) {
				// hex to rgb
				function HexToRGB($hex) {
					$hex = str_replace("#", "", $hex);
					$color = array();
					 
					if(strlen($hex) == 3) {
						$color['r'] = hexdec(substr($hex, 0, 1) . $r);
						$color['g'] = hexdec(substr($hex, 1, 1) . $g);
						$color['b'] = hexdec(substr($hex, 2, 1) . $b);
					}
					else if(strlen($hex) == 6) {
						$color['r'] = hexdec(substr($hex, 0, 2));
						$color['g'] = hexdec(substr($hex, 2, 2));
						$color['b'] = hexdec(substr($hex, 4, 2));
					}
					 
					return $color;
				}
			}

			// index
			$index = 0;

			// get shots
			if(is_array($images) && !empty($images)) {

				foreach ($images as $image) {

					// get image
					$img = wp_get_attachment_image_src($image, 'full');

					// is image still in library?
					if(false !== $img) {

						// caption
						$img['title'] = get_the_title($image);
						$img['caption'] = wp_get_attachment_caption($image);

						// image alt
						$image_alt = semplice_get_image_alt($image);

						// mouseover
						if($mouseover == 'color') {
							if(strpos($mouseover_color, '#') !== false) {
								$rgba = HexToRGB($mouseover_color);
								$mouseover_html = '<div class="gg-hover" style="background: rgba(' . $rgba['r'] . ', ' . $rgba['g'] . ', ' . $rgba['b'] . ', ' . ($mouseover_opacity / 100) . ');"></div>';
							} else {
								$mouseover_html = '';
							}
						} elseif($mouseover == 'shadow') {
							$mouseover_html = '<div class="gg-hover" style="box-shadow: 0px 0px 50px rgba(0,0,0,' . ($mouseover_opacity / 100) . ');"></div>';
						} else {
							$mouseover_html = '';
						}

						// title and caption visibility
						$title_caption = '';
						if($title_visibility != 'hidden') {
							$title_caption .= '<div class="gg-title-caption" data-title-visibility="' . $title_visibility . '">';
							if($title_visibility == 'both' || $title_visibility == 'title') {
								$title_caption .= '<div class="post-title ' . $title_font . '">' . $img['title'] . '</div>';
							}
							if($title_visibility == 'both' || $title_visibility == 'caption') {
								$title_caption .= '<div class="post-caption ' . $caption_font . '">' . $img['caption'] . '</div>';
							}
							$title_caption .= '</div>';
						}

						// image html
						if($target == 'lightbox') {
							$image = '<a class="semplice-lightbox gallerygrid-image mouseover-' . $mouseover . '"><img class="lightbox-item" src="' . $img[0] . '" width="' . $img[1] . '" height="' . $img[2] . '" caption="' . $img['caption'] . '" alt="' . $image_alt . '">' . $mouseover_html . '</a>' . $title_caption;
						} else {
							$image = '<a class="mouseover-' . $mouseover . '"><img src="' . $img[0] . '" width="' . $img[1] . '" height="' . $img[2] . '" alt="' . $image_alt . '">' . $mouseover_html . '</a>' . $title_caption;
						}
						
						if($random !== 'disabled' && $index % 4 == 0 && $index > 0) {
							$col = $big_col;
						} elseif($random !== 'disabled') {
							$col = $small_col;
						}
						
						// add thumb to holder
						$masonry_items .= '
							<div class="masonry-item thumb masonry-' . $id . '-item" data-xl-width="' . $col . '" data-sm-width="6" data-xs-width="12">
							' . $image . '
							</div>
						';
						
						// increment index
						$index ++;
					}
				}
				// get masonry
				$this->output['html'] = semplice_masonry('gallerygrid', $id, $values['options'], $masonry_items, $this->is_editor, $values['script_execution']);
			}

			// if there are no images show placeholder
			if(empty($masonry_items)) {
				$this->output['html'] = semplice_module_placeholder('gallerygrid', false, true, $this->is_editor);
			}

			// add to css
			$this->output['css'] = '
				' . $mobile_css = semplice_masonry_mobile_css($id, $values['options'], $col, $this->is_editor, $hor_gutter, $ver_gutter, false) . '
				#content-holder #' . $id . ' .thumb .post-title { 
					padding: ' . $title_padding . ' 0 0 0;
				}
				#' . $id . ' .thumb .post-title {
					color: ' . $title_color . ';
					font-size: ' . $title_fontsize . ';
					text-transform: ' . $title_text_transform . ';
					text-align: ' . $title_position . ';
				}
				#' . $id . ' .thumb .post-caption {
					color: ' . $caption_color . ';
					font-size: ' . $caption_fontsize . ';
					text-transform: ' . $caption_text_transform . ';
					padding-top: ' . $caption_padding_top . ';
					text-align: ' . $title_position . ';
					text-align: ' . $title_position . ';
				}
			';

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
	$this->module['gallerygrid'] = new sm_gallerygrid;
}