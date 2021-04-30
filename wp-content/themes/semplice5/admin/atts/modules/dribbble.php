<?php

// -----------------------------------------
// semplice
// admin/atts/modules/dribbble.php
// -----------------------------------------

$dribbble = array(
	'refresh-grid' => array(
		'title'  	 => 'Refresh',
		'hide-title' => true,
		'break'		 => '1,3,2',
		'masonry' => array(
			'data-input-type' 	=> 'button',
			'title'		 		=> 'Preview',
			'hide-title'		=> true,
			'button-title'		=> 'Refresh Shots',
			'help'				=> 'If you are happy with your settings, just press the \'Refresh Feed\' button to generate a new preview with your updated settings.',
			'size'		 		=> 'span4',
			'class'				=> 'semplice-button regenerate-masonry',
			'responsive'		=> true,
		),
	),
	'options' => array(
		'title'  	 => 'Options',
		'break'		 => '3,2',
		'data-hide-mobile' => true,
		'hor_gutter' => array(
			'title'			=> 'H-Gutter',
			'size'			=> 'span1',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 30,
			'min'			=> 0,
			'max'			=> 999,
			'class'			=> 'editor-listen',
			'data-handler'  => 'save',
		),
		'ver_gutter' => array(
			'title'			=> 'V-Gutter',
			'size'			=> 'span1',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 30,
			'min'			=> 0,
			'max'			=> 999,
			'class'			=> 'editor-listen',
			'data-handler'  => 'save',
		),
		'col' => array(
			'data-input-type' 	=> 'select-box',
			'title'		 		=> 'Images per Row',
			'size'		 		=> 'span2',
			'class'			=> 'editor-listen',
			'data-handler'  => 'save',
			'default' 	 		=> '4',
			'select-box-values' => array(
				'12' 			=> '1 Image',
				'6' 			=> '2 Images',
				'4' 			=> '3 Images',
				'3' 			=> '4 Images',
				'2' 			=> '6 Images',
				'1' 			=> '12 Images',
			),
		),
		'count' => array(
			'title'			=> 'Images',
			'size'			=> 'span2',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'help'			=> 'Number of Images',
			'default'		=> 15,
			'min'			=> 1,
			'max'			=> 9999,
			'class'			=> 'editor-listen',
			'data-handler'  => 'save',
		),
		'target' => array(
			'data-input-type' => 'switch',
			'switch-type'=> 'twoway',
			'title'		 => 'Lightbox',
			'help'		 => 'If you want your images to be opened in Dribbble, please choose \'No\'.',
			'size'		 => 'span2',
			'class'			=> 'editor-listen',
			'data-handler'  => 'save',
			'default' 	 => 'lightbox',
			'switch-values' => array(
				'lightbox'	 => 'Yes',
				'instagram'  => 'No',
			),
		),
	),
	'disconect-options' => array(
		'title'  	 => 'Disconnect',
		'hide-title' => true,
		'break'		 => '1,3,2',
		'style-class'=> 'no-spacer',
		'data-hide-mobile' => true,
		'disconnect' => array(
			'data-input-type' 	=> 'button',
			'title'		 		=> 'Disconnect',
			'button-title'		=> 'Disconnect Dribbble',
			'help'				=> 'Disconnect if you want to remove Dribbble from your page or change / renew your Dribbble account.',
			'size'		 		=> 'span4',
			'class'				=> 'semplice-button white-button remove-token',
		),
	),
	'responsive_gutter_lg' => get_responsive_gutter('lg', true),
	'responsive_gutter_md' => get_responsive_gutter('md', true),
	'responsive_gutter_sm' => get_responsive_gutter('sm', true),
	'responsive_gutter_xs' => get_responsive_gutter('xs', true),
);

?>