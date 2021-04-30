<!-- add new post -->
<script id="add-post-template" type="text/template">
	<div id="semplice-add-post" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<h3>Add new {{postType}}</h3>
				{{options}}
			</div>
			<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler semplice-button add-post-button" data-handler="execute" data-action="savePost" data-action-type="main" data-post-type="{{postType}}">Add</a>
			</div>
		</div>
	</div>
</script>
<!-- add new post options -->
<script id="add-post-page-template" type="text/template">
	<div class="option">
		<div class="option-inner">
			<div class="attribute span4-popup">
				<h4>Title</h4>
				<input type="text" placeholder="Page title" name="post-title" class="is-meta">
			</div>
		</div>
	</div>
	<div class="option">
		<div class="option-inner">
			<div class="attribute span4-popup">
				<div class="is-checkbox">
					<h4>Content Type</h4>
					<div class="option-switch">
						<ul class="twoway page-type-switch">
							<li class="active">
								<a class="admin-click-handler" data-handler="switchChange" data-name="content_type" data-switch-val="page" data-input-type="switch" switch-type="twoway">Page</a>
							</li>
							<li>
								<a class="admin-click-handler" data-handler="switchChange" data-name="content_type" data-switch-val="coverslider" data-input-type="switch" switch-type="twoway">Coverslider</a>
							</li>
							<input class="is-meta" type="hidden" name="content_type" data-input-type="switch" switch-type="twoway">
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="option">
		<div class="option-inner">
			<div class="attribute span4-popup">
				<div class="is-checkbox">
					<h4>Add page to menu</h4>
					<div class="option-switch">
						<ul class="twoway">
							<li class="active">
								<a class="admin-click-handler" data-handler="switchChange" data-name="add_to_menu" data-switch-val="no" data-input-type="switch" switch-type="twoway">No</a>
							</li>
							<li>
								<a class="admin-click-handler" data-handler="switchChange" data-name="add_to_menu" data-switch-val="yes" data-input-type="switch" switch-type="twoway">Yes</a>
							</li>
							<input class="is-meta" type="hidden" name="add_to_menu" data-input-type="switch" switch-type="twoway">
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
<!-- add footer -->
<script id="add-post-footer-template" type="text/template">
	<div class="option">
		<div class="option-inner">
			<div class="attribute span4-popup">
				<h4>Title</h4>
				<input type="text" placeholder="Footer title" name="post-title" class="is-meta">
			</div>
		</div>
	</div>
</script>
<!-- add project -->
<script id="add-post-project-template" type="text/template">
	<div class="option">
		<div class="option-inner">
			<div class="attribute span4-popup">
				<h4>Title</h4>
				<input type="text" placeholder="Project title" name="post-title" class="is-meta">
			</div>
		</div>
		<div class="option-inner">
			<div class="attribute span4-popup">
				<h4>Type</h4>
				<input type="text" placeholder="Corporate Design" name="project-type" class="is-meta">
			</div>
		</div>
		<div class="option-inner">
			<div class="attribute span4-popup">
				<h4>Thumbnail</h4>
				<div class="media-upload-box onboarding-upload-box">
					<a class="semplice-button white-button admin-click-handler new-project-thumb" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="image" data-upload="newProjectThumb" name="new-project-thumb">Add project thumbnail</a>
					<input type="hidden" name="project-thumbnail" class="is-meta" value="">
				</div>
			</div>
		</div>
	</div>
</script>