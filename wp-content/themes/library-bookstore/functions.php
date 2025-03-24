<?php
/**
 * Library Bookstore functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Library Bookstore
 */

if ( ! defined( 'DIGITAL_BOOKS_URL' ) ) {
    define( 'DIGITAL_BOOKS_URL', esc_url( 'https://www.themagnifico.net/products/library-wordpress-theme', 'library-bookstore') );
}
if ( ! defined( 'DIGITAL_BOOKS_TEXT' ) ) {
    define( 'DIGITAL_BOOKS_TEXT', __( 'Library Bookstore Pro','library-bookstore' ));
}
if ( ! defined( 'DIGITAL_BOOKS_CONTACT_SUPPORT' ) ) {
define('DIGITAL_BOOKS_CONTACT_SUPPORT',__('https://wordpress.org/support/theme/library-bookstore','library-bookstore'));
}
if ( ! defined( 'DIGITAL_BOOKS_REVIEW' ) ) {
define('DIGITAL_BOOKS_REVIEW',__('https://wordpress.org/support/theme/library-bookstore/reviews/#new-post','library-bookstore'));
}
if ( ! defined( 'DIGITAL_BOOKS_LIVE_DEMO' ) ) {
define('DIGITAL_BOOKS_LIVE_DEMO',__('https://demo.themagnifico.net/library-bookstore/','library-bookstore'));
}
if ( ! defined( 'DIGITAL_BOOKS_GET_PREMIUM_PRO' ) ) {
define('DIGITAL_BOOKS_GET_PREMIUM_PRO',__('https://www.themagnifico.net/products/library-wordpress-theme','library-bookstore'));
}
if ( ! defined( 'DIGITAL_BOOKS_PRO_DOC' ) ) {
define('DIGITAL_BOOKS_PRO_DOC',__('https://demo.themagnifico.net/eard/wathiqa/library-bookstore-doc/','library-bookstore'));
}
if ( ! defined( 'DIGITAL_BOOKS_BUY_TEXT' ) ) {
    define( 'DIGITAL_BOOKS_BUY_TEXT', __( 'Buy Library Bookstore Pro','library-bookstore' ));
}
if ( ! defined( 'DIGITAL_BOOKS_FREE_DOC' ) ) {
define('DIGITAL_BOOKS_FREE_DOC',__('https://demo.themagnifico.net/eard/wathiqa/library-bookstore-free-doc/','library-bookstore'));
}

function library_bookstore_enqueue_styles() {
    wp_enqueue_style( 'flatly-css', esc_url(get_template_directory_uri()) . '/assets/css/flatly.css');
    $parentcss = 'digital-books-style';
    $theme = wp_get_theme(); wp_enqueue_style( $parentcss, get_template_directory_uri() . '/style.css', array(), $theme->parent()->get('Version'));
    wp_enqueue_style( 'library-bookstore-style', get_stylesheet_uri(), array( $parentcss ), $theme->get('Version'));

    require get_theme_file_path( '/custom-option.php' );
    wp_add_inline_style( 'library-bookstore-style',$digital_books_theme_css );
    require get_parent_theme_file_path( '/custom-option.php' );
    wp_add_inline_style( 'digital-books-basic-style',$digital_books_theme_css );

    wp_enqueue_script( 'comment-reply', '/wp-includes/js/comment-reply.min.js', array(), false, true );  

    wp_enqueue_script('library-bookstore-custom-js',get_theme_file_uri() . '/assets/js/custom-script.js', array('jquery'), '', true );
}
add_action( 'wp_enqueue_scripts', 'library_bookstore_enqueue_styles' );
function library_bookstore_admin_scripts() {
    // demo CSS
    wp_enqueue_style( 'library-bookstore-demo-css', get_theme_file_uri( 'assets/css/demo.css' ) );
}
add_action( 'admin_enqueue_scripts', 'library_bookstore_admin_scripts' );

function library_bookstore_customize_register($wp_customize){

     // Pro Version
    class Library_Bookstore_Customize_Pro_Version extends WP_Customize_Control {
        public $type = 'pro_options';

        public function render_content() {
            echo '<span>For More <strong>'. esc_html( $this->label ) .'</strong>?</span>';
            echo '<a href="'. esc_url($this->description) .'" target="_blank">';
                echo '<span class="dashicons dashicons-info"></span>';
                echo '<strong> '. esc_html( DIGITAL_BOOKS_BUY_TEXT,'library-bookstore' ) .'<strong></a>';
            echo '</a>';
        }
    }

    //Latest Product
    $wp_customize->add_section('library_bookstore_latest_product',array(
        'title' => esc_html__('Latest Product','library-bookstore'),
        'description' => esc_html__('Here you have to select product category which will display perticular latest product in the home page.','library-bookstore'),
    ));

    $wp_customize->add_setting('library_bookstore_latest_product_title', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('library_bookstore_latest_product_title', array(
        'label' => __('Section Title', 'library-bookstore'),
        'section' => 'library_bookstore_latest_product',
        'priority' => 1,
        'type' => 'text',
    ));
    $wp_customize->add_setting('library_bookstore_latest_product_sub_title', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('library_bookstore_latest_product_sub_title', array(
        'label' => __('Section Sub Title', 'library-bookstore'),
        'section' => 'library_bookstore_latest_product',
        'priority' => 2,
        'type' => 'text',
    ));
    $wp_customize->add_setting('library_bookstore_latest_number', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('library_bookstore_latest_number', array(
        'label' => __('Product Count', 'library-bookstore'),
        'section' => 'library_bookstore_latest_product',
        'priority' => 2,
        'type' => 'number',
    ));

    $args = array(
       'type'                     => 'product',
        'child_of'                 => 0,
        'parent'                   => '',
        'orderby'                  => 'term_group',
        'order'                    => 'ASC',
        'hide_empty'               => false,
        'hierarchical'             => 1,
        'number'                   => '',
        'taxonomy'                 => 'product_cat',
        'pad_counts'               => false
    );
    $categories = get_categories( $args );
    $cats = array();
    $i = 0;
    foreach($categories as $category){
        if($i==0){
            $default = $category->slug;
            $i++;
        } 
        $cats[$category->slug] = $category->name;
    }
    $wp_customize->add_setting('library_bookstore_latest_product',array(
        'sanitize_callback' => 'digital_books_sanitize_select',
    ));
    $wp_customize->add_control('library_bookstore_latest_product',array(
        'type'    => 'select',
        'choices' => $cats,
        'label' => __('Select Product Category','library-bookstore'),
        'section' => 'library_bookstore_latest_product',
    ));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_feature_product_setting', array(
        'sanitize_callback' => 'Digital_Books_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Library_Bookstore_Customize_Pro_Version ( $wp_customize,'pro_version_feature_product_setting', array(
        'section'     => 'library_bookstore_latest_product',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'library-bookstore' ),
        'description' => esc_url( DIGITAL_BOOKS_URL ),
        'priority'    => 100
    )));

}
add_action('customize_register', 'library_bookstore_customize_register');

if ( ! function_exists( 'library_bookstore_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function library_bookstore_setup() {

        add_theme_support( 'responsive-embeds' );

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

        add_image_size('library-bookstore-featured-header-image', 2000, 660, true);

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
            'default-color' => '',
            'default-image' => '',
        ) ) );

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

        add_theme_support( 'align-wide' );

        add_theme_support( 'wp-block-styles' );
    }
endif;
add_action( 'after_setup_theme', 'library_bookstore_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function library_bookstore_widgets_init() {
        register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'library-bookstore' ),
        'id'            => 'sidebar',
        'description'   => esc_html__( 'Add widgets here.', 'library-bookstore' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ) );
}
add_action( 'widgets_init', 'library_bookstore_widgets_init' );

function library_bookstore_remove_my_action() {
    remove_action( 'admin_menu','library_bookstore_themepage' );
    remove_action( 'admin_menu','demo_importer_admin_page' );
    remove_action( 'admin_notices','library_bookstore_deprecated_hook_admin_notice' );
}
add_action( 'init', 'library_bookstore_remove_my_action');


// Demo Content Code

// Ensure WordPress is loaded
if (!defined('ABSPATH')) {
    exit;
}

// Add admin menu page to trigger theme import
add_action('admin_menu', 'library_bookstore_demo_importer_admin_page');

function library_bookstore_demo_importer_admin_page() {
    add_theme_page(
        'Demo Theme Importer',     // Page title
        'Theme Importer',          // Menu title
        'manage_options',          // Capability
        'theme-importer',          // Menu slug
        'library_bookstore_demo_importer_page',      // Callback function
    );
}

// Display the page content with the button
function library_bookstore_demo_importer_page() {
    ?>
    <div class="wrap-main-box">
        <div class="main-box">
            <h2><?php echo esc_html('Welcome to Library Bookstore','library-bookstore'); ?></h2>
            <h3><?php echo esc_html('Create your website in just one click','library-bookstore'); ?></h3>
            <hr>
            <p><?php echo esc_html('The "Begin Installation" helps you quickly set up your website by importing sample content that mirrors the demo version of the theme. This tool provides you with a ready-made layout and structure, so you can easily see how your site will look and start customizing it right away. It\'s a straightforward way to get your site up and running with minimal effort.','library-bookstore'); ?></p>
            <p><?php echo esc_html('Click the button below to install the demo content.','library-bookstore'); ?></p>
            <hr>
            <button id="import-theme-mods" class="button button-primary"><?php echo esc_html('Begin Installation','library-bookstore'); ?></button>
            <div id="import-response"></div>
        </div>
    </div>
    <?php
}

// Add the AJAX action to trigger theme mods import
add_action('wp_ajax_import_theme_mods', 'library_bookstore_demo_importer_ajax_handler');

// Handle the AJAX request
function library_bookstore_demo_importer_ajax_handler() {
    // Sample data to import
    $theme_mods_data = array(
        'header_textcolor' => '000000',  // Example: change header text color
        'background_color' => 'ffffff',  // Example: change background color
        'custom_logo'      => 123,       // Example: set a custom logo by attachment ID
        'footer_text'      => 'Custom Footer Text', // Example: custom footer text
    );

    // Call the function to import theme mods
    if (library_bookstore_demo_theme_importer($theme_mods_data)) {
        // After importing theme mods, create the menu
        library_bookstore_create_demo_menu();
        wp_send_json_success(array(
            'msg' => 'Theme mods imported successfully.',
            'redirect' => home_url()
        ));
    } else {
        wp_send_json_error('Failed to import theme mods.');
    }

    wp_die();
}

// Function to set theme mods
function library_bookstore_demo_theme_importer($import_data) {
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
function library_bookstore_create_demo_menu() {

    // Page import process
    $pages_to_create = array(
        array(
            'title'    => 'Home',
            'slug'     => 'home',
            'template' => 'page-template/home-template.php',
        ),
        array(
            'title'    => 'Events',
            'slug'     => 'events',
            'template' => '',
        ),
        array(
            'title'    => 'Causes',
            'slug'     => 'causes',
            'template' => '',
        ),
        array(
            'title'    => 'Projects',
            'slug'     => 'projects',
            'template' => '',
        ),
        array(
            'title'    => 'News',
            'slug'     => 'News',
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
            'menu-item-title' =>  __('Home','library-bookstore'),
            'menu-item-classes' => 'home',
            'menu-item-url' => home_url( '/' ),
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Events','library-bookstore'),
            'menu-item-classes' => 'events',
            'menu-item-url' => home_url( '/' ),
            'menu-item-status' => 'publish',
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Causes','library-bookstore'),
            'menu-item-classes' => 'causes',
            'menu-item-url' => home_url( '/' ),
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Projects','library-bookstore'),
            'menu-item-classes' => 'projects',
            'menu-item-url' => home_url( '/' ),
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('News','library-bookstore'),
            'menu-item-classes' => 'news',
            'menu-item-url' => home_url( '/' ),
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  __('Contact Us','library-bookstore'),
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

             $image_url = get_stylesheet_directory_uri().'/assets/img/slider-bg.png';

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
                update_post_meta( $post_id, '_price', "$20.00" );
                
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

    //Our Services
    set_theme_mod( 'library_bookstore_latest_product_section_setting', true );
    set_theme_mod( 'library_bookstore_latest_product_title', 'Book Store' );
    set_theme_mod( 'library_bookstore_latest_product_sub_title', 'Lorem Ipsum has been the industrys standard dummy text ever since the 1500' );
    set_theme_mod( 'library_bookstore_latest_number', '5' );

    if ( class_exists( 'WooCommerce' ) ) {
        $product_category= array(
            'Latest Product' => array(
                'Lorem Ipsum 1',
                'Lorem Ipsum 2',
                'Lorem Ipsum 3',
                'Lorem Ipsum 4',
                'Lorem Ipsum 5',
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
                update_post_meta( $post_id, '_price', "$20.00" );
                
                // Now replace meta w/ new updated value array
                $image_url = get_stylesheet_directory_uri().'/assets/img/' . str_replace(' ', '-', strtolower($product_title)).'.png';
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
    set_theme_mod( 'library_bookstore_latest_product', 'latest-product' );
}
// Enqueue necessary scripts
add_action('admin_enqueue_scripts', 'library_bookstore_demo_importer_enqueue_scripts');

function library_bookstore_demo_importer_enqueue_scripts() {
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
