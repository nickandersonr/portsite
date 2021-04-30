<?php

// -----------------------------------------
// get posts
// -----------------------------------------

function semplice_get_posts($request) {
	// output
	$output = array('html' => '', 'empty_state' => '');

	// sortby
	$sortby = semplice_get_sortby();
	$date_column_head = array('date' => 'Created', 'modified' => 'Modified');

	// get projects view
	$projects_view = semplice_get_projects_view();

	// get post count
	$post_count = wp_count_posts($request['post_type']);
	$count = 0;

	// pubslihed posts
	if(isset($post_count->publish))
		$count = $count + $post_count->publish;

	// drafts
	if(isset($post_count->draft))
		$count = $count + $post_count->draft;

	// pending posts
	if(isset($post_count->pending))
		$count = $count + $post_count->pending;

	// private posts
	if(isset($post_count->private))
		$count = $count + $post_count->private;

	// posts per page
	$posts_per_page = 20;

	// pagination
	if($request['page'] != 'show-all') {
		$page_num = intval($request['page']);
	} else {
		$page_num = 1;
		$posts_per_page = -1;
	}
	if($page_num == 0) {
		$page_num = 1;
	}

	// pinned
	$pinned_posts = false;
	$exclude = '';
	if($page_num == 1) {
		if($request['post_type'] == 'page') {
			$pinned = semplice_get_pinned();
			if(false !== $pinned && !empty($pinned)) {
				$home = get_option('page_on_front');
				// has home?
				$pos = array_search($home, $pinned);
				if(false !== $pos) {
					// unset home and add home id as first id
					unset($pinned[$pos]);
					array_unshift($pinned, $home);
				}
				// pinned args
				$pinned_posts_args = array(
					'posts_per_page' => -1,
					'post_type' 	 => 'page',
					'orderby'		 => 'post__in',
					'post__in'		 => $pinned,
				);
				// excludes
				$exclude = $pinned; 
				// get posts
				$pinned_posts = wp_get_recent_posts($pinned_posts_args);
			}
		}
	}

	// ignore pagination for footers
	if($request['post_type'] == 'footer') {
		$posts_per_page = -1;
	}

	// get pagination
	$pagination = ceil($count / $posts_per_page);
	$pagination_html = '';

	// is page num allowed?
	if($page_num >= $pagination && $request['page'] != 'show-all') {
		$page_num = $pagination;
	}

	if(is_numeric($pagination) && $pagination > 1) {

		// vars
		$active_prev = '';
		$active_next = '';

		// make prev inactive
		if($page_num == 1) {
			$active_prev = 'inactive';
		}

		//make next inactive
		if($page_num == $pagination) {
			$active_next = 'inactive';
		}

		//pagination html
		$pagination_html .= '
			<div class="semplice-pagination">
				<ul>
					<li>
					<a class="show-all" href="#content/pages/show-all">Show all</a>
					</li>
					<li>
						<a href="#content/pages/' . ($page_num-1) . '" id="nav-pages" class="' . $active_prev . ' prev">' . get_svg('backend', '/icons/pages_prev') . '</a>
					</li>
					<li>
						<span>' . $page_num . ' / ' . $pagination . '</span>
					</li>
					<li>
						<a href="#content/pages/' . ($page_num+1) . '" id="nav-pages" class="' . $active_next . ' next">' . get_svg('backend', '/icons/pages_next') . '</a>
					</li>
				</ul>
			</div>
		';
	}
	// search sort html
	$sort_search = '
		<div class="semplice-sort-search">
			<div class="semplice-page-search">
				<input type="text" placeholder="Search for title" class="search-semplice-pages" name="search-semplice-pages">
			</div>
			<div class="semplice-projects-view">
				<div class="select-box">
					<div class="sb-arrow"></div>
					<select name="type" data-input-type="select-box" class="admin-listen-handler" data-handler="projectsView">
						' . semplice_get_dropdown(array('thumb' => 'Thumb View', 'list' => 'List View'), $projects_view) . '
					</select>
				</div>
			</div>
			<div class="semplice-sortby">
				<div class="semplice-page-sort-label">
					Sort by
				</div>
				<div class="select-box">
					<div class="sb-arrow"></div>
					<select name="type" data-input-type="select-box" class="admin-listen-handler" data-handler="sortBy">
						' . semplice_get_dropdown(array('date' => 'Last Created', 'modified' => 'Last Modified'), $sortby) . '
					</select>
				</div>
			</div>
		</div>
	';

	// active page num
	$output['page_num'] = $page_num;

	// check if auth
	$args = array(
		'posts_per_page' => $posts_per_page,
		'offset'		 => ($page_num - 1) * $posts_per_page,
		'post_type' 	 => $request['post_type'],
		'orderby'		 => $sortby,
		'exclude'		 => $exclude
	);

	// on project pages, show all per default
	if($request['post_type'] == 'project') {
		// posts per page for dashboard
		$args['posts_per_page'] = -1;
		// categories?
		if(isset($request['project_categories'])) {
			$args['categories'] = $request['project_categories'];
		}
		// get portfolio order
		$output['portfolio_order'] = json_decode(get_option('semplice_portfolio_order'));
		// empty pagination
		$pagination_html = '';
	}

	// get posts or search for posts
	if(isset($request['search_term']) && !empty($request['search_term'])) {
		$posts = semplice_search_posts_by_title($request['search_term'], 'post_' . $sortby, $request['post_type']);
	} else {
		$posts = wp_get_recent_posts($args);
	}

	// posts top row
	$posts_top_row = '';
	if($request['post_type'] != 'project' || $projects_view == 'list') {
		$posts_top_row = '
			<div class="posts-list posts-view-' . $projects_view . '">
				<div class="posts-top-row admin-row">
					<div class="admin-column" data-xl-width="5"><span class="post-title">Title</span></div>
					<div class="admin-column" data-xl-width="2">Status</div>
					<div class="admin-column" data-xl-width="2">' . $date_column_head[$sortby] . '</div>
				</div>
		';
	} else {
		$posts_top_row = '
			<div class="projects-list admin-row">
		';
	}

	if(!$posts && false === $pinned_posts) {
		$output['html'] .= 'nopost';
		// empty state
		$output['empty_state'] = '
			<div class="no-posts">
				<div class="inner">
					<h3>Only <span>procrastinators</span><br />can see this message.</h3>
					<a class="admin-click-handler semplice-button" data-handler="execute" data-action="addPost" data-action-type="main" data-post-type="' . $request['post_type'] . '">Start creating</a>
				</div>
			</div>
		';
	} else {
		// header
		$header = '
			<div class="admin-row posts-header">
				<div class="sub-header admin-column">
					<h2 class="admin-title">All ' . ucfirst($request['post_type']) . 's</h2>
					<a class="admin-click-handler semplice-button" data-handler="execute" data-action="addPost" data-action-type="main" data-post-type="' . $request['post_type'] . '">Add New ' . $request['post_type'] . '</a>
					' . semplice_save_spinner() . '
					' . $sort_search . '
				</div>
			</div>
			<div class="posts-loader">
				<svg class="semplice-spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
					<circle class="path" fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
				</svg>
			</div>
		';
		// hide header?
		if(isset($request['hide_row_header']) && true === $request['hide_row_header']) {
			$header = '';
		}
		// define post status
		$post_status = '';
		$posts_html = '';
		// get pinned
		if(is_array($pinned_posts)) {
			if(!isset($request['search_term']) || isset($request['search_term']) && empty($request['search_term'])) {
				$posts_html .= semplice_iterate_posts($pinned_posts, $request['post_type'], $projects_view);
			}
		}
		// get posts
		$posts_html .= semplice_iterate_posts($posts, $request['post_type'], $projects_view, false);
		// only posts (for sorting change) or complete page?
		if(isset($request['only_posts']) && true === semplice_boolval($request['only_posts'])) {
			$output['html'] .= $posts_top_row . $posts_html . '</div>' . $pagination_html;
		} else {
			$output['html'] .= '
				<div class="' . $request['post_type'] . 's posts admin-container">
					' . $header . '
					' . $posts_top_row . '
						' . $posts_html . '
					</div>
					' . $pagination_html . '
				</div>
			';
		}
	}
	return $output;
}

// -----------------------------------------
// iterate posts
// -----------------------------------------

function semplice_iterate_posts($posts, $post_type, $projects_view) {
	$posts_html = '';
	foreach ($posts as $key => $post) {
		// is semplice?
		$is_semplice = get_post_meta($post['ID'], '_is_semplice', true);

		// get thumbnail
		if($post_type == 'project') {
			$thumbnail = semplice_get_thumbnail($post['ID'], false);
		} else {
			$thumbnail = false;
		}

		// format post
		$posts_html .= semplice_post_row($post['ID'], $post_type, $post['post_title'], $post['post_status'], false, $thumbnail, $is_semplice, $post['post_name'], $projects_view);
	}
	return $posts_html;
}

// -----------------------------------------
// get dashboard projects
// -----------------------------------------

function semplice_dashboard_projects() {

	// output
	$output = '';

	// get latest 3 projects
	$args = array(
		'posts_per_page' => 4,
		'post_type' 	 => array('page', 'project'),
		'orderby'		 => 'modified'
	);

	// get posts
	$posts = wp_get_recent_posts($args);

	foreach ($posts as $key => $post) {

		// is semplice?
		$is_semplice = get_post_meta($post['ID'], '_is_semplice', true);

		// get thumbnail
		$thumbnail = semplice_get_thumbnail($post['ID'], false);

		// format post
		$output .= semplice_post_row($post['ID'], 'project', $post['post_title'], $post['post_status'], false, $thumbnail, $is_semplice, $post['post_name'], 'thumb');
	}

	// return
	return $output;
}

// -----------------------------------------
// get post row
// -----------------------------------------

function semplice_post_row($post_id, $post_type, $post_title, $post_status, $is_duplicate, $thumbnail, $is_semplice, $slug, $projects_view) {
	// output
	$output = '';
	$is_semplice_class = '';
	$activate_semplice = '';

	// get front page and blogpage
	if(get_option('page_on_front') == $post_id) {
		$front_or_posts = ' <span class="semibold">&mdash; Front Page</span>';
	} else if(get_option('page_for_posts') == $post_id) {
		$front_or_posts = ' <span class="semibold">&mdash; Blog Page</span>';
	} else {
		$front_or_posts = '';
	}

	if(isset($is_duplicate) && $is_duplicate === true) {
		$css = 'style="opacity: 0; transform: translateY(-30px) scale(.9);"';
	} else {
		$css = '';
	}

	// is pusblished?
	if($post_status == 'publish') {
		$post_status = 'published';
	}

	// check if post title is empty
	if(empty($post_title)) {
		$post_title = 'Untitled';
	} else {
		// post title
		$lenght = 40;
		if($post_type == 'project') {
			$lenght = 24;
		}
		$post_title = (strlen($post_title) > $lenght) ? substr($post_title, 0, $lenght) . '...' : $post_title;
	}

	// is semplice
	if(!$is_semplice) {
		$is_semplice_class = ' no-semplice';
		$activate_semplice = '<a class="edit-with-semplice semplice-button green-button admin-click-handler"  data-post-id="' . $post_id . '" data-handler="execute" data-action-type="popup" data-action="activateSemplice">Edit with Semplice</a>';
	}


	// is pinned
	$is_pinned_class = '';
	$pinned_mode = 'favorite';
	$pinned = semplice_get_pinned();
	if(is_array($pinned) && in_array($post_id, $pinned)) {
		$is_pinned_class = ' semplice-is-pinned';
		$pinned_mode = 'unfavorite';
	}

	// thumbnail
	$data_thumbnail = '';
	$bg_thumbnail = '';
	if(false !== $thumbnail && false === strpos($thumbnail['src'], 'no_thumbnail.png')) {
		$data_thumbnail = ' data-thumbnail-src="' . $thumbnail['src'] . '"';
		$bg_thumbnail = ' style="background-image: url(' . $thumbnail['src'] . ');"';
	} else {
		$bg_thumbnail = 'data-thumbnail="no-project-thumb"';
	}
	if($post_type == 'project' && $projects_view == 'thumb') {
		// get post type again to make sure to support pages in the dashboard
		$post_type = get_post_type($post_id);
		// add page icon if post type is page (dashboard)
		if($post_type == 'page') {
			$bg_thumbnail = 'data-thumbnail="no-page-thumb"';
		}
		// thumbnail html
		$thumbnail_html = '
			<div class="thumbnail"' . $bg_thumbnail . '>
				<div class="thumbnail-hover"></div>
				<div class="post-actions">
					<ul>
						<li>
							<a class="edit" href="#edit/' . $post_id . '">' . get_svg('backend', '/icons/post_edit') . '</a>
							<div class="tooltip tt-edit">Edit</div>
						</li>
						<li>
							<a class="page-settings admin-click-handler" data-handler="execute" data-action-type="postSettings" data-action="getPostSettings" data-post-id="' . $post_id . '"  data-ps-mode="posts" data-post-type="' . $post_type . '"' . $data_thumbnail . '>' . get_svg('backend', '/icons/post_settings') . '</a>
							<div class="tooltip tt-settings">Settings</div>
						</li>
						<li>
							<a class="duplicate admin-click-handler" data-handler="execute" data-action="duplicatePost" data-action-type="main" data-post-type="' . $post_type . '" data-duplicate-id="' . $post_id . '">' . get_svg('backend', '/icons/post_duplicate') . '</a>
							<div class="tooltip tt-duplicate">Duplicate</div>
						</li>
						<li>
							<a class="delete admin-click-handler" data-handler="execute" data-action="deletePost" data-action-type="popup" data-post-type="' . $post_type . '" data-delete-id="' . $post_id . '">' . get_svg('backend', '/icons/post_delete') . '</a>
							<div class="tooltip tt-delete">Delete</div>
						</li>
					</ul>
				</div>
			</div>
		';
		// add to thumb view output
		$output .= '
			<div class="project admin-column' . $is_semplice_class . '" data-xl-width="3" id="' . $post_id . '"' . $data_thumbnail . ' ' . $css . '>
				' . $activate_semplice . '
				<div class="column-inner">
					' . $thumbnail_html . '
					<div class="project-meta">
						<div class="post-status">' . semplice_post_status($post_id, $post_status) . '</div>
						<div class="post-title"><h2>' . $post_title . $front_or_posts . '</h2></div>
						' . semplice_preview_link($post_type, 'project', $post_id, $slug, true) . '
					</div>
				</div>
			</div>
		';
	} else {
		// date
		$sortby = semplice_get_sortby();
		if($sortby == 'modified') {
			$date = get_the_modified_date('d/m/Y', $post_id);
		} else {
			$date = get_the_date('d/m/Y', $post_id);
		}

		$output .= '
			<div class="' . $post_type . ' post admin-row' . $is_semplice_class . $is_pinned_class . '" id="' . $post_id . '" ' . $css . '>
				<div class="post-title admin-column" data-xl-width="5"><h2><a class="post-link" href="#edit/' . $post_id . '">' . $post_title . $front_or_posts . '</a></h2></div>
				<div class="post-status admin-column" data-xl-width="2">' . semplice_post_status($post_id, $post_status) . '</div>
				<div class="post-date admin-column" data-xl-width="2">' . $date . '</div>
				<div class="post-actions admin-column" data-xl-width="3">
					<ul>
						<li>
							<a class="page-settings admin-click-handler" data-handler="execute" data-action-type="postSettings" data-action="getPostSettings" data-post-id="' . $post_id . '"  data-ps-mode="posts" data-post-type="' . $post_type . '"' . $data_thumbnail . '>' . get_svg('backend', '/icons/post_settings') . '</a>
							<div class="tooltip tt-postsettings">Settings</div>
						</li>
						<li>
							<a class="duplicate admin-click-handler" data-handler="execute" data-action="duplicatePost" data-action-type="main" data-post-type="' . $post_type . '" data-duplicate-id="' . $post_id . '">' . get_svg('backend', '/icons/post_duplicate') . '</a>
							<div class="tooltip tt-duplicate">Duplicate</div>
						</li>
						<li>
							<a class="delete admin-click-handler" data-handler="execute" data-action="deletePost" data-action-type="popup" data-post-type="' . $post_type . '" data-delete-id="' . $post_id . '">' . get_svg('backend', '/icons/post_delete') . '</a>
							<div class="tooltip tt-delete">Delete</div>
						</li>
						<li>
							' . semplice_preview_link($post_type, 'page', $post_id, $slug, false) . '
							<div class="tooltip tt-preview">Preview</div>
						</li>
						<li>
							<a class="semplice-pin admin-click-handler" data-handler="execute" data-action="pinPost" data-action-type="helper" data-mode="' . $pinned_mode . '" data-post-id="' . $post_id . '">' . get_svg('backend', '/icons/post_pin') . '</a>
							<div class="tooltip tt-pinned">' . ucfirst($pinned_mode) . '</div>
						</li>
					</ul>
				</div>
				' . $activate_semplice . '
			</div>
		';
	}

	return $output;
}

// -----------------------------------------
// semplice preview link
// -----------------------------------------

function semplice_preview_link($type, $class, $id, $slug, $has_tooltip) {

	// tooltip
	$tooltip = '';
	if(true === $has_tooltip) {
		$tooltip = '<div class="tooltip">Preview</div>';
	}

	// project slug
	$project_slug = '';
	if($type == 'project') {
		$project_slug = semplice_get_project_slug() . '/';
	}

	// return preview link
	return '<a class="preview-' . $class . '" href="' . home_url() . '/' . $project_slug . $slug . '?preview_id=' . $id . '&preview=true" target="_blank">' . get_svg('backend', '/icons/preview') . $tooltip . '</a>';
}

// -----------------------------------------
// post status
// -----------------------------------------

function semplice_post_status($post_id, $status) {

	// get link
	if($status == 'published') {
		$link = '<a class="admin-click-handler published" data-post-id="' . $post_id . '" data-post-status="draft" data-handler="execute" data-action-type="helper" data-action="updatePostStatus">' . ucfirst($status) . '<div class="tooltip">Make draft</div></a>';
	} else {
		$link = '<a class="admin-click-handler draft" data-post-id="' . $post_id . '" data-post-status="publish" data-handler="execute" data-action-type="helper" data-action="updatePostStatus">' . ucfirst($status) . '<div class="tooltip">Publish</div></a>';
	}

	// status
	$output = $link;

	// return
	return $output;
}

// -----------------------------------------
// get projects
// -----------------------------------------

function semplice_get_projects($portfolio_order, $categories, $limit, $offset, $projectnav) {

	// categories?
	if(is_array($categories)) {
		$categories = implode(', ', $categories);
	}
	
	// generate thumbnails
	$args = array(
		'posts_per_page'=> $limit,
		'post__in' 	 	=> $portfolio_order,
		'post_type'	  	=> 'project',
		'post_status' 	=> 'publish',
		'orderby' 	  	=> 'post__in',
		'category'      => $categories,
	);

	// offset
	if(false !== $offset && $offset > 0) {
		$args['offset'] = $offset;
	}

	$posts = get_posts($args);
	$projects = array();

	// go through order and add to list
	if(null !== $posts) {
		$i = 0;
		foreach ($posts as $post) {
			// get post settings
			$post_settings = json_decode(get_post_meta($post->ID, '_semplice_post_settings', true), true);
			// project nav visibility
			$projectnav_visibility = true;
			if(isset($post_settings['meta']['projectnav_visibility']) && false === semplice_boolval($post_settings['meta']['projectnav_visibility'])) {
				$projectnav_visibility = false;
			}
			// add to projects
			if(false === $projectnav || true === $projectnav && true === $projectnav_visibility) {
				// get thumbnails
				$thumbnails = semplice_get_thumbnail($post->ID, true);
				// add to projects
				$projects[$i] = array(
					'post_id' => $post->ID,
					'post_title' => $post->post_title,
					'permalink' => get_permalink($post->ID),
					'image' => $thumbnails['image'],
					'pp_thumbnail' => $thumbnails['project_panel'],
					'nextprev_thumbnail' => $thumbnails['nextprev'],
					'categories' => wp_get_post_categories($post->ID),
				);
				
				// is individual thumb hover activated?
				if(isset($post_settings['thumbnail']['hover_visibility']) && $post_settings['thumbnail']['hover_visibility'] == 'enabled') {
					$projects[$i]['thumb_hover'] = $post_settings['thumbnail'];
				}
				// project type
				if(isset($post_settings['meta']['project_type']) && !empty($post_settings['meta']['project_type'])) {
					$projects[$i]['project_type'] = $post_settings['meta']['project_type'];
				} else {
					$projects[$i]['project_type'] = 'Project type';
				}
				
				// inc
				$i++;
			}
		}
	}

	return $projects;
}

// ----------------------------------------
// get post dropdown
// ----------------------------------------

function semplice_get_post_dropdown($post_type) {
	// get pages
	$posts = get_posts(array('posts_per_page' => -1, 'post_type' => $post_type));
	// pages array
	$posts_array = array(0 => '— Select ' . $post_type);
	// iterate pages object
	if(is_array($posts)) {
		foreach ($posts as $post) {
			$posts_array[$post->ID] = $post->post_title;
		}
		return $posts_array;
	} else {
		return array('0' => 'You have no ' . $post_type . 's');
	}
}

// ----------------------------------------
// get all pages and projects
// ----------------------------------------

function semplice_get_apg_posts($mode, $order) {
	// get pages
	$args = array(
		'posts_per_page' => -1, 
		'post_type' => array('page', 'project')
	);
	// is order?
	if(false !== $order && is_array($order)) {
		$args['post__in'] = $order;
		$args['orderby'] = 'post__in';
	}
	// get posts
	$posts = get_posts($args);
	// pages array
	$posts_array = array();
	// i
	$i = 0;
	// iterate pages object
	if(is_array($posts)) {
		if($mode == 'content') {
			foreach ($posts as $post) {
				$posts_array[$i] = array(
					'post_id'	 => $post->ID,
					'post_title' => $post->post_title,
					'post_type'  => $post->post_type,
					'permalink'	 => get_permalink($post->ID),
					'thumbnail'  => semplice_get_thumbnail($post->ID, false),
				);
				// get post settings
				$post_settings = json_decode(get_post_meta($post->ID, '_semplice_post_settings', true), true);
				// project type
				if(isset($post_settings['meta']['project_type']) && !empty($post_settings['meta']['project_type'])) {
					$posts_array[$i]['project_type'] = $post_settings['meta']['project_type'];
				} else {
					$posts_array[$i]['project_type'] = 'Project type';
				}
				// inc
				$i++;
			}
		} else {
			if($mode == 'ids') {
				foreach ($posts as $post) {
					$posts_array[] = $post->ID;
					$i++;
				}
			}
		}
	}
	// ret
	return $posts_array;
}

// ----------------------------------------
// get tmeplate dropdown
// ----------------------------------------

function semplice_get_template_dropdown() {
	// get pages
	$posts = get_posts(array('posts_per_page' => -1, 'post_type' => array('page', 'project'), 'post_status' => array('publish', 'draft')));
	// pages array
	$output = '<option value="0">Use Existing Page or Project as a Template</option>';
	// iterate pages object
	if(is_array($posts)) {
		foreach ($posts as $post) {
			// is coverslider
			$is_coverslider = semplice_boolval(get_post_meta($post->ID, '_is_coverslider', true));
			// is semplice
			$is_semplice = semplice_boolval(get_post_meta($post->ID, '_is_semplice', true));
			// only include smeplice pages or posts which are not a coverslider
			if(false === $is_coverslider && true === $is_semplice) {
				$output .= '<option value="' . $post->ID . '">' . $post->post_title . '</option>';
			}
		}
		return $output;
	} else {
		return $output = '<option value="0">No pages or projects found</option>';
	}
}

// ----------------------------------------
// search posts by title
// ----------------------------------------

function semplice_search_posts_by_title($search_term, $sortby, $post_type) {
	// global wpdb
	global $wpdb;
	// search posts
	$search_posts = $wpdb->get_results(
		$wpdb->prepare (
			"
			SELECT ID, post_title, post_status, post_name
			FROM $wpdb->posts
			WHERE post_title LIKE '%s'
			AND post_type = '$post_type'
			AND post_status != 'trash'
			ORDER BY $sortby DESC
			",
			'%' . $wpdb->esc_like($search_term) . '%'
		),
		ARRAY_A
	);
	return $search_posts;
}

// ----------------------------------------
// get portfolio order
// ----------------------------------------

function semplice_get_portfolio_order() {
	// get order
	$order = json_decode(get_option('semplice_portfolio_order'));
	// ret array
	$return_array = array();
	// is array?
	if(is_array($order) && !empty($order)) {
		$i = 0;
		foreach ($order as $id) {
			if(get_post_status($id) == 'publish') {
				$return_array[$i] = $id;
				$i++;
			}
		}
	}
	// return
	return $return_array;
}
?>