<?php

// -----------------------------------------
// grid
// -----------------------------------------

function semplice_grid($mode) {

	// css
	$output = '';
	$gutter = 0;
	$outer_padding = 30;
	$grid_width = 1170;

	// get custom grid values
	$grid = json_decode(get_option('semplice_customize_grid'), true);

	if(is_array($grid)) {

		// outer padding
		if(isset($grid['outer_padding']) && $mode == 'frontend') {
			$outer_padding = $grid['outer_padding'];
			// outer padding only for desktop
			$output .= '
				@media screen and (min-width: 1170px) {
					.container-fluid, .container, .admin-container {
						padding: 0 ' . round($outer_padding / 18, 5) . 'rem 0 ' . round($outer_padding / 18, 5) . 'rem;
					}
				}
			';
		}

		// grid width
		if(isset($grid['width'])) {
			// is < 1170?
			if($grid['width'] < 1170) {
				$grid_width = 1170;
			} else {
				$grid_width = $grid['width'];
			}	
		}

		// css
		$output .= '.container {
			max-width: ' . ($grid_width + ($outer_padding * 2)) . 'px;
		}';
		
		// mobile gutter
		if(isset($grid['responsive_gutter']) && is_numeric($grid['responsive_gutter'])) {
			$output .= semplice_get_grid_breakpoint($grid['responsive_gutter'], $mode, false);
		}

		// xl gutter 
		if(isset($grid['gutter']) && is_numeric($grid['gutter'])) {
			$output .= semplice_get_grid_breakpoint($grid['gutter'], $mode, true);
			$gutter = $grid['gutter'];
		}		
	}

	return $output;
}

// -----------------------------------------
// grid breakpoint
// -----------------------------------------

function semplice_get_grid_breakpoint($gutter, $mode, $is_desktop) {
	// media query open
	$output = '';
	// define prefix
	$prefix = '';
	if($mode == 'editor') {
		if($is_desktop) {
			$prefix = '[data-breakpoint="xl"]';
		}
		// row
		$output .= $prefix . ' .row {
			margin-left: -' . ($gutter / 2) . 'px;
			margin-right: -' . ($gutter / 2) . 'px;
		}';
		// column
		$output .= $prefix . ' .column, .grid-column {
			padding-left: ' . ($gutter / 2) . 'px;
			padding-right: ' . ($gutter / 2) . 'px;
		}';
	} else {
		if($is_desktop) {
			$prefix = '@media screen and (min-width: 1170px) {';
		} else {
			$prefix = '@media screen and (max-width: 1169px) {';
		}

		$output .= $prefix . ' .row {
			margin-left: -' . ($gutter / 2) . 'px;
			margin-right: -' . ($gutter / 2) . 'px;
		}';
		
		$output .= '.column, .grid-column {
			padding-left: ' . ($gutter / 2) . 'px;
			padding-right: ' . ($gutter / 2) . 'px;
		}';

		// close media query
		$output .= '}';
	}

	return $output;
}

// -----------------------------------------
// masonry
// -----------------------------------------

function semplice_masonry($module, $id, $options, $masonry_items, $is_editor, $script_execution) {
	// load more
	$load_more = '';
	if(isset($options['lazy_load']) && is_array($options['lazy_load'])) {
		// short
		$lazy_load = $options['lazy_load'];
		// get button image
		if(is_numeric($lazy_load['button'])) {
			$lazy_load['button'] = semplice_get_image($lazy_load['button'], 'full');
		}
		// only show button if count of projects is > starting offset
		if($options['count'] >= $lazy_load['start_offset']) {
			// get grid options
			extract( shortcode_atts(
				array(
					'categories'				=> '',
					'title_visibility'			=> 'both',
					'title_position'			=> 'below',
					'title_font'				=> 'regular',
					'category_font'				=> 'regular',
				), $options)
			);
			// categories
			if(is_array($categories)) {
				$categories = implode(',', $categories);
			}
			// grid optioons
			$grid_options = '{"categories": "' . $categories . '", "title_visibility": "' . $title_visibility . '", "title_position": "' . $title_position . '", "title_font": "' . $title_font . '", "category_font": "' . $category_font . '"}';
			// load more button
			$load_more = '<div class="load-more-wrapper"><a class="semplice-load-more semplice-event" data-event-type="helper" data-event="lazyLoad" data-type="portfolio-grid" data-load="' . $lazy_load['per_load'] . '" data-offset="' . $lazy_load['start_offset'] . '" data-content-id="' . $id . '" data-grid-options=\'' . $grid_options . '\'><img src="' . $lazy_load['button'] . '" alt="load-more-button"></a></div>';
		}
	}

	// open masonry
	$masonry_html = '
		<div id="masonry-' . $id . '" class="masonry" data-masonry-init="' . $script_execution . '">
			<div class="masonry-item-width"></div>
	';

	// js tags
	$js_open = '<script type="text/javascript">(function ($) { $(document).ready(function () {';
	$js_close = '});})(jQuery);</script>';

	// instagram sizes
	$instagram_sizes = '';
	if($module == 'instagram') {
		$instagram_sizes = '
			// is instagram?
			if($image.hasClass("semplice-instagram")) {
				var sizes = { width: $image[0].naturalWidth, height: $image[0].naturalHeight };
				$image.attr({ width: sizes.width, height: sizes.height });
				// has video?
				if($item.find("video").length > 0) {
					$item.find("video").attr({ width: sizes.width, height: sizes.height });
					// init video
					$item.find("video").mediaelementplayer({
						pauseOtherPlayers: false,
						stretching: "responsive"
					});
				}
			}
		';
	}

	// masonry javascript
	$masonry_js = $js_open . '
		// define container
		var $container = $(".active-content").find("#masonry-' . $id . '");

		// make jquery object out of items
		var $items = $(".active-content").find(".masonry-' . $id . '-item");

		// fire masmonry
		$container.masonry({
			itemSelector: ".masonry-' . $id . '-item",
			columnWidth: ".masonry-item-width",
			transitionDuration: 0,
			isResizable: true,
			percentPosition: true,
		});

		// show images
		showImages($container, $items);

		// load images and reveal if loaded
		function showImages($container, $items) {
			// get masonry
			var msnry = $container.data("masonry");
			// get item selector
			var itemSelector = msnry.options.itemSelector;
			// append items to masonry container
			//$container.append($items);
			$items.imagesLoaded().progress(function(imgLoad, image) {
				// get item
				var $image = $(image.img);
				var $item = $(image.img).parents(itemSelector);
				' . $instagram_sizes . '
				// layout
				msnry.layout();
				// fade in
				gsap.to($item, 1.1, {
					opacity: 1,
					y: 0,
					ease: "Expo.easeOut",
				});
			});
		}

		// remove min height after images are loaded in delayed mode
		$items.imagesLoaded().done(function(imgLoad) {
			if($container.attr("data-masonry-init") == "delayed") {
				$container.attr("data-masonry-init", "loaded");
				// sync scroll reveal if defined
				if(typeof sr != "undefined") {
					sr.sync();
				}
			}
		});
	' . $js_close;

	// script execution
	if($script_execution == 'delayed') {
		// close masonry container first
		$masonry_html .= '</div>';
		// content
		$masonry_content = $masonry_items . $masonry_js;
		// add grid to stack
		$masonry_js = '
			<script type="text/javascript">
				s4.sempliceExecuteStack["' . $id . '"] = {
					"type": "masonry",
					"id": "' . $id . '",
					"html": ' . json_encode($masonry_content) . ',
				};
			</script>
		';
	} else {
		// since not delayed, add items and js to html
		$masonry_html .= $masonry_items . '</div>';
	}

	// add load more
	$masonry_html .= $load_more;

	// add javascript
	$masonry_html .= $masonry_js;

	// output
	return $masonry_html;
}

// -----------------------------------------
// get masonry css
// -----------------------------------------

function semplice_masonry_mobile_css($id, $options, $img_per_row, $is_editor, $hor_gutter, $ver_gutter, $is_portfoliogrid) {
	// output
	$mobile_css = '';

	// defaults images per row
	$col_width = array(
		'xl' => $img_per_row,
		'lg' => $img_per_row,
		'md' => $img_per_row,
		'sm' => 6,
		'xs' => 12
	);

	// get breakpoints
	$breakpoints = semplice_get_breakpoints($is_editor);

	// iterate breakpoints
	foreach ($breakpoints as $breakpoint => $width) {
		// open css
		$css = array(
			'margin'  => '',
			'padding' => '',
			'width'	  => '',
		);
		if(isset($options['hor_gutter_' . $breakpoint]) || isset($options['ver_gutter_' . $breakpoint])) {
			// open padding
			$css['padding'] = '.masonry-'. $id .'-item {';
			// hor gutter
			if(isset($options['hor_gutter_' . $breakpoint])) {
				$css['margin'] .= '#masonry-'. $id .'{ margin: auto -' . ($options['hor_gutter_' . $breakpoint] / 2) . 'px !important; }';
				$css['padding'] .= 'padding-left: ' . ($options['hor_gutter_' . $breakpoint] / 2) . 'px; padding-right: ' . ($options['hor_gutter_' . $breakpoint] / 2) . 'px;';

			}
			// ver gutter
			if(isset($options['ver_gutter_' . $breakpoint])) {
				$css['padding'] .= 'padding-bottom:  ' . $options['ver_gutter_' . $breakpoint] . 'px;';
			}
			// close css
			$css['padding'] .= '}';
		}
		// colum width (images per row)
		if(false === $is_portfoliogrid) {
			if(!isset($options['random']) || $options['random'] == 'disabled') {
				if(isset($options['col_' . $breakpoint])) {
					$css['width'] .= '.masonry-'. $id .'-item { width: calc(100% / 12 * ' . $options['col_' . $breakpoint] . ') !important; max-width: calc(100% / 12 * ' . $options['col_' . $breakpoint] . ') !important; }';
				}
			}
		}
		// add to mobile css
		if(true === $is_editor) {
			// iterate atts and add to mobile css
			$atts = array('margin', 'padding', 'width');
			foreach ($atts as $attribute) {
				if(!empty($css[$attribute])) {
					$mobile_css .= '[data-breakpoint="' . $breakpoint . '"] ' . $css[$attribute];
				}
			}			
		} else {
			$mobile_css .= '@media screen' . $width['min'] . $width['max'] . ' {' . $css['margin'] . $css['padding'] . $css['width'] . '}';
		}
	}
	// masonry css
	$masonry_css = '
			#masonry-'. $id .'{ margin: auto -' . ($hor_gutter / 2) . 'px !important; } 
			.masonry-'. $id .'-item { margin: 0px; padding-left: ' . ($hor_gutter / 2) . 'px; padding-right: ' . ($hor_gutter / 2) . 'px; padding-bottom: ' . $ver_gutter . 'px; }
			' . $mobile_css . '
	';
	// return css
	return str_replace(array("\r","\n", "\t"),"",$masonry_css);
}

// -----------------------------------------
// project nav grid html
// -----------------------------------------

function semplice_project_nav_html($mode, $is_frontend, $post_id) {

	// vars
	$output = '';

	// get project panel
	$projectnav = json_decode(get_option('semplice_customize_projectpanel'), true);

	// attributes
	extract(shortcode_atts(
		array(
			'visibility'				=> 'visible',
			'images_per_row'			=> 2,
			'width'						=> 'container',
			'title_visibility'			=> 'visible',
			'meta_visibility'			=> 'both',
			'panel_title_font'			=> 'regular',
			'title_font'				=> 'regular',
			'category_font'				=> 'regular',
			'panel_label'				=> 'Selected Works',
			'gutter'					=> 'yes',
			'hide_active_project'		=> 'no',
			'np_visibility'				=> 'visible',
			'np_text_visibility'		=> 'visible',
			'np_image_visibility'		=> 'hidden',
			'np_font'					=> 'regular',
			'np_font_sub'				=> 'regular',
			'np_width'					=> 'container',
			'np_gutter'					=> 'yes',
			'np_justify'				=> 'edge',
			'np_alignment'				=> 'middle',
			'np_sep_visibility'			=> 'hidden',
			'np_label'					=> 'nextprev_above_title',
			'np_prefix'					=> 'visible',
			'np_text_position'			=> 'overlay',
			'np_image_scale'			=> 'cover',
			'np_next_only'				=> 'disabled',
			'np_mouseover_effect'		=> 'none',
			'np_mouseover_title_fade'	=> 'none',
		), $projectnav)
	);

	// get portfolio order
	$portfolio_order = json_decode(get_option('semplice_portfolio_order'));

	// get projects
	$projects = semplice_get_projects($portfolio_order, false, -1, false, true);

	// columns per row
	$columns_per_row = array('lg' => 2, 'md' => 3, 'sm' => 4, 'xs' => 6);
	foreach ($columns_per_row as $bp => $value) {
		if(isset($projectnav['images_per_row_' . $bp])) {
			$columns_per_row[$bp] = $projectnav['images_per_row_' . $bp];
		}
	}

	// items
	$output = '';

	// are there any published projects
	if($mode == 'projectpanel') {
		if(!empty($projects)) {
			foreach ($projects as $key => $project) {	

				//show project
				$show_project = true;
				if($hide_active_project == 'yes' && $project['post_id'] == $post_id) {
					$show_project = false;
				}

				// masonry items open
				if(true === $show_project) {
					$output .= '
						<div class="pp-thumb column" data-xl-width="' . $images_per_row . '" data-lg-width="' . $columns_per_row['lg'] . '" data-md-width="' . $columns_per_row['md'] . '" data-sm-width="' . $columns_per_row['sm'] . '" data-xs-width="' . $columns_per_row['xs'] . '">
							<a href="' . $project['permalink'] . '" title="' . $project['post_title'] . '"><img src="' . $project['pp_thumbnail']['src'] . '" width="' . $project['pp_thumbnail']['width'] . '" height="' . $project['pp_thumbnail']['height'] . '"></a>
							<p class="pp-title"><a data-font="' . $title_font . '" href="' . $project['permalink'] . '" title="' . $project['post_title'] . '">' . $project['post_title'] . '</a><span data-font="' . $category_font . '">' . $project['project_type'] . '</span></p>
						</div>
					';
				}
			}
		} else {
			$output = '<div class="empty-portfolio"><img src="' . get_template_directory_uri() . '/assets/images/admin/noposts.svg" alt="no-posts"><h3>Looks like you have an empty Portfolio. Please note that only<br />published projects are visible in the project panel.</h3></div>';
		}
		// is visible? if not return nothing
		if($visibility != 'hidden' && true === $is_frontend && get_post_type($post_id) == 'project' || false === $is_frontend) {
			// html
			return '
				<section class="project-panel" data-pp-gutter="' . $gutter . '" data-pn-layout="' . $width . '" data-pp-visibility="' . $visibility . '">
					<div class="container" data-title-visibility="' . $title_visibility . '" data-meta-visibility="' . $meta_visibility . '">
						<div class="row">
							<div class="column" data-xl-width="12">
								<p class="panel-label"><span data-font="' . $panel_title_font . '">' . $panel_label . '</span></p>
							</div>
						</div>
						<div class="row pp-thumbs">
							' . $output . '
						</div>
					</div>
				</section>
			';
		} else {
			return '';
		}
	} else {
		// vars
		$np_classes = '';
		$pos = 0;
		$next = 0;
		$prev = 0;
		$prev_label = 'Prev';
		$next_label = 'Next';
		$prev_type = 'Project Type';
		$next_type = 'Project Type';
		$prev_image_src = get_template_directory_uri() . '/assets/images/admin/prev.svg';
		$next_image_src = get_template_directory_uri() . '/assets/images/admin/next.svg';
		// is not editor?
		if(true === $is_frontend) {
			// check if there are projects
			if(!empty($projects) && count($projects) >= 3) {
				// is this project published yet?
				if('publish' == get_post_status($post_id)) {
					// get published posts
					$published_posts = array();
					foreach ($projects as $key => $project) {
						$published_posts[] = $project['post_id'];
					}
					// if this post is not in published posts add it to published posts no matter its project nav visibility if no
					if(!in_array($post_id, $published_posts)) {
						$published_posts[] = $post_id;
					}
					// get pos
					$pos = array_search($post_id, $published_posts);
					// is first?
					if($pos == 0) {
						end($published_posts);
						$prev = $published_posts[key($published_posts)];
					} else {
						$prev = $published_posts[$pos - 1];
					}
					// is last?
					if(!isset($published_posts[$pos + 1])) {
						$next = $published_posts[0];
					} else {
						$next = $published_posts[$pos + 1];
					}
					// get labels
					if(strpos($np_label, 'title') !== false) {
						$prev_label = get_the_title($prev);
						$next_label = get_the_title($next);
					}
					// next / prev pos
					$prev_pos = array_search($prev, $published_posts);
					$next_pos = array_search($next, $published_posts);
					// get images
					if($np_image_visibility == 'visible') {
						// prev image
						if(is_array($projects[$prev_pos]['nextprev_thumbnail'])) {
							$prev_image_src = $projects[$prev_pos]['nextprev_thumbnail']['src'];
						}
						// next image
						if(is_array($projects[$next_pos]['nextprev_thumbnail'])) {
							$next_image_src = $projects[$next_pos]['nextprev_thumbnail']['src'];
						}
					}
					// get project type
					$prev_type = $projects[$prev_pos]['project_type'];
					$next_type = $projects[$next_pos]['project_type'];
				} else {
					$np_classes .= ' nextprev-error';
				}
			} else {
				$np_classes .= ' nextprev-error';
			}
		} else {
			// change labels for admin
			if(strpos($np_label, 'title') !== false) {
				$prev_label = 'My previous project';
				$next_label = 'My next project';
			}
		}
		// wrap images
		$background_prev = '';
		$background_next = '';
		if($np_image_visibility == 'visible' || false === $is_frontend) {
			$background_prev = ' style="background-image: url(' . $prev_image_src . ');"';
			$background_next = ' style="background-image: url(' . $next_image_src . ');"';
		}
		// output
		if(false === $is_frontend || true === $is_frontend && $np_visibility == 'visible' && get_post_type($post_id) == 'project') {
			$output = '
				<section class="semplice-next-prev"  data-np-visibility="' . $np_visibility . '" data-np-gutter="' . $np_gutter . '" data-pn-layout="' . $np_width . '" data-np-sep-visibility="' . $np_sep_visibility . '" data-np-prefix-visibility="' . $np_prefix . '" data-np-image-visibility="' . $np_image_visibility . '" data-np-text-visibility="' . $np_text_visibility . '" data-np-text-position="' . $np_text_position . '" data-np-mouseover="' . $np_mouseover_effect . '">
					<div class="container">
						<div class="row">
							<div class="column" data-xl-width="12">
								<div class="np-inner' . $np_classes . '" data-np-justify="' . $np_justify . '" data-np-alignment="' . $np_alignment . '" data-np-image-scale="' . $np_image_scale . '" data-np-next-only="' . $np_next_only . '">
									<a class="semplice-prev np-link" href="' . get_permalink($prev) . '">
										<div class="np-bg"' . $background_prev . '></div>
										' . semplice_get_project_nav_label('prev', $np_label, $prev_label, $prev_type, $np_mouseover_title_fade, $np_font, $np_font_sub) . '
									</a>
									<a class="semplice-next np-link" href="' . get_permalink($next) . '">
										<div class="np-bg"' . $background_next . '></div>
										' . semplice_get_project_nav_label('next', $np_label, $next_label, $next_type, $np_mouseover_title_fade, $np_font, $np_font_sub) . '
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="nextprev-seperator"></div>
				</section>
			';
		}
		// return
		return $output;
	}
}

function semplice_get_project_nav_label($state, $label, $title, $type, $fade, $font, $font_sub) {
	// default content
	$defaults = array(
		'prev' => array(
			'label' 	=> 'Prev',
			'prefix' 	=> '<span>&lsaquo;</span>',
		),
		'next' => array(
			'label' 	=> 'Next',
			'prefix' 	=> '<span>&rsaquo;</span>',
		),
	);
	// labels
	switch ($label) {
		case 'arrows':
			$defaults[$state]['label'] = '';
		break;
		case 'nextprev':
			$defaults[$state]['prefix'] = '';
		break;
		case 'title':
			$defaults[$state]['prefix'] = '';
			$defaults[$state]['label'] = $title;
		break;
		case 'arrows_title':
			$defaults[$state]['label'] = $title;
		break;
		case 'type_above_title':
			$defaults[$state]['label'] = $type;
		break;
	}
	// return
	if(strpos($label, 'above') !== false) {
		return '
			<div class="np-text">
				<div class="np-text-inner np-above ' . $fade . '">
					<div class="np-text-above">
						<span class="np-label-above" data-font="' . $font_sub . '">' . $defaults[$state]['label'] . '</span>
					</div>
					<div class="np-text-main">
						<span class="np-label" data-font="' . $font . '">' . $title . '</span>
					</div>
				</div>
			</div>
		';
	} else {
		return '
			<div class="np-text">
				<div class="np-text-inner ' . $fade . '">
					<span class="np-prefix" data-font="' . $font . '">' . $defaults[$state]['prefix'] . '</span>
					<span class="np-label" data-font="' . $font . '">' . $defaults[$state]['label'] . '</span>
				</div>
			</div>
		';
	}
}

// -----------------------------------------
// project nav grid css
// -----------------------------------------

function semplice_project_nav_css($is_frontend) {

	// mobile detect
	global $detect;

	// get project nav options
	$projectnav = json_decode(get_option('semplice_customize_projectpanel'), true);

	// attributes
	extract(shortcode_atts(
		array(
			'background'					=> '#f5f5f5',
			'panel_padding'					=> '2.5rem',
			'panel_title_color'				=> '#000000',
			'panel_title_fontsize'			=> '1.777777777777778rem',
			'panel_title_text_transform'	=> 'none',
			'panel_padding_left'			=> '0rem',
			'panel_padding_bottom'			=> '1.666666666666667rem',
			'panel_text_align'				=> 'left',
			'title_padding_bottom'			=> '1.666666666666667rem',
			'title_color'					=> '#000000',
			'title_fontsize'				=> '0.7222222222222222rem',
			'title_text_transform'			=> 'none',
			'title_padding_top'				=> '0.5555555555555556rem',
			'category_color'				=> '#999999',
			'category_fontsize'				=> '0.7222222222222222rem',
			'category_text_transform'		=> 'none',
			'np_background'					=> '#ffffff',
			'np_height'						=> '10rem',
			'np_padding_ver'				=> '0rem',
			'np_padding_hor'				=> '0rem',
			'np_color'						=> '#000000',
			'np_fontsize'					=> '1.555555555555556rem',
			'np_text_transform'				=> 'none',
			'np_letter_spacing'				=> '0rem',
			'np_color_sub'					=> '#aaaaaa',
			'np_fontsize_sub'				=> '0.7777777777777778rem',
			'np_text_transform_sub'			=> 'uppercase',
			'np_letter_spacing_sub'			=> '1px',
			'np_spacing_sub'				=> '2px',
			'np_sep_width'					=> 1,
			'np_sep_spacing'				=> '1.666666666666667rem',
			'np_sep_background'				=> '#000000',
			'np_padding_outer_top'			=> '0rem',
			'np_padding_outer_bottom'		=> '0rem',
			'np_mouseover_effect'			=> 'none',
			'np_mouseover_background'		=> '#ffffff',
			'np_mouseover_color'			=> '#000000',
			'np_mouseover_color_sub'		=> '#000000',
			'np_mouseover_so_opacity'		=> .4,
			'np_mouseover_so_scale'			=> 7,
			'np_mouseover_dimdown_opacity' 	=> .4,
		), $projectnav)
	);

	// if letter spacing add negative margin
	$negative_margin = '';
	if(strpos($np_letter_spacing, '-') === false) {
		$negative_margin .= 'margin-right: -' . $np_letter_spacing . ';'; 
	} else {
		$negative_margin .= 'margin-right: ' . str_replace('-', '', $np_letter_spacing) . ';'; 
	}

	// seperator positiong
	$sep_pos = 0;
	if($np_sep_width > 1) {
		$sep_pos = round($np_sep_width / 2);
	}

	// css
	$css = '
		.project-panel {
			background: ' . $background . ';
			padding: ' . $panel_padding . ' 0rem;
		}
		[data-pp-gutter="no"] .project-panel .pp-thumbs,
		.project-panel .pp-thumbs {
			margin-bottom: -' . $title_padding_bottom . ';
		}
		#content-holder .panel-label, .projectnav-preview .panel-label {
			color: ' . $panel_title_color . ';
			font-size: ' . $panel_title_fontsize . ';
			text-transform: ' . $panel_title_text_transform . ';
			padding-left: ' . $panel_padding_left . ';
			padding-bottom: ' . $panel_padding_bottom . ';
			text-align: ' . $panel_text_align . ';
			line-height: 1;
		}
		.project-panel .pp-title {
			padding: ' . $title_padding_top . ' 0rem ' . $title_padding_bottom . ' 0rem;
		}
		.project-panel .pp-title a {
			color: ' . $title_color . '; 
			font-size: ' . $title_fontsize . '; 
			text-transform: ' . $title_text_transform . ';
		} 
		.project-panel .pp-title span {
			color: ' . $category_color . ';
			font-size: ' . $category_fontsize . ';
			text-transform: ' . $category_text_transform . ';
		}
		.semplice-next-prev {
			background: ' . $np_background . ';
			padding: ' . $np_padding_outer_top . ' 0rem ' . $np_padding_outer_bottom . ' 0rem;
		}
		.semplice-next-prev .np-inner {
			height: ' . $np_height . ';
		}
		.semplice-next-prev .np-inner .np-link .np-prefix,
		.semplice-next-prev .np-inner .np-link .np-label {
			color: ' . $np_color . ';
			font-size: ' . $np_fontsize . ';
			text-transform: ' . $np_text_transform . ';
			letter-spacing: ' . $np_letter_spacing . ';
		}
		.semplice-next-prev .np-inner .np-link .np-text-above {
			padding-bottom: ' . $np_spacing_sub . ';
		}
		.semplice-next-prev .np-inner .np-link .np-label-above {
			color: ' . $np_color_sub . ';
			font-size: ' . $np_fontsize_sub . ';
			text-transform: ' . $np_text_transform_sub . ';
			letter-spacing: ' . $np_letter_spacing_sub . ';
		}
		.semplice-next-prev .np-inner .np-link .np-text {
			padding: ' . $np_padding_ver . ' ' . $np_padding_hor . ';
		}
		.semplice-next .np-text {
			' . $negative_margin . '
		}
		.semplice-next-prev .nextprev-seperator {
			width: ' . $np_sep_width . 'px;
			margin: ' . $np_sep_spacing . ' -' . $sep_pos . 'px;
			background: ' . $np_sep_background . ';
		}
	';

	// mobile atts
	$mobile_atts = array(
		'panel_padding' => array('attribute' => 'padding', 'target' => '.project-panel'),
		'title_padding_bottom' => array('attribute' => 'margin-bottom', 'target' => '.pp-thumbs'),
		'panel_title_fontsize' => array('attribute' => 'font-size', 'target' => '#content-holder .panel-label, .projectnav-preview .panel-label'),
		'panel_padding_left ' => array('attribute' => 'padding-left', 'target' => '#content-holder .panel-label, .projectnav-preview .panel-label'),
		'panel_padding_bottom ' => array('attribute' => 'padding-bottom', 'target' => '#content-holder .panel-label, .projectnav-preview .panel-label'),
	);	

	// get breakpoints
	$breakpoints = semplice_get_breakpoints();
	
	// iterate breakpoints
	foreach ($breakpoints as $breakpoint => $width) {
		// breakpoint css
		$breakpoint_css = '';
		$sep_pos_changed = false;
		if(isset($projectnav['panel_padding_' . $breakpoint])) {
			$breakpoint_css .= '.project-panel { padding: ' . $projectnav['panel_padding_' . $breakpoint] . ' 0rem; }';
		}
		if(isset($projectnav['title_padding_bottom_' . $breakpoint])) {
			$breakpoint_css .= '.pp-thumbs { margin-bottom: -' . $projectnav['title_padding_bottom_' . $breakpoint] . '; }';
			$breakpoint_css .= '.project-panel .pp-title { padding-bottom: ' . $projectnav['title_padding_bottom_' . $breakpoint] . '; }';
		}
		if(isset($projectnav['title_padding_top_' . $breakpoint])) {
			$breakpoint_css .= '.project-panel .pp-title { padding-top: ' . $projectnav['title_padding_top_' . $breakpoint] . '; }';
		}
		if(isset($projectnav['panel_title_fontsize_' . $breakpoint])) {
			$breakpoint_css .= '#content-holder .panel-label, .projectnav-preview .panel-label { font-size: ' . $projectnav['panel_title_fontsize_' . $breakpoint] . '; }';
		}
		if(isset($projectnav['panel_padding_left_' . $breakpoint])) {
			$breakpoint_css .= '#content-holder .panel-label, .projectnav-preview .panel-label { padding-left: ' . $projectnav['panel_padding_left_' . $breakpoint] . '; }';
		}
		if(isset($projectnav['panel_padding_bottom_' . $breakpoint])) {
			$breakpoint_css .= '#content-holder .panel-label, .projectnav-preview .panel-label { padding-bottom: ' . $projectnav['panel_padding_bottom_' . $breakpoint] . '; }';
		}
		if(isset($projectnav['title_fontsize_' . $breakpoint])) {
			$breakpoint_css .= '.project-panel .pp-title a { font-size: ' . $projectnav['title_fontsize_' . $breakpoint] . '; }';
		}
		if(isset($projectnav['category_fontsize_' . $breakpoint])) {
			$breakpoint_css .= '.project-panel .pp-title span { font-size: ' . $projectnav['category_fontsize_' . $breakpoint] . '; }';
		}
		if(isset($projectnav['np_padding_outer_top_' . $breakpoint])) {
			$breakpoint_css .= '.semplice-next-prev { padding-top: ' . $projectnav['np_padding_outer_top_' . $breakpoint] . '; }';
		}
		if(isset($projectnav['np_padding_outer_bottom_' . $breakpoint])) {
			$breakpoint_css .= '.semplice-next-prev { padding-bottom: ' . $projectnav['np_padding_outer_bottom_' . $breakpoint] . '; }';
		}
		if(isset($projectnav['np_height_' . $breakpoint])) {
			$breakpoint_css .= '.semplice-next-prev .np-inner { height: ' . $projectnav['np_height_' . $breakpoint] . '; }';
		}
		if(isset($projectnav['np_fontsize_' . $breakpoint])) {
			$breakpoint_css .= '.semplice-next-prev .np-inner .np-link .np-prefix, .semplice-next-prev .np-inner .np-link .np-label { font-size: ' . $projectnav['np_fontsize_' . $breakpoint] . '; }';
		}
		if(isset($projectnav['np_letter_spacing_' . $breakpoint])) {
			$breakpoint_css .= '.semplice-next-prev .np-inner .np-link .np-prefix, .semplice-next-prev .np-inner .np-link .np-label { letter-spacing: ' . $projectnav['np_letter_spacing_' . $breakpoint] . '; }';
		}
		if(isset($projectnav['np_spacing_sub_' . $breakpoint])) {
			$breakpoint_css .= '.semplice-next-prev .np-inner .np-link .np-text-above { padding-bottom: ' . $projectnav['np_spacing_sub_' . $breakpoint] . '; }';
		}
		if(isset($projectnav['np_fontsize_sub_' . $breakpoint])) {
			$breakpoint_css .= '.semplice-next-prev .np-inner .np-link .np-label-above { font-size: ' . $projectnav['np_fontsize_sub_' . $breakpoint] . '; }';
		}
		if(isset($projectnav['np_letter_spacing_sub_' . $breakpoint])) {
			$breakpoint_css .= '.semplice-next-prev .np-inner .np-link .np-label-above { letter-spacing: ' . $projectnav['np_letter_spacing_sub_' . $breakpoint] . '; }';
		}
		if(isset($projectnav['np_padding_ver_' . $breakpoint]) || isset($projectnav['np_padding_hor_' . $breakpoint])) {
			$nppv = isset($projectnav['np_padding_ver_' . $breakpoint]) ? $projectnav['np_padding_ver_' . $breakpoint] : $np_padding_ver;
			$npph = isset($projectnav['np_padding_hor_' . $breakpoint]) ? $projectnav['np_padding_hor_' . $breakpoint] : $np_padding_hor;
			$breakpoint_css .= '.semplice-next-prev .np-inner .np-link .np-text { padding: ' . $nppv . ' ' . $npph . '; }';
		}
		if(isset($projectnav['np_sep_width_' . $breakpoint])) {
			if($projectnav['np_sep_width_' . $breakpoint] > 1) {
				$sep_pos = round($projectnav['np_sep_width_' . $breakpoint] / 2);
				$sep_pos_changed = true;
			}
			$breakpoint_css .= '.semplice-next-prev .nextprev-seperator { width: ' . $projectnav['np_sep_width_' . $breakpoint] . 'px; }';
		}
		if(isset($projectnav['np_sep_spacing_' . $breakpoint]) || true === $sep_pos_changed) {
			$npsp = isset($projectnav['np_sep_spacing_' . $breakpoint]) ? $projectnav['np_sep_spacing_' . $breakpoint] : $np_sep_spacing;
			$breakpoint_css .= '.semplice-next-prev .nextprev-seperator { margin: ' . $npsp . ' -' . $sep_pos . 'px; }';
		}
		// only add breakpoint if css is not empty
		if(!empty($breakpoint_css)) {
			// breakpoint open
			$css .= '@media screen' . $width['min'] . $width['max'] . ' { ' . $breakpoint_css . ' }';
		}
	}

	// mouseover
	if(true === $is_frontend) {
		// basic mouseover
		$css .= '
			.np-link:hover {
				background: ' . $np_mouseover_background . ';
			}
			.np-link:hover .np-text .np-label,
			.np-link:hover .np-text .np-prefix {
				color: ' . $np_mouseover_color . ' !important;
			}
			.np-link:hover .np-label-above {
				color: ' . $np_mouseover_color_sub . ' !important;
			}
		';
		// scale or dimdown
		if(false === $detect->isMobile()) {
			switch($np_mouseover_effect) {
				case 'scale-opacity':
					$css .= '
						.np-inner:hover .np-link { opacity: ' . $np_mouseover_so_opacity . '; }
						.np-inner .np-link:hover .np-bg { transform: scale(' . (($np_mouseover_so_scale / 100) + 1) . '); }
					';
				break;
				case 'dim-down':
					$css .= '
						.np-link:hover .np-bg { opacity: ' . $np_mouseover_dimdown_opacity . '; }
					';
				break;
			}
		}
	}

	// return
	return $css;
}
?>