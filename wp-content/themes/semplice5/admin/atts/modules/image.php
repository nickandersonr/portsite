<?php

// -----------------------------------------
// semplice
// admin/atts/modules/image.php
// -----------------------------------------

$image = array(
	'image-upload' => array(
		'title'  	 => 'Image',
		'break'		 => '1,2',
		'data-hide-mobile' => true,
		'image' => array(
			'title'			=> 'Image Upload',
			'size'			=> 'span2',
			'data-input-type'	=> 'admin-image-upload',
			'default'		=> '',
			'data-is-content' => true,
			'hide-title'	=> true,
			'data-upload'	=> 'contentImage',
			'style-class'		=> 'ce-dropzone',
		),
		'width' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Width',
			'size'		 => 'span2',
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'default',
			'data-target'=> '.is-content',
			'default' 	 => 'original',
			'help'		 => '\'Original\' means that the image will not be scaled unless it is too big for the grid. If you choose \'Grid Width\', your image will always be scaled to match the grid width.',
			'select-box-values' => array(
				'original'		 => 'Original',
				'grid-width' => 'Grid Width',
			),
		),
		'align' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Align',
			'size'		 => 'span2',
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'default',
			'data-target'=> '.ce-image',
			'default' 	 => 'left',
			'help'		 => 'Only works if your image is not bigger than the grid.',
			'select-box-values' => array(
				'left' 		=> 'Left',
				'center'	=> 'Center',
				'right'		=> 'Right'
			),
		),
	),
	'image-link' => array(
		'title'  	 => 'Links to',
		'break'		 => '1,1,1,1,1,2',
		'style-class' => 'ep-collapsed',
		'data-hide-mobile' => true,
		'image_link_type' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Link Type',
			'size'		 => 'span4',
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'save',
			'default' 	 => 'url',
			'data-visibility-switch' 	=> true,
			'data-visibility-values' 	=> 'url,page,project,post',
			'data-visibility-prefix'	=> 'ov-img-link',
			'hide-title'	=> true,
			'style-class'   => 'first-option-title-hidden',
			'select-box-values' => array(
				'url' => 'Url',
				'page'		 => 'Page',
				'project'	 => 'Project',
				'post'		 => 'Blog post',
			),
		),
		'image_link' => array(
			'data-input-type'	=> 'input-text',
			'title'		 	=> 'Link',
			'size'		 	=> 'span4',
			'placeholder'	=> 'https://www.google.com',
			'default'		=> '',
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'save',
			'style-class'	=> 'ov-img-link-url',
		),
		'image_link_page' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Link to page',
			'size'		 => 'span4',
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'save',
			'default' 	 => '',
			'select-box-values' => semplice_get_post_dropdown('page'),
			'style-class'	=> 'ov-img-link-page',
		),
		'image_link_project' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Link to project',
			'size'		 => 'span4',
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'save',
			'default' 	 => '',
			'select-box-values' => semplice_get_post_dropdown('project'),
			'style-class'	=> 'ov-img-link-project',
		),
		'image_link_post' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Link to blog post',
			'size'		 => 'span4',
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'save',
			'default' 	 => '',
			'select-box-values' => semplice_get_post_dropdown('post'),
			'style-class'	=> 'ov-img-link-post',
		),
		'image_link_target' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Link Target',
			'size'		 => 'span2',
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'save',
			'default' 	 => '_blank',
			'select-box-values' => array(
				'_blank'	 => 'New Tab',
				'_self' 	 => 'Same Tab',
			),
		),
		'lightbox' => array(
			'data-input-type' => 'switch',
			'switch-type'=> 'twoway',
			'title'		 => 'Lightbox',
			'size'		 => 'span2',
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'save',
			'default' 	 => 'no',
			'help'		 => 'To show a caption for your images in the lightbox please open the media library, click on the settings icon on your selected images and add a caption. You can customize the caption style in \'Customize -> Advanced\'',
			'switch-values' => array(
				'no'	 => 'No',
				'yes' 	 => 'Yes',
			),
		),
		/*
		'scaling' => array(
			'data-input-type' => 'switch',
			'switch-type'=> 'twoway',
			'title'		 => 'Mobile Scaling',
			'help'		 => 'If activated the image will not get scaled to match the content width on mobile devices. It will only get scaled if its bigger than the content width, but will never get enlarged.',
			'size'		 => 'span2',
			'class'      => 'listen',
			'default' 	 => 'no',
			'data-target'=> '.is-content',
			'switch-values' => array(
				'no'	 => 'No',
				'yes' 	 => 'yes',
			),
		),
		*/
	),
);

?>