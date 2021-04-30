<?php

// -----------------------------------------
// semplice
// header.php
// -----------------------------------------

// get settings
$settings = json_decode(get_option('semplice_settings_general'), true);

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> data-semplice="<?php echo semplice_theme('version'); ?>">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<?php wp_head(); ?>
		<style>html{margin-top:0px!important;}#wpadminbar{top:auto!important;bottom:0;}</style>
		<?php echo semplice_head($settings); ?>
	</head>
	<body <?php body_class(); semplice_body_bg(); ?> data-post-type="<?php if(is_object($post) && !is_404()) { echo get_post_type($post->ID); } ?>" data-post-id="<?php the_ID(); ?>">