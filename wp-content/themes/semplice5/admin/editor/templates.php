<!-- editor templates -->
<div id="editor-templates">
	<?php
		// globals
		global $editor_api, $post;
		// define templates
		$templates = array('modules', 'popups', 'other');
		// get templates
		foreach ($templates as $template) {
			require get_template_directory() . '/admin/editor/templates/' . $template . '.php';
		}
	?>	
</div>