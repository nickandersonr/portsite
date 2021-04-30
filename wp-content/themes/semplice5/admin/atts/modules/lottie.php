<?php

// -----------------------------------------
// semplice
// admin/atts/modules/lottie.php
// -----------------------------------------

$lottie = array(
	'lottie-animations' => array(
		'title'  	 => 'Notice',
		'break'		 => '1',
		'hide-title' => true,
		'data-hide-mobile' => true,
		'style-class' => 'lottie-notice',
		'lottie_animations' => array(
			'data-input-type' => 'notice',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'     	=> 'ep-notice',
			'default'    => 'To display on your page, Lottie requires you to enable our custom animations. This will disable scroll reveal on this page. To reenable scroll reveal, go to your <b>Look & Feel</b> settings.<a class="lottie-enable-animations editor-action" data-action-type="helper" data-action="activateLottie">Enable Custom Animations</a>',
			'notice-type'=> 'warning',
		),
	),
	'upload' => array(
		'title'  	 => 'Lottie Upload',
		'title' 	 => 'Lottie',
		'break' 	 => '1',
		'data-hide-mobile' => true,
		'style-class'=> 'lottie-upload',
		'lottie' => array(
			'title'			=> 'Upload Lottie (json) file',
			'size'			=> 'span4',
			'data-input-type'	=> 'lottie-upload',
			'default'		=> '',
			'data-is-content' => true,
			'hide-title'	=> true,
			'data-upload'	=> 'lottie',
			'data-handler'	=> 'animate',
			'style-class'		=> 'ce-dropzone',
		),
	),
	'lottie-sizing' => array(
		'title'  	 => 'Sizing & Alignment',
		'break'		 => '3',
		'data-hide-mobile' => true,
		'width' => array(
			'data-input-type' => 'switch',
			'switch-type'	  => 'twoway',
			'title'		 	  => 'Width',
			'size'		 	  => 'span2',
			'class'			  => 'editor-listen',
			'data-handler'	  => 'save',
			'default' 	 	  => 'grid',
			'data-visibility-switch' 	=> true,
			'data-visibility-values' 	=> 'grid,custom',
			'data-visibility-prefix'	=> 'ov-lottie-width',
			'switch-values' => array(
				'grid' 		 => 'Grid',
				'custom'	 => 'Custom',
			),
		),
		'custom_width' => array(
			'title'			=> 'Custom',
			'size'			=> 'span1',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 570,
			'min'			=> 0,
			'max'			=> 99999,
			'class'			=> 'editor-listen',
			'data-handler'  => 'save',
			'help'			=> 'Custom width in pixel.',
			'style-class'	=> 'ov-lottie-width-custom',
		),
		'justify' => array(
			'title'		 => 'Align',
			'size'		 => 'span1',
			'data-input-type' => 'switch',
			'switch-type'=> 'icon-select',
			'class' 	 		=> 'editor-listen',
			'data-handler' 		=> 'save',
			'default'	 => 'left',
			'tooltips'	 => array(
				'left'     		 => 'Align left',
				'right'  		 => 'Align right',
				'center' 		 => 'Align center',
			),
			'switch-values' => array(
				'left'     		 => 'Left',
				'right'  		 => 'Right',
				'center' 		 => 'center',
			),
		),
	),
	'lottie-playback' => array(
		'title'  	 => 'Playback Options',
		'break'		 => '3,1,2,2,1',
		'data-hide-mobile' => true,
		'style-class' => 'ep-collapsed',
		'loop' => array(
			'data-input-type' => 'switch',
			'switch-type'	  => 'twoway',
			'title'		 	  => 'Loop',
			'size'		 	  => 'span2',
			'class'			  => 'editor-listen',
			'data-handler'	  => 'save',
			'default' 	 	  => 'false',
			'switch-values' => array(
				'false'  => 'No',
				'true'	 => 'Yes',
			),
		),
		'speed' => array(
			'title'			=> 'Speed',
			'size'			=> 'span1',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 10,
			'min'			=> 0,
			'max'			=> 999,
			'data-devider'  => 10,
			'class'			=> 'editor-listen',
			'data-handler'  => 'save',
		),
		'mobile' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 	  => 'Mobile',
			'size'		 	  => 'span1',
			'hide-title' => true,
			'class'			=> 'editor-listen',
			'data-handler'  => 'save',
			'default' 	 	  => 'on',
			'data-on'		  => 'on',
			'data-off'		  => 'off',
			'style-class'	  => 'onoff-inline'
		),
		'event' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Trigger',
			'size'		 => 'span4',
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'save',
			'default' 	 => 'on_load',
			'help'		 => 'Trigger that starts your lottie animation.',
			'data-visibility-switch' 	=> true,
			'data-visibility-values' 	=> 'on_load,on_hover,on_click,on_scroll',
			'data-visibility-prefix'	=> 'ov-lottie-trigger',
			'select-box-values' => array(
				'on_load'	=> 'When in view',
				'on_hover' 	=> 'Mouseover',
				'on_click' 	=> 'Click (tap)',
				'on_scroll'  => 'Scrolling in view',
			),
		),
		'start_scroller' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Start Point',
			'size'		 => 'span2',
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'save',
			'default' 	 => '0',
			'help'		 => 'Start point of your animation.<br /><br /><b>Examples:</b><br />Bottom means the animation will start once your lottie container enters the viewport on the bottom. Top means it will start once the lottie container reaches the top of your browser.',
			'style-class' => 'ov-lottie-trigger-on_scroll',
			'select-box-values' => array(
				'0'	=> 'Bottom',
				'-50' 	=> 'Center',
				'-100' 	=> 'Top',
			),
		),
		'pin_duration' => array(
			'title'			=> 'Duration (%)',
			'size'			=> 'span2',
			'offset'		=> false,
			'data-input-type' 	=> 'range-slider',
			'default'		=> 50,
			'min'			=> 0,
			'max'			=> 999,
			'class'			=> 'editor-listen',
			'data-handler'  => 'save',
			'help'			=> 'Example: 50 means that the animation will finish once you scroll 50% of your browser height.',
			'style-class' => 'ov-lottie-trigger-on_scroll',
		),
		'pin' => array(
			'data-input-type' => 'switch',
			'switch-type'	  => 'twoway',
			'title'		 	  => 'Pin',
			'size'		 	  => 'span2',
			'class'			  => 'editor-listen',
			'data-handler'	  => 'save',
			'default' 	 	  => 'false',
			'style-class' => 'ov-lottie-trigger-on_scroll',
			'switch-values' => array(
				'false'  => 'No',
				'true'	 => 'Yes',
			),
		),
		'pinSpacing' => array(
			'data-input-type' => 'switch',
			'switch-type'	  => 'twoway',
			'title'		 	  => 'Pin Spacing',
			'size'		 	  => 'span2',
			'class'			  => 'editor-listen',
			'data-handler'	  => 'save',
			'default' 	 	  => 'false',
			'style-class' => 'ov-lottie-trigger-on_scroll',
			'switch-values' => array(
				'false'  => 'No',
				'true'	 => 'Yes',
			),
		),
		'markers' => array(
			'data-input-type' => 'switch',
			'switch-type'	  => 'twoway',
			'title'		 	  => 'Show Markers',
			'help'			  => 'This will show the markers (starting points and triggers) of your animation to make it easier to test and debug.',
			'size'		 	  => 'span4',
			'class'			  => 'editor-listen',
			'data-handler'	  => 'save',
			'default' 	 	  => 'false',
			'style-class' => 'ov-lottie-trigger-on_scroll',
			'switch-values' => array(
				'false'  => 'Disabled',
				'true'	 => 'Enbabled',
			),
		),
	),
);

?>