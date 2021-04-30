<?php

// -----------------------------------------
// semplice
// /includes/post-types/portfolio.php
// -----------------------------------------

add_action('init', 'smp_register_project');

function smp_register_project() {
	// get projectrewrite slug
	$slug = semplice_get_project_slug();
	// labels
	$labels = array(
		'name' => __('Projects', 'semplice'),
		'singular_name' => __('Project', 'semplice'),
		'add_new' => __('Add New Project', 'semplice'),
		'add_new_item' => __('Add New Project', 'semplice'),
		'edit_item' => __('Edit Project', 'semplice'),
		'new_item' => __('New Project', 'semplice'),
		'view_item' => __('View Project', 'semplice'),
		'search_items' => __('Search Portfolio', 'semplice'),
		'not_found' => __('No portfolio found', 'semplice'),
		'not_found_in_trash' => __('No portfolio found in Trash', 'semplice'),
		'parent_item_colon' => __('Parent project:', 'semplice'),
		'menu_name' => __('Portfolio', 'semplice'),
	);
	$args = array(
		'labels' => $labels,
		'menu_icon' => '',
		'hierarchical' => false,
		'description' => __('Description for the Post Type project.', 'semplice'),
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
		'rewrite' => array('slug' => $slug),
		'capability_type' => 'post'
	);
	register_post_type('project', $args);
	// flush needed?
	if(true === semplice_boolval(get_option('semplice_flush_rewrite'))) {
		flush_rewrite_rules();
		// set option to false
		update_option('semplice_flush_rewrite', false);
	}
} 
?>