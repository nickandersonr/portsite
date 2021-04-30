<!-- not found -->
<script id="not-found-template" type="text/template">
	<div class="semplice-error">
		<span><?php echo get_svg('backend', '/icons/popup_important'); ?></span>
		<h1>It looks like your permalinks are not working.<br/>Please make sure that permalinks are enabled<br />and that you have a working htaccess file in place.</h1>
		<a class="semplice-button" href="<?php echo admin_url('options-permalink.php'); ?>">Permalink Settings</a>
	</div>
</script>
<!-- no rest api -->
<script id="no-rest-api-template" type="text/template">
	<div class="semplice-error">
		<span><?php echo get_svg('backend', '/icons/popup_important'); ?></span>
		<h1>Semplice requires WordPress 4.4 or higher with an activated<br />Rest-API. Please update your site and try again.</h1>
		<a class="semplice-button admin-click-handler" data-handler="execute" data-action="exit" data-action-type="main">Exit to Wordpress</a>
	</div>
</script>
<!-- php version -->
<script id="php-error-template" type="text/template">
	<div class="semplice-error">
		<span><?php echo get_svg('backend', '/icons/popup_important'); ?></span>
		<h1>Semplice requires PHP version 5.3 or higher.<br />Please contact your web host to update your PHP version.</h1>
		<a class="semplice-button admin-click-handler" data-handler="execute" data-action="exit" data-action-type="main">Exit to Wordpress</a>
	</div>
</script>