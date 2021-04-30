<!-- edit popup template -->
<script id="edit-popup-template" type="text/template">
	<div class="color-picker-holder"></div>
	<div class="create-animations" data-display="none">
		<div class="head">Element Trigger</div>
		<p>Please select which element trigger<br />should start your animation.</p>
		<ul>
			<li><a class="editor-action semplice-button white-button create-animation" data-action-type="animate" data-action="add" data-id="{{id}}" data-event="on_load">When in view</a></li>
			<li><a class="editor-action semplice-button white-button create-animation" data-action-type="animate" data-action="add" data-id="{{id}}" data-event="on_hover">Mouseover</a></li>
			<li><a class="editor-action semplice-button white-button create-animation" data-action-type="animate" data-action="add" data-id="{{id}}" data-event="on_click">Click (tap)</a></li>
			<li><a class="editor-action semplice-button white-button create-animation" data-action-type="animate" data-action="add" data-id="{{id}}" data-event="on_scroll">Scrolling in view</a></li>
		</ul>
		<div class="animation-trigger-help"></div>
	</div>
	<div class="ep-content">
		<div class='ep-switch'>
			<ul>
				<li><a class='ep-content load-edit-popup active-switch' data-layout='content' data-switch="content" data-id="{{contentId}}" data-module="{{module}}"><?php echo semplice_get_module_svgs(); ?><span class="switch-tooltip">Content</span></a></li>
				<li><a class='ep-column load-edit-popup' data-layout='column' data-switch="column" data-id="{{contentId}}"><?php echo get_svg('backend', '/icons/ep_switch_column'); ?><span class="switch-tooltip">Column</span></a></li>
				<li><a class='ep-section load-edit-popup' data-layout='section' data-switch="section" data-id="{{contentId}}"><?php echo get_svg('backend', '/icons/ep_switch_section'); ?><span class="switch-tooltip">Section</span></a></li>
			</ul>
		</div>
		<div class="inner edit-popup-inner" data-popup-id="{{id}}">
			<div class="handlebar"><div class="handlebar-inner"><!-- draggable handle --></div></div>
			<div class="ep-options-wrapper">
				<div class="regular-options">
					<nav class="ep-tabs-nav">
						<ul>
							{{tabsNav}}
							<li><a class="close-edit-popup" data-module="{{module}}" data-id="{{id}}"><!-- close ep --></a></li>
						</ul>
					</nav>
					<div class="edit-popup-help"><div class="close-popup-notice" data-mode="help"><?php echo get_svg('backend', '/icons/ep_close_help'); ?></div><div class="content"></div></div>
					<div class="ep-tabs">
					</div>
					<ul class="actions ep-actions">
						<li class="ep-actions-item"><a class="editor-action duplicate mep-icon" data-action-type="duplicate" data-action="{{mode}}" data-id="{{id}}"><!-- Duplicate --></a><div class="tooltip tooltip-duplicate">Duplicate</div></li>
						<li class="ep-actions-item"><a class="editor-action delete mep-icon" data-layout-type="{{mode}}" data-action-type="popup" data-action="delete" data-id="{{id}}"><!-- Delete --></a><div class="tooltip tooltip-delete">Delete</div></li>
						<?php
							if(semplice_theme('edition') == 'single') {
								echo '<li class="save-block-single admin-click-handler ep-actions-item" data-handler="execute" data-action="studioFeatures" data-action-type="popup" data-feature="blocks"><a class="save-block mep-icon"><!-- Save Block --></a><div class="tooltip tooltip-save">Save as block</div></li>';
							} else {
								echo '<li class="ep-actions-item" data-is-masterblock="{{masterBlock}}"><a class="save-block mep-icon editor-action" data-action-type="popup" data-action="saveBlock" data-content-id="{{sectionId}}" data-masterblock-id="{{masterBlockId}}"><!-- Save Block --></a><div class="tooltip tooltip-save">{{blockTooltip}}</div></li>';
							}
						?>
						<li class="preview-animation">
							<a class="editor-action semplice-button mep-icon preview-animation-link" data-action-type="animate" data-action="preview" data-id="{{id}}" data-step="all" data-module="{{module}}"><span><?php echo get_svg('backend', '/icons/animate_preview'); ?></span> Preview</a>
							<a class="save-animate-preset editor-action" data-action-type="popup" data-action="saveAnimatePreset" data-content-id="{{id}}"><div class="tooltip animate-tooltip tooltip-animate-save">Save as preset</div></a>
							<a class="editor-action preview-animation-delete" data-action-type="popup" data-action="deleteAnimation" data-id="{{id}}" data-layout-type="{{mode}}"><div class="tooltip animate-tooltip tooltip-animate-remove">Delete Animation</div></a>
						</li>
					</ul>
				</div>
				<div class="ep-expand-options"></div>
			</div>
	</div>
</script>
<!-- add section -->
<script id="section-template" type="text/template">
	<section id="{{sectionId}}" class="content-block{{classes}}" data-column-mode-xs="single" data-column-mode-sm="single">
		<div class="container">
			<div id="{{rowId}}" class="row">
				<div id="{{columnId}}" class="column" data-xl-width="12">
					<div class="column-edit-head">
						<a class="column-handle"><?php echo get_svg('backend', '/icons/column_reorder'); ?></a>
						<p>Col</p>
					</div>
					<div class="content-wrapper">
						<div id="{{contentId}}" class="column-content" data-module="{{module}}">
							{{content}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</script>
<!-- add section with spacer column-->
<script id="section-spacer-column-template" type="text/template">
	<section id="{{sectionId}}" class="content-block" data-column-mode-xs="single" data-column-mode-sm="single">
		<div class="container">
			<div id="{{rowId}}" class="row">
				<div id="{{columnId}}" class="column spacer-column" data-xl-width="12">
					<div class="column-edit-head">
						<a class="column-handle"><?php echo get_svg('backend', '/icons/column_reorder'); ?></a>
						<p>Col</p>
					</div>
				</div>
			</div>
		</div>
	</section>
</script>
<!-- add empty section -->
<script id="empty-section-template" type="text/template">
	<section id="{{sectionId}}" class="content-block" data-column-mode-xs="single" data-column-mode-sm="single">
		<div class="container">
			<div id="{{rowId}}" class="row">
			</div>
		</div>
	</section>
</script>
<!-- add column -->
<script id="column-template" type="text/template">
	<div id="{{columnId}}" class="column" data-xl-width="12">
		<div class="column-edit-head">
			<a class="column-handle"><?php echo get_svg('backend', '/icons/column_reorder'); ?></a>
			<p>Col</p>
		</div>
		<div class="content-wrapper">
			<div id="{{contentId}}" class="column-content" data-module="{{module}}">
				{{content}}
			</div>
		</div>
	</div>
</script>
<!-- add spacer column -->
<script id="spacer-column-template" type="text/template">
	<div id="{{columnId}}" class="column spacer-column" data-xl-width="12">
		<div class="column-edit-head">
			<a class="column-handle"><?php echo get_svg('backend', '/icons/column_reorder'); ?></a>
			<p>Col</p>
		</div>
		<div class="column-count"></div>
	</div>
</script>
<!-- add content -->
<script id="content-template" type="text/template">
	<div id="{{contentId}}" class="column-content" data-module="{{module}}">
		{{content}}
	</div>
</script>
<!-- add column -->
<script id="cover-template" type="text/template">
	<div id="{{columnId}}" class="column" data-xl-width="12">
		<div class="column-edit-head">
			<a class="column-handle"><?php echo get_svg('backend', '/icons/column_reorder'); ?></a>
			<p>Col</p>
		</div>
		<div class="content-wrapper">
			<div id="{{contentId}}" class="column-content" data-module="{{module}}">
				{{content}}
			</div>
		</div>
	</div>
</script>
<!-- activate editor -->
<script id="active-editor" type="text/template">
	<a href="#edit/{{postId}}" id="editor-active">
		<div class="inner">
			<h5>Last Edited Post</h5>
			<h4>{{postTitle}}</h4>
		</div>
	</a>
</script>
<!-- publish dropdown -->
<script id="publish-dropdown-template" type="text/template">
	{{ options }}
	<a class="editor-action" data-action="post" data-action-type="save" data-save-mode="publish">Update</a>
</script>
<!-- default cover tmeplate -->
<script id="default-cover-template" type="text/template">
	<?php echo semplice_default_cover('hidden'); ?>
</script>
<!-- empty editor -->
<script id="empty-editor-template" type="text/template">
	<div id="empty-editor">
		<div class="drag-and-drop"><img src="<?php echo get_template_directory_uri() . '/assets/images/admin/empty_editor_drag.png'; ?>"></div>
		<div class="content">
			<h3 class="text">Drag an item from the topbar &amp;<br />and drop here to add content.</h3>
			<div class="semplice-template">
				<p>or</p>
				<div class="select-template-wrapper">
					<div class="st-arrow"></div>
					<select class="select-template">
						<?php echo semplice_get_template_dropdown(); ?>
					</select>
				</div>
			</div>
		</div>
		<div class="help-videos">
			<a href="https://www.semplice.com/videos#content-editor-overview" target="_blank">Watch Tutorial</a>
			<!--
			<span>or</span>
			<a class="demo-content" href="link/to/video/tutorial" target="_blank">Load demo content</a>
			-->
		</div>
	</div>
</script>
<!-- select covers -->
<script id="select-covers-template" type="text/template">
	<div class="grid-categories select-covers">
		<div class="content">
			<nav class="editor-action" data-handler="execute" data-action-type="coverslider" data-action="add">
				<ul class="cover-list">{{posts}}</ul>
			</nav>
		</div>
	</div>
</script>
<!-- advaned portfolio grid presets -->
<script id="apg-presets-template" type="text/template">
	<div class="apg-presets">
		<ul class="content apg-presets-content">
			<li class="apg-load-preset" data-preset="horizontal-fullscreen" data-content-id="{{id}}">
				<div class="apg-inner">
					<img alt="horizontal-fullscreen" class="preset-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/portfoliogrid/horizontal_fullscreen.png'; ?>">
					<div class="apg-preset-hover"><p>Horizontal<br />Fullscreen</p></div>
				</div>
			</li>
			<li class="apg-load-preset" data-preset="text" data-content-id="{{id}}">
				<div class="apg-inner">
					<img alt="text-grid" class="preset-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/portfoliogrid/text.png'; ?>">
					<div class="apg-preset-hover"><p>Text Grid</p></div>
				</div>
			</li>
			<li class="apg-load-preset" data-preset="splitscreen" data-content-id="{{id}}">
				<div class="apg-inner">
					<img alt="splitscreen-grid" class="preset-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/portfoliogrid/splitscreen.png'; ?>">
					<div class="apg-preset-hover"><p>Splitscreen</p></div>
				</div>
			</li>
		</ul>
	</div>
</script>
<!-- advaned portfolio grid missing thumb -->
<script id="apg-missing-thumb-template" type="text/template">
	<div class="missing-thumbnail">
		<p>Missing thumbnail for<br />"{{postTitle}}"</p>
		<div class="semplice-button admin-click-handler no-ep trigger-apg-thumb-upload" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="image" data-media-type="image" data-upload="epPostThumbnail" name="post_thumbnail" data-content-id="{{contentId}}" data-post-id="{{postId}}">Upload Thumbnail</div>
		<img alt="missing-thumbnail" src="<?php echo get_template_directory_uri() . '/assets/images/admin/apg_missing_thumbnail.png'; ?>">
	</div>
</script>
<!-- revision list item template -->
<script id="revision-list-item-template" type="text/template">
	<li id="{{revisionId}}" class="revision-list-item">
		<a class="load-revision editor-action" data-action-type="revisions" data-action="load" data-revision-id="{{revisionId}}">{{revisionTitle}}</a>
		<div class="revision-options">
			<a class="rename-revision editor-action" data-action-type="popup" data-action="renameRevision" data-revision-id="{{revisionId}}"></a>
			<a class="remove-revision editor-action" data-action-type="popup" data-action="deleteRevision" data-revision-id="{{revisionId}}"></a>
		</div>
	</li>
</script>
<!-- revisions unsaved changes -->
<script id="revision-unsaved-changes-template" type="text/template">
<div id="semplice-exit" class="popup">
	<div class="popup-inner">
		<div class="popup-content">
			<div class="important">
				<?php echo get_svg('backend', '/icons/popup_important'); ?>
			</div>
			<h3>Unsaved Changes</h3>
			<p>Do you want to save your progress to the active version before continuing?</p>
		</div>
		<div class="popup-footer">
			<a class="editor-action cancel" data-handler="execute" data-action-type="revisions" data-action="forceLoad" data-revision-id="{{revisionId}}">Don't Save</a>
			<a class="editor-action confirm semplice-button" data-handler="execute" data-action-type="save" data-action="post" data-save-mode="draft" data-change-status="no" data-load-revision="yes" data-revision-id="{{revisionId}}">Save &amp; continue</a>
		</div>					
	</div>
</div>
</script>
<!-- before after before -->
<script id="ba-before-template" type="text/template">
	<?php echo semplice_get_ba_content('', 'before', false); ?>
</script>
<!-- before after after -->
<script id="ba-after-template" type="text/template">
	<?php echo semplice_get_ba_content('', 'after', false); ?>
</script>
<!-- list animate presets -->
<script id="list-animate-presets-template" type="text/template">
<div class="animate-presets-list" data-active-list="premade">
	<div class="apl-nav">
		<a class="editor-action preset-list active-preset-list" data-action-type="animate" data-action="togglePresetList" data-type="premade">Premade</a>
		<a class="editor-action preset-list " data-action-type="animate" data-action="togglePresetList" data-type="global">Custom</a>
	</div>
	<ul class="premade">
		{{premade}}
	</ul>
	<ul class="global ep-ap-list">
		{{global}}
	</ul>
</div>
</script>
<!-- custom animate presets empty state -->
<script id="animate-presets-emtpy-template" type="text/template">
	<div class="apl-empty">
		<div class="apl-empty-inner">
			<div class="head-image"></div>
			<p class="apl-empty-head">Custom Presets</p>
			<p>You haven't created any custom presets yet. Use the + icon below to save a custom preset after finishing your animation.</p>
		</div>
	</div>
</script>


