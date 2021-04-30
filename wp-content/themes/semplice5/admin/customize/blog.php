<?php

// -----------------------------------------
// semplice
// /admin/blog.php
// -----------------------------------------

if(!class_exists('blog')) {
	class blog {

		// pub
		public $content;

		// constructor
		public function __construct() {
			global $semplice_get_content;
			$this->content = $semplice_get_content;
		}

		// output
		public function output() {
			// output air
			$output = array(
				'html' => $this->content->customize(),
				'css'  => $this->get_css(true),
			);

			return $output;
		}

		// get css
		public function get_css($is_admin) {

			// output
			$css = '';

			// blog options
			$options = json_decode(get_option('semplice_customize_blog'), true);

			// check if blog is array
			if(is_array($options)) {
				// blog alignment
				if(isset($options['blog_alignment'])) {
					$css .= '.is-frontend .post .row, #semplice-content .post .row { justify-content: ' . $options['blog_alignment'] . '; }';
				}
				// bg color
				if(isset($options['blog_bg_color'])) {
					if($is_admin) {
						$css .= '.blog-settings #content-holder { background-color: ' .$options['blog_bg_color'] . '; }';
					} else {
						$css .= '#content-holder, #content-holder .transition-wrap, #content-holder .posts { background-color: ' . $options['blog_bg_color'] . '; }';
					}
				}
				// display content
				if(isset($options['display_content']) && $options['display_content'] == 'top') {
					$css .= '#content-holder .sections { margin-top: 0px !important; }';
				}
				// divider color
				if(isset($options['blog_divider_color'])) {
					$css .= '.post-divider { background-color: ' . $options['blog_divider_color'] . '; }';
				}
				// blog meta font size
				if(isset($options['blog_head_meta_font_size'])) {
					$css .= '.post .post-heading p a, .post .post-heading p span { font-size: ' . $options['blog_head_meta_font_size'] . '; }';
				}
				// blog meta alignment
				if(isset($options['blog_head_meta_alignment'])) {
					$css .= '.post .post-heading p { text-align: ' . $options['blog_head_meta_alignment'] . '; }';
				}
				// blog meta link color
				if(isset($options['blog_head_meta_color'])) {
					$css .= '.post .post-heading p a, .post .post-heading p span { color: ' . $options['blog_head_meta_color'] . '; }';
				}
				// blog meta mouseover color
				if(isset($options['blog_head_meta_mouseover_color'])) {
					$css .= '.post .post-heading p a:hover { color: ' . $options['blog_head_meta_mouseover_color'] . '; }';
				}
				// blog title alignment
				if(isset($options['blog_title_alignment'])) {
					$css .= '.post .post-heading h2 { text-align: ' . $options['blog_title_alignment'] . '; }';
				}
				// blog title color
				if(isset($options['blog_title_color'])) {
					$css .= '.post .post-heading h2 a, .posts .post-heading h2 { color: ' . $options['blog_title_color'] . '; }';
				}
				// blog title mouseover
				if(isset($options['blog_title_mouseover_color'])) {
					$css .= '.post .post-heading h2 a:hover { color: ' . $options['blog_title_mouseover_color'] . '; opacity: 1; }';
				}
				// content text color
				if(isset($options['blog_text_color'])) {
					$css .= '.post .post-content { color: ' . $options['blog_text_color'] . '; }';
				}
				// content link color
				if(isset($options['blog_link_color'])) {
					$css .= '.post .post-content a, .blog-pagination a { color: ' . $options['blog_link_color'] . '; }';
				}
				// content mouseover color
				if(isset($options['blog_mouseover_color'])) {
					$css .= '.post .post-content a:hover { color: ' . $options['blog_mouseover_color'] . '; }';
				}
				// blog meta font size
				if(isset($options['blog_meta_font_size'])) {
					$css .= '#content-holder .post .post-meta * { font-size: ' . $options['blog_meta_font_size'] . '; }';
				}
				// blog meta alignment
				if(isset($options['blog_meta_alignment'])) {
					$css .= '.post .post-meta * { text-align: ' . $options['blog_meta_alignment'] . '; }';
				}
				// blog meta link color
				if(isset($options['blog_meta_color'])) {
					$css .= '.post .post-meta { color: ' . $options['blog_meta_color'] . '; }';
				}
				// blog meta link color
				if(isset($options['blog_meta_link_color'])) {
					$css .= '.post .post-meta a { color: ' . $options['blog_meta_link_color'] . '; }';
				}
				// blog meta mosueover color
				if(isset($options['blog_meta_mouseover_color'])) {
					$css .= '.post .post-meta a:hover { color: ' . $options['blog_meta_mouseover_color'] . '; }';
				}
				// comment bg color
				if(isset($options['comment_bg_color'])) {
					$css .= '#comments { background-color: ' . $options['comment_bg_color'] . '; }';
				}
				// comment title color
				if(isset($options['comment_title_color'])) {
					$css .= '#comments .comments-title { color: ' . $options['comment_title_color'] . '; }';
				}
				// comment author font color
				if(isset($options['comment_author_color'])) {
					$css .= '#comments .comments .comment .comment-author cite, #comments .comments .comment .comment-author cite a { color: ' . $options['comment_author_color'] . '; }';
				}
				// comment author hover
				if(isset($options['comment_author_mouseover_color'])) {
					$css .= '#comments .comments .comment .comment-author cite a:hover { color: ' . $options['comment_author_mouseover_color'] . '; }';
				}
				// comment date font color
				if(isset($options['comment_date_color'])) {
					$css .= '#comments .comments .comment .comment-meta a { color: ' . $options['comment_date_color'] . '; }';
				}
				// comment date hover
				if(isset($options['comment_date_mouseover_color'])) {
					$css .= '#comments .comments .comment .comment-meta a:hover { color: ' . $options['comment_date_mouseover_color'] . '; }';
				}
				// comment font color
				if(isset($options['comment_content_color'])) {
					$css .= '#comments .comments .comment p { color: ' . $options['comment_content_color'] . '; }';
				}
				// comment divider color
				if(isset($options['comment_content_divider_color'])) {
					$css .= '#comments .comments .comment, #comments .comments .comment .depth-2, #comments .comments .comment .depth-3 { border-color: ' . $options['comment_content_divider_color'] . '; }';
				}
				// comment reply button
				if(isset($options['comment_reply_color'])) {
					$css .= '#comments .comments .comment .reply a, #comments #respond #reply-title #cancel-comment-reply-link { color: ' . $options['comment_reply_color'] . '; }';
				}
				// comment reply border
				if(isset($options['comment_reply_border_color'])) {
					$css .= '#comments .comments .comment .reply a, #comments #respond #reply-title #cancel-comment-reply-link { border-color: ' . $options['comment_reply_border_color'] . '; }';
				}
				// respond color
				if(isset($options['comment_respond_color'])) {
					$css .= '#comments #respond #reply-title, #comments #respond #reply-title a { color: ' . $options['comment_respond_color'] . '; }';
				}

				// font familys
				if(!$is_admin) {
					// comment title font
					if(isset($options['comment_title_font_family'])) {
						$css .= '#comments .comments-title { ' . semplice_get_font_family($options['comment_title_font_family']) . ' }';
					}
					// comment author font
					if(isset($options['comment_author_font_family'])) {
						$css .= '#comments .comments .comment .comment-author cite, #comments .comments .comment .comment-author cite a { ' . semplice_get_font_family($options['comment_author_font_family']) . ' }';
					}
					// comment author font
					if(isset($options['comment_date_font_family'])) {
						$css .= '#comments .comments .comment .comment-meta a { ' . semplice_get_font_family($options['comment_date_font_family']) . ' }';
					}
					// comment author font
					if(isset($options['comment_content_font_family'])) {
						$css .= '#comments .comments .comment p { ' . semplice_get_font_family($options['comment_content_font_family']) . ' }';
					}
					// comment reply font
					if(isset($options['comment_respond_font_family'])) {
						$css .= '#comments #reply-title { ' . semplice_get_font_family($options['comment_respond_font_family']) . ' }';
					}
					// comment reply button font
					if(isset($options['comment_reply_font_family'])) {
						$css .= '.comment-reply-link { ' . semplice_get_font_family($options['comment_reply_font_family']) . ' }';
					}
					// form font family
					if(isset($options['comment_form_font_family'])) {
						$css .= 'form#commentform input, #comments form#commentform #submit, #comments form#commentform textarea { ' . semplice_get_font_family($options['comment_form_font_family']) . ' }';
					}
				}

				// form open
				$css .= '
					#comments form#commentform input, #comments form#commentform #submit, #comments form#commentform textarea,
					#comments form#commentform input:hover, #comments form#commentform #submit:hover, #comments form#commentform textarea:hover,
					#comments form#commentform input:focus, #comments form#commentform #submit:focus, #comments form#commentform textarea:focus {
				';

				// form bg color
				if(isset($options['comment_form_bg_color'])) {
					$css .= 'background-color: ' . $options['comment_form_bg_color'] . ';';
				}
				// form color
				if(isset($options['comment_form_color'])) {
					$css .= 'color: ' . $options['comment_form_color'] . ';';
				}
				// form color
				if(isset($options['comment_form_border_color'])) {
					$css .= 'border-color: ' . $options['comment_form_border_color'] . ';';
				}

				// form close
				$css .= '}';

				// placeholder
				// form color
				if(isset($options['comment_form_color'])) {
					$css .= '
						::-webkit-input-placeholder {
							color: ' . $options['comment_form_color'] . ';
						}
						::-moz-placeholder {
							color: ' . $options['comment_form_color'] . ';
						}
						:-ms-input-placeholder {
							color: ' . $options['comment_form_color'] . ';
						}
						:-moz-placeholder {
							color: ' . $options['comment_form_color'] . ';
						}
					';
				}
			}

			// correct the author display
			if($is_admin) {
				$css .= '
					cite.fn { top: -7px !important; }
					.comment-meta a { margin-top: -5px !important; }
				';
			}

			// get share box css
			$css .= semplice_share_box_css($options, 'share-holder');

			// return
			return $css;
		}
	}

	// instance
	admin_api::$customize['blog'] = new blog;
}

?>