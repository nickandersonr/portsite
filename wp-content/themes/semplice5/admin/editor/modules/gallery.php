<?php

// -----------------------------------------
// semplice
// admin/editor/modules/gallery/module.php
// -----------------------------------------

if(!class_exists('sm_gallery')) {
	class sm_gallery {

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

			// get images
			$images = $values['content']['xl'];

			// image src
			$img_src = '';

			// preview
			if(is_array($images)) {
				foreach ($images as $image) {
					$img = wp_get_attachment_image_src($image, 'full');
					if(false !== $img) {
						$img_src = $img[0];
					}
					// already has an preview found?
					if(!empty($img_src)) {
						break;
					}
				}
			}

			// is preview still empty?
			if(empty($img_src)) {
				$this->output['html'] = semplice_module_placeholder('gallery', false, true, true);
			} else {
				$this->output['html'] = '<div class="gallery-preview"><img class="is-content" src="' . $img_src . '" alt="gallery-placeholder"></div>';
			}
			
			// return output
			return $this->output;
		}

		// output frtonend
		public function output_frontend($values, $id) {

			// output
			$output = '';
			$images_output = '';
			$cover = array(
				'css' 		 => '',
				'class' 	 => '',
				'object-fit' => '',
			);
			$gallery_size = 'true';

			// attributes
			extract( shortcode_atts(
				array(
					'images'				=> '',
					'width'					=> 'grid-width',
					'cover_mode'			=> 'disabled',
					'autoplay'				=> false,
					'adaptive_height'		=> 'true',
					'animation_status'		=> 'enabled',
					'animation'				=> 'sgs-crossfade',
					'timeout' 				=> 4000,
					'arrows_visibility'		=> 'true',
					'arrows_shape'			=> 'default',
					'arrows_custom'			=> false,
					'arrows_color'			=> '#ffffff',
					'arrows_bg_color'		=> '#000000',
					'arrows_bg_opacity'		=> 0,
					'pagination_visibility'	=> 'false',
					'pagination_color'		=> '#000000',
					'pagination_position'	=> 'below',
					'infinite'				=> 'false',
					'attraction'			=> '0.025',
					'friction'				=> '0.28',
					'caption_visibility'	=> 'hidden',
					'caption_color'			=> '#000000',
					'caption_font'			=> 'regular',
					'caption_fontsize'		=> '0.8888888888888889rem',
					'caption_text_transform'=> 'none',
				), $values['options'] )
			);
			
			// autoplay?
			if($autoplay == 'true' && is_numeric($timeout)) {
				$autoplay = $timeout;
			} else {
				$autoplay = 'false';
			}

			// animation status
			if($animation_status == 'disabled') {
				$animation = 'sgs-nofade';
			}

			// arrows
			$default_arrows = array(
				'default'	  => 'M67.37,100L28.195,50,67.37,0,71.8,5.5,37.581,50,71.8,94.5Z',
				'alternative' => 'M95.849,46.323H14.1L40.364,20.15a4.166,4.166,0,0,0-5.9-5.881L1.076,47.537a4.162,4.162,0,0,0,0,5.891L34.462,86.7a4.166,4.166,0,0,0,5.9-5.881L14.1,54.642H95.849A4.159,4.159,0,1,0,95.849,46.323Z',
			);
			if($arrows_shape == 'custom') {
				if(!empty($arrows_custom)) {
					$arrow = htmlentities($arrows_custom);	
				} else {
					$arrow = $default_arrows['default'];
				}
			} else {
				$arrow = $default_arrows[$arrows_shape];
			}

			// arrow color
			if($arrows_bg_color != 'transparent') {
				$arrow_bg_color = semplice_hex_to_rgb($arrows_bg_color);
				$arrow_bg_color = 'rgba(' . $arrow_bg_color['r'] . ', ' . $arrow_bg_color['g'] . ', ' . $arrow_bg_color['b'] . ', ' . ($arrows_bg_opacity / 100) . ')';
			} else {
				$arrow_bg_color = 'transparent';
			}

			// caption js
			$caption = array('js' => '', 'css' => '');
			if($caption_visibility == 'visible' && $cover_mode == 'disabled') {
				$caption['js'] = '
					// Flickity instance
					var flkty = $gallery.data("flickity");
					// captions
					$gallery.on("select.flickity", function() {
						var caption = $(flkty.selectedElement).find("img").attr("caption");
						$("#' . $id . '").find(".flickity-caption").text(caption);
					});
				';
				$caption['css'] = '#' . $id . ' .flickity-meta .flickity-caption { display: block; }';
			}

			// get images
			$images = $values['content']['xl'];
			
			if(is_array($images)) {

				// cover class and css
				if($cover_mode == 'enabled') {
					// change min-height to vh if section is fullscreen. set min height to 100% if section height is custom and therefore defined with a fixed value for .container
					$min_height_unit = 'vh';
					$content_height = '100vh';
					if($values['section_height']['mode'] == 'custom') {
						$min_height_unit = '%';
						$content_height = $values['section_height']['height'];
					}

					// set up cover
					$cover = array(
						'css' 		 => $values['section_element'] . ' .row, ' . $values['section_element'] . ' .row .column { min-height: 100' . $min_height_unit . ' !important; } ' . $values['section_element'] . ' .column-content { height: ' . $content_height . '; }',
						'class' 	 => ' sgs-cover',
						'object-fit' => ' data-object-fit="cover"',
					);
					// set gallery sizing to false
					$gallery_size = 'false';
				}

				$output .= '<div id="gallery-' . $id . '" class="is-content semplice-gallery-slider ' . $animation . $cover['class'] . '">';

				foreach($images as $image) {
					
					// get img
					$img = wp_get_attachment_image_src($image, 'full');

					// is image still in library?
					if(false !== $img) {
						// image alt
						$image_alt = semplice_get_image_alt($image);

						// caption
						$image_caption = wp_get_attachment_caption($image);
						
						$images_output .= '<div class="sgs-slide ' . $width . '">';
						$images_output .= '<img src="' . $img[0] . '" alt="' . $image_alt . '" caption="' . $image_caption . '"' . $cover['object-fit'] . ' />';
						$images_output .= '</div>';
					}
				}

				// add to output
				$output .= $images_output;

				$output .= '</div><div class="flickity-meta pagination-' . $pagination_position . ' sgs-pagination-' . $pagination_visibility . '" data-caption-visibility="' . $caption_visibility . '"><div class="flickity-caption" data-font="' . $caption_font . '"></div></div>';

				// custom css for nav and pagination
				$this->output['css'] = '
					#' . $id . ' .flickity-prev-next-button .arrow { fill: ' . $arrows_color . ' !important; }
					#' . $id . ' .flickity-page-dots .dot { background: ' . $pagination_color . ' !important; }
					#' . $id . ' .flickity-meta .flickity-caption { color: ' . $caption_color . '; font-size: ' . $caption_fontsize . '; text-transform: ' . $caption_text_transform . '; }
					#' . $id . ' .flickity-button-icon path { fill: ' . $arrows_color . '; }
					#' . $id . ' .flickity-prev-next-button { background-color: ' . $arrow_bg_color . '; }
					' . $cover['css'] . $caption['css'];
				
				$output .='
					<script>
						(function($) {
							$(document).ready(function () {
								// ready event listener
								$("#gallery-' . $id . '").on("ready.flickity", function() {
									// append dots to flickity meta
									if($(this).find(".flickity-page-dots").length > 0) {
										$("#' . $id . '").find(".flickity-meta").append($(this).find(".flickity-page-dots"));
									}
									// refresh scroll trigger
									s4.helper.refreshScrollTrigger();
								});
								var $gallery = $("#gallery-' . $id . '").flickity({
									autoPlay: ' . $autoplay . ',
									adaptiveHeight: ' . $adaptive_height . ',
									prevNextButtons: ' . $arrows_visibility . ',
									pageDots: ' . $pagination_visibility . ',
									wrapAround: ' . $infinite . ',
									setGallerySize: ' . $gallery_size . ',
									selectedAttraction: ' . $attraction . ',
									friction: ' . $friction . ',
									percentPosition: true,
									imagesLoaded: true,
									arrowShape: "' . $arrow . '",
									pauseAutoPlayOnHover: false,
								});
								' . $caption['js'] . '
							});
						})(jQuery);
					</script>
				';
			}

			// if there are not images show placeholder
			if(empty($images_output)) {
				$output .= semplice_module_placeholder('gallery', false, true, false);
			}

			// save output
			$this->output['html'] = $output;

			return $this->output;
		}
	}
	// instance
	$this->module['gallery'] = new sm_gallery;
}