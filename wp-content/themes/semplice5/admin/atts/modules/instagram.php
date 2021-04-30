<?php

// -----------------------------------------
// semplice
// admin/atts/modules/instagram.php
// -----------------------------------------

$instagram = array(
	'refresh-grid' => array(
		'title'  	 => 'Refresh',
		'hide-title' => true,
		'break'		 => '1',
		'masonry' => array(
			'data-input-type' 	=> 'button',
			'title'		 		=> 'Preview',
			'hide-title'		=> true,
			'button-title'		=> 'Refresh Feed',
			'help'				=> 'If you are happy with your settings, just press the \'Refresh Feed\' button to generate a new preview with your updated settings.',
			'size'		 		=> 'span4',
			'class'				=> 'semplice-button regenerate-masonry',
			'responsive'		=> true,
		),
	),
	'options' => array(
		'title'  	 => 'Options',
		'break'		 => '3,2,1',
		'data-hide-mobile' => true,
		'hor_gutter' => array(
			'title'			=> 'H-Gutter',
			'size'			=> 'span1',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 30,
			'min'			=> 0,
			'max'			=> 999,
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'save',
		),
		'ver_gutter' => array(
			'title'			=> 'V-Gutter',
			'size'			=> 'span1',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 30,
			'min'			=> 0,
			'max'			=> 999,
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'save',
		),
		'col' => array(
			'data-input-type' 	=> 'select-box',
			'title'		 		=> 'Images per Row',
			'size'		 		=> 'span2',
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'save',
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
			'title'			=> 'Number of Images',
			'size'			=> 'span2',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'help'			=> 'The limit is 20 images.',
			'default'		=> 20,
			'min'			=> 1,
			'max'			=> 20,
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'save',
		),
		'target' => array(
			'data-input-type' => 'switch',
			'switch-type'=> 'twoway',
			'title'		 => 'Lightbox',
			'help'		 => 'If you want your images to open in Instagram, please choose \'No\'.',
			'size'		 => 'span2',
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'save',
			'default' 	 => 'lightbox',
			'switch-values' => array(
				'lightbox'	 => 'Yes',
				'instagram'  => 'No',
			),
		),
		'random' => array(
			'data-input-type' 	=> 'select-box',
			'title'		 		=> 'Random Grid',
			'size'		 		=> 'span4',
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'save',
			'default' 	 		=> 'disabled',
			'help'				=> 'This feature will override the \'Images Per Row\' setting.',
			'select-box-values' => array(
				'disabled'		=> 'Disabled',
				'2.4' 			=> 'Small: 2 Col, Big: 4 Col',
				'3.6' 			=> 'Small: 3 Col, Big: 6 Col',
				'4.8' 			=> 'Small: 4 Col, Big: 8 Col',
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
			'button-title'		=> 'Disconnect Instagram',
			'help'				=> 'Disconnect if you want to remove Instagram from your page or change / renew your Instagram account.',
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