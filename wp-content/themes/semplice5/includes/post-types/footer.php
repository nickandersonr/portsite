<?php

// -----------------------------------------
// semplice
// /includes/post-types/footer.php
// -----------------------------------------

add_action( 'init', 'smp_register_footer' );

function smp_register_footer() {
	$labels = array(
		'name' => __('Footers', 'semplice'),
		'singular_name' => __('Footer', 'semplice'),
		'add_new' => __('Add New Footer', 'semplice'),
		'add_new_item' => __('Add New Footer', 'semplice'),
		'edit_item' => __('Edit Footer', 'semplice'),
		'new_item' => __('New Footer', 'semplice'),
		'view_item' => __('View Footer', 'semplice'),
		'search_items' => __('Search Footers', 'semplice'),
		'not_found' => __('No footer found', 'semplice'),
		'not_found_in_trash' => __('No footer found in Trash', 'semplice'),
		'parent_item_colon' => __('Parent Footer:', 'semplice'),
		'menu_name' => __('Footer', 'semplice'),
	);
	$args = array(
		'labels' => $labels,
		'menu_icon' => '',
		'hierarchical' => false,
		'description' => __('Description for the Post Type Footer.', 'semplice'),
		'supports' => array( 'title', 'author', 'thumbnail', 'custom-fields'),
		'taxonomies' => array('category'),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => false,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
	);
	register_post_type('footer', $args );
} 
?>