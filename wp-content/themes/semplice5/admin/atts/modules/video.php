<?php

// -----------------------------------------
// semplice
// admin/atts/modules/video.php
// -----------------------------------------

$video = array(
	'video-upload' => array(
		'title'  	 => 'Video Upload',
		'break'		 => '1,1',
		'data-hide-mobile' => true,
		'video' => array(
			'title'			=> 'Video Upload',
			'size'			=> 'span4',
			'help'			=> 'Please upload a .mp4 file. If a \'Download\' button is visible in the front end instead of your video, you are using a wrong format.',
			'data-input-type' => 'video-upload',
			'default'		=> '',
			'data-is-content' => true,
			'data-upload'	=> 'contentVideo',
			'hide-title' => true,
		),
		'video_url' => array(
			'data-input-type'	=> 'input-text',
			'title'		 	=> 'or direct url link',
			'help'			=> 'If your video is too big to upload into the WordPress media library or you want to include a video from an external source (like a CDN), you can paste the link here.<br /><br /> For the video module it is not possible to post links from Vimeo, Youtube etc. Please use the oEmbed module for this.<br /><br />Recommended video format: .mp4',
			'size'		 	=> 'span4',
			'placeholder'	=> 'http://my.cdn.com/video.mp4',
			'default'		=> '',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
		),
	),
	'poster-aspect' => array(
		'title'  	 => 'Poster &amp; Aspect Ratio',
		'break'		 => '2',
		'style-class'=> 'ep-collapsed',
		'data-hide-mobile' => true,
		'poster' => array(
			'title'			=> 'Fallback Image',
			'help'			=> 'This fallback image will be displayed on mobile devices instead of your video and it will be a placeholder in the editor.',
			'size'			=> 'span2',
			'data-input-type'	=> 'admin-image-upload',
			'default'		=> '',
			'class'			=> 'editor-listen',
			'style-class'   => 'ce-upload-small hide-unsplash'
			),
		'ratio' => array(
			'data-input-type' 	=> 'input-text',
			'title'				=> 'Aspect Ratio',
			'size'				=> 'span2',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'default' 	 		=> '',
			'placeholder'		=> 'Example: 16:9',
			'help'				=> 'If you experience black bars (mostly with non 16:9 aspect ratios), please add your aspect ratio here. Examples: 16:9. You can even just use your resolution like: 1280:720. (don\'t forget the colon between width and height)',
		),
	),
	'autoplay-option' => array(
		'title' => 'Autoplay',
		'break' => '1',
		'data-hide-mobile' => true,
		'hide-title' => true,
		'autoplay' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 	  => 'Autoplay',
			'size'		 	  => 'span4',
			'hide-title' => true,
			'class'      		=> 'editor-listen',
			'data-handler' 		=> 'save',
			'default' 	 	  => 'off',
			'data-on'		  => 'on',
			'data-off'		  => 'off',
		),
	),
	'loop-option' => array(
		'title' => 'Loop',
		'break' => '1',
		'data-hide-mobile' => true,
		'hide-title' => true,
		'loop' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 	  => 'Loop',
			'size'		 	  => 'span4',
			'hide-title' => true,
			'class'      		=> 'editor-listen',
			'data-handler' 		=> 'save',
			'default' 	 	  => 'off',
			'data-on'		  => 'on',
			'data-off'		  => 'off',
		),
	),
	'muted-option' => array(
		'title' => 'Muted',
		'break' => '1',
		'data-hide-mobile' => true,
		'hide-title' => true,
		'muted' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 	  => 'Muted',
			'size'		 	  => 'span4',
			'hide-title' => true,
			'class'      		=> 'editor-listen',
			'data-handler' 		=> 'save',
			'default' 	 	  => 'off',
			'data-on'		  => 'on',
			'data-off'		  => 'off',
		),
	),
	'hide-controls-option' => array(
		'title' => 'Hide Controls',
		'break' => '1',
		'data-hide-mobile' => true,
		'hide-title' => true,
		'hide_controls' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 	  => 'Hide Controls',
			'size'		 	  => 'span4',
			'hide-title' => true,
			'class'      		=> 'editor-listen',
			'data-handler' 		=> 'save',
			'default' 	 	  => 'off',
			'data-on'		  => 'on',
			'data-off'		  => 'off',
		),
	),
);

?>