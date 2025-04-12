<?php defined( 'ABSPATH' ) || exit;

function astra_child_enqueue_styles() {
    wp_enqueue_style('astra-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('astra-child-style', get_stylesheet_uri(), array('astra-style'), wp_get_theme()->get('Version'));
    wp_enqueue_script('astra-child-script', get_stylesheet_directory_uri() . '/assets/js/js.js', array('jquery'), wp_get_theme()->get('Version'), true);
    wp_localize_script('astra-child-script', 'admin_url', array(
        'ajax_url'   =>  admin_url('admin-ajax.php'),
        'nonce'  => wp_create_nonce( 'my-ajax-nonce' )
    ));
}

add_action('wp_enqueue_scripts', 'astra_child_enqueue_styles');

// Cargar el archivo functions-elementor.php si existe
if ( file_exists( get_stylesheet_directory() . '/functions-elementor.php' ) ) :
    require_once get_stylesheet_directory() . '/functions-elementor.php';
endif;

// Cargar el archivo functions-woocommerce.php si existe
if ( file_exists( get_stylesheet_directory() . '/functions-woocommerce.php' ) ) :
    require_once get_stylesheet_directory() . '/functions-woocommerce.php';

endif;
require_once get_stylesheet_directory() . '/forms/register.php';

// Cargar el archivo formulario registro si existe
if ( file_exists( get_stylesheet_directory() . 'forms/register.php' ) ) :
    

endif;

// Cargar el archivo formulario registro si existe
if ( file_exists( get_stylesheet_directory() . 'emails/register.php' ) ) :
    require_once get_stylesheet_directory() . '/forms/register.php';

endif;


/* =====================================================
*   AGREGAR CMB2"
* ===================================================== */
if ( file_exists( dirname( __FILE__ ) . '/example-functions.php' ) ) :
require_once get_stylesheet_directory() . '/example-functions.php';
    require_once get_stylesheet_directory() . '/inc/custom-fields-product.php';
endif;





function enqueue_owl_carousel() {
    // Cargar el archivo CSS de Owl Carousel
    wp_enqueue_style('owl-carousel-css', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
    wp_enqueue_style('owl-theme-css', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css');
    
    // Cargar el archivo JS de Owl Carousel
    wp_enqueue_script('owl-carousel-js', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), '', true);
    
    // Añadir script para inicializar el carrusel
    wp_add_inline_script('owl-carousel-js', '
        jQuery(document).ready(function($) {
            $(".wiwu-carrusel-productos").owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 3000,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 4
                    }
                }
            });
        });
    ');
}
//add_action('wp_enqueue_scripts', 'enqueue_owl_carousel');



function mostrar_seccion_carrito_vacio() {
    get_template_part('/template_parts/cart-vacio');
    
}
add_action( 'woocommerce_cart_is_empty', 'mostrar_seccion_carrito_vacio' );
