<?php

// -----------------------------------------
// admin notices
// -----------------------------------------

function semplice_admin_notice($type, $notice) {
	// class
	$class = array(
		'warning' => 'update-nag',
		'error'	  => 'error',
		'notice'  => 'updated',
	);
	// add notice
	?>
	<div class="<?php echo $class[$type]; ?>"><?php _e($notice, 'semplice'); ?></div>
	<?php
}

// -----------------------------------------
// all semplice admin notices
// -----------------------------------------

function semplice_admin_notices() {
	// check if api is already installed
	if(semplice_wp_version_is('<', '4.4')) {
		// admin notice
		function semplice_wp_version_notice() {
			semplice_admin_notice('warning', 'Semplice requires WordPress 4.4 or higher. Please update your site and try again.');
		}
		add_action('admin_notices', 'semplice_wp_version_notice');
		// show on frontend
		if(!is_admin()) {
			echo '
				<div class="semplice-error">
					<span>' . get_svg('backend', '/icons/popup_important') . '</span>
					<h1>Semplice requires WordPress 4.4 or higher with an activated<br />Rest-API. Please update your site and try again.</h1>
					<a class="semplice-button admin-click-handler" data-handler="execute" data-action="exit" data-action-type="main">Exit to Wordpress</a>
				</div>
			';
		}
	}

	// check if php version is > 5.3
	if (version_compare(phpversion(), '5.3', '<')) {
		// admin notice
		function semplice_php_version_notice() {
			semplice_admin_notice('warning', 'Semplice requires PHP 5.3 or higher. Please ask your host to update your PHP version and try again.');
		}
		add_action('admin_notices', 'semplice_php_version_notice');
	}

	// update permalinks for the use with semplice
	global $wp_rewrite;
	if($wp_rewrite->permalink_structure != '/%postname%') {
		$wp_rewrite->set_permalink_structure('/%postname%');
		// admin notice
		function semplice_rewrite_notice() {
			semplice_admin_notice('warning', 'In order for Semplice to work properly we changed your permalink structure automatically to <b>\'%postname\'</b>. <br /><i>Example: http://www.domain.com/post-name.</i>');
		}
		add_action('admin_notices', 'semplice_rewrite_notice');
	}
}

// -----------------------------------------
// editor notices
// -----------------------------------------

function semplice_editor_notices() {
	// get notices
	if(false !== get_option('semplice_editor_notices')) {
		return json_decode(get_option('semplice_editor_notices'), true);
	} else {
		// return default
		return array(
			'section_module' => 'unread',
			'text_module'	 => 'unread',
			'motions'		 => 'unread'
		);
	}
}

?>