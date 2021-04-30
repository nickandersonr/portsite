<!-- admin templates -->
<div id="admin-templates">
	<?php
		// semplice get content
		global $semplice_get_content;
		// default nav settings
		$nav_settings = admin_api::$customize['navigations']->default_nav_settings();
		// get menu
		$menu = wp_nav_menu(
			array (
				'echo' => false,
				'container' => false,
				//'fallback_cb' => '__return_false',
				'theme_location' => 'main-menu',
			)
		);
		// define templates
		$templates = array('error', 'add_post', 'edit_popup', 'customize', 'webfonts', 'navigations', 'input', 'post_settings', 'media_library', 'popups', 'other');
		// get templates
		foreach ($templates as $template) {
			require get_template_directory() . '/admin/templates/' . $template . '.php';
		}
	?>
</div>












	
	
	


