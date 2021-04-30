<?php

// -----------------------------------------
// semplice
// admin/atts/customize/grid.php
// -----------------------------------------

$grid = array(
	'tabs' => array(
		'options' => array(
			'grid-sizes' => array(
				'title'  	 => 'Grid',
				'hide-title' => true,
				'break'		 => '1',
				'values' => array(
					'title'				=> 'Grid Sizes',
					'size'				=> 'span4',
					'data-input-type'	=> 'button',
					'help'				=> 'In this popup you can view your grid sizes based on the grid width you defined. Once you change the grid width the popup will also get updated.',
					'button-title'		=> 'Show grid sizes',
					'class'				=> 'admin-click-handler semplice-button white-button',
					'data-handler'		=> 'execute',
					'data-action'		=> 'gridSizes',
					'data-action-type'	=> 'popup',
				),
			),
			'width-options' => array(
				'title'  	 => 'Grid',
				'break'		 => '2',
				'width' => array(
					'title'				=> 'Width',
					'help'				=> 'Important: If your grid width is bigger than your browser window the preview will not be displayed correctly. The minimum grid width is 1170px',
					'size'				=> 'span2',
					'offset'			=> false,
					'data-input-type' 	=> 'range-slider',
					'class'				=> 'grid-width admin-listen-handler',
					'data-handler'		=> 'gridSettings',
					'default'			=> 1170,
					'min'				=> 1170,
					'max'				=> 9999,
					'data-range-slider' => 'gridSettings',
				),
				'outer_padding' => array(
					'title'				=> 'Outer Padding',
					'help'				=> 'To avoid that your grid sticks to the browser edges, there is always a outer padding on both sides of your grid.<br /><br />This setting only applies for the desktop breakpoint. On non-desktop and mobile breakpoints the outer padding will default to 30px (tablets) and 20px (mobile)<br /><br />Note: There is no preview for this setting and it will be only visible in the frontend.',
					'size'				=> 'span2',
					'offset'			=> false,
					'data-input-type' 	=> 'range-slider',
					'class'				=> 'admin-listen-handler',
					'data-handler'		=> 'gridSettings',
					'default'			=> 30,
					'min'				=> 0,
					'max'				=> 9999,
					'data-range-slider' => 'gridSettings',
				),
			),
			'gutter-options' => array(
				'title'  	 => 'Gutter Width',
				'break'		 => '2',
				'gutter' => array(
					'title'				=> 'Desktop',
					'size'				=> 'span2',
					'offset'			=> false,
					'data-input-type' 	=> 'range-slider',
					'class'				=> 'admin-listen-handler',
					'data-handler'		=> 'gridSettings',
					'default'			=> 30,
					'min'				=> 0,
					'max'				=> 100,
					'data-range-slider' => 'gridSettings',
				),
				'responsive_gutter' => array(
					'title'				=> 'Responsive',
					'help'				=> 'The responsive gutter is for all your mobile breakpoints starting from < 1170px. Note: There is no preview for the mobile gutter.',
					'size'				=> 'span2',
					'offset'			=> false,
					'data-input-type' 	=> 'range-slider',
					'class'				=> 'admin-listen-handler',
					'data-handler'		=> 'gridSettings',
					'default'			=> 30,
					'min'				=> 0,
					'max'				=> 100,
					'data-range-slider' => 'gridSettings',
				),
			),
		),
	),
);