<?php

// -----------------------------------------
// semplice
// admin/editor/animate.php
// -----------------------------------------

if(!class_exists('animate_api')) {
	class animate_api {

		// public vars
		public $animate;
		public $detect;
		public $post_id;
		public $script_execution;

		public function __construct() {
			global $detect;
			$this->detect = $detect;
		}

		// -----------------------------------------
		// get motion output
		// -----------------------------------------

		public function get_motion_output($output, $atts, $id, $mode, $post_id) {
			// vars
			$presets = semplice_get_animate_presets();
			$atts = $atts[$id];
			$is_lottie = $this->is_lottie($atts);
			
			// mobile
			if(true === $is_lottie) {
				$mobile = isset($atts['options']['mobile']) ? $atts['options']['mobile'] : 'on';
			} else {
				$mobile = isset($atts['motions']['mobile']) ? $atts['motions']['mobile'] : 'on';
			}

			// event
			$event = 'on_load';
			if(isset($atts['motions']['event'])) {
				$event = $atts['motions']['event'];
			}

			// check if id is cover and change it
			if($id == 'cover') {
				$id = 'cover-' . $post_id;
			}

			// are there motions to mirgrate or is a preset attached??
			if(!empty($atts['motions']['active'])) {
				$atts['motions'] = $this->migrate_motions($id, $atts);
			} else if(!empty($atts['motions']['preset']) && isset($presets['custom'][$atts['motions']['preset']])) {
				$atts['motions'] = $presets['custom'][$atts['motions']['preset']];
				// add back event
				$atts['motions']['event'] = $event;
			}

			// remove z-index if set
			if(isset($atts['motions']['initial']) && isset($atts['motions']['initial']['z-index'])) {
				unset($atts['motions']['initial']['z-index']);
			}

			// get motion css and js
			if(true === $this->detect->isMobile() && $mobile == 'on' || false === $this->detect->isMobile()) {
				if(!empty($atts['motions']['timeline']) || true === $is_lottie) {
					// get css
					if(false === $is_lottie) {
						$output['motion']['css'] .= $this->get_motion_css('css', $atts, $atts['motions'], $id);
					}
					// add to output
					$output['motion']['js'] .= $this->get_motion_js($atts, $id, $is_lottie);
				}
			}

			// return
			return $output;
		}

		// -----------------------------------------
		// is lottie?
		// -----------------------------------------

		public function is_lottie($atts) {
			// default
			$is_lottie = false;
			if(isset($atts['module']) && $atts['module'] == 'lottie') {
				// get content
				$content = $atts['content']['xl'];
				// get lottie url
				if(isset($content['id'])) {
					$url = wp_get_attachment_url($content['id']);
					// has content + width and height defined?
					if(false !== $url && isset($content['width']) && isset($content['height'])) {
						$is_lottie = true;
					}
				}
			}
			return $is_lottie;
		}

		// -----------------------------------------
		// motion css
		// -----------------------------------------

		public function get_motion_css($mode, $atts, $motions, $id) {
			// vars
			$css = array('regular' => array(), 'transform' => array(), 'boxShadow' => array(), 'gradient' => array(), 'filter' => array());
			$output_css = '';
			$text_color_css = '';
			$transform = '';
			$box_shadow = '';
			$gradient = '';
			$gsap_set = array();
			$module = isset($atts['module']) ? $atts['module'] : false;
			$selector = $this->get_selector($id, $atts);
			$bg_image_url = $this->get_bg_image_url($atts['styles']['xl']);
			// first get initial defaults
			$initial_defaults = $this->get_initial_defaults($css, $motions['initial']);
			// add values from initial state
			$css = $this->get_effects_css($css, $initial_defaults);
			// text color
			if(isset($css['regular']['color']) && $css['regular']['color'] != 'transparent') {
				$text_color_css = $selector . ' * { color: inherit !important; }';
			} else if(isset($css['regular']['color']) && $css['regular']['color'] == 'transparent') {
				unset($css['regular']['color']);
			}
			// remove background-color from modules
			if(false !== $module) {
				unset($css['regular']['background-color']);
				$bg_image_url = 'none';
			}
			// generate regular css
			if(!empty($css['regular'])) {
				foreach ($css['regular'] as $attribute => $value) {
					$output_css .= $attribute . ': ' . $value . ';';
				}
			}
			// get box shadow
			$box_shadow = $this->box_shadow($css['boxShadow'], $module);
			// add box shadow to css
			if(false !== $box_shadow) {
				if($module == 'text' || $module == 'paragraph') {
					$output_css .= 'text-shadow: ' . $box_shadow . ';';
				} else {
					$output_css .= 'box-shadow: ' . $box_shadow . ';';
				}
			}
			// get gradient
			$gradient = $this->gradient($css['gradient'], $bg_image_url);
			// add gradient to css
			if(false !== $gradient) {
				$output_css .= 'background-image: ' . $gradient . ';';
			}
			// get filter state
			$filter_initial = $this->get_filter_state($motions, 'initial');
			if(false !== $filter_initial && is_array($filter_initial) && !empty($filter_initial)) {
				foreach ($filter_initial as $filter => $value) {
					$css['filter'][$filter] = $value;
				}
			}
			// get filter
			$filter = $this->filter($css['filter']);
			// add filter to css
			if(false !== $filter && !empty($filter)) {
				$output_css .= 'filter: ' . $filter . ';';
				$gsap_set['filter'] = $filter;
			}
			// generate transform css
			if(!empty($css['transform'])) {
				$transformOrder = array('translateY', 'translateX', 'rotate', 'rotateY', 'rotateX', 'skew', 'scale');
				foreach ($transformOrder as $key => $attribute) {
					$value = false;
					if(isset($css['transform'][$attribute])) {
						$value = $css['transform'][$attribute];
					}
					if(strpos($attribute, 'rotate') !== false) {
						$value = $value . 'deg';
					}
					// combine skew and scale so the animation looks like gsap
					if($attribute == 'skew' || $attribute == 'scale') {
						$unit = '';
						if($attribute == 'skew') {
							$unit = 'deg';
						}
						$transform .= ' ' . $attribute . '(' . $css['transform'][$attribute . 'X'] . $unit . ',' . $css['transform'][$attribute . 'Y'] . $unit . ')';
						// set individual values for gsap
						$gsap_set[$attribute . 'X'] = $css['transform'][$attribute . 'X'] . $unit;
						$gsap_set[$attribute . 'Y'] = $css['transform'][$attribute . 'Y'] . $unit;
					} else {
						$transform .= ' ' . $attribute . '(' . $value . ')';
						$gsap_set[$attribute] = $value;
					}
				}
			}
			// transform css available?
			if(strlen($transform) > 0) {
				$output_css .= 'transform:' . $transform . ';';
			}
			// output
			if($mode == 'css') {
				return $selector . '{' . $output_css . '}' . $text_color_css;
			} else {
				return $gsap_set;
			}
		}

		// -----------------------------------------
		// get motion js
		// -----------------------------------------

		public function get_motion_js($atts, $id, $is_lottie) {
			// output
			$output = 'var playRepeat = [];';
			$selector = $this->get_selector($id, $atts);
			$options = false;
			// get gsap element or lottie
			$lottiePlayback = array(
				'onStart' => '',
				'play' => '',
				'pause' => ''
			);
			if(true === $is_lottie) {
				$motions = $atts['options'];
				$gsap_props = $this->get_lottie_element($id, $atts['options']);
				// call lottie
				$lottie = $atts['content']['xl'];
				$url = wp_get_attachment_url($lottie['id']);
				$output = 's4.helper.lottie("' . $id . '", "' . $url . '", JSON.parse(\'' . json_encode($atts['options']) . '\'), ' . $lottie['width'] . ', ' . $lottie['height'] . ');';
				// lottie play for gsap
				$lottiePlayback = array(
					'onStart' => '
						onStart: function() {
							// start lottie animation
							s4.animate.lottie["' . $id . '"].play();
						}
					',
					'play' => 's4.animate.lottie["' . $id . '"].play();',
					'pause' => 's4.animate.lottie["' . $id . '"].pause();'
				);
			} else {
				$motions = $atts['motions'];
				$gsap_props = $this->get_gsap_element($id, $atts);
			}
			// event
			$event = $gsap_props['event'];
			switch ($event) {
				case 'on_scroll':
					// default trigger settings
					$trigger = array('start_trigger' => 'top', 'start_scroller' => 'bottom', 'end_trigger' => 'bottom', 'end_scroller' => 'top');
					// iterate triggers
					foreach ($trigger as $attr => $dir) {
						// has value in ram?
						if(isset($motions['migrated']) && $attr == 'end_trigger') {
							// add to js output
							if(isset($motions[$attr])) {
								$output .= 'var endDuration = ' . $motions[$attr] . ';';
							} else {
								$output .= 'var endDuration = 50;';
							}
							$trigger[$attr] = 'migrated';
						} else if(isset($motions[$attr]) && $motions[$attr] != 0) {
							$prefix = '+';
							if($motions[$attr] < 0) {
								$prefix = '-';
							}
							$trigger[$attr] = $trigger[$attr] . $prefix . '=' . abs($motions[$attr]) . '%';
						} else {
							$trigger[$attr] = $trigger[$attr];
						}
					}
					// start and end
					$start = $trigger['start_trigger'] . ' ' . $trigger['start_scroller'];
					$end = $trigger['end_trigger'] . ' ' . $trigger['end_scroller'];
					if(isset($motions['pin']) && true === semplice_boolval($motions['pin'])) {
						if(isset($motions['pin_duration'])) {
							$end = '+=' . $motions['pin_duration'] . '%';
						} else {
							$end = '+=50%';
						}
					}
					// options
					$options = array(
						'id' => $id,
						'trigger' => $selector,
						'start' => $start,
						'end' => $end,
						'pin' => false,
						'markers' => false,
						'pinSpacing' => false,
						'scrub' => 0
					);
					// numeric
					$numeric = array('scrub');
					// iterate defaults and add values from motions
					foreach ($options as $attr => $default_val) {
						if(isset($motions[$attr])) {
							$val = $motions[$attr];
							// true false and numeric?
							if($val == 'true' || $val == 'false') {
								$val = semplice_boolval($val);
							} else if(in_array($attr, $numeric)) {
								$val = floatval($val);
							}
							$options[$attr] = $val;
						}
					}
					// encode options
					$output .= 'var options = JSON.parse(\'' . json_encode($options) . '\');';
					// migrated end trigger
					if(isset($motions['migrated']) && isset($motions['end_trigger'])) {
						// calculate end trigger
						$output .= '
							if(typeof endDuration !== "undefined") {
								var vpHeight = parseInt($(window).height());
								var content = document.getElementById("' . $id . '");
								var contentRect = content.getBoundingClientRect();
								var contentHeight = contentRect.height;
								var newEnd = Math.round(((endDuration * (vpHeight / 100)) - contentHeight) / (contentHeight / 100));
								// changing end
								if(false !== newEnd && null !== newEnd) {
									options["end"] = options["end"].replace("migrated", "bottom+=" + newEnd + "%");
								}
							}
						';
					}
					// add on update
					if(true === $is_lottie) {
						$output .= '
							var timeObj = { currentFrame: 0 };
							options["onUpdate"] = function(self) {
								gsap.to(timeObj, {
									duration: 0,
									currentFrame:(Math.floor(self.progress *  (s4.animate.lottie["' . $id . '"].totalFrames - 1))),
									onUpdate: function() {
										s4.animate.lottie["' . $id . '"].goToAndStop(timeObj.currentFrame, true);
									},
								});
							}
						';
					}
					$output .= '
						if(options.pin === true) {
							if("' . $id . '".indexOf("section_") > -1 || "' . $id . '".indexOf("cover") > -1) {
								$("#' . $id . '").wrap("<div class=\'section-pin sp_' . $id . '\'></div>");
								options["trigger"] = ".sp_' . $id . '";
							} else if("' . $id . '".indexOf("column_") > -1) {
								$("#' . $id . '").wrap("<div class=\'column-pin-outer cpo_' . $id  . '\'><div class=\'column-pin-inner cpi_' . $id . ' \'></div></div>");
								options["trigger"] = ".cpi_' . $id . '";
								var atts = $("#' . $id . '").prop("attributes");
								$.each(atts, function(key, attr) {
									if(attr.name.indexOf("width") > -1) {
										$(".cpo_' . $id  . '").attr(attr.name, attr.value);
									}
								});
							} else if("' . $id . '".indexOf("content_") > -1) {
								options["trigger"] = "#' . $id  . '";
							}
							' . $this->get_z_index($atts, $id) . '
						}
						s4.animate.gsap["' . $id . '"] = gsap.timeline({
							scrollTrigger: options,
						});
					';
				break;
				case 'on_load':
					$output .= '
						s4.animate.gsap["' . $id . '"] = gsap.timeline({
							scrollTrigger: "' . $selector . '",
							repeat: ' . $gsap_props['repeat'] . ',
							' . $lottiePlayback['onStart'] . '
						});
					';
				break;
				case 'on_click':
				case 'on_hover':
					$output .= '
						s4.animate.gsap["' . $id . '"] = gsap.timeline({
							repeat: ' . $gsap_props['repeat'] . ',
							onRepeat: function() {
								if(playRepeat["' . $id . '"] !== true) {
									s4.animate.gsap["' . $id . '"].pause();
								}
							},
							' . $lottiePlayback['onStart'] . '
						});
					';
				break;
			}
			// event handler
			if($event == 'on_click') {
				$output .= '
					$(document).on("click", "' . $selector . '", function() {
						s4.animate.gsap["' . $id . '"].play();
					});
					// add pointer
					$("' . $selector . '").css("cursor", "pointer");
				';
			} else if($event == 'on_hover') {
				$lottie_start = '';
				$lottie_pause = '';
				if(true === $is_lottie) {
					$lottie_start = 's4.animate.lottie["' . $id . '"].play();';
					$lottie_pause = 's4.animate.lottie["' . $id . '"].pause();';
				}
				$output .= '
					$(document).on("mouseover", "' . $selector . '", function() {
						s4.animate.gsap["' . $id . '"].play();
						playRepeat["' . $id . '"] = true;
						' . $lottiePlayback['play'] . '
					});
					$(document).on("mouseout", "' . $selector . '", function() {
						s4.animate.gsap["' . $id . '"].reverse();
						playRepeat["' . $id . '"] = false;
						' . $lottiePlayback['pause'] . '
					});
				';
			}
			// check if timeline is defined and add steps to timeline (check is needed for lottie onscroll animations which has no timeline)
			if(isset($gsap_props['timeline']) && !empty($gsap_props['timeline'])) {
				foreach ($gsap_props['timeline'] as $step => $step_animation) {
					// is there transform to set?
					if(isset($step_animation['css'])) {
						$css = json_encode($step_animation['css']);
						if(!empty(json_decode($css, true))) {
							$output .= '
								// gsap set transform
								gsap.set("' . $selector . '", JSON.parse(\'' . $css . '\'));
							';
						}
					}
					$output .= '
						// parse props
						var props = JSON.parse(\'' . json_encode($step_animation['props']) . '\');
						// add to timeline
						s4.animate.gsap["' . $id . '"].to("' . $selector . '", props);
						// pause timeline
						s4.animate.gsap["' . $id . '"].pause();
					';
				}
			}
			// return
			return $output;
		}

		// -----------------------------------------
		// get z index
		// -----------------------------------------

		public function get_z_index($atts, $id) {
			$selector = '#' . $id;
			if(strpos($id, 'section_') !== false || strpos($id, 'cover') !== false) {
				$selector = '.sp_' . $id;
			}
			if(isset($atts['styles']['xl']) && isset($atts['styles']['xl']['z-index'])) {
				$z_index = $atts['styles']['xl']['z-index'];
				if(is_numeric($z_index)) {
					return 'gsap.set("' . $selector . '", {zIndex: "' . $z_index . '"});';
				}
			}
		}

		// -----------------------------------------
		// get box shadow
		// -----------------------------------------

		public function box_shadow($box_shadow_values, $module) {
			// define
			$box_shadow = false;
			if(!empty($box_shadow_values)) {
				$box_shadow = '';
				// bsopacity
				$box_shadow_opacity = 1;
				$box_shadow_color = '#ffd300';
				$is_default = true;
				foreach ($box_shadow_values as $attribute => $value) {
					// is default?
					if(strpos(strval($value), 'rem') !== false && floatval($value) > 0) {
						$is_default = false;
					}
					// change defaults or add to css instantly
					if(strpos($attribute, 'opacity') !== false) {
						$box_shadow_opacity = $value;
					} else if(strpos($attribute, 'color') !== false && true === ctype_xdigit(str_replace('#', '', $value)) && strlen(str_replace('#', '', $value)) == 6) {
						$box_shadow_color = $value;
					} else {
						// has rem?
						if(is_numeric($value)) {
							$value .= 'rem';
						}
						if($attribute == 'box-shadow-spread-radius' && $module == 'paragraph' || $attribute == 'box-shadow-spread-radius' && $module == 'text') {
							$box_shadow = $box_shadow;
						} else {
							$box_shadow .= $value . ' ';
						}
					}
				}
				if(false === $is_default) {
					// color and opacity
					$rgb = semplice_hex_to_rgb($box_shadow_color);
					// generate shadow
					$box_shadow .= 'rgba(' . $rgb['r'] . ',' . $rgb['g'] . ',' . $rgb['b'] . ',' . $box_shadow_opacity . ')';
				} else {
					$box_shadow = false;
				}
			}
			// return box shadow
			return $box_shadow;
		}

		// -----------------------------------------
		// linear gradient
		// -----------------------------------------

		public function gradient($gradient_values, $bg_image_url) {
			// define
			$gradient = false;
			// bg image
			$bg_image = '';
			if(false !== $bg_image_url && $bg_image_url != 'none') {
				$bg_image = ', ' . $bg_image_url;
			}
			// iterate gradient values
			if(!empty($gradient_values)) {
				$gradient = '';
				// defaults
				$defaults = array(
					'gradient_angle' => 0,
					'gradient_color_1' => '#000000',
					'gradient_color_1_opacity' => 0,
					'gradient_color_1_progress' => 0,
					'gradient_color_2' => '#000000',
					'gradient_color_2_opacity' => 1,
					'gradient_color_2_progress' => 100
				);
				foreach ($defaults as $attribute => $value) {
					// has value?
					if(isset($gradient_values[$attribute])) {
						$defaults[$attribute] = $gradient_values[$attribute];
					}
				}
				// color and opacity
				$rgb1 = semplice_hex_to_rgb($defaults['gradient_color_1']);
				$rgb2 = semplice_hex_to_rgb($defaults['gradient_color_2']);
				// generate shadow
				$gradient .= 'linear-gradient(' . $defaults['gradient_angle'] . 'deg, rgba(' . $rgb1['r'] . ','. $rgb1['g'] . ',' . $rgb1['b'] . ',' . $defaults['gradient_color_1_opacity'] . ') ' . $defaults['gradient_color_1_progress'] . '%, rgba(' . $rgb2['r'] . ',' . $rgb2['g'] . ',' . $rgb2['b'] . ',' . $defaults['gradient_color_2_opacity'] . ') ' . $defaults['gradient_color_2_progress'] . '%)' . $bg_image;
			}
			// return gradient
			return $gradient;
		}

		// -----------------------------------------
		// filter
		// -----------------------------------------

		public function filter($filter_values) {
			$filter = false;
			// order
			ksort($filter_values);
			// iterate filter values
			if(!empty($filter_values)) {
				$filter = '';
				// iterate filters
				foreach ($filter_values as $attribute => $value) {
					$unit = '%';
					// change unit individualle
					if($attribute == 'filter_blur') { $unit = 'px'; }
					if($attribute == 'filter_hue-rotate') { $unit = 'deg'; }
					// add to filter
					$filter .= str_replace('filter_', '', $attribute) . '(' . $filter_values[$attribute] . $unit . ') ';
				}
			}
			// return gradient
			return $filter;
		}

		// -----------------------------------------
		// get filter state
		// -----------------------------------------

		public function get_filter_state($motions, $step) {
			// define css
			$css = array('filter' => array());
			// filters
			$used_filters = array();
			// first get initial defaults
			$initial_defaults = $this->get_initial_defaults($css, $motions['initial']);
			// effects defaults
			$effects_defaults = $this->get_effects_defaults();
			// itearte initial defautls and add all used filters to list
			foreach ($initial_defaults as $attribute => $value) {
				if(false !== strpos($attribute, 'filter_') && !in_array($attribute, $used_filters) && intval($value) !== $effects_defaults[$attribute][$attribute]) {
					$used_filters[] = $attribute;
				}
			}
			// iterate all steps and add used filters to list
			foreach ($motions['timeline'] as $key => $animation) {
				$effects = $animation['effects'];
				if(!empty($effects)) {
					foreach ($effects as $effect => $value) {
						if(false !== strpos($effect, 'filter_') && !in_array($effect, $used_filters)) {
							$used_filters[] = $effect;
						}
					}
				}
			}
			// first add defaults to used filters
			foreach ($used_filters as $filter) {
				// add to css
				$css['filter'][$filter] = $initial_defaults[$filter];
			}
			// finally add stepp values
			if($step != 'initial') {
				for($i=0; $i<=$step; $i++) {
					$effects = $motions['timeline'][$i]['effects'];
					$shadow_props = array();
					if(!empty($effects)) {
						foreach ($effects as $effect => $value) {
							if(false !== strpos($effect, 'filter_')) {
								$css['filter'][$effect] = $value;
							}
						}
					}
				}
			}
			return $css['filter'];
		}

		// -----------------------------------------
		// migrate old motions
		// -----------------------------------------

		public function migrate_motions($id, $atts) {
			// motions
			$motions = $atts['motions'];
			// event
			$event = isset($motions['event']) ? $motions['event'] : 'on_load';
			// get initial styles
			$initial = $this->generate_initial_styles($atts);
			// init new motion structure
			$migrated = array(
				'event' => $event,
				'initial' => $initial,
				'timeline' => array(),
				'migrated' => true
			);
			// old defaults
			$defaults = array(
				'duration' => 800,
				'delay' => 0,
				'easing' => 'Power0.easeNone', 
			);
			// add global options timeline
			$migrated['timeline'][0] = array(
				'duration' => isset($motions['duration']) ? $motions['duration'] : $defaults['duration'],
				'delay' => isset($motions['delay']) ? $motions['delay'] : $defaults['delay'],
				'ease' => isset($motions['easing']) ? $motions['easing'] : $defaults['easing'],
				'effects' => array()
			);
			// add effects to timeline
			foreach ($motions['active'] as $key => $effect) {
				// initial values
				if(isset($motions['start'][$effect]) && $effect != 'scale' && $effect != 'move') {
					if($effect == 'rotate') {
						$motions['start'][$effect] = intval($motions['start'][$effect]);
					}
					$migrated['initial'][$effect] = $motions['start'][$effect];
				} else if(isset($motions['start'][$effect]) && $effect == 'scale') {
					$migrated['initial']['scaleX'] = $motions['start'][$effect];
					$migrated['initial']['scaleY'] = $motions['start'][$effect];
				} else if($effect == 'move') {
					$migrated['initial']['translateX'] = $motions['start']['translateX'];
					$migrated['initial']['translateY'] = $motions['start']['translateY'];
				}
				// add to effects
				if(isset($motions['end'][$effect]) && $effect != 'scale' && $effect != 'move') {
					if($effect == 'rotate') {
						$motions['end'][$effect] = intval($motions['end'][$effect]);
					}
					$migrated['timeline'][0]['effects'][$effect] = $motions['end'][$effect];
				} else if(isset($motions['end'][$effect]) && $effect == 'scale') {
					$migrated['timeline'][0]['effects']['scaleX'] = $motions['end'][$effect];
					$migrated['timeline'][0]['effects']['scaleY'] = $motions['end'][$effect];
				} else if($effect == 'move') {
					$migrated['timeline'][0]['effects']['translateX'] = $motions['end']['translateX'];
					$migrated['timeline'][0]['effects']['translateY'] = $motions['end']['translateY'];
				}
			}
			// on scroll
			if($event == 'on_scroll') {
				// on scroll atts
				$on_scroll_atts = array('onscroll_duration', 'onscroll_movement', 'push_followers');
				// iterate atts
				foreach ($on_scroll_atts as $key => $attribute) {
					if(isset($motions[$attribute])) {
						switch($attribute) {
							case 'onscroll_duration':
								// use as pin duration if sticky
								if(isset($motions['onscroll_movement']) && $motions['onscroll_movement'] == 'sticky') {
									$migrated['pin_duration'] = intval($motions[$attribute]);
								} else {
									$migrated['end_trigger'] = intval($motions[$attribute]);
								}
							break;
							case 'onscroll_movement':
								$migrated['pin'] = ($motions[$attribute] == 'sticky') ? 'true' : 'false';
							break;
							case 'push_followers':
								$migrated['pinSpacing'] = ($motions[$attribute] == 'enabled') ? 'true' : 'false';
							break;
						};
					}
				}
				// if no pin duration or end trigger, add the 50% end trigger default
				if(!isset($migrated['pin_duration']) && !isset($migrated['end_trigger'])) {
					if(isset($motions['onscroll_movement']) && $motions['onscroll_movement'] == 'sticky') {
						$migrated['pin_duration'] = 50;
					} else {
						$migrated['end_trigger'] = 50;
					}
				}
				// trigger hook
				$migrated['start_scroller'] = -50;
				if(isset($motions['trigger_hook']) && $motions['trigger_hook'] != 'custom') {
					$triggerHook = array(
						'.5' => -50,
						'onLeave' => -100,
						'onEnter' => 0
					);
					$migrated['start_scroller'] = $triggerHook[$motions['trigger_hook']];
				} else if(isset($motions['trigger_hook_custom'])) {
					$value = 100 - intval($motions['trigger_hook_custom']);
					if($value > 0) {
						$value = -1 * abs($value);
					}
					$migrated['start_scroller'] = $value;
				}
				// set the end to start since in scrollMagic there was only 1 trigger
				$migrated['end_scroller'] = $migrated['start_scroller'] + 100;
			}
			return $migrated;
		}

		// -----------------------------------------
		// generate initial styles
		// -----------------------------------------

		public function generate_initial_styles($atts) {
			// initial
			$initial = array();
			// get default styles if available
			$animate_styling = array('opacity', 'background-color', 'border-color', 'border-width', 'box-shadow-color', 'box-shadow-h-length', 'box-shadow-v-length', 'box-shadow-blur-radius', 'box-shadow-spread-radius', 'box-shadow-opacity');
			foreach ($animate_styling as $key => $attribute) {
				// define val
				$val = false;
				// button module individual
				if(isset($atts['module']) && $atts['module'] == 'button' && isset($atts['options'][$attribute])) {
					$val = $atts['options'][$attribute];
				} else if(isset($atts['styles']['xl'][$attribute])) {
					$val = $atts['styles']['xl'][$attribute];
				}
				// add rem to box shadow values if val true
				if(false !== $val) {
					if(strpos($attribute, 'box-shadow') !== false && strpos($attribute, 'color') === false && strpos($attribute, 'opacity') === false) {
						$initial[$attribute] = ($val / 18) . 'rem';
					} else {
						$initial[$attribute] = $val;
					}
				}
			}
			// ret
			return $initial;
		}

		// -----------------------------------------
		// get initial defaults
		// -----------------------------------------

		public function get_initial_defaults($css, $initial_values) {
			// remove dropshadow
			if(isset($initial_values['filter_drop-shadow'])) {
				unset($initial_values['filter_drop-shadow']);
			}
			$defaults = $this->get_effects_defaults();
			$transform = array('scaleX', 'scaleY', 'translateX', 'translateY', 'rotate', 'rotateX', 'rotateY', 'skewX', 'skewY');
			foreach ($defaults as $effect_group => $effects) {
				foreach ($effects as $effect => $val) {
					if(!isset($initial_values[$effect])) {
						$initial_values[$effect] = $val;
					}
				}
			}
			return $initial_values;
		}
		// -----------------------------------------
		// get effects defaults
		// -----------------------------------------

		public function get_effects_defaults() {
			return array(
				'opacity' => array(
					'opacity' => 1,
				),
				'border' => array(
					'border-color' => '#000000',
					'border-width' => 0,
				),
				'box-shadow' => array(
					'box-shadow-color' => '#000000',
					'box-shadow-h-length' => 0,
					'box-shadow-v-length' => 0,
					'box-shadow-blur-radius' => 0,
					'box-shadow-spread-radius' => 0,
					'box-shadow-opacity' => 1,
				),
				'background-color' => array(
					'background-color' => 'transparent',
				),
				'color' => array(
					'color' => 'transparent',
				),
				'gradient' => array(
					'gradient_applyto' => 'background',
					'gradient_angle' => 0,
					'gradient_color_1' => '#000000',
					'gradient_color_1_opacity' => 0,
					'gradient_color_1_progress' => 0,
					'gradient_color_2' => '#000000',
					'gradient_color_2_opacity' => 0,
					'gradient_color_2_progress' => 100
				),
				'move' => array(
					'translateX' => 0,
					'translateY' => 0
				),
				'rotate' => array(
					'rotate' => 0,
				),
				'rotate3d' => array(
					'rotateX' => 0,
					'rotateY' => 0
				),
				'scale' => array(
					'scaleX' => 1,
					'scaleY' => 1
				),
				'skew' => array(
					'skewX' => 0,
					'skewY' => 0
				),
				'filter_blur' => array(
					'filter_blur' => 0,
				),
				'filter_brightness' => array(
					'filter_brightness' => 100,
				),
				'filter_contrast' => array(
					'filter_contrast' => 100,
				),
				'filter_grayscale' => array(
					'filter_grayscale' => 0,
				),
				'filter_hue-rotate' => array(
					'filter_hue-rotate' => 0,
				),
				'filter_invert' => array(
					'filter_invert' => 0,
				),
				'filter_saturate' => array(
					'filter_saturate' => 100,
				),
			);
		}

		// -----------------------------------------
		// get effects css
		// -----------------------------------------

		public function get_effects_css($css, $effects) {
			// effects defaults
			$effects_defaults = $this->get_effects_defaults();
			// transform
			$transform = array('scaleX', 'scaleY', 'translateX', 'translateY', 'rotate', 'rotateX', 'rotateY', 'skewX', 'skewY');
			foreach ($effects as $effect => $value) {
				// rem kommastsellen matchen mit gsap
				if(strpos(strval($value), 'rem') !== false && $effect != 'filter_drop-shadow') {
					$value = floatval(str_replace('rem', '', $value));
					if($value > 0) {
						$value = number_format($value, 4) . 'rem';
					} else {
						$value .= 'rem';
					}
				}
				// is transform effect?
				if(in_array($effect, $transform)) {
					$css['transform'][$effect] = $value;
				} else if(strpos($effect, 'box-shadow') !== false) {
					$css['boxShadow'][$effect] = $value;
				} else if(strpos($effect, 'gradient') !== false) {
					$css['gradient'][$effect] = $value;
				} else if(strpos($effect, 'filter_') !== false && intval($value) !== $effects_defaults[$effect][$effect]) {
					$css['filter'][$effect] = $value;
				} else if(strpos($effect, 'filter_') === false) {
					$css['regular'][$effect] = $value;
				}
			}
			return $css;
		}

		// -----------------------------------------
		// get selector
		// -----------------------------------------

		public function get_selector($id, $atts) {
			$selector = '#content-holder #' . $id;
			$module = isset($atts['module']) ? $atts['module'] : false;
			// exclude from is content
			$exclude = array('advancedportfoliogrid', 'portfoliogrid', 'dribbble', 'instagram', 'gallerygrid', 'video');
			// if module add to selector
			if(strpos($id, 'content_') !== false && !in_array($module, $exclude)) {
				$selector .= ' .is-content';
			}
			// return
			return $selector;
		}

		// -----------------------------------------
		// get bg image url
		// -----------------------------------------

		public function get_bg_image_url($styles) {
			// define url
			$url = false;
			// get background image
			if(!empty($styles['background-image'])) {
				if(!isset($styles['background_type']) || $styles['background_type'] != 'vid') {
					if(!is_numeric($styles['background-image'])) {
						$bg_image = semplice_get_external_image($styles['background-image']);
						$bg_image[0] = $bg_image['url'];
					} else {
						$bg_image = wp_get_attachment_image_src($styles['background-image'], 'full');
					}
					if (false !== $bg_image) {
						$url = 'url(' . $bg_image[0] . ')';
					}
				}
			}
			// return
			return $url;
		}

		// -----------------------------------------
		// get gsap element
		// -----------------------------------------

		public function get_gsap_element($id, $atts) {
			// vars
			$gsap = array();
			$motions = $atts['motions'];
			$count = 0;
			$repeat = 0;
			// set event
			if(!isset($motions['event'])) {
				$motions['event'] = 'on_load';
			}
			// repeat and loop
			if(isset($motions['loop']) && $motions['loop'] == 'yes') {
				$repeat = -1;
			} else if(isset($motions['repeat'])) {
				$repeat = intval($motions['repeat']) - 1;
			}
			// set basic gsap element
			$gsap = array('repeat' => $repeat, 'timeline' => array(), 'event' => $motions['event']);
			// steps
			$steps = count($motions['timeline']);
			// get gsap set
			$css = $this->get_motion_css('gsap', $atts, $atts['motions'], $id);
			// iterate steps
			foreach ($motions['timeline'] as $key => $animation) {
				// get animation props
				$props = $this->get_animation_props($animation, $id, $atts, $key);
				// add to timeline
				$gsap['timeline'][$count] = array(
					'props' => $props
				);
				// set css
				if(!empty($css)) {
					$gsap['timeline'][$count]['css'] = $css;
				}
				// inc count
				$count++;
			}
			// return gsap
			return $gsap;
		}

		// -----------------------------------------
		// get lottie element
		// -----------------------------------------

		public function get_lottie_element($id, $options) {
			// vars
			$event = 'on_load';
			$lottie = array();
			// get event
			if(isset($options['event'])) {
				$event = $options['event'];
			}
			// add to lottie, set repeat to 0 for lottie because looping will get defined in the lottie animation itself, not gsap
			$lottie = array(
				'event' => $event,
				'isLottie' => true,
				'repeat' => 0
			);
			if($event == 'on_scroll') {
				$lottie['options'] = $options;
			} else {
				// add timeline
				$lottie['timeline'][0] = array(
					'props' => array(
						'ease' => 'expo'
					),
					'css' => array(),
				);
			}
			// return lottie
			return $lottie;
		}

		// -----------------------------------------
		// get animation props
		// -----------------------------------------

		public function get_animation_props($animation, $id, $atts, $step) {
			// define props
			$props = array();
			$box_shadow_props = array();
			$gradient_props = array();
			$filter_props = array();
			$module = isset($atts['module']) ? $atts['module'] : false;
			$bg_image_url = $this->get_bg_image_url($atts['styles']['xl']);
			// remove bg mage on modules
			if(false !== $module) {
				$bg_image_url = 'none';
			}
			// duration, delay and easing
			$transition_atts = array(
				'duration' => 800,
				'ease' => 'Power1.easeOut',
				'delay' => 0
			);
			// iterate transitions atts
			foreach ($transition_atts as $transition_attr => $value) {
				if(isset($animation[$transition_attr])) {
					$props[$transition_attr] = $animation[$transition_attr];
				} else {
					$props[$transition_attr] = $value;
				}
				// is duration?
				if($transition_attr == 'duration' || $transition_attr == 'delay') {
					$props[$transition_attr] = $props[$transition_attr] / 1000;
				}
			}
			// iterate effects
			foreach ($animation['effects'] as $attribute => $value) {
				// rem kommastsellen matchen mit gsap
				if(strpos(strval($value), 'rem') !== false && $attribute != 'filter_drop-shadow') {
					$value = floatval(str_replace('rem', '', $value));
					if($value > 0) {
						$value = number_format($value, 4) . 'rem';
					} else {
						$value .= 'rem';
					}
				}
				// is rotate or skew?
				if(strpos($attribute, 'rotate') !== false || strpos($attribute, 'skew') !== false) {
					// exclude some attributes
					if($attribute != 'filter_hue-rotate') {
						$value = $value . 'deg';
					}
				}
				// add value if not box shadow
				if(strpos($attribute, 'box-shadow') !== false) {
					$box_shadow_props[$attribute] = $value;
				} else if(strpos($attribute, 'gradient') !== false) {
					$gradient_props[$attribute] = $value;
				} else if(strpos($attribute, 'filter') !== false) {
					$filter_props[$attribute] = $value;
				} else if(strpos($attribute, 'z-index') === false) {
					$props[$this->get_js_attribute($attribute)] = $value;
				}
			}
			// get box shadow
			$box_shadow = $this->box_shadow($box_shadow_props, $module);
			// add box shadow to css
			if(false !== $box_shadow) {
				if($module == 'text' || $module == 'paragraph') {
					$props['textShadow'] = $box_shadow;
				} else {
					$props['boxShadow'] = $box_shadow;
				}
			}
			
			// get gradient
			$gradient = $this->gradient($gradient_props, $bg_image_url);
			// add gradient to css
			if(false !== $gradient) {
				$props['backgroundImage'] = $gradient;
			}
			// for css filters we need to add the initial filter value if changed since we overwrite the css values else
			$filter_state = $this->get_filter_state($atts['motions'], $step);
			if(false !== $filter_state && is_array($filter_state) && !empty($filter_state)) {
				foreach ($filter_state as $filter => $value) {
					// add to filter props but only if its not already in as an effect
					if(!isset($filter_props[$filter])) {
						$filter_props[$filter] = $value;
					}
				}
			}
			// get filter
			$filter = $this->filter($filter_props);
			// add filter to css
			if(false !== $filter && !empty($filter)) {
				$props['filter'] = $filter;
			}
			// return props
			return $props;
		}

		// -----------------------------------------
		// get js attribute
		// -----------------------------------------

		public function get_js_attribute($attribute) {
			// js atts
			$js_atts = array(
				'opacity' => 'opacity',
				'translateX' => 'x',
				'translateY' => 'y',
				'scaleX' => 'scaleX',
				'scaleY' => 'scaleY',
				'skewX' => 'skewX',
				'skewY' => 'skewY',
				'rotate' => 'rotation',
				'rotateX' => 'rotateX',
				'rotateY' => 'rotateY',
				'background-color' => 'backgroundColor',
				'color' => 'color',
				'border-color' => 'borderColor',
				'border-width' => 'borderWidth',
				'duration' => 'duration',
				'easing' => 'easing'
			);
			// return
			return $js_atts[$attribute];
		}
	}
	// instance
	$this->animate_api = new animate_api;
}
?>