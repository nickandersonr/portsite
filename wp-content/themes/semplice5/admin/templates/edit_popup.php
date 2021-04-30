<!-- edit popup template -->
<script id="admin-edit-popup-template" type="text/template">
	<div class="color-picker-holder"></div>
	<div class="ep-content">
		<div class="inner">
			<div class="handlebar"><div class="handlebar-inner"><!-- draggable handle --></div></div>
			<div class="ep-options-wrapper">
				<div class="regular-options">
					<nav class="ep-tabs-nav">
						<ul>
							{{tabsNav}}
							<li><a class='close-edit-popup'><!-- close ep --></a></li>
						</ul>
					</nav>
					<div class="edit-popup-help"><div class="close-popup-notice" data-mode="help"><?php echo get_svg('backend', '/icons/ep_close_help'); ?></div><div class="content"></div></div>
					<div class="ep-tabs">
					</div>
				</div>
				<div class="ep-expand-options"></div>
			</div>
		</div>
	</div>
</script>
<!-- expanded options template -->
<script id="expand-options-template" type="text/template">
	<div class="head">
		<div class="back">
			<a class="hide-expand-options" data-expand-options="{{expandOptions}}" data-id="{{id}}"><?php echo get_svg('backend', '/icons/ep_back_arrow'); ?></a>
		</div>
		<div class="title">
			{{title}}
		</div>
		<div class="expand-save-button">
			<a class="close-edit-popup save-button" data-module="{{module}}" data-id="{{id}}"><!-- close ep options --></a>
		</div>
	</div>
	<div class="ep-expand-content">
		{{content}}
	</div>
</script>
<!-- ep posts -->
<script id="ep-post-template" type="text/template">
	<li class="ep-post" data-ep-post-id="{{postId}}">
		<div class="ep-post-inner">
			<div class="ep-post-meta ep-posts-expand">
				<div class="ep-posts-handle"></div>
				<div class="title">
					<p>{{postTitle}}</p>
				</div>
				<div class="ep-meta-right">
					<div class="ep-posts-remove ep-posts-icon admin-click-handler" data-handler="execute" data-action-type="epPosts" data-action="removePost" data-delete-id="{{postId}}" data-content-id="{{contentId}}"></div>
					<div class="ep-posts-icon ep-posts-expand-icon"></div>
				</div>
			</div>
			<div class="ep-post-options"></div>
		</div>
	</li>
</script>
<!-- ep add post dropdown -->
<script id="ep-add-post-dropdown-template" type="text/template">	
	<div class="ep-posts-dropdown">
		<div class="ep-posts-close admin-click-handler" data-handler="execute" data-action-type="epPosts" data-action="hideAddPostDropdown"><?php echo get_svg('backend', '/icons/ep_close_help'); ?></div>
		<div class="ep-posts-input"><input class="ep-posts-search" type="text" placeholder="Search for pages or projects"></div>
		<ul>{{content}}</ul>
	</div>
</script>
<!-- ep posts add -->
<script id="ep-add-post-template" type="text/template">
	<li class="ep-add-post" data-ep-post-id="{{postId}}" data-post-title="{{postTitleLowerCase}}" data-content-id="{{contentId}}">
		<div class="ap-add-meta">
			<div class="title">
				<p>{{postTitle}}</p>
			</div>
			<div class="ep-posts-add"></div>
		</div>
	</li>
</script>
<!-- ep posts options -->
<script id="ep-post-options-template" type="text/template">
	<div class="option">
		<div class="thumbnail option-inner">
			<div class="attribute span4">
				<h4>Custom Thumbnail</h4>
				<div class="media-upload-box ep-posts-upload-box" data-upload-box="{{contentId}}">
					<a class="semplice-button white-button admin-click-handler ep-thumb-upload" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="image" data-media-type="image" data-upload="epPostThumbnail" name="post_thumbnail" data-content-id="{{contentId}}" data-post-id="{{postId}}">{{imageSrc}}</a>
					<a class="admin-click-handler remove-media" data-handler="execute" data-action="image" data-action-type="delete" data-content-id="{{contentId}}" name="post_thumbnail" data-post-id="{{postId}}"><?php echo get_svg('backend', '/icons/icon_delete'); ?></a>
				</div>
			</div>
		</div>
	</div>
	<div class="option">
		<div class="option-inner">
			<div class="attribute span4">
				<h4>Classes</h4>
				<input type="text" name="post_custom_class" class="editor-listen" data-handler="epPostOptions" value="{{custom_class}}" placeholder="Classes" data-content-id="{{contentId}}" data-post-id="{{postId}}" data-input-type="text">
			</div>
		</div>
	</div>
</script>
<!-- social profile template -->
<script id="ep-sp-template" type="text/template">
	<li class="social-profile" data-social-profile="{{profile}}">
		<div class="ep-sp-inner">
			<div class="ep-sp-meta ep-sp-expand">
				<div class="ep-sp-handle"></div>
				<div class="title">
					<p>{{displayName}}</p>
				</div>
				<div class="ep-meta-right">
					<div class="ep-sp-remove ep-posts-icon editor-action" data-action-type="socialProfiles" data-action="removeProfile" data-delete-id="{{profile}}" data-content-id="{{contentId}}"></div>
					<div class="ep-posts-icon ep-posts-expand-icon"></div>
				</div>
			</div>
			<div class="ep-sp-options"></div>
		</div>
	</li>
</script>
<!-- sp add profile dropdown -->
<script id="ep-sp-add-profile-dropdown-template" type="text/template">	
	<div class="ep-sp-dropdown">
		<div class="ep-posts-close editor-action" data-action-type="socialProfiles" data-action="hideAddProfileDropdown"><?php echo get_svg('backend', '/icons/ep_close_help'); ?></div>
		<div class="ep-posts-input"><input class="ep-posts-search" type="text" placeholder="Search for profiles"></div>
		<ul>{{content}}</ul>
	</div>
</script>
<!-- sp add profile dropdown items -->
<script id="ep-sp-add-profile-dropdown-items-template" type="text/template">	
	<?php
		$profiles = semplice_get_social_profiles();
		// output
		$output = '';
		// iterate profiles
		foreach ($profiles as $profile_id => $profile) {
			$output .= '
				<li class="ep-sp-add-profile" data-profile="' . $profile_id . '" data-post-title="' . $profile_id . '" data-content-id="{{contentId}}" data-display-name="' . $profile['name'] . '">
					' . $profile['svg'] . '
					<div class="ap-add-meta">
						<div class="ep-posts-add"></div>
					</div>
				</li>
			';
		}
		// return
		echo $output;
	?>
</script>
<!-- ep social profiles options -->
<script id="ep-social-profile-options-template" type="text/template">
	<div class="option">
		<div class="option-inner">
			<div class="attribute span3">
				<h4 class="attr-title-no-margin">{{usernamePrefix}}</h4>
				<input type="text" name="profile_username" class="editor-listen" data-handler="socialProfileOptions" value="{{username}}" placeholder="{{usernamePrefix}}" data-content-id="{{contentId}}" data-profile="{{profile}}" data-input-type="text">
			</div>
		</div>
	</div>
	<div class="option">
		<div class="option-inner">
			<div class="attribute sp-color-option">
				<h4>Link</h4>
				<div class="cpt-holder">
					<div class="color-picker-toggle" data-picker-toggle="social_profile_color" style="background-color: {{color}};"></div>
				</div>
				<div class="wp-color">
					<input type="text" value="{{color}}" data-style-option="true" data-input-type="color" data-target="" class="color-picker admin-listen-handler" data-handler="colorPicker" data-picker="socialProfiles" data-css-attribute="color" data-option-type="option" data-real-attr="{{profile}}" name="social_profile_color" data-profile="{{profile}}" data-type="options" data-content-id="{{contentId}}" data-mode="content" data-unique-name="social_profile_color">
				</div>
			</div>
			<div class="attribute sp-color-option">
				<h4>Hover</h4>
				<div class="cpt-holder">
					<div class="color-picker-toggle" data-picker-toggle="social_profile_color_hover" style="background-color: {{hoverColor}};"></div>
				</div>
				<div class="wp-color">
					<input type="text" value="{{hoverColor}}" data-style-option="true" data-input-type="color" data-target="" class="color-picker admin-listen-handler" data-handler="colorPicker" data-picker="socialProfiles" data-css-attribute="color" data-option-type="option" data-real-attr="{{profile}}" name="social_profile_color_hover" data-profile="{{profile}}" data-type="options" data-content-id="{{contentId}}" data-mode="content" data-unique-name="social_profile_color_hover">
				</div>
			</div>
		</div>
	</div>
</script>
<!-- ep timeline intitial -->
<script id="ep-timeline-initial-template" type="text/template">
	<li>
		<div class="duration">0.0s</div>
		<div class="add-step-between editor-action{{addAfterInitial}}" data-expand-options="animate" data-action-type="animate" data-action="addStep" data-timeline-step="initial" data-content-id="{{id}}" data-module="{{module}}" data-mode="{{mode}}">+</div>
		<a class="expand-options admin-click-handler" data-expand-options="animate" data-timeline-step="initial" data-mode="initial" data-content-id="{{id}}"{{module}}>Initial State</a>
	</li>
</script>
<!-- ep timeline step -->
<script id="ep-timeline-step-template" type="text/template">
	<li data-ep-timeline-step="{{step}}">
		<div class="duration duration-step">{{durationTotal}}s</div>
		<div class="duration-animated">{{durationTotal}}s</div>
		<div class="add-step-between editor-action{{addBetween}}" data-expand-options="animate" data-action-type="animate" data-action="addStep" data-timeline-step="{{step}}" data-content-id="{{id}}" data-module="{{module}}" data-mode="{{mode}}">+</div>
		<a class="expand-options admin-click-handler" data-expand-options="animate" data-timeline-step="{{step}}" data-mode="{{mode}}" data-content-id="{{id}}"{{module}}>
			{{label}}
			<span class="delete-step editor-action" data-action-type="animate" data-action="deleteStep" data-timeline-step="{{step}}" data-content-id="{{id}}"></span>
		</a>
	</li>
</script>