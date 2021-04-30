<?php

// -----------------------------------------
// semplice
// admin/atts/options.php
// -----------------------------------------

$options = array(

	// content options, empty for the module options
	'content' => array(),

	// section options
	'cover' => array(
		'options' => array(
			'title'  => 'Options',
			'break'  => '2,1,1',
			'data-hide-mobile' => true,
			'layout' => array(
				'title'		 => 'Layout',
				'size'		 => 'span2',
				'data-input-type' => 'switch',
				'switch-type'=> 'twoway',
				'class' 	 		=> 'editor-listen',
				'data-handler' 		=> 'layout',
				'default' 	 => 'grid',
				'switch-values' => array(
					'grid'	=> 'Grid',
					'fluid' => 'Fluid',
				),
			),
			'gutter' => array(
				'title'		 => 'Gutter',
				'data-input-type' => 'switch',
				'switch-type'=> 'twoway',
				'size'		 => 'span2',
				'class' 	 		=> 'editor-listen',
				'data-handler' 		=> 'layout',
				'default' 	 => 'yes',
				'switch-values' => array(
					'yes'  => 'Keep',
					'no'   => 'Remove',
				),
			),
			'valign' => array(
				'title'		 => 'Vertical Align',
				'size'		 => 'span4',
				'data-input-type' => 'switch',
				'switch-type'=> 'fourway',
				'class' 	 		=> 'editor-listen',
				'data-handler' 		=> 'layout',
				'default'	 => 'stretch',
				'switch-values' => array(
					'stretch' => 'Stretch',
					'top'     => 'Top',
					'bottom'  => 'Bottom',
					'center'  => 'Center',
				),
			),
			'justify' => array(
				'title'		 => 'Justify',
				'help'		 => 'First three options only take effect if you have free space in your section. (that means your column sizes are combined < 12) For the last two options you need at least 2 columns and the size of your columns is < 12',
				'size'		 => 'span4',
				'data-input-type' => 'switch',
				'switch-type'=> 'fiveway',
				'class' 	 		=> 'editor-listen',
				'data-handler' 		=> 'layout',
				'default'	 => 'left',
				'switch-values' => array(
					'left'     		 => 'Left',
					'right'  		 => 'Right',
					'center' 		 => 'center',
					'space-between'  => 'Space Between',
					'space-around' 	 => 'Space Around'
				),
			),
		),
	),

	// mobile options
	'responsive-lg' => get_responsive_options('lg', 'Desktop' ),
	'responsive-md' => get_responsive_options('md', 'Tablet Wide'),
	'responsive-sm' => get_responsive_options('sm', 'Tablet Portrait'),
	'responsive-xs' => get_responsive_options('xs', 'Phone'),
);

?>