<!-- webfont templates -->
<script id="webfonts-template" type="text/template">
	<div class="customize-sidebar">
			<div class="webfonts-ressources">
				<h3 class="sidebar-title">Resources</h3>
				<div class="sidebar-spacer-full"></div>
					<ul>
						{{ressource}}
					</ul>
				<a class="add-ressource-button admin-click-handler" data-handler="execute" data-action="addRessourcePopUp" data-setting-type="webfonts" data-action-type="customize" data-options="service" data-mode="add">+ Add Resource</a>
			</div>
	</div>
	<div class="customize-inner">
		<div class="customize-heading">
			<div class="inner">
				<div class="admin-row">
					<div class="sub-header admin-column">
						<h2 class="admin-title">Webfonts</h2>
						<a class="admin-click-handler semplice-button gray-button" data-handler="execute" data-action="addWebfontPopUp" data-setting-type="webfonts" data-action-type="customize" data-options="add-font" data-mode="add">Add webfont</a> 
					</div>
				</div>
			</div>
		</div>
		<div class="customize-content">
			<div class="webfonts">
				<ul>
					{{content}}
				</ul>
			</div>
		</div>
	</div>
</script>
<script id="webfonts-onboarding-template" type="text/template">
	<div class="customize-content">
		<div class="webfonts-onboarding">
			<div class="head"></div>
			<div class="content">
				<h2>Custom Webfonts</h2>
				<p>In Semplice you can add fonts from any external service (like Typekit, Fonts.com) or just add your own self hosted fonts.</p>
				<a class="semplice-button admin-click-handler" data-handler="execute" data-action="addRessourcePopUp" data-setting-type="webfonts" data-action-type="customize" data-options="service" data-mode="add">Add your first Webfont</a>
			</div>
			<div class="help-videos">
				<a href="https://vimeo.com/214124569/e1337fa720" target="_blank">Add serviced fonts</a>
				<a class="self-hosted" href="https://vimeo.com/214964290/5c4cc9f3aa" target="_blank">Add selfhosted fonts</a>
			</div>
		</div>
	</div>
</script>
<script id="webfonts-addfont-popup-template" type="text/template">
	<div id="webfonts-add-font" class="popup" data-is-uploaded-font="{{isUploaded}}">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content" data-font-type="{{fontType}}">
				<h3>{{title}}</h3>
				{{options}}
				<div class="option font-axis-option">
					<div class="option-inner">
						<div class="attribute span4-popup vfont-setting font-axis-setting">
							<h4>Font Axis <span class="show-help">?<span>For uploaded self hosted fonts Semplice will automatically add all axis that are available in your font and also add the min / max values for each axis.<br /><br />If you need to add these values manually or have a non-uploaded self hosted font please see our guide on <a href="https://help.semplice.com/hc/en-us/articles/360058172071" target="_blank">variable webfonts</a>.</span></span></h4>
							{{fontAxis}}
						</div>
					</div>
				</div>
			</div>
			<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="semplice-button admin-click-handler" data-handler="execute" data-action-type="customize" data-setting-type="webfonts" data-action="{{mode}}Webfont" data-font-id="{{id}}">{{mode}} Webfont</a>
			</div>
			<div class="webfonts-help">
				<div class="close-popup-notice" data-mode="webfonts">
					<?php echo get_svg('backend', '/icons/ep_close_help'); ?>
				</div>
				<div class="content">
					{{content}}
				</div>
			</div>
		</div>
	</div>
</script>
<script id="webfonts-addfont-list-template" type="text/template">
	<li id="{{fontId}}" data-font-type="{{fontType}}">
		<a class="admin-click-handler edit-font" data-handler="execute" data-action-type="customize" data-setting-type="webfonts" data-action="addWebfontPopUp" data-font-id="{{fontId}}" data-mode="edit" data-options="add-font">
			<p class="font-name">{{name}}</p>
			<h4 class="font-preview {{fontId}}">ABCabc0123 The quick brown fox</h4>
		</a>
		<div class="webfonts-actions">
			<ul>
				<li><a class="admin-click-handler edit" data-handler="execute" data-action-type="customize" data-setting-type="webfonts" data-action="addWebfontPopUp" data-font-id="{{fontId}}" data-mode="edit" data-options="add-font"><?php echo get_svg('backend', '/icons/icon_edit'); ?></a></li>
				<li><a class="admin-click-handler delete" data-handler="execute" data-action-type="popup" data-type="removeFont" data-action="deleteWebfont" data-delete-id="{{fontId}}"><?php echo get_svg('backend', '/icons/icon_delete'); ?></a></li>
			</ul>
		</div>
		{{variable}}
	</li>
</script>
<script id="webfonts-ressource-popup-template" type="text/template">
	<div id="webfonts-add-ressource" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hideWebfontsRessource">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<h3>{{label}} resource</h3>
				<div class="option" data-ressource-mode="{{mode}}">
					<div class="option-inner">
						<div class="attribute span4-popup">
							<h4>Type <span class="show-help">?<span><b>Webservice</b><br />Integrate any fonts you like from a webfont service such as Fonts.com, Typekit, Google Fonts etc. <a href="https://vimeo.com/214124569/e1337fa720" target="_blank">Here is a little video tutorial for you.</a><br /><br /><b>Self hosted</b><br />Integrate fonts that are hosted on your own web server. <a href="https://vimeo.com/214964290/5c4cc9f3aa" target="_blank">You can see how that works in this video.</a></span></span></h4>
							<div class="option-switch">
								<div class="select-box">
									<div class="sb-arrow"></div>
									<select name="res-type-select" data-input-type="select-box" class="webfonts-switch" data-handler="webfontsSwitch">
										<option value="service" data-ressource-id="{{id}}">Service</option>
										<option value="self-hosted-upload" data-ressource-id="{{id}}">Self Hosted via Upload</option>
										<option value="self-hosted" data-ressource-id="{{id}}">Self Hosted via CSS</option>
									</select>
									<input type="hidden" name="ressource-type" value="service" class="is-webfonts-setting">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="options">
					{{options}}
				</div>
			</div>
			<div class="popup-footer">
				<a class="admin-click-handler cancel" data-handler="hideWebfontsRessource">Cancel</a><a class="semplice-button admin-click-handler" data-handler="execute" data-action-type="customize" data-setting-type="webfonts" data-action="{{mode}}Ressource" data-ressource-id="{{id}}">{{mode}}</a>
			</div>
			<div class="webfonts-help">
				<div class="close-popup-notice" data-mode="webfonts">
					<?php echo get_svg('backend', '/icons/ep_close_help'); ?>
				</div>
				<div class="content">
					{{content}}
				</div>
			</div>
		</div>
	</div>
</script>
<script id="webfonts-ressource-list-template" type="text/template">
	<li id="{{id}}" class="{{type}}"{{css}}>
		<h5 class="ressource-name">{{name}}{{domainWarning}}</h5>
		<div class="webfonts-ressources-actions">
			<ul>
				<li><a class="admin-click-handler" data-handler="execute" data-action-type="customize" data-setting-type="webfonts" data-action="addRessourcePopUp" data-mode="edit" data-ressource-id="{{id}}" data-options="{{type}}"><?php echo get_svg('backend', '/icons/icon_edit'); ?></a></li>
				<li><a class="admin-click-handler" data-handler="execute" data-action-type="popup" data-type="removeRessource" data-action="deleteWebfont" data-delete-id="{{id}}"><?php echo get_svg('backend', '/icons/icon_delete'); ?></a></li>
			</ul>
		</div>
	</li>
</script>
<script id="webfonts-upload-template" type="text/template">
	<div class="font-dropzone">
		<div class="loader">
			<svg class="semplice-spinner" width="20px" height="20px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
				<circle class="path" fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
			</svg>
		</div>
		<div class="media-upload-box show-upload font-upload-box">
			<div class="upload-button font-upload font-upload-button admin-click-handler" data-handler="execute" data-action="init" data-action-type="mediaLibrary" data-media-type="webfont" data-upload="webfonts">
				<div class="upload-button-inner font-upload-inner">
					<div class="upload-icon">
						<?php echo get_svg('backend', '/icons/upload'); ?>
					</div>
					<div class="upload-text">
						<span>Upload Fonts<br /><span class="font-upload-note">Click or drag and drop</span></span> 
					</div>
				</div>
			</div>
		</div>
		<input type="file" name="files[]" id="semplice-font-upload" multiple="">
	</div>
</script>
<script id="webfonts-font-axis-template" type="text/template">
	<li class="font-axis">
		<div class="font-axis-options">
			<div class="option">
				<div class="option-inner">
					<div class="attribute span2-popup vfont-setting">
						<input type="text" placeholder="wght" value="{{axis}}" data-input-type="input-text" class="is-vfont-setting" data-option-type="add-font" name="axis" data-unique-name="axis">
					</div>
					<div class="attribute span1-popup vfont-setting">
						<div class="range-slider-wrapper">
							<input type="number" data-type="range-slider" value="{{min}}" data-input-type="range-slider" class="is-vfont-setting" data-range-slider="fontAxis" min="0" max="9999" data-option-type="add-font" name="axis-min" data-unique-name="min" data-negative="true">
						</div>
					</div>
					<div class="attribute span1-popup vfont-setting">
						<div class="range-slider-wrapper">
							<input type="number" data-type="range-slider" value="{{max}}" data-input-type="range-slider" class="is-vfont-setting" data-range-slider="fontAxis" min="0" max="9999" data-option-type="add-font" name="axis-max" data-unique-name="max" data-negative="true">
						</div>
					</div>
					<a class="remove-axis admin-click-handler" data-handler="execute" data-action-type="customize" data-action="removeAxis" data-setting-type="webfonts" data-axis="[[axis}}"></a>
				</div>
			</div>
		</div>
	</li>
</script>
<script id="webfonts-variable-styles-template" type="text/template">
	<div id="variable-styles">
		<div class="inner">
			<div class="head">
				<div class="title">{{fontName}}</div>
				<div class="buttons">
					<a class="vs-cancel admin-click-handler" data-handler="execute" data-action-type="customize" data-action="closeVariableStyle" data-setting-type="webfonts" data-font-id="{{fontId}}" data-style-id="{{styleId}}">cancel</a>
					<a class="vs-save admin-click-handler" data-handler="execute" data-action-type="customize" data-action="saveVariableStyle" data-setting-type="webfonts" data-font-id="{{fontId}}" data-style-id="{{styleId}}">save</a>
				</div>
			</div>
			<div class="content">
				<div class="sidebar">
					<div class="sidebar-head">
						<p>Edit your<br/>variable style</p>
					</div>
					<div class="sidebar-settings vsp-sidebar">
						<div class="sidebar-inner">
							<div class="setting">
								<p class="setting-label">STYLE NAME</p>
								<input type="text" placeholder="Helvetica Header" value="{{name}}" data-input-type="input-text" class="is-vstyle-setting" name="name" data-unique-name="name">
							</div>
							{{axis}}
						</div>
					</div>
				</div>
				<div class="preview">
					<div class="preview-settings">
						<div class="setting">
							<span>Font size</span>
							<div class="option">
								<div class="option-inner">
									<div class="attribute">
										<input type="number" class="admin-listen-handler is-vstyle-setting" data-handler="variableStyle" data-is-unit="true" data-type="range-slider" value="20" data-input-type="range-slider" data-range-slider="variableStyle" data-attribute="font-size" min="6" max="999" name="font-size">
									</div>
								</div>
							</div>
						</div>
						<div class="setting">
							<span>Line height</span>
							<div class="option">
								<div class="option-inner">
									<div class="attribute">
										<input type="number" class="admin-listen-handler is-vstyle-setting" data-handler="variableStyle" data-is-unit="true" data-type="range-slider" value="32" data-input-type="range-slider" data-range-slider="variableStyle" data-attribute="line-height" min="6" max="999" name="line-height">
									</div>
								</div>
							</div>
						</div>
						<div class="setting">
							<span>Letter Spacing</span>
							<div class="option">
								<div class="option-inner">
									<div class="attribute">
										<input type="number" class="admin-listen-handler is-vstyle-setting" data-handler="variableStyle" data-is-unit="true" data-type="range-slider" value="0" data-input-type="range-slider" data-range-slider="variableStyle" data-attribute="letter-spacing" min="0" max="9999" name="letter-spacing" data-negative="true" data-divider="10">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="vsp-content-outer">
						<div class="preview-content vsp-content" contenteditable="true" data-font="{{fontId}}">
							Welcome to the variable style preview. Feel free to edit this text to preview your own paragraphs or headlines.<br /><br />How does this work?<br /><br />Well, you know how you usually choose weights like light, regular or bold when using a web font? That's old school now.<br /><br />With variable web fonts, you can define your own weights. So if bold is too bold and regular is too boring, you can find something in between. We call it "styles," in this case, because most of the time you can edit more than just the weight in your variable web fonts.<br /><br />Once you set your styles here, they will be available everywhere else in Semplice when selecting your web fonts.<br /><br />PRO TIPS for editing your styles:<br /><br />1. Try clicking the slider bullet and using your cursor keys (left & right) to adjust your slider value in single steps. This way, you won't get crazy if it jumps from 99 to 101.<br /><br />2. Font size, line height and letter spacing are for preview only, meaning they won't be saved with your axis settings. If you want to set site-wide size and line height styles with your variable web fonts, you can do that in the Typography section.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
<script id="webfonts-axis-slider-template" type="text/template">
	<div class="setting">
		<p class="setting-label">{{axis}}<span class="val">{{val}}</span></p>
		<input type="range" min="{{min}}" max="{{max}}" value="{{val}}" step="1" class="variable-style-slider is-vstyle-setting is-axis" data-axis="{{axis}}" name="{{axis}}" data-font-id="{{id}}" data-style-id="{{styleId}}">
	</div>
</script>
<script id="webfonts-variable-style-preview-template" type="text/template">
	<li>
		<a class="variable-style-preview admin-click-handler" data-handler="execute" data-action="editVariableStyle" data-action-type="customize" data-setting-type="webfonts" data-font="{{id}}" data-font-id="{{id}}" data-style-id="{{styleId}}" style="font-variation-settings: {{css}};">
			<span class="spacer"></span>{{name}}</a><a class="admin-click-handler delete-variable-style" data-handler="execute" data-action-type="popup" data-action="deleteVariableStyle" data-font-id="{{id}}" data-style-id="{{styleId}}">
		</a>
	</li>
</script>