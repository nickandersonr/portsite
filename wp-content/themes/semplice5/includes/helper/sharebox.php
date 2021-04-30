<?php

// ----------------------------------------
// share-box html
// ----------------------------------------

function semplice_share_box_html($options, $id) {

	// get options
	extract( shortcode_atts(
		array(
			'type' 					=> 'icons',
			'icon_text_visibility' 	=> 'visible',
		), $options )
	);

	// id
	if(false === $id) {
		$id = semplice_get_id();
	}

	// facebook
	$facebook = 'href="//facebook.com/sharer.php?u=' . get_the_permalink($id) . '" onclick="window.open(this.href,this.title,\'width=500,height=500,top=200px,left=200px\');  return false;" rel="nofollow" target="_blank"';

	// twitter
	$twitter = 'href="//twitter.com/share?url=' . get_the_permalink($id) . '" onclick="window.open(this.href,this.title,\'width=500,height=500,top=200px,left=200px\');  return false;" rel="nofollow" target="_blank"';

	// twitter
	$linked_in = 'href="//linkedin.com/shareArticle?mini=true&url=' . get_the_permalink($id) . '&title=' . str_replace(' ', '%20', get_the_title($id)) . '" onclick="window.open(this.href,this.title,\'width=500,height=500,top=200px,left=200px\');  return false;" rel="nofollow" target="_blank"';

	// Buttons
	if($type == 'buttons') {
		return '
			<div class="is-content share-box">
				<div class="semplice-share first">
					<div class="text">Facebook</div>
					<div class="share-button button-facebook">
						<a ' . $facebook . '>Share on Facebook</a>
					</div>
				</div>
				<div class="semplice-share">
					<div class="text">Twitter</div>
					<div class="share-button button-twitter">
						<a ' . $twitter . '>Share on Twitter</a>
					</div>
				</div>
				<div class="semplice-share">
					<div class="text">LinkedIn</div>
					<div class="share-button button-linkedin">
						<a ' . $linked_in . '>Share on LinkedIn</a>
					</div>
				</div>
			</div>
		';
	} else {
		return '
			<div class="is-content share-box">
				<div class="share-icons-wrapper">
					<p class="' . $icon_text_visibility . '">Share on</p>
					<div class="semplice-share-icons first">
						<div class="share-icon icon-facebook">
							<a ' . $facebook . '>' . get_svg('frontend', 'networks/facebook') . '</a>
						</div>
					</div>
					<div class="semplice-share-icons">
						<div class="share-icon icon-twitter">
							<a ' . $twitter . '>' . get_svg('frontend', 'networks/twitter') . '</a>
						</div>
					</div>
					<div class="semplice-share-icons">
						<div class="share-icon icon-linkedin">
							<a ' . $linked_in . '>' . get_svg('frontend', 'networks/linkedin') . '</a>
						</div>
					</div>
				</div>
			</div>
		';
	}
}

// ----------------------------------------
// share-box css
// ----------------------------------------

function semplice_share_box_css($options, $id) {
	// css
	$css = '';

	// prefix
	if(false === $id) {
		$prefix = '#share-holder .share-box ';
	} else {
		$prefix = '#content-holder #' . $id . ' .share-box ';
	}
	
	$attributes = array(
		'button_bg_color' 		=> array('.text', 'background-color'),
		'button_border_color' 	=> array('.text', 'border-color'),
		'button_text_color' 	=> array('.text', 'color'),
		'icon_color' 			=> array('.share-icon svg', 'fill'),
		'icon_scale'			=> array('.share-icon svg', 'height'),
		'icon_padding'			=> array('.share-icon a', 'padding'),
		'icon_text_color' 		=> array('.share-icons-wrapper p', 'color'),
		'icon_font_size'		=> array('.share-icons-wrapper p', 'font-size'),
		'icon_letter_spacing'	=> array('.share-icons-wrapper p', 'letter-spacing'),
	);

	// iterate $values
	if(!empty($options)) {
		foreach ($options as $option => $value) {
			// is option in attributes?
			if(isset($attributes[$option]) && !empty($value)) {
				// is padding?
				if($option == 'icon_padding') {
					$value = '0 ' . $value;
				}
				$css .= $prefix . $attributes[$option][0] . ' { ' . $attributes[$option][1] . ': ' . $value . '; }'; 
			}
		}
		// font family
		if(!empty($options['icon_font_family'])) {
			$css .= $prefix . ' .share-icons-wrapper p { ' . semplice_get_font_family($options['icon_font_family']) . ' }';
		}
	}

	// margin to compensate letter spacing
	if(!empty($options['icon_letter_spacing'])) {
		// letter spacing
		$letter_spacing = $options['icon_letter_spacing'];
		// margin
		$margin = '-' . $letter_spacing;
		// is negative?
		if(strpos($letter_spacing, '-') !== false) {
			$margin = str_replace('-', '', $letter_spacing);
		}
		$css .= $prefix . ' .share-icons-wrapper p { margin-right: ' . $margin . '; }';
	}

	return $css;
}

?>