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

add_shortcode( 'wiwu-cart', 'wiwu_mostrar_cart');

/* ===========================================================
* OCULTAR BREADCRUMBS DE LA PAGINA DE PRODUCTOS 
* =========================================================== */



function mi_seccion_personalizada() {
    echo '<div class="mi-seccion">';
    echo '<h3>Información Adicional</h3>';
    echo '<p>Aquí puedes agregar contenido personalizado sobre el producto.</p>';
    echo '</div>';
}



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

/* =============================== */
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

add_shortcode( 'wiwu-carrusel-productos', 'wiwu_mustrarCaruselProductos' );

function  wiwu_mostrarCaruselProductosRelacionados(){
    ?>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <?php 
    global $product;

if (!$product) {
    return '<p>Producto no encontrado.</p>';
}

$related_ids = wc_get_related_products($product->get_id(), $atts['limit']); 

if (empty($related_ids)) {
    return '<p>No hay productos relacionados disponibles.</p>';
}

$args = array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => $atts['limit'],
    'orderby'        => 'rand', 
    'post__in'       => $related_ids, 
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

$query = new WP_Query($args);

if ($query->have_posts()) {
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
        $output .= '<div class="add-to-cart">' . mi_boton_personalizado($product->get_id()) . '</div>';
        $output .= '<h2 class="woocommerce-loop-product__title">' . get_the_title() . '</h2>';
        $output .= '<span class="price">' . $product->get_price_html() . '</span>';
        $output .= '</div>'; // Cierra el div del producto

    endwhile;

    $output .= '</div>'; // Cierra el div de productos
    $output .= '</div>'; // Cierra el div del carrusel

    wp_reset_postdata();

    return $output;
} else {
    return '<p>No hay productos relacionados disponibles.</p>';
}
 


}

add_shortcode( 'wiwu-carrusel-productos-relacionados', 'wiwu_mostrarCaruselProductosRelacionados' );


function mi_boton_personalizado($product_id) {
    $texto = '';
    $product = wc_get_product($product_id);

    // Verificar si el producto ya está en el carrito
    $cart = WC()->cart;
    $is_product_in_caart = false;

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
                $output .= '<div class="add-to-cart">'.mi_boton_personalizado($product->get_id()).'</div>';
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

// Mostrar el atributo "color" con su descripción y slug
function mostrar_atributo_color_en_producto() {
    global $product;
    
    // Obtener el valor del atributo "color"
    $color = $product->get_attribute('colores');
    
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
                    echo '<input type="radio" name="pa_colores" value="' . esc_attr($slug) . '" class="wiwu-single-product-color-radio" /> ';
                        echo '<span class="wiwu-single-product-color" style="background-color: ' . esc_attr($term->description) . ';" data-color-name="'.esc_attr($nombre).'"></span>';
                    echo '</label>';
                endif;
            endif;
        endforeach;
        echo '</div>';
    endif;
}
add_action('woocommerce_before_add_to_cart_button', 'mostrar_atributo_color_en_producto', 20);



add_filter('woocommerce_add_cart_item_data', 'add_color_to_cart_item', 10, 3);

function add_color_to_cart_item($cart_item_data, $product_id, $variation_id) {
    if (isset($_POST['pa_colores'])) {
        $color = sanitize_text_field($_POST['pa_colores']);
        
        // Agregar el color seleccionado al artículo en el carrito
        $cart_item_data['color'] = $color;
    }
    return $cart_item_data;
}

// Mostrar el color seleccionado en el carrito
add_filter('woocommerce_get_item_data', 'display_color_in_cart', 10, 2);

function display_color_in_cart($item_data, $cart_item) {
    if (isset($cart_item['color'])) {
        $item_data[] = array(
            'key'     => __('Color', 'woocommerce'),
            'value'   => $cart_item['color'],
            'display' => $cart_item['color'],
        );
    }
    return $item_data;
}

// Mostrar el color en la página de detalles del pedido
add_action('woocommerce_order_item_meta_end', 'display_color_in_order', 10, 3);

function display_color_in_order($item_id, $item, $order) {
    if ($color = $item->get_meta('color')) {
        echo '<p><strong>' . __('Color:', 'woocommerce') . '</strong> ' . esc_html($color) . '</p>';
    }
}



// Añadir formulario personalizado con botón de añadir al carrito
add_action('woocommerce_after_add_to_cart_form', 'custom_variation_form_with_button', 20);
function custom_variation_form_with_button() {
    global $product;
    
    if ($product->is_type('variable')) {
        $attributes = $product->get_variation_attributes();
        $available_variations = $product->get_available_variations();
        
        if ($attributes) {
            wp_enqueue_script('wc-add-to-cart-variation');
            ?>
            <div class="custom-variation-form-wrapper">
                <form class="variations_form cart" method="post" enctype="multipart/form-data">
                    <table class="variations" cellspacing="0">
                        <tbody>
                            <?php foreach ($attributes as $attribute_name => $options) : ?>
                                <tr>
                                    <td class="label">
                                        <label for="<?php echo esc_attr(sanitize_title($attribute_name)); ?>">
                                            <?php echo wc_attribute_label($attribute_name); ?>
                                        </label>
                                    </td>
                                    <td class="value">
                                        <?php
                                        $selected = isset($_REQUEST['attribute_' . sanitize_title($attribute_name)]) 
                                            ? wc_clean($_REQUEST['attribute_' . sanitize_title($attribute_name)]) 
                                            : $product->get_variation_default_attribute($attribute_name);
                                        
                                        wc_dropdown_variation_attribute_options(array(
                                            'options' => $options,
                                            'attribute' => $attribute_name,
                                            'product' => $product,
                                            'selected' => $selected,
                                            'class' => 'custom-variation-select'
                                        ));
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="single_variation_wrap">
                        <div class="woocommerce-variation single_variation">
                            <div class="woocommerce-variation-description"></div>
                            <div class="woocommerce-variation-price">
                                <span class="price"></span>
                            </div>
                            <div class="woocommerce-variation-availability"></div>
                        </div>
                        <div class="woocommerce-variation-add-to-cart variations_button">
                            <?php 
                            woocommerce_quantity_input(array(
                                'min_value' => 1,
                                'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity(),
                                'input_value' => isset($_POST['quantity']) ? wc_stock_amount($_POST['quantity']) : 1
                            )); 
                            ?>
                            <button type="submit" class="single_add_to_cart_button button alt">
                                <?php echo esc_html($product->single_add_to_cart_text()); ?>
                            </button>
                            <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
                            <input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>" />
                            <input type="hidden" name="variation_id" class="variation_id" value="0" />
                        </div>
                    </div>
                </form>
            </div>

            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    // Inicializar el manejo de variaciones de WooCommerce
                    $('.variations_form').wc_variation_form();
                    
                    // Actualizar el botón cuando cambian las selecciones
                    $('.variations_form').on('woocommerce_variation_select_change', function() {
                        $('.single_add_to_cart_button').prop('disabled', false);
                    });
                    
                    // Deshabilitar el botón inicialmente
                    $('.single_add_to_cart_button').prop('disabled', true);
                });
            </script>
            <?php
        }
    }
}

// CSS para el formulario
add_action('wp_head', 'custom_variation_form_css');
function custom_variation_form_css() {
    ?>
    <style>
        .custom-variation-form-wrapper {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #e4e4e4;
            background: #fafafa;
            border-radius: 3px;
        }
        .custom-variation-form-wrapper table.variations {
            margin-bottom: 20px;
            width: 100%;
        }
        .custom-variation-form-wrapper table.variations td.label {
            width: 30%;
            padding-right: 10px;
            vertical-align: top;
        }
        .custom-variation-form-wrapper table.variations td.value {
            width: 70%;
        }
        .custom-variation-form-wrapper select.custom-variation-select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        .custom-variation-form-wrapper .single_variation_wrap {
            margin-top: 20px;
        }
        .custom-variation-form-wrapper .price {
            font-size: 1.25em;
            color: #77a464;
            font-weight: bold;
        }
        .custom-variation-form-wrapper .woocommerce-variation-add-to-cart {
            margin-top: 15px;
        }
        .custom-variation-form-wrapper .quantity {
            margin-right: 10px;
        }
    </style>
    <?php
}