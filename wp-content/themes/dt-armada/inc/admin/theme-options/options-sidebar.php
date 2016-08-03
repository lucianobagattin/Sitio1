<?php
/**
 * Sidebar.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Page definition.
 */
$options[] = array(
		"page_title"	=> _x( "Sidebar", 'theme-options', LANGUAGE_ZONE ),
		"menu_title"	=> _x( "Sidebar", 'theme-options', LANGUAGE_ZONE ),
		"menu_slug"		=> "of-sidebar-menu",
		"type"			=> "page"
);

/**
 * Heading definition.
 */
$options[] = array( "name" => _x( 'Sidebar', 'theme-options', LANGUAGE_ZONE ), "type" => "heading" );

// block begin
$options[] = array( "name" => _x( "Sidebar settings", "theme-options", LANGUAGE_ZONE ), "type" => "block_begin" );

	$options[] = array(
		"name"		=> _x( "Sidebar width (%)", "theme-options", LANGUAGE_ZONE ),
		"id"		=> "sidebar-width",
		"std"		=> "30",
		"type"		=> "text",
		"class"		=> "mini",
		"sanitize"	=> "dimensions"
	);

	$options[] = array( "type" => "divider" );

	$options[] = array(
		"name"		=> _x( "Vertical distance between widgets (px)", "theme-options", LANGUAGE_ZONE ),
		"id"		=> "sidebar-vertical_distance",
		"std"		=> "60",
		"type"		=> "text",
		"class"		=> "mini",
		"sanitize"	=> "dimensions"
	);

	$options[] = array( "type" => "divider" );

	$options[] = array(
		"name"		=> _x( "Vertical divider", "theme-options", LANGUAGE_ZONE ),
		"id"		=> "sidebar-divider-vertical",
		"std"		=> "1",
		"type"		=> "radio",
		"options"	=> $en_dis_options
	);

	$options[] = array( "type" => "divider" );

	$options[] = array(
		"name"		=> _x( "Dividers between widgets", "theme-options", LANGUAGE_ZONE ),
		"id"		=> "sidebar-divider-horizontal",
		"std"		=> "1",
		"type"		=> "radio",
		"options"	=> $en_dis_options
	);

// block end
$options[] = array( "type" => "block_end" );

// block begin
$options[] = array(	"name" => _x('Text', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

	$options[] = array(
		"desc"	=> '',
		"name"	=> _x( 'Headers color', 'theme-options', LANGUAGE_ZONE ),
		"id"	=> "sidebar-headers_color",
		"std"	=> "#000000",
		"type"	=> "color"
	);

	$options[] = array(
		"desc"	=> '',
		"name"	=> _x( 'Text color', 'theme-options', LANGUAGE_ZONE ),
		"id"	=> "sidebar-primary_text_color",
		"std"	=> "#686868",
		"type"	=> "color"
	);

// block end
$options[] = array(	"type" => "block_end");

/*
$options[] = array(	"name" => _x('Background color', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

	// colorpicker
	$options[] = array(
		"desc"	=> '',
		"name"	=> _x( 'Background color', 'theme-options', LANGUAGE_ZONE ),
		"id"	=> "sidebar-bg_color",
		"std"	=> "#ffffff",
		"type"	=> "color"
	);

	// slider
	$options[] = array(
		"desc"      => '',
		"name"      => _x( 'Opacity', 'theme-options', LANGUAGE_ZONE ),
		"id"        => "sidebar-bg_opacity",
		"std"       => 100, 
		"type"      => "slider",
		"options"   => array( 'java_hide_if_not_max' => true )
	);

	// hidden area
	$options[] = array( 'type' => 'js_hide_begin' );

		// colorpicker
		$options[] = array(
			"desc"  => '',
			"name"  => _x( 'Internet Explorer color', 'theme-options', LANGUAGE_ZONE ),
			"id"    => "sidebar-bg_ie_color",
			"std"   => "#ffffff",
			"type"  => "color"
		);

	$options[] = array( 'type' => 'js_hide_end' );

	// background_img
	$options[] = array(
		'type' 			=> 'background_img',
		'id' 			=> 'sidebar-bg_image',
		"name" 			=> _x( 'Add background image', 'theme-options', LANGUAGE_ZONE ),
		'preset_images' => $backgrounds_sidebar_bg_image,
		'std' 			=> array(
			'image'			=> '',
			'repeat'		=> 'repeat',
			'position_x'	=> 'center',
			'position_y'	=> 'center',
		),
	);

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Dividers &amp; lines', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

	// colorpicker
	$options[] = array(
		"desc"	=> '',
		"name"	=> _x( 'Color', 'theme-options', LANGUAGE_ZONE ),
		"id"	=> "sidebar-dividers_color",
		"std"	=> "#757575",
		"type"	=> "color"
	);

	// slider
	$options[] = array(
		"desc"      => '',
		"name"      => _x( 'Opacity', 'theme-options', LANGUAGE_ZONE ),
		"id"        => "sidebar-dividers_opacity",
		"std"       => 100, 
		"type"      => "slider",
		"options"   => array( 'java_hide_if_not_max' => true )
	);

	// hidden area
	$options[] = array( 'type' => 'js_hide_begin' );

		// colorpicker
		$options[] = array(
			"desc"  => '',
			"name"  => _x( 'Internet Explorer color', 'theme-options', LANGUAGE_ZONE ),
			"id"    => "sidebar-dividers_ie_color",
			"std"   => "#ececec",
			"type"  => "color"
		);

	$options[] = array( 'type' => 'js_hide_end' );

$options[] = array(	"type" => "block_end");
*/
