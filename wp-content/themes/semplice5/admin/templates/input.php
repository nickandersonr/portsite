<!-- media upload template -->
<script id="editor-image-upload-template" type="text/template">
	<div class="media-upload-box" data-upload-box="{{contentId}}">
		<div class="upload-button admin-click-handler" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="image" {{attributes}}>
			<div class="upload-button-inner">
				<div class="upload-icon">
					<?php echo get_svg('backend', '/icons/upload'); ?>
				</div>
				<div class="upload-text">
					<span>Upload Media</span> 
				</div>
			</div>
		</div>
		<div class="ep-upload-status"><?php echo get_svg('backend', '/progress_circle'); ?></div>
		<div class="unsplash-button-wrapper"><span>or select from </span><span class="small-upload">or </span><a class="admin-click-handler unsplash-upload" data-handler="execute" data-action-type="helper" data-action="unsplash" {{attributes}}>Unsplash</a></div>
		<div class="image-preview-wrapper">
			<div class="ep-thumbnail {{ratio}}">
				<div class="centered">
					<img class="image image-preview" src="{{imageSrc}}">
				</div>
			</div>
			<div class="edit-image">
				<ul>
					<li><a class="admin-click-handler" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="image" {{attributes}}><?php echo get_svg('backend', '/icons/icon_edit'); ?></a></li>
					<li><a class="editor-action" data-action="bgImage" data-action-type="delete" data-content-id="{{contentId}}" {{attributes}}><?php echo get_svg('backend', '/icons/icon_delete'); ?></a></li>
				</ul>
			</div>
		</div>
		<input type="hidden" {{attributes}}>
	</div>
</script>
<script id="admin-image-upload-template" type="text/template">
	<div class="media-upload-box {{uploadVisibility}}">
		<div class="upload-button admin-click-handler" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="image" {{attributes}}>
			<div class="upload-button-inner">
				<div class="upload-icon">
					<?php echo get_svg('backend', '/icons/upload'); ?>
				</div>
				<div class="upload-text">
					<span>Upload Media</span> 
				</div>
			</div>
		</div>
		<div class="ep-upload-status"><?php echo get_svg('backend', '/progress_circle'); ?></div>
		<div class="unsplash-button-wrapper"><span>or select from </span><span class="small-upload">or </span><a class="admin-click-handler unsplash-upload" data-handler="execute" data-action-type="helper" data-action="unsplash" {{attributes}}>Unsplash</a></div>
		<div class="image-preview-wrapper">
			<div class="ep-thumbnail {{ratio}}">
				<div class="centered">
					<img class="image image-preview" src="{{imageSrc}}">
				</div>
			</div>
			<div class="edit-image">
				<ul>
					<li><a class="admin-click-handler" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="image" {{attributes}}><?php echo get_svg('backend', '/icons/icon_edit'); ?></a></li>
					<li><a class="admin-click-handler" data-handler="execute" data-action="image" data-action-type="delete" {{attributes}}><?php echo get_svg('backend', '/icons/icon_delete'); ?></a></li>
				</ul>
			</div>
		</div>
		<input type="hidden" {{attributes}}>
	</div>
</script>
<script id="lottie-upload-template" type="text/template">
	<div class="media-upload-box {{uploadVisibility}}">
		<div class="upload-button admin-click-handler" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="json" {{attributes}}>
			<div class="upload-button-inner">
				<div class="upload-icon">
					<?php echo get_svg('backend', '/icons/upload'); ?>
				</div>
				<div class="upload-text">
					<span>Upload Lottie file (.json)</span> 
				</div>
			</div>
		</div>
		<div class="ep-upload-status"><?php echo get_svg('backend', '/progress_circle'); ?></div>
		<div class="lottie-preview-wrapper">
			<div class="lottie-preview-left">
				<?php echo get_svg('backend', '/icons/lottie_json'); ?>
			</div>
			<div class="lottie-preview-right">
				<div class="lottie-filename">
					<h4>Uploaded File</h4>
					<p>{{filename}}</p>
				</div>
				<a class="editor-action" data-action="lottie" data-action-type="delete" {{attributes}}><?php echo get_svg('backend', '/icons/icon_delete'); ?></a>
			</div>
		</div>
		<input type="hidden" {{attributes}}>
	</div>
</script>
<script id="video-upload-template" type="text/template">
	<div class="media-upload-box" data-upload-box="{{contentId}}">
		<a class="semplice-button video-upload admin-click-handler" data-handler="execute"  data-action="init" data-action-type="mediaLibrary" data-media-type="video" {{attributes}}>{{buttonText}}</a>
		<a class="editor-action remove-media" data-action="video" data-action-type="delete" data-content-id="{{contentId}}" {{attributes}}><?php echo get_svg('backend', '/icons/media_delete'); ?></a>
		<input type="hidden" {{attributes}}>
	</div>
</script>
<script id="gallery-upload-template" type="text/template">
	<div class="media-upload-box" data-upload-box="{{contentId}}">
		<ul class="gallery-images{{visibility}}">{{images}}</ul>
		<div class="upload-button admin-click-handler" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="gallery" {{attributes}}>
			<div class="upload-button-inner">
				<div class="upload-icon">
					<?php echo get_svg('backend', '/icons/upload'); ?>
				</div>
				<div class="upload-text">
					<span>Add Images to Gallery</span>
				</div>
			</div>
		</div>
		<div class="ep-upload-status gallery-upload-status"><?php echo get_svg('backend', '/progress_circle'); ?></div>
		<input type="hidden" {{attributes}}>
	</div>
</script>
<script id="gallery-image-template" type="text/template">
	<li id="{{imageId}}">
		<div class="image-preview-wrapper">
			<div class="ep-thumbnail {{ratio}}">
				<div class="centered">
					<img class="image image-preview" src="{{imageSrc}}">
				</div>
			</div>
		</div>
		<a class="change-gallery-meta admin-click-handler" data-handler="execute" data-action-type="mediaLibrary" data-action="init" data-content-id="{{contentId}}" data-image-id="{{imageId}}" data-after-init="editMeta"></a>
		<a class="remove-gallery-image admin-click-handler" data-handler="execute" data-action-type="helper" data-action="removeGalleryImage" data-content-id="{{contentId}}"></a>
	</li>
</script>
<script id="onoff-switch-template" type="text/template">
	<div class="onoff-switch">
		<div class="title">
			<h6>{{title}}</h6>
		</div>
		<div class="switch admin-click-handler switch-{{status}}" data-handler="onOffSwitch">
			<div class="circle">
		</div>
		<input type="hidden" name="{{name}}" value="{{default}}" {{attributes}}>
	</div>
</script>
<!-- categories -->
<script id="categories-template" type="text/template">
	<div class="select-categories">
		<nav {{attributes}}>
			<ul>
				<?php 
					// list categories
					wp_category_checklist();
				?>
			</ul>
		</nav>
		<div class="add-new-category">
			<div class="add-category-form hide">
				<input type="text" name="category-name" placeholder="Category Name">
				<input type="hidden" name="category-parent">
				<div class="categories-dropdown"><div class="select-box"><div class="sb-arrow"></div><?php wp_dropdown_categories('hide_empty=0&depth=5&hierarchical=1'); ?></div></div>
				<a class="semplice-button white-button admin-click-handler" data-handler="execute" data-action-type="postSettings" data-action="addCategory">Add Category</a>
			</div>
			<a class="semplice-button white-button admin-click-handler" data-handler="execute" data-action-type="postSettings" data-action="showAddCategoryForm">Add Category</a>
		</div>
	</div>
</script>
<!-- select categories -->
<script id="select-categories-template" type="text/template">
	<div class="grid-categories select-categories">
		<div class="content">
			<nav {{attributes}}>
				<ul>
					<?php 
						// list categories
						wp_category_checklist();
					?>
				</ul>
			</nav>
		</div>
	</div>
</script>
<!-- add effect template -->
<script id="add-animate-effect-template" type="text/template">
	<div class="animate-effects-list">
		<div class="ael-inner">
			<ul>
				<li class="title">Transform</li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="move" data-id="{{id}}" data-step="{{step}}">Move</a></li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="scale" data-id="{{id}}" data-step="{{step}}">Scale</a></li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="rotate" data-id="{{id}}" data-step="{{step}}">Rotate</a></li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="skew" data-id="{{id}}" data-step="{{step}}">Skew</a></li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="rotate3d" data-id="{{id}}" data-step="{{step}}">3D Rotate</a></li>
				<li class="title">Filter</li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="filter_blur" data-id="{{id}}" data-step="{{step}}">Blur</a></li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="filter_brightness" data-id="{{id}}" data-step="{{step}}">Brightness</a></li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="filter_contrast" data-id="{{id}}" data-step="{{step}}">Contrast</a></li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="filter_grayscale" data-id="{{id}}" data-step="{{step}}">Grayscale</a></li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="filter_hue-rotate" data-id="{{id}}" data-step="{{step}}">Hue-Rotate</a></li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="filter_invert" data-id="{{id}}" data-step="{{step}}">Invert</a></li>	
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="filter_saturate" data-id="{{id}}" data-step="{{step}}">Saturate</a></li>				
			</ul>
			<ul>
				<li class="title">Styling</li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="opacity" data-id="{{id}}" data-step="{{step}}">Opacity</a></li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="gradient" data-id="{{id}}" data-step="{{step}}">Gradient</a></li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="color" data-id="{{id}}" data-step="{{step}}">Text Color</a></li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="border" data-id="{{id}}" data-step="{{step}}">Border</a></li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="background-color" data-id="{{id}}" data-step="{{step}}">Background Color</a></li>
				<li><a class="editor-action" data-action-type="animate" data-action="addEffect" data-effect="box-shadow" data-id="{{id}}" data-step="{{step}}">Drop Shadow</a></li>
			</ul>
		</div>
	</div>
	<a class="add-effect semplice-button white-button editor-action" data-action-type="animate" data-action="showAddEffectDropdown" data-step="{{step}}">Add Effect</a>
	<div class="animate-effects-empty">
		<p>You have not yet added any effects.<br />Added effects will be listed here.</p>
	</div>
</script>