<?php

// -----------------------------------------
// semplice
// admin/editor/modules/mailchimp.php
// -----------------------------------------

if(!class_exists('sm_mailchimp')) {
	class sm_mailchimp {

		public $output;
		public $is_frontend;

		// constructor
		public function __construct() {
			// define output
			$this->output = array(
				'html' => '',
				'css'  => '',
			);
			$this->is_frontend = false;
		}

		// output frontend
		public function output_editor($values, $id) {

			// values
			extract( shortcode_atts(
				array(
					'form_action_url'					=> '',
					'fname'								=> 'enabled',
					'placeholder_name'					=> 'First Name',
					'placeholder_email'					=> 'E-Mail Address',
					'alignment'							=> 'left',
					'layout'							=> 'horizontal',
					'spacing'							=> '0rem',
					'input_color'						=> '#000000',
					'input_bg_color'					=> '#f0f0f0',
					'input_holder_color'				=> '#aaaaaa',
					'input_width'						=> '12.77777777777778rem',
					'input_text_align'					=> 'left',
					'input_font_family'					=> 'regular',
					'input_font_size'					=> '1rem',
					'input_padding_ver'					=> '1.111111111111111rem',
					'input_padding_hor'					=> '1.666666666666667rem',
					'input_border_width'				=> 0,
					'input_border_color'				=> '#000000',
					'input_border_radius'				=> 0,			
					'input_mouseover_color'				=> '#000000',
					'input_holder_mouseover_color' 		=> '#666666',
					'input_bg_mouseover_color'			=> '#e9e9e9',
					'input_border_mouseover_color'		=> '#000000',
					'submit_label'						=> 'Subscribe',
					'submit_color'						=> '#000000',
					'submit_font_family'				=> 'regular',
					'submit_font_size'					=> '1rem',
					'submit_letter_spacing'				=> 0,
					'submit_bg_color'					=> '#ffd300',
					'submit_padding_ver'				=> '1.111111111111111rem',
					'submit_padding_hor'				=> '1.666666666666667rem',
					'submit_border_width'				=> 0,
					'submit_border_color'				=> '#000000',
					'submit_border_radius'				=> 0,
					'submit_mouseover_color'			=> '#000000',
					'submit_mouseover_letter_spacing'	=> 0,
					'submit_bg_mouseover_color'			=> '#ffe152',
					'submit_border_mouseover_color'		=> '#000000',
				), $values['options'] )
			);

			// css on is-content
			$css = '#content-holder #' . $id . ' .is-content {';

			// close is-content css
			$css .= '}';

			// form elements margin
			$margin_dir = 'right';
			if($layout == 'vertical') {
				$margin_dir = 'bottom';
			}

			// input styles
			$css .= '
				#content-holder #' . $id . ' .mailchimp-input {
					color: ' . $input_color .';
					background-color: ' . $input_bg_color . ';
					margin-' . $margin_dir . ': ' . $spacing . ';
					width: ' . $input_width . ';
					text-align: ' . $input_text_align . ';
					font-size: ' . $input_font_size . ';
					padding-top: ' . $input_padding_ver . ';
					padding-bottom: ' . $input_padding_ver . ';
					padding-left: ' . $input_padding_hor . ';
					padding-right: ' . $input_padding_hor . ';
					border-width: ' . $input_border_width . ';
					border-color: ' . $input_border_color . ';
					border-radius: ' . $input_border_radius . ';
				}
				#content-holder #' . $id . ' .mailchimp-input:hover, #content-holder #' . $id . ' .mailchimp-input:focus {
					color: ' . $input_mouseover_color .';
					background-color: ' . $input_bg_mouseover_color .';
					border-color: ' . $input_border_mouseover_color .';
				}
				#content-holder #' . $id . ' input::-webkit-input-placeholder { color: ' . $input_holder_color . ';	}
				#content-holder #' . $id . ' input::-moz-placeholder { color: ' . $input_holder_color . '; }
				#content-holder #' . $id . ' input:-ms-input-placeholder { color: ' . $input_holder_color . '; }
				#content-holder #' . $id . ' input:-moz-placeholder { color: ' . $input_holder_color . '; }
				#content-holder #' . $id . ' input:hover::-webkit-input-placeholder { color: ' . $input_holder_mouseover_color . ';	}
				#content-holder #' . $id . ' input:hover::-moz-placeholder { color: ' . $input_holder_mouseover_color . '; }
				#content-holder #' . $id . ' input:hover:-ms-input-placeholder { color: ' . $input_holder_mouseover_color . '; }
				#content-holder #' . $id . ' input:hover:-moz-placeholder { color: ' . $input_holder_mouseover_color . '; }

			';

			// mobile spacing
			if($layout == 'horizontal') {
				$css .= '
					@media screen and (max-width: 543.98px) {
						#content-holder #' . $id . ' .mailchimp-input { margin-bottom: ' . $spacing . '; }
					}
				';
			}

			// submit button
			$css .= '
				#content-holder #' . $id . ' button {
					color: ' . $submit_color . ';
					font-size: ' . $submit_font_size . ';
					letter-spacing: ' . $submit_letter_spacing . ';
					background-color: ' . $submit_bg_color . ';
					border-width: ' . $submit_border_width . ';
					border-color: ' . $submit_border_color . ';
					border-radius: ' . $submit_border_radius . ';
					padding-top: ' . $submit_padding_ver . ';
					padding-bottom: ' . $submit_padding_ver . ';
					padding-left: ' . $submit_padding_hor . ';
					padding-right: ' . $submit_padding_hor . ';
				}
				#content-holder #' . $id . ' button:hover {
					color: ' . $submit_mouseover_color .';
					letter-spacing: ' . $submit_mouseover_letter_spacing .';
					background-color: ' . $submit_bg_mouseover_color .';
					border-color: ' . $submit_border_mouseover_color .';
				}
			';

			// add css to output
			$this->output['css'] = $css;

			// first name
			$fname_input = '<input type="text" value="" name="FNAME" id="mce-FNAME" class="mailchimp-input ' . $input_font_family . '" size="16" placeholder="' . $placeholder_name . '">';

			// always show on editor, only in frontend if selected
			if(true === $this->is_frontend && $fname == 'disabled') {
				$fname_input = '';
			}

			// add html to output
			$this->output['html'] = '
				<div class="mailchimp-newsletter" data-alignment="' . $alignment . '" data-fname="' . $fname . '" data-layout="' . $layout . '">
					<div class="mailchimp-inner is-content">
						<form action="' . $form_action_url . '" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate">
							' . $fname_input . '
							<input type="email" value="" name="EMAIL" id="mce-EMAIL" class="mailchimp-input ' . $input_font_family . '" size="16" placeholder="' . $placeholder_email .'">
							<button class="mailchimp-submit-button ' . $submit_font_family . '" type="submit"  value="Subscribe" name="subscribe" id="mc-embedded-subscribe">' . $submit_label . '</button>
						</form>
					</div>
				</div>
			';

			// output
			return $this->output;
		}

		// output frontend
		public function output_frontend($values, $id) {
			// set is frontend to true
			$this->is_frontend = true;
			// same as editor
			return $this->output_editor($values, $id);
		}
	}

	// instance
	$this->module['mailchimp'] = new sm_mailchimp;
}