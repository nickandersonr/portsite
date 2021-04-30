<?php

// -----------------------------------------
// semplice
// admin/editor/editor.php
// -----------------------------------------

class editor {

	// public vars
	public $db;
	public $rev_table_name;
	public $blocks_table_name;
	public $rev_db_version;
	public $module_api;

	public function __construct() {

		// database
		global $wpdb;
		$this->db = $wpdb;
		$this->rev_table_name = $wpdb->prefix . 'semplice_revisions';
		$this->blocks_table_name = $wpdb->prefix . 'semplice_content_blocks';

		// db version
		$this->rev_db_version = get_option("semplice_revisions_rev_db_version");

		// check status
		add_action('init', array(&$this, 'revisions_status'));

		// include module api
		require get_template_directory() . '/admin/editor/module.php';
	}

	// -----------------------------------------
	// duplicate
	// -----------------------------------------
	
	public function generate_duplicate($request) {

		// output module
		$output = array();

		// vars
		$content = $this->check_slashes($request['content']);
		$ram = json_decode($content, true);

		// set mode to editor
		$ram['visibility'] = 'editor';

		// mode
		switch($request['mode']) {
			case 'section':

				// get section content
				$section_output = $this->module_api->generate_output($ram, $request['section_id'], $ram['order'][$request['section_id']], 'enabled');

				// add to html output
				$output['html'] = $section_output['html'];

				// add to css output
				$output['css'] = $section_output['css'];

			break;
			case 'column':
				// add section element to ram
				$ram['section_element'] = '#' . $request['section_id'];
				// add section height to ram
				$ram['section_height'] = array(
					'mode' => 'dynamic',
					'height' => 'auto',
				);
				// get column content
				$column_output = $this->module_api->column_iterate($ram, $request['id'], $ram['order']);
				// add to html output
				$output['html'] = $column_output['html'];
				// css output
				$output['css'] = $column_output['css'];

			break;
			case 'content':

				// set values
				$values = array(
					'module_name' => $ram['module'],
					'content_id'  => $request['id'],
					'content'	  => $ram
				);

				// get content
				$content = $this->module_api->content($values, $ram['visibility'], true);

				// output html
				$output['html'] = $content['html'];

				// add css output
				$output['css'] = $content['css'];

			break;
		}

		// output
		return $output;
	}

	// -----------------------------------------
	// get content
	// -----------------------------------------

	public function get_content($ram, $visibility, $is_block, $is_coverslider) {

		// output
		$output = array(
			'html'   		=> '',
			'css'	 		=> '',
			'motion'		=> array(
				'css'		=> '',
				'js'		=> '',
			),
			'js'	 		=> '',
		);

		// is coverslider?
		if(true === $is_coverslider) {
			// script execution
			$script_execution = 'normal';
			if(isset($ram['script_execution']) && $ram['script_execution'] == 'delayed') {
				$script_execution = 'delayed';
			}
			// get coverslider
			$coverslider = semplice_get_coverslider($ram['coverslider'], $visibility, $script_execution);
			// add to output
			$output = array(
				'html'		  => $coverslider['html'],
				'css'		  => $coverslider['css'],
				'js'		  => $coverslider['js']
			);
		} else {
			// sr status
			$sr_status = 'enabled';

			if(isset($ram['branding']['scroll_reveal']) && $ram['branding']['scroll_reveal'] == 'disabled' || isset($ram['is_footer']) && true === $ram['is_footer']) {
				// set sr status
				$sr_status = 'disabled';
				// js output start
				$output['js']  .= '(function ($) { "use strict";';
			}

			// get cover visibility
			$cover_visibility = isset($ram['cover_visibility']) ? $ram['cover_visibility'] : 'hidden';

			// is cover?
			if(isset($ram['cover'])) {
				$is_cover = true;
			} else {
				$is_cover = false;
			}

			// show default cover if not there
			if($visibility == 'editor' && false === $is_cover && false === $is_block) {
				$output['html'] .= semplice_default_cover($cover_visibility);
			}

			// iterate order
			foreach($ram['order'] as $section_id => $section) {

				// set mode to ram
				if($visibility == 'editor') {
					$ram['visibility'] = 'editor';	
				} else {
					$ram['visibility'] = 'frontend';
				}

				// show cover on editor or on ftontend if visible
				if($section_id != 'cover' || $visibility == 'editor' || $this->has_cover($section_id, $ram['visibility'], $is_cover, $cover_visibility)) {
			
					// get section content
					$section_output = $this->module_api->generate_output($ram, $section_id, $section);

					// add to html output
					$output['html'] .= $section_output['html'];

					// add to css output
					$output['css'] .= $section_output['css'];

					// is scroll reveal deactivated
					if($sr_status == 'disabled' && $visibility != 'editor') {
						// add motion css
						$output['css'] .= $section_output['motion']['css'];

						// add motions to output
						$output['motion']['js'] .= $section_output['motion']['js'];
					}
				}
			}
			// scroll reveal
			if($sr_status == 'disabled' && $visibility != 'editor') {
				// add motions to js output
				$output['js'] .= $output['motion']['js'];

				// js output end
				$output['js'] .= '$(window).scroll();})(jQuery);';
			}
			
			// remove motion since its not need anymore
			unset($output['motion']);

			// branding
			if(!empty($ram['branding'])) {
				// branding css
				if($visibility == 'editor') {
					$output['css'] .= $this->module_api->container_styles('branding', $ram['branding'], '#content-holder', false, 'xl');
				} else {
					$output['css'] .= $this->module_api->container_styles('branding', $ram['branding'], 'body .transition-wrap', false, 'xl');
					// additional branding
					$output['css'] .= $this->branding($ram['branding'], $is_cover);
				}
			}
		}

		// output
		return $output;
	}

	// -----------------------------------------
	// add masterblock to ram
	// -----------------------------------------

	public function init_masterblocks($ram) {
		// decode
		$ram = json_decode($ram, true);
		// images array
		$images = '';
		$image_modules = array('image', 'gallerygrid', 'video', 'gallery');
		// iterate block and replace content from ram with the DB version
		foreach ($ram['order'] as $section_id => $section) {
			// is masterblock?
			if(isset($ram[$section_id]) && isset($ram[$section_id]['masterblock']) && strpos($ram[$section_id]['masterblock'], 'master_') !== false) {
				// get masterblock
				$block = $this->get_masterblock($ram[$section_id]['masterblock']);
				// add masterblock if there
				if(null !== $block && isset($block[$section_id]) && isset($block['order'][$section_id])) {
					// replace section from ram
					$ram[$section_id] = $block[$section_id];
					// get background image and add to images_array
					$images .= semplice_get_background_image($block[$section_id]['styles']['xl']);
					// new section to iterate through
					$section_iterate = array();
					// is old single row mode?
					if(isset($block['order'][$section_id]['columns'])) {
						//move columns to a virtual row to make it compatible with the new multi row system
						$block_section_iterate['row_' . substr(md5(rand()), 0, 9)]['columns'] = $block['order'][$section_id]['columns'];
						$real_section_iterate['row_' . substr(md5(rand()), 0, 9)]['columns'] = $section['columns'];
					} else {
						$block_section_iterate = $block['order'][$section_id];
						$real_section_iterate = $section;
					}
					// iterate rows
					foreach($block_section_iterate as $row_id => $columns) {
						// iterate columns
						foreach ($columns['columns'] as $column_id => $column_content) {
							// get background image and add to images_array
							$images .= semplice_get_background_image($block[$column_id]['styles']['xl']);
							// replace column
							$ram[$column_id] = $block[$column_id];
							// iterate content
							foreach ($column_content as $content_id) {
								// get background image and add to images_array
								$images .= semplice_get_background_image($block[$content_id]['styles']['xl']);
								// get all images used in module
								if(in_array($block[$content_id]['module'], $image_modules)) {
									$images .= semplice_get_used_images($block[$content_id]);
								}
								//replace content
								$ram[$content_id] = $block[$content_id];
							}
						}
					}
					// iterate real order and unset everything that is not in the ram anymore
					foreach($real_section_iterate as $row_id => $columns) {
						// iterate columns
						foreach ($columns['columns'] as $column_id => $column_content) {
							// is columnn in block?
							if(!isset($block[$column_id])) {
								unset($ram[$column_id]);
							}
							// iterate content	
							foreach ($column_content as $content_id) {
								// is content in block?
								if(!isset($block[$content_id])) {
									unset($ram[$content_id]);
								}
							}
						}
					}
					// update section order to block order to make sure ids are matching
					$ram['order'][$section_id] = $block['order'][$section_id];
				} else {
					// unset
					unset($ram[$section_id]);
					// new section to iterate through
					$section_iterate = array();
					// is old single row mode?
					if(isset($section['columns'])) {
						//move columns to a virtual row to make it compatible with the new multi row system
						$section_iterate['row_' . substr(md5(rand()), 0, 9)]['columns'] = $section['columns'];
					} else {
						$section_iterate = $section;
					}
					// iterate rows
					foreach($section_iterate as $row_id => $columns) {
						// iterate columns
						foreach ($columns['columns'] as $column_id => $column_content) {
							// unset column
							unset($ram[$column_id]);
							// iterate content
							foreach ($column_content as $content_id) {
								// unset content
								unset($ram[$content_id]);
							}
						}
					}
				}
			}
		}
		// add images to ram
		$images_arr = semplice_blocks_image_array($images);
		if(is_array($images_arr)) {
			foreach ($images_arr as $image_id => $image) {
				$ram['images'][$image_id] = $image;
			}
		}
		// return ram
		return json_encode($ram, JSON_FORCE_OBJECT);
	}

	// -----------------------------------------
	// get masterblock
	// -----------------------------------------

	public function get_masterblock($id) {
		// get block
		$block = $this->db->get_row("SELECT content FROM $this->blocks_table_name WHERE masterblock = '$id'", ARRAY_A);
		if(null !== $block) {
			// decode
			$block = json_decode($block['content'], true);
		}
		// return block
		return $block;
	}

	// -----------------------------------------
	// navigator
	// -----------------------------------------

	public function navigator() {
		
		$output = '
		<div class="inner">
			<div class="exit-ce">
				<a class="editor-action semplice-button exit-button semplice-navigator-hover" data-action="exit" data-action-type="popup"><span>' . get_svg('backend', 'icons/exit_arrow') . '</span> Back to Dashboard</a>
			</div>
			<h3 class="pages-projects-heading">Pages &amp; Projects</h3>
			<div class="posts">
				<div class="pages">
					<h4><a data-new-url="#content/pages/1" data-exit-mode="close" class="editor-action" data-action-type="popup" data-action="exit">Pages</a></h4>
					<ul>';
							// list projects
							global $post;
							
							// args
							$pages_args = array(
								'sort_order' 		=> 'ASC',
								'post_type' 		=> 'page',
								'post_status' 		=> 'publish,private,draft',
								'posts_per_page'   	=> -1,
								'orderby'			=> 'modified',
							);

							$pages = get_posts($pages_args);
							
							if($pages) {
								foreach($pages as $page) {
									// truncate title	
									$title_truncated = (strlen($page->post_title) > 24) ? substr($page->post_title, 0, 24) . '...' : $page->post_title;
									// output list element					
									$output .= '<li><a data-new-url="#edit/' . $page->ID . '" data-reopen="#edit/' . $page->ID . '" data-exit-mode="re-open" class="editor-action" data-action-type="popup" data-action="exit">' . $title_truncated . '</a></li>';
								}
							}
			$output .= '
					</ul>
				</div>
				<div class="projects">
					<h4><a data-new-url="#content/projects/1" data-exit-mode="close" class="editor-action" data-action-type="popup" data-action="exit">Projects</a></h4>
					<ul>';
							// list projects
							global $post;
							
							// args
							$project_args = array(
								'sort_order' 		=> 'ASC',
								'post_type' 		=> 'project',
								'post_status' 		=> 'publish,private,draft',
								'posts_per_page'   	=> -1,
								'orderby'			=> 'modified',
							);

							$projects = get_posts($project_args);
							
							if($projects) {
								foreach($projects as $project) {
									// truncate title	
									$title_truncated = (strlen($project->post_title) > 24) ? substr($project->post_title, 0, 24) . '...' : $project->post_title;
									// output list element									
									$output .= '<li><a data-new-url="#edit/' . $project->ID . '" data-reopen="#edit/' . $project->ID . '" data-exit-mode="re-open" class="editor-action" data-action-type="popup" data-action="exit">' . $title_truncated . '</a>';
								}
							}
			$output .= '
					</ul>
				</div>
			</div>
			<h3>Customize</h3>
			<div class="navigator-customize">
				' . semplice_get_customize_nav('customize', 'navigator') . '
			</div>
			<h3 class="settings-heading">Settings</h3>
			<div class="navigator-customize">
				' . semplice_get_customize_nav('settings', 'navigator') . '
			</div>
		</div>
		';
		return $output;
	}

	// -----------------------------------------
	// branding
	// -----------------------------------------

	public function branding($options) {

		// define css
		$css = '';

		// display content
		if(isset($options['display_content']) && $options['display_content'] == 'top') {
			$css .= '#content-holder .sections { margin-top: 0px !important; }';
		}
		// top arrow colo
		if(isset($options['top_arrow_color'])) {
			$css .= '.back-to-top a svg { fill: ' . $options['top_arrow_color'] . '; }';
		}
		// custom css
		if(isset($options['custom_post_css'])) {
			$css .= $options['custom_post_css'];
		}
		// return
		return $css;
	}

	// -----------------------------------------
	// revisions
	// -----------------------------------------

	public function revisions_status() {

		// atts
		$atts = array(
			'rev_db_version' => '1.0',
			'is_update'  	 => false,
			'sql'		 	 => ''
		);

		// check if table is already created
		if($this->db->get_var("SHOW TABLES LIKE '$this->rev_table_name'") !== $this->rev_table_name || $this->rev_db_version !== $atts['rev_db_version']) {
			// setup revisions (install or update)
			$this->setup_revisions($atts);
		}
	}

	// -----------------------------------------
	// setup revisions
	// -----------------------------------------

	public function setup_revisions($atts) {

		// charset
		$charset_collate = $this->db->get_charset_collate();

		// database tables
		$atts['sql'] = "CREATE TABLE $this->rev_table_name (
				ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				post_id bigint(20) NOT NULL,
				revision_id tinytext NOT NULL,
				revision_title tinytext NOT NULL,
				content longtext NOT NULL,
				settings longtext NOT NULL,
				wp_changes boolean NOT NULL,
				PRIMARY KEY (ID)
			) $charset_collate;";

		// install or update table
		if (!function_exists('revisions_db_install')) {
			function revisions_db_install($atts) {
		
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				
				dbDelta($atts['sql']);

				if($atts['is_update'] !== true) {
					// add db version to wp_options
					add_option('semplice_revisions_rev_db_version', $atts['rev_db_version']);
				} else {
					// update db version in wp_optionss
					update_option('semplice_revisions_rev_db_version', $atts['rev_db_version']);
				}
			}
		}
		
		// check if table exists, if not install table
		if($this->db->get_var("SHOW TABLES LIKE '$this->rev_table_name'") !== $this->rev_table_name) {
			revisions_db_install($atts);
		}

		if ($this->rev_db_version !== $atts['rev_db_version']) {

			// is update
			$atts['is_update'] = true;
			
			// update db
			revisions_db_install($atts);
			
		}
	}

	// -----------------------------------------
	// get revisions
	// -----------------------------------------

	public function get_revisions($post_id) {
		// output
		$output = '';

		// get post revision
		$post_revision = $this->get_post_revision($post_id);

		// get revisions
		$revisions = $this->db->get_results( 
			"
			SELECT * 
			FROM $this->rev_table_name
			WHERE post_id = $post_id
			ORDER BY ID DESC
			"
		);

		// post status
		$post_status = get_post_status($post_id);

		if(!empty($revisions) && count($revisions) > 0) {
			// loop throuh blocks
			foreach($revisions as $revision) {
				// is latest version?
				if($revision->revision_title == 'Latest Version') {
					$revision->revision_title = 'Default Version';
				}
				// status class
				$status_class = '';
				$published = '';
				if($revision->revision_id == $post_revision['active']) {
					$status_class .= ' revision-active';
				}
				if($revision->revision_id == $post_revision['published'] && $post_status == 'publish') {
					$status_class .= ' revision-published';
				}
				// title
				if(strlen($revision->revision_title) > 20) {
					$revision->revision_title = substr($revision->revision_title, 0, 24) . '...';
				}
				$output .= '
					<li id="' . $revision->revision_id . '" class="revision-list-item' . $status_class . '">
						<a class="load-revision editor-action" data-action-type="revisions" data-action="load" data-revision-id="' . $revision->revision_id . '">' . $revision->revision_title . '</a>
						<div class="revision-options">
							<a class="rename-revision editor-action" data-action-type="popup" data-action="renameRevision" data-revision-id="' . $revision->revision_id . '"></a>
							<a class="remove-revision editor-action" data-action-type="popup" data-action="deleteRevision" data-revision-id="' . $revision->revision_id . '"></a>
						</div>
					</li>
				';
				
			}
		} else {
			// empty state
			$output = 'empty';
		}

		// return
		return $output;
	}
	
	// -----------------------------------------
	// get post revision
	// -----------------------------------------

	public function get_post_revision($post_id) {
		// get post revision
		$post_revision = get_post_meta($post_id, '_semplice_revisions', true);
		// is available?
		if(empty($post_revision) || !is_array($post_revision)) {
			return array(
				'active' => 'latest_version',
				'published' => 'latest_version',
			);
		} else {
			return $post_revision;
		}
	}

	// -----------------------------------------
	// has cover?
	// -----------------------------------------

	public function has_cover($id, $mode, $is_cover, $visibility) {
		// get hidden covers from coverslider
		$hide_cover = false;
		if(isset($_POST['hide_cover']) || isset($_GET['hide_cover'])) {
			$hide_cover = true;
		}
		// is id cover and cover is created?
		if($id == 'cover' && true === $is_cover && false === $hide_cover) {
			// is editor, always show it
			if($mode == 'editor') {
				$has_cover = true;
			} else if($mode == 'frontend' && $visibility == 'visible') {
				$has_cover = true;
			} else {
				$has_cover = false;
			}
		} else {
			$has_cover = false;
		}
		return $has_cover;
	}
}

?>