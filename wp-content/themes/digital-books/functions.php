<?php
/**
 * Digital Books functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Digital Books
 */

include get_theme_file_path( 'vendor/wptrt/autoload/src/Digital_Books_Loader.php' );

$digital_books_loader = new \WPTRT\Autoload\Digital_Books_Loader();

$digital_books_loader->digital_books_add( 'WPTRT\\Customize\\Section', get_theme_file_path( 'vendor/wptrt/customize-section-button/src' ) );

$digital_books_loader->digital_books_register();

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function digital_books_setup() {

	add_theme_support( 'responsive-embeds' );

	add_theme_support( 'woocommerce' );

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

	add_image_size('digital-books-featured-header-image', 2000, 660, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary','digital-books' ),
		'footer'=> esc_html__( 'Footer Menu','digital-books' ),
	) );

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		* to output valid HTML5.
		*/
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'digital_books_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 50,
		'width'       => 50,
		'flex-width'  => true,
	) );

	add_editor_style( array( '/editor-style.css' ) );
	add_action('wp_ajax_digital_books_dismissable_notice', 'digital_books_dismissable_notice');

	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'digital_books_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function digital_books_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'digital_books_content_width', 1170 );
}
add_action( 'after_setup_theme', 'digital_books_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function digital_books_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'digital-books' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'digital-books' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Woocommerce Shop Page Sidebar', 'digital-books' ),
		'id'            => 'woocommerce-shop-page-sidebar',
		'description'   => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'digital-books' ),
		'id'            => 'digital-books-footer1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="footer-column-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'digital-books' ),
		'id'            => 'digital-books-footer2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="footer-column-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'digital-books' ),
		'id'            => 'digital-books-footer3',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="footer-column-widget-title">',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'digital_books_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function digital_books_scripts() {
	require_once get_theme_file_path( 'inc/wptt-webfont-loader.php' );

	wp_enqueue_style(
	'ubuntu',
	wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap' ),
	array(),
	'1.0'
	);

	wp_enqueue_style(
		'libre-baskerville',
		wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap' ),
		array(),
		'1.0'
	);

	wp_enqueue_style( 'digital-books-block-editor-style', get_theme_file_uri('/assets/css/block-editor-style.css') );

	// load bootstrap css
    wp_enqueue_style( 'bootstrap-css',get_template_directory_uri() . '/assets/css/bootstrap.css');

    // Theme stylesheet.
	wp_enqueue_style( 'digital-books-style', get_stylesheet_uri() );
	require get_parent_theme_file_path( '/custom-option.php' );
	wp_add_inline_style( 'digital-books-style',$digital_books_theme_css );

	wp_enqueue_style( 'digital-books-style', get_stylesheet_uri() );

	wp_style_add_data('digital-books-style', 'rtl', 'replace');

	// fontawesome
	wp_enqueue_style( 'fontawesome-css',get_template_directory_uri().'/assets/css/fontawesome/css/all.css' );

	wp_enqueue_style( 'owl.carousel-css',get_template_directory_uri().'/assets/css/owl.carousel.css' );

    wp_enqueue_script('owl.carousel-js',get_template_directory_uri() . '/assets/js/owl.carousel.js', array('jquery'), '', true );

    wp_enqueue_script('digital-books-theme-js',get_template_directory_uri() . '/assets/js/theme-script.js', array('jquery'), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}	
}
add_action( 'wp_enqueue_scripts', 'digital_books_scripts' );

/**
 * Enqueue theme color style.
 */
function digital_books_theme_color() {

    $digital_books_theme_color_css = '';
    $digital_books_theme_color = get_theme_mod('digital_books_theme_color');
    $digital_books_theme_color_2 = get_theme_mod('digital_books_theme_color_2');
    $digital_books_preloader_bg_color = get_theme_mod('digital_books_preloader_bg_color');
    $digital_books_preloader_dot_1_color = get_theme_mod('digital_books_preloader_dot_1_color');
    $digital_books_preloader_dot_2_color = get_theme_mod('digital_books_preloader_dot_2_color');
  	$digital_books_preloader2_dot_color = get_theme_mod('digital_books_preloader2_dot_color');
    $digital_books_logo_max_height = get_theme_mod('digital_books_logo_max_height');

	if(get_theme_mod('digital_books_logo_max_height') == '') {
		$digital_books_logo_max_height = '24';
	}
	if(get_theme_mod('digital_books_preloader_dot_1_color') == '') {
		$digital_books_preloader_dot_1_color = '#fff';
	}
	if(get_theme_mod('digital_books_preloader_dot_2_color') == '') {
		$digital_books_preloader_dot_2_color = '#1e3237';
	}

	$digital_books_theme_color_css = '
		.custom-logo-link img{
				max-height: '.esc_attr($digital_books_logo_max_height).'px;
			 }
		.sticky .entry-title::before,.main-navigation .sub-menu,#button,.sidebar input[type="submit"],.comment-respond input#submit,.post-navigation .nav-previous a:hover, .post-navigation .nav-next a:hover, .posts-navigation .nav-previous a:hover, .posts-navigation .nav-next a:hover,.woocommerce .woocommerce-ordering select,.woocommerce ul.products li.product .onsale, .woocommerce span.onsale,.pro-button a, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.wp-block-button__link,.serv-box:hover,.woocommerce-account .woocommerce-MyAccount-navigation ul li,.btn-primary,.sidebar h5,.toggle-nav i,span.onsale,.slide-btn a,.serach_inner [type="submit"],.counter_box1,.sidebar .tagcloud a:hover,.woocommerce a.added_to_cart,a.account-btn {
			background: '.esc_attr($digital_books_theme_color).';
		}
		a,.sidebar ul li a:hover,#colophon a:hover, #colophon a:focus,p.price, .woocommerce ul.products li.product .price, .woocommerce div.product p.price, .woocommerce div.product span.price,.woocommerce-message::before, .woocommerce-info::before,.slider-inner-box a h2,.woocommerce .star-rating span::before,.product-home-box .star-rating span::before,#colophon a:hover, #colophon a:focus,.slider-inner-box h2 {
			color: '.esc_attr($digital_books_theme_color).';
		}
		a.rsswidget {
    color: '.esc_attr($digital_books_theme_color).'!important;
		}
		.woocommerce-message, .woocommerce-info,.wp-block-pullquote,.wp-block-quote, .wp-block-quote:not(.is-large):not(.is-style-large), .wp-block-pullquote,.btn-primary{
			border-color: '.esc_attr($digital_books_theme_color).';
		}
		span.cart-value,.slide-btn a:hover,.pro-button a:hover,.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,.main-navigation .sub-menu,#button:hover,.top-info,.serach_inner,#top-slider,#colophon,.woocommerce-account .woocommerce-MyAccount-navigation ul li:hover,.main-navigation .sub-menu > li > a:hover, .main-navigation .sub-menu > li > a:focus:hover,.woocommerce a.added_to_cart:hover{
			background: '.esc_attr($digital_books_theme_color_2).';
		}
		.main-navigation .menu > li > a:hover,{
			color: '.esc_attr($digital_books_theme_color_2).';
		}
		.loading, .loading2{
			background-color: '.esc_attr($digital_books_preloader_bg_color).';
		 }
		 @keyframes loading {
		  0%,
		  100% {
		  	transform: translatey(-2.5rem);
		    background-color: '.esc_attr($digital_books_preloader_dot_1_color).';
		  }
		  50% {
		  	transform: translatey(2.5rem);
		    background-color: '.esc_attr($digital_books_preloader_dot_2_color).';
		  }
		}
		.load hr {
			background-color: '.esc_attr($digital_books_preloader2_dot_color).';
		}
	';
    wp_add_inline_style( 'digital-books-style',$digital_books_theme_color_css );

}
add_action( 'wp_enqueue_scripts', 'digital_books_theme_color' );

/**
 * Enqueue S Header.
 */
function digital_books_sticky_header() {

  $digital_books_sticky_header = get_theme_mod('digital_books_sticky_header');

  $digital_books_custom_style= "";

  if($digital_books_sticky_header != true){

    $digital_books_custom_style .='.stick_header{';

      $digital_books_custom_style .='position: static;';

    $digital_books_custom_style .='}';
  }

  wp_add_inline_style( 'digital-books-style',$digital_books_custom_style );

}
add_action( 'wp_enqueue_scripts', 'digital_books_sticky_header' );

function digital_books_sanitize_number_absint( $number, $setting ) {
	// Ensure $number is an absolute integer (whole number, zero or greater).
	$number = absint( $number );

	// If the input is an absolute integer, return it; otherwise, return the default
	return ( $number ? $number : $setting->default );
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/* TGM. */
require get_parent_theme_file_path( '/inc/tgm.php' );

/** * Posts pagination. */
if ( ! function_exists( 'digital_books_blog_posts_pagination' ) ) {
	function digital_books_blog_posts_pagination() {
		$pagination_type = get_theme_mod( 'digital_books_blog_pagination_type', 'blog-nav-numbers' );
		if ( $pagination_type == 'blog-nav-numbers' ) {
			the_posts_pagination();
		} else {
			the_posts_navigation();
		}
	}
}

/*dropdown page sanitization*/
function digital_books_sanitize_dropdown_pages( $page_id, $setting ) {
	$page_id = absint( $page_id );
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

function digital_books_preloader1(){
	if(get_theme_mod('digital_books_preloader_type', 'Preloader 1') == 'Preloader 1' ) {
		return true;
	}
	return false;
}

function digital_books_preloader2(){
	if(get_theme_mod('digital_books_preloader_type', 'Preloader 1') == 'Preloader 2' ) {
		return true;
	}
	return false;
}

function digital_books_sanitize_select( $input, $setting ){
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function digital_books_sanitize_checkbox( $input ) {
  // Boolean check
  return ( ( isset( $input ) && true == $input ) ? true : false );
}

 //Float
function digital_books_sanitize_float( $input ) {
    return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

/*radio button sanitization*/
function digital_books_sanitize_choices( $input, $setting ) {
    global $wp_customize;
    $control = $wp_customize->get_control( $setting->id );
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

function digital_books_sanitize_number_range( $number, $setting ) {
	
	// Ensure input is an absolute integer.
	$number = absint( $number );
	
	// Get the input attributes associated with the setting.
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;
	
	// Get minimum number in the range.
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
	
	// Get maximum number in the range.
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
	
	// Get step.
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
	
	// If the number is within the valid range, return it; otherwise, return the default
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

//Change number of products that are displayed per page (shop page)
add_filter( 'loop_shop_per_page', 'digital_books_shop_per_page', 9 );
function digital_books_shop_per_page( $cols ) {
  	$cols = get_theme_mod( 'digital_books_product_per_page', 9 );
	return $cols;
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'digital_books_loop_columns');
if (!function_exists('digital_books_loop_columns')) {
	function digital_books_loop_columns() {
		$columns = get_theme_mod( 'digital_books_products_per_row', 3 );
		return $columns; // 3 products per row
	}
}

/**
 * Get CSS
 */

function digital_books_getpage_css($hook) {
	wp_enqueue_script( 'digital-books-admin-script', get_template_directory_uri() . '/inc/admin/js/digital-books-admin-notice-script.js', array( 'jquery' ) );
    wp_localize_script( 'digital-books-admin-script', 'digital_books_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
    );
	if ( 'appearance_page_digital-books-info' != $hook ) {
		return;
	}
	wp_enqueue_style( 'digital-books-demo-style', get_template_directory_uri() . '/assets/css/demo.css' );
}
add_action( 'admin_enqueue_scripts', 'digital_books_getpage_css' );

if ( ! defined( 'DIGITAL_BOOKS_CONTACT_SUPPORT' ) ) {
define('DIGITAL_BOOKS_CONTACT_SUPPORT',__('https://wordpress.org/support/theme/digital-books','digital-books'));
}
if ( ! defined( 'DIGITAL_BOOKS_REVIEW' ) ) {
define('DIGITAL_BOOKS_REVIEW',__('https://wordpress.org/support/theme/digital-books/reviews/#new-post','digital-books'));
}
if ( ! defined( 'DIGITAL_BOOKS_LIVE_DEMO' ) ) {
define('DIGITAL_BOOKS_LIVE_DEMO',__('https://demo.themagnifico.net/digital-books/','digital-books'));
}
if ( ! defined( 'DIGITAL_BOOKS_GET_PREMIUM_PRO' ) ) {
define('DIGITAL_BOOKS_GET_PREMIUM_PRO',__('https://www.themagnifico.net/products/book-store-wordpress-theme','digital-books'));
}
if ( ! defined( 'DIGITAL_BOOKS_PRO_DOC' ) ) {
define('DIGITAL_BOOKS_PRO_DOC',__('https://demo.themagnifico.net/eard/wathiqa/book-store-pro-doc/','digital-books'));
}
if ( ! defined( 'DIGITAL_BOOKS_FREE_DOC' ) ) {
define('DIGITAL_BOOKS_FREE_DOC',__('https://demo.themagnifico.net/eard/wathiqa/digital-books-free-doc/','digital-books'));
}

add_action('admin_menu', 'digital_books_themepage');
function digital_books_themepage(){

	$digital_books_theme_test = wp_get_theme();

	$digital_books_theme_info = add_theme_page( __('Theme Options','digital-books'), __(' Theme Options','digital-books'), 'manage_options', 'digital-books-info.php', 'digital_books_info_page' );
}

function digital_books_info_page() {
	$digital_books_theme_user = wp_get_current_user();
	$digital_books_theme = wp_get_theme();
	?>
	<div class="wrap about-wrap digital-books-add-css">
		<div>
			<h1>
				<?php esc_html_e('Welcome To ','digital-books'); ?><?php echo esc_html( $digital_books_theme ); ?>
			</h1>
			<div class="feature-section three-col">
				<div class="col">
					<div class="widgets-holder-wrap demo-content">
						<h3><?php esc_html_e("Instant Demo Setup", "digital-books"); ?></h3>
						<p><?php esc_html_e("Import your entire demo content in just one click, including pages, posts, and design elements for a quick setup.", "digital-books"); ?></p>
						<p><a target="_blank" href="<?php echo esc_url( admin_url( 'admin.php?page=theme-importer' )); ?>" class="button button-primary get">
							<?php esc_html_e("Start Demo Import", "digital-books"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php esc_html_e("Contact Support", "digital-books"); ?></h3>
						<p><?php esc_html_e("Thank you for trying Digital Books , feel free to contact us for any support regarding our theme.", "digital-books"); ?></p>
						<p><a target="_blank" href="<?php echo esc_url( DIGITAL_BOOKS_CONTACT_SUPPORT ); ?>" class="button button-primary get">
							<?php esc_html_e("Contact Support", "digital-books"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php esc_html_e("Checkout Premium", "digital-books"); ?></h3>
						<p><?php esc_html_e("Our premium theme comes with extended features like demo content import , responsive layouts etc.", "digital-books"); ?></p>
						<p><a target="_blank" href="<?php echo esc_url( DIGITAL_BOOKS_GET_PREMIUM_PRO ); ?>" class="button button-primary get prem">
							<?php esc_html_e("Get Premium", "digital-books"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php esc_html_e("Review", "digital-books"); ?></h3>
						<p><?php esc_html_e("If You love Digital Books theme then we would appreciate your review about our theme.", "digital-books"); ?></p>
						<p><a target="_blank" href="<?php echo esc_url( DIGITAL_BOOKS_REVIEW ); ?>" class="button button-primary get">
							<?php esc_html_e("Review", "digital-books"); ?>
						</a></p>
					</div>
				</div>
				<div class="col">
					<div class="widgets-holder-wrap">
						<h3><?php esc_html_e("Free Documentation", "digital-books"); ?></h3>
						<p><?php esc_html_e("Our guide is available if you require any help configuring and setting up the theme. Easy and quick way to setup the theme.", "digital-books"); ?></p>
						<p><a target="_blank" href="<?php echo esc_url( DIGITAL_BOOKS_FREE_DOC ); ?>" class="button button-primary get">
							<?php esc_html_e("Free Documentation", "digital-books"); ?>
						</a></p>
					</div>
				</div>
			</div>
		</div>
		<hr>

		<h2><?php esc_html_e("Free Vs Premium","digital-books"); ?></h2>
		<div class="digital-books-button-container">
			<a target="_blank" href="<?php echo esc_url( DIGITAL_BOOKS_PRO_DOC ); ?>" class="button button-primary get">
				<?php esc_html_e("Checkout Documentation", "digital-books"); ?>
			</a>
			<a target="_blank" href="<?php echo esc_url( DIGITAL_BOOKS_LIVE_DEMO ); ?>" class="button button-primary get">
				<?php esc_html_e("View Theme Demo", "digital-books"); ?>
			</a>
		</div>


		<table class="wp-list-table widefat">
			<thead class="table-book">
				<tr>
					<th><strong><?php esc_html_e("Theme Feature", "digital-books"); ?></strong></th>
					<th><strong><?php esc_html_e("Basic Version", "digital-books"); ?></strong></th>
					<th><strong><?php esc_html_e("Premium Version", "digital-books"); ?></strong></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><?php esc_html_e("Header Background Color", "digital-books"); ?></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Custom Navigation Logo Or Text", "digital-books"); ?></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Hide Logo Text", "digital-books"); ?></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>

				<tr>
					<td><?php esc_html_e("Premium Support", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Fully SEO Optimized", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Recent Posts Widget", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>

				<tr>
					<td><?php esc_html_e("Easy Google Fonts", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Pagespeed Plugin", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Only Show Header Image On Front Page", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Show Header Everywhere", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Custom Text On Header Image", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Full Width (Hide Sidebar)", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Only Show Upper Widgets On Front Page", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Replace Copyright Text", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Upper Widgets Colors", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Navigation Color", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Post/Page Color", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Blog Feed Color", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Footer Color", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Sidebar Color", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Customize Background Color", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
				<tr>
					<td><?php esc_html_e("Importable Demo Content	", "digital-books"); ?></td>
					<td><span class="cross"><span class="dashicons dashicons-dismiss"></span></span></td>
					<td><span class="tick"><span class="dashicons dashicons-yes-alt"></span></span></td>
				</tr>
			</tbody>
		</table>
		<div class="digital-books-button-container">
			<a target="_blank" href="<?php echo esc_url( DIGITAL_BOOKS_GET_PREMIUM_PRO ); ?>" class="button button-primary get prem">
				<?php esc_html_e("Go Premium", "digital-books"); ?>
			</a>
		</div>
	</div>
	<?php
}

//Admin Notice For Getstart
function digital_books_ajax_notice_handler() {
    if ( isset( $_POST['type'] ) ) {
        $type = sanitize_text_field( wp_unslash( $_POST['type'] ) );
        update_option( 'dismissed-' . $type, TRUE );
    }
}

function digital_books_deprecated_hook_admin_notice() {

    $dismissed = get_user_meta(get_current_user_id(), 'digital_books_dismissable_notice', true);
    if ( !$dismissed) { ?>
        <div class="updated notice notice-success is-dismissible notice-get-started-class" data-notice="get_started" style="background: #f7f9f9; padding: 20px 10px; display: flex;">
	    	<div class="tm-admin-image">
	    		<img style="width: 100%;max-width: 320px;line-height: 40px;display: inline-block;vertical-align: top;border: 2px solid #ddd;border-radius: 4px;" src="<?php echo esc_url(get_stylesheet_directory_uri()) .'/screenshot.png'; ?>" />
	    	</div>
	    	<div class="tm-admin-content" style="padding-left: 30px; align-self: center">
	    		<h2 style="font-weight: 600;line-height: 1.3; margin: 0px;"><?php esc_html_e('Thank You For Choosing ', 'digital-books'); ?><?php echo wp_get_theme(); ?><h2>
	    		<p style="color: #3c434a; font-weight: 400; margin-bottom: 30px;"><?php _e('Get Started With Theme By Clicking On Getting Started.', 'digital-books'); ?><p>
    			<a class="admin-notice-btn button button-primary button-hero" target="_blank" href="<?php echo esc_url( admin_url( 'admin.php?page=theme-importer' )); ?>"><?php esc_html_e( 'Start Demo Import', 'digital-books' ) ?></a>
	        	<a class="admin-notice-btn button button-primary button-hero" href="<?php echo esc_url( admin_url( 'themes.php?page=digital-books-info.php' )); ?>"><?php esc_html_e( 'Get started', 'digital-books' ) ?></a>
	        	<a class="admin-notice-btn button button-primary button-hero" target="_blank" href="<?php echo esc_url( DIGITAL_BOOKS_FREE_DOC ); ?>"><?php esc_html_e( 'Documentation', 'digital-books' ) ?></a>
	        	<span style="padding-top: 15px; display: inline-block; padding-left: 8px;">
	        	<span class="dashicons dashicons-admin-links"></span>
	        	<a class="admin-notice-btn"	 target="_blank" href="<?php echo esc_url( DIGITAL_BOOKS_LIVE_DEMO ); ?>"><?php esc_html_e( 'View Demo', 'digital-books' ) ?></a>
	        	</span>
	    	</div>
        </div>
    <?php }
}

add_action( 'admin_notices', 'digital_books_deprecated_hook_admin_notice' );

function digital_books_switch_theme() {
    delete_user_meta(get_current_user_id(), 'digital_books_dismissable_notice');
}
add_action('after_switch_theme', 'digital_books_switch_theme');
function digital_books_dismissable_notice() {
    update_user_meta(get_current_user_id(), 'digital_books_dismissable_notice', true);
    die();
}

// Demo Content Code

// Ensure WordPress is loaded
if (!defined('ABSPATH')) {
    exit;
}

// Add admin menu page to trigger theme import
add_action('admin_menu', 'demo_importer_admin_page');

function demo_importer_admin_page() {
    add_theme_page(
        'Demo Theme Importer',     // Page title
        'Theme Importer',          // Menu title
        'manage_options',          // Capability
        'theme-importer',          // Menu slug
        'demo_importer_page',      // Callback function
    );
}

// Display the page content with the button
function demo_importer_page() {
    ?>
    <div class="wrap-main-box">
        <div class="main-box">
            <h2><?php echo esc_html('Welcome to Digital Books','digital-books'); ?></h2>
            <h3><?php echo esc_html('Create your website in just one click','digital-books'); ?></h3>
            <hr>
            <p><?php echo esc_html('The "Begin Installation" helps you quickly set up your website by importing sample content that mirrors the demo version of the theme. This tool provides you with a ready-made layout and structure, so you can easily see how your site will look and start customizing it right away. It\'s a straightforward way to get your site up and running with minimal effort.','digital-books'); ?></p>
            <p><?php echo esc_html('Click the button below to install the demo content.','digital-books'); ?></p>
            <hr>
            <button id="import-theme-mods" class="button button-primary"><?php echo esc_html('Begin Installation','digital-books'); ?></button>
            <div id="import-response"></div>
        </div>
    </div>
    <?php
}

// Add the AJAX action to trigger theme mods import
add_action('wp_ajax_import_theme_mods', 'demo_importer_ajax_handler');

// Handle the AJAX request
function demo_importer_ajax_handler() {
    // Sample data to import
    $theme_mods_data = array(
        'header_textcolor' => '000000',  // Example: change header text color
        'background_color' => 'ffffff',  // Example: change background color
        'custom_logo'      => 123,       // Example: set a custom logo by attachment ID
        'footer_text'      => 'Custom Footer Text', // Example: custom footer text
    );

    // Call the function to import theme mods
    if (demo_theme_importer($theme_mods_data)) {
        // After importing theme mods, create the menu
        create_demo_menu();
        wp_send_json_success(array(
        	'msg' => 'Theme mods and widgets imported successfully.',
        	'redirect' => home_url()
        ));
    } else {
        wp_send_json_error('Failed to import theme mods.');
    }

    wp_die();
}

// Function to set theme mods
function demo_theme_importer($import_data) {
    if (is_array($import_data)) {
        foreach ($import_data as $mod_name => $mod_value) {
            set_theme_mod($mod_name, $mod_value);
        }
        return true;
    } else {
        return false;
    }
}

// Function to create demo menu
function create_demo_menu() {

    // Page import process
    $pages_to_create = array(
        array(
            'title'    => 'Home',
            'slug'     => 'home',
            'template' => 'page-template/home-template.php',
        ),
        array(
            'title'    => 'About Us',
            'slug'     => 'about-us',
            'template' => '',
        ),
        array(
            'title'    => 'Features',
            'slug'     => 'features',
            'template' => '',
        ),
        array(
            'title'    => 'Blog',
            'slug'     => 'blog',
            'template' => '',
        ),
        array(
            'title'    => 'Pages',
            'slug'     => 'pages',
            'template' => '',
        ),
        array(
            'title'    => 'Contact Us',
            'slug'     => 'contact-us',
            'template' => '',
        ),
    );

    // Loop through each page data to create pages
    foreach ($pages_to_create as $page_data) {
        $page_check = get_page_by_title($page_data['title']);
        
        // Check if the page doesn't exist already
        if (!$page_check) {
            $page = array(
                'post_type'    => 'page',
                'post_title'   => $page_data['title'],
                'post_status'  => 'publish',
                'post_author'  => 1,
                'post_slug'    => $page_data['slug'],
            );
            
            // Insert the page and get the inserted page ID
            $page_id = wp_insert_post($page);
            
            // Set the page template
            if ($page_id) {
                add_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
        }
    }

    // Set 'Home' as the front page
    $home_page = get_page_by_title('Home');
    if ($home_page) {
        update_option('page_on_front', $home_page->ID);
        update_option('show_on_front', 'page');
    }

    // Set 'Blog' as the posts page
    $blog_page = get_page_by_title('Blog');
    if ($blog_page) {
        update_option('page_for_posts', $blog_page->ID);
    }
    // ------- Create Main Menu --------
    $menuname =  'Primary Menu';
    $bpmenulocation = 'primary';
    $menu_exists = wp_get_nav_menu_object($menuname);
    
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menuname);
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Home','digital-books'),
            'menu-item-classes' => 'home',
            'menu-item-url' => home_url( '/' ),
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('About Us','digital-books'),
            'menu-item-classes' => 'about-us',
            'menu-item-url' => home_url( '/index.php/about-us/' ),
            'menu-item-status' => 'publish',
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Features','digital-books'),
            'menu-item-classes' => 'features',
            'menu-item-url' => home_url( '/index.php/features/' ),
            'menu-item-status' => 'publish',
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Blog','digital-books'),
            'menu-item-classes' => 'blog',
            'menu-item-url' => home_url( '/index.php/blog/' ),
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Page','digital-books'),
            'menu-item-classes' => 'page',
            'menu-item-url' => home_url( '/index.php/page/' ),
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Contact Us','digital-books'),
            'menu-item-classes' => 'contact-us',
            'menu-item-url' => home_url( '/' ),
            'menu-item-status' => 'publish'
        ));

        // Assign the menu to the location
        if (!has_nav_menu($bpmenulocation)) {
            $locations = get_theme_mod('nav_menu_locations');
            $locations[$bpmenulocation] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }
    
    //Top Bar
    set_theme_mod( 'digital_books_social_on_of_setting', 1 );
    set_theme_mod( 'digital_books_facebook_icon', 'fab fa-facebook-f' );
    set_theme_mod( 'digital_books_facebook_url', 'www.facebook.com' );
    set_theme_mod( 'digital_books_twitter_icon', 'fab fa-twitter' );
    set_theme_mod( 'digital_books_twitter_url', 'www.twitter.com' );
    set_theme_mod( 'digital_books_intagram_icon', 'fab fa-instagram' );
    set_theme_mod( 'digital_books_intagram_url', 'www.instagram.com' );
    set_theme_mod( 'digital_books_linkedin_icon', 'fab fa-linkedin-in' );
    set_theme_mod( 'digital_books_linkedin_url', 'www.linkedin.com' );
    set_theme_mod( 'digital_books_pintrest_icon', 'fab fa-pinterest-p' );
    set_theme_mod( 'digital_books_pintrest_url', 'www.pinterest.com' );

    //Slider
    set_theme_mod( 'digital_books_top_slider_section_setting', true );

    //$tab_title = array('','Exceptional Kindergarten Learning Experience','Excellence in Kindergarten Education');
    for($i=1;$i<=3;$i++){
        $title = 'Lorem ipsum dolor amet';
        $content = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s.';
            // Create post object
        $my_post = array(
         	'post_title'    => wp_strip_all_tags( $title ),
         	'post_content'  => $content,
         	'post_status'   => 'publish',
         	'post_type'     => 'page',
        );

         // Insert the post into the database
         $post_id = wp_insert_post( $my_post );

         if ($post_id) {
	        // Set the theme mod for the slider page
	        set_theme_mod('digital_books_top_slider_page' . $i, $post_id);

	         $image_url = get_template_directory_uri().'/assets/img/slider.png';

			$image_id = media_sideload_image($image_url, $post_id, null, 'id');

		        if (!is_wp_error($image_id)) {
		            // Set the downloaded image as the post's featured image
		            set_post_thumbnail($post_id, $image_id);
		        }
      	}
    }

    //About Us
    set_theme_mod( 'digital_books_product_section_setting', 1 );
    set_theme_mod( 'digital_books_home_product_number1', '80k' );
    set_theme_mod( 'digital_books_home_product_text1', 'Active Readers' );
    set_theme_mod( 'digital_books_home_product_number2', '+3k' );
    set_theme_mod( 'digital_books_home_product_text2', 'Total Pages' );
    set_theme_mod( 'digital_books_home_product_number3', '283' );
    set_theme_mod( 'digital_books_home_product_text3', 'Cup of Coffee' );
    set_theme_mod( 'digital_books_home_product_number4', '14k' );
    set_theme_mod( 'digital_books_home_product_text4', 'Facebook Fans' );

    if ( class_exists( 'WooCommerce' ) ) {
	    $product_category= array(
			'Best Seller' => array(
				'Lorem Ipsum Dolor Amet',
			),
		);
		foreach ( $product_category as $product_cats => $products_name ) {

			// Insert porduct cats Start
			$content = 'This is sample product category';
			$parent_category = wp_insert_term(
				$product_cats, // the term
				 'product_cat', // the taxonomy
				array(
					'description'=> $content,
					'slug' => str_replace( ' ', '-', $product_cats)
			) );

			// -------------- create subcategory END -----------------
			// create Product START
			foreach ( $products_name as $key => $product_title ) {
				$content = 'Lorem Ipsum has been the industrys standard dummy text ever since the 1500 when an unknown printer took a galley of type and scrambled it to make a type specimen book when an unknown printer took a galley of type and scrambled it to make a type specimen book.';
				// Create post object
				$my_post = array(
					'post_title'    => wp_strip_all_tags( $product_title ),
					'post_content'  => $content,
					'post_status'   => 'publish',
					'post_type'     => 'product',
					'post_category' => [$parent_category['term_id']]
				);
				// Insert the post into the database
				$post_id    = wp_insert_post($my_post);
				wp_set_object_terms( $post_id, str_replace( ' ', '-', $product_cats), 'product_cat', true );

				update_post_meta( $post_id, '_regular_price', "$25.00" );
				update_post_meta( $post_id, '_sale_price', "$20.00" );
				
				// Now replace meta w/ new updated value array
				$image_url = get_template_directory_uri().'/assets/img/' . str_replace(' ', '-', strtolower($product_title)).'.png';
				//  $image_url = get_template_directory_uri().'/assets/images/product/'.$product_cats.'/'.$product_title.'.png';
				$image_name  = $product_title.'.png';
				$upload_dir = wp_upload_dir();
				// Set upload folder
				$image_data = file_get_contents(esc_url($image_url));
				// Get image data
				$unique_file_name = wp_unique_filename($upload_dir['path'], $image_name);
				// Generate unique name
				$filename = basename($unique_file_name);
				// Create image file name
				// Check folder permission and define file location
				if (wp_mkdir_p($upload_dir['path'])) {
					$file = $upload_dir['path'].'/'.$filename;
				}
				// Create the image  file on the server
				file_put_contents($file, $image_data);
				// Check image file type
				$wp_filetype = wp_check_filetype($filename, null);
				// Set attachment data
				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title'     => sanitize_file_name($filename),
					'post_type'      => 'product',
					'post_status'    => 'inherit',
				);
				// Create the attachment
				$attach_id = wp_insert_attachment($attachment, $file, $post_id);
				// Include image.php
				require_once (ABSPATH.'wp-admin/includes/image.php');
				// Define attachment metadata
				$attach_data = wp_generate_attachment_metadata($attach_id, $file);
				// Assign metadata to attachment
				wp_update_attachment_metadata($attach_id, $attach_data);
				// And finally assign featured image to post
				set_post_thumbnail($post_id, $attach_id);
				// Create product END
				wp_update_post($post_id);
				
			}
		}
	}
    set_theme_mod( 'digital_books_home_product', 'best-seller' );
}
// Enqueue necessary scripts
add_action('admin_enqueue_scripts', 'demo_importer_enqueue_scripts');

function demo_importer_enqueue_scripts() {
    wp_enqueue_script(
        'demo-theme-importer',
        get_template_directory_uri() . '/assets/js/theme-importer.js', // Path to your JS file
        array('jquery'),
        null,
        true
    );

    wp_enqueue_style('demo-importer-style', get_template_directory_uri() . '/assets/css/importer.css', array(), '');

    // Localize script to pass AJAX URL to JS
    wp_localize_script(
        'demo-theme-importer',
        'demoImporter',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('theme_importer_nonce')
        )
    );
}
