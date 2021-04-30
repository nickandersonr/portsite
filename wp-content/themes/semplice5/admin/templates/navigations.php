<!-- navigations -->
<script id="navigations-template" type="text/template">
	<div class="customize-inner">
		<div class="customize-heading">
			<div class="inner navigations-inner">
				<div class="admin-row">
					<div class="sub-header admin-column">
						<h2 class="admin-title">Navigations</h2>
						<a class="semplice-button gray-button" href="#customize/navigations/add">Add Navigation</a> 
					</div>
				</div>
			</div>
		</div>
		<div class="customize-content navigations-inner">
			<div class="navigations">
				<ul>
					{{content}}
				</ul>
			</div>
		</div>
	</div>
</script>
<script id="navigations-list-template" type="text/template">
	<li id="{{id}}">
		<a class="navigation {{preset}}{{lastInRow}}" href="#customize/navigations/edit/{{id}}">
			<img alt="preset-two bg" class="preset-bg-img" src="<?php echo get_template_directory_uri() . '/assets/images/admin/navigation/{{presetUrl}}_full.png'; ?>">
			<p>{{name}}{{defaultNav}}</p>
		</a>
		<div class="edit-nav-hover">
			<ul>
				<li>
					<a class="navigation-duplicate" href="#customize/navigations/edit/{{id}}"><?php echo get_svg('backend', '/icons/icon_edit'); ?></a>
					<div class="tooltip tt-edit">Edit</div>
				</li>
				<li>
					<a class="navigation-remove admin-click-handler" data-handler="execute" data-action="duplicate" data-setting-type="navigations" data-action-type="customize" data-nav-id="{{id}}"><?php echo get_svg('backend', '/icons/post_duplicate'); ?></a>
					<div class="tooltip tt-duplicate">Duplicate</div>
				</li>
				<li>
					<a class="navigation-duplicate admin-click-handler" data-handler="execute" data-action="removePopup" data-setting-type="navigations" data-action-type="customize" data-nav-id="{{id}}"><?php echo get_svg('backend', '/icons/icon_delete'); ?></a>
					<div class="tooltip tt-remove">Remove</div>
				</li>
				<li>
					<a class="navbar-default" data-nav-id="{{id}}"><?php echo get_svg('backend', '/icons/save_checkmark'); ?></a>
					<div class="tooltip tt-default">Default</div>
				</li>
			</ul>
		</div>
	</li>
</script>
<script id="navigations-presets-template" type="text/template">
	<?php
		// output 
		$nav_presets = '';
		// define navigations
		$navigations = array(
			'preset_one' => array(
				'system_name' => 'logo_left_menu_right',
				'display_name' => 'Logo on the left; menu on the right',
				'hidden' => false,
			),
			'preset_two' => array(
				'system_name' => 'logo_left_menu_left',
				'display_name' => 'Logo and menu on the left',
				'hidden' => false,
			),
			'preset_three' => array(
				'system_name' => 'logo_right_menu_left',
				'display_name' => 'Logo on the right; menu on the left',
				'hidden' => false,
			),
			'preset_four' => array(
				'system_name' => 'logo_right_menu_right',
				'display_name' => 'Logo and menu on the right',
				'hidden' => false,
			),
			'preset_five' => array(
				'system_name' => 'logo_middle_menu_sides',
				'display_name' => 'Logo in the middle, menu on both sides',
				'hidden' => false,
			),
			'preset_six' => array(
				'system_name' => 'logo_middle_menu_stacked',
				'display_name' => 'Logo and menu stacked in the middle',
				'hidden' => false,
			),
			'preset_seven' => array(
				'system_name' => 'logo_hidden_menu_middle',
				'display_name' => 'Logo hidden, menu in the middle',
				'hidden' => true,
			),
			'preset_eight' => array(
				'system_name' => 'logo_left_menu_vertical_right',
				'display_name' => 'Logo on the left, vertical menu on the right',
				'hidden' => true,
			),
			'preset_nine' => array(
				'system_name' => 'logo_middle_menu_corners',
				'display_name' => 'Logo in the middle, menu on four corners',
				'hidden' => false,
			),
			'preset_ten' => array(
				'system_name' => 'logo_middle_menu_vertical_left_right',
				'display_name' => 'Logo in the middle, vertical menu on left and right',
				'hidden' => true,
			),
			'preset_eleven' => array(
				'system_name' => 'no_logo_menu_distributed',
				'display_name' => 'No logo, menu distributed',
				'hidden' => false,
			),
		);
		// studio navs
		$studio_navs = array('preset_five', 'preset_nine', 'preset_eleven');
		// count
		$count = 0;
		// iterate navs
		foreach ($navigations as $preset => $nav) {
			// is nav hidden?
			if(false === $nav['hidden']) {
				// even / odd
				$class = '';
				if($count % 2 != 0) {
					$class = ' preset-right';
				}
				if(semplice_theme('edition') == 'single' && in_array($preset, $studio_navs)) {
					$nav_presets .= '
						<div class="preset single-preset' . $class . '" data-preset="' . $nav['system_name'] . '">
							<div class="images">
								<img alt="' . $preset . ' bg" class="preset-bg-img" src="' . get_template_directory_uri() . '/assets/images/admin/navigation/' . $preset . '_bg.png">
								<img alt="' . $preset . ' nav" class="preset-nav-img" src="' . get_template_directory_uri() . '/assets/images/admin/navigation/' . $preset . '_nav.png">
							</div>
							<div class="single-nav-hover">
								<div class="snh-inner">
									<div class="studio-edition">Studio Edition</div>
									<p>Unlock more navigations<br />with our Studio edition.</p>
									<a class="admin-click-handler semplice-button" data-handler="execute" data-action="studioFeatures" data-action-type="popup" data-feature="navigations">More Navigations</a>
								</div>
							</div>
							<p>' . $nav['display_name'] . '</p>
						</div>
					';
				} else {
					$nav_presets .= '
						<a class="preset admin-click-handler' . $class . '" data-handler="execute" data-action-type="customize" data-setting-type="navigations" data-action="addNavigation" data-preset="' . $nav['system_name'] . '">
							<div class="images">
								<img alt="' . $preset . ' bg" class="preset-bg-img" src="' . get_template_directory_uri() . '/assets/images/admin/navigation/' . $preset . '_bg.png">
								<img alt="' . $preset . ' nav" class="preset-nav-img" src="' . get_template_directory_uri() . '/assets/images/admin/navigation/' . $preset . '_nav.png">
							</div>
							<p>' . $nav['display_name'] . '</p>
						</a>
					';
				}
				// inc count
				$count ++;
			}
		}
	?>
	<div class="customize-inner navigation-presets">
		<div class="customize-heading presets-heading">
			<div class="inner">
				<div class="admin-row">
					<div class="sub-header admin-column">
						<h2 class="admin-title">Select your navigation preset</h2>
						<a class="close-presets {{isFirst}}" href="#customize/navigations"><?php echo get_svg('backend', '/icons/close_admin'); ?></a>
					</div>
				</div>
			</div>
		</div>
		<div class="customize-content">
			<div class="presets">
				<?php echo $nav_presets; ?>
			</div>
		</div>
	</div>
</script>
<script id="navigations-edit-template" type="text/template">
	<div class="customize-inner">
		<div class="customize-content">
			<div class="browser-top">
				<div class="dots">
					<div class="dot"></div>
					<div class="dot"></div>
					<div class="dot"></div>
				</div>	
			</div>
			{{content}}
		</div>
	</div>
</script>
<script id="np-logo-left-menu-right" type="text/template">
	<?php echo admin_api::$customize['navigations']->get_preset('preset_one', $nav_settings); ?>
</script>
<script id="np-logo-left-menu-left" type="text/template">
	<?php echo admin_api::$customize['navigations']->get_preset('preset_two', $nav_settings); ?>
</script>
<script id="np-logo-right-menu-left" type="text/template">
	<?php echo admin_api::$customize['navigations']->get_preset('preset_three', $nav_settings); ?>
</script>
<script id="np-logo-right-menu-right" type="text/template">
	<?php echo admin_api::$customize['navigations']->get_preset('preset_four', $nav_settings); ?>
</script>
<script id="np-logo-middle-menu-stacked" type="text/template">
	<?php echo admin_api::$customize['navigations']->get_preset('preset_six', $nav_settings); ?>
</script>
<script id="navigations-delete-template" type="text/template">
	<div id="navigations-delete" class="popup">
		<div class="popup-inner">
			<div class="popup-close admin-click-handler" data-handler="hidePopup">
				<?php echo get_svg('backend', '/icons/popup_close'); ?>
			</div>
			<div class="popup-content">
				<div class="important">
					<?php echo get_svg('backend', '/icons/popup_important'); ?>
				</div>
				<h3>Delete navigation</h3>
				<p>Are you sure you want to delete this navigation?</p>
			</div>
			<div class="popup-footer">
			<a class="admin-click-handler cancel" data-handler="hidePopup">Cancel</a><a class="admin-click-handler confirm semplice-button delete-button" data-handler="execute" data-action="remove" data-setting-type="navigations" data-action-type="customize" data-delete-id="{{id}}">Delete</a>
			</div>					
		</div>
	</div>
</script>
<!-- edit menu -->
<script id="navigations-edit-menu-template" type="text/template">
	<div class="edit-menu">
		<div class="close-popup-notice" data-mode="menu">
			<?php echo get_svg('backend', '/icons/ep_close_help'); ?>
		</div>
		<div class="content">
			{{content}}
		</div>
	</div>
</script>
<!-- add menu item -->
<script id="navigations-add-menu-item-template" type="text/template">
	<li class="ep-menu-item{{linkClass}}" data-ep-menu-item-id="{{id}}" data-type="{{type}}">
		<div class="ep-menu-item-inner">
			<div class="ep-menu-item-meta ep-menu-item-expand">
				<div class="ep-menu-item-handle ui-sortable-handle"></div>
				<div class="title">
					<p>{{title}}</p>
				</div>
				<div class="ep-meta-right">
					<div class="ep-menu-item-remove ep-posts-icon admin-click-handler" data-handler="execute" data-action-type="menu" data-action="remove" data-id="{{id}}"></div>
					<div class="ep-posts-icon ep-posts-expand-icon"></div>
				</div>
			</div>
			<div class="ep-menu-item-options">
				<div class="option">
					<div class="option-inner menu-item-title">
						<div class="attribute span4">
							<h4>Title</h4>
							<input type="text" name="menu_title" class="item-title admin-listen-handler" data-handler="menuItemTitle" value="{{title}}" placeholder="Title" data-id="{{id}}">
						</div>
					</div>
				</div>
				<div class="option">
					<div class="option-inner">
						<div class="attribute span2">
							<h4>Target</h4>
							<div class="select-box">
								<div class="sb-arrow"></div>
								<select name="menu_target" class="menu-target admin-listen-handler" data-handler="updateMenu">
									<option value="_self">Same Tab</option>
									<option value="_blank" ' . $target_blank . '>New Tab</option>
								</select>
							</div>
						</div>
						<div class="attribute span4">
							<h4>Classes</h4>
							<input type="text" name="menu_classes" class="item-classes admin-listen-handler" data-handler="updateMenu" value="" placeholder="Classes">
						</div>
					</div>
				</div>
				{{link}}
			</div>
		</div>
	</li>
</script>