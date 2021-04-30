<!-- media library template -->
<script id="media-library-template" type="text/template">
	<div id="semplice-media-library">
		<div class="dragover">
			<div class="dragover-inner"><p>Drop files to upload</p></div>
		</div>
		<div class="sml-inner">
			<div class="sml-header">
				<div class="sml-header-inner">
					<div class="sml-status">
						<svg class="semplice-spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
							<circle class="path" fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
						</svg>
						<div class="sml-status-text">Loading Folder</div>
					</div>
					<div class="sml-filename"></div>
					<div class="sml-search">
						<input type="text" placeholder="Search for title" class="sml-search-term" name="sml-search">
					</div>
				</div>
				<div class="sml-search-results"></div>
			</div>
			<div class="sml-upload">
				<a class="semplice-button sml-upload-button">Upload Media</a>
				<input type="file" name="files[]" id="sml-file-upload" multiple />
			</div>
			<div class="sml-footer">
				<div class="sml-footer-left">
					<a class="sml-delete-media admin-click-handler" data-handler="execute" data-action-type="popup" data-action="smlDeleteAttachment">Delete</a>
				</div>
				<div class="sml-footer-right">
					<a class="admin-click-handler cancel" data-handler="execute" data-action-type="mediaLibrary" data-action="close">Cancel</a>
					<a class="sml-insert-media semplice-button admin-click-handler" data-handler="execute" data-action-type="mediaLibrary" data-action="insert">Insert Media</a>
				</div>
			</div>
			<div class="sml-content"></div>
		</div>
	</div>
</script>
<!-- sml upload attachment blank template -->
<script id="sml-upload-attachment-blank-template" type="text/template">
	<div class="sml-attachment sml-attachment-slot">
		<div class="sml-attachment-inner">
			<div id="{{id}}" class="sml-upload-progress"><div class="progress-inner"></div><div class="progress-inner-bg"></div></div>
		</div>
	</div>
</script>
<!-- sml upload attachment template -->
<script id="sml-upload-attachment-template" type="text/template">
	<div id="attachment-{{id}}" class="sml-attachment" data-attachment-id="{{id}}" data-attachment-mime="{{mimeType}}" data-attachment-url="{{src}}" data-attachment-width="{{width}}" data-attachment-height="{{height}}">>
		<div class="sml-attachment-inner">
			<div class="sml-thumbnail {{classes}} {{ratio}}" data-mime-type="{{mimeType}}">
				<div class="centered">
					{{thumbnail}}
				</div>
				{{title}}
				<div class="sml-meta"><a class="sml-show-meta admin-click-handler" data-handler="execute" data-action-type="mediaLibrary" data-action="getMeta" data-attachment-id="{{id}}"></a></div>
			</div>
		</div>
	</div>
</script>
<!-- sml edit metas template -->
<script id="sml-edit-meta-template" type="text/template">
	<div id="sml-edit-meta">
		<div class="inner">
			<div class="sml-meta-details">
				<div class="sml-meta-preview">
					<div class="sml-meta-url"><a href="{{url}}" target="_blank"><?php echo get_svg('backend', '/icons/sml_meta_url'); ?></a></div>
					<div class="sml-meta-thumbnail {{ratio}} {{mimeClass}}">
						<div class="centered">
							{{preview}}
						</div>
					</div>
				</div>
				<div class="sml-attachment-meta">
					<div class="sml-meta-filename"><span>{{filename}}</span></div>
					<div class="sml-meta-date"><span>Date:</span> {{date}}</div>
					<div class="sml-meta-size"><span>Size:</span> {{size}}</div>
					<div class="sml-meta-dimension"><span>Dimension:</span> {{dimension}}</div>
				</div>
			</div>
			<div class="options">
				<div class="option">
					<div class="option-inner">
						<div class="attribute span4">
							<h4>Title</h4>
							<input type="text" value="{{title}}" name="sml-meta-title">
						</div>
					</div>
					<div class="option-inner">
						<div class="attribute span4-popup">
							<h4>Caption</h4>
							<textarea type="text" name="sml-meta-caption">{{caption}}</textarea>
						</div>
					</div>
					<div class="option-inner">
						<div class="attribute span4 sml-alt-text">
							<h4>Alt Text</h4>
							<input type="text" value="{{alt}}" name="sml-meta-alt">
						</div>
					</div>
					<div class="option-inner">
						<div class="attribute span4-popup">
							<h4>Description</h4>
							<textarea type="text" name="sml-meta-description">{{description}}</textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="sml-meta-footer">
				<a class="admin-click-handler cancel" data-handler="execute" data-action-type="mediaLibrary" data-action="closeMeta" data-close-mode="{{saveMode}}">Cancel</a>
				<a class="admin-click-handler confirm semplice-button" data-handler="execute" data-action-type="mediaLibrary" data-action="saveMeta" data-attachment-id="{{id}}" data-save-mode="{{saveMode}}">Save</a>
			</div>
		</div>
	</div>
</script>