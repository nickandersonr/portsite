<?php global $admin_api; ?>
<div id="semplice" data-edition="<?php echo semplice_theme('edition'); ?>" data-color-scheme="<?php echo semplice_get_backend_style(); ?>" data-customize-breakpoint="xl">
	<div id="semplice-wrapper">
		<header id="semplice-header">
			<div class="admin-logo">
				<a class="dashboard-link" href="#dashboard">
					<?php echo get_svg('backend', 'semplice_logo_' . semplice_theme('edition')); ?>
				</a>
			</div>
			<nav>
				<ul class="admin-nav">
					<li><a href="#content/pages/1" id="nav-pages">Pages</a></li>
					<li><a href="#content/projects/1" id="nav-projects">Projects</a></li>
					<li><a href="#customize/grid" id="nav-customize">Customize</a></li>
					<li><a href="#settings/general" id="nav-settings">Settings</a></li>
				</ul>
			</nav>
			<div class="preview-and-exit">
				<a class="change-backend-style" data-backend-style="<?php echo semplice_get_backend_style(); ?>"></a>
				<a class="preview-site" href="<?php echo home_url(); ?>" target="_blank"><?php echo get_svg('backend', '/icons/preview'); ?></a>
				<a class="exit admin-click-handler" data-handler="execute" data-action="exit" data-action-type="main">Exit</a>
			</div>
		</header>
		<section class="admin-spacer"></section>
		<section id="customize-header">
			<?php echo semplice_get_customize_nav('customize', 'admin'); ?>
			<div class="customize-save">
				<?php echo semplice_ajax_save_button('<a class="admin-click-handler save-button semplice-button ajax-save-button" data-handler="execute" data-action-type="customize" data-action="save" data-customize-setting="">'); ?>
			</div>
		</section>
		<section id="settings-header">
			<?php echo semplice_get_customize_nav('settings', 'admin'); ?>
			<div class="settings-save">
				<?php echo semplice_ajax_save_button('<a class="admin-click-handler save-button semplice-button ajax-save-button" data-handler="execute" data-action-type="settings" data-action="save" data-settings-setting="">'); ?>
			</div>
		</section>
		<section id="semplice-content">
			<!-- Dynamic Content -->
		</section>
	</div>
	
	<!-- overlay -->
	<div class="overlay"></div>

	<!-- admin templates -->
	<?php require get_template_directory() . '/admin/templates.php'; ?>

	<!-- semplice editor -->
	<?php require get_template_directory() . '/admin/editor/index.php'; ?>

	<!-- editor launch transition -->
	<div class="editor-launch-transition">
		<div class="logo-transition">
			<div class="inner">
				<?php echo get_svg('backend', 'transition_logo'); ?>
			</div>
		</div>
	</div>

	<!-- init transition -->
	<div class="admin-init-transition">
		<div class="logo-transition">
			<div class="inner">
				<?php echo get_svg('backend', 'transition_logo'); ?>
			</div>
		</div>
	</div>

	<!-- loader -->
	<div class="semplice-loader">
		<svg class="semplice-spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
			<circle class="path" fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
		</svg>
	</div>

	<!-- edit popups -->
	<div id="admin-edit-popup"></div>

	<!-- exiting -->
	<div class="exiting">Goodbye!</div>

	<!-- onboarding progress -->
	<div id="onboarding-progress">
		<div class="ob-progress-bg"></div>
		<div class="ob-progress"></div>
	</div>
</div>

<!-- wysiwyg save -->
<div id="wysiwyg-active">
	<a class="wysiwyg-save"><?php echo get_svg('backend', 'icons/save_checkmark'); ?></a>
</div>

<!-- reorder save -->
<div id="reorder-active">
	<p>Re-Order</p>
	<div class="reorder-mode">
		<a class="editor-action active" data-handler="execute" data-action-type="helper" data-action="reOrder" data-mode="section">Sections</a>
		<a class="editor-action" data-handler="execute" data-action-type="helper" data-action="reOrder" data-mode="row">Rows</a>
	</div>
	<a class="reorder-save"><?php echo get_svg('backend', 'icons/save_checkmark'); ?></a>
</div>