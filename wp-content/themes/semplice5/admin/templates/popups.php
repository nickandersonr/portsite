<!-- delete post popup -->
<script id="delete-post-template" type="text/template">
	<div id="semplice-delete" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Delete post</h3>
				<p>Are you sure you want to delete this post?</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler confirm semplice-button delete-button" data-handler="execute" data-action="deletePost" data-action-type="main" data-delete-id="{{postId}}" data-post-type="{{postType}}">Delete</a>
			</div>					
		</div>
	</div>
</script>
<!-- about -->
<script id="about-template" type="text/template">
	<div id="about-semplice" class="popup">
		<div class="popup-inner">
			<a class="admin-click-handler close-about" data-handler="hidePopup">Close</a>
			<div class="popup-content">
				<h3><?php echo get_svg('backend', '/adler_about'); ?></h3>
				<?php echo semplice_about(); ?>
			</div>				
		</div>
	</div>
</script>
<!-- enable transitions-->
<script id="enable-transitions-template" type="text/template">
	<div id="enable-transitions" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Enable Transitions</h3>
				<p>Transitions require your website to be set to 'Single Page App' mode. That means we can load new content without reloads.<br /><br /><span class="warning">Warning:</span> The 'Single Page App' mode is experimental. If you experience problems with plugins or anything else, you can always change this back under Settings.</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler confirm semplice-button" data-handler="execute" data-action-type="helper" data-action="enableTransitions">Activate Transitions</a>
			</div>					
		</div>
	</div>
</script>
<!-- grid sizes template-->
<script id="grid-sizes-template" type="text/template">
	<div id="grid-sizes-popup" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<h3>Grid Sizes</h3>
				<div class="grid-sizes">
					<div class="grid-sizes-row">
						<div class="grid-sizes-value">
							<p>
								<span class="title">Outer</span>
								<span class="val">{{containerWidth}}</span>
							</p>
						</div>
						<div class="grid-sizes-value">
							<p>
								<span class="title">Grid</span>
								<span class="val">{{gridWidth}}</span>
							</p>
						</div>
						<div class="grid-sizes-value">
							<p>
								<span class="title">Gutter</span>
								<span class="val">{{gutterWidth}}</span>
							</p>
						</div>
					</div>
					<div class="divider"></div>
					<div class="grid-sizes-row-big">
						<div class="grid-sizes-value">
							<p>
								<span class="title">1 Col</span>
								<span class="val">{{gridSize1}}</span>
							</p>
						</div>
						<div class="grid-sizes-value">
							<p>
								<span class="title">2 Col</span>
								<span class="val">{{gridSize2}}</span>
							</p>
						</div>
						<div class="grid-sizes-value">
							<p>
								<span class="title">3 Col</span>
								<span class="val">{{gridSize3}}</span>
							</p>
						</div>
						<div class="grid-sizes-value">
							<p>
								<span class="title">4 Col</span>
								<span class="val">{{gridSize4}}</span>
							</p>
						</div>
					</div>
					<div class="grid-sizes-row-big">
						<div class="grid-sizes-value">
							<p>
								<span class="title">5 Col</span>
								<span class="val">{{gridSize5}}</span>
							</p>
						</div>
						<div class="grid-sizes-value">
							<p>
								<span class="title">6 Col</span>
								<span class="val">{{gridSize6}}</span>
							</p>
						</div>
						<div class="grid-sizes-value">
							<p>
								<span class="title">7 Col</span>
								<span class="val">{{gridSize7}}</span>
							</p>
						</div>
						<div class="grid-sizes-value">
							<p>
								<span class="title">8 Col</span>
								<span class="val">{{gridSize8}}</span>
							</p>
						</div>
					</div>
					<div class="grid-sizes-row-big">
						<div class="grid-sizes-value">
							<p>
								<span class="title">9 Col</span>
								<span class="val">{{gridSize9}}</span>
							</p>
						</div>
						<div class="grid-sizes-value">
							<p>
								<span class="title">10 Col</span>
								<span class="val">{{gridSize10}}</span>
							</p>
						</div>
						<div class="grid-sizes-value">
							<p>
								<span class="title">11 Col</span>
								<span class="val">{{gridSize11}}</span>
							</p>
						</div>
						<div class="grid-sizes-value">
							<p>
								<span class="title">12 Col</span>
								<span class="val">{{gridSize12}}</span>
							</p>
						</div>
					</div>
					<div class="divider"></div>
					<p class="grid-sizes-info">The values above should be used for content like images, videos etc. If you have uneven values please change the grid or gutter size. All values are in pixel.</p>
				</div>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler confirm semplice-button" data-handler="execute" data-action-type="helper" data-action="enableTransitions">Continue Editing</a>
			</div>					
		</div>
	</div>
</script>
<!-- delete custom style -->
<script id="delete-custom-style-template" type="text/template">
	<div id="delete-custom-style" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Delete Style</h3>
				<p>Are you sure you want to delete this custom style?</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler confirm semplice-button delete-button" data-handler="deleteCustomStyle" data-custom-id="{{id}}">Delete Style</a>
			</div>					
		</div>
	</div>
</script>
<!-- add sml folder -->
<script id="sml-add-folder-template" type="text/template">
	<div id="sml-folder" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hideSmlPopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<h3>Add Folder</h3>
				<p class="revision-notice">Please enter a name for your new folder.</p>
				<div class="option">
					<div class="option-inner">
						<div class="attribute span4-popup">
							<input type="text" placeholder="My Folder" name="folder-title">
						</div>
					</div>
				</div>
			</div>
			<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hideSmlPopup">Cancel</a><a class="admin-click-handler confirm semplice-button" data-handler="execute" data-action-type="mediaLibrary" data-action="addFolder">Add Folder</a>
			</div>					
		</div>
	</div>
</script>
<!-- sml rename folder -->
<script id="sml-rename-folder-template" type="text/template">
	<div id="sml-rename-folder" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hideSmlPopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<h3>Rename Folder</h3>
				<p class="revision-notice">Choose a new name for your folder.</p>
				<div class="option">
					<div class="option-inner">
						<div class="attribute span4-popup">
							<input type="text" placeholder="My Folder" name="folder-title" value="{{folderName}}">
						</div>
					</div>
				</div>
			</div>
			<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hideSmlPopup">Cancel</a><a class="admin-click-handler confirm semplice-button" data-handler="execute" data-action-type="mediaLibrary" data-action="renameFolder" data-folder-id="{{folderId}}">Rename Folder</a>
			</div>					
		</div>
	</div>
</script>
<!-- sml delete attachment popup -->
<script id="sml-delete-attachment-template" type="text/template">
	<div id="sml-delete-attachment" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hideSmlPopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Delete File(s)</h3>
				<p>Selected items will be permanently deleted from your site. This action can't be undone. Are you sure?</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hideSmlPopup">Cancel</a><a class="admin-click-handler confirm semplice-button delete-button" data-handler="execute" data-action="delete" data-action-type="mediaLibrary">Delete</a>
			</div>					
		</div>
	</div>
</script>
<!-- sml delete folder popup -->
<script id="sml-delete-folder-template" type="text/template">
	<div id="sml-delete-folder" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hideSmlPopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Delete Folder</h3>
				<p>This will delete your folder, not your files.<br />All files will get moved to 'Unsorted'.</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hideSmlPopup">Cancel</a><a class="admin-click-handler confirm semplice-button delete-button" data-handler="execute" data-action="deleteFolder" data-action-type="mediaLibrary" data-folder-id="{{folderId}}">Delete</a>
			</div>					
		</div>
	</div>
</script>
<script id="delete-webfont-template" type="text/template">
	<div id="semplice-delete" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Delete {{type}}</h3>
				<p>Are you sure you want to delete this {{type}}?{{notes}}</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler confirm semplice-button delete-button" data-handler="execute" data-action="{{action}}" data-action-type="customize" data-setting-type="webfonts" data-delete-id="{{id}}">Delete</a>
			</div>					
		</div>
	</div>
</script>
<script id="delete-variable-style-template" type="text/template">
	<div id="semplice-delete" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Delete variable style</h3>
				<p>Are you sure you want to delete this style?</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler confirm semplice-button delete-button" data-handler="execute" data-action="removeVariableStyle" data-action-type="customize" data-setting-type="webfonts" data-font-id="{{id}}" data-style-id="{{styleId}}">Delete</a>
			</div>					
		</div>
	</div>
</script>
<!-- webfont change hostname -->
<script id="hostchange-webfont-template" type="text/template">
	<div id="host-change-webfontr" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<h3>Update Domain</h3>
				<p class="revision-notice">It looks like the domain for your uploaded webfonts doesn't match your website domain.<br /><br /><b>Old Domain:</b> {{oldDomain}}<br/><b>New Domain:</b> {{newDomain}}</p>
			</div>
			<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler confirm semplice-button" data-handler="execute" data-action="hostChange" data-action-type="customize" data-setting-type="webfonts" data-res-id="{{id}}">Update domain</a>
			</div>					
		</div>
	</div>
</script>
<script id="studio-feature-gallerygrid-template" type="text/template">
	<?php echo semplice_studio_popup('gallerygrid', 'Show off your work with grids and image galleries', 'Choose from a range of customizable grids and gallery sliders to showcase your work and photos.'); ?>
</script>
<script id="studio-feature-advancedportfoliogrid-template" type="text/template">
	<?php echo semplice_studio_popup('advancedportfoliogrid', 'Present your projects in a bold, interactive way', 'Unlock the Advanced Portfolio Grid module, giving you even more visual ways to show off your work.'); ?>
</script>
<script id="studio-feature-instagram-template" type="text/template">
	<?php echo semplice_studio_popup('instagram', 'Add your live Instagram feed to your page', 'Upgrade to unlock the Instagram module and add your latest Instagram shots anywhere on your site.'); ?>
</script>
<script id="studio-feature-mailchimp-template" type="text/template">
	<?php echo semplice_studio_popup('mailchimp', 'Collect email addresses for your newsletter', 'Unlock the Mailchimp module, so people can sign up for your witty emails straight from your site.'); ?>
</script>
<script id="studio-feature-blocks-template" type="text/template">
	<?php echo semplice_studio_popup('blocks', 'Save individual content elements as templates', 'Use our pre-defined layout or create your own blocks and re-use them wherever you need.'); ?>
</script>
<script id="studio-feature-navigations-template" type="text/template">
	<?php echo semplice_studio_popup('navigations', 'Get more navigations', 'Studio unlocks more navs, including a four-corner menu, split menu, stacked logo option and more. All navigations can be customized for your full site or individually branded pages.'); ?>
</script>
<script id="studio-feature-beforeafter-template" type="text/template">
	<?php echo semplice_studio_popup('beforeafter', 'Show before/after comparisons of your work', 'Get the Before/After module to share your process or the impact of your work with a sliding visual comparison. Only with Studio edition.'); ?>
</script>
<script id="activate-studio-template" type="text/template">
	<div class="popup-content">
		<div class="popup-close admin-click-handler" data-handler="hidePopup">
			<?php echo get_svg('backend', '/icons/popup_close'); ?>
		</div>
		<div class="important">
			<?php echo get_svg('backend', '/icons/dashboard_uptodate'); ?>
		</div>
		<h3>How to activate Studio</h3>
		<p>After you purchased the Studio Edition, you will receive an email with a new license key which you need to enable your new Studio Edition.</p>
	</div>
	<div class="popup-footer">
	<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler confirm semplice-button" href="#settings/license">License Settings</a>
	</div>					
</script>