<?php

// -----------------------------------------
// semplice
// admin/atts/branding.php
// -----------------------------------------

$branding = array(
	'left' => array(
		'background' => array(
			'title' => 'Background',
			'hide-title'	=> true,
			'break'	=> '1,2,1,1',
			'background-color' => array(
				'title'			=> 'Background Options',
				'size'			=> 'span4',
				'data-input-type'	=> 'color',
				'default'		=> 'transparent',
				'class'			=> 'color-picker admin-listen-handler',
				'data-handler'  => 'colorPicker',
				'data-picker'	=> 'branding',
			),
			'background-image' => array(
				'title'			=> 'Image',
				'hide-title'	=> true,
				'size'			=> 'span2',
				'data-input-type'	=> 'admin-image-upload',
				'style-class'	=> 'ce-upload-small general-dropzone hide-unsplash',
				'default'		=> '',
				'data-upload'	=> 'brandingBackground',
			),
			'background-size' => array(
				'title'			=> 'Options',
				'hide-title'	=> true,
				'size'			=> 'span2',
				'stack'			=> 'vertical-start',
				'data-input-type'    => 'select-box',
				'class'			=> 'editor-listen',
				'data-handler'	=> 'default',
				'default'		=> 'auto',
				'select-box-values' => array(
					'auto'		=> 'No Scale',
					'cover' 	=> 'Cover (full width)',
					'contain'	=> 'Contain'
				),
			),
			'background-position' => array(
				'title'			=> 'Position',
				'hide-title'	=> true,
				'size'			=> 'span2',
				'stack'			=> 'vertical',
				'data-input-type'    => 'select-box',
				'class'			=> 'editor-listen',
				'data-handler'	=> 'default',
				'default'		=> '0% 0%',
				'select-box-values' => array(
					'0% 0%' 	=> 'Top Left',
					'50% 0%' 	=> 'Top Center',
					'100% 0%' 	=> 'Top Right',
					'0% 50%' 	=> 'Middle Left',
					'50% 50%' 	=> 'Middle Center',
					'100% 50%' 	=> 'Middle Right',
					'0% 100%' 	=> 'Bottom Left',
					'50% 100%' 	=> 'Bottom Center',
					'100% 100%' => 'Bottom Right'
				),
			),
			'background-repeat' => array(
				'title'			=> 'Repeat',
				'hide-title'	=> true,
				'size'			=> 'span2',
				'stack'			=> 'vertical-end',
				'data-input-type'    => 'select-box',
				'class'			=> 'editor-listen',
				'data-handler'	=> 'default',
				'default'		=> 'repeat',
				'select-box-values' => array(
					'repeat' 	=> 'Repeat both',
					'repeat-x' 	=> 'Repeat horizontal',
					'repeat-y' 	=> 'Repeat vertical',
					'no-repeat' => 'No Repeat',
				),
			),
		),
		'background-attachment-option' => array(
			'title' 	 => 'Background Attachment',
			'hide-title' => true,
			'background-attachment' => array(
				'title'			=> 'Background Attachment',
				'size'			=> 'span4',
				'data-input-type'    => 'select-box',
				'class'			=> 'editor-listen',
				'data-handler'	=> 'default',
				'default'		=> 'scroll',
				'select-box-values' => array(
					'scroll' 	=> 'None',
					'fixed' 	=> 'Fixed',
				),
			),
		),
	),
	'right' => array(
		'back-to-top' => array(
			'title' 	 => 'Back to top arrow color',
			'hide-title' => true,
			'top_arrow_color' => array(
				'title'			=> 'Back to top arrow color',
				'size'			=> 'span4',
				'data-input-type'	=> 'color',
				'default'		=> 'transparent',
				'class'			=> 'color-picker admin-listen-handler',
				'data-handler'  => 'colorPicker',
				'data-picker'	=> 'branding',
			),
		),
		'custom-css' => array(
			'title' 	 => 'Custom CSS',
			'hide-title' => true,
			'custom_post_css' 	=> array(
				'title'				=> 'Custom CSS',
				'size'				=> 'span4',
				'help'				=> '',
				'data-input-type'	=> 'codemirror',
				'placeholder'		=> '',
				'default'			=> '',
				'button-title'		=> 'Edit Custom css',
				'class'				=> 'semplice-button codemirror white-button admin-click-handler',
				'data-handler'		=> 'codemirror',
			),
		),
		'scroll-reavel' => array(
			'title'	 		=> 'Scroll Reveal',
			'hide-title'	=> true,
			'scroll_reveal' => array(
				'title'			=> 'Reveal content on scroll',
				'help'			=> 'If this setting is \'Enabled\' the custom animations on the page will be disabled. It\'s not possible to run custom animations and scroll reveal at the same time.',
				'size'			=> 'span4',
				'data-input-type'    => 'select-box',
				'class'			=> 'editor-listen',
				'data-handler'	=> 'default',
				'default'		=> 'enabled',
				'select-box-values' => array(
					'enabled'   => 'Enabled',
					'disabled'  => 'Disabled',
				),
			),
		),
		'motion-reset' => array(
			'title' 	 => 'Reset Animations',
			'hide-title' => true,
			'custom_post_css' 	=> array(
				'title'				=> 'Reset Custom Animations',
				'help'				=> 'Please note that this will reset all custom animations you are added to this page or project.',
				'size'				=> 'span4',
				'help'				=> '',
				'data-input-type'	=> 'button',
				'placeholder'		=> '',
				'default'			=> '',
				'button-title'		=> 'Reset Animations',
				'class'				=> 'semplice-button white-button reset-animations',
			),
		),
		'display-content' => array(
			'title'	 		=> 'Content Vertical Position',
			'hide-title'	=> true,
			'display_content' => array(
				'title'			=> 'Display Content',
				'size'			=> 'span4',
				'data-input-type'    => 'switch',
				'switch-type' => 'twoway',
				'class'			=> 'editor-listen',
				'data-handler'	=> 'default',
				'default'		=> 'navbar',
				'switch-values' => array(
					'navbar'   => 'After Navigation',
					'top'  => 'Straight on Top',
				),
			),
		),
	),
);

?>