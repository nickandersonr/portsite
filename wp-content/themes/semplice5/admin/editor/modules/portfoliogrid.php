<?php

// -----------------------------------------
// semplice
// admin/editor/modules/portfoliogrid/module.php
// -----------------------------------------

if(!class_exists('sm_portfoliogrid')) {

	class sm_portfoliogrid {

		public $output;
		public $is_editor;

		// constructor
		public function __construct() {
			// define output
			$this->output = array(
				'html' => '',
				'css'  => '',
			);
			// set is editor
			$this->is_editor = true;
		}

		// output frontend
		public function output_editor($values, $id) {

			// css output
			$styles = array(
				'css' => '',
				'mobile_css' => array(
					'lg' => '',
					'md' => '',
					'sm' => '',
					'xs' => '',
				),
			);

			// extract options
			extract( shortcode_atts(
				array(
					'project_display'			=> 'default',
					'limit'						=> 20,
					'lazy_load_initial'			=> 20,
					'lazy_load_per_load'		=> 20,
					'lazy_load_button'			=> get_template_directory_uri() . '/assets/images/frontend/icons/button_load_more.svg',
					'lazy_load_button_width'	=> '3.333333333333333rem',
					'lazy_load_padding_top'		=> '2.222222222222222rem',
					'lazy_load_padding_bottom'	=> '5.555555555555556rem',
					'categories'				=> '',
					'hor_gutter'				=> 30,
					'ver_gutter'				=> 30,
					'title_visibility'			=> 'both',
					'title_position'			=> 'below',
					'title_padding'				=> '1rem',
					'title_color'				=> '#000000',
					'title_fontsize'			=> '16px',
					'title_font'				=> 'regular',
					'title_text_transform'		=> 'none',
					'category_color'			=> '#999999',
					'category_fontsize'			=> '14px',
					'category_font'				=> 'regular',
					'category_text_transform'	=> 'none',
					'category_padding_top'		=> '0.4444444444444444rem',
					'filter_alignment'			=> 'flex-end',
					'filter_showall'			=> 'Show All',
					'filter_color'				=> '#bbbbbb',
					'filter_color_active'		=> '#000000',
					'filter_fontsize'			=> '1.111111111111111rem',
					'filter_font'				=> 'regular',
					'filter_text_transform'		=> 'none',
					'filter_padding'			=> '1.555555555555556rem',
					'filter_item_padding'		=> '1.555555555555556rem',
					'filter_letter_spacing'		=> '0',
					'filter_text_decoration'	=> 'none',
					'filter_mobile_visibility'	=> 'visible',
				), $values['options'] )
			);

			// get portfolio order
			$portfolio_order = json_decode(get_option('semplice_portfolio_order'));

			// limit and lazy load
			$limit_num = -1;
			if($project_display == 'limit' && $limit > 0) {
				$limit_num = $limit;
			} else if($project_display == 'lazy_load') {
				$limit_num = $lazy_load_initial;
				// add button width
				$styles['css'] .= '.semplice-load-more { width: ' . $lazy_load_button_width . '; padding: ' . $lazy_load_padding_top . ' 0 ' . $lazy_load_padding_bottom . '; }';
				$values['options']['lazy_load'] = array(
					'start_offset'  => $lazy_load_initial,
					'per_load' 		=> $lazy_load_per_load,
					'button'		=> $lazy_load_button,
				);
			}

			// get projects
			$projects = semplice_get_projects($portfolio_order, $categories, $limit_num, false, false);

			// count projects and add it to the options values
			$values['options']['count'] = count($projects);

			// get thumb hover options
			$global_hover_options = json_decode(get_option('semplice_customize_thumbhover'), true);

			// change title position to below if visibility is hidden
			if($title_visibility == 'hidden') {
				$title_position = 'below';
			}

			// title padding
			$title_css = $this->get_title_padding($title_position, $title_padding);

			// show filter
			$filter_output = '';
			if($project_display == 'category') {
				// open filter
				$filter_output .= '<nav class="pg-category-filter" data-mobile-visibility="' . $filter_mobile_visibility . '"><ul class="masonry-filter">';
				// show all
				$filter_output .= '<li><a class="semplice-event pg-filter-active" data-font="' . $filter_font . '" data-event-type="helper" data-event="filterMasonry" data-category="show-all" data-masonry-element="#masonry-' . $id . '">' . $filter_showall . '</a></li>';
				// if not categories get all categories
				if(!is_array($categories) || empty($categories)) {
					// category ids
					$category_ids = array();
					// get categories
					$categories = get_terms('category','orderby=count&hide_empty=0');
					// iterate categories to get the right format
					foreach ($categories as $index => $category) {
						$category_ids[$index] = $category->term_id;
					}
					// define filter categories
					$categories = $category_ids;
				}
				// iterate categories and add to filter
				foreach ($categories as $category_id) {
					$filter_output .= '<li><a class="semplice-event" data-event-type="helper" data-event="filterMasonry" data-font="' . $filter_font . '" data-category="' . $category_id . '" data-masonry-element="#masonry-' . $id . '">' . get_cat_name($category_id) . '</a></li>';
				}
				// end filter
				$filter_output .= '</ul></nav>';

				// css defaults
				$values['options']['filter_alignment'] = $filter_alignment;
				$values['options']['filter_padding'] = $filter_padding;
				$values['options']['filter_item_padding'] = $filter_item_padding;
				$values['options']['filter_fontsize'] = $filter_fontsize;
				$values['options']['filter_letter_spacing'] = $filter_letter_spacing;

				// get filter css
				$selector = '[data-breakpoint="##breakpoint##"] #content-holder #' . $id . ' nav ul';
				$styles = semplice_get_css($selector, 'filter_alignment', array('justify-content'), $values['options'], false, false, $styles);
				$styles = semplice_get_css($selector, 'filter_padding', array('padding-bottom'), $values['options'], false, false, $styles);
				$styles = semplice_get_css($selector . ' li a', 'filter_item_padding', array('padding-right'), $values['options'], false, false, $styles);
				$styles = semplice_get_css($selector . ' li a', 'filter_fontsize', array('font-size'), $values['options'], false, false, $styles);
				$styles = semplice_get_css($selector . ' li a', 'filter_letter_spacing', array('letter-spacing'), $values['options'], false, false, $styles);

				// remove breakpoint prefix for desktop styles
				$styles['css'] = str_replace('[data-breakpoint="##breakpoint##"] ', '', $styles['css']);
			}
			
			// are there any published projects
			if(!empty($projects)) {

				// get masonry items
				$atts = array(
					'global_hover_options' => $global_hover_options,
					'title_visibility' => $title_visibility,
					'title_position' => $title_position,
					'category_font' => $category_font,
					'title_font' => $title_font,
				);
				
				// gutter numeric?
				if(!is_numeric($hor_gutter)) { $hor_gutter = 30; }
				if(!is_numeric($ver_gutter)) { $ver_gutter = 39; }

				// masonry items
				$masonry_items = '';

				// add to css
				$styles['css'] .= semplice_thumb_hover_css(false, $global_hover_options, true, '#content-holder', $this->is_editor);

				foreach ($projects as $key => $project) {
					// get masonry items
					$masonry_items .= $this->get_masonry_items($id, $project, $atts, $this->is_editor, '');

					// thumb hover css if custom thumb hover is set
					if(isset($project['thumb_hover'])) {
						$styles['css'] .= semplice_thumb_hover_css('project-' . $project['post_id'], $project['thumb_hover'], false, '#content-holder', $this->is_editor);
					}
				}

				// add to css
				$styles['css'] .= '
					#content-holder #' . $id . ' .thumb .post-title { 
						' . $title_css . '
					}
					#' . $id . ' .thumb .post-title,
					#' . $id . ' .thumb .post-title a {
						color: ' . $title_color . ';
						font-size: ' . $title_fontsize . ';
						text-transform: ' . $title_text_transform . ';
					}
					#' . $id . ' .thumb .post-title span,
					#' . $id . ' .thumb .post-title a span {
						color: ' . $category_color . ';
						font-size: ' . $category_fontsize . ';
						text-transform: ' . $category_text_transform . ';
						padding-top: ' . $category_padding_top . ';
					}
					#content-holder #' . $id . ' nav ul li a {
						color: ' . $filter_color . ';
						text-transform: ' . $filter_text_transform . ';
					}
					#content-holder #' . $id . ' nav ul li a:hover,
					#content-holder #' . $id . ' nav ul li a.pg-filter-active {
						color: ' . $filter_color_active . ';
						text-decoration: ' . $filter_text_decoration . ';
					}
				';

				// mobile title options
				$selector = '[data-breakpoint="##breakpoint##"] #content-holder #' . $id . ' .thumb';
				$styles = semplice_get_css($selector . ' .post-title, ' . $selector . ' .post-tile a', 'title_fontsize', array('font-size'), $values['options'], false, false, $styles);
				$styles = semplice_get_css($selector . ' .post-title span, ' . $selector . ' .post-tile a span', 'category_fontsize', array('font-size'), $values['options'], false, false, $styles);
				$styles = semplice_get_css($selector . ' .post-title span, ' . $selector . ' .post-tile a span', 'category_padding_top', array('padding-top'), $values['options'], false, false, $styles);

				// iterate breakpoints
				$breakpoints = semplice_get_breakpoints();
				foreach ($breakpoints as $breakpoint => $width) {
					if(isset($values['options']['title_padding_' . $breakpoint])) {
						$styles['mobile_css'][$breakpoint] .= $selector . ' .post-title {' . $this->get_title_padding($title_position, $values['options']['title_padding_' . $breakpoint]) . '}';
					}
					if(!empty($styles['mobile_css'][$breakpoint])) {
						if(true === $this->is_editor) {
							$styles['css'] .= str_replace('##breakpoint##', $breakpoint, $styles['mobile_css'][$breakpoint]);
						} else {
							$styles['css'] .= '@media screen' . $width['min'] . $width['max'] . ' { ' . str_replace('[data-breakpoint="##breakpoint##"] ', '', $styles['mobile_css'][$breakpoint]) . '}';
						}
					}
				}

				// add gutters to css
				$styles['css'] .= semplice_masonry_mobile_css($id, $values['options'], false, $this->is_editor, $hor_gutter, $ver_gutter, true);

				// add css
				$this->output['css'] = $styles['css'];

				// get masonry
				$this->output['html'] = $filter_output . semplice_masonry('portfoliogrid', $id, $values['options'], $masonry_items, $this->is_editor, $values['script_execution']);
			} else {
				$this->output['html'] = semplice_module_placeholder('portfoliogrid', 'Please note that only published projects are visible in the portfolio grid.', false, true);
			}

			// output
			return $this->output;
		}

		// get title padding
		public function get_title_padding($pos, $val) {
			if(strpos($pos, 'below') === false) {
				return 'padding: ' . $val . ';';
			} else {
				return 'padding: ' . $val . ' 0 0 0;';
			}
		}

		// get masonry items
		public function get_masonry_items($id, $project, $atts, $is_editor, $lazy_load_class) {
			if(empty($project['image']['width'])) {
				$project['image']['width'] = 6;
			}

			// title and category
			$title = '';
			if($atts['title_visibility'] == 'both') {
				$title = '
					<div class="post-title ' . $atts['title_font'] . '">' . $project['post_title'] . '<span class="' . $atts['category_font'] . '">' . $project['project_type'] . '</span></div>
				'; 
			} else if($atts['title_visibility'] == 'title') {
				$title = '
					<div class="post-title ' . $atts['title_font'] . '">' . $project['post_title'] . '</div>
				'; 
			} else if($atts['title_visibility'] == 'category') {
				$title = '
					<div class="post-title ' . $atts['title_font'] . '"><span class="' . $atts['category_font'] . '">' . $project['project_type'] . '</span></div>
				'; 
			}

			// link title if below
			if(false !== strpos($atts['title_position'], 'below')) {
				$title = '<a class="pg-title-link" href="' . $project['permalink'] . '" title="' . $project['post_title'] . '">' . $title . '</a>';
			}

			// show post settings link on admin
			if(false === $is_editor) {
				$thumb_inner = '<a href="' . $project['permalink'] . '">' . $this->get_thumb_inner($id, $atts['global_hover_options'], $project, true, $title, $atts['title_position']);
			} else {
				$thumb_inner = $this->get_thumb_inner($id, $atts['global_hover_options'], $project, false, $title, $atts['title_position']);
			}

			// category classes
			$category_classes = '';
			if(is_array($project['categories']) && !empty($project['categories'])) {
				$category_classes = ' ';
				foreach ($project['categories'] as $categories => $cat_id) {
					$category_classes .= 'cat-' . $cat_id . ' ';
				}
			}

			// video thumbnail hover
			$video_hover = '';
			if(isset($atts['global_hover_options']['hover_bg_type']) && $atts['global_hover_options']['hover_bg_type'] == 'vid' || isset($project['thumb_hover']['hover_bg_type']) && $project['thumb_hover']['hover_bg_type'] == 'vid') {
				$video_hover = ' video-hover';
			}

			// masonry items open
			$masonry_item = '<div id="project-' . $project['post_id'] . '" class="masonry-item thumb masonry-' . $id . '-item ' . $atts['title_position'] . '' . $category_classes . '' . $video_hover . '' . $lazy_load_class . '" data-xl-width="' . $project['image']['grid_width'] . '" data-sm-width="6" data-xs-width="12">';

			// add thumb inner
			$masonry_item .= $thumb_inner;

			// masonry items close
			$masonry_item .= '</div>';

			// return item
			return $masonry_item;
		}

		// get thumbnail inner html
		public function get_thumb_inner($id, $global_hover_options, $project, $is_frontend, $title, $title_position) {

			// vars
			$post_settings = '';

			if(false === $is_frontend) {
				$post_settings = '<a class="admin-click-handler grid-post-settings" data-content-id="' . $id . '" data-handler="execute" data-action-type="postSettings" data-action="getPostSettings" data-post-id="' . $project['post_id'] . '" data-ps-mode="grid" data-post-type="project" data-thumbnail-src="' . $project['image']['src'] . '">' . get_svg('backend', '/icons/post_settings') . '</a>';
			}

			// define output
			$output = '
				<div class="thumb-inner">
					' . semplice_thumb_hover_html($global_hover_options, $project, $is_frontend) . '
					' . $post_settings . '
					<img src="' . $project['image']['src'] . '" width="' . $project['image']['width'] . '" height="' . $project['image']['height'] . '" alt="' . $project['post_title'] . '">
			';

			// if title is below close the thumb inner link before the title. if title is above, include the title within thumb inner a tag. Note: the title only contains a tags if below
			if(false !== strpos($title_position, 'below')) {
				$output .= '</div></a>' . $title;
			} else {
				$output .= $title . '</div></a>';
			}

			// output
			return $output;
		}

		// output frontend
		public function output_frontend($values, $id) {

			// same as editor
			$this->is_editor = false;
			return $this->output_editor($values, $id);
		}
	}

	// instance
	$this->module['portfoliogrid'] = new sm_portfoliogrid;
}