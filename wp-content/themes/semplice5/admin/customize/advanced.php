<?php

// -----------------------------------------
// semplice
// /admin/customize/advanced.php
// -----------------------------------------

if(!class_exists('advanced')) {
	class advanced extends admin_api{

		// constructor
		public function __construct() {}

		// output
		public function output() {
			// return output
			return '';
		}
		// generate css
		public function generate_css($is_frontend) {

			// output
			$advanced_css = '';

			// get advanced content
			$advanced = json_decode(get_option('semplice_customize_advanced'), true);

			// is array?
			if(is_array($advanced)) {

				// text color
				if(isset($advanced['text_color'])) {
					$advanced_css .= '.is-content { color: ' . $advanced['text_color'] . '; }';
				}

				// text color
				if(isset($advanced['link_color'])) {
					$advanced_css .= 'a { color: ' . $advanced['link_color'] . '; }';
				}

				// text color
				if(isset($advanced['mouseover_color'])) {
					$advanced_css .= 'a:hover { color: ' . $advanced['mouseover_color'] . '; }';
				}

				// global custom css
				if($is_frontend) {
					if(isset($advanced['custom_css_global']) && !empty($advanced['custom_css_global'])) {
						$advanced_css .= $advanced['custom_css_global'];
					}
					// get breakpoints
					$breakpoints = array(
						'xl' => '@media screen and (min-width: 1170px)', 
						'lg' => '@media screen and (min-width: 992px) and (max-width: 1169.98px)', 
						'md' => '@media screen and (min-width: 768px) and (max-width: 991.98px)', 
						'sm' => '@media screen and (min-width: 544px) and (max-width: 767.98px)', 
						'xs' => '@media screen and (max-width: 543.98px)',
					);
					// loop through breakpoints
					foreach ($breakpoints as $breakpoint => $query) {
						if(isset($advanced['custom_css_' . $breakpoint]) && !empty($advanced['custom_css_' . $breakpoint])) {
							$advanced_css .= $query . '{' . $advanced['custom_css_' . $breakpoint] . '}';
						}
					}

					// progress bar
					if(isset($advanced['progress_bar'])) {
						$advanced_css .= '#nprogress .bar { background: ' . $advanced['progress_bar'] . '; }';
					}	

					// top arrow color
					if(isset($advanced['top_arrow_color'])) {
						$advanced_css .= '.back-to-top a svg { fill: ' . $advanced['top_arrow_color'] . '; }';
					}

					// top arrow width
					if(isset($advanced['top_arrow_width'])) {
						$advanced_css .= '.back-to-top a img, .back-to-top a svg { width: ' . $advanced['top_arrow_width'] . '; height: auto; }';
					}

					// password font color
					if(isset($advanced['password_color'])) {
						$advanced_css .= '.post-password-form p, .post-password-form p a.post-password-submit, .post-password-form input[type=submit] { color: ' . $advanced['password_color'] . '; }';
					}

					// password border color
					if(isset($advanced['password_border'])) {
						$advanced_css .= '.post-password-form p a.post-password-submit, .post-password-form p input[type=submit], .post-password-form p label input { border-color: ' . $advanced['password_border'] . '; }';
					}

					// lightbox bg color
					if(isset($advanced['lightbox_bg_color'])) {
						$advanced_css .= '.pswp__bg { background: ' . $advanced['lightbox_bg_color'] . '; }';
						$bg_color = semplice_hex_to_rgb($advanced['lightbox_bg_color']);
						// transparent top bar
						$advanced_css .= '.pswp__top-bar, .pswp__button--arrow--left:before, .pswp__button--arrow--right:before { background-color: rgba(' . $bg_color['r'] . ', ' . $bg_color['g'] . ', ' . $bg_color['b'] . ', .3) !important; }';
					}

					// lightbox opacity
					if(isset($advanced['lightbox_bg_opacity'])) {
						$advanced_css .= '.pswp__bg { opacity: ' . $advanced['lightbox_bg_opacity'] . ' !important; }';
					}

					// lightbox icon opacity
					if(isset($advanced['lightbox_icon_opacity'])) {
						$advanced_css .= '.pswp__button, .pswp__counter { opacity: ' . $advanced['lightbox_icon_opacity'] . ';}';
					}
					// lightbox icon color
					if(isset($advanced['lightbox_icon_color'])) {
						$lightbox_icon_color = str_replace('#', '%23', $advanced['lightbox_icon_color']);
						$advanced_css .= "
							.pswp__counter {
								color: " . $advanced['lightbox_icon_color'] . ";
							}
							.pswp--svg .pswp__button,
						    .pswp--svg .pswp__button--arrow--left:before,
							.pswp--svg .pswp__button--arrow--right:before {
								background-image: url(\"data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='1100' height='367' viewBox='0 0 1100 367'><path fill='" . $lightbox_icon_color . "' d='M60.08,308a2.094,2.094,0,0,1-1.48-3.575l62.806-62.821a2.093,2.093,0,0,1,2.96,2.961L61.56,307.388A2.085,2.085,0,0,1,60.08,308Zm62.806,0a2.087,2.087,0,0,1-1.48-.613L58.6,244.566a2.093,2.093,0,0,1,2.96-2.961l62.806,62.821A2.094,2.094,0,0,1,122.886,308Z'/><path fill='" . $lightbox_icon_color . "' d='M701.3,243.326H623.655l24.34-24.1c1.416-1.466,2.366-3.794.891-5.2-1.436-1.367-2.7-1.364-4.134.008L614.081,243.4a3.655,3.655,0,0,0,0,5.195l0,0.005,30.669,29.369c1.472,1.41,2.815,1.369,4.235-.093,1.381-1.421.385-3.672-.991-5.1l-24.339-24.107H701.3c2.041,0,2.7-.644,2.7-2.671S703.345,243.326,701.3,243.326Z'/><path fill='" . $lightbox_icon_color . "' d='M398.7,243.326h77.649l-24.34-24.1c-1.416-1.466-2.366-3.794-.891-5.2,1.436-1.367,2.7-1.364,4.134.008L485.919,243.4a3.655,3.655,0,0,1,0,5.195l0,0.005L455.25,277.967c-1.472,1.41-2.815,1.369-4.235-.093-1.381-1.421-.385-3.672.991-5.1l24.339-24.107H398.7c-2.041,0-2.7-.644-2.7-2.671S396.655,243.326,398.7,243.326Z'/><path fill='" . $lightbox_icon_color . "' d='M59.152,126a2.157,2.157,0,0,1-1.525-3.682l25.88-25.878a2.156,2.156,0,0,1,3.05,3.05L60.677,125.37A2.15,2.15,0,0,1,59.152,126Zm64.7-45.288a2.157,2.157,0,0,1-2.157-2.156V61.305H104.442a2.157,2.157,0,1,1,0-4.313h19.41a2.157,2.157,0,0,1,2.156,2.157V78.558A2.157,2.157,0,0,1,123.852,80.714ZM78.562,126H59.152A2.157,2.157,0,0,1,57,123.845V104.436a2.157,2.157,0,0,1,4.313,0v17.253H78.562A2.157,2.157,0,1,1,78.562,126Zm19.41-38.818A2.157,2.157,0,0,1,96.447,83.5l25.88-25.879a2.156,2.156,0,0,1,3.049,3.05L99.5,86.552A2.149,2.149,0,0,1,97.972,87.184Z'/><path fill='" . $lightbox_icon_color . "' d='M635.621,115.347A30.674,30.674,0,1,1,666.3,84.663h0A30.7,30.7,0,0,1,635.621,115.347Zm0.03-56.659a25.981,25.981,0,1,0,25.964,25.975h0A26,26,0,0,0,635.651,58.688Zm13.861,28.125H621.4a2.344,2.344,0,0,1,0-4.687h28.111A2.344,2.344,0,0,1,649.512,86.813ZM677.623,129a2.329,2.329,0,0,1-1.656-.687l-21.956-21.968a2.343,2.343,0,0,1,3.313-3.314L679.279,125A2.344,2.344,0,0,1,677.623,129Z'/><path fill='" . $lightbox_icon_color . "' d='M452.62,115.347A30.674,30.674,0,0,1,452.649,54h0A30.7,30.7,0,0,1,483.3,84.663h0A30.7,30.7,0,0,1,452.62,115.347Zm0.03-56.659a25.98,25.98,0,1,0,25.966,25.975h0a26,26,0,0,0-25.963-25.975h0Zm13.862,28.125H438.4a2.344,2.344,0,0,1,0-4.687h28.111A2.344,2.344,0,0,1,466.512,86.813Zm-14.055,14.063a2.344,2.344,0,0,1-2.343-2.344V70.406a2.343,2.343,0,1,1,4.685,0V98.531A2.343,2.343,0,0,1,452.457,100.875ZM494.624,129a2.335,2.335,0,0,1-1.657-.687l-21.956-21.968a2.343,2.343,0,0,1,3.313-3.314L496.28,125A2.344,2.344,0,0,1,494.624,129Z'/><path fill='" . $lightbox_icon_color . "' d='M280.972,87.184a2.157,2.157,0,0,1-1.525-3.681l25.88-25.879a2.156,2.156,0,0,1,3.049,3.05L282.5,86.552A2.149,2.149,0,0,1,280.972,87.184Zm-12.939,32.348a2.157,2.157,0,0,1-2.157-2.156V100.123H248.623a2.156,2.156,0,0,1,0-4.313h19.41a2.157,2.157,0,0,1,2.156,2.157v19.409A2.156,2.156,0,0,1,268.033,119.532Zm32.349-32.348h-19.41a2.157,2.157,0,0,1-2.156-2.157V65.618a2.156,2.156,0,1,1,4.313,0V82.871h17.253A2.157,2.157,0,0,1,300.382,87.184ZM242.153,126a2.157,2.157,0,0,1-1.524-3.681l25.879-25.879a2.156,2.156,0,1,1,3.049,3.05L243.678,125.37A2.146,2.146,0,0,1,242.153,126Z'/></svg>\");
							}
						";
					}
				}
			}
			
			// output
			return $advanced_css;
		}
	}

	// instance
	admin_api::$customize['advanced'] = new advanced;
}

?>