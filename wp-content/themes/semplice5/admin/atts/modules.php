<?php

// -----------------------------------------
// semplice
// admin/atts/modules.php
// -----------------------------------------

// modules list
$modules = array('paragraph', 'text', 'mailchimp', 'button', 'image', 'gallery', 'oembed', 'spacer', 'video', 'portfoliogrid', 'singleproject', 'advancedportfoliogrid', 'instagram', 'dribbble', 'gallerygrid', 'code', 'share', 'beforeafter', 'socialprofiles', 'lottie');

// include files
foreach ($modules as $module) {
	require get_template_directory() . '/admin/atts/modules/' . $module . '.php';
}

// modules array
$module_options = array(

	// paragraph
	'paragraph' => $paragraph,

	// text
	'text' => $text,

	// mailchimp
	'mailchimp' => $mailchimp,

	// button module
	'button' => $button,

	// image module
	'image' => $image,

	// gallery
	'gallery' => $gallery,

	// oembed module
	'oembed' => $oembed,

	// spacer module
	'spacer' => $spacer,

	// video module
	'video' => $video,

	// portfolio grid
	'portfoliogrid' => $portfoliogrid,

	// single project
	'singleproject' => $singleproject,

	// advanced portfolio grid
	'advancedportfoliogrid' => $advancedportfoliogrid,

	// instagram
	'instagram' => $instagram,

	// dribbble
	'dribbble' => $dribbble,

	// gallery grid
	'gallerygrid' => $gallerygrid,

	// code module
	'code' => $code,

	// share module
	'share' => $share,

	// social profiles
	'socialprofiles' => $socialprofiles,

	// before after
	'beforeafter' => $beforeafter,

	// lottie
	'lottie' => $lottie,
);

?>