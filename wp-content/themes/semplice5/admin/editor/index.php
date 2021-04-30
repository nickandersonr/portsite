<div id="semplice-editor" class="active-content" data-mode="default">
	<!-- column count -->
	<div class="column-count"><span class="count"></span><sup class="col">Col</sup></div>
	<!-- grid -->
	<div id="semplice-grid" data-breakpoint="xl">
		<section class="content-block-grid">
			<div class="container">
				<div class="grid-row">
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
					<div class="grid-column" data-xl-width="1"><div class="grid-content"></div></div>
				</div>
			</div>
		</section>
	</div>
	<!-- top bar -->
	<header id="editor-header">
		<!-- exit without saving -->
		<div class="exit-without-saving">
			<a class="editor-action exit-button semplice-navigator-hover" data-action="slideIn" data-action-type="sidebar" data-element="#semplice-navigator" data-name="navigator"></a>
		</div>
		<!-- mobile  -->
		<div id="mobile-edit">
			Editing <span>Desktop</span>
		</div>
		<!-- add content -->
		<div class="editor-add">
			<nav>
				<ul>
					<li>
						<a class="add-content has-tooltip" data-module="text">
							<?php echo get_svg('backend', '/icons/module_text'); ?>
						</a>
						<div class="tooltip">Add Text</div>
					</li>
					<li>
						<a class="add-content has-tooltip" data-module="image">
							<?php echo get_svg('backend', '/icons/module_image'); ?>
						</a>
						<div class="tooltip">Add Image</div>
					</li>
					<li>
						<a class="add-content has-tooltip" data-module="gallery">
							<?php echo get_svg('backend', '/icons/module_gallery'); ?>
						</a>
						<div class="tooltip">Add Gallery Slider</div>
					</li>
					<li>
						<a class="add-content has-tooltip" data-module="video">
							<?php echo get_svg('backend', '/icons/module_video'); ?>
						</a>
						<div class="tooltip">Add Self Hosted Video</div>
					</li>
					<li>
						<a class="add-content has-tooltip" data-module="spacer">
							<?php echo get_svg('backend', '/icons/module_spacer'); ?>
						</a>
						<div class="tooltip">Add Horizontal Spacer</div>
					</li>
					<li>
						<a class="add-content has-tooltip" data-module="button">
							<?php echo get_svg('backend', '/icons/module_button'); ?>
						</a>
						<div class="tooltip">Add Button</div>
					</li>
					<li>
						<a class="add-spacer-column has-tooltip" data-module="spacer-column">
							<?php echo get_svg('backend', '/icons/module_spacercolumn'); ?>
						</a>
						<div class="tooltip">Add Spacer Column</div>
					</li>
					<li class="cover-button">
						<a class="text-link editor-action" data-action="coverDropdown" data-action-type="helper">Cover</a>
						<div class="cover-dropdown">
							<div class="option">
								<div class="option-inner">
									<div class="attribute span4">
										<h4>Visibility</h4>
										<div class="option-switch">
											<ul class="twoway">
												<li class="cover-hidden active">
													<a name="cover" data-switch-val="hidden" data-input-type="switch" switch-type="twoway" class="editor-listen" data-handler="cover" data-option-type="cover">Hidden</a>
												</li>
												<li class="cover-visible">
													<a name="cover" data-switch-val="visible" data-input-type="switch" switch-type="twoway" class="editor-listen" data-handler="cover" data-option-type="cover">Visible</a>
												</li>
												<input type="hidden" name="cover" data-input-type="switch" switch-type="twoway" class="editor-listen" data-handler="cover" data-option-type="cover">
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="option">
								<div class="option-inner">
									<div class="attribute span4">
										<h4>Import existing Cover</h4>
										<div class="select-box">
											<div class="sb-arrow"></div>
											<select name="import_cover" data-input-type="select-box" class="import-cover-listen">
												<option value="enabled" selected="">Select Page or Project</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="option">
								<div class="option-inner">
									<div class="attribute span4">
										<h4>Reset</h4>
										<a class="reset-cover semplice-button delete-button editor-action" data-handler="execute" data-action-type="popup" data-action="resetCover">Reset Cover</a>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li>
						<a class="editor-action show-modules text-link" data-action="slideIn" data-action-type="sidebar" data-element="#semplice-modules" data-name="modules">Modules</a>
					</li>
					<li>
						<?php
							if(semplice_theme('edition') == 'single') {
								echo '<a class="admin-click-handler show-blocks text-link" data-handler="execute" data-action="studioFeatures" data-action-type="popup" data-feature="blocks">Blocks</a>';
							} else {
								echo '<a class="editor-action show-blocks text-link" data-action="slideIn" data-action-type="sidebar" data-element="#semplice-blocks" data-name="blocks">Blocks</a>';
							}
						?>
					</li>
				</ul>
			</nav>
		</div>
		<!-- save -->
		<div class="editor-meta">
			<nav>
				<ul>
					<li class="branding-button">
						<a class="editor-action has-tooltip cursor-pointer icon-button" data-action="brandingDropdown" data-action-type="helper">
							<?php echo get_svg('backend', '/icons/branding'); ?>
						</a>
						<div class="tooltip">Look &amp; Feel</div>
						<div class="branding-dropdown">
							<div class="inner">
								<div class="branding-picker-holder"></div>
								<div class="left"></div>
								<div class="right"></div>
							</div>
						</div>
					</li>
					<li class="page-settings-button">
						<a class="page-settings has-tooltip cursor-pointer admin-click-handler" data-handler="execute" data-action="init" data-action-type="postSettings" data-ps-mode="editor">
							<?php echo get_svg('backend', '/icons/post_settings'); ?>
						</a>
						<div class="tooltip">Page Settings</div>
					</li>
					<li>
						<a class="footer-settings has-tooltip cursor-pointer editor-action" data-handler="execute" data-action-type="popup" data-action="footerSettings">
							<?php echo get_svg('backend', '/icons/post_settings'); ?>
						</a>
						<div class="tooltip">Footer Settings</div>
					</li>
					<li class="breakpoints-button">
						<a class="editor-action cursor-pointer has-tooltip icon-button" data-handler="execute" data-action="breakpointsDropdown" data-action-type="helper">
							<?php echo get_svg('backend', '/icons/mobile_switch'); ?>
						</a>
						<div class="tooltip">Responsive</div>
						<div class="breakpoints-dropdown">
							<ul>
								<li><a class="change-breakpoint xl active-breakpoint" data-change-breakpoint="xl"><?php echo get_svg('backend', '/icons/breakpoints_desktop_wide'); ?><div class="tooltip">Desktop Wide</div></a></li>
								<li><a class="change-breakpoint lg" data-change-breakpoint="lg"><?php echo get_svg('backend', '/icons/breakpoints_desktop'); ?><div class="tooltip">Desktop</div></a></li>
								<li><a class="change-breakpoint md" data-change-breakpoint="md"><?php echo get_svg('backend', '/icons/breakpoints_tablet_wide'); ?><div class="tooltip">Tablet Wide</div></a></li>
								<li><a class="change-breakpoint sm" data-change-breakpoint="sm"><?php echo get_svg('backend', '/icons/breakpoints_tablet_portrait'); ?><div class="tooltip">Tablet Portrait</div></a></li>
								<li><a class="change-breakpoint xs" data-change-breakpoint="xs"><?php echo get_svg('backend', '/icons/breakpoints_mobile'); ?><div class="tooltip">Mobile</div></a></li>
							</ul>
						</div>
					</li>
					<li class="semplice-revisions">
						<a class="editor-action has-tooltip cursor-pointer icon-button" data-action="revisionsDropdown" data-action-type="helper">
							<?php echo get_svg('backend', '/icons/revisions'); ?>
						</a>
						<div class="tooltip">Versions</div>
						<div class="revisions-dropdown">
							<h3 class="revisions-heading">Versions</h3>
							<ul class="revisions-list"></ul>
							<div class="update-button">
								<a class="editor-action semplice-button" data-action="addRevision" data-action-type="popup">Add Version</a>
							</div>
						</div>
					</li>
					<li>
						<a class="show-preview has-tooltip cursor-pointer" href="" target="_blank">
							<?php echo get_svg('backend', '/icons/preview'); ?>
						</a>
						<div class="tooltip">Show Preview</div>
					</li>
					<li class="publish-button">
						<a class="text-link editor-action" data-action="publishDropdown" data-action-type="helper">Publish</a>
						<div class="pb-loader-spinner">
							<svg class="semplice-spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
								<circle class="path" fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
							</svg>
						</div>
						<div class="publish-dropdown" data-state="draft">
							<h3><span>Status </span><span class="status">Draft</span></h3>
							<div class="option">
								<div class="option-inner post-password-option">
										<div class="attribute">
												<h4>Password protect</h4>
												<input type="text" name="post-password" placeholder="Leave empty if not needed">
										</div>
								</div>
							</div>
							<div class="update-button">
								<a class="editor-action semplice-button switch-to-draft" data-action="post" data-action-type="save" data-save-mode="draft" data-change-status="yes">Switch to draft</a>
								<a class="editor-action semplice-button publish-button" data-action="post" data-action-type="save" data-save-mode="publish" data-change-status="no">Update</a>
							</div>
						</div>
						<div id="unpublished-changes"></div>
					</li>
					<li>
						<?php
							global $admin_api;
							echo semplice_ajax_save_button('<a class="ajax-save-button editor-save text-link editor-action" data-action="post" data-action-type="save" data-save-mode="draft" data-change-status="no">');
						?>
					</li>
					<li>
						<a class="editor-action save-exit" data-action="saveAndExitDropdown" data-action-type="helper"><?php echo get_svg('backend', '/icons/save_and_exit'); ?></a>
						<ul class="save-exit-dropdown">
							<li><a class="editor-action confirm" data-action="postAndExit" data-action-type="save" data-exit-mode="close" data-post-type="page" data-reopen="undefined" data-new-url="undefined">Save &amp; Exit</a></li>
							<li><a class="editor-action cancel" data-action="exit" data-action-type="main" data-exit-mode="close" data-post-type="page" data-reopen="undefined" data-new-url="undefined">Exit without saving</a>
						</ul>
					</li>
			</div>
	</header>
	
	<!-- editor content -->
	<div id="editor-content" data-ep-init="" data-active-wysiwyg="" data-wysiwyg-type="">
		<!-- edit popups -->
		<div id="edit-popup"></div>
		<div id="content-holder"><!-- holder --></div>
	</div>

	<!-- navigator -->
	<div id="semplice-navigator" class="editor-sidebar semplice-navigator-hover">
		<?php 
			// get editor api
			global $editor_api;
			// output navigator
			echo $editor_api->navigator(); 
		?>
	</div>

	<!-- modules -->
	<div id="semplice-modules" class="editor-sidebar">
		<?php echo semplice_get_modules(); ?>
	</div>

	<!-- blocks -->
	<div id="semplice-blocks" class="editor-sidebar">
		<?php
			// include blocks
			global $editor_api;
			// output list
			echo $editor_api->blocks->list_blocks();
		?>
	</div>

	<!-- wysiwyg toolbar -->
	<div id="wysiwyg-toolbar"></div>

	<!-- animate toolbar -->
	<div id="animate-toolbar">
		<div class="motions-mode"><span><?php echo get_svg('backend', '/icons/animate_topbar'); ?></span></div>
		<div class="animate-ba-wrapper">
			<a class="animate-link animate-batch-link editor-action" data-action="animateDropdown" data-action-type="helper">Bulk Apply</a>
			<div class="animate-dropdown">
				<div class="option">
					<div class="option-inner">
						<div class="attribute">
							<div class="is-checkbox">
								<h4>Preset type</h4>
								<div class="option-switch">
									<ul class="twoway">
										<li class="bulk-preset-type-premade active">
											<a class="admin-click-handler" data-handler="toggleAnimatePresets" data-name="animate_bulk_type" data-switch-val="premade" data-input-type="switch" switch-type="twoway">Premade</a>
										</li>
										<li class="bulk-preset-type-custom">
											<a class="admin-click-handler" data-handler="toggleAnimatePresets" data-name="animate_bulk_type" data-switch-val="custom" data-input-type="switch" switch-type="twoway">Custom</a>
										</li>
										<input class="editor-listen animate-bulk-type" data-handler="toggleAnimatePresets" type="hidden" name="animate_bulk_type" value="premade" data-input-type="switch" switch-type="twoway">
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="option">
					<div class="option-inner">
						<div class="attribute span4">
							<h4>Element Trigger</h4>
							<div class="select-box">
								<div class="sb-arrow"></div>
								<select name="animate_bulk_trigger" data-input-type="select-box" class="admin-click-handler animate-bulk-trigger" data-handler="toggleAnimatePresets">
									<option value="on_load" selected="">When in view</option>
									<option value="on_hover">Mouseover</option>
									<option value="on_click">Click (Tap)</option>
									<option value="on_scroll">Scrolling in view</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="option">
					<div class="option-inner">
						<div class="attribute span4">
							<h4>Preset</h4>
							<div class="select-box">
								<div class="sb-arrow"></div>
								<select name="animate_preset" data-input-type="select-box" class="animate-bulk-dropdown">
									<option value="enabled" selected="">Select Page or Project</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="option">
					<div class="option-inner">
						<div class="attribute span4">
							<h4>Apply To</h4>
							<div class="select-box">
								<div class="sb-arrow"></div>
								<select name="animate_bulk_content_type" data-input-type="select-box" class="animate-content-type">
									<option value="section" selected="">Section</option>
									<option value="column">Column</option>
									<option value="content">Content</option>
									<option value="text">Text module</option>
									<option value="paragraph">Paragraph module</option>
									<option value="image">Image module</option>
									<option value="video">Video module</option>
									<option value="button">Button module</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="bulk-apply-button">
					<a class="editor-action semplice-button" data-action="bulkApplyPreset" data-action-type="popup">Apply Presets</a>
				</div>
			</div>
		</div>
		<a class="animate-link reset-animations">Reset Animations</a>
		<a class="animate-link animate-preview editor-action" data-action-type="animate" data-action="prepareFullPreview">Preview All</a>		
		<a class="animate-link animate-exit editor-action" data-action-type="animate" data-action="exit"></a>
		<div class="preview-overlay">
			<a class="animate-link animate-exit-preview editor-action" data-action-type="animate" data-action="fullPreviewExit">
				Exit Preview
				<svg class="semplice-spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
					<circle class="path" fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
				</svg>
			</a>
			<div class="preview-scrollbar"><div class="bar-empty"></div><div class="bar-filled"></div></div>
		</div>
	</div>

	<!-- animate markers -->
	<div id="animate-markers" data-is-pinned="false">
		<div class="animate-trigger-markers">
			<div class="marker-position start-trigger-position"><div class="animate-marker animate-start_trigger" data-trigger="start_trigger" data-type="trigger"><span class="trigger-label">Start Trigger</span><span class="marker-percent"></span></div></div>
			<div class="marker-position end-trigger-position"><div class="animate-marker animate-end_trigger" data-trigger="end_trigger" data-type="trigger"><span class="trigger-label">End Trigger</span><span class="marker-percent"></span></div></div>
		</div>
		<div class="animate-scroller-markers">
			<div class="marker-position start-scroller-position"><div class="animate-marker animate-start_scroller" data-trigger="start_scroller" data-type="scroller">Start Point<span class="marker-percent"></span></div></div>
			<div class="marker-position end-scroller-position"><div class="animate-marker animate-end_scroller" data-trigger="end_scroller" data-type="scroller">End Point<span class="marker-percent"></span></div></div>
		</div>
	</div>

	<!-- re-order and undo / redo -->
	<div id="semplice-tools">
		<div class="semplice-tools-reorder">
			<a class="editor-action reorder" data-handler="execute" data-action-type="helper" data-action="reOrder" data-mode="section"><?php echo get_svg('backend', '/icons/reorder'); ?></a>
			<div class="tooltip">Re-Order</div>
		</div>
		<div class="semplice-tools-motions">
			<a class="editor-action animate-init" data-handler="execute" data-action-type="animate" data-action="init"><?php echo get_svg('backend', '/icons/animate_switch'); ?></a>
			<div class="tooltip">Animations</div>
		</div>
		<div class="semplice-tools-undo">
			<a class="semplice-history semplice-undo disabled" data-state="undo"></a>
			<a class="semplice-history semplice-redo disabled" data-state="redo"></a>
			<div class="tooltip">Undo/Redo</div>
		</div>
	</div>

	<!-- motions notice -->
	<div id="motion-notice">
		<div class="inner">
			<img src="<?php echo get_template_directory_uri() . '/assets/images/admin/motion_notice.svg'; ?>">
			<p class="title">Custom Animations</p>
			<p class="desc">Motion options now live here. Click to open the Animations editor, then select the element you'd like to animate.</p>
			<a class="editor-action" data-handler="execute" data-action-type="helper" data-action="editorNotice" data-notice-id="motions">Got it!</a>
		</div>
	</div>

	<!-- coverslider open popup-->
	<div id="cs-open-popup">
		<a class="editor-action open" data-handler="execute" data-action-type="coverslider" data-action="editPopup"><?php echo get_svg('backend', '/icons/coverslider_edit'); ?></a>
		<div class="tooltip">Edit Coverslider</div>
	</div>

	<!-- published notice -->
	<div class="published-notice">
		<div class="pn-icon"><?php echo get_svg('backend', '/icons/dashboard_uptodate'); ?></div>
		<h3>Your <span class="post-type">post</span> has been<br />published.</h3>
		<div class="pn-button">
			<a class="semplice-button" href="#" target="_blank">See it Live</a>
		</div>
	</div>
	
	<!-- editor templates -->
	<?php require get_template_directory() . '/admin/editor/templates.php'; ?>

</div>