<!-- page settings template -->
<script id="post-settings-template" type="text/template">
	<div id="post-settings">
		<div class="inner">
			<div class="ps-header">
				<nav>
					<ul>
						{{thumbnailNavTab}}
						<li><a class="ps-tab admin-click-handler" data-handler="psTabchange" data-ps-tab="ps-meta">Settings</a></li>
						<li><a class="ps-tab admin-click-handler" data-handler="psTabchange" data-ps-tab="ps-seo">SEO &amp; Share</a></li>
					</ul>
				</nav>
				<a class="admin-click-handler cancel" data-handler="execute" data-action-type="postSettings" data-action="save" data-save-action="close">Cancel</a>
				<a class="save-post-settings admin-click-handler" data-handler="execute" data-action-type="postSettings" data-action="save" data-save-action="save"><?php echo get_svg('backend', '/icons/post_settings_save'); ?></a>
			</div>
			<div class="ps-tabs">
				{{thumbnailTab}}
				<div id="ps-meta"><div class="tab-content"></div></div>
				<div id="ps-seo"><div class="tab-content"></div></div>
			</div>
		</div>
	</div>
</script>
<script id="post-settings-thumbnail-template" type="text/template"> 
	<div id="ps-thumbnail" class="{{thumbnailVisibility}}">
		<div class="empty-thumbnail">
			<div class="et-inner">
				<h4>Project thumbnails</h4>
				<p>Upload a thumbnail for your portfolio grid. After upload, you will have the option to add thumbnails for your Project Panel and your Next/Prev navigation.</p>
				<a class="semplice-button upload-thumbnail admin-click-handler" data-handler="execute" data-action-type="mediaLibrary" data-action="init" data-upload="thumbnail" data-media-type="thumbnail">Add Thumbnail</a>
			</div>
		</div>
		<div class="ps-thumbnail-preview">
			<img class="ps-thumbnail-preview-img" src="{{thumbnail}}">
			<div class="edit-image">
				<ul>
					<li><a class="admin-click-handler" data-handler="execute" data-action-type="mediaLibrary" data-action="init" data-upload="thumbnail" data-media-type="thumbnail"><?php echo get_svg('backend', '/icons/icon_edit'); ?></a></li>
					<li><a class="admin-click-handler" data-handler="execute" data-action="image" data-action-type="delete" name="thumbnail"><?php echo get_svg('backend', '/icons/icon_delete'); ?></a></li>
				</ul>
			</div>
		</div>
		<div class="ps-thumbnail-options" data-custom-hover="disabled">
			<div class="tab-content"></div>
		</div>
	</div>
</script>
<script id="post-settings-seo-template" type="text/template">
	<div class="options">
		<div class="option">
			<div class="option-heading seo-heading">
				<h3>SEO Settings</h3>
				<p class="description">Below you can change and optimize your SEO settings.<br />To change your titles and descriptions please click directly into the previews below.<br /><br />To change your SEO defaults, navigate to your WordPress dashboard<br />and click 'SEO' in the navigation. This will open the Yoast SEO plugin where you can edits.</p>
			</div>
		<div class="title-spacer"></div>
	</div>
	<div class="semplice-seo-snippets">
		<div class="google-preview">
			<p class="snippet-preview">Title and description</p>
			<div class="snippet-inner">
				<input type="text" placeholder="Title" value="{{seoTitle}}" data-input-type="input-text" class="ps-setting admin-listen-handler seo-title" data-handler="postSettings" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_title">
				<p class="page-slug">{{permalink}}<span class="slug-tip">Please change the url in the settings tab</span></p>
				<textarea rows="1" type="text" placeholder="Meta description" data-input-type="textarea" class="ps-setting admin-listen-handler meta-desc adaptive-textarea" data-handler="postSettings" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_metadesc">{{metaDesc}}</textarea>
			</div>
			
		</div>
		<div class="facebook-preview">
			<p class="snippet-preview">Facebook</p>
			<div class="snippet-inner">
				<div class="ce-dropzone general-dropzone">
					<div class="media-upload-box {{fbUploadVisibility}}">
						<div class="upload-button admin-click-handler" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="image" data-input-type="admin-image-upload" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_opengraph-image">
							<div class="image-note">1200px x 630px</div>
						</div>
						<div class="ep-upload-status"><?php echo get_svg('backend', '/progress_circle'); ?></div>
						<div class="image-preview-wrapper">
							<img class="image image-preview" src="{{facebookImage}}">
							<div class="edit-image">
								<ul>
									<li><a class="admin-click-handler" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="image" data-input-type="admin-image-upload" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_opengraph-image"><?php echo get_svg('backend', '/icons/icon_edit'); ?></a></li>
									<li><a class="admin-click-handler" data-handler="execute" data-action="image" data-action-type="delete" data-input-type="admin-image-upload" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_opengraph-image"><?php echo get_svg('backend', '/icons/icon_delete'); ?></a></li>
								</ul>
							</div>
						</div>
						<input type="hidden" data-input-type="admin-image-upload" class="ps-setting admin-listen-handler" data-handler="postSettings" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_opengraph-image">
					</div>
				</div>
				<div class="facebook-meta">
					<input type="text" placeholder="Facebook title" value="{{facebookTitle}}" data-input-type="input-text" class="ps-setting admin-listen-handler facebook-title" data-handler="postSettings" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_opengraph-title">
					<textarea rows="1" type="text" placeholder="Facebook description" data-input-type="textarea" class="ps-setting admin-listen-handler facebook-desc adaptive-textarea" data-handler="postSettings" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_opengraph-description">{{facebookDesc}}</textarea>
					<p class="facebook-url">{{facebookUrl}}</p>
				</div>
			</div>
		</div>
		<div class="twitter-preview">
			<p class="snippet-preview">Twitter</p>
			<div class="snippet-inner">
				<div class="ce-dropzone general-dropzone">
					<div class="media-upload-box {{twitterUploadVisibility}}">
						<div class="upload-button admin-click-handler" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="image" data-input-type="admin-image-upload" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_twitter-image">
							<div class="image-note image-note-twitter">1024px x 512px</div>
						</div>
						<div class="ep-upload-status"><?php echo get_svg('backend', '/progress_circle'); ?></div>
						<div class="image-preview-wrapper">
							<img class="image image-preview" src="{{twitterImage}}">
							<div class="edit-image">
								<ul>
									<li><a class="admin-click-handler" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="image" data-input-type="admin-image-upload" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_twitter-image"><?php echo get_svg('backend', '/icons/icon_edit'); ?></a></li>
									<li><a class="admin-click-handler" data-handler="execute" data-action="image" data-action-type="delete" data-input-type="admin-image-upload" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_twitter-image"><?php echo get_svg('backend', '/icons/icon_delete'); ?></a></li>
								</ul>
							</div>
						</div>
						<input type="hidden" data-input-type="admin-image-upload" class="ps-setting admin-listen-handler" data-handler="postSettings" data-upload="seo" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_twitter-image">
					</div>
				</div>
				<div class="twitter-meta">
					<input type="text" placeholder="twitter title" value="{{twitterTitle}}" data-input-type="input-text" class="ps-setting admin-listen-handler twitter-title" data-handler="postSettings" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_twitter-title">
					<textarea rows="1" type="text" placeholder="twitter description" data-input-type="textarea" class="ps-setting admin-listen-handler twitter-desc adaptive-textarea" data-handler="postSettings" data-ps-type="seo" data-option-type="post-settings" name="_yoast_wpseo_twitter-description">{{twitterDesc}}</textarea>
					<p class="twitter-url">{{twitterUrl}}</p>
				</div>
			</div>
		</div>
	</div>
</script>
<script id="post-settings-yoast-template" type="text/template">
	<div class="no-yoast">
		<h3>Please install Yoast SEO</h3>
		<p>To enable SEO fields in Semplice, you need to install the <a href="https://wordpress.org/plugins/wordpress-seo/" target="_blank">Yoast SEO Plugin</a>.<br /><br />Please note that our admin panel and the 'Single Page App' mode only supports the Yoast SEO Plugin. If you would rather manage your SEO settings in the standard Wordpress admin and you don't plan on using the 'Single Page App' mode, you can use any SEO plugin you prefer.</p>
	</div>
</script>