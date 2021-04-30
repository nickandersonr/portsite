<?php

// -----------------------------------------
// semplice
// partials/password_form.php
// -----------------------------------------
// $theme 	> black / white
// $submit 	> submit button for static or single page app
// -----------------------------------------

?>

<div class="post-password-form<?php echo $theme; ?>">
	<div class="inner">
		<form action="<?php echo esc_url(site_url('wp-login.php?action=postpass', 'login_post')); ?>" method="post">
			<div class="password-lock"><?php echo get_svg('frontend', 'icons/password_lock'); ?></div>
			<p>This content is protected. <br /><span>To view, please enter the password.</span></p>
			<div class="input-fields">
				<input name="post_password" class="post-password-input" type="password" size="20" maxlength="20" placeholder="Enter password" /><?php echo $submit; ?>
			</div>
		</form>
	</div>
</div>

