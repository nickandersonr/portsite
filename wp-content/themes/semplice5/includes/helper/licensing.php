<?php

// -----------------------------------------
// save license
// -----------------------------------------

function semplice_save_license($key, $product) {

	// output
	$output = array(
		'license' => '',
		'update' => '',
	);

	// get current license
	$current_license = json_decode(get_option('semplice_license'), true);

	// defaults
	$defaults = array('key', 'product', 'is_valid');

	// get current license
	foreach ($defaults as $attribute) {
		if(!isset($current_license[$attribute])) {
			$current_license[$attribute] = '';
		}
	}

	// check license
	$check_license = wp_remote_get('https://update.semplice.com/update.php?key=' . $key . '&product=' . $product . '&action=check_key');

	if(!is_wp_error($check_license) && empty($check_license->errors)) {
		// get array
		$license = json_decode($check_license['body'], true);
		// valid until set?
		$valid_until = 'no_subscription';
		if(isset($license['valid_until'])) {
			$valid_until = $license['valid_until'];
		}
		// check if license is valid
		if($license['license'] == 'valid' && $product != 'subscription' || $license['license'] == 'valid' && $product == 'subscription' && true === semplice_active_subscription($license)) {
			// define output
			$output['license'] = array(
				'is_valid'  	=> true,
				'key'			=> $key,
				'name'			=> $license['name'],
				'product'		=> $product,
				'email'			=> $license['email'],
				'error'			=> false,
				'valid_until'   => $valid_until
			);
		} else {
			// set license to invalid
			$output['license'] = array(
				'is_valid' => false,
				'product' => $product,
			);
		}
	} else {
		$output['license'] = array('error' => $check_license->get_error_message());
	}

	// save to admin
	update_option('semplice_license', json_encode($output['license']));

	// check for updates
	semplice_update_check();

	// add update to array
	$output['update'] = semplice_has_update();

	// return
	return $output;
}

// -----------------------------------------
// get license
// -----------------------------------------

function semplice_get_license() {

	// get current license
	$current_license = json_decode(get_option('semplice_license'), true);

	// check license
	if(is_array($current_license) && false !== $current_license['is_valid']) {
		$output = $current_license;
	} else {
		$output = false;
	}

	// return
	return $output;
}

// -----------------------------------------
// semplice update check
// -----------------------------------------

function semplice_update_check() {
	
	// get license
	$license = semplice_get_license();

	// meta data url
	$meta_data_url = false;

	// decide which edition / product to update
	if(isset($license['product']) && $license['product'] == 'subscription') {
		// is valid?
		if(true === semplice_active_subscription($license)) {
			$meta_data_url = 'https://update.semplice.com/update_subscription.json';
		}
	} else if(semplice_theme('edition') == 'single' && isset($license['product']) && $license['product'] != 's5-single') {
		$meta_data_url = 'https://update.semplice.com/update_s5_studio.json';
	} else {
		// check license and theme folder
		$meta_data_url = 'https://update.semplice.com/update_s5_' . semplice_theme('edition') . '.json';
	}

	// has meta data url?
	if(false !== $meta_data_url) {
		// get theme folder (without trailing slash)
		$theme_folder = get_template();

		// check if theme folder is correct and license is valid
		if($theme_folder == 'semplice5' && is_array($license) && true === $license['is_valid']) {
			// make sure its s5
			if(strpos($license['product'], 's5') !== false || $license['product'] == 'subscription') {
				// if everything is ok turn on auto update
				require get_template_directory() . '/includes/update.php';
					
				// new instance of themeupdatechecker
				$check_update = new ThemeUpdateChecker(
					'semplice5',
					$meta_data_url
				);

				// check for updates
				$check_update->checkForUpdates();
			}
		}
	}	
}

// -----------------------------------------
// check if there is an update
// -----------------------------------------

function semplice_has_update() {

	// output array
	$output = array(
		'has_update' => false,
	);

	// get license
	$license = semplice_get_license();

	// get theme folder (without trailing slash)
	$theme_folder = get_template();

	// include update.php
	require_once ABSPATH . '/wp-admin/includes/update.php';

	// get theme updates
	$theme_updates = get_theme_updates();

	// loop through updates
	if(is_array($theme_updates)) {
		foreach ($theme_updates as $theme => $meta) {
			// make sure its semplice 4
			if($meta->Name == 'Semplice v5') {
				$output = array(
					'has_update' => true,
					'has_edition_upgrade' => false,
					'recent_version' => semplice_theme('version'),
					'new_version' => $meta->update['new_version']
				);
				// is edition upgrade available?
				if(semplice_theme('edition') == 'single' && $license['product'] != 's5-single') {
					$output['has_edition_upgrade'] = true;
				}
			}
		}
	}

	// check if correct folder
	if($theme_folder !== 'semplice5') {
		$output['wrong_folder'] = true;
	} else {
		$output['wrong_folder'] = false;
	}

	// output
	return $output;
}

function semplice_active_subscription($license) {
	$is_active = false;
	if(isset($license['valid_until'])) {
		$today = date('d.m.Y');
		if(strtotime($today) <= strtotime($license['valid_until'])) {
			$is_active = true;
		} else {
			// set inactive
			update_option('semplice_license', json_encode(array('is_valid' => false, 'product' => 'subscription')));
		}
	}
	return $is_active;
}

?>