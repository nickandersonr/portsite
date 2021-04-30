<?php

// -----------------------------------------
// semplice
// admin/atts/modules/spacer.php
// -----------------------------------------

$spacer = array(
	'options' => array(
		'title'  	 => 'Options',
		'hide-title' => true,
		'break'		 => '4',
		'data-hide-mobile' => true,
		'background-color' => array(
			'title'				=> 'Color',
			'data-style-option' => true,
			'size'				=> 'span1',
			'data-input-type'	=> 'color',
			'data-target'		=> '.spacer',
			'default'			=> '#e0e0e0',
			'class'				=> 'color-picker admin-listen-handler',
			'data-handler' 		=> 'colorPicker',
		),
		'height' => array(
			'title'				=> 'Height',
			'data-style-option' => true,
			'size'				=> 'span1',
			'offset'			=> false,
			'data-input-type' 	=> 'range-slider',
			'data-target'		=> '.spacer',
			'default'			=> 10,
			'min'				=> 0,
			'max'				=> 999,
			'class'				=> 'editor-listen',
			'data-handler'		=> 'default',
			'data-has-unit' 	=> true,
		),
	),
);

?>