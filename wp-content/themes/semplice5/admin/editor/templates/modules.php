<!-- image module template -->
<script id="module-template-image" type="text/template">
	<?php echo semplice_module_placeholder('image', false, true, true); ?>
</script>
<!-- paragraph module template -->
<script id="module-template-paragraph" type="text/template">
	<div class="is-content wysiwyg-editor wysiwyg-edit" data-wysiwyg-id="{{id}}" contenteditable="false"><p>Hey there, this is the default text for a new paragraph. Feel free to edit this paragraph by clicking on the yellow edit icon. After you are done just click on the yellow checkmark button on the top right. Have Fun!</p></div>
</script>
<!-- gallery odule template -->
<script id="module-template-gallery" type="text/template">
	<?php echo semplice_module_placeholder('gallery', false, true, true); ?>
</script>
<!-- oembed module template -->
<script id="module-template-oembed" type="text/template">
	<?php echo semplice_module_placeholder('oembed', false, false, true); ?>
</script>
<!-- video module template -->
<script id="module-template-video" type="text/template">
	<?php echo semplice_module_placeholder('video', false, false, true); ?>
</script>
<!-- spacer module template -->
<script id="module-template-spacer" type="text/template">
	<div class="spacer-container">
		<div class="is-content">
			<div class="spacer"><!-- horizontal spacer --></div>
		</div>
	</div>
</script>
<!-- portfolio grid module template -->
<script id="module-template-portfoliogrid" type="text/template"></script>
<!-- single project module template -->
<script id="module-template-singleproject" type="text/template"></script>
<!-- advanced portfolio grid module template -->
<script id="module-template-advancedportfoliogrid" type="text/template"></script>
<!-- dribbbble module template -->
<script id="module-template-dribbble" type="text/template"></script>
<!-- instagram module template -->
<script id="module-template-instagram" type="text/template"></script>
<!-- gallerygrid module template -->
<script id="module-template-gallerygrid" type="text/template">
	<?php echo semplice_module_placeholder('gallerygrid', false, true, true); ?>
</script>
<!-- button module template -->
<script id="module-template-button" type="text/template">
	<div class="ce-button">
		<div class="is-content">
			<a>Semplice Button</a>
		</div>
	</div>
</script>
<!-- code module template -->
<script id="module-template-code" type="text/template">
	<?php echo semplice_module_placeholder('code', false, false, true); ?>
</script>
<!-- share module template -->
<script id="module-template-share" type="text/template">
	<?php echo semplice_share_box_html(array('type' => 'icons'), false); ?>
</script>
<!-- social profiles module template -->
<script id="module-template-socialprofiles" type="text/template">
	<div class="socialprofiles is-content" data-align="center">
		<div class="inner">
			<ul>
				<li class="social-profile social-profile-facebook"><a href="https://www.facebook.com/semplicelabs" target="_blank"><?php echo get_svg('frontend', '/social-profiles/facebook'); ?></a></li>
				<li class="social-profile social-profile-twitter"><a href="https://www.twitter.com/semplicelabs" target="_blank"><?php echo get_svg('frontend', '/social-profiles/twitter'); ?></a></li>
				<li class="social-profile social-profile-vimeo"><a href="https://vimeo.com/semplicelabs" target="_blank"><?php echo get_svg('frontend', '/social-profiles/vimeo'); ?></a></li>
			</ul>
		</div>
	</div>
</script>
<!-- share module template -->
<script id="module-template-share-buttons" type="text/template">
	<?php echo semplice_share_box_html(array('type' => 'buttons'), false); ?>
</script>
<!-- mailchimp module template -->
<script id="module-template-mailchimp" type="text/template">
	<div class="mailchimp-newsletter">
		<div class="mailchimp-inner is-content">
			<form action="" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate">
				<input type="text" value="" name="FNAME" id="mce-FNAME" class="mailchimp-input" size="16" placeholder="First Name" data-font-size="18px">
				<input type="email" value="" name="EMAIL" id="mce-EMAIL" class="mailchimp-input" size="16" placeholder="E-Mail Address">
				<button class="mailchimp-submit-button" type="submit"  value="Subscribe" name="subscribe" id="mc-embedded-subscribe">Subscribe</button>
			</form>
		</div>
	</div>
</script>
<!-- before after module template -->
<script id="module-template-beforeafter" type="text/template">
	<?php
		// content
		$content = semplice_get_ba_content('', 'before', false);
		$content .= semplice_get_ba_content('', 'after', false);
		// output
		echo '
			<div class="before-after-editor module-placeholder is-content">
				' . $content . '
				<div class="ba-handle">
					<div class="ba-arrow" data-ba-arrow-direction="left">' . get_svg('frontend', 'icons/beforeafter_arrow') . '</div>
					<div class="ba-bar"></div>
					<div class="ba-arrow" data-ba-arrow-direction="right">' . get_svg('frontend', 'icons/beforeafter_arrow') . '</div>
				</div>
			</div>
		';
	?>
</script>
<!-- lottie module template -->
<script id="module-template-lottie" type="text/template">
	<div class="is-content semplice-lottie"><div id="{{id}}_lottie" class="lottie-holder"></div></div>
	<?php echo semplice_module_placeholder('lottie', false, false, true); ?>
</script>