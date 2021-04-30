<?php

/*
Plugin Name: XXII_Daemon #462251
Plugin URI: https://www.myfonts.com
Description: MyFonts WordPress Plugin
Version: 0.1
Author: MyFonts Team
Author URI: https://www.myfonts.com
*/

if ( version_compare( PHP_VERSION, '5.4.0', '<') ) {
    die("Cannot activate MyFonts plugin because your PHP version is out of date. <br />Please use at least PHP 5.4 (currently using ".PHP_VERSION.") with the MyFonts WordPress plugin.");
}

require_once('installer.inc');
if(is_admin()) {require_once( 'mf-options.inc' ); }
add_action( 'admin_init', array('MyFontsInstaller_462251','checkInstallation'));
add_action( 'wp_enqueue_scripts', array('MyFontsInstaller_462251','myfonts_loadupWebfonts' ));
