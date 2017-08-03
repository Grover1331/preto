<?php
session_start();
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentyseventeen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'twentyseventeen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyseventeen' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'twentyseventeen-featured-image', 2000, 1200, true );

	add_image_size( 'twentyseventeen-thumbnail-avatar', 100, 100, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'twentyseventeen' ),
		'social' => __( 'Social Links Menu', 'twentyseventeen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', twentyseventeen_fonts_url() ) );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets' => array(
			// Place three core-defined widgets in the sidebar area.
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area.
			'sidebar-2' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area.
			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x( 'Espresso', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
			),
			'image-sandwich' => array(
				'post_title' => _x( 'Sandwich', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/sandwich.jpg',
			),
			'image-coffee' => array(
				'post_title' => _x( 'Coffee', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/coffee.jpg',
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods' => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'top' => array(
				'name' => __( 'Top Menu', 'twentyseventeen' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

			// Assign a menu to the "social" location.
			'social' => array(
				'name' => __( 'Social Links Menu', 'twentyseventeen' ),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
		),
	);

	/**
	 * Filters Twenty Seventeen array of starter content.
	 *
	 * @since Twenty Seventeen 1.1
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'twentyseventeen_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'twentyseventeen_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function twentyseventeen_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( twentyseventeen_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter Twenty Seventeen content width of the theme.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'twentyseventeen_content_width', $content_width );
}
add_action( 'template_redirect', 'twentyseventeen_content_width', 0 );

/**
 * Register custom fonts.
 */
function twentyseventeen_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'twentyseventeen' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function twentyseventeen_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'twentyseventeen-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'twentyseventeen_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentyseventeen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'twentyseventeen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'twentyseventeen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'twentyseventeen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyseventeen_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentyseventeen_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'twentyseventeen_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function twentyseventeen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyseventeen_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'twentyseventeen_pingback_header' );

/**
 * Display custom color CSS.
 */
function twentyseventeen_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}

	require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
?>
	<style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"'; } ?>>
		<?php echo twentyseventeen_custom_colors_css(); ?>
	</style>
<?php }
add_action( 'wp_head', 'twentyseventeen_colors_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function twentyseventeen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'twentyseventeen-style', get_stylesheet_uri() );

	// Load the dark colorscheme.
	if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'twentyseventeen-style' ), '1.0' );
	}

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'twentyseventeen-style' ), '1.0' );
		wp_style_add_data( 'twentyseventeen-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'twentyseventeen-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'twentyseventeen-style' ), '1.0' );
	wp_style_add_data( 'twentyseventeen-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'twentyseventeen-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	$twentyseventeen_l10n = array(
		'quote'          => twentyseventeen_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	if ( has_nav_menu( 'top' ) ) {
		wp_enqueue_script( 'twentyseventeen-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '1.0', true );
		$twentyseventeen_l10n['expand']         = __( 'Expand child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['collapse']       = __( 'Collapse child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['icon']           = twentyseventeen_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
	}

	wp_enqueue_script( 'twentyseventeen-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

	wp_localize_script( 'twentyseventeen-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $twentyseventeen_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'twentyseventeen_scripts' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentyseventeen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function twentyseventeen_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'twentyseventeen_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentyseventeen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function twentyseventeen_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'twentyseventeen_front_page_template' );

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );





/*--------------Restaurants---------------*/

$labels = array(
'name' => _x( 'restaurant_category', 'Restaurant category' ),
'singular_name' => _x( 'Restaurant category', 'Restaurant category' ),
'search_items' => __( 'Search Restaurant category' ),
'all_items' => __( 'All Restaurant category' ),
'parent_item' => __( 'Parent Restaurant category' ),
'parent_item_colon' => __( 'Parent Restaurant category' ),
'edit_item' => __( 'Edit Restaurant category' ),
'update_item' => __( 'Update Restaurant category' ),
'add_new_item' => __( 'Add New Restaurant category' ),
'new_item_name' => __( 'New Restaurant category' ),
'menu_name' => __( 'Restaurant category' ),
);

$args = array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'show_admin_column' => true,
'query_var' => true,
'rewrite' => array( 'slug' => 'restaurant_category' ),
);

register_taxonomy( 'restaurant_category', array( 'restaurant_category' ), $args );
function codex_int_restaurants() {
  $labels = array(
    'name' => 'Restaurants',
    'singular_name' => 'Restaurants',
    'add_new' => 'Add Restaurants',
    'add_new_item' => 'Add New Restaurants',
    'edit_item' => 'Edit Restaurants',
    'new_item' => 'New Restaurants',
    'all_items' => 'All Restaurants',
    'view_item' => 'View Restaurants',
    'search_items' => 'Search Restaurants',
    'not_found' =>  'No Restaurants found',
    'not_found_in_trash' => 'No Restaurants found in Trash', 
    'parent_item_colon' => '',
    'menu_name' => 'Restaurants'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'restaurants' ), 
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
     'taxonomies' => array('restaurant_category'),
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
  ); 

  register_post_type( 'restaurants', $args ); 
}  
  add_action( 'init', 'codex_int_restaurants' );
/*--------------/Restaurants---------------*/



//Meta Box Starts For Timings




/*--------------/Price Range New Code---------------*/
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function myplugin_add_restaurants_timings() {

	$myPostType = array( 'restaurants' );

	foreach ( $myPostType as $value ) {

		add_meta_box(
			'myplugin_sectionid_price_range',
			__( 'Restaurants Timings', 'myplugin_tprice_range' ),
			'myplugin_add_call_restaurants_timings',
			$value
		);
	}
}
add_action( 'add_meta_boxes', 'myplugin_add_restaurants_timings' );
add_action( 'save_post', 'myplugin_save_meta_restaurants_timings');
/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function myplugin_add_call_restaurants_timings( $post) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'myplugin_meta_box', 'myplugin_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
		$post_id = $post->ID;
		global $wpdb;
	 ?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/jquery.timepicker.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/toastr.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/style.css" />
		<div class="meta-box-section">
			<div class="container1">
				<table class="table table-striped">
			    <thead>
			      <tr>
			        <th>Start Day</th>
			        <th>Start Time</th>
			        <th>End Day</th>
			        <th>End Time</th>
			        <th>Delete</th>
			      </tr>
			    </thead>
			    <tbody class="newRoles">
			    	<?php 
					$results = $wpdb->get_results( "SELECT * FROM `wtw_deal_new_timing` WHERE deal_id = '$post_id'");
					$test_count = count($results);
					if($test_count>0) {
						foreach($results as $result) {
							?>
							<tr>
						        <td>
						        	<select name="start_day_new[]" id="" onchange="start_day_change(this)" value="<?php echo $result->start_day; ?>">
							        	<option value="">Select Day</option>
							        	<option <?php if($result->start_day == "Monday") { echo "selected"; } ?> value="Monday">Monday</option>
								        <option <?php if($result->start_day == "Tuesday") { echo "selected"; } ?> value="Tuesday">Tuesday</option>
								        <option <?php if($result->start_day == "Wednesday") { echo "selected"; } ?> value="Wednesday">Wednesday</option>
								        <option <?php if($result->start_day == "Thursday") { echo "selected"; } ?> value="Thursday">Thursday</option>
								        <option <?php if($result->start_day == "Friday") { echo "selected"; } ?> value="Friday">Friday</option>
								        <option <?php if($result->start_day == "Saturday") { echo "selected"; } ?> value="Saturday">Saturday</option>
							        	<option <?php if($result->start_day == "Sunday") { echo "selected"; } ?> value="Sunday">Sunday</option>
						    		</select>
					    		</td>
						        <td>
						        	<input value="<?php echo $result->start_time; ?>" type="text" class="form-control myPlanTimer_new start_time_new" name="start_time_new[]"  autocomplete="off" Placeholder="Start Time">
						        </td>
						        <td>
						        	<select name="end_day_new[]" id="" value="<?php echo $result->end_day; ?>">
							        	<option value="">Select Day</option>
							        	<option <?php if($result->end_day == "Monday") { echo "selected"; } ?> value="Monday">Monday</option>
								        <option <?php if($result->end_day == "Tuesday") { echo "selected"; } ?> value="Tuesday">Tuesday</option>
								        <option <?php if($result->end_day == "Wednesday") { echo "selected"; } ?> value="Wednesday">Wednesday</option>
								        <option <?php if($result->end_day == "Thursday") { echo "selected"; } ?> value="Thursday">Thursday</option>
								        <option <?php if($result->end_day == "Friday") { echo "selected"; } ?> value="Friday">Friday</option>
								        <option <?php if($result->end_day == "Saturday") { echo "selected"; } ?> value="Saturday">Saturday</option>
							        	<option <?php if($result->end_day == "Sunday") { echo "selected"; } ?>  value="Sunday">Sunday</option>
						    		</select>
					    		</td>
						        <td>
						        	<input value="<?php echo $result->end_time; ?>" type="text" class="form-control myPlanTimer_new end_time" name="end_time_new[]"  autocomplete="off" Placeholder="End Time">
						        </td>
						        <td>
						        	<button onclick="deleteRow(this);" class="btn-primary" >Delete</button>
						        </td>
				      		</tr>
							<?php
						}
					} else {
						?>
						<tr>
					        <td>
					        	<select name="start_day_new[]" id="" onchange="start_day_change(this)">
						        	<option value="">Select Day</option>
						        	<option value="Monday">Monday</option>
							        <option value="Tuesday">Tuesday</option>
							        <option value="Wednesday">Wednesday</option>
							        <option value="Thursday">Thursday</option>
							        <option value="Friday">Friday</option>
							        <option value="Saturday">Saturday</option>
						        	<option value="Sunday">Sunday</option>
					    		</select>
				    		</td>
					        <td>
					        	<input type="text" class="form-control myPlanTimer_new start_time_new" name="start_time_new[]"  autocomplete="off" Placeholder="Start Time">
					        </td>
					        <td>
					        	<select name="end_day_new[]" id="">
						        	<option value="">Select Day</option>
						        	<option value="Monday">Monday</option>
							        <option value="Tuesday">Tuesday</option>
							        <option value="Wednesday">Wednesday</option>
							        <option value="Thursday">Thursday</option>
							        <option value="Friday">Friday</option>
							        <option value="Saturday">Saturday</option>
						        	<option value="Sunday">Sunday</option>
					    		</select>
				    		</td>
					        <td>
					        	<input type="text" class="form-control myPlanTimer_new end_time" name="end_time_new[]"  autocomplete="off" Placeholder="End Time">
					        </td>
					       
					        <td>
					        	<button onclick="deleteRow(this);" class="btn-primary" >Delete</button>
					        </td>
				      	</tr>
						<?php
					}
			    	 ?>
			      
			      
			    </tbody>
			  </table>
			<button type="button" class="btn-primary" onclick="add_results();">Add Row</button>
			</div>
		</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src='<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery.timepicker.js'></script>
    <script src='<?php echo esc_url( get_template_directory_uri() ); ?>/js/toastr.js'></script>
    <script>
    jQuery(document).ready(function(){
    	jQuery(".myPlanTimer_new").each(function(){
    		jQuery(this).timepicker();
    		jQuery(".postbox").each(function(){
    			jQuery(this).removeClass("closed");
    		});
    	});
    });


    function deleteRow(event) {
    	jQuery(event).parent().parent().remove();
    	save_results1111();

    }
    function add_results() {
    	jQuery(".newRoles").append(" <tr> <td> <select name='start_day_new[]' id='' onchange='start_day_change(this)'> <option value=''>Select Day</option> <option value='Monday'>Monday</option> <option value='Tuesday'>Tuesday</option> <option value='Wednesday'>Wednesday</option> <option value='Thursday'>Thursday</option> <option value='Friday'>Friday</option> <option value='Saturday'>Saturday</option> <option value='Sunday'>Sunday</option> </select> </td><td><input type='text' class='form-control myPlanTimer_new start_time' name='start_time_new[]' autocomplete='off' Placeholder='Start Time'></td><td> <select name='end_day_new[]' id=''> <option value=''>Select Day</option> <option value='Monday'>Monday</option> <option value='Tuesday'>Tuesday</option> <option value='Wednesday'>Wednesday</option> <option value='Thursday'>Thursday</option> <option value='Friday'>Friday</option> <option value='Saturday'>Saturday</option> <option value='Sunday'>Sunday</option> </select> </td><td><input type='text' class='form-control myPlanTimer_new end_time' name='end_time_new[]' autocomplete='off' Placeholder='End Time'></td><td><button onclick='deleteRow(this);' class='btn-primary' >Delete</button></td></tr>");
    	jQuery(".myPlanTimer_new").each(function(){
    		jQuery(this).timepicker();
    		jQuery(".postbox").each(function(){
    			jQuery(this).removeClass("closed");
    		});
    	});
    }
    </script>
    <!-------------------------Save Results---------------------------------------->
    <script>
    function start_day_change(event) {
    	var value = jQuery(event).val();
    	if(jQuery(event).parent().siblings("td:eq(1)").find("select").val() == "") {
    		jQuery(event).parent().siblings("td:eq(1)").find("select").val(value);
    	}
    	jQuery(event).parent().siblings("td:eq(4)").find("input").val(value);
    }

	</script>
    <!-------------------------Save Results---------------------------------------->
	
<style>
    
</style>
<?php
	
}


function myplugin_save_meta_restaurants_timings( $post_id ) {
	global $wpdb;
	
	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
		return;
	}


	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */
	// Make sure that it is set.
	$start_day = $_POST['start_day_new'];
	$start_time = $_POST['start_time_new'];
	$end_day = $_POST['end_day_new'];
	$end_time = $_POST['end_time_new'];
	$start_foodTeam = $_POST['start_foodTeam'];
	$start_payment = $_POST['start_payment'];
	$start_facility = $_POST['start_facility'];
	$wpdb->query("DELETE  FROM `wtw_deal_new_timing` WHERE `deal_id` = '".$post_id."'");
	$wpdb->query("DELETE  FROM `wtw_foofItem` WHERE `restID` = '".$post_id."'");
	$wpdb->query("DELETE  FROM `wtw_payment` WHERE `restID` = '".$post_id."'");
	$wpdb->query("DELETE  FROM `wtw_facilities` WHERE `restID` = '".$post_id."'");

	$i=0;
	foreach ($start_day as $value) {
		$wpdb->insert( 'wtw_deal_new_timing', array(
			'deal_id' => $post_id,
			'start_day' => $value,
			'start_time' => $start_time[$i],
			'end_day' => $end_day[$i],
			'end_time' => $end_time[$i])
			);
	$i++;
	}

	foreach ($start_foodTeam as $value) {
		$wpdb->insert( 'wtw_foofItem', array(
			'restID' => $post_id,
			'name' => $value)
		);
	}
	foreach ($start_payment as $value) {
		$wpdb->insert( 'wtw_payment', array(
			'restID' => $post_id,
			'name' => $value)
		);
	}
	foreach ($start_facility as $value) {
		$wpdb->insert( 'wtw_facilities', array(
			'restID' => $post_id,
			'name' => $value)
		);
	}
	
}


/*--------------/Price Range New Code---------------*/
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function myplugin_add_type_of_food() {

	$myPostType = array( 'restaurants' );

	foreach ( $myPostType as $value ) {

		add_meta_box(
			'myplugin_sectionid_menu_item',
			__( 'Type of food', 'myplugin_menu_items' ),
			'myplugin_add_call_type_of_foods',
			$value
		);
	}
}
add_action( 'add_meta_boxes', 'myplugin_add_type_of_food' );
/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function myplugin_add_call_type_of_foods( $post) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'myplugin_meta_box', 'myplugin_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
		$post_id = $post->ID;
		global $wpdb;
	 ?>
		<div class="meta-box-section">
			<div class="container1">
				<table class="table table-striped">
			    <thead>
			      <tr>
			        <th>Type of food</th>
			      </tr>
			    </thead>
			    <tbody class="newRolesq">
			    	<?php 
					$results = $wpdb->get_results( "SELECT * FROM `wtw_foofItem` WHERE restID = '$post_id'");
					$test_count = count($results);
					if($test_count>0) {
						foreach($results as $result) {
							?>
							<tr>
						        <td>
						        	<input value="<?php echo $result->name; ?>" type="text" class="form-control  " name="start_foodTeam[]"   Placeholder="Food Item">
						        </td>
						        <td>
					        	<button onclick="deleteRow1(this);" class="btn-danger" >Delete</button>
					        </td>
				      		</tr>
							<?php
						}
					} else {
						?>
						<tr>
					        <td>
					        	<input type="text" class="form-control  " name="start_foodTeam[]"  Placeholder="Food Item">
					        </td>
					        <td>
					        	<button onclick="deleteRow1(this);" class="btn-danger" >Delete</button>
					        </td>
				      	</tr>
						<?php
					}
			    	 ?>
			      
			      
			    </tbody>
			  </table>
			<button type="button" class="btn-primary" onclick="add_results1();">Add Row</button>
			</div>
		</div>
    <script>
   
    function deleteRow1(event) {
    	jQuery(event).parent().parent().remove();

    }
    function add_results1() {
    	jQuery(".newRolesq").append("<tr><td><input type='text' class='form-control myPlanTimer_new ' name='start_foodTeam[]'  Placeholder='Food Item'></td><td><button onclick='deleteRow1(this);' class='btn-danger' >Delete</button></td></tr>");
    }
    </script>
<?php
	
}


/*--------------/Price Range New Code---------------*/
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function myplugin_add_payment_method() {

	$myPostType = array( 'restaurants' );

	foreach ( $myPostType as $value ) {

		add_meta_box(
			'myplugin_sectionid_payment_method',
			__( 'Payment Method', 'myplugin_payment_method' ),
			'myplugin_add_call_payment_method',
			$value
		);
	}
}
add_action( 'add_meta_boxes', 'myplugin_add_payment_method' );
/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function myplugin_add_call_payment_method( $post) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'myplugin_meta_box', 'myplugin_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
		$post_id = $post->ID;
		global $wpdb;
	 ?>
		<div class="meta-box-section">
			<div class="container1">
				<table class="table table-striped">
			    <thead>
			      <tr>
			        <th>Payment Method</th>
			      </tr>
			    </thead>
			    <tbody class="newRolesw">
			    	<?php 
					$results = $wpdb->get_results( "SELECT * FROM `wtw_payment` WHERE restID = '$post_id'");
					$test_count = count($results);
					if($test_count>0) {
						foreach($results as $result) {
							?>
							<tr>
						        <td>
						        	<input value="<?php echo $result->name; ?>" type="text" class="form-control  " name="start_payment[]"   Placeholder="Payment Method">
						        </td>
						        <td>
					        	<button onclick="deleteRow2(this);" class="btn-danger" >Delete</button>
					        </td>
				      		</tr>
							<?php
						}
					} else {
						?>
						<tr>
					        <td>
					        	<input type="text" class="form-control  " name="start_payment[]"  Placeholder="Payment Method">
					        </td>
					        <td>
					        	<button onclick="deleteRow2(this);" class="btn-danger" >Delete</button>
					        </td>
				      	</tr>
						<?php
					}
			    	 ?>
			      
			      
			    </tbody>
			  </table>
			<button type="button" class="btn-primary" onclick="add_results2();">Add Row</button>
			</div>
		</div>
    <script>
   
    function deleteRow2(event) {
    	jQuery(event).parent().parent().remove();

    }
    function add_results2() {
    	jQuery(".newRolesw").append("<tr><td><input type='text' class='form-control myPlanTimer_new ' name='start_payment[]'  Placeholder='Payment Method'></td><td><button onclick='deleteRow2(this);' class='btn-danger' >Delete</button></td></tr>");
    }
    </script>
<?php
	
}

/*--------------/Price Range New Code---------------*/
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function myplugin_add_facility() {

	$myPostType = array( 'restaurants' );

	foreach ( $myPostType as $value ) {

		add_meta_box(
			'myplugin_sectionid_facility',
			__( 'Facilities', 'myplugin_facility' ),
			'myplugin_add_call_facility',
			$value
		);
	}
}
add_action( 'add_meta_boxes', 'myplugin_add_facility' );
/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function myplugin_add_call_facility( $post) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'myplugin_meta_box', 'myplugin_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
		$post_id = $post->ID;
		global $wpdb;
	 ?>
		<div class="meta-box-section">
			<div class="container1">
				<table class="table table-striped">
			    <thead>
			      <tr>
			        <th>Facilities</th>
			      </tr>
			    </thead>
			    <tbody class="newRolese">
			    	<?php 
					$results = $wpdb->get_results( "SELECT * FROM `wtw_facilities` WHERE restID = '$post_id'");
					$test_count = count($results);
					if($test_count>0) {
						foreach($results as $result) {
							?>
							<tr>
						        <td>
						        	<input value="<?php echo $result->name; ?>" type="text" class="form-control  " name="start_facility[]"   Placeholder="Facilities">
						        </td>
						        <td>
					        	<button onclick="deleteRow3(this);" class="btn-danger" >Delete</button>
					        </td>
				      		</tr>
							<?php
						}
					} else {
						?>
						<tr>
					        <td>
					        	<input type="text" class="form-control  " name="start_facility[]"  Placeholder="Facilities">
					        </td>
					        <td>
					        	<button onclick="deleteRow3(this);" class="btn-danger" >Delete</button>
					        </td>
				      	</tr>
						<?php
					}
			    	 ?>
			      
			      
			    </tbody>
			  </table>
			<button type="button" class="btn-primary" onclick="add_results3();">Add Row</button>
			</div>
		</div>
    <script>
   
    function deleteRow3(event) {
    	jQuery(event).parent().parent().remove();

    }
    function add_results3() {
    	jQuery(".newRolese").append("<tr><td><input type='text' class='form-control myPlanTimer_new ' name='start_facility[]'  Placeholder='Facilities'></td><td><button onclick='deleteRow3(this);' class='btn-danger' >Delete</button></td></tr>");
    }
    </script>
<?php
	
}
