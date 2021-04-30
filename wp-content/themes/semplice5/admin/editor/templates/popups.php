<!-- exit popup -->
<script id="exit-template" type="text/template">
<div id="semplice-exit" class="popup">
	<div class="popup-inner">
		<div class="popup-close admin-click-handler" data-handler="hidePopup">
			<?php echo get_svg('backend', '/icons/popup_close'); ?>
		</div>
		<div class="popup-content">
			<div class="important">
				<?php echo get_svg('backend', '/icons/popup_important'); ?>
			</div>
			<h3>Unsaved Changes</h3>
			<p>Do you want to save your progress before continuing?</p>
		</div>
		<div class="popup-footer">
			<a class="editor-action cancel" data-action="exit" data-action-type="main" data-exit-mode="close" data-post-type="{{postType}}" data-reopen="{{reOpenUrl}}" data-new-url="{{newUrl}}">Don't Save</a>
			<a class="editor-action confirm semplice-button" data-action="postAndExit" data-action-type="save" data-exit-mode="close" data-post-type="{{postType}}" data-reopen="{{reOpenUrl}}" data-new-url="{{newUrl}}">Save &amp; Exit</a>
		</div>					
	</div>
</div>
</script>
<!-- delete popup -->
<script id="delete-template" type="text/template">
<div id="semplice-delete" class="popup">
	<div class="popup-inner">
		<div class="popup-close admin-click-handler" data-handler="hidePopup">
			<?php echo get_svg('backend', '/icons/popup_close'); ?>
		</div>
		<div class="popup-content">
			<div class="important">
				<?php echo get_svg('backend', '/icons/popup_important'); ?>
			</div>
			<h3>Delete {{action}}</h3>
			<p>Are you sure you want to delete this {{action}}?</p>
		</div>
		<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button delete-button" data-action="{{action}}" data-action-type="delete" data-id="{{id}}">Delete</a>
		</div>					
	</div>
</div>
</script>
<!-- reset changes popup -->
<script id="reset-changes-template" type="text/template">
	<div id="breakpoint-reset-changes" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Are you sure?</h3>
				<p>This will reset all changes made to the section in this breakpoint. This includes styles, options and content. (for example customized paragraphs)</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button" data-action="resetChanges" data-action-type="helper" data-content-id="{{id}}">Reset Changes</a>
			</div>					
		</div>
	</div>
</script>
<!-- copy styles popup -->
<script id="copy-styles-template" type="text/template">
	<div id="breakpoint-copy-styles" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Are you sure?</h3>
				<p>This will reset all changes made to the section in this breakpoint. This includes styles, options and content. (for example customized paragraphs)</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button" data-action="copyStyles" data-action-type="helper" data-content-id="{{id}}" data-val="{{val}}">Copy Styles</a>
			</div>					
		</div>
	</div>
</script>
<!-- save block popup -->
<script id="save-block-template" type="text/template">
	<div id="save-block" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<h3>Save section as block</h3>
				<p class="block-notice">If you choose Master block, any changes you make to your block will be applied everywhere you use that block. Learn more <a class="masterblock-guide" href="https://help.semplice.com/hc/en-us/articles/360033776971" target="_blank">here</a>.</p>
				<div class="option">
					<div class="option-inner">
						<div class="attribute span4-popup">
							<h4>Block Name</h4>
							<input type="text" placeholder="Block Name" name="block-name">
						</div>
					</div>
				</div>
				<div class="option">
					<div class="option-inner">
						<div class="attribute span4-popup">
							<div class="is-checkbox">
								<h4>Block Type</h4>
								<div class="option-switch">
									<ul class="twoway block-type-switch">
										<li class="active">
											<a class="admin-click-handler" data-handler="switchChange" data-name="block-type" data-switch-val="normal" data-input-type="switch" switch-type="twoway">Normal</a>
										</li>
										<li>
											<a class="admin-click-handler" data-handler="switchChange" data-name="block-type" data-switch-val="master" data-input-type="switch" switch-type="twoway">Master</a>
										</li>
										<input class="is-meta" type="hidden" name="block-type" data-input-type="switch" switch-type="twoway">
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action semplice-button save-block-button" data-action="save" data-action-type="blocks" data-content-id="{{id}}">Save</a>
			</div>
		</div>
	</div>
</script>
<!-- delete block popup -->
<script id="delete-block-template" type="text/template">
	<div id="semplice-delete-block" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Delete block</h3>
				<p>Are you sure you want to delete this block?<br />There is no undo for this action.</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button delete-button" data-action="delete" data-action-type="blocks" data-block-id="{{id}}" data-masterblock-id="{{masterblock}}">Delete</a>
			</div>					
		</div>
	</div>
</script>
<!-- delete master block -->
<script id="delete-masterblock-template" type="text/template">
	<div id="semplice-delete-masterblock" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Delete Masterblock</h3>
				<p>Please note that if you delete a Masterblock it will also remove the block from every page or project that uses this block. There is no undo for this action.<br /><br />Are you sure?</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button delete-button" data-action="delete" data-action-type="blocks" data-block-id="{{id}}" data-masterblock-id="{{masterblock}}">Delete</a>
			</div>					
		</div>
	</div>
</script>
<!-- dribbble popup -->
<script id="dribbble-popup-template" type="text/template">
	<div id="dribbble-token" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<h3>Connect Dribbble</h3>
				<div class="option">			
					<div class="option-inner">
						<div class="attribute span4-popup">
							<h4>Username</h4>
							<input type="text" placeholder="Username" name="dribbble-id">
						</div>
					</div>
				</div>
				<div class="option">
					<div class="option-inner">
						<div class="attribute span4-popup">
							<h4>Token</h4>
							<input type="text" placeholder="Access Token" name="dribbble-token">
						</div>
					</div>
				</div>
			</div>
			<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action semplice-button save-block-button" data-action="dribbbleToken" data-action-type="save" data-content-id="{{id}}">Save</a>
			</div>
		</div>
	</div>
</script>
<!-- import cover popup -->
<script id="import-cover-template" type="text/template">
	<div id="semplice-import-cover" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Import Cover</h3>
				<p>This will overwrite your existing cover. Are you sure?</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button" data-action-type="helper" data-action="importCover" data-post-id="{{postId}}">Import</a>
			</div>					
		</div>
	</div>
</script>
<!-- reset cover popup -->
<script id="reset-cover-template" type="text/template">
	<div id="semplice-reset-cover" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Reset Cover</h3>
				<p>Are you sure you want to reset your cover?</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button delete-button" data-action-type="helper" data-action="resetCover">Reset</a>
			</div>					
		</div>
	</div>
</script>
<!-- footer rename popup -->
<script id="footer-settings-template" type="text/template">
	<div id="semplice-footer-settings" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<h3>Footer settings</h3>
				<div class="option">
					<div class="option-inner">
						<div class="attribute span4-popup">
							<h4>Title</h4>
							<input type="text" placeholder="Footer title" name="title" class="is-footer-setting" value="{{title}}">
						</div>
					</div>
				</div>
			</div>
			<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action semplice-button add-post-button" data-handler="execute" data-action="footerTitle" data-action-type="save" data-post-id="{{id}}">Save</a>
			</div>
		</div>
	</div>
</script>
<!-- reset animations -->
<script id="reset-animations-template" type="text/template">
	<div id="reset-animations" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Reset Custom Animations</h3>
				<p>Are you sure you want to remove all custom animations for this page or project?</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button" data-handler="execute" data-action-type="animate" data-action="resetAll">Reset Animations</a>
			</div>					
		</div>
	</div>
</script>
<!-- editor notice -->
<script id="editor-notice-template" type="text/template">
	<div id="editor-notice" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>{{title}}</h3>
				<p>{{notice}}</p>
			</div>
			<div class="popup-footer">
			<a class="editor-action confirm semplice-button" data-handler="execute" data-action-type="helper" data-action="editorNotice" data-notice-id="{{noticeId}}">Ok fine</a>
			</div>					
		</div>
	</div>
</script>
<!-- save revision template -->
<script id="add-revision-template" type="text/template">
	<div id="semplice-save-revision" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<h3>Add Version</h3>
				<p class="revision-notice">Give your version a memorable title.<br />Example: "Blue Header Version"</p>
				<div class="option">
					<div class="option-inner">
						<div class="attribute span4-popup">
							<input type="text" placeholder="Version Title" name="revision-title">
						</div>
					</div>
				</div>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button" data-action-type="revisions" data-action="add" data-revision-id="{{revisionId}}">Save Version</a>
			</div>					
		</div>
	</div>
</script>
<!-- rename revision template -->
<script id="rename-revision-template" type="text/template">
	<div id="semplice-rename-revision" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<h3>Rename Version</h3>
				<div class="option">
					<div class="option-inner">
						<div class="attribute span4-popup">
							<input type="text" placeholder="Version Title" name="revision-title">
						</div>
					</div>
				</div>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button" data-action-type="revisions" data-action="rename" data-revision-id="{{revisionId}}">Rename Version</a>
			</div>					
		</div>
	</div>
</script>
<!-- delete revision -->
<script id="delete-revision-template" type="text/template">
	<div id="delete-revision" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Delete Version</h3>
				<p>Are you sure you want to delete this version?</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button delete-button" data-handler="execute" data-action-type="revisions" data-action="delete" data-revision-id="{{revisionId}}">Delete Version</a>
			</div>					
		</div>
	</div>
</script>
<!-- delete animation -->
<script id="delete-animation-template" type="text/template">
	<div id="delete-animation" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Delete Animation</h3>
				<p>This will delete the timeline for this {{mode}}. Are you sure?</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action confirm semplice-button delete-button" data-handler="execute" data-action-type="animate" data-action="deleteAnimation" data-id="{{id}}">Delete Animation</a>
			</div>					
		</div>
	</div>
</script>
<!-- save animate preset popup -->
<script id="save-animate-preset-template" type="text/template">
	<div id="save-animate-preset" class="popup keep-popup-alive">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<h3>Save as preset</h3>
				<p class="block-notice">This will save your animation in a custom preset.</p>
				<div class="option">
					<div class="option-inner">
						<div class="attribute span4-popup">
							<h4>Preset Name</h4>
							<input type="text" placeholder="Preset Name" name="preset-name">
						</div>
					</div>
				</div>
			</div>
			<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action semplice-button save-animate-preset-button" data-action="savePreset" data-action-type="animate" data-content-id="{{id}}">Save</a>
			</div>
		</div>
	</div>
</script>
<!-- remove animate preset popup -->
<script id="remove-animate-preset-template" type="text/template">
	<div id="remove-animate-preset" class="popup keep-popup-alive">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Delete global preset</h3>
				<p class="block-notice">Are you sure you want to delete this global preset? All animations that uses this preset will be no longer connected to it.</p>
			</div>
			<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action semplice-button delete-button" data-action="removePreset" data-action-type="animate" data-preset="{{presetId}}" data-id="{{id}}">Delete</a>
			</div>
		</div>
	</div>
</script>
<!-- batch animate preset popup -->
<script id="batch-animate-preset-template" type="text/template">
	<div id="batch-animate-preset" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Bulk Apply Preset</h3>
				<p class="block-notice">Are you sure you want to overwrite all {{type}} animations with the selected preset?</p>
			</div>
			<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action semplice-button" data-action="batch" data-action-type="animate">Apply presets</a>
			</div>
		</div>
	</div>
</script>
<!-- activate animations -->
<script id="activate-motions-preset-template" type="text/template">
	<div id="activate-motions" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Custom Animations</h3>
				<p class="block-notice">By default, your content fades in on scroll. Enabling custom animations will disable scroll reveal on this page. To reenable scroll reveal, go to your <b>Look & Feel</b> settings.</p>
			</div>
			<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="editor-action semplice-button" data-action="activateMotions" data-action-type="animate">Use Custom Animations</a>
			</div>
		</div>
	</div>
</script>