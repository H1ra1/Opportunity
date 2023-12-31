<?php if(! defined('ABSPATH')){ return; }
/*
	Name: Title Element
	Description: Create and display a title and or subtitle
	Class: TH_TitleElement
	Category: content
	Keywords: heading, headline, subtitle
	Level: 3
*/
/**
 * Class TH_TitleElement
 *
 * Create and display a Title  element
 *
 * @package  Kallyas
 * @category Page Builder
 * @author   Team Hogash
 * @since    4.0.0
 */
class TH_TitleElement extends ZnElements
{
	public static function getName(){
		return __( "Title Element", 'zn_framework' );
	}

	/**
	 * Output the inline css to head or after the element in case it is loaded via ajax
	 */
	function css(){

		$uid = $this->data['uid'];
		$css = '';

		// backwards compatibility for top and bottom padding
		$tt_padding_std = array('top' => '0', 'bottom'=> '35px');
		if(isset($this->data['options']['top_padding']) && $this->data['options']['top_padding'] != '' ){
			$tt_padding_std['top'] = $this->data['options']['top_padding'].'px';
		}
		if(isset($this->data['options']['bottom_padding']) && $this->data['options']['bottom_padding'] != '' ){
			$tt_padding_std['bottom'] = $this->data['options']['bottom_padding'].'px';
		}

		// Margin
		if( $this->opt('cc_margin_lg', '' ) || $this->opt('cc_margin_md', '' ) || $this->opt('cc_margin_sm', '' ) || $this->opt('cc_margin_xs', '' ) ){
			$css .= zn_push_boxmodel_styles(array(
					'selector' => '.'.$uid,
					'type' => 'margin',
					'lg' =>  $this->opt('cc_margin_lg', '' ),
					'md' =>  $this->opt('cc_margin_md', '' ),
					'sm' =>  $this->opt('cc_margin_sm', '' ),
					'xs' =>  $this->opt('cc_margin_xs', '' ),
				)
			);
		}
		// Padding
		if( $this->opt('cc_padding_lg', $tt_padding_std ) || $this->opt('cc_padding_md', '' ) || $this->opt('cc_padding_sm', '' ) || $this->opt('cc_padding_xs', '' ) ){
			$css .= zn_push_boxmodel_styles(array(
					'selector' => '.'.$uid,
					'type' => 'padding',
					'lg' =>  $this->opt('cc_padding_lg', $tt_padding_std ),
					'md' =>  $this->opt('cc_padding_md', '' ),
					'sm' =>  $this->opt('cc_padding_sm', '' ),
					'xs' =>  $this->opt('cc_padding_xs', '' ),
				)
			);
		}

		$ttl_bmargin = array(
			'lg' =>  $this->opt('title_bmargin', 10),
			'unit_lg' => 'px',
		);
		if($ttl_bmargin['lg'] != '10'){
			$css .= zn_smart_slider_css( $this->opt( 'title_bmargin', $ttl_bmargin ), '.'.$uid.' .tbk__title' , 'margin-bottom' );
		}

		// Title Typography
		$typo = array();
		$typo['lg'] = $this->opt('title_typo', '' );
		$typo['md'] = $this->opt('title_typo_md', '' );
		$typo['sm'] = $this->opt('title_typo_sm', '' );
		$typo['xs'] = $this->opt('title_typo_xs', '' );
		if( !empty($typo) ){
			$typo['selector'] = '.'.$uid.' .tbk__title';
			$css .= zn_typography_css( $typo );
		}


		// SubTitle Typography
		$sub_typo = array();
		$sub_typo['lg'] = $this->opt('subtitle_typo', '' );
		$sub_typo['md'] = $this->opt('subtitle_typo_md', '' );
		$sub_typo['sm'] = $this->opt('subtitle_typo_sm', '' );
		$sub_typo['xs'] = $this->opt('subtitle_typo_xs', '' );
		if( !empty($sub_typo) ){
			$sub_typo['selector'] = '.'.$uid.' .tbk__subtitle';
			$css .= zn_typography_css( $sub_typo );
		}


		// icon size
		$icon_size = $this->opt('icon_size') || $this->opt('icon_size') === '0' ? 'font-size:'.$this->opt('icon_size').'px;' : 'font-size:28px;';
		$css .= ".$uid .tbk__icon { $icon_size }";

		// symbol color
		if($this->opt('te_symbol_color', 'default') == 'theme') {
			$custom_color = $this->opt('te_symbol_custom_color', '#cd2122');
			$symbol = $this->opt('te_symbol');

			if( !empty($symbol) ){
				if($symbol == 'icon') {
					$css .= '.'.$uid.'.tbk--colored .tbk__icon {color:'.$custom_color.';}';

				} elseif($symbol == 'line' || $symbol == 'line_border' || $symbol == 'border') {
					$css .= '.'.$uid.'.tbk--colored .tbk__symbol span {background-color:'.$custom_color.';}';

				} elseif($symbol == 'border2') {
					$css .= '.'.$uid.'.tbk--colored .tbk__border-helper {border-bottom-color:'.$custom_color.';}';
				}
			}
		}

		$parent_hover_anim = $this->opt('parent_hover_anim','');

		if($parent_hover_anim != ''){

			$parent_id = $this->opt('parent_hover_id','');
			if($parent_id != ''){

				if($parent_hover_anim == 'fadeout'){
					$css .= '.'.$parent_id.':hover .ph-'.$uid.'.prt-hover-fadeout {opacity:0;}';
				}
				elseif($parent_hover_anim == 'fadein'){
					$css .= '.'.$parent_id.':hover .ph-'.$uid.'.prt-hover-fadein {opacity:1;}';
				}
				elseif($parent_hover_anim == 'slideout'){
					$css .= '.'.$parent_id.':hover .ph-'.$uid.'.prt-hover-slideout {opacity:0; max-height:0;}';
				}
				elseif($parent_hover_anim == 'slidein'){
					$css .= '.'.$parent_id.':hover .ph-'.$uid.'.prt-hover-slidein {opacity:1; max-height:200px;}';
				}

			}

		}


		return $css;
	}
	/**
	 * This function is used to hold the element symbol structure
	 *
	 * @return the element symbol markup
	 */
	private function the_symbol() {
		$te_symbol = $this->opt( 'te_symbol' );
		$iconHolder = $this->opt('te_symbol_icon');

		if( ! empty( $te_symbol ) ) {
			echo '<span class="tbk__symbol ">';

			if( $te_symbol == 'icon' && !empty( $iconHolder['family'] ) ){
				echo '<span class="tbk__icon" '.zn_generate_icon( $this->opt('te_symbol_icon') ).'></span>';
			} else {
				echo '<span></span>';
			}
			echo '</span>';
		}
	}

	/**
	 * This method is used to display the output of the element.
	 *
	 * @return void
	 */
	function element()
	{
		$options = $this->data['options'];

		if( empty( $options ) ) { return; }

		$symbol_pos = $this->opt('te_symbol_pos', 'after-title');
		$symbol_color = $this->opt('te_symbol_color', 'default') == 'theme' ? 'tbk--colored' : '';
		$te_symbol = $this->opt( 'te_symbol' );



		$classes = array();
		$classes[] = 'tbk--text-'.( $this->opt('te_color_theme','') == 'default' ? '' : $this->opt('te_color_theme','') );
		$classes[] = 'tbk--'.$this->opt('te_alignment', 'center');
		$classes[] = 'text-'.$this->opt('te_alignment', 'center');
		$classes[] = 'tbk-symbol--'.$te_symbol;
		$classes[] = $symbol_color;
		$classes[] = 'tbk-icon-pos--'.$symbol_pos;
		$classes[] = $uid = $this->data['uid'];
		$classes[] = zn_get_element_classes($options);

		$attributes = zn_get_element_attributes($options);

		// Parent Hover block
		$parent_hover_anim = $this->opt( 'parent_hover_anim', '' );

		// Object Parallax
		if( $this->opt('obj_parallax_enable','') == 'yes' ){
			// Classes
			$classes[] = 'js-doObjParallax zn-objParallax';
			$classes[] = 'zn-objParallax--ease-'.$this->opt('obj_parallax_easing_v2', 'linear');
			// Attributes
			$distance = $this->opt('obj_parallax_distance_v2', zn_obj_parallax_distance_std_legacy( $this->opt('obj_parallax_distance', '1') ) );
			$dir = $this->opt('obj_parallax_reverse', '') == 'yes' ? '' : '-';
			$attributes .= ' data-rellax-speed="' . $dir . $distance .'"';
			$attributes .= ' data-rellax-percentage="0.5"';
		}

		if( ! empty( $parent_hover_anim ) ) {
			echo '<div class="prt-hover-' . $parent_hover_anim . ' ph-' . $uid . '">';
		}

		echo '<div class="kl-title-block clearfix '.implode(' ', $classes).'" '.$attributes.'>';

			if( $symbol_pos == 'before-title'  ) $this->the_symbol();

			if($te_title = $this->opt('te_title')) {

				$title_heading = $this->opt('te_tt_heading','3');
				$tag_type = $title_heading !== 'p' ? "h{$title_heading}" : $title_heading;


				echo '<'.$tag_type.' class="tbk__title" '.WpkPageHelper::zn_schema_markup('title').'>';

					if( $symbol_pos == 'left-title' && $te_symbol == 'icon' ) $this->the_symbol();
					$border_class = ( 'border2' === !empty($te_symbol) && $te_symbol ) ? true : false;

					if ( $border_class ) {
						echo '<span class="tbk__border-helper">';
					}

					echo do_shortcode($te_title);

					if( $border_class ){
						echo '</span>';
					}

				echo '</'.$tag_type.'>';
			}

			// In case there's no icon and symbol placement is left, place the
			// symbol (whatever it is) after the title
			if( $symbol_pos == 'after-title' || ( $symbol_pos == 'left-title' && $te_symbol != 'icon' ) )  {
				$this->the_symbol();
			}

			if($te_subtitle = $this->opt('te_subtitle')) {
				$subtitle_tag = $this->opt('te_stt_tag','h4');
				echo '<'.$subtitle_tag.' class="tbk__subtitle" '.WpkPageHelper::zn_schema_markup('subtitle').'>'.do_shortcode($te_subtitle).'</'.$subtitle_tag.'>';
			}

			if( $symbol_pos == 'after-subtitle' ) $this->the_symbol();

			if($te_text = $this->opt('te_text')) {
				echo '<div class="tbk__text">';
				$content = wpautop( $te_text );
				if ( ! empty ( $te_text ) ) {
					if ( preg_match( '%(<[^>]*>.*?</)%i', $content, $regs ) ) {
						echo do_shortcode( $content );
					}
					else {
						echo '<p>' . do_shortcode( $content ) . '</p>';
					}
				}
				echo '</div>';
			}

			if( $symbol_pos == 'after-text' ) $this->the_symbol();

		echo '</div>';

		if ( ! empty( $parent_hover_anim ) ) {
			echo '</div>';
		}

	}

	/**
	 * This method is used to retrieve the configurable options of the element.
	 * @return array The list of options that compose the element and then passed as the argument for the render() function
	 */
	function options()
	{
		$uid = $this->data['uid'];

		// backwards compatibility for top and bottom padding
		$tt_padding_std = array('top' => '0', 'bottom'=> '35px');
		if(isset($this->data['options']['top_padding']) && $this->data['options']['top_padding'] != '' ){
			$tt_padding_std['top'] = $this->data['options']['top_padding'].'px';
		}
		if(isset($this->data['options']['bottom_padding']) && $this->data['options']['bottom_padding'] != '' ){
			$tt_padding_std['bottom'] = $this->data['options']['bottom_padding'].'px';
		}

		$options = array(
			'has_tabs'  => true,
			'general' => array(
				'title' => 'General options',
				'options' => array(

					array (
						"name"        => __( "Alignment", 'zn_framework' ),
						"description" => __( "Select the alignment", 'zn_framework' ),
						"id"          => "te_alignment",
						"std"         => "center",
						"type"        => "select",
						"options"     => array(
							"left" => "Left",
							"center" => "Center",
							"right" => "Right"
						),
						// "type"        => "zn_radio",
						// "options"     => array(
						// 	"left" => '<span class="dashicons dashicons-editor-alignleft"></span>',
						// 	"center" => '<span class="dashicons dashicons-editor-aligncenter"></span>',
						// 	"right" => '<span class="dashicons dashicons-editor-alignright"></span>',
						// ),
						'live'        => array(
							'multiple' => array(
								array(
									'type'      => 'class',
									'css_class' => '.'.$uid,
									'val_prepend'  => 'tbk--',
								),
								array(
									'type'      => 'class',
									'css_class' => '.'.$uid,
									'val_prepend'  => 'text-',
								),
							)
						)
					),

					array (
						"name"        => __( "Title", 'zn_framework' ),
						"description" => __( "Add the title. Shorcodes and HTML code allowed", 'zn_framework' ),
						"id"          => "te_title",
						"std"         => "",
						"type"        => "textarea",
					),

					array (
						"name"        => __( "Sub Title", 'zn_framework' ),
						"description" => __( "Add a sub-title. Shorcodes and HTML code allowed", 'zn_framework' ),
						"id"          => "te_subtitle",
						"std"         => "",
						"type"        => "textarea",
					),

					array(
						'id'          => 'te_color_theme',
						'name'        => 'Element Color Scheme',
						'description' => 'Select a theme text color. In case you have a dark background you most definitely want a light colored text',
						'type'        => 'select',
						'std'         => '',
						'options'        => array(
							'' => 'Inherit from Kallyas options > Color Options [Requires refresh]',
							'light' => 'Light (default)',
							'dark' => 'Dark'
						),
						'live'        => array(
							'multiple' => array(
								array(
									'type'      => 'class',
									'css_class' => '.'.$uid,
									'val_prepend'  => 'tbk--text-',
								),
								array(
									'type'      => 'class',
									'css_class' => '.'.$uid,
									'val_prepend'  => 'element-scheme--',
								),
							)
						)
					),


					/**
					 * Margins and padding
					 */
					array (
						"name"        => __( "Edit element padding & margins for each device breakpoint. ", 'zn_framework' ),
						"description" => __( "This will enable you to have more control over the padding of the container on each device. Click to see <a href='http://hogash.d.pr/1f0nW' target='_blank'>how box-model works</a>.", 'zn_framework' ),
						"id"          => "cc_spacing_breakpoints",
						"std"         => "lg",
						"tabs"        => true,
						"type"        => "zn_radio",
						"options"     => array (
							"lg"        => __( "LARGE", 'zn_framework' ),
							"md"        => __( "MEDIUM", 'zn_framework' ),
							"sm"        => __( "SMALL", 'zn_framework' ),
							"xs"        => __( "EXTRA SMALL", 'zn_framework' ),
						),
						"class"       => "zn_full zn_breakpoints"
					),
					// MARGINS
					array(
						'id'          => 'cc_margin_lg',
						'name'        => 'Margin (Large Breakpoints)',
						'description' => 'Select the margin (in percent % or px) for this container. Accepts negative margin.',
						'type'        => 'boxmodel',
						'std'	  => '',
						'placeholder' => '0px',
						"dependency"  => array( 'element' => 'cc_spacing_breakpoints' , 'value'=> array('lg') ),
						'live' => array(
							'type'		=> 'boxmodel',
							'css_class' => '.'.$uid,
							'css_rule'	=> 'margin',
						),
					),
					array(
						'id'          => 'cc_margin_md',
						'name'        => 'Margin (Medium Breakpoints)',
						'description' => 'Select the margin (in percent % or px) for this container.',
						'type'        => 'boxmodel',
						'std'	  => 	'',
						'placeholder'        => '0px',
						"dependency"  => array( 'element' => 'cc_spacing_breakpoints' , 'value'=> array('md') ),
					),
					array(
						'id'          => 'cc_margin_sm',
						'name'        => 'Margin (Small Breakpoints)',
						'description' => 'Select the margin (in percent % or px) for this container.',
						'type'        => 'boxmodel',
						'std'	  => 	'',
						'placeholder'        => '0px',
						"dependency"  => array( 'element' => 'cc_spacing_breakpoints' , 'value'=> array('sm') ),
					),
					array(
						'id'          => 'cc_margin_xs',
						'name'        => 'Margin (Extra Small Breakpoints)',
						'description' => 'Select the margin (in percent % or px) for this container.',
						'type'        => 'boxmodel',
						'std'	  => 	'',
						'placeholder'        => '0px',
						"dependency"  => array( 'element' => 'cc_spacing_breakpoints' , 'value'=> array('xs') ),
					),
					// PADDINGS
					array(
						'id'          => 'cc_padding_lg',
						'name'        => 'Padding (Large Breakpoints)',
						'description' => 'Select the padding (in percent % or px) for this container.',
						'type'        => 'boxmodel',
						"allow-negative" => false,
						'std'	  => $tt_padding_std,
						'placeholder' => '0px',
						"dependency"  => array( 'element' => 'cc_spacing_breakpoints' , 'value'=> array('lg') ),
						'live' => array(
							'type'		=> 'boxmodel',
							'css_class' => '.'.$uid,
							'css_rule'	=> 'padding',
						),
					),
					array(
						'id'          => 'cc_padding_md',
						'name'        => 'Padding (Medium Breakpoints)',
						'description' => 'Select the padding (in percent % or px) for this container.',
						'type'        => 'boxmodel',
						"allow-negative" => false,
						'std'	  => 	'',
						'placeholder'        => '0px',
						"dependency"  => array( 'element' => 'cc_spacing_breakpoints' , 'value'=> array('md') ),
					),
					array(
						'id'          => 'cc_padding_sm',
						'name'        => 'Padding (Small Breakpoints)',
						'description' => 'Select the padding (in percent % or px) for this container.',
						'type'        => 'boxmodel',
						"allow-negative" => false,
						'std'	  => 	'',
						'placeholder'        => '0px',
						"dependency"  => array( 'element' => 'cc_spacing_breakpoints' , 'value'=> array('sm') ),
					),
					array(
						'id'          => 'cc_padding_xs',
						'name'        => 'Padding (Extra Small Breakpoints)',
						'description' => 'Select the padding (in percent % or px) for this container.',
						'type'        => 'boxmodel',
						"allow-negative" => false,
						'std'	  => 	'',
						'placeholder'        => '0px',
						"dependency"  => array( 'element' => 'cc_spacing_breakpoints' , 'value'=> array('xs') ),
					),

					array(
						'id'          => 'title_bmargin',
						'name'        => 'TITLE - Bottom Margin',
						'description' => 'Select the bottom margin ( in pixels ) for the title.',
						'type'        => 'smart_slider',
						'std'         => '10',
						// 'class'       => 'zn_full',
						'supports' => array('breakpoints'),
						'units' => array('px'),
						'helpers'     => array(
							'min' => '0',
							'max' => '100',
							'step' => '1'
						),
						'live' => array(
							'type'      => 'css',
							'css_class' => '.'.$uid .' .tbk__title',
							'css_rule'  => 'margin-bottom',
							'unit'      => 'px'
						)
					),

					array (
						"name"        => __( "Parent Hover Animation", 'zn_framework' ),
						"description" => __( "Animate element on parent hover", 'zn_framework' ),
						"id"          => "parent_hover_anim",
						"std"         => "",
						"type"        => "select",
						"options"     => array(
							"" => "None",
							"fadeout" => "Fade Out",
							"fadein" => "Fade In",
							"slideout" => "Slide Out",
							"slidein" => "Slide In",
							// "color" => "Color Swap",
						),
					),

					array(
						'id'          => 'parent_hover_id',
						'name'        => __( "Parent ID", 'zn_framework' ),
						'description' => __( "You need to copy the parent element's unique ID. To find it, open the parent element's options and in the HELP tab you can find the ID. Just click to copy it and paste it here.", 'zn_framework' ),
						'type'        => 'text',
						'std'         => '',
						"dependency"  => array( 'element' => 'parent_hover_anim' , 'value'=> array('fadeout', 'fadein', 'slideout', 'slidein') )
					),

					// animation type
					// fade out/ fade in / slide in / slide-out / color


				)
			),


			'font' => array(
				'title' => 'Font settings',
				'options' => array(

					array (
						"name"        => __( "Title Heading", 'zn_framework' ),
						"description" => __( "Select a title heading. The title will be wrapped in this tag", 'zn_framework' ),
						"id"          => "te_tt_heading",
						"std"         => "3",
						"type"        => "select",
						"options"     => array(
								"1" => "H1",
								"2" => "H2",
								"3" => "H3",
								"4" => "H4",
								"5" => "H5",
								"6" => "H6",
								"p" => "Paragraph",
							)
					),

					array (
						// "name"        => __( "Title Typography settings", 'zn_framework' ),
						// "description" => __( "Adjust the typography of the title as you want on any breakpoint", 'zn_framework' ),
						"id"          => "cc_font_breakpoints",
						"std"         => "lg",
						"tabs"        => true,
						"type"        => "zn_radio",
						"options"     => array (
							"lg"        => __( "LARGE", 'zn_framework' ),
							"md"        => __( "MEDIUM", 'zn_framework' ),
							"sm"        => __( "SMALL", 'zn_framework' ),
							"xs"        => __( "EXTRA SMALL", 'zn_framework' ),
						),
						"class"       => "zn_full zn_breakpoints"
					),

					array (
						"name"        => __( "Title settings", 'zn_framework' ),
						"description" => __( "Specify the typography properties for the title.", 'zn_framework' ),
						"id"          => "title_typo",
						"std"         => '',
						'supports'   => array( 'size', 'font', 'style', 'line', 'color', 'weight', 'spacing', 'case', 'shadow', 'decoration' ),
						"type"        => "font",
						'live' => array(
							'type'      => 'font',
							'css_class' => '.'.$uid. ' .tbk__title',
						),
						"dependency"  => array( 'element' => 'cc_font_breakpoints' , 'value'=> array('lg') ),
					),

					array (
						"name"        => __( "Title settings", 'zn_framework' ),
						"description" => __( "Specify the typography properties for the title.", 'zn_framework' ),
						"id"          => "title_typo_md",
						"std"         => '',
						'supports'   => array( 'size', 'line', 'spacing' ),
						"type"        => "font",
						"dependency"  => array( 'element' => 'cc_font_breakpoints' , 'value'=> array('md') ),
					),

					array (
						"name"        => __( "Title settings", 'zn_framework' ),
						"description" => __( "Specify the typography properties for the title.", 'zn_framework' ),
						"id"          => "title_typo_sm",
						"std"         => '',
						'supports'   => array( 'size', 'line', 'spacing' ),
						"type"        => "font",
						"dependency"  => array( 'element' => 'cc_font_breakpoints' , 'value'=> array('sm') ),
					),

					array (
						"name"        => __( "Title settings", 'zn_framework' ),
						"description" => __( "Specify the typography properties for the title.", 'zn_framework' ),
						"id"          => "title_typo_xs",
						"std"         => '',
						'supports'   => array( 'size', 'line', 'spacing' ),
						"type"        => "font",
						"dependency"  => array( 'element' => 'cc_font_breakpoints' , 'value'=> array('xs') ),
					),


					array (
						"name"        => __( "Sub-Title settings", 'zn_framework' ),
						"description" => __( "Specify the typography properties for the sub-title.", 'zn_framework' ),
						"id"          => "subtitle_typo",
						"std"         => '',
						'supports'   => array( 'size', 'font', 'style', 'line', 'color', 'weight', 'spacing', 'case', 'shadow' ),
						"type"        => "font",
						'live' => array(
							'type'      => 'font',
							'css_class' => '.'.$uid. ' .tbk__subtitle ',
						),
						"dependency"  => array( 'element' => 'cc_font_breakpoints' , 'value'=> array('lg') ),
					),

					array (
						"name"        => __( "Sub-Title settings", 'zn_framework' ),
						"description" => __( "Specify the typography properties for the sub-title.", 'zn_framework' ),
						"id"          => "subtitle_typo_md",
						"std"         => '',
						'supports'   => array( 'size', 'line', 'spacing' ),
						"type"        => "font",
						"dependency"  => array( 'element' => 'cc_font_breakpoints' , 'value'=> array('md') ),
					),

					array (
						"name"        => __( "Sub-Title settings", 'zn_framework' ),
						"description" => __( "Specify the typography properties for the sub-title.", 'zn_framework' ),
						"id"          => "subtitle_typo_sm",
						"std"         => '',
						'supports'   => array( 'size', 'line', 'spacing' ),
						"type"        => "font",
						"dependency"  => array( 'element' => 'cc_font_breakpoints' , 'value'=> array('sm') ),
					),

					array (
						"name"        => __( "Sub-Title settings", 'zn_framework' ),
						"description" => __( "Specify the typography properties for the sub-title.", 'zn_framework' ),
						"id"          => "subtitle_typo_xs",
						"std"         => '',
						'supports'   => array( 'size', 'line', 'spacing' ),
						"type"        => "font",
						"dependency"  => array( 'element' => 'cc_font_breakpoints' , 'value'=> array('xs') ),
					),

					array (
						"name"        => __( "Sub-Title Tag", 'zn_framework' ),
						"description" => __( "Select the subtitle's tag. The title will be wrapped in this tag", 'zn_framework' ),
						"id"          => "te_stt_tag",
						"std"         => "h4",
						"type"        => "select",
						"options"     => array(
								"h1" => "H1",
								"h2" => "H2",
								"h3" => "H3",
								"h4" => "H4",
								"h5" => "H5",
								"h6" => "H6",
								"div" => "div",
								"p" => "Paragraph",
								"pre" => "Preformatted",
							)
					),

				)
			),

			'symbol' => array(
				'title' => 'Symbol',
				'options' => array(
					array (
						"name"        => __( "Add a symbol?", 'zn_framework' ),
						"description" => __( "Add any symbol?.", 'zn_framework' ),
						"id"          => "te_symbol",
						"std"         => "",
						"type"        => "select",
						"options"     => array(
								"" => "None",
								"line" => "Small line (50px x 3px)",
								"border" => "Long bottom border",
								"border2" => "Long Thicker bottom border (with thicker border for title)",
								"line_border" => "Small line + Bottom Border",
								"icon" => "Icon",
							)
					),
					array (
						"name"        => __( "Symbol Color", 'zn_framework' ),
						"description" => __( "Select symbol color.", 'zn_framework' ),
						"id"          => "te_symbol_color",
						"std"         => "default",
						"type"        => "select",
						"options"     => array(
								"default" => "Default color",
								"theme" => "Custom color"
						),
						// "dependency"  => array( 'element' => 'te_symbol' , 'value'=> array('line', 'line_border', 'icon') )
					),


					array (
						"name"        => __( "Symbol Custom Color", 'zn_framework' ),
						"description" => __( "Select symbol color.", 'zn_framework' ),
						"id"          => "te_symbol_custom_color",
						"std"         => "#cd2122",
						"type"        => "colorpicker",
						"dependency"  => array( 'element' => 'te_symbol_color' , 'value'=> array('theme') )
					),

					array (
						"name"        => __( "Icon", 'zn_framework' ),
						"description" => __( "Add icon.", 'zn_framework' ),
						"id"          => "te_symbol_icon",
						"std"         => "",
						"type"        => "icon_list",
						'class'       => 'zn_full',
						"dependency"  => array( 'element' => 'te_symbol' , 'value'=> array('icon') )
					),

					array(
						'id'          => 'icon_size',
						'name'        => 'Icon Size',
						'description' => 'Select the icon size in px.',
						'type'        => 'slider',
						'std'         => '28',
						'class'       => 'zn_full',
						'helpers'     => array(
							'min' => '14',
							'max' => '80',
							'step' => '2'
						),
						"dependency"  => array( 'element' => 'te_symbol' , 'value'=> array('icon') ),
						'live' => array(
							'type'      => 'css',
							'css_class' => '.'.$uid.' .tbk__icon',
							'css_rule'  => 'font-size',
							'unit'      => 'px'
						)
					),

					array (
						"name"        => __( "Symbol position", 'zn_framework' ),
						"description" => __( "Select the symbol's position.", 'zn_framework' ),
						"id"          => "te_symbol_pos",
						"std"         => "after-title",
						"type"        => "select",
						"options"     => array(
								"before-title" => "Before title",
								"after-title" => "After title",
								"after-subtitle" => "After sub-title",
								"after-text" => "After Text",
								"left-title" => "Inline, in title's left side (Icon only!)",
						),
						"dependency"  => array( 'element' => 'te_symbol' , 'value'=> array('line', 'border', 'line_border', 'icon') ),
					),

				)
			),

			'text' => array(
				'title' => 'Plain text',
				'options' => array(
					array (
						"name"        => __( "Some text maybe?", 'zn_framework' ),
						"description" => __( "Add a text paragraph.", 'zn_framework' ),
						"id"          => "te_text",
						"std"         => "",
						"type"        => "visual_editor",
						'class'		 => 'zn_full'
					),
				)
			),

			'advanced' => array(
				'title' => 'Advanced',
				'options' => array(


					array (
						"name"        => __( "Enable Object Scrolling", 'zn_framework' ),
						"description" => __( "This will add a very nice slide up or down effect to this element, upon scrolling.", 'zn_framework' ),
						"id"          => "obj_parallax_enable",
						"std"         => "",
						"type"        => "toggle2",
						"value"        => "yes",
					),

					array (
						"name"        => __( "Distance", 'zn_framework' ),
						"description" => __( "Select the Y axis distance to run the effect. The effect will run on the entire screen, from entering the viewport until leaving it.", 'zn_framework' ),
						"id"          => "obj_parallax_distance_v2",
						"std"         => zn_obj_parallax_distance_std_legacy( $this->opt('obj_parallax_distance', '1') ),
						"type"        => "slider",
						"helpers"     => array (
							"step" => "1",
							"min" => "1",
							"max" => "10"
						),
						"dependency"  => array( 'element' => 'obj_parallax_enable' , 'value'=> array('yes') ),
					),

					array (
						"name"        => __( "Easing", 'zn_framework' ),
						"description" => __( "Select the effect's easing. You can play with the easing effects <a href=\"http://greensock.com/ease-visualizer\" target=\"_blank\">here</a>.", 'zn_framework' ),
						"id"          => "obj_parallax_easing_v2",
						"std"         => "linear",
						"type"        => "select",
						"options"     => array(
							"none"     => "No Easing",
							"linear" => "Ease Out Linear",
							"quad"   => "Ease Out Quad",
							"cubic"  => "Ease Out Cubic",
							"quart"  => "Ease Out Quart",
							"quint"  => "Ease Out Quint",
						),
						"dependency"  => array( 'element' => 'obj_parallax_enable' , 'value'=> array('yes') ),
					),

					array (
						"name"        => __( "Tween in reverse?", 'zn_framework' ),
						"description" => __( "This will make the tween effect to run in opposite direction of the scroll.", 'zn_framework' ),
						"id"          => "obj_parallax_reverse",
						"std"         => "",
						"type"        => "toggle2",
						"value"        => "yes",
						"dependency"  => array( 'element' => 'obj_parallax_enable' , 'value'=> array('yes') ),
					),

				)
			),

			'help' => znpb_get_helptab( array(
				'video'   => sprintf( '%s', esc_url('https://my.hogash.com/video_category/kallyas-wordpress-theme/#aBpgvHl6g6I') ),
				'docs'    => sprintf( '%s', esc_url('https://my.hogash.com/documentation/title-element/') ),
				'copy'    => $uid,
				'general' => true,
			)),

		);
		return $options;
	}
}
