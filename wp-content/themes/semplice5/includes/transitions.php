<?php

// -----------------------------------------
// semplice
// includes/transitions.php
// -----------------------------------------
	
$transition_atts = array(
	'options' => array(
		'status'	=> 'disabled',
		'preset'	=> 'fade',
		// enabled scrollToTop per default
		'scrollToTop'  => 'enabled',
	),
	'presets' => array(
		'fade' => array(
			'in' => array(
				'effect'   		=> 'fadeIn',
				'position' 		=> 'normal',
				'visibility'	=> 'transition-hidden',
				'easing' 	   	=> 'Expo.easeInOut',
				'duration' 		=> 1,
			),
			'out' => array(
				'effect'   		=> 'fadeOut',
				'position' 		=> 'normal',
				'visibility'	=> 'transition-hidden',
				'easing' 	   	=> 'Expo.easeInOut',
				'duration' 		=> 1,
			),
		),
		'rightToLeft' => array(
			'in' => array(
				'effect'   		=> 'moveRightToLeft',
				'position' 		=> 'right',
				'to'			=> '-100%',
				'visibility'	=> '',
				'easing' 	   	=> 'Expo.easeInOut',
				'duration' 		=> 1,
			),
			'out' => array(
				'effect'   		=> 'moveRightToLeft',
				'position' 		=> 'normal',
				'to'			=> '-100%',
				'visibility'	=> '',
				'easing' 	   	=> 'Expo.easeInOut',
				'duration' 		=> 1,
			),
		),
		'leftToRight' => array(
			'in' => array(
				'effect'   		=> 'moveLeftToRight',
				'position' 		=> 'left',
				'to'			=> '100%',
				'visibility'	=> '',
				'easing' 	   	=> 'Expo.easeInOut',
				'duration' 		=> 1,
			),
			'out' => array(
				'effect'   		=> 'moveLeftToRight',
				'position' 		=> 'normal',
				'to'			=> '100%',
				'visibility'	=> '',
				'easing' 	   	=> 'Expo.easeInOut',
				'duration' 		=> 1,
			),
		),
		'topToBottom' => array(
			'in' => array(
				'effect'   		=> 'moveTopToBottom',
				'position' 		=> 'top',
				'to'			=> '100%',
				'visibility'	=> '',
				'easing' 	   	=> 'Expo.easeInOut',
				'duration' 		=> 1,
			),
			'out' => array(
				'effect'   		=> 'moveTopToBottom',
				'position' 		=> 'normal',
				'to'			=> '100%',
				'visibility'	=> '',
				'easing' 	   	=> 'Expo.easeInOut',
				'duration' 		=> 1,
			),
		),
		'bottomToTop' => array(
			'in' => array(
				'effect'   		=> 'moveBottomToTop',
				'position' 		=> 'bottom',
				'to'			=> '-100%',
				'visibility'	=> '',
				'easing' 	   	=> 'Expo.easeInOut',
				'duration' 		=> 1,
			),
			'out' => array(
				'effect'   		=> 'moveBottomToTop',
				'position' 		=> 'normal',
				'to'			=> '-100%',
				'visibility'	=> '',
				'easing' 	   	=> 'Expo.easeInOut',
				'duration' 		=> 1,
			),
		),
		'reveal' => array(
			'direction'				=> 'topToBottom',
			'easing' 	   			=> 'Expo.easeInOut',
			'duration' 				=> .95,
			'color'					=> '#ffd300',
			'offset'				=> '450',
			'image'					=> false,
			'image_size'			=> 'auto',
			'image_align'			=> '50% 50%',
			'image_offset'			=> '600',
		),
	),
);