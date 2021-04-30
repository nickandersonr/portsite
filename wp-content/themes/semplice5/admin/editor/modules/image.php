<?php

// -----------------------------------------
// semplice
// admin/editor/modules/image/module.php
// -----------------------------------------

if(!class_exists('sm_image')) {
	class sm_image {

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
			// get image id
			$image_id = $values['content']['xl'];

			// extract options
			extract( shortcode_atts(
				array(
					'width'				=> 'original',
					'align'				=> 'left',
					'lightbox'			=> 'no',
					'scaling'			=> 'no',
					'image_link' 		=> '',
					'image_link_type'	=> 'url',
					'image_link_page'	=> '',
					'image_link_project'=> '',
					'image_link_post'	=> '',
					'image_link_target' => '_blank',
				), $values['options'] )
			);

			// get image
			if(!empty($image_id)) {
				// is an id or a url from an semplice block?
				if(is_numeric($image_id)) {
					// get img
					$attachment = wp_get_attachment_image_src($image_id, 'full', false);
					// is image?
					if($attachment) {
						// image alt
						$image_alt = semplice_get_image_alt($image_id);
						// check if svg
						if(strpos($attachment[0], '.svg') !== false) {
							$image = array(
								'src'		=> $attachment[0],
								'alt'		=> $image_alt,
							);
						} else {
							$image = array(
								'src' 		=> $attachment[0],
								'width' 	=> $attachment[1],
								'height' 	=> $attachment[2],
								'alt'		=> $image_alt,
							);
						}
						// image caption
						$image_post = get_post($image_id);
						$image['caption'] = wp_get_attachment_caption($image_id);

					} else {
						$image = array(
							'src' 		=> get_template_directory_uri() . '/assets/images/admin/preview_notfound.svg',
							'width' 	=> 500,
							'height'	=> 500,
							'alt'		=> 'Image not found',
							'caption'   => '',
						);
					}
					
				} else {
					// get semplice image
					$semplice_image = semplice_get_external_image($image_id);
					// is svg?
					if($semplice_image['type'] == 'vector') {
						$image = array(
							'src' 		=> $semplice_image['url'],
							'alt'		=> $semplice_image['alt'],
							'caption'   => '',
						);
					} else {
						$image = array(
							'src' 		=> $semplice_image['url'],
							'width' 	=> $semplice_image['width'],
							'height'	=> $semplice_image['height'],
							'alt'		=> $semplice_image['alt'],
							'caption'   => '',
						);
					}
				}

				// check if lightbox item
				$lightbox_item = '';
				if($lightbox == 'yes') {
					$lightbox_item = ' lightbox-item';
				}

				// image html
				$image_html = '<img class="is-content' . $lightbox_item . '" ' . $this->get_image_atts($image) . ' data-width="' . $width . '" data-scaling="' . $scaling . '">';

				// image link
				$image_link = array(
					'type'		=> $image_link_type,
					'url'		=> $image_link,
					'page'		=> $image_link_page,
					'project'  	=> $image_link_project,
					'post'		=> $image_link_post,
				);

				// temporaray output without link and lightbox
				$this->output['html'] = '<div class="ce-image" data-align="' . $align . '">' . $this->wrap_hyperlink($image_html, $lightbox, $image_link, $image_link_target) . '</div>';

			} else {
				// is admin and has no images?
				$this->output['html'] = semplice_module_placeholder('image', false, true, $this->is_editor);
			}

			// output
			return $this->output;
		}

		// output frtonend
		public function output_frontend($values, $id) {
			// set is frontend
			$this->is_editor = false;
			// same as editor
			return $this->output_editor($values, $id);
		}

		// get image
		public function get_image_atts($attributes) {
			// output
			$output = '';
			// iterate img
			foreach ($attributes as $attribute => $value) {
				$output .= ' ' . $attribute . '="' . $value . '"';
			}
			// return
			return $output;
		}

		// wrap hyperlink
		public function wrap_hyperlink($image, $lightbox, $link, $target) {
			if(false === $this->is_editor) {
				if($lightbox == 'yes') {
					return '<a class="semplice-lightbox">' . $image . '</a>';
				} else if($link['type'] == 'url' && !empty($link['url'])) {
					return '<a href="' . $link['url'] . '" target="' . $target . '">' . $image . '</a>';
				} else if($link['type'] != 'url') {
					if(!empty($link[$link['type']])) {
						return '<a href="' . get_permalink($link[$link['type']]) . '" target="' . $target . '">' . $image . '</a>';
					} else {
						return $image;
					}
				} else {
					return $image;
				}
			} else {
				return $image;
			}
		}
	}
	// instance
	$this->module['image'] = new sm_image;
}