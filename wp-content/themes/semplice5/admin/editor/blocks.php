<?php

// -----------------------------------------
// semplice
// admin/editor/blocks.php
// -----------------------------------------

class blocks {

	// public vars
	public $db;
	public $table_name;
	public $db_version;

	public function __construct() {

		// database
		global $wpdb;
		$this->db = $wpdb;
		$this->table_name = $wpdb->prefix . 'semplice_content_blocks';

		// db version
		$this->db_version = get_option("semplice_content_blocks_db_version");

		// add action
		add_action('init', array(&$this, 'status'));
	}

	// -----------------------------------------
	// get block
	// -----------------------------------------
	
	public function get($id, $type) {

		// get json
		switch($type) {
			case 'layout':
				$ram = file_get_contents(get_template_directory() . '/admin/editor/blocks/' . $id . '.json');
			break;
			case 'user':
				// get block from the db
				$block = $this->db->get_row("SELECT * FROM $this->table_name WHERE id = $id", ARRAY_A);
				// add content to ram
				$ram = $block['content'];
			break;
		}

		// decode
		$ram = json_decode($ram, true);

		// is content?
		if(is_array($ram)) {
			return semplice_generate_ram_ids($ram, false, true);
		} else {
			return 'noram';
		}
	}

	// -----------------------------------------
	// save block
	// -----------------------------------------

	public function save($content, $name, $mode, $masterblock) {
		// empty name?
		if(empty($name)) {
			$name = 'Untitled';
		}

		// mode
		if($mode == 'save') {
			// save block in the database
			$this->db->insert(
				$this->table_name,
				array(
					"name"		 	 => json_encode($name),
					"content"		 => $content,
					"masterblock"	 => $masterblock,
				)
			);
		} else {
			// update masterblock
			$this->db->update(
				$this->table_name, 
				array(
					"content"	  	=> $content,
				),
				array(
					"masterblock" 	=> $masterblock,
				)
			);
		}
		

		// output newest list
		return $this->user_blocks();
	}

	// -----------------------------------------
	// delete blocks
	// -----------------------------------------

	public function delete($id) {
		// delete block from db
		$this->db->delete($this->table_name, array('id' => $id));
	}

	// -----------------------------------------
	// list blocks
	// -----------------------------------------

	public function list_blocks() {
		// get layout blocks
		$layout_blocks = $this->layout_blocks();
		// return list
		return '
			<ul>
				<li><a class="blocks-default-tab" href="#layout">Layout Blocks</a></li>
				<li><a href="#user-defined">My Blocks</a></li>
			</ul>
			<div class="tab-content">
				<div id="layout" class="block-tab">
					<h4>Boost your workflow<br />with our layout blocks.</h4>
					<div class="layout-blocks">
						' . $layout_blocks . '
					</div>
				</div>
				<div id="user-defined" class="block-tab">
					' . $this->user_blocks() . '
				</div>
			</div>
		';
	}

	// -----------------------------------------
	// layout blocks
	// -----------------------------------------

	public function layout_blocks() {

		// types
		$types = array(
			'header' => array(
				'name' => 'Page Header',
				'count' => 3,
			),
			'fullscreen_image' => array(
				'name' => 'Fullscreen Image',
				'count' => 3,
			),
			'fullwidth_image' => array(
				'name' => 'Fullwidth Image',
				'count' => 2,
			),
			'columns' => array(
				'name' => 'Columns',
				'count' => 3,
			),
			'text' => array(
				'name' => 'Text Layout',
				'count' => 5,
			),
			'profile' => array(
				'name' => 'Profile',
				'count' => 5,
			),
			'team' => array(
				'name' => 'Team',
				'count' => 3,
			),
			'fiftyfifty' => array(
				'name' => 'Fifty Fifty',
				'count' => 4,
			),
			'imagegrid' => array(
				'name' => 'Image Grids',
				'count' => 6,
			),
			'imagecaption' => array(
				'name' => 'Image with Caption',
				'count' => 4,
			),
			'fluidgrid' => array(
				'name' => 'Fluid Grids',
				'count' => 5,
			),
			'editorial' => array(
				'name' => 'Editorial',
				'count' => 2,
			),
			'overlap' => array(
				'name' => 'Overlap',
				'count' => 3,
			),
			'quotes' => array(
				'name' => 'Quotes',
				'count' => 2,
			),
			'list' => array(
				'name' => 'Lists',
				'count' => 2,
			),
			'comingsoon' => array(
				'name' => 'Under construction',
				'count' => 3,
			),
			'footer' => array(
				'name' => 'Footer',
				'count' => 3,
			),
		);

		// vars
		$blocks = '';

		// loop through types
		foreach ($types as $type => $content) {
			// open block list
			$blocks .= '<ul class="layout-blocks-' . $type . ' layout-blocks-list">';
			// loop through blocks
			if($content['count'] > 0) {
				$column_left = '';
				$column_right = '';
				$blocks .= '<li>';
				for($i = 1; $i <= $content['count']; $i++) {
					$block_content = '<a class="semplice-block" data-block-id="' . $type . '_' . $i . '" data-block-type="layout"><img src="https://blocks.semplice.com/v5/images/preview/' . $type . '_' . $i . '.jpg"></a>';
					if($i % 2 == 0) {
						$column_right .= $block_content;
					} else {
						$column_left .= $block_content;
					}
				}
				$blocks .= '
						<p class="blocks-head">' . $content['name'] . '</p>
						<div class="blocks-columns">
							<div class="blocks-columns-left">' . $column_left . '</div>
							<div class="blocks-columns-right">' . $column_right . '</div>
						</div>
					</li>
				';
			}
			// close blocklist
			$blocks .= '</ul>';
		}

		// output list
		return $blocks;
	}

	// -----------------------------------------
	// user blocks
	// -----------------------------------------

	public function user_blocks() {
		
		// output
		$output = '';

		// get blocks
		$blocks = $this->db->get_results( 
			"
			SELECT * 
			FROM $this->table_name
			ORDER BY ID DESC
			"
		);

		if(!empty($blocks)) {

			// list start
			$output .= '
				<h4>Add & Customize your<br />personal blocks.</h4>
				<ul class="user-defined">
			';

			// loop throuh blocks
			foreach($blocks as $block) {

				// masterblock
				$masterblock = '';
				if(strpos($block->masterblock, 'master_') !== false) {
					$masterblock = '<span class="masterblock-label">Master</span>';
				}
				
				$output .= '
					<li id="block-' . $block->id . '">
						<a class="semplice-block editor-action" data-action-type="blocks" data-action="add" data-block-id="' . $block->id . '" data-block-type="user" data-masterblock-id="' . $block->masterblock . '">
							<h5>' . json_decode($block->name) . $masterblock . '</h5>
						</a>
						<a class="remove-block editor-action" data-action-type="popup" data-action="deleteBlock" data-block-id="' . $block->id . '" data-masterblock-id="' . $block->masterblock . '"></a>
					</li>
				';
				
			}

			// list end
			$output .= '</ul>';
		} else {
			// empty state
			$output .= '
				<div class="no-blocks">
					<div class="inner">
						<p>Hey! You can also<br />create your own blocks.</p>
						<a class="semplice-button" href="https://www.semplice.com/videos#blocks" target="_blank">See how it works</a>
						<a class="blocks-help-video" href="https://www.semplice.com/videos#blocks" target="_blank"></a>
					</div>
				</div>
			';
		}

		// output
		return $output;
	}

	// -----------------------------------------
	// check db status
	// -----------------------------------------

	public function status() {

		// atts
		$atts = array(
			'db_version' => '1.1',
			'is_update'  => false
		);

		// check if table is already created
		if($this->db->get_var("SHOW TABLES LIKE '$this->table_name'") !== $this->table_name || $this->db_version !== $atts['db_version']) {
			// setup blocks (install or update)
			$this->setup($atts);
		}
	}

	// -----------------------------------------
	// setup database for blocks
	// -----------------------------------------

	public function setup($atts) {
		// charset
		$charset_collate = $this->db->get_charset_collate();

		// database tables
		$atts['sql'] = "CREATE TABLE $this->table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				name tinytext NOT NULL,
				content longtext NOT NULL,
				masterblock tinytext NOT NULL,
				UNIQUE KEY id (id)
			) $charset_collate;";

		// install or update table
		if (!function_exists('blocks_db_install')) {
			function blocks_db_install($atts) {
		
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				
				dbDelta($atts['sql']);

				// update db version
				update_option('semplice_content_blocks_db_version', $atts['db_version']);
			}
		}
		
		// check if table exists, if not install table
		if($this->db->get_var("SHOW TABLES LIKE '$this->table_name'") !== $this->table_name) {
			blocks_db_install($atts);
		}

		if ($this->db_version !== $atts['db_version']) {

			// is update
			$atts['is_update'] = true;
			
			// update db
			blocks_db_install($atts);
			
		}
	}
}
?>