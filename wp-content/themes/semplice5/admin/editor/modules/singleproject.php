<?php

// -----------------------------------------
// semplice
// admin/editor/modules/singleproject.php
// -----------------------------------------

if(!class_exists('sm_singleproject')) {
	class sm_singleproject {

		public $output;
		public $is_editor;

		// constructor
		public function __construct() {
			// define output
			$this->output = array(
				'html' => '',
				'css'  => '',
				'postid' => false,
			);
			// set is editor
			$this->is_editor = true;
		}

		// output editor
		public function output_editor($values, $id) {
			// output
			$output = array(
				'html' => '',
				'css'  => '',
				'postid' => false,
			);
			// get project id
			$project_id = $values['content']['xl'];

			// global hover
			$hover = json_decode(get_option('semplice_customize_thumbhover'), true);
			// is new?
			if(empty($project_id) && $project_id != 0) {
				// get pages
				$posts = get_posts(array('posts_per_page' => 1, 'post_type' => 'project', 'order' => 'ASC'));
				// get first post if there
				if(is_array($posts) && !empty($posts) && isset($posts[0])) {
					$project_id = $posts[0]->ID;
					$output['postid'] = $project_id;
				}
			}
			// get project
			$projects = semplice_get_projects(array($project_id), false, 1, 0, false);
			// show project or placeholder if empty
			if(isset($projects) && is_array($projects) && !empty($projects)) {
				$project = $projects[0];
				// video thumbnail hover
				$video_hover = '';
				if(isset($hover['hover_bg_type']) && $hover['hover_bg_type'] == 'vid' || isset($project['thumb_hover']['hover_bg_type']) && $project['thumb_hover']['hover_bg_type'] == 'vid') {
					$video_hover = ' video-hover';
				}
				// thumb hover css if custom thumb hover is set
				if(isset($project['thumb_hover'])) {
					$output['css'] .= semplice_thumb_hover_css('project-' . $project['post_id'], $project['thumb_hover'], false, '#content-holder [data-module="singleproject"]', false);
					$hover = $project['thumb_hover'];
				}
				$output['html'] = '
					<div id="project-' . $project['post_id'] . '" class="thumb' . $video_hover . '">
						<div class="thumb-inner">
								' . semplice_thumb_hover_html($hover, $project, true) . '
								<img class="sp-thumbnail" src="' . $project['image']['src'] . '" width="' . $project['image']['width'] . '" height="' . $project['image']['height'] . '" alt="' . $project['post_title'] . '">
						</div>
					</div>
				';
				// wrap for frontend
				if(false === $this->is_editor) {
					$output['html'] = '<a href="' . $project['permalink'] . '">' . $output['html'] . '</a>';
				}
			} else {
				$output['html'] = semplice_module_placeholder('singleproject', 'You either removed your project, need to publish it or haven\'t created one yet.', false, true);
			}
			// output
			return $this->output = array(
				'html'   => $output['html'],
				'css'  	 => $output['css'],
				'postid' => $output['postid']
			);
		}

		// output frontend
		public function output_frontend($values, $id) {
			// set is editor
			$this->is_editor = false;
			// same as editor
			return $this->output_editor($values, $id);
		}
	}

	// instance
	$this->module['singleproject'] = new sm_singleproject;
}