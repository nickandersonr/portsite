<?php

// -----------------------------------------
// semplice
// admin/atts/settings/general.php
// -----------------------------------------

$general = array(
	'site' => array(
		'title' => 'Site Title and Tagline',
		'description' => 'Define your site title and tagline.',
		'break' => '1,1',
		'site_title' => array(
			'data-input-type' 	 => 'input-text',
			'title'			  	 => 'Title',
			'placeholder' 	  	 => 'Semplice',
			'class'			  	 => 'admin-listen-handler',
			'size'		 	  	 => 'span4',
			'data-handler'    	 => 'settings',
			'default'		  	 => '',
			'data-settings-type' => 'general',
		),
		'site_tagline' => array(
			'data-input-type' 	 => 'input-text',
			'title'			  	 => 'Tagline',
			'placeholder' 	  	 => 'Designers\' best kept secret.',
			'class'			  	 => 'admin-listen-handler',
			'size'		 	  	 => 'span4',
			'data-handler'    	 => 'settings',
			'default'		  	 => '',
			'data-settings-type' => 'general',
		),
	),
	'homepage' => array(
		'title' => 'Your Homepage displays',
		'description' => 'Choose what to display on your homepage. <br /><br /><span class="warning">Warning</span><br />The portfolio homepage and the blog homepage<br />should not be the same! Instead select \'Latest Posts\' if you want to show your latest blog posts on the homepage.',
		'break' => '1,2',
		'show_on_front' => array(
			'data-input-type' 			=> 'switch',
			'hide-title'				=> true,
			'switch-type'				=> 'twoway',
			'title'		 				=> 'Your Homepage displays',
			'size'		 				=> 'span4',
			'class'						=> 'admin-listen-handler',
			'data-handler'  			=> 'settings',
			'default' 	 				=> 'posts',
			'data-settings-type'		=> 'general',
			'data-visibility-switch' 	=> true,
			'data-visibility-values' 	=> 'posts,page',
			'data-visibility-prefix'	=> 'ov-homepage',
			'switch-values' => array(
				'posts'  	=> 'Latest Posts',
				'page'	 	=> 'Static Page',
			),
		),
		'page_on_front' => array(
			'title'				 => 'Portfolio Homepage',
			'size'				 => 'span2',
			'data-input-type'    => 'select-box',
			'class'			  	 => 'admin-listen-handler',
			'data-handler'       => 'settings',
			'default'			 => '1',
			'data-settings-type' => 'general',
			'style-class'		 => 'ov-homepage-page',
			'select-box-values' => semplice_get_post_dropdown('page'),
		),
		'page_for_posts' => array(
			'title'				 => 'Blog Homepage',
			'size'				 => 'span2',
			'data-input-type'    => 'select-box',
			'class'			  	 => 'admin-listen-handler',
			'data-handler'       => 'settings',
			'default'			 => '1',
			'data-settings-type' => 'general',
			'style-class'		 => 'ov-homepage-page',
			'select-box-values' => semplice_get_post_dropdown('page'),
		),
	),
	'projects_rewrite' => array(
		'title' => 'Project Slug',
		'description' => 'Define the slug for projects. Default slug is <span class="code">project</span>. Please only use one word without any special characters like spaces, dashes etc. Example: <span class="code">work</span><br /><br />Example with default slug: http://www.example.com/project/my-project.',
		'break' => '1,1',
		'project_slug' => array(
			'data-input-type' 	 => 'input-text',
			'title'			  	 => 'Slug',
			'placeholder' 	  	 => 'Semplice',
			'class'			  	 => 'admin-listen-handler',
			'size'		 	  	 => 'span4',
			'data-handler'    	 => 'settings',
			'default'		  	 => 'project',
			'data-settings-type' => 'general',
		),
	),
	'frontend_mode' => array(
		'title' => 'Frontend Mode',
		'description' => '\'Single Page App\' means your website loads new content without page reloads to create a better flow and seamless page transitions. If you prefer the classic version with normal page reloads, select \'Static\'. Please note that custom page transitions are not supported in \'Static\' mode. You can customize your page transitions <a href="#customize/transitions">here</a>.<br /><br /><span class="warning">Important</span><br />The \'Single Page App\' mode is experimental. If you experience issues with plugins or if you miss some blog functionality (such as archives) please use the \'Static\' mode instead.',
		'frontend_mode' => array(
			'data-input-type' 			=> 'switch',
			'hide-title'				=> true,
			'switch-type'				=> 'twoway',
			'title'		 				=> 'Frontend mode',
			'size'		 				=> 'span4',
			'class'						=> 'admin-listen-handler',
			'data-handler'  			=> 'settings',
			'default' 	 				=> 'static',
			'data-settings-type'		=> 'general',
			'switch-values' => array(
				'static'  			=> 'Static',
				'dynamic'	 		=> 'Single Page App',
			),
		),
	),
	'static_transitions' => array(
		'title' => 'Static Page Transitions',
		'description' => 'If you run your site in \'Static\' mode, you can enable default page transitions to make your site feel more elegant out of the box. If you don’t want page transitions at all, set this option to \'Disabled.\'',
		'static_transitions' => array(
			'data-input-type' 			=> 'switch',
			'hide-title'				=> true,
			'switch-type'				=> 'twoway',
			'title'		 				=> 'Frontend mode',
			'size'		 				=> 'span4',
			'class'						=> 'admin-listen-handler',
			'data-handler'  			=> 'settings',
			'default' 	 				=> 'enabled',
			'data-settings-type'		=> 'general',
			'switch-values' => array(
				'enabled'  			=> 'Enabled',
				'disabled'	 		=> 'Disabled',
			),
		),
	),
	'analytics' => array(
		'title'		  => 'Google Analytics',
		'description' => 'Your Google Analytics code must start with <span class="code">&lt;script&gt;</span> and end with <span class="code">&lt;/script&gt;</span>',
		'break'		  => '1',
		'google_analytics' => array(
			'title'				 => 'Google Analytics',
			'hide-title'		 => true,
			'size'				 => 'span4',
			'data-input-type'	 => 'textarea',
			'class'			  	 => 'admin-listen-handler',
			'data-handler'       => 'settings',
			'default'			 => '',
			'data-settings-type' => 'general',
			'placeholder'		=> 'Paste your Google Analytics code here',
		),
	),
	'head-code' => array(
		'title'		  => 'HTML Head',
		'description' => 'Paste code you want to include in your <span class="code">&lt;head&gt;</span> section.',
		'break'		  => '1',
		'head_code' => array(
			'title'				 => 'HTML Head',
			'hide-title'		 => true,
			'size'				 => 'span4',
			'data-input-type'	 => 'textarea',
			'class'			  	 => 'admin-listen-handler',
			'data-handler'       => 'settings',
			'default'			 => '',
			'data-settings-type' => 'general',
			'placeholder'		=> 'Paste your code here',
		),
	),
	'favicon-upload' => array(
		'title'		  => 'Favicon',
		'description' => 'Upload your favicon here.<br /><br />Format: PNG<br />Dimensions: 32px*32px',
		'break'		  => '1',
		'favicon' => array(
			'title'				 => 'Favicon',
			'hide-title'		 => true,
			'size'				 => 'span2',
			'data-input-type'	 => 'admin-image-upload',
			'class'			  	 => 'admin-listen-handler',
			'data-handler'       => 'settings',
			'data-settings-type' => 'general',
			'data-upload'		 => 'favicon',
			'style-class'		 => 'ce-upload-small general-dropzone hide-unsplash',
		),
	),
);