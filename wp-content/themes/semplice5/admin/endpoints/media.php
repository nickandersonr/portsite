<?php

// -----------------------------------------
// semplice
// /admin/endpoints/media.php
// -----------------------------------------

class admin_api_media extends admin_api {

	// public vars
	public $db, $editor, $rev_table_name;

	// constructor
	public function __construct() {
		// database
		global $wpdb;
		$this->db = $wpdb;
		$this->rev_table_name = $wpdb->prefix . 'semplice_revisions';

		// editor api
		global $editor_api;
		$this->editor = $editor_api;

		// call register routes on rest api init
		add_action('rest_api_init', array(&$this, 'register_routes'));
	}

	// -----------------------------------------
	// rest routes
	// -----------------------------------------

	public function register_routes() {
		$version = '1';
		$namespace = 'semplice/v' . $version . '/admin';

		// routes
		$routes = array(
			'/media/get'				=> array('readable', 'get_media'),
			'/media/search'				=> array('readable', 'search_media'),
			'/media/delete'				=> array('creatable', 'delete_media'),
			'/media/folder/add'			=> array('creatable', 'add_media_folder'),
			'/media/folder/rename'		=> array('creatable', 'rename_media_folder'),
			'/media/folder/delete'		=> array('creatable', 'delete_media_folder'),
			'/media/add-to-folder'		=> array('creatable', 'add_media_to_folder'),
			'/media/meta/get'			=> array('readable', 'get_media_meta'),
			'/media/meta/save'			=> array('creatable', 'save_media_meta'),
		);

		// register routes
		semplice_register_route($namespace, $routes, $this);
	}

	// -----------------------------------------
	// endpoints
	// -----------------------------------------

	// upload media
	public function get_media($request) {
		// output
		$output = array('html' => '', 'is_end' => false);
		// get folders
		$output['html'] = semplice_sml_get_folders(intval($request['folder']));
		// attachments
		$output['html'] .= '<div class="sml-attachments" data-offset="' . $request['offset'] . '"><div class="sml-attachments-inner">';
		// tax query args
		$tax_query_args = array(
			'taxonomy' => 'semplice_folder',
			'operator' => 'NOT EXISTS'
		);
		if(is_numeric($request['folder'])) {
			$tax_query_args = array(
				'taxonomy' => 'semplice_folder',
				'field' => 'term_id',
				'terms' => $request['folder']
			);
		}
		// get posts
		$args = array(
			'post_type' => 'attachment',
			'post_status' => null,
			'numberposts' => 120,
			'offset' => $request['offset'],
			'orderby' => 'ID', 
			'tax_query' => array($tax_query_args),
		);
		// get posts
		$attachments = get_posts($args);
		// attachments html
		$attachments_html = '';
		// has posts?
		if(is_array($attachments) && !empty($attachments)){
			foreach($attachments as $attachment){
				// add to output
				$attachments_html .= semplice_sml_get_attachment($attachment);
			}
		} else {
			$attachments_html .= '<div class="sml-empty-state"><p>Drop your files here</p></div>';
		}
		
		// is lazy load?
		if($request['offset'] > 0) {
			// is already smaller 120?
			if(count($attachments) < 120) {
				$output['is_end'] = true;
			}
			// is no new attachment?
			if(count($attachments) > 0) {
				$output['html'] = $attachments_html;
			} else {
				$output['html'] = '';
			}
		} else {
			$output['html'] .= $attachments_html;
			// close
			$output['html'] .= '</div></div>';
		}
		// return
		return new WP_REST_Response($output, 200);
	}

	// search media
	public function search_media($request) {
		// output
		$output = '';
		// keyword
		$keyword = $request['keyword'];
		// global wpdb
		global $wpdb;
		// search posts
		$attachments = $wpdb->get_results(
			$wpdb->prepare (
				"
				SELECT *
				FROM $wpdb->posts
				WHERE post_type = 'attachment' AND post_title LIKE '%s'
				OR post_type = 'attachment' AND post_excerpt LIKE '%s'
				OR post_type = 'attachment' AND post_content LIKE '%s'
				ORDER BY ID DESC
				",
				'%' . $wpdb->esc_like($keyword) . '%',
				'%' . $wpdb->esc_like($keyword) . '%',
				'%' . $wpdb->esc_like($keyword) . '%'
			),
			OBJECT
		);
		// has posts?
		if(is_array($attachments) && !empty($attachments)){
			foreach($attachments as $attachment){
				// add to output
				$output .= semplice_sml_get_attachment($attachment);
			}
		} else {
			$output .= '<div class="sml-empty-search"><p>No attachments found for "' . $keyword . '"</p></div>';
		}
		// return
		return new WP_REST_Response($output, 200);
	}

	// delete media
	public function delete_media($request) {
		// attachments
		$attachments = $request['attachments'];
		// make sure its an array
		if(is_array($attachments)) {
			// set object term for each image
			foreach ($attachments as $attachment => $id) {
				// delete attachment
				wp_delete_attachment($id, true);
				// delete object term relationships
				wp_delete_object_term_relationships($id,'semplice_folder');
			}
		}
		// return
		return new WP_REST_Response($attachments, 200);
	}

	// add media folder
	public function add_media_folder($request) {
		// output
		$output = array(
			'term' => wp_insert_term($request['title'], 'semplice_folder'),
			'folders' => semplice_sml_get_folders(intval($request['active_folder'])),
		);
		// return
		return new WP_REST_Response($output, 200);
	}

	// rename folder
	public function rename_media_folder($request) {
		// output
		$output = array(
			'term' => wp_update_term($request['id'], 'semplice_folder', array('name' => $request['title'])),
			'folders' => semplice_sml_get_folders(intval($request['active_folder'])),
		);
		// return
		return new WP_REST_Response($output, 200);
	}

	// delete folder
	public function delete_media_folder($request) {
		// delete term first
		$term = wp_delete_term($request['id'], 'semplice_folder');
		// attachments html
		$attachments_html = '';
		// is active folder the same as folder id?
		if($request['active_folder'] == $request['id'] || $request['active_folder'] == 'uncategorized') {
			// get uncategorized attachments
			$args = array(
				'post_type' => 'attachment',
				'post_status' => null,
				'numberposts' => 120,
				'offset' => 0,
				'tax_query' => array(
					array(
						'taxonomy' => 'semplice_folder',
						'operator' => 'NOT EXISTS',
					),
				),
			);
			// get posts
			$attachments = get_posts($args);
			// attachments html
			$attachments_html = '';
			// has posts?
			if(is_array($attachments) && !empty($attachments)){
				foreach($attachments as $attachment){
					// add to output
					$attachments_html .= semplice_sml_get_attachment($attachment);
				}
			} else {
				$attachments_html .= '<div class="sml-empty-state"><p>Drop your files here</p></div>';
			}
		}
		// output
		$output = array(
			'term' => $term,
			'folders' => semplice_sml_get_folders(intval($request['active_folder'])),
			'attachments' => $attachments_html,
		);
		// return
		return new WP_REST_Response($output, 200);
	}

	// add media to folder
	public function add_media_to_folder($request) {
		$output = '';
		// attachments
		$attachments = $request['attachments'];
		// make sure its an array
		if(is_array($attachments)) {
			// set object term for each attachment
			foreach ($attachments as $attachment => $id) {
				wp_set_object_terms($id, intval($request['folder']), 'semplice_folder');
			}
		}
		// return
		return new WP_REST_Response($output, 200);
	}

	// get media meta
	public function get_media_meta($request) {
		$output = '';
		// attachments
		$attachment = get_post($request['id']);
		// make sure its an array
		if(is_object($attachment)) {
			// get alt text
			$alt_text = semplice_get_image_alt($attachment->ID);
			// get sizes
			$sizes = wp_get_attachment_image_src($attachment->ID, 'full', false);
			if(false === $sizes) {
				$sizes = array(0,0,0);
			}
			// file size
			$file = get_attached_file($request['id']);
			$filesize = filesize($file); // bytes
			$filesize = round($filesize / 1024, 2);
			// get attachment url
			$attachment_url = wp_get_attachment_url($attachment->ID);
			// add metas
			$output = array(
				'url' => $attachment_url,
				'width' => $sizes[1],
				'height' => $sizes[2],
				'size' => $filesize,
				'date' => $attachment->post_date,
				'title' => $attachment->post_title,
				'caption' => $attachment->post_excerpt,
				'alt' => $alt_text,
				'description' => $attachment->post_content,
				'mime' => $attachment->post_mime_type,
			);
		}
		// return
		return new WP_REST_Response($output, 200);
	}

	// save media meta
	public function save_media_meta($request) {
		$output = '';
		// attachments
		$meta = json_decode($request['meta'], true);
		// make sure its an array
		if(null !== $meta && is_array($meta) && !empty($meta)) {
			// args
			$post_args = array(
				'ID' => $request['id'],
				'post_title' => $meta['title'],
				'post_excerpt' => $meta['caption'],
				'post_content' => $meta['description']
			);
			// update post
			wp_update_post($post_args);
			// save alt
			if(!empty($meta['alt'])) {
				update_post_meta($request['id'], '_wp_attachment_image_alt', $meta['alt']);
			}
		}
		// return
		return new WP_REST_Response($output, 200);
	}	
}

// -----------------------------------------
// build instance of endpoints
// -----------------------------------------

$admin_api_media = new admin_api_media();

?>