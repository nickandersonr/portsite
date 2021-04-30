<!-- onboarding container -->
<script id="onboarding-template" type="text/template">
	<div id="onboarding" data-onboarding-theme="{{theme}}">
		<div class="inner" data-step="{{step}}">
			<div class="content">
				<div class="heading">
					<div class="onboarding-heading onboarding-fadein">{{title}}</div>
					{{input}}
					<div class="onboarding-sub onboarding-fadein">{{sub}}</div>
				</div>
				{{content}}
				<div class="footer">
					<a class="onboarding-button onboarding-fadein" href="#onboarding/{{stepNav}}">Next</a> 
				</div>
			</div>
		</div>
	</div>
</script>
<!-- onboarding start -->
<script id="onboarding-start-template" type="text/template">
	<div class="ob-bg-wrapper"><div class="ob-bg ob-bg-{{step}}"></div></div>
	<div class="welcome-title">
		<img class="onboarding-fadein welcome-logo" width="81" height="80" src="<?php echo get_template_directory_uri(); ?>/assets/images/admin/onboarding/welcome_logo.svg" alt="onboarding-welcome-logo">
		<img class="onboarding-fadein welcome-heading" width="483" height="189" src="<?php echo get_template_directory_uri(); ?>/assets/images/admin/onboarding/welcome_heading.svg" alt="onboarding-welcome-heading">
		<img class="onboarding-fadein welcome-sub" width="506" height="58" src="<?php echo get_template_directory_uri(); ?>/assets/images/admin/onboarding/welcome_sub.svg" alt="onboarding-welcome-sub">
	</div>
	<div class="letsgo-wrapper">
		<a class="onboarding-button lets-go onboarding-fadein" href="#onboarding/one">Press Start</a>
	</div>
</script>
<!-- onboarding step 1 -->
<script id="onboarding-one-template" type="text/template">
	<div class="ob-bg-wrapper ob-bg-{{step}}-dark"><div class="ob-bg"></div></div>
	<div class="ob-bg-wrapper ob-bg-{{step}}-bright"><div class="ob-bg"></div></div>
	<div class="ob-inner-content">
		<div class="ob-left">
			<div class="onboarding-theme admin-click-handler" data-handler="execute" data-action-type="onboarding" data-action="selectTheme" data-theme="bright">
				<img class="onboarding-fadein" src="<?php echo get_template_directory_uri(); ?>/assets/images/admin/onboarding/step_one_browser_day.png" alt="onboarding-step-one-browser-day">
			</div>
			<div class="ob-caption-theme onboarding-fadein">Light</div>
		</div>
		<div class="ob-right">
			<div class="onboarding-theme admin-click-handler" data-handler="execute" data-action-type="onboarding" data-action="selectTheme" data-theme="dark">
				<img class="onboarding-fadein" src="<?php echo get_template_directory_uri(); ?>/assets/images/admin/onboarding/step_one_browser_night.png" alt="onboarding-step-one-browser-night">
			</div>
			<div class="ob-caption-theme onboarding-fadein">Dark</div>
		</div>
	</div>
</script>
<!-- onboarding step 2 -->
<script id="onboarding-two-template" type="text/template">
	<div class="onboarding-browser onboarding-site-title onboarding-fadein">
		<div class="browser-heading"><span class="site_title">Sergio Rambotta</span> <span class="mdash">&mdash;</span> <span class="site_tagline">Graphic Designer</span></div>
	</div>
</script>
<!-- onboarding step 3 -->
<script id="onboarding-three-template" type="text/template">
	<div class="onboarding-browser onboarding-site-tagline onboarding-fadein">
		<div class="browser-heading"><span class="site_title">Sergio Rambotta</span> <span class="mdash">&mdash;</span> <span class="site_tagline">Graphic Designer</span></div>
	</div>
</script>
<!-- onboarding step 4 -->
<script id="onboarding-four-template" type="text/template">
	<div class="onboarding-navigation onboarding-nav-transition">
		<div class="onboarding-nav-preset preset-one admin-click-handler" data-handler="execute" data-action-type="onboarding" data-action="selectPreset" data-preset="logo_left_menu_right"></div>
		<div class="onboarding-nav-preset preset-two admin-click-handler" data-handler="execute" data-action-type="onboarding" data-action="selectPreset"  data-preset="logo_right_menu_left"></div>
		<div class="onboarding-nav-preset preset-three admin-click-handler" data-handler="execute" data-action-type="onboarding" data-action="selectPreset"  data-preset="logo_middle_menu_stacked"></div>
		<div class="onboarding-nav-preset preset-four admin-click-handler" data-handler="execute" data-action-type="onboarding" data-action="selectPreset"  data-preset="logo_left_menu_left"></div>
	</div>
</script>
<!-- onboarding step 5 -->
<script id="onboarding-five-template" type="text/template">
	<div class="onboarding-pages onboarding-fadein">
		<div class="ob-pages">
			<div class="ob-page">
				<div class="ob-page-title">Showcase &mdash; <span>Front Page</span></div>
			</div>
			<div class="ob-page">
				<div class="ob-page-title">About Page</div>
			</div>
		</div>
	</div>
</script>
<!-- onboarding step 6 -->
<script id="onboarding-six-template" type="text/template">
	<div class="onboarding-projects onboarding-fadein">
		<div class="ob-projects">
			<div class="ob-project">
				<img src="https://assets.semplice.com/onboarding/step_six_thumbnail.jpg" alt="step-six-thumbnail">
				<div class="ob-project-title">My first project</div>
			</div>
		</div>
	</div>
</script>
<!-- onboarding step 7 -->
<script id="onboarding-seven-template" type="text/template">
</script>
<!-- no motions template -->
<script id="no-motions-template" type="text/template">
	<div class="no-motions">
		<h3>Custom Animations</h3>
		<p>By default, automatic animations will reveal your content while scrolling. Click 'Activate Animations' to enable custom animations for this page or project.</p>
		<a class="activate-motions semplice-button" data-layout="{{mode}}" data-id="{{id}}">Activate Animations</a>
	</div>
</script>
<!-- theme update -->
<script id="update-template" type="text/template">
	<div class="semplice-update">
		<div class="inner">
			<p><span>Update available!</span> New version: {{newVersion}} &mdash; <a href="https://www.semplice.com/changelog-v5-<?php echo semplice_theme('edition'); ?>" target="_blank">Changelog</a></p>
			<div class="update-button">
				<a href="<?php echo admin_url('themes.php'); ?>">Update Semplice</a>
			</div>
		</div>
	</div>
</script>
<script id="update-edition-template" type="text/template">
	<div class="semplice-update">
		<div class="inner">
			<p><span>Studio Upgrade available!</span> Please upgrade to the studio edition now!</p>
			<div class="update-button">
				<a href="<?php echo admin_url('themes.php'); ?>">Upgrade to Studio</a>	
			</div>
		</div>
	</div>
</script>
<!-- wrong folder -->
<script id="wrong-folder-template" type="text/template">
	<div class="wrong-folder">
		<div class="wrong-folder-icon"><?php echo get_svg('backend', '/icons/popup_important'); ?></div>
		<p>To activate the Semplice One-click Update, your theme root folder must be called <span>/semplice5</span>. At the moment your theme root folder is: <span>/<?php echo get_template(); ?></span>. Please <a href="https://help.semplice.com/hc/en-us/articles/360035159731" target="_blank">read our small guide</a> on how to change that. Don't worry it's pretty easy and straight forward.</p>
	</div>
</script>
<!-- theme settings template -->
<script id="settings-template" type="text/template">
	<div id="settings">
		<div class="settings-inner">{{options}}</div>
	</div>
</script>
<!-- code mirror -->
<script id="codemirror-template" type="text/template">
	<div id="codemirror-pagesettings">
		<textarea id="code_mirror" {{attributes}}>{{code}}</textarea>
	</div>
</script>
<!-- code mirror -->
<script id="code-mirror-template" type="text/template">
	<div id="code-editor">
		<div class="code-editor-save">
			<p>Code Editor<p>
			<div class="buttons">
				<a class="code-cancel admin-click-handler" data-handler="codemirror" data-mode="cancel">cancel</a>
				<a class="code-save admin-click-handler" data-handler="codemirror" data-mode="save" data-attribute="{{attribute}}" data-id="{{contentId}}"{{timelineStep}}>save</a>
			</div>
		</div>
		<textarea id="code_mirror">{{code}}</textarea>
	</div>
</script>
<!-- template unsplash -->
<script id="unsplash-template" type="text/template">
	<div id="unsplash">
		<div class="unsplash-inner">
			<div class="unsplash-header">
				<div class="popup-close admin-click-handler" data-handler="execute" data-action-type="helper" data-action="closeUnsplash">
					<?php echo get_svg('backend', 'unsplash_close'); ?>
				</div>
				<input type="text" class="search-unsplash" placeholder="Search images from Unsplash">
			</div>
			<div class="unsplash-images" data-page-num="1"><!-- images placeholder --></div>
		</div>
	</div>
</script>
<!-- unsplash image template -->
<script id="unsplash-image-template" type="text/template">
	<div class="unsplash-thumb unsplash-{{format}}">
		<a class="add-unsplash-image admin-click-handler" data-handler="execute" data-action-type="helper" data-action="addUnsplashImage" data-image-src="{{imageSrc}}" data-ratio="{{ratio}}" data-download="{{download}}">
			<img src="{{thumbnail}}">
		</a>
		<div class="credit-link">
			<a class="profile-image" href="{{portfolioUrl}}" target="_blank"><img src="{{profileImage}}"></a>
			<a class="profile-name" href="{{portfolioUrl}}" target="_blank">{{name}}</a>
		</div>
	</div>
</script>
<!-- activate semplice -->
<script id="activate-semplice-template" type="text/template">
	<div id="activate-semplice" class="popup">
		<div class="popup-close admin-click-handler" data-handler="hidePopup">
			<?php echo get_svg('backend', '/icons/popup_close'); ?>
		</div>
		<div class="popup-inner">
			<div class="popup-content">
				<h3>Edit with Semplice v5</h3>
				<p>This page was created with an older version of Semplice or another theme. The content is not compatible with Semplice v.5. You can click "Start editing" to edit the page with the current version, but you won’t be able to see or edit the original content within Semplice.</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler confirm semplice-button" data-handler="execute" data-action-type="helper" data-action="activateSemplice" data-post-id="{{id}}">Start editing</a>
			</div>					
		</div>
	</div>
</script>
<!-- Semplice activated -->
<script id="semplice-activated-template" type="text/template">
	<div class="semplice-activated">
		<div class="box">
			<img src="https://www.semplice.com/images/boxes/{{boxUrl}}.png">
		</div>
		<div class="license-meta">
		<h3>Welcome to the<br />Semplice Family</h3>
		<p class="current-license">
			<span>Your Current License</span>
			{{license}}
		</p>
		<p class="license-infos">
			Installed Version: <a href="https://www.semplice.com/changelog-v5-{{changelog}}" target="_blank"><?php echo semplice_theme('version'); ?></a><br />
			Support: <a href="http://help.semplice.com" target="_blank">Helpdesk</a>
		</p>
		<p class="license-status">
			<span>License Status:</span>
			{{status}} <a class="admin-click-handler deactivate-license" data-handler="execute" data-action-type="helper" data-action="releaseLicense">Deactivate</a>
		</p>
		</div>
	</div>
</script>