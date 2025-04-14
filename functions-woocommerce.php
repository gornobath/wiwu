<?php defined( 'ABSPATH' ) || exit;

function wiwu_tamano_imagenes() {
    add_image_size( 'wiwu-miniatura-producto-carrito', 90, 90, true ); // 'true' significa recorte rígido
    add_image_size( 'wiwu-miniatura-producto', 270, 342, true ); // 'true' significa recorte rígido
}
add_action( 'after_setup_theme', 'wiwu_tamano_imagenes' );


remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action('woocommerce_before_single_product', 'woocommerce_template_loop_product_thumbnail', 10);

/* =====================================================
*   FUNCION PARA CARGAR 2 IMAGENES EN LAS IMAGENES DE LOS 
*   PRODUCTOS.
*   La idea es que cargue la imagen principal y una 
*   secundaria(primera de la galeris de imagenes del producto)
*  ===================================================== */

function wiwu_custom_hover_product_images(){
    $idsGaleria = '';
    $primeraImagenGaleria = '';
    $imagenPrincipal = '';
    $product_title = '';
    
    $imagenPrincipal = get_the_post_thumbnail_url(get_the_ID(), 'wiwu-miniatura-producto');

    // Obtener la primera imagen de la galería (si existe)
    global $product;
    $idsGaleria = $product->get_gallery_image_ids(); // Obtener las imágenes de la galería
    //$primeraImagenGaleria = !empty($idsGaleria) ? wp_get_attachment_url($idsGaleria[0]) : $imagenPrincipal; // Si hay imágenes en la galería, obtenemos la primera
    $primeraImagenGaleria = !empty($idsGaleria) ? wp_get_attachment_image_url($idsGaleria[0], 'wiwu-miniatura-producto') : $imagenPrincipal; // Si hay imágenes en la galería, obtenemos la primera
    $product_title = get_the_title();
    // Mostrar ambas imágenes con clases para el hover

    return '<div class="wiwu-product-images-wrapper">
            <img src="'. esc_url($imagenPrincipal).'" class="wiwu-main-image" alt="'.esc_attr($product_title).'" />
            <img src="'. esc_url($primeraImagenGaleria).'" class="wiwu-hover-image" alt="'.esc_attr($product_title).'" />
        </div>';
   /*  echo '<div class="wiwu-product-images-wrapper">
        <img src="'. esc_url($imagenPrincipal).'" class="wiwu-main-image" alt="'.esc_attr($product_title).'" />
    </div>'; */
}

function wiwu_mostrarWooImagenesProductos(){
    echo wiwu_custom_hover_product_images();
}

add_action('woocommerce_before_shop_loop_item_title', 'wiwu_mostrarWooImagenesProductos', 20);
add_action('woocommerce_before_single_product', 'wiwu_mostrarWooImagenesProductos', 20);


/* ===============================================================
*  FUNCION QUE MUESTRA EL CARRITO DE COMPRA
*  ===============================================================*/
add_shortcode( 'wiwu-cart', 'wiwu_mostrar_cart');
function wiwu_mostrar_cart(){
    $html = '';
    $itemTextoCart = '';
    
    // Obtener el número de productos en el carrito
    $cart_item_count = count(WC()->cart->get_cart());
    
    if ( $cart_item_count > 0 ) : 
        // Obtener el subtotal
       
        $subtotal = WC()->cart->get_cart_subtotal();
        
        // Generar el HTML para mostrar el carrito
        $html .= '<aside class="wiwu-cart">';
            $html .= '<div class="wiwu-cart-header">';
                $html .= '<span class="wiwu-cart-header-titulo">' . esc_html__('Carrito de compras', 'tu_texto_dominio') . '</span>';
                $html .= '<span class="wiwu-cart-header-btn-cerrar">x</span>';
                
                // Determinar si se está mostrando "item" o "items" según la cantidad
                $itemTextoCart = $cart_item_count == 1 ? esc_html__('item', 'tu_texto_dominio') : esc_html__('items', 'tu_texto_dominio');
                $html .= '<span class="wiwu-cart-header-texto-items">' . esc_html($itemTextoCart) . ' ' . esc_html($cart_item_count) . '</span>';
            $html .= '</div>';

            // Lista de productos en el carrito
            $html .= '<ul class="wiwu-cart-products">';
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                    $_product = $cart_item['data'];
                    
                    // Obtener los datos del producto y escapar la información
                    $product_name = esc_html($_product->get_name());
                    $product_price = esc_html($_product->get_price());
                    $product_qty = esc_html($cart_item['quantity']);
                    
                    // Obtener la imagen con tamaño personalizado (270x342px)
                    $product_thumbnail = $_product->get_image( 'wiwu-miniatura-producto-carrito', array( 90, 90 ) );
                    
                    // Generar el HTML para cada producto
                    $html .= '<li class="wiwu-cart-products-box">';
                        $html .= '<div class="wiwu-cart-products-box-thumbnail">' . $product_thumbnail . '</div>';
                        $html .= '<div class="wiwu-cart-products-box-info">';
                            $html .= '<span class="wiwu-cart-products-box-info-title">' . $product_name . '</span>';
                            $html .= '<span class="wiwu-cart-products-box-info-price">$ ' . $product_price . '</span>';
                            $html .= '<span class="wiwu-cart-products-box-info-quantity">' . esc_html__('Cantidades: ', 'tu_texto_dominio') . $product_qty . '</span>';
                        $html .= '</div>';
                    $html .= '</li>';
                endforeach;
            $html .= '</ul>';

            // Mostrar el subtotal
            $html .= '<div class="wiwu-cart-subtotal-cont">';
                $html .= '<span class="wiwu-cart-subtotal">' . esc_html__('SUBTOTAL: ', 'tu_texto_dominio') . $subtotal . '</span>';
            $html .= '</div>';

            // Botón para ver el carrito
            $html .= '<div class="wiwu-cart-botonera">';
                $html .= '<a href="' . esc_url(wc_get_cart_url()) . '" class="wiwu-cart-botonera-btn">' . esc_html__('Ver carrito', 'tu_texto_dominio') . '</a>';
            $html .= '</div>';
        $html .= '</aside>';
    else :
        // Si el carrito está vacío
        $html .= '<aside class="wiwu-cart">';
            $html .= '<span class="wiwu-cart-products-box-info-quantity">' . esc_html__('Tu carrito está vacío.', 'tu_texto_dominio') . '</span>';
        $html .= '</aside>';
    endif;
    
    return $html;
}

/* ===============================================================
*  FUNCION QUE REORDENA CAMPOS DE LOS PRODUCTOS
*  ===============================================================*/
function reordenar_elementos_woocommerce() {
    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
    remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

    // Agregar la imagen primero
    add_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_thumbnail', 10);

    // Agregar el botón de añadir al carrito
    add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15);

    // Agregar el título del producto
    add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_title', 20);

    // Agregar el precio
    add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_price', 25);
}
add_action('woocommerce_before_shop_loop', 'reordenar_elementos_woocommerce');

/* ===============================================================
*  FUNCION QUE MUESTRA EL CARRUSEL DE PRODUCTOS
*  ===============================================================*/
function wiwu_mustrarCaruselProductos(){
       // Definir los atributos del shortcode (puedes ajustarlos según sea necesario)
       $atts = shortcode_atts(
        array(
            'limit' => 8,
            'columns' => 4,
            'rows' => 2,
        ),
        $atts,
        'mi_carrusel_productos'
    );

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $atts['limit'],
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'     => '_stock_status',
                'value'   => 'instock',  // Solo productos con stock
                'compare' => '=',
            ),
        ),
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'exclude-from-catalog',
                'operator' => 'NOT IN',  // Evita productos ocultos del catálogo
            ),
        ),
    );


    return  wiwu_mostrar_carrusel_productos($args);
    

   
}

/* ===============================================================
*  FUNCION QUE MUESTRA EL CARRUSEL DE LOS  PRODUCTOS RELACIONADOS
*  ===============================================================*/

add_shortcode( 'wiwu-carrusel-productos', 'wiwu_mustrarCaruselProductos' );

add_shortcode( 'wiwu-carrusel-productos-relacionados', 'wiwu_mostrarCaruselProductosRelacionados' );
function  wiwu_mostrarCaruselProductosRelacionados(){
    ?>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <?php 


$args = array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'orderby'        => 'rand', 
    'meta_query'     => array(
        array(
            'key'     => '_stock_status',
            'value'   => 'instock',  
            'compare' => '=',
        ),
    ),
    'tax_query'      => array(
        array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'exclude-from-catalog',
            'operator' => 'NOT IN',  // Evita productos ocultos del catálogo
        ),
    ),
);

$query = new WP_Query($args);

if ($query->have_posts()):
    $output = '<div class="wiwu-woo-carousel-products">';
        $output .= '<div class="products">';

            while ($query->have_posts()) :
                $query->the_post();
                global $product;

                $productoEnElCarrito = WC()->cart->find_product_in_cart(WC()->cart->generate_cart_id($product->get_id()));
                $styleIconoCarrito = (!empty($productoEnElCarrito)) ? 'shopping-bag-activo.svg' : 'shopping-bag.svg';

                $output .= '<div class="product">';
                $output .= '<a href="' . esc_url(get_the_permalink()) . '">
                                <div class="wiwu-carprod-cont-img">
                                    <img src="' . esc_url(get_stylesheet_directory_uri() . '/images/' . $styleIconoCarrito) . '" alt="" class="wiwu-shoppingbag"/>
                                    ' . wp_kses_post(wiwu_custom_hover_product_images()) . '
                                </div>
                            </a>';
                $output .= '<div class="add-to-cart">' . wiwu_mi_boton_personalizado($product->get_id()) . '</div>';
                $output .= '<h2 class="woocommerce-loop-product__title">' . get_the_title() . '</h2>';
                $output .= '<span class="price">' . $product->get_price_html() . '</span>';
                $output .= '</div>'; // Cierra el div del producto

            endwhile;

        $output .= '</div>'; // Cierra el div de productos
    $output .= '</div>'; // Cierra el div del carrusel

    wp_reset_postdata();

    return $output;
    else :
        return '<p>No hay productos relacionados disponibles.</p>';
    endif;
 

}
/* ===============================================================
*  FUNCION CAMBIA EL TEXTO DEL BOTON DEL CARRITO DE LOS PRODUCTOS
*  ===============================================================*/
function wiwu_mi_boton_personalizado($product_id) {
    $texto = '';
    $product = wc_get_product($product_id);

    // Verificar si el producto ya está en el carrito
    $cart = WC()->cart;
    $is_product_in_cart = false;

    foreach ($cart->get_cart() as $cart_item) {
        if ($cart_item['product_id'] == $product_id) {
            $is_product_in_cart = true;
            break;
        }
    }

    // Obtener la URL para añadir al carrito
    $add_to_cart_url = $product->add_to_cart_url();
    
    // Decidir si redirigir al carrito o a la página de pago
    if ($is_product_in_cart) {
        // Si el producto ya está en el carrito, redirigir a la página de pago
        $texto = 'Añadir al carrito';
        $add_to_cart_url = wc_get_checkout_url(); // Redirige al checkout
    } else {
        // Si el producto no está en el carrito, redirigir a la página del producto
        $texto = 'Seleccionar opciones';
        $add_to_cart_url = get_permalink($product_id); // Redirige a la página del producto
    }
    

    // Crear el botón HTML
    $add_to_cart_button = '<a href="' . esc_url($add_to_cart_url) . '" class="button add_to_cart_button">'.$texto.'</a>';

    return $add_to_cart_button;
}

/* ===============================================================
*  FUNCION QUE MUESTRA EL CARRUSEL DE PRODUCTOS
*  ===============================================================*/
function wiwu_mostrar_carrusel_productos($args){
    ?>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <?php 
     $query = new WP_Query($args);
    if ($query->have_posts()) {
        $output = '<div class="wiwu-woo-carousel-products">';
            $output .= '<div class="products">';
        
        while ($query->have_posts()) :
            $query->the_post();
            $styleIconoCarrito = '';
            global $product;
     
            $output .= '<div class="product">';
          
            $productoEnElCarrito = WC()->cart->find_product_in_cart( WC()->cart->generate_cart_id( $product->get_id() ) );
            $styleIconoCarrito = ( !empty($productoEnElCarrito) ) ? 'shopping-bag-activo.svg':'shopping-bag.svg'; 

                $output .= '<a href="' . esc_url(get_the_permalink()) . '">
                                <div class="wiwu-carprod-cont-img">
                                    <img src="'.esc_url(get_stylesheet_directory_uri() .'/images/'. $styleIconoCarrito).'" alt="" class="wiwu-shoppingbag"/>
                                    '.wp_kses_post(wiwu_custom_hover_product_images()).'
                                </div>
                            </a>';
                $output .= '<div class="add-to-cart">'.wiwu_mi_boton_personalizado($product->get_id()).'</div>';
                $output .= '<h2 class="woocommerce-loop-product__title">' . get_the_title() . '</h2>';
                $output .= '<span class="price">' . $product->get_price_html() . '</span>';
            $output .= '</div>'; 
        endwhile;

            $output .= '</div>'; 
        $output .= '</div>'; 

        wp_reset_postdata();

        return $output;
    } else {
        return '<p>No hay productos disponibles.</p>';
    }
}


/* ===============================================================
*  FUNCION MUESTRA EL ATRIBUTO COLOR EN FORMA DE COLOR, TENIENDO 
*  EN CUENTA QUE EL COLOR ES LA DESCRIPCION DEL PRODUCTO
*  ===============================================================*/

function wiwu_mostrar_atributo_color_en_producto() {
    $color = '';
    $colors = '';
    $description = '';
    $nombre = '';
    $primerElemento = true;
    $slug = '';
    $term = '';
    $tipoProducto = '';
    
    global $product;
    $tipoProducto = wc_get_product( $product->get_id() );
    // Obtener el valor del atributo "color"
    $color = $product->get_attribute('colores');
    if( $tipoProducto->get_type() == 'simple'):
        if ($color):
            // Dividir el valor del atributo en varios colores si es que tiene más de uno
            $colors = explode(', ', $color);
            echo '<div class="wiwu-single-product-color-cont">';
            foreach ($colors as $color_name) :
                // Obtener el objeto del término del atributo "color" (por su nombre)
                $term = get_term_by('name', $color_name, 'pa_colores');
                
                if ($term) :
                    // Obtener el slug y la descripción del término
                    $slug = $term->slug;
                    $nombre = $term->name;
                    $description = $term->description;
                    
                    //echo '<p><strong>Slug:</strong> ' . esc_html($slug) . '</p>';
                    if ($description) :
                        //echo '<div class="wiwu-single-product-color" style="background: '.esc_attr($description).'"></div>';
                        echo '<label class="wiwu-single-product-color-label">';
                        echo '<input type="radio" name="pa_colores" value="' . esc_attr($slug) . '" class="wiwu-single-product-color-radio" '.($primerElemento ? 'checked' : '').' /> ';
                            echo '<span class="wiwu-single-product-color" style="background-color: ' . esc_attr($term->description) . ';" data-color-name="'.esc_attr($nombre).'"></span>';
                        echo '</label>';
                        $primerElemento = false;
                    endif;
                endif;
            endforeach;
            echo '</div>';
        endif;
    endif;
}
add_action('woocommerce_before_add_to_cart_button', 'wiwu_mostrar_atributo_color_en_producto', 20);

/* ===============================================================
*  FUNCION MUESTRA EL COLOR SELECCIONADO EN EL CARRITO
*  ===============================================================*/
add_filter('woocommerce_add_cart_item_data', 'add_color_to_cart_item', 10, 3);
function add_color_to_cart_item($cart_item_data, $product_id, $variation_id) {
    if (isset($_POST['pa_colores'])) {
        $color = sanitize_text_field($_POST['pa_colores']);
        
        // Agregar el color seleccionado al artículo en el carrito
        $cart_item_data['color'] = $color;
    }
    return $cart_item_data;
}

/* ===============================================================
*  FUNCION MUESTRA EL COLOR SELECCIONADO EN EL CARRITO
*  ===============================================================*/
add_filter('woocommerce_get_item_data', 'wiwu_mostrar_color_en_carrito', 10, 2);

function wiwu_mostrar_color_en_carrito($item_data, $cart_item) {
    if (isset($cart_item['color'])) {
        $item_data[] = array(
            'key'     => __('Color', 'woocommerce'),
            'value'   => $cart_item['color'],
            'display' => $cart_item['color'],
        );
    }
    return $item_data;
}

/* ===============================================================
*  FUNCION MUESTRA EL COLOR EN LOS DETALLES DEL PEDIDO
*  ===============================================================*/
add_action('woocommerce_order_item_meta_end', 'wiwu_mostrar_atributo_color_en_pedido', 10, 3);

function wiwu_mostrar_atributo_color_en_pedido($item_id, $item, $order) {
    if ($color = $item->get_meta('color')) {
        echo '<p><strong>' . __('Color:', 'woocommerce') . '</strong> ' . esc_html($color) . '</p>';
    }
}

/* ===============================================================
*  FUNCION QUE REORGANIZA LOS ATRIBUTOS DE LAS VARIABLES. PRINERO 
*  APAREZCA EL COLOR Y LUEGO LAS MEDIDAS
*  ===============================================================*/
add_filter('woocommerce_product_get_attributes', 'wiwu_reorganizar_atributos_variaciones', 10, 2);
function wiwu_reorganizar_atributos_variaciones($attributes, $product) {
    if ($product->is_type('variable')) {
        $ordered_attributes = array();
        
        // Buscar y colocar primero el atributo de colores
        if (isset($attributes['pa_colores'])) {
            $ordered_attributes['pa_colores'] = $attributes['pa_colores'];
            unset($attributes['pa_colores']);
        }
        
        // Buscar y colocar segundo el atributo de medidas (ajusta el slug según tu caso)
        if (isset($attributes['pa_medidas'])) {
            $ordered_attributes['pa_medidas'] = $attributes['pa_medidas'];
            unset($attributes['pa_medidas']);
        }
        
        // Añadir el resto de atributos
        foreach ($attributes as $key => $attribute) {
            $ordered_attributes[$key] = $attribute;
        }
        
        return $ordered_attributes;
    }
    
    return $attributes;
}


/* ===============================================================
*  FUNCION CONVIERTE EL SELECTE DEL ATRIBITO COLOR POR UN RADIO
*  ===============================================================*/
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'wiwu_convertir_select_a_radio_del_atributo_color', 10, 2);
function wiwu_convertir_select_a_radio_del_atributo_color($html, $args) {
    if ($args['attribute'] == 'pa_colores') :

        $original_html = str_replace(
            '<select', 
            '<select style="display:none !important"', 
            $html
        );
        
        $options   = $args['options'];
        $product   = $args['product'];
        $attribute = $args['attribute'];
        $name      = 'attribute_' . sanitize_title($attribute);

        if (empty($options)) {
            return $html;
        }
        
        $radio_html = '<div class="wiwu-single-product-color-cont">';
        
        foreach ($options as $option) {
            $term = get_term_by('slug', $option, $attribute);
            $color_code = $term ? $term->description : '#fff';
            $id = sanitize_title($option);
            $checked = isset($_REQUEST[$name]) && $_REQUEST[$name] == $option ? 'checked' : '';
        
            $radio_html .= '<label class="wiwu-single-product-color-label">';
            $radio_html .= '<input type="radio" name="'.esc_attr($name).'" value="' . esc_attr($option) . '" class="wiwu-single-product-color-radio" id="'.esc_attr($id).'" '.esc_attr($checked).'/> ';
            $radio_html .= '<span class="wiwu-single-product-color" style="background-color: ' . esc_attr($color_code) . ';" data-color-name="'.esc_html($option).'"></span>';
            $radio_html .= '</label>';
        }
        
        $radio_html .= '</div>';
        
        // JavaScript para sincronizar radios con select (opcional, pero útil para compatibilidad)
        add_action('wp_footer', function() use ($name) {
            ?>
            <script>
            jQuery(document).ready(function($) {
                // No es necesario sincronizar manualmente si usas el mismo 'name'
                // Pero lo dejamos por si hay otros scripts que dependen del select
                $('input[name="<?php echo esc_js($name); ?>"]').on('change', function() {
                    $('select[name="<?php echo esc_js($name); ?>"]').val($(this).val()).trigger('change');
                });
            });
            </script>
            <?php
        }, 100);
        
        return $original_html . $radio_html;
    endif;
    
    return $html;
}

add_shortcode( 'wiwu-productos-categoria', 'wiwu_mostrar_productos_categoria' );
function wiwu_mostrar_productos_categoria($atts) {
    // Atributos del shortcode con valores por defecto
    $atts = shortcode_atts(
        array(
            'categoria' => '',
            'limit' => 4
        ), 
        $atts, 
        'wiwu-productos-categoria'
    );
    
    // Si no se especifica categoría, mostrar mensaje
    if(empty($atts['categoria'])) {
        return '<p>Por favor, especifica una categoría de productos.</p>';
    }
        
    // ID único para este carrusel
    $carousel_id = 'wiwu-carousel-' . uniqid();
    
    $args = wiwu_obtener_productos_por_categoria($atts['categoria'],$atts['limit']);
    
    $query = new WP_Query($args);
    
    if (function_exists('wiwu_mostrar_productos')) :
        return wiwu_mostrar_productos(
            $query,
            $carousel_id,
            $atts['limit'], 
            $atts['categoria'] 
        );
    endif; 
    
}

// Función AJAX para cargar más productos
// add_action('wp_ajax_wiwu_load_more_products_categoria', 'wiwu_load_more_products_categoria');
// add_action('wp_ajax_nopriv_wiwu_load_more_products_categoria', 'wiwu_load_more_products_categoria');
function wiwu_load_more_products_categoria() {
    //echo 'Entre desde php con ajax';
    $category = sanitize_text_field($_POST['category']);
    $limit = intval($_POST['limit']);
    $offset = intval($_POST['offset']);
    
    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => $limit,
        'offset'         => $offset,
        'orderby'        => 'rand',
        'meta_query'     => array(
            array(
                'key'     => '_stock_status',
                'value'   => 'instock',
                'compare' => '=',
            ),
        ),
        'tax_query'      => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'exclude-from-catalog',
                'operator' => 'NOT IN',
            ),
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        ),
    );
    
    $query = new WP_Query($args);
    
    $output = '';
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
           
            $productoEnElCarrito = WC()->cart->find_product_in_cart(WC()->cart->generate_cart_id($product->get_id()));
            $styleIconoCarrito = (!empty($productoEnElCarrito)) ? 'shopping-bag-activo.svg' : 'shopping-bag.svg';
       
            $output .= '<div class="product">';
            $output .= '<a href="' . esc_url(get_the_permalink()) . '">
                            <div class="wiwu-carprod-cont-img">
                                <img src="' . esc_url(get_stylesheet_directory_uri() . '/images/' . $styleIconoCarrito) . '" alt="" class="wiwu-shoppingbag"/>
                                ' . wp_kses_post(wiwu_custom_hover_product_images()) . '
                            </div>
                        </a>';
            $output .= '<div class="add-to-cart">' . wiwu_mi_boton_personalizado($product->get_id()) . '</div>';
            $output .= '<h2 class="woocommerce-loop-product__title">' . get_the_title() . '</h2>';
            $output .= '<span class="price">' . $product->get_price_html() . '</span>';
            $output .= '</div>';
        }
        
        wp_send_json_success($output);
    } else {
        wp_send_json_error();
    }
    
    wp_reset_postdata();
}


/* ======================================================================
*  FUNCION QUE RETORNA LOS PRODUCTOS DE UNA CATEGORIA ESPECIFICA
*  @param int $limite  Número maximo de productos a obtener. DEbe de ser
*  positivo y por defecto 0
*  @param string $categoria Slug de la categoria. Obligatorio
*  @return array|string Array de argumentos para WP_Query
*  ======================================================================*/


function wiwu_obtener_productos_por_categoria($categoria,$limite = 8){
    
    if(empty($categoria)) return '';

    $limite = absint($limite);

    if($limite <= 0)  $limite = 8;

    $categoria_sanitizada = '';
    $categoria_sanitizada = sanitize_title($categoria);

    if(empty($categoria_sanitizada)) return '';

    $args = '';
    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => $limite,
        'orderby'        => 'desc',
        'meta_query'     => array(
            array(
                'key'     => '_stock_status',
                'value'   => 'instock',
                'compare' => '=',
            ),
        ),
        'tax_query'      => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'exclude-from-catalog',
                'operator' => 'NOT IN',
            ),
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $categoria,
            ),
        ),
    );
    return $args;
}




function  wiwu_mostrar_productos($query, $carousel_id,$limite,$categoria){
    $output = '';
    $contadorIteracciones = 0;

    if ($query->have_posts()):
        $output .= '<div class="wiwu-woo-products" id="' . esc_attr($carousel_id) . '">';
        $output .= '<div class="products">';
        
        while ($query->have_posts()) :
       
            $query->the_post();
            global $product;
            
            
            $productoEnElCarrito = WC()->cart->find_product_in_cart(WC()->cart->generate_cart_id($product->get_id()));
            $styleIconoCarrito = (!empty($productoEnElCarrito)) ? 'shopping-bag-activo.svg' : 'shopping-bag.svg';
            
            $output .= '<div class="product">';
            $output .= '<a href="' . esc_url(get_the_permalink()) . '">
                            <div class="wiwu-carprod-cont-img">
                              <span class="wiwu-descuento-producto">'.wiwu_mostar_descuento_del_producto().'</span>
                                <img src="' . esc_url(get_stylesheet_directory_uri() . '/images/' . $styleIconoCarrito) . '" alt="" class="wiwu-shoppingbag"/>
                                ' . wp_kses_post(wiwu_custom_hover_product_images()) . '
                            </div>
                        </a>';
            $output .= '<div class="add-to-cart">' . wiwu_mi_boton_personalizado($product->get_id()) . '</div>';
            $output .= '<h2 class="woocommerce-loop-product__title">' . get_the_title() . '</h2>';
            $output .= '<span class="price">' . $product->get_price_html() . '</span>';
            $output .= '</div>'; // Cierra el div del producto
            $contadorIteracciones++;

        endwhile;
        
        $output .= '</div>'; // Cierra el div de productos
        
        // Botón "Ver más"
        $limite = 4;
        if( $contadorIteracciones > $limite):
            $output .= '<div class="wiwu-load-more-container" style="text-align: center; margin-top: 20px;">';
            $output .= '<button class="wiwu-load-more" data-category="' . esc_attr($categoria) . '" 
                        data-limit="' . esc_attr($limite) . '" data-offset="' . esc_attr($limite) . '" 
                        data-carousel="' . esc_attr($carousel_id) . '">Ver más</button>';
            $output .= '</div>';
        endif;
        
        $output .= '</div>'; // Cierra el div del carrusel
        
    
        
        wp_reset_postdata();
    else:
        $output .= '<p>No hay productos disponibles en esta categoría.</p>';
    endif;

    return $output;

}




function wiwu_obtener_productos_por_id_categoria( $categoria_id,$limite = 8){
    
    if(empty($categoria_id)) return '';

    $categoria_id = absint($categoria_id);
    $limite = absint($limite);

    if($limite <= 0)  $limite = 8;


   /*  $categoria_sanitizada = '';
    $categoria_sanitizada = sanitize_title($categoria_id);

    if(empty($categoria_sanitizada)) return ''; */

    $args = '';
    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => $limite,
        'orderby'        => 'rand',
        'meta_query'     => array(
            array(
                'key'     => '_stock_status',
                'value'   => 'instock',
                'compare' => '=',
            ),
        ),
        'tax_query'      => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',  // Aquí se mantiene porque 'exclude-from-catalog' es un nombre, no un ID
                'terms'    => 'exclude-from-catalog',
                'operator' => 'NOT IN',
            ),
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',  // Cambiado de 'slug' a 'term_id'
                'terms'    => $categoria_id,  // Ahora espera un ID (ej: 5) en lugar de un slug (ej: 'camisetas')
            ),
        ),
    );
  
    
    return $args;
}


function wiwu_mostrar_productos_subcategoria($atts) {
    // Atributos del shortcode con valores por defecto
    if( !isset($_POST['product_id']) && empty($_POST['product_id'])):
        echo 'No hay productos';
        return '';
    endif;

    $idCategoria = absint( $_POST['product_id'] ) ;
    
    $atts = shortcode_atts(
        array(
            'limit' => 4
        ), 
        $atts, 
        'wiwu-productos-categoria'
    );
    
    // ID único para este carrusel
    $carousel_id = 'wiwu-carousel-' . uniqid();
    
    $args = wiwu_obtener_productos_por_id_categoria($idCategoria,$atts['limit']);
    
    $query = new WP_Query($args);
   

    //echo 'CANTIDAD: '.$contadorIteracciones;
    
    if (function_exists('wiwu_mostrar_productos')) :
        
        echo wiwu_mostrar_productos(
            $query,
            $idCategoria ,
            $atts['limit'], 
            $idCategoria 
        );
    endif;
    wp_die();
    
}


add_action( 'wp_ajax_nopriv_wiwu_mostrar_productos_subcategoria', 'wiwu_mostrar_productos_subcategoria' );
add_action( 'wp_ajax_wiwu_mostrar_productos_subcategoria', 'wiwu_mostrar_productos_subcategoria' );


function wiwu_mostar_descuento_del_producto(){
    global $product;
    $porcentaje= '';
    $precio_regular = '';
    $precio_venta = '';
    if ($product->is_on_sale() && !$product->is_type('variable')) {
        $precio_regular = $product->get_regular_price();
        $precio_venta = $product->get_sale_price();
        $porcentaje = round((($precio_regular - $precio_venta) / $precio_regular) * 100);
        
       return '-' . esc_html($porcentaje) . '%';
    }
}

/* ======================================================================
*  FUNCION PARA CREAR EL ROL MAYORISTA
*  ======================================================================*/

function wiwu_agregar_role_mayorista() {
    add_role('mayorista', 'Mayorista', array(
        'read' => true, // Acceso al dashboard
        'view_woocommerce_reports' => false, // Opcional: si quieres dar acceso a reportes
    ));
}
add_action('init', 'wiwu_agregar_role_mayorista');

/* ======================================================================
*  FUNCION PARA CREAR EL CAMPO DE PRECIO MAYORISTA EN EL PRODUCTO,
*  el id del campo es wholesale_price
*  ======================================================================*/
// Add wholesale price field to product edit page
function wiwu_agregar_campo_precio_mayorista_al_producto() {
    woocommerce_wp_text_input(array(
        'id' => 'wholesale_price',
        'label' => __('Precio Mayorista', 'woocommerce'),
        'type' => 'number',
        'custom_attributes' => array(
            'step' => '1',
            'min' => '0'
        ),
        'data_type' => 'price',
    ));
}
add_action('woocommerce_product_options_pricing', 'wiwu_agregar_campo_precio_mayorista_al_producto');

// Save wholesale price field
function wiwu_guardar_valor_campo_mayorista($product) {
    if (isset($_POST['wholesale_price'])) {
        $product->update_meta_data('wholesale_price', wc_format_decimal($_POST['wholesale_price']));
    }
}
add_action('woocommerce_admin_process_product_object', 'wiwu_guardar_valor_campo_mayorista');



// Mostrar precio mayorista solo a usuarios con rol "mayorista"
function wiwu_mostrar_precio_mayorista($price, $product) {
    if (is_user_logged_in() && current_user_can('mayorista')) {
        $wholesale_price = absint(get_post_meta($product->get_id(), 'wholesale_price', true));
        if ($wholesale_price && $wholesale_price > 0) {
            return wc_price(esc_html($wholesale_price)) . '<span class="wholesale-badge"></span>';
        }
    }
    return $price;
}
add_filter('woocommerce_get_price_html', 'wiwu_mostrar_precio_mayorista', 10, 2);

function apply_wholesale_price_cart($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;
    if (!is_user_logged_in() || !current_user_can('mayorista')) return;

    foreach ($cart->get_cart() as $cart_item) {
        $product_id = $cart_item['product_id'];
        $wholesale_price = get_post_meta($product_id, 'wholesale_price', true);
        if ($wholesale_price && $wholesale_price > 0) {
            $cart_item['data']->set_price($wholesale_price);
        }
    }
}
add_action('woocommerce_before_calculate_totals', 'apply_wholesale_price_cart');

// Mostrar campo en VARIACIONES de productos variables
function wiwu_agregar_campo_precio_mayorista_a_variaciones($loop, $variation_data, $variation) {
    woocommerce_wp_text_input(array(
        'id' => 'wholesale_price[' . $variation->ID . ']',
        'name' => 'wholesale_price[' . $variation->ID . ']',
        'label' => __('Precio Mayorista', 'woocommerce'),
        'type' => 'number',
        'custom_attributes' => array(
            'step' => '1',
            'min' => '0'
        ),
        'value' => get_post_meta($variation->ID, 'wholesale_price', true),
        'data_type' => 'price',
    ));
}
add_action('woocommerce_variation_options_pricing', 'wiwu_agregar_campo_precio_mayorista_a_variaciones', 10, 3);

// Guardar campo en VARIACIONES
function wiwu_guardar_valor_campo_mayorista_variaciones($variation_id, $i) {
    if (isset($_POST['wholesale_price'][$variation_id])) {
        update_post_meta(
            $variation_id,
            'wholesale_price',
            wc_format_decimal($_POST['wholesale_price'][$variation_id])
        );
    }
}
add_action('woocommerce_save_product_variation', 'wiwu_guardar_valor_campo_mayorista_variaciones', 10, 2);