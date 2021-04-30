<?php

// -----------------------------------------
// semplice
// admin/atts/modules/oembed.php
// -----------------------------------------

$oembed = array(
	'options' => array(
		'title'  	 => 'Options',
		'hide-title' => true,
		'break'		 => '1,2',
		'data-hide-mobile' => true,
		'url' => array(
			'title'				=> 'oEmbed Link',
			'size'				=> 'span4',
			'data-input-type'	=> 'input-text',
			'data-is-content'	=> true,
			'default'			=> '',
			'placeholder'		=> 'Example: https://vimeo.com/101874310',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
		),
		'type' => array(
			'data-input-type' 	=> 'select-box',
			'title'		 		=> 'Media Type',
			'size'		 		=> 'span2',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'default' 	 		=> 'video',
			'select-box-values' => array(
				'video' 		=> 'Video',
				'other'			=> 'Other',
			),
		),
		'ratio' => array(
			'data-input-type' 	=> 'input-text',
			'title'				=> 'Aspect Ratio',
			'size'				=> 'span2',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'default' 	 		=> '',
			'placeholder'		=> 'Example: 16:9',
			'help'				=> 'If you experience black bars, please add your aspect ratio here. Don\'t forget the colon between width and height (ie. 16:9). You can even use your resolution like: 1280:720',
		),
	),
);

?>