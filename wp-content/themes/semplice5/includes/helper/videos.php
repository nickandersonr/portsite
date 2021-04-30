<?php

// -----------------------------------------
// get background video
// -----------------------------------------

function semplice_background_video($styles, $visibility, $autoplay) {

	// vars
	global $detect;
	$no_fallback = '';
	if(false === semplice_background_video_fallback_image($styles)) {
		$no_fallback = ' no-fallback';
	}
	$video = '<div class="background-video' . $no_fallback . '"></div>';
	$force_autoplay = isset($styles['bg_force_autoplay']) ? $styles['bg_force_autoplay'] : 'disabled';
	// fallback image
	$fallback_image = '';
	if($detect->isMobile()) {
		$fallback_image = ' poster="' . semplice_background_video_fallback_image($styles) . '"';	
	}
	// has bg video?
	if(!empty($styles['bg_video'])) {
		// get video url
		$bg_video = wp_get_attachment_url($styles['bg_video']);
	} else if(isset($styles['bg_video_url'])) {
		$bg_video = $styles['bg_video_url'];
	}
	// autoplay
	if(true === $autoplay) {
		$autoplay = 'data-autoplay autoplay ';
	}
	// is url?
	if(!empty($bg_video) && $visibility == 'frontend') {
		if(!$detect->isMobile() || $detect->isMobile() && $force_autoplay == 'enabled') {
			$video = '
				<div class="background-video">
					<video ' . $autoplay . 'webkit-playsinline playsinline loop muted data-object-fit="cover"' . $fallback_image . '>
						<source src="' . $bg_video . '" type="video/mp4">
					</video>
				</div>
			';
		}
	}

	// return
	return $video;
}

// -----------------------------------------
// get background video fallback
// -----------------------------------------

function semplice_background_video_fallback($styles, $id, $visibility) {
	// mobile detection
	global $detect;
	// is cover?
	if (strpos($id, 'cover') !== false) {
		$id = $id . ' .semplice-cover-inner';
	}
	// css
	$css = '#content-holder #' . $id . ' > .background-video {';
	// force autoplay
	$force_autoplay = isset($styles['bg_force_autoplay']) ? $styles['bg_force_autoplay'] : 'disabled';
	// get fallback image
	$fallback_image = semplice_background_video_fallback_image($styles);
	// is fallback image there?
	if(false !== $fallback_image) {
		// only show in editor or mobile frontend
		if($visibility == 'editor' || $detect->isMobile() && $force_autoplay == 'disabled') {
			// css code
			$css .= 'background-image: url(' . $fallback_image . '); background-size: cover;';
		}
	}
	// bg color on frontend
	if($visibility == 'frontend') {
		// bg color
		$css .= semplice_get_bg_css($styles);
	}
	// close css
	$css .= '}';
	// bg video opacity
	if(isset($styles['bg_video_opacity'])) {
		$css .= '#content-holder #' . $id . ' > .background-video video { opacity: ' . $styles['bg_video_opacity'] . '; }';
	}
	// return css
	return $css;
}

// -----------------------------------------
// get background video fallback image
// -----------------------------------------

function semplice_background_video_fallback_image($styles) {
	// vars
	$image = false;
	// check if fallback image is set
	if(isset($styles['bg_video_fallback'])) {
		if(is_numeric($styles['bg_video_fallback'])) {
			// get img
			$image = wp_get_attachment_image_src($styles['bg_video_fallback'], 'full', false);

			// image found?
			if($image) {
				$image = $image[0];
			} else {
				$image = get_template_directory_uri() . '/assets/images/admin/preview_notfound.svg';
			}
		} else {
			$image = semplice_get_external_image($styles['bg_video_fallback']);
			$image = $image['url'];
		}
	}
	// return
	return $image;
}

// -----------------------------------------
// get video type
// -----------------------------------------

function semplice_get_video_type($src) {
	// parse url for the file extension and make sure there are not url parameters
	$get_ext = parse_url($src);

	// get video type
	$type = substr($get_ext['path'], -3);

	if($type == 'ogv') {
		$type = 'ogg';
	} elseif ($type == 'ebm') {
		$type = 'webm';
	}

	// ret
	return $type;
}