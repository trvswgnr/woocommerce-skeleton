<?php // custom functions.php template @ digwp.com

// add feed links to header
if (function_exists('automatic_feed_links')) {
	automatic_feed_links();
} else {
	return;
}

// include custom jQuery
function custom_jquery() {
  wp_deregister_script('jquery');
  wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'custom_jquery');

// officially woocommerce supported theme
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
// disable WooCommerce default stylesheet
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// enable threaded comments
function enable_threaded_comments(){
	if (!is_admin()) {
		if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
			wp_enqueue_script('comment-reply');
		}
}
add_action('get_header', 'enable_threaded_comments');

// remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

// remove autoformatting
foreach ( array( 'the_content', 'the_title', 'the_excerpt' ) as $hook ) {
  remove_filter( $hook, 'wptexturize' );
  remove_filter( $hook, 'wpautop' );
}

//// add google analytics to footer
//function add_google_analytics() {
//	echo '<script src="http://www.google-analytics.com/ga.js" type="text/javascript"></script>';
//	echo '<script type="text/javascript">';
//	echo 'var pageTracker = _gat._getTracker("UA-XXXXX-X");';
//	echo 'pageTracker._trackPageview();';
//	echo '</script>';
//}
//add_action('wp_footer', 'add_google_analytics');

//// custom excerpt ellipses for 2.9+
//function custom_excerpt_more($more) {
//	return '...';
//}
//add_filter('excerpt_more', 'custom_excerpt_more');

/* custom excerpt ellipses for 2.8-
function custom_excerpt_more($excerpt) {
	return str_replace('[...]', '...', $excerpt);
}
add_filter('wp_trim_excerpt', 'custom_excerpt_more');
*/

//// no more jumping for read more link
//function no_more_jumping($post) {
//	return '<a href="'.get_permalink($post->ID).'" class="read-more">'.'Continue Reading'.'</a>';
//}
//add_filter('excerpt_more', 'no_more_jumping');

//// add a favicon
//function blog_favicon() {
//	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('wpurl').'/favicon.ico" />';
//}
//add_action('wp_head', 'blog_favicon');


//// add a favicon for your admin
//function admin_favicon() {
//	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/images/favicon.png" />';
//}
//add_action('admin_head', 'admin_favicon');

//// custom admin login logo
//function custom_login_logo() {
//	echo '<style type="text/css">
//	h1 a { background-image: url('.get_bloginfo('template_directory').'/images/custom-login-logo.png) !important; }
//	</style>';
//}
//add_action('login_head', 'custom_login_logo');

// no admin version check nag
if (!current_user_can('edit_users')) {
	add_action('init', create_function('$a', "remove_action('init', 'wp_version_check');"), 2);
	add_filter('pre_option_update_core', create_function('$a', "return null;"));
}

?>
