<?php

// -----------------------------------------
// is onboarding
// -----------------------------------------

function semplice_is_onboarding() {
	// get onboarding status
	$completed_onboarding = get_option('semplice_completed_onboarding');
	// return status
	if($completed_onboarding) {
		return false;
	} else {
		return true;
	}
}

// -----------------------------------------
// get onboarding
// -----------------------------------------

function semplice_get_onboarding_content() {

	// steps
	$steps = array(
		'start' => 0,
		'one' => 1,
		'two' => 2,
		'three' => 3,
		'four' => 4,
		'five' => 5,
	);

	// output
	$output = array(
		'start' => array('title' => '', 'sub' => '', 'input' => ''),
		'one' => array(
			'title' => get_svg('backend', 'onboarding/step_one_heading'),
			'sub'	=> 'Choose between a light and dark experience depending<br />on the time of day, or your mood.',
			'input' => '',
		),
		'two' => array(
			'title' => get_svg('backend', 'onboarding/step_two_heading'),
			'sub'	=> 'This will show up when people search for your site. Use your<br />name, your studio’s name or your artistic pseudonym.',
			'input' => '<input type="text" class="onboarding-input onboarding-fadein admin-listen-handler" data-handler="onboardingBrowserHeading" name="site_title" placeholder="Sergio Rambotta">',
		),
		'three' => array(
			'title' => get_svg('backend', 'onboarding/step_three_heading'),
			'sub'	=> 'Don’t have an existential crisis. You can change this later.',
			'input' => '<input type="text" class="onboarding-input onboarding-fadein admin-listen-handler" data-handler="onboardingBrowserHeading" name="site_tagline" placeholder="Graphic Designer">',
		),
		'four' => array(
			'title' => get_svg('backend', 'onboarding/step_four_heading'),
			'sub'	=> 'Go with your gut. You can customize later or even use<br />different navigations for different pages. ',
			'input' => '',
		),
		'five' => array(
			'title' => get_svg('backend', 'onboarding/step_five_heading'),
			'sub'	=> 'You just relax for a moment. We’re setting up your<br />homepage and About page for you.',
			'input' => '',
		),
		'six' => array(
			'title' => get_svg('backend', 'onboarding/step_six_heading'),
			'sub'	=> 'Now we’re setting up your first project. Use projects for<br />your case studies, pages for everything else.',
			'input' => '',
		),
		'seven' => array(
			'title' => get_svg('backend', 'onboarding/step_seven_heading'),
			'sub'	=> 'You are ready to create your portfolio. There is no right<br />or wrong way from here. It’s entirely up to you.',
			'input' => '',
		),
	);

	// output
	return $output;
}

// -----------------------------------------
// first page
// -----------------------------------------

function semplice_first_page($post_id, $title, $post_revision) {
	
	// content
	if($title == 'work') {
		$content = '{"order":{"section_kb3god8ou":{"columns":{"column_z2clynthm":["content_g6nt8g63h"]},"row_id":"row_spc6vkgc0"}},"images":{},"branding":{},"content_g6nt8g63h":{"content":{"xl":""},"module":"portfoliogrid","options":{},"styles":{"xl":{}},"motions":{"active":[],"start":{},"end":{}}},"section_kb3god8ou":{"options":{},"layout":{"data-column-mode-sm":"single","data-column-mode-xs":"single"},"customHeight":{"xl":{"height":"15rem"}},"styles":{"xl":{}},"motions":{"active":[],"start":{},"end":{}}},"column_z2clynthm":{"width":{"xl":12},"options":{},"layout":{},"styles":{"xl":{}},"motions":{"active":[],"start":{},"end":{}}},"first_save":"yes","unpublished_changes":false}';
	} else {
		$content = '{"order":{},"images":{"":""},"branding":{},"first_save":"yes","unpublished_changes":false}';
	}

	// create array
	$page = array(
		'post_id' 		=> $post_id,
		'content'		=> $content,
		'first_save'	=> 'yes',
		'post_settings' => array(
			'meta' => array(
				'post_title' => ucfirst($title),
				'permalink' => sanitize_title($title),
			),
		),
		'post_type'		=> 'page',
		'save_mode'		=> 'publish',
		'change_status'	=> 'yes',
		'post_password' => '',
		'masterblocks'  => '{}',
		'post_revision' => $post_revision,
	);

	// decode post settings
	$page['post_settings'] = json_encode($page['post_settings']);

	return $page;
}

// -----------------------------------------
// first project
// -----------------------------------------

function semplice_first_project($post_id, $post_revision) {
	
	// create array
	$project = array(
		'post_id' 		=> $post_id,
		'content'		=> '{"order":{},"images":{"":""},"branding":{},"first_save":"yes","unpublished_changes":false}',
		'first_save'	=> 'yes',
		'post_settings' => array(
			'thumbnail' => array(
				'image' => '',
				'width'	=> '4',
				'hover_visibility' => 'disabled',
			),
			'meta' => array(
				'post_title' => 'My first project',
				'permalink' => sanitize_title('My first project'),
			),
		),
		'post_type'		=> 'project',
		'save_mode'		=> 'publish',
		'change_status'	=> 'yes',
		'post_password' => '',
		'masterblocks'  => '{}',
		'post_revision' => $post_revision,
	);

	// decode post settings
	$project['post_settings'] = json_encode($project['post_settings']);

	return $project;
}

?>