<?php

// -----------------------------------------
// semplice
// admin/atts/settings.php
// -----------------------------------------

// customize list
$settings_list = array('general', 'license');

// include files
foreach ($settings_list as $setting) {
	require get_template_directory() . '/admin/atts/settings/' . $setting . '.php';
}

$settings = array(

	// general settings
	'general' => $general,
	
	// license
	'license' => $license,
);

?>