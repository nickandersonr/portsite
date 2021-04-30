<?php

// -----------------------------------------
// semplice
// admin/atts.php
// -----------------------------------------

// -----------------------------------------
// Default Fonts
// -----------------------------------------

$fonts = semplice_get_default_fonts('display', false);

// -----------------------------------------
// Easings
// -----------------------------------------

$easings = array(
	'none'				=> 'None (linear)',
	'Power1.easeIn'		=> 'Power1.easeIn',
	'Power1.easeInOut'	=> 'Power1.easeInOut',
	'Power1.easeOut'	=> 'Power1.easeOut',
	'Power2.easeIn'		=> 'Power2.easeIn',
	'Power2.easeInOut'	=> 'Power2.easeInOut',
	'Power2.easeOut'	=> 'Power2.easeOut',
	'Power3.easeIn'		=> 'Power3.easeIn',
	'Power3.easeInOut'	=> 'Power3.easeInOut',
	'Power3.easeOut'	=> 'Power3.easeOut',
	'Power4.easeIn'		=> 'Power4.easeIn',
	'Power4.easeInOut'	=> 'Power4.easeInOut',
	'Power4.easeOut'	=> 'Power4.easeOut',
	'Bounce.easeIn'		=> 'Bounce.easeIn',
	'Bounce.easeInOut'	=> 'Bounce.easeInOut',
	'Bounce.easeOut'	=> 'Bounce.easeOut',
	'Circ.easeIn'		=> 'Circ.easeIn',
	'Circ.easeInOut'	=> 'Circ.easeInOut',
	'Circ.easeOut'		=> 'Circ.easeOut',
	'Expo.easeIn'		=> 'Expo.easeIn',
	'Expo.easeInOut'	=> 'Expo.easeInOut',
	'Expo.easeOut'		=> 'Expo.easeOut',
	'Sine.easeIn'		=> 'Sine.easeIn',
	'Sine.easeInOut'	=> 'Sine.easeInOut',
	'Sine.easeOut'		=> 'Sine.easeOut',
);

// -----------------------------------------
// Helper
// -----------------------------------------

// responsive options
function get_responsive_options($breakpoint, $title) {

	$atts = array(
		'break'	  => '1,1,1,1,1,1,1,1',
		'title'   => $title . ' options',
		'reset-changes' => array(
			'data-input-type' 	=> 'button',
			'title'		 		=> 'Reset Mobile',
			'button-title'		=> 'Reset Mobile Changes',
			'help'				=> 'This will reset all changes made to the section in this breakpoint to the \'Desktop\' breakpoint. This includes styles, options and content changes.',
			'size'		 		=> 'span4',
			'class'				=> 'semplice-button reset-changes white-button',
			'responsive' 		=> true,
			'data-core-option' => true,
		),
		'copy-styles' => array(
			'data-input-type' 	=> 'select-box',
			'title'		 		=> 'Copy Changes from',
			'help'				=> 'This will copy all changes made to the section from your selected breakpoint. This includes styles, options and content changes.',
			'size'		 		=> 'span4',
			'class'				=> 'copy-styles',
			'responsive' 		=> true,
			'data-core-option' => true,
			'select-box-values' => array(
				'false' => 'Select Breakpoint',
				'xs' => 'Phone',
				'sm' => 'Tablet Portrait',
				'md' => 'Tablet Wide',
				'lg' => 'Desktop',
				'xl' => 'Desktop Wide',
			),
		),
		$breakpoint . '-visibility' => array(
			'title'		 		=> 'Visibility',
			'size'		 		=> 'span4',
			'data-input-type' 	=> 'switch',
			'switch-type'		=> 'twoway',
			'class' 	 		=> 'editor-listen',
			'data-handler'		=> 'layout',
			'default' 	 		=> 'visbile',
			'data-content-id'	=> '',
			'responsive' 		=> true,
			'data-core-option' => true,
			'switch-values' 	=> array(
				'visbile'		=> 'Visible',
				'hide' 			=> 'Hide',
			),
		),
	);

	// column mode
	if($breakpoint == 'sm' || $breakpoint == 'xs') {
		$column_mode = array(
			'title'		 => 'Column Mode',
			'size'		 => 'span4',
			'data-input-type' => 'switch',
			'switch-type'=> 'twoway',
			'class' 	 	=> 'editor-listen',
			'data-handler'	=> 'layout',
			'default' 	 => 'single',
			'data-content-id' => '',
			'responsive' => true,
			'data-core-option' => true,
			'switch-values' => array(
				'single'	=> 'Single',
				'multi' => 'Multi',
			),
		);
		// add to atts
		$atts['column-mode-' . $breakpoint] = $column_mode;
	}

	return $atts;
}

// thumb hover
function get_thumb_hover_options($option, $fonts) {
	if($option == 'scale') {
		$atts = array(
			'break' 	  => '1,2',
			'class'		  => 'custom-hover',
			'title'		  => 'Scale Thumbnail',
			'style-class' => 'ep-collapsed',
			'hover_scale' => array(
				'title'				=> 'Scale Status',
				'data-input-type' 	=> 'switch',
				'switch-type'		=> 'twoway',
				'size'				=> 'span4',
				'class'				=> 'ps-setting admin-listen-handler',
				'data-ps-type' 		=> 'thumbnail',
				'data-handler'		=> 'thumbHover',
				'default'			=> 'noscale',
				'switch-values' => array(
					'noscale'	=> 'Disabled',
					'scale'		=> 'Enabled'
				),
			),
			'hover_scale_amount' => array(
				'title'					=> 'Scale (in %)',
				'help'					=> 'Define the amount the thumbnail should get scaled on mouseover. (in %)',
				'size'					=> 'span2',
				'offset'				=> false,
				'data-input-type' 		=> 'range-slider',
				'min'					=> 0,
				'default'				=> 15,
				'max'					=> 70,
				'class'					=> 'ps-setting admin-listen-handler',
				'data-handler'			=> 'thumbHover',
				'data-ps-type' 			=> 'thumbnail',
				'data-target'			=> '.thumb-hover',
				'data-range-slider'		=> 'thumbHover',
			),
			'hover_scale_duration' => array(
				'title'					=> 'Duration (ms)',
				'help'					=> 'Duration of your scale transition in milliseconds.',
				'size'					=> 'span2',
				'offset'				=> false,
				'data-input-type' 		=> 'range-slider',
				'min'					=> 0,
				'default'				=> 300,
				'max'					=> 5000,
				'data-divider'			=> 1000,
				'class'					=> 'ps-setting admin-listen-handler',
				'data-handler'			=> 'thumbHover',
				'data-ps-type' 			=> 'thumbnail',
				'data-target'			=> '.thumb-hover',
				'data-range-slider'		=> 'thumbHover',
			),

		);
	} else if($option == 'shadow') {
		// box shadow
		$atts = array(
			'title' => 'Drop Shadow',
			'break'	=> '4,3',
			'class' => 'ep-styles-box-shadow',
			'style-class' => 'ep-collapsed',
			'box-shadow-color' => array(
				'title'			=> 'Color',
				'size'			=> 'span1',
				'offset'		=> false,
				'data-input-type' 	=> 'color',
				'default'		=> '#000000',
				'class'			=> 'color-picker admin-listen-handler',
				'data-handler'  => 'colorPicker',
				'data-ps-type'  => 'thumbnail',
				'responsive'	=> true,
				'data-picker'	=> 'thumbHover',
			),
			'box-shadow-h-length' => array(
				'title'			=> 'H Length',
				'size'			=> 'span1',
				'offset'		=> false,
				'data-input-type' 	=> 'range-slider',
				'default'		=> 0,
				'min'			=> 0,
				'max'			=> 999,
				'data-has-unit'	=> true,
				'class'			=> 'ps-setting admin-listen-handler box-shadow-hover',
				'data-handler'	=> 'thumbHover',
				'data-ps-type' 	=> 'thumbnail',
				'data-target'	=> '.thumb-hover',
				'data-range-slider'	=> 'thumbHover',
			),
			'box-shadow-v-length' => array(
				'title'			=> 'V Length',
				'size'			=> 'span1',
				'offset'		=> false,
				'data-input-type' 	=> 'range-slider',
				'default'		=> 0,
				'min'			=> 0,
				'max'			=> 999,
				'data-has-unit'	=> true,
				'class'			=> 'ps-setting admin-listen-handler box-shadow-hover',
				'data-handler'	=> 'thumbHover',
				'data-ps-type' 	=> 'thumbnail',
				'data-target'	=> '.thumb-hover',
				'data-range-slider'	=> 'thumbHover',
			),
			'box-shadow-blur-radius' => array(
				'title'			=> 'Blur',
				'size'			=> 'span1',
				'offset'		=> false,
				'data-input-type' 	=> 'range-slider',
				'default'		=> 0,
				'min'			=> 0,
				'max'			=> 999,
				'data-has-unit'	=> true,
				'class'			=> 'ps-setting admin-listen-handler box-shadow-hover',
				'data-handler'	=> 'thumbHover',
				'data-ps-type' 	=> 'thumbnail',
				'data-target'	=> '.thumb-hover',
				'data-range-slider'	=> 'thumbHover',
			),
			'box-shadow-spread-radius' => array(
				'title'			=> 'Spread',
				'size'			=> 'span1',
				'data-input-type' 	=> 'range-slider',
				'default'		=> 0,
				'min'			=> 0,
				'max'			=> 999,
				'data-has-unit'	=> true,
				'class'			=> 'ps-setting admin-listen-handler box-shadow-hover',
				'data-handler'	=> 'thumbHover',
				'data-ps-type' 	=> 'thumbnail',
				'data-target'	=> '.thumb-hover',
				'data-range-slider'	=> 'thumbHover',
			),
			'box-shadow-opacity' => array(
				'title'			=> 'Opacity',
				'size'			=> 'span1',
				'offset'		=> false,
				'data-input-type' 	=> 'range-slider',
				'min'			=> 0,
				'max'			=> 100,
				'default'		=> 100,
				'class'			=> 'ps-setting admin-listen-handler box-shadow-hover',
				'data-handler'	=> 'thumbHover',
				'data-ps-type' 	=> 'thumbnail',
				'data-target'	=> '.thumb-hover',
				'data-range-slider'	=> 'thumbHover',
			),
			'hover_box_shadow_duration' => array(
				'title'					=> 'Duration (ms)',
				'help'					=> 'Duration of your shadow transition in milliseconds.',
				'size'					=> 'span2',
				'offset'				=> false,
				'data-input-type' 		=> 'range-slider',
				'min'					=> 0,
				'default'				=> 300,
				'max'					=> 5000,
				'data-divider'			=> 1000,
				'class'					=> 'ps-setting admin-listen-handler',
				'data-handler'			=> 'thumbHover',
				'data-ps-type' 			=> 'thumbnail',
				'data-target'			=> '.thumb-hover',
				'data-range-slider'		=> 'thumbHover',
			),
		);
	} else if($option == 'background-type') {
		$atts = array(
			'title' => 'Background Type',
			'break' => '1',
			'style-class' => 'custom-hover no-spacer bg-type-switch no-pt',
			'hide-title' => true,
			'hover_bg_type' => array(
				'data-input-type' 			=> 'switch',
				'switch-type'				=> 'twoway',
				'title'		 				=> 'Background Type',
				'hide-title'				=> true,
				'size'		 				=> 'span4',
				'data-visibility-switch' 	=> true,
				'data-visibility-values' 	=> 'img,vid',
				'data-visibility-prefix'	=> 'ov-bg-type-thumbhover',
				'default' 	 				=> 'img',
				'class'						=> 'ps-setting admin-listen-handler',
				'data-handler'				=> 'thumbHover',
				'data-ps-type' 				=> 'thumbnail',
				'switch-values' => array(
					'img'  	=> 'Image',
					'vid'	=> 'Video',
				),
			),
		);
	} else if($option == 'background-color') {
		$atts = array(
			'break' 	  => '2',
			'style-class' => 'custom-hover no-spacer',
			'title'		  => 'Background Options',
			'hover_bg_color' => array(
				'title'				=> 'Color',
				'size'				=> 'span1',
				'data-input-type'	=> 'color',
				'data-target'		=> '.thumb-hover',
				'default'			=> '#000000',
				'class'				=> 'color-picker admin-listen-handler',
				'data-ps-type' 		=> 'thumbnail',
				'data-handler'  	=> 'colorPicker',
				'data-picker'		=> 'thumbHover',
				'data-css-attribute'=> 'background-color',
			),
			'hover_bg_color_opacity' => array(
				'title'					=> 'Color Opacity',
				'size'					=> 'span2',
				'offset'				=> false,
				'data-input-type' 		=> 'range-slider',
				'min'					=> 0,
				'default'				=> 50,
				'max'					=> 100,
				'data-divider'			=> 100,
				'class'					=> 'ps-setting admin-listen-handler',
				'data-handler'			=> 'thumbHover',
				'data-ps-type' 			=> 'thumbnail',
				'data-target'			=> '.thumb-hover',
				'data-range-slider'		=> 'thumbHover',
			),
		);
	} else if($option == 'background-image') {
		$atts = array(
			'break' 	  => '2,2',
			'style-class' => 'custom-hover  bg-img-upload ov-bg-type-thumbhover-img',
			'title'		  => 'Background',
			'hide-title'   => true,
			'has-media'    => 'thumbHover,hover_bg_image',
			'hover_bg_image' => array(
				'title'			=> 'Image',
				'size'			=> 'span2',
				'hide-title'	=> true,
				'data-input-type'	=> 'admin-image-upload',
				'data-target'	=> '.thumb-hover',
				'default'		=> '',
				'data-upload'	=> 'hoverBgImage',
				'style-class'	=> 'ov-bg-type-thumbhover-img ce-dropzone hide-unsplash general-dropzone',
			),
			'hover_bg_size' => array(
				'title'				=> 'Options',
				'hide-title'		=> true,
				'size'				=> 'span2',
				'stack'				=> 'vertical-start',
				'data-input-type'   => 'select-box',
				'class'				=> 'ps-setting admin-listen-handler',
				'data-handler'		=> 'thumbHover',
				'data-ps-type' 		=> 'thumbnail',
				'data-target'		=> '.thumb-hover',
				'default'			=> 'auto',
				'data-css-attribute'=> 'background-size',
				'style-class'	=> 'ov-bg-type-thumbhover-img',
				'select-box-values' => array(
					'auto'		=> 'No Scale',
					'cover' 	=> 'Cover (full width)',
				),
			),
			'hover_bg_position' => array(
				'title'				=> 'Position',
				'hide-title'		=> true,
				'size'				=> 'span2',
				'stack'				=> 'vertical',
				'data-input-type'    => 'select-box',
				'class'				=> 'ps-setting admin-listen-handler',
				'data-handler'		=> 'thumbHover',
				'data-ps-type' 		=> 'thumbnail',
				'data-target'		=> '.thumb-hover',
				'default'			=> '0% 0%',
				'data-css-attribute'=> 'background-position',
				'style-class'	=> 'ov-bg-type-thumbhover-img',
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
				'responsive'	=> true,
			),
			'hover_bg_repeat' => array(
				'title'				=> 'Repeat',
				'hide-title'		=> true,
				'size'				=> 'span2',
				'stack'				=> 'vertical-end',
				'data-input-type'   => 'select-box',
				'class'				=> 'ps-setting admin-listen-handler',
				'data-handler'		=> 'thumbHover',
				'data-ps-type' 		=> 'thumbnail',
				'data-target'		=> '.thumb-hover',
				'default'			=> 'no-repeat',
				'data-css-attribute'=> 'background-repeat',
				'style-class'	=> 'ov-bg-type-thumbhover-img',
				'select-box-values' => array(
					'no-repeat' => 'No Repeat',
					'repeat-x' 	=> 'Repeat horizontal',
					'repeat-y' 	=> 'Repeat vertical',
					'repeat' 	=> 'Repeat both'
				),
			),
		);
	} else if($option == 'background-video') {
		$atts = array(
			'title'			=> 'Background Video',
			'class'		  => 'custom-hover ov-bg-type-thumbhover-vid',
			'hide-title'	=> true,
			'break'			=> '1,1,1',
			'bg_video' => array(
				'title'			=> 'Video Upload',
				'size'			=> 'span4',
				'hide-title'	=> true,
				'data-input-type' => 'video-upload',
				'default'		=> '',
				'class'			=> 'ps-setting admin-listen-handler',
				'data-handler'	=> 'thumbHover',
				'style-class'	=> 'ov-bg-type-thumbhover-vid',
				'data-upload'	=> 'hoverBgImage',
				'data-ps-type' 		=> 'thumbnail',
			),
			'bg_video_url' => array(
				'data-input-type'	=> 'input-text',
				'title'		 	=> 'or use external video',
				'size'		 	=> 'span4',
				'placeholder'	=> 'http://my.cdn.com/video.mp4',
				'default'		=> '',
				'class'			=> 'ps-setting admin-listen-handler',
				'data-handler'	=> 'thumbHover',
				'data-ps-type' 		=> 'thumbnail',
				'style-class'	=> 'ov-bg-type-thumbhover-vid',
			),
			'bg_video_opacity' => array(
				'title'			=> 'Video Opacity',
				'size'			=> 'span4',
				'data-input-type' 	=> 'range-slider',
				'data-target'	=> '.background-video',
				'default'		=> 100,
				'min'			=> 0,
				'max'			=> 100,
				'class'			=> 'ps-setting admin-listen-handler',
				'data-handler'	=> 'thumbHover',
				'data-divider'  => 100,
				'style-class'	=> 'ov-bg-type-thumbhover-vid',
				'data-ps-type' 		=> 'thumbnail',
				'data-range-slider'		=> 'thumbHover',
			),
		);
	} else if($option == 'title-category') {
		$atts = array(
			'break' 	  => '1,2,1',
			'class'		  => 'custom-hover',
			'title'		  => 'Title &amp; Type Visibility',
			'style-class' => 'ep-collapsed',
			'hover_title_visibility' => array(
				'data-input-type' => 'select-box',
				'title'		 		=> 'Visibility',
				'size'		 		=> 'span4',
				'class'				=> 'ps-setting admin-listen-handler',
				'data-handler'		=> 'thumbHover',
				'data-ps-type' 		=> 'thumbnail',
				'default' 	 		=> 'hide-both',
				'data-target'		=> '.thumb-hover-meta',
				'select-box-values' => array(
					'hide-both'		=> 'Hide Both',
					'show-both' 	=> 'Show both title and project type',
					'show-title'	=> 'Show only title',
					'show-category'	=> 'Show only project type',
				),
			),
			'hover_title_alignment' => array(
				'data-input-type' => 'select-box',
				'title'		 		=> 'Alignment',
				'size'		 		=> 'span2',
				'class'				=> 'ps-setting admin-listen-handler',
				'data-handler'		=> 'thumbHover',
				'data-ps-type' 		=> 'thumbnail',
				'default' 	 		=> 'none',
				'data-target'		=> '.thumb-hover-meta',
				'select-box-values' => array(
					'top-left'		=> 'Top Left',
					'top-center'	=> 'Top Center',
					'top-right'		=> 'Top Right',
					'middle-left'	=> 'Middle Left',
					'middle-center'	=> 'Middle Center',
					'middle-right'	=> 'Middle Right',
					'bottom-left'	=> 'Bottom Left',
					'bottom-center'	=> 'Bottom Center',
					'bottom-right'	=> 'Bottom Right',
				),
			),
			'hover_title_padding' => array(
				'title'					=> 'Padding',
				'size'					=> 'span2',
				'offset'				=> false,
				'data-input-type' 		=> 'range-slider',
				'min'					=> 0,
				'default'				=> 40,
				'max'					=> 1000,
				'data-has-unit'			=> true,
				'class'					=> 'ps-setting admin-listen-handler',
				'data-handler'			=> 'thumbHover',
				'data-ps-type' 			=> 'thumbnail',
				'data-target'			=> '.thumb-hover-meta',
				'data-range-slider'		=> 'thumbHover',
			),
			'hover_title_transition' => array(
				'data-input-type' => 'select-box',
				'title'		 		=> 'Transition',
				'size'		 		=> 'span4',
				'class'				=> 'ps-setting admin-listen-handler',
				'data-handler'		=> 'thumbHover',
				'data-ps-type' 		=> 'thumbnail',
				'default' 	 		=> 'fadein',
				'select-box-values' => array(
					'fade' 		  => 'Fade in only',
					'move-top' => 'Fade in + move from top',
					'move-right' => 'Fade in + move from right',
					'move-bottom' => 'Fade in + move from bottom',
					'move-left' => 'Fade in + move from left',
				),
			),
		);
	} else if($option == 'title') {
		$atts = array(
			'break' 	  => '2',
			'class'		  => 'custom-hover',
			'title'		  => 'Title Formatting',
			'style-class' => 'ep-collapsed',
			'hover_title_color' => array(
				'title'					=> 'Color',
				'size'					=> 'span2',
				'data-input-type'		=> 'color',
				'default'				=> 'transparent',
				'class'					=> 'color-picker admin-listen-handler',
				'data-handler'  	 	=> 'colorPicker',
				'data-css-attribute' 	=> 'color',
				'data-target'			=> '.thumb-hover-meta .title',
				'data-picker'		=> 'thumbHover',
			),
			'hover_title_font' => array(
				'data-input-type' => 'select-fonts',
				'title'		 		=> 'Font Family',
				'size'		 		=> 'span2',
				'class'				=> 'ps-setting admin-listen-handler',
				'data-handler'		=> 'thumbHover',
				'data-ps-type' 		=> 'thumbnail',
				'default' 	 		=> 'none',
				'select-box-values' => $fonts,
				'data-target'		=> '.thumb-hover-meta .title',
			),
			'hover_title_fontsize' => array(
				'title'					=> 'Font Size',
				'size'					=> 'span2',
				'offset'				=> false,
				'data-input-type' 		=> 'range-slider',
				'default'				=> 24,
				'min'					=> 0,
				'max'					=> 999,
				'class'					=> 'ps-setting admin-listen-handler',
				'data-handler'			=> 'thumbHover',
				'data-ps-type' 			=> 'thumbnail',
				'data-has-unit'			=> true,
				'data-css-attribute'	=> 'font-size',
				'data-target'			=> '.thumb-hover-meta .title',
				'data-range-slider'		=> 'thumbHover',
			),
			'hover_title_text_transform' => array(
				'title'					=> 'Text Transform',
				'size'					=> 'span2',
				'data-input-type'		=> 'select-box',
				'class'					=> 'ps-setting admin-listen-handler',
				'data-handler'			=> 'thumbHover',
				'data-ps-type' 			=> 'thumbnail',
				'default'				=> 'none',
				'data-css-attribute'	=> 'text-transform',
				'data-target'			=> '.thumb-hover-meta .title',
				'select-box-values' => array(
					'none'			=> 'None',
					'uppercase'		=> 'Uppercase',
				),
			),
		);
	} else if($option == 'category') {
		$atts = array(
			'break' 	  => '2',
			'class'		  => 'custom-hover',
			'title'		  => 'Type Formatting',
			'style-class' => 'ep-collapsed',
			'hover_category_color' => array(
				'title'					=> 'Color',
				'size'					=> 'span2',
				'data-input-type'		=> 'color',
				'data-target'			=> '.content-block',
				'default'				=> 'transparent',
				'class'					=> 'color-picker admin-listen-handler',
				'data-handler'  		=> 'colorPicker',
				'data-css-attribute' 	=> 'color',
				'data-target'			=> '.thumb-hover-meta .category',
				'data-picker'		=> 'thumbHover',
			),
			'hover_category_font' => array(
				'data-input-type' => 'select-fonts',
				'title'		 		=> 'Font Family',
				'size'		 		=> 'span2',
				'class'				=> 'ps-setting admin-listen-handler',
				'data-handler'		=> 'thumbHover',
				'data-ps-type' 		=> 'thumbnail',
				'default' 	 		=> 'none',
				'select-box-values' => $fonts,
				'data-target'		=> '.thumb-hover-meta .category',
			),
			'hover_category_fontsize' => array(
				'title'					=> 'Font Size',
				'size'					=> 'span2',
				'offset'				=> false,
				'data-input-type' 		=> 'range-slider',
				'default'				=> 18,
				'min'					=> 0,
				'max'					=> 999,
				'class'					=> 'ps-setting admin-listen-handler',
				'data-handler'			=> 'thumbHover',
				'data-ps-type' 			=> 'thumbnail',
				'data-has-unit'			=> true,
				'data-css-attribute'	=> 'font-size',
				'data-target'			=> '.thumb-hover-meta .category',
				'data-range-slider'		=> 'thumbHover',
			),
			'hover_category_text_transform' => array(
				'title'					=> 'Text Transform',
				'size'					=> 'span2',
				'data-input-type'		=> 'select-box',
				'class'					=> 'ps-setting admin-listen-handler',
				'data-handler'			=> 'thumbHover',
				'data-ps-type' 			=> 'thumbnail',
				'default'				=> 'none',
				'data-css-attribute'	=> 'text-transform',
				'data-target'			=> '.thumb-hover-meta .category',
				'select-box-values' => array(
					'none'			=> 'None',
					'uppercase'		=> 'Uppercase',
				),
			),
		);
	}
	// return
	return $atts;
}

// view project button
function get_vp_button_options($is_slider) {

	// vars
	$handler = 'default';
	$apply_to = 'style';

	// change vars on slider
	if(true === $is_slider) {
		$handler = 'coverSlider';
		$apply_to= 'coverSlider';
	}

	// general options
	$general = array(
		'title'  	 => 'View Project Button',
		'hide-title' => true,
		'break'		 => '1,3,2,2',
		'data-hide-mobile' => true,
		'style-class'	=> 'ov-vp-button-custom',
		'vp_button_label' => array(
			'data-input-type'	=> 'input-text',
			'title'		 	=> 'Label',
			'size'		 	=> 'span4',
			'placeholder'	=> 'View Project',
			'default'		=> 'View Project',
			'class'			=> 'editor-listen',
			'data-handler'  => $handler,
		),
		'vp_button_font_family' => array(
			'title'				=> 'Font Family',
			'size'				=> 'span2',
			'data-input-type'	=> 'select-fonts',
			'class'				=> 'editor-listen',
			'data-handler'  	=> $handler,
			'default'			=> 'none',
			'select-box-values' => semplice_get_default_fonts('display', false),
		),
		'vp_button_font_size' => array(
			'title'				=> 'Font size',
			'size'				=> 'span1',
			'data-input-type' 	=> 'range-slider',
			'class'				=> 'editor-listen',
			'data-handler'  	=> $handler,
			'data-has-unit'		=> true,
			'default'			=> 13,
			'min'				=> 6,
			'max'				=> 9999,
			'data-range-slider' => $apply_to,
		),
		'vp_button_letter_spacing' => array(
			'data-style-option' => true,
			'title'				=> 'Spacing',
			'size'				=> 'span1',
			'data-input-type' 	=> 'range-slider',
			'class'				=> 'editor-listen',
			'data-handler' 		=> $handler,
			'data-has-unit'		=> true,
			'default'			=> 0,
			'min'				=> 0,
			'max'				=> 9999,
			'data-divider'		=> 10,
			'data-negative'		=> true,
			'data-range-slider' => $apply_to,
		),
		'vp_button_padding_ver' => array(
			'title'				=> 'Padding Ver',
			'size'				=> 'span2',
			'data-input-type' 	=> 'range-slider',
			'class'				=> 'editor-listen',
			'data-handler'  	=> $handler,
			'data-has-unit'		=> true,
			'default'			=> 8,
			'min'				=> 0,
			'max'				=> 9999,
			'data-range-slider' => $apply_to,
		),
		'vp_button_padding_hor' => array(
			'title'				=> 'Padding Hor',
			'size'				=> 'span2',
			'data-input-type' 	=> 'range-slider',
			'class'				=> 'editor-listen',
			'data-handler'  	=> $handler,
			'data-has-unit'		=> true,
			'default'			=> 30,
			'min'				=> 0,
			'max'				=> 9999,
			'data-range-slider' => $apply_to,
		),
		'vp_button_border_width' => array(
			'title'				=> 'Border Width',
			'size'				=> 'span2',
			'data-input-type' 	=> 'range-slider',
			'class'				=> 'editor-listen',
			'data-handler'  	=> $handler,
			'data-has-unit'		=> true,
			'default'			=> 1,
			'min'				=> 0,
			'max'				=> 9999,
			'data-range-slider' => $apply_to,
		),
		'vp_button_border_radius' => array(
			'title'				=> 'Border Radius',
			'size'				=> 'span2',
			'data-input-type' 	=> 'range-slider',
			'class'				=> 'editor-listen',
			'data-handler'  	=> $handler,
			'data-has-unit'		=> true,
			'default'			=> 2,
			'min'				=> 0,
			'max'				=> 9999,
			'data-range-slider' => $apply_to,
		),
	);

	// link options
	$link = array(
		'title'  	 => 'Button Link Colors',
		'break'		 => '3',
		'data-hide-mobile' => true,
		'style-class'		=> 'ov-vp-button-custom',
		'vp_button_font_color' => array(
			'title'				=> 'Font',
			'size'				=> 'span2',
			'data-input-type'	=> 'color',
			'default'			=> '#ffffff',
			'class'				=> 'color-picker admin-listen-handler',
			'data-handler' 		=> 'colorPicker',
			'data-picker'		=> $apply_to,
		),
		'vp_button_bg_color' => array(
			'title'				=> 'Background',
			'size'				=> 'span2',
			'data-input-type'	=> 'color',
			'default'			=> 'transparent',
			'class'				=> 'color-picker admin-listen-handler',
			'data-handler' 		=> 'colorPicker',
			'data-picker'		=> $apply_to,
		),
		'vp_button_border_color' => array(
			'title'				=> 'Border',
			'size'				=> 'span2',
			'data-input-type'	=> 'color',
			'default'			=> '#ffffff',
			'class'				=> 'color-picker admin-listen-handler',
			'data-handler' 		=> 'colorPicker',
			'data-picker'		=> $apply_to,
		),
	);

	// link options
	$hover = array(
		'title'  	 => 'Button Hover Colors',
		'break'		 => '3',
		'data-hide-mobile' => true,
		'style-class'		=> 'ov-vp-button-custom',
		'vp_button_font_mouseover_color' => array(
			'title'				=> 'Font',
			'size'				=> 'span2',
			'data-input-type'	=> 'color',
			'default'			=> '#ffffff',
			'class'				=> 'color-picker admin-listen-handler',
			'data-handler' 		=> 'colorPicker',
			'data-picker'		=> $apply_to,
		),
		'vp_button_bg_mouseover_color' => array(
			'title'				=> 'Background',
			'size'				=> 'span2',
			'data-input-type'	=> 'color',
			'default'			=> 'transparent',
			'class'				=> 'color-picker admin-listen-handler',
			'data-handler' 		=> 'colorPicker',
			'data-picker'		=> $apply_to,
		),
		'vp_button_border_mouseover_color' => array(
			'title'				=> 'Border',
			'size'				=> 'span2',
			'data-input-type'	=> 'color',
			'default'			=> '#ffffff',
			'class'				=> 'color-picker admin-listen-handler',
			'data-handler' 		=> 'colorPicker',
			'data-picker'		=> $apply_to,
		),
	);

	// define options array
	$options = array(
		'general' => $general,
		'link'	  => $link,
		'hover'	  => $hover,
	);

	// retrn
	return $options;
}

// responsive styles column
function get_responsive_column_styles($breakpoint, $title) {

	$atts = array(
		'break'	  => '1,1,1,1,1,1,1,1',
		'title'   => $title . ' styles',
	);

	// column mode
	if($breakpoint == 'sm' || $breakpoint == 'xs') {
		$column_height = array(
			// height
			'title'			=> 'Height',
			'size'			=> 'span2',
			'help'			=> 'Please note that if you set your spacer column to a height of 0px, it still has 100px height in the editor just so you can click it. In the frontend the height will be 0px.',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'data-target'	=> '.column',
			'default'		=> 0,
			'min'			=> 0,
			'max'			=> 999,
			'class'			=> 'editor-listen',
			'data-handler'	=> 'default',
			'responsive'	=> true,
			'data-has-unit'	=> true,
			'data-range-slider' => 'spacerColumn'
		);
		// add to atts
		$atts['height'] = $column_height;
	}

	return $atts;
}

// function get responsive gutter
function get_responsive_gutter($breakpoint, $images_per_row) {

	// names
	$title = array(
		'lg' => 'Grid Options Desktop',
		'md' => 'Grid Options Tablet Landscape',
		'sm' => 'Grid Options Tablet Portrait',
		'xs' => 'Grid Options Mobile',
	);

	$options = array(
		'title'  	 => $title[$breakpoint],
		'break'		 => '3',
		'class'		 => 'mobile-option mobile-option-' .$breakpoint,
		'hor_gutter_' . $breakpoint => array(
			'title'			=> 'H-Gutter',
			'size'			=> 'span1',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 30,
			'min'			=> 0,
			'max'			=> 999,
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'responsive'	=> true,
		),
		'ver_gutter_' . $breakpoint => array(
			'title'			=> 'V-Gutter',
			'size'			=> 'span1',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 30,
			'min'			=> 0,
			'max'			=> 999,
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'responsive'	=> true,
		),
	);
	// adding imgages per row option
	if(true === $images_per_row) {
		$options['col_' . $breakpoint] = array(
			'data-input-type' 	=> 'select-box',
			'title'		 		=> 'Images per Row',
			'size'		 		=> 'span2',
			'class'      		=> 'editor-listen',
			'data-handler' 		=> 'save',
			'default' 	 		=> '4',
			'responsive'		=> true,
			'select-box-values' => array(
				'12' 			=> '1 Image',
				'6' 			=> '2 Images',
				'4' 			=> '3 Images',
				'3' 			=> '4 Images',
				'2' 			=> '6 Images',
				'1' 			=> '12 Images',
			),
		);
	}
	// ret
	return $options;
}

// get apg mobile options
function get_apg_responsive($grid, $breakpoint) {
	// names
	$title = array(
		'lg' => 'Desktop Options',
		'md' => 'Tablet Landscape Options',
		'sm' => 'Tablet Portrait Options',
		'xs' => 'Mobile Options',
	);
	// define mobile options
	if($grid == 'hor-full') {

		// default width
		$default_width = array('lg' => 6, 'md' => 6, 'sm' => 12, 'xs' => 12);

		return array(
			'title'  	 => $title[$breakpoint],
			'break'		 => '2,2,2,2,1',
			'class'		 => 'mobile-option mobile-option-' .$breakpoint,
			'style-class'=> 'apg-responsive-horfull-' . $breakpoint,
			'hor_full_width_' . $breakpoint => array(
				'data-input-type' => 'select-box',
				'title'		 => 'Images per Row',
				'size'		 => 'span2',
				'class'      	=> 'editor-listen',
				'data-handler' 	=> 'apg',
				'default' 	 => $default_width[$breakpoint],
				'responsive'	=> true,
				'select-box-values' => array(
					'12' => '1 Image',
					'6' => '2 Images',
					'4' => '3 Images',
					'3' => '4 Images',
				),
			),
			'hor_full_arrow_size_' . $breakpoint => array(
				'data-input-type' => 'select-box',
				'title'		 => 'Arrow Size',
				'size'		 => 'span2',
				'class'      	=> 'editor-listen',
				'data-handler' 	=> 'apg',
				'default' 	 => 'small',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
				'select-box-values' => array(
					'small' 		=> 'Small',
					'medium' 		=> 'Medium',
					'large' 		=> 'Large',
					'insane' 		=> 'Insane',
				),
			),
			'hor_full_title_padding_' . $breakpoint => array(
				'title'			=> 'Title Padding',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> 72,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-css-attribute'=> 'padding',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'hor_full_title_offset_' . $breakpoint => array(
				'title'			=> 'Title Offset',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> 0,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'help'			=> 'Define the vertical offset of your title. This is an addition to the padding because sometimes you want a small horizontal padding but at the same time you dont want your title to stick to the top or bottom edge.',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'hor_full_title_fontsize_' . $breakpoint => array(
				'title'			=> 'Title Font Size',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' 	=> 'range-slider',
				'default'		=> 42,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-css-attribute'=> 'font-size',
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'hor_full_title_letter_spacing_' . $breakpoint => array(
				'title'				=> 'Letter Spacing',
				'size'				=> 'span2',
				'data-input-type' 	=> 'range-slider',
				'data-css-attribute'=> 'letter-spacing',
				'data-style-option' => true,
				'data-has-unit'		=> true,
				'default'			=> 0,
				'min'				=> 0,
				'max'				=> 9999,
				'data-negative' 	=> true,
				'data-divider'		=> 10,
				'class' 	 		=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'hor_full_title_line_height_' . $breakpoint => array(
				'title'				=> 'Line Height',
				'size'				=> 'span2',
				'data-input-type' 	=> 'range-slider',
				'default'			=> 100,
				'min'				=> 0,
				'max'				=> 9999,
				'class' 	 		=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'hor_full_type_fontsize_' . $breakpoint => array(
				'title'			=> 'Type Font Size',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' 	=> 'range-slider',
				'default'		=> 20,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-style-option' => true,
				'data-has-unit'		=> true,
				'data-css-attribute'=> 'font-size',
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'hor_full_type_padding_top_' . $breakpoint => array(
				'title'			=> 'Padding Top',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> 10,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-css-attribute'=> 'padding-top',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
		);
	} else if($grid == 'text') {

		return array(
			'title'  	 => $title[$breakpoint],
			'break'		 => '2,2,2',
			'class'		 => 'mobile-option mobile-option-' .$breakpoint,
			'style-class'	=> 'apg-responsive-text-' . $breakpoint,
			'text_title_padding_' . $breakpoint => array(
				'title'			=> 'Outer Padding',
				'help'			=> 'This setting has no effect if title position is set to \'Middle Center\'.',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> 72,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-css-attribute'=> 'padding',
				'data-responsive-option' => 'apg',
				'responsive'	=> true,
			),
			'text_title_item_padding_ver_' . $breakpoint => array(
				'title'			=> 'Item Padding Vert',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> 10,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-responsive-option' => 'apg',
				'responsive'	=> true,
			),
			'text_title_item_padding_hor_' . $breakpoint => array(
				'title'			=> 'Item Padding Hor',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> 18,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-responsive-option' => 'apg',
				'responsive'	=> true,
			),
			'text_title_fontsize_' . $breakpoint => array(
				'title'			=> 'Font Size',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' 	=> 'range-slider',
				'default'		=> 90,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-css-attribute'=> 'font-size',
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'text_title_line_height_' . $breakpoint => array(
				'title'				=> 'Line Height',
				'size'				=> 'span2',
				'data-input-type' 	=> 'range-slider',
				'default'			=> 100,
				'min'				=> 0,
				'max'				=> 9999,
				'class' 	 		=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'text_title_letter_spacing_' . $breakpoint => array(
				'title'				=> 'Letter Spacing',
				'size'				=> 'span2',
				'data-input-type' 	=> 'range-slider',
				'data-css-attribute'=> 'letter-spacing',
				'data-style-option' => true,
				'data-has-unit'		=> true,
				'default'			=> 0,
				'min'				=> 0,
				'max'				=> 9999,
				'data-negative' 	=> true,
				'data-divider'		=> 10,
				'class' 	 		=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
		);
	} else if($grid == 'splitscreen') {

		// default width
		$default_width = array('lg' => 6, 'md' => 6, 'sm' => 12, 'xs' => 12);

		return array(
			'title'  	 => $title[$breakpoint],
			'break'		 => '2,2,2,2,2,2,1',
			'class'		 => 'mobile-option mobile-option-' .$breakpoint,
			'style-class'=> 'apg-responsive-splitscreen-' . $breakpoint,
			'splitscreen_title_padding_' . $breakpoint => array(
				'title'			=> 'Title Padding',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> 72,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-css-attribute'=> 'padding',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'splitscreen_title_offset_' . $breakpoint => array(
				'title'			=> 'Title Offset',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> 0,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'help'			=> 'Define the vertical offset of your title. This is an addition to the padding because sometimes you want a small horizontal padding but at the same time you dont want your title to stick to the top or bottom edge.',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'splitscreen_title_fontsize_' . $breakpoint => array(
				'title'			=> 'Title Font Size',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' 	=> 'range-slider',
				'default'		=> 42,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-css-attribute'=> 'font-size',
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'splitscreen_title_letter_spacing_' . $breakpoint => array(
				'title'				=> 'Title Letter Spacing',
				'size'				=> 'span2',
				'data-input-type' 	=> 'range-slider',
				'data-css-attribute'=> 'letter-spacing',
				'data-style-option' => true,
				'data-has-unit'		=> true,
				'default'			=> 0,
				'min'				=> 0,
				'max'				=> 9999,
				'data-negative' 	=> true,
				'data-divider'		=> 10,
				'class' 	 		=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'splitscreen_title_line_height_' . $breakpoint => array(
				'title'				=> 'Title Line Height',
				'size'				=> 'span2',
				'data-input-type' 	=> 'range-slider',
				'default'			=> 100,
				'min'				=> 0,
				'max'				=> 9999,
				'class' 	 		=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'splitscreen_type_fontsize_' . $breakpoint => array(
				'title'			=> 'Desc Font Size',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' 	=> 'range-slider',
				'default'		=> 20,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-style-option' => true,
				'data-has-unit'		=> true,
				'data-css-attribute'=> 'font-size',
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'splitscreen_type_padding_top_' . $breakpoint => array(
				'title'			=> 'Desc Padding Top',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> 10,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-css-attribute'=> 'padding-top',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'splitscreen_details_padding_top_' . $breakpoint  => array(
				'title'			=> 'Button Top Spacing',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> 36,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-css-attribute'=> 'margin-top',
				'data-target'		=> '.apg-post-title .details',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'splitscreen_details_padding_ver_' . $breakpoint  => array(
				'title'			=> 'Button Spacing Ver',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' 	=> 'range-slider',
				'default'		=> 14,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-target'		=> '.apg-post-title .details a',
				'data-has-unit'		=> true,
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'splitscreen_details_padding_hor_' . $breakpoint  => array(
				'title'			=> 'Button Spacing Hor',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' 	=> 'range-slider',
				'default'		=> 14,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-target'		=> '.apg-post-title .details a',
				'data-has-unit'		=> true,
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'splitscreen_details_border_' . $breakpoint  => array(
				'title'			=> 'Button Border',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' 	=> 'range-slider',
				'default'		=> 1,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-target'		=> '.apg-post-title .details a',
				'data-has-unit'		=> true,
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'splitscreen_details_fontsize_' . $breakpoint  => array(
				'title'			=> 'Button Font Size',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' 	=> 'range-slider',
				'default'		=> 20,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-target'		=> '.apg-post-title .details a',
				'data-style-option' => true,
				'data-has-unit'		=> true,
				'data-css-attribute'=> 'font-size',
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
			'splitscreen_details_letter_spacing_' . $breakpoint  => array(
				'title'				=> 'Btn Letter Spacing',
				'size'				=> 'span2',
				'data-input-type' 	=> 'range-slider',
				'data-css-attribute'=> 'letter-spacing',
				'data-style-option' => true,
				'data-target'		=> '.apg-post-title .details a',
				'default'			=> 0,
				'min'				=> 0,
				'max'				=> 9999,
				'data-negative' 	=> true,
				'data-has-unit'		=> true,
				'data-divider'		=> 10,
				'class' 	 		=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'responsive'	=> true,
				'data-responsive-option' => 'apg',
			),
		);
	} 
}

// get pg filter mobile options
function get_pg_filter_responsive($breakpoint) {
	return array(
		'title'  	 => 'Category Filter',
		'break'		 => '1,2,2',
		'class'		 => 'mobile-option mobile-option-' .$breakpoint,
		'style-class'=> 'ep-collapsed',
		'filter_alignment_' . $breakpoint => array(
			'title'				=> 'Alignment',
			'size'				=> 'span4',
			'data-input-type'	=> 'select-box',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'default'			=> 'right',
			'responsive'		=> true,
			'select-box-values' => array(
				'left'			=> 'Left',
				'center'		=> 'Center',
				'right'			=> 'Right',
			),
		),
		'filter_padding_' . $breakpoint => array(
			'title'				=> 'Padding Bottom',
			'size'				=> 'span2',
			'offset'			=> false,
			'data-input-type' 	=> 'range-slider',
			'default'			=> 28,
			'min'				=> 0,
			'max'				=> 999,
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'data-style-option' => true,
			'data-has-unit'	=> true,
			'responsive'	=> true,
		),
		'filter_item_padding_' . $breakpoint => array(
			'title'				=> 'Item Padding',
			'size'				=> 'span2',
			'offset'			=> false,
			'data-input-type' 	=> 'range-slider',
			'default'			=> 28,
			'min'				=> 0,
			'max'				=> 999,
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'data-style-option' => true,
			'data-has-unit'	=> true,
			'responsive'	=> true,
		),
		'filter_fontsize_' . $breakpoint => array(
			'title'				=> 'Font Size',
			'size'				=> 'span2',
			'offset'			=> false,
			'data-input-type' 	=> 'range-slider',
			'default'			=> 20,
			'min'				=> 0,
			'max'				=> 999,
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'data-style-option' => true,
			'data-has-unit'	=> true,
			'responsive'	=> true,
		),
		'filter_letter_spacing_' . $breakpoint => array(
			'title'				=> 'Letter Spacing',
			'size'				=> 'span2',
			'offset'			=> false,
			'data-input-type' 	=> 'range-slider',
			'default'			=> 0,
			'min'				=> 0,
			'max'				=> 9999,
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'data-style-option' => true,
			'data-divider'  	=> 10,
			'data-has-unit'		=> true,
			'data-negative' 	=> true,
			'help'				=> 'This value increments the letter spacing in 0.1px steps. <br /><br /><b>Example:</b> 10 = 1px.',
			'responsive'		=> true,
		),
	);
}

// get pg title options mobile options
function get_responsive_pg_title_options($breakpoint) {
	$fonts = semplice_get_default_fonts('display', false);
	return array(
		'title'  	 => 'Title & Category Formatting',
		'break'		 => '2,2',
		'style-class'=> 'ep-collapsed',
		'class'		 => 'mobile-option mobile-option-' .$breakpoint,
		'title_fontsize_' . $breakpoint => array(
			'title'			=> 'Title Font Size',
			'size'			=> 'span2',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 16,
			'min'			=> 0,
			'max'			=> 999,
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'data-style-option' => true,
			'data-has-unit'	=> true,
			'responsive'	=> true,
		),
		'title_padding_' . $breakpoint => array(
			'title'			=> 'Title Padding',
			'help'			=> 'Padding has no effect if title position is set to \'Overlay Middle Center.\'',
			'size'			=> 'span2',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 18,
			'min'			=> 0,
			'max'			=> 999,
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'data-style-option' => true,
			'data-has-unit'	=> true,
			'responsive'	=> true,
		),
		'category_fontsize_' . $breakpoint => array(
			'title'			=> 'Type Font Size',
			'size'			=> 'span2',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 14,
			'min'			=> 0,
			'max'			=> 999,
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'data-style-option' => true,
			'data-has-unit'	=> true,
			'responsive'	=> true,
		),
		'category_padding_top_' . $breakpoint => array(
			'title'			=> 'Type Padding Top',
			'size'			=> 'span2',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 8,
			'min'			=> 0,
			'max'			=> 999,
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'data-style-option' => true,
			'data-has-unit'	=> true,
			'responsive'	=> true,
		),
	);
}

// get social profiles mobile options
function get_sp_responsive($breakpoint) {
	return array(
		'title'  	 => 'Icons',
		'break'		 => '4',
		'class'		 => 'mobile-option mobile-option-' .$breakpoint,
		'icon_scale_' .$breakpoint => array(
			'title'				=> 'Scale',
			'size'				=> 'span1',
			'data-input-type' 	=> 'range-slider',
			'data-css-attribute'=> 'height',
			'data-target'		=> '.social-profile svg',
			'data-style-option' => true,
			'data-has-unit'		=> true,
			'default'			=> 26,
			'min'				=> 0,
			'max'				=> 9999,
			'class' 	 		=> 'editor-listen',
			'data-handler'		=> 'socialProfiles',
			'data-range-slider' => 'socialProfiles',
			'responsive'		=> true,
		),
		'icon_padding_' .$breakpoint => array(
			'title'				=> 'Padding',
			'size'				=> 'span1',
			'data-input-type' 	=> 'range-slider',
			'data-css-attribute'=> 'padding',
			'data-target'		=> '.social-profile a',
			'data-style-option' => true,
			'data-has-unit'		=> true,
			'default'			=> 10,
			'min'				=> 0,
			'max'				=> 9999,
			'style-class'		=> 'ov-share-icons',
			'class' 	 		=> 'editor-listen',
			'data-handler'		=> 'socialProfiles',
			'data-range-slider' => 'socialProfiles',
			'help'				=> 'Padding only works if you set \'Distributed\' to \'Default\'.',
			'responsive'		=> true,
		)
	);
}

// title options
function get_title_options($options, $prefix, $fonts, $font_size_title, $font_size_type, $line_height) {

	// style classes
	$style_classes = array(
		'hor_full_' 	=> 'ov-apg-horizontal-fullscreen',
		'text_'    		=> 'ov-apg-text',
		'splitscreen_' 	=> 'ov-apg-splitscreen'
	);

	// get style class
	$style_class = false;
	if(false !== $prefix) {
		$style_class = $style_classes[$prefix] . ' ep-collapsed';
	}

	// visibility options
	$visibility_options = array(
		'both' 			=> 'Show both title and project type',
		'title'			=> 'Show only title',
		'category'		=> 'Show only project type',
		'hidden'		=> 'Hide Both',
	);

	// title position default
	$title_position_default = 'bottom-center';

	// type padding top
	$type_padding_top = 10;

	// adjust settings for splitscreen
	if($prefix == 'splitscreen_') {
		$type_padding_top = 36;
		$title_position_default = 'middle-left';
		$visibility_options = array(
			'both' 			=> 'Show both title and description',
			'title'			=> 'Show only title',
			'description'	=> 'Show only description',
		);
	}

	// return options
	if($options == 'title-options') {
		return array(
			'title'  	 => 'Title Options',
			'break'		 => '2,2',
			'style-class'=> $style_class,
			'data-hide-mobile' => true,
			$prefix . 'title_visibility' => array(
				'data-input-type' 	=> 'select-box',
				'title'		 		=> 'Visibility',
				'size'		 		=> 'span2',
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'default' 	 		=> 'both',
				'select-box-values' => $visibility_options,
			),
			$prefix . 'title_position' => array(
				'data-input-type' 	=> 'select-box',
				'title'		 		=> 'Position',
				'size'		 		=> 'span2',
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'default' 	 		=> $title_position_default,
				'select-box-values' => array(
					'top-left'      => 'Top Left',
					'top-center'	=> 'Top Center',
					'top-right'		=> 'Top Right',
					'middle-left'   => 'Middle Left',
					'middle-center'	=> 'Middle Center',
					'middle-right'	=> 'Middle Right',
					'bottom-left'   => 'Bottom Left',
					'bottom-center'	=> 'Bottom Center',
					'bottom-right'	=> 'Bottom Right',
				),
			),
			$prefix . 'title_padding' => array(
				'title'			=> 'Padding',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> 72,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-css-attribute'=> 'padding',
				'data-target'   => '.apg-post-title',
			),
			$prefix . 'title_offset' => array(
				'title'			=> 'Vertical Offset',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> 0,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-target'   => '.apg-post-title',
				'help'			=> 'Define the vertical offset of your title. This is an addition to the padding, as you may want a small horizontal padding but don’t want your title to stick to the top or bottom edge.',
			),
		);
	} else if($options == 'title-options-text') {
		return array(
			'title'  	 => 'Title Options',
			'break'		 => '2,2',
			'style-class'=> $style_class,
			'data-hide-mobile' => true,
			$prefix . 'title_direction' => array(
				'data-input-type' 	=> 'switch',
				'switch-type'		=> 'twoway',
				'title'		 		=> 'Direction',
				'size'		 		=> 'span2',
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'default' 	 		=> 'column-dir',
				'switch-values' => array(
					'column-dir'	=> 'Vert',
					'row-dir'		=> 'Hor',
				),
			),
			$prefix . 'title_position' => array(
				'data-input-type' 	=> 'select-box',
				'title'		 		=> 'Position',
				'size'		 		=> 'span2',
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'default' 	 		=> 'middle-center',
				'select-box-values' => array(
					'top-left'      => 'Top Left',
					'top-center'	=> 'Top Center',
					'top-right'		=> 'Top Right',
					'middle-left'   => 'Middle Left',
					'middle-center'	=> 'Middle Center',
					'middle-right'	=> 'Middle Right',
					'bottom-left'   => 'Bottom Left',
					'bottom-center'	=> 'Bottom Center',
					'bottom-right'	=> 'Bottom Right',
				),
			),
			$prefix . 'title_padding' => array(
				'title'			=> 'Outer Padding',
				'help'			=> 'This setting has no effect if title position is set to \'Middle Center\'.',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> 72,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-css-attribute'=> 'padding',
				'data-target'   => '.apg',
			),
			$prefix . 'title_item_padding_ver' => array(
				'title'			=> 'Item Padding Vert',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> 10,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-target'   => '.apg',
			),
			$prefix . 'title_item_padding_hor' => array(
				'title'			=> 'Item Padding Hor',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> 18,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-target'   => '.apg',
			),
		);
	} else if($options == 'title-formatting') {
		return array(
			'title'  	 => 'Title Formatting',
			'break'		 => '2,2,2',
			'style-class'=> $style_class,
			'data-hide-mobile' => true,
			$prefix . 'title_color' => array(
				'title'				=> 'Color',
				'data-style-option' => true,
				'size'				=> 'span2',
				'data-input-type'	=> 'color',
				'data-target'		=> '.spacer',
				'default'			=> 'transparent',
				'class'				=> 'color-picker admin-listen-handler',
				'data-handler' 		=> 'colorPicker',
				'data-picker'		=> 'apg',
				'data-target'		=> '.apg-post-title .title',
				'data-css-attribute'=> 'color',
			),
			$prefix . 'title_font_family' => array(
				'data-input-type' => 'select-fonts',
				'title'		 		=> 'Font Family',
				'size'		 		=> 'span2',
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'default' 	 		=> 'bold',
				'select-box-values' => $fonts,
			),
			$prefix . 'title_fontsize' => array(
				'title'			=> 'Font Size',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' 	=> 'range-slider',
				'default'		=> $font_size_title,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-css-attribute'=> 'font-size',
				'data-target'		=> '.apg-post-title .title, .apg-text-seperator',
				'data-range-slider' => 'apg',
				//'responsive'	=> true,
			),
			$prefix . 'title_text_transform' => array(
				'title'				=> 'Text Transform',
				'size'				=> 'span2',
				'data-input-type'	=> 'select-box',
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'default'			=> 'none',
				'data-css-attribute'=> 'text-transform',
				'data-target'		=> '.apg-post-title .title, .apg-text-seperator',
				'select-box-values' => array(
					'none'			=> 'None',
					'uppercase'		=> 'Uppercase',
				),
			),
			$prefix . 'title_line_height' => array(
				'title'				=> 'Line Height (in %)',
				'size'				=> 'span2',
				'data-input-type' 	=> 'range-slider',
				'data-target'		=> '.apg-post-title .title',
				'default'			=> $line_height,
				'min'				=> 0,
				'max'				=> 9999,
				'class' 	 		=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
			),
			$prefix . 'title_letter_spacing' => array(
				'title'				=> 'Letter Spacing',
				'size'				=> 'span2',
				'data-input-type' 	=> 'range-slider',
				'data-css-attribute'=> 'letter-spacing',
				'data-style-option' => true,
				'data-target'		=> '.apg-post-title .title',
				'default'			=> 0,
				'min'				=> 0,
				'max'				=> 9999,
				'data-negative' 	=> true,
				'data-has-unit'		=> true,
				'data-divider'		=> 10,
				'class' 	 		=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
			),
		);
	} else if($options == 'type-formatting') {
		return array(
			'title'  	 => 'Type Formatting',
			'break'		 => '2,2,2',
			'style-class'=> $style_class,
			'data-hide-mobile' => true,
			$prefix . 'type_color' => array(
				'title'				=> 'Color',
				'data-style-option' => true,
				'size'				=> 'span2',
				'data-input-type'	=> 'color',
				'default'			=> 'transparent',
				'class'				=> 'color-picker admin-listen-handler',
				'data-handler' 		=> 'colorPicker',
				'data-picker'		=> 'apg',
				'data-target'		=> '.apg-post-title .type, .apg-post-title .description',
				'data-css-attribute'=> 'color',
			),
			$prefix . 'type_font_family' => array(
				'data-input-type' => 'select-fonts',
				'title'		 		=> 'Font Family',
				'size'		 		=> 'span2',
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'default' 	 		=> 'regular',
				'select-box-values' => $fonts,
			),
			$prefix . 'type_fontsize' => array(
				'title'			=> 'Font Size',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' 	=> 'range-slider',
				'default'		=> $font_size_type,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-target'		=> '.apg-post-title .type, .apg-post-title .description',
				'data-style-option' => true,
				'data-has-unit'		=> true,
				'data-css-attribute'=> 'font-size',
				'data-range-slider' => 'apg',
				//'responsive'	=> true,
			),
			$prefix . 'type_text_transform' => array(
				'title'				=> 'Text Transform',
				'size'				=> 'span2',
				'data-input-type'	=> 'select-box',
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'default'			=> 'none',
				'data-css-attribute'=> 'text-transform',
				'data-target'		=> '.apg-post-title .type, .apg-post-title .description',
				'select-box-values' => array(
					'none'			=> 'None',
					'uppercase'		=> 'Uppercase',
				),
			),
			$prefix . 'type_line_height' => array(
				'title'				=> 'Line Height (in %)',
				'size'				=> 'span2',
				'data-input-type' 	=> 'range-slider',
				'data-target'		=> '.apg-post-title .type, .apg-post-title .description',
				'default'			=> $line_height,
				'min'				=> 0,
				'max'				=> 9999,
				'class' 	 		=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'style-class'		=> 'apg-type-line-height',
			),
			$prefix . 'type_padding_top' => array(
				'title'			=> 'Padding Top',
				'size'			=> 'span2',
				'offset'		=> false,
				'data-input-type' => 'range-slider',
				'default'		=> $type_padding_top,
				'min'			=> 0,
				'max'			=> 999,
				'class'				=> 'editor-listen',
				'data-handler'		=> 'apg',
				'data-range-slider' => 'apg',
				'data-style-option' => true,
				'data-has-unit'	=> true,
				'data-css-attribute'=> 'padding-top',
				'data-target'   => '.apg-post-title .type, .apg-post-title .description',
				//'responsive'	=> true,
			),
		);
	}

	// return
	return $title_options;
}

// -----------------------------------------
// styles
// -----------------------------------------

require get_template_directory() . '/admin/atts/styles.php';

// -----------------------------------------
// options
// -----------------------------------------

require get_template_directory() . '/admin/atts/options.php';

// -----------------------------------------
// animations
// -----------------------------------------

require get_template_directory() . '/admin/atts/animations.php';

// -----------------------------------------
// module options
// -----------------------------------------

require get_template_directory() . '/admin/atts/modules.php';

// -----------------------------------------
// branding
// -----------------------------------------

require get_template_directory() . '/admin/atts/branding.php';

// -----------------------------------------
// customize options
// -----------------------------------------

require get_template_directory() . '/admin/atts/customize.php';

// -----------------------------------------
// theme settings
// -----------------------------------------

require get_template_directory() . '/admin/atts/settings.php';

// -----------------------------------------
// page settings
// -----------------------------------------

require get_template_directory() . '/admin/atts/post_settings.php';

// -----------------------------------------
// coverslider
// -----------------------------------------

require get_template_directory() . '/admin/atts/coverslider.php';

















