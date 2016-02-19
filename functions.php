<?php
require_once( get_template_directory() . '/lib/init.php' );
require_once( get_stylesheet_directory() . '/nav.php');

define( 'CHILD_THEME_NAME', 'CP Sharp' );
define( 'CHILD_THEME_URL', 'http://www.cpsharp.net/' );

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

add_theme_support( 'genesis-responsive-viewport' );

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

//* Enable HTML5 markup
add_theme_support('html5');

//* Enable HTML5 markup for galleries
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add support for structural wraps
add_theme_support('genesis-structural-wraps', array('header', 'nav', 'subnav', 'site-inner', 'inner', 'footer'));

//* Add support for custom header
add_theme_support('custom-header',
array('header-selector' => '.site-title a',
	'header-text' => false,
	'height' => 125,
	'width' => 162));

remove_theme_support( 'genesis-footer-widgets', 1 );

genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

unregister_sidebar( 'header-right' );
unregister_sidebar( 'sidebar-alt' );

remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

remove_action( 'genesis_before_post_content', 'genesis_post_info' );

remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_post_title', 'genesis_do_post_title' );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

remove_action('genesis_header', 'genesis_do_header');
add_action('genesis_header', 'cp_do_header');

function cp_do_header() {
    echo '<div id="header">';
	echo '<img src="/wp-content/uploads/2015/09/cropped-cpsharp11.png" alt="CP Sharp Logo">';
	echo '<span class="title">Innovative</span><span class="title">Responsive</span><span class="title">Technology</span>';
    echo '</div>';
	echo '<div id="socialmedia"></div>';
}

//* Enqueue Scripts
// Load Google fonts
add_action('wp_enqueue_scripts', 'cp_google_fonts');
function cp_google_fonts() {
	wp_enqueue_style('google-fonts', 'http://fonts.googleapis.com/css?family=Coda|Raleway:400,700,200', array(), PARENT_THEME_VERSION);
	wp_enqueue_style('google-fonts', "http://fonts.googleapis.com/css?family=PT+Sans+Narrow:regular,bold", array(), PARENT_THEME_VERSION);
}

//remove_action('genesis_after_header', 'genesis_do_nav');
//add_action('genesis_after_header', 'cp_do_nav');

add_action('wp_enqueue_scripts', 'cp_d3_layout');

function cp_d3_layout() {
	wp_enqueue_script( 'jq', get_stylesheet_directory_uri() . '/lib/jquery.js', array(), '1.0.0', true );
	wp_enqueue_script( 'jqcookie', get_stylesheet_directory_uri() . '/lib/jquery.cookie.js', array('jq'), '1.0.0', true );
	wp_enqueue_script( 'd3', get_stylesheet_directory_uri() . '/lib/d3.js', array('jq'), '1.0.0', true );
	wp_enqueue_script( 'gstween', get_stylesheet_directory_uri() . '/lib/tweenlite.js', array('jq'), '1.0.0', true );
	wp_enqueue_script( 'gscss', get_stylesheet_directory_uri() . '/lib/gs.cssplugin.js', array('jq'), '1.0.0', true );
	wp_enqueue_script( 'gsease', get_stylesheet_directory_uri() . '/lib/gs.easepack.js', array('jq'), '1.0.0', true );

	$prereqs = array('d3', 'gstween', 'gscss', 'gsease');
	wp_enqueue_script( 'cpd3core', get_stylesheet_directory_uri() . '/js/app.core.js', $prereqs, '1.0.0', true );
	array_push($prereqs, 'cpd3core');
	wp_enqueue_script( 'cpd3app', get_stylesheet_directory_uri() . '/js/app.js', $prereqs, '1.0.0', true );
	array_push($prereqs, 'cpd3app');
	wp_enqueue_script( 'cpd3map', get_stylesheet_directory_uri() . '/js/app.map.js', $prereqs, '1.0.0', true );
	wp_enqueue_script( 'cpd3ui', get_stylesheet_directory_uri() . '/js/app.ui.js', $prereqs, '1.0.0', true );
}

/* Add new image sizes
add_image_size('grid-thumbnail', 150, 150, TRUE);
add_image_size('home-featured', 505, 210, TRUE);

//* Reposition the secondary navigation
remove_action('genesis_after_header', 'genesis_do_subnav');
add_action('genesis_before_header', 'genesis_do_subnav');

//* Customise Post Date
add_filter('genesis_post_date_shortcode', 'nameless_post_date_shortcode', 10, 2);

function nameless_post_date_shortcode($output, $atts) {
    return sprintf('<span class="date time published" title="%4$s">%1$s<span class="day">%2$s</span><span class="month">%3$s</span></span>',
        $atts['label'], get_the_time('j'), get_the_time('M'), get_the_time('Y-m-d\TH:i:sO'));
}

//* Define content width for Jetpack's tiled galleries
if (!isset($content_width)) {$content_width = 1140;}
*/