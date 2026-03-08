<?php
/**
 * rediez functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package rediez
 */

// Подключение Carbon Fields
add_action( 'after_setup_theme', 'crb_load' );

function crb_load() {
    $autoload = __DIR__ . '/vendor/autoload.php';
    
    if ( !file_exists( $autoload ) ) {
        die( "Ошибка: Автозагрузчик не найден по пути: " . $autoload );
    }
    
    require_once( $autoload );
    \Carbon_Fields\Carbon_Fields::boot();
}

// Подключение настроек
add_action( 'carbon_fields_register_fields', 'register_carbon_fields' );

function register_carbon_fields() {
    $options_path = __DIR__ . '/carbon-fields-options/';

    if ( file_exists( $options_path . 'theme-options.php' ) ) {
        require_once( $options_path . 'theme-options.php' );
    }
    if ( file_exists( $options_path . 'post-meta.php' ) ) {
        require_once( $options_path . 'post-meta.php' );
    }
}

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function rediez_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on rediez, use a find and replace
		* to change 'rediez' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'rediez', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'header_menu' => esc_html__( 'Primary', 'rediez' ),
			'footer_menu' => esc_html__( 'Footer', 'rediez' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'rediez_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'rediez_setup' );

// Register new post type:
$inc_files = array(
    'custom_post_type_musicians.php',
    'custom_post_type_events.php',
	'custom_post_type_poster.php',
);

foreach ( $inc_files as $file ) {
    require_once get_template_directory() . '/inc/' . $file;
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rediez_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'rediez_content_width', 640 );
}
add_action( 'after_setup_theme', 'rediez_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rediez_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'rediez' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'rediez' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'rediez_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function rediez_style() {
	wp_enqueue_style( 'rediez-fonts', get_template_directory_uri() . '/styles/font.css', array(), _S_VERSION );

	wp_enqueue_style( 'rediez-swiper-style', get_template_directory_uri('rediez-fonts') .'/libs/swiper/swiper-bundle.min.css');

	wp_enqueue_style( 'rediez-micromodal-style', get_template_directory_uri('rediez-fonts') .'/libs/micromodal/micromodal.css');

	wp_enqueue_style( 'rediez-bootstrap', get_template_directory_uri('rediez-fonts') .'/libs/bootstrap/css/bootstrap.min.css');

	wp_enqueue_style( 'rediez-style', get_stylesheet_uri(), array('rediez-fonts'), _S_VERSION );

	wp_enqueue_style( 'rediez-style-media', get_template_directory_uri('rediez-fonts') .'/styles/media.css');
}
add_action( 'wp_enqueue_scripts', 'rediez_style' );

function rediez_scripts() {

	wp_enqueue_script( 'rediez-swiper', get_template_directory_uri() . '/libs/swiper/swiper-bundle.min.js', array(), '', true);

	wp_enqueue_script( 'rediez-micromodal', get_template_directory_uri() . '/libs/micromodal/micromodal.min.js', array(), '', true);
    
    wp_enqueue_script( 'rediez-price-range', get_template_directory_uri() . '/js/price-range.js', array(), '', true );

    wp_enqueue_script( 'rediez-musicians-filters', get_template_directory_uri() . '/js/musicians-filters.js', array('rediez-price-range'), '', true );

	wp_localize_script('rediez-musicians-filters', 'rediez_filters', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'nonce'    => wp_create_nonce('musicians_filter_nonce'),
	]);

	wp_enqueue_script( 'rediez-events-filters',get_template_directory_uri() . '/js/events-filters.js', array('rediez-price-range'), '', true );

	wp_localize_script( 'rediez-events-filters', 'rediez_events_filters', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'events_filter_nonce' ),
	) );

    wp_enqueue_script( 'rediez-common', get_template_directory_uri() . '/js/common.js', array('jquery', 'rediez-micromodal'), '', true );
}

add_action( 'wp_enqueue_scripts', 'rediez_scripts' );

// Настройки ролей пользователей
require_once get_template_directory() . '/inc/user-roles.php';

// Подключение доработанного меню с помощью Walker
require_once __DIR__ . '/inc/class-bem-menu-walker.php';

// Подключение хлебных крошек
require get_template_directory() . '/inc/breadcrumbs.php';

// Подключение фильтров музыкантов
require_once get_template_directory() . '/inc/ajax-musicians-filter.php';

// Подключение фильтров ивентов
require_once get_template_directory() . '/inc/ajax-events-filter.php';

// Подключение сортировки архива музыкантов
require get_template_directory() . '/inc/archive-filters.php';

// Подключение файла со вспомогательными функциями
require get_template_directory() . '/inc/helpers.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// Передаём URL профиля в JavaScript
function rediez_um_profile_url() {
    ?>
    <script type="text/javascript">
        var umProfileUrl = '<?php echo esc_url( um_get_core_page('user') ); ?>';
        var umAccountUrl = '<?php echo esc_url( um_get_core_page('account') ); ?>';
    </script>
    <?php
}
add_action('wp_footer', 'rediez_um_profile_url');

// Подключение кастомных настроек админ-бара
require_once get_template_directory() . '/inc/admin-bar-bottom.php';