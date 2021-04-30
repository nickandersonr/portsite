<?php

// -----------------------------------------
// semplice
// admin/atts/modules/singleproject.php
// -----------------------------------------

$singleproject = array(
	'project-select' => array(
		'title'  	 => 'Select Project',
		'hide-title' => true,
		'help'		 => 'Only published projects are available.',
		'break'		 => '1',
		'data-hide-mobile' => true,
		'sp-project' => array(
			'data-input-type' => 'select-box',
			'title'		 => 'Project',
			'size'		 => 'span4',
			'class'      	=> 'editor-listen',
			'data-handler' 	=> 'singleProject',
			'data-is-content' => true,
			'default' 	 => '',
			'select-box-values' => semplice_get_post_dropdown('project'),
		),
	),
	'project-hover' => array(
		'title'  	 => 'Thumbnail',
		'break'		 => '1,1',
		'data-hide-mobile' => true,
		'global_hover' => array(
			'data-input-type' => 'notice',
			'title'		 => 'Notice',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'      => 'ep-notice',
			'style-class'=> 'singleproject-notice',
			'default'    => 'Options like <b>scale</b> and <b>drop shadow</b> can only be changed globally in \'Customize\' &rarr; \'Thumb Hover\'. ',
			'notice-type'=> 'warning',
		),
		'thumbnail' => array(
			'data-input-type' 	=> 'button',
			'title'		 		=> 'Thumbnail',
			'hide-title'		=> true,
			'button-title'		=> 'Edit Thumbnail & Hover',
			'size'		 		=> 'span4',
			'class'				=> 'semplice-button single-project-post-settings',
			'responsive'		=> true,
		),
	),
);

?>