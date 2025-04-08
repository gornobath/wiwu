<?php defined( 'ABSPATH' ) || exit; ?>
<style>
    .cart-empty,
    .return-to-shop{
        display: none; 
    }
</style>

<div class="wiwu-cart-vacio">
    <div class="wiwu-cart-vacio-cont">
        <div class="wiwu-cart-vacio-box">
            <div class="wiwu-cart-vacio-box-1">
                <img src="<?php echo esc_url(get_stylesheet_directory_uri() .'/images/cara.jpg');?>" class="wiwu-cart-vacio-box-1-logo" alt="cara triste"/>
                <p class="wiwu-cart-vacio-box-texto-1"><?php echo esc_html_e('Upss'); ?></p>
                <p class="wiwu-cart-vacio-box-texto-2"><?php echo esc_html_e('Tu carrito se encuentra vacio')?></p>
                <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>"  class="wiwu-cart-vacio-box-btn">Visita nuestra tienda</a>
            </div>
            <div class="wiwu-cart-vacio-box-2">
                <p class="wiwu-cart-vacio-box-texto-2"><?php echo esc_html_e( 'Te invitamos a que eches un vistazo a nuestro amplio catalogo de productos' )?></p>
            </div>
        </div>
        <div class="wiwu-cart-vacio-box-fondo">
            <img src="<?php echo esc_url(get_stylesheet_directory_uri() .'/images/reloj.jpg')?>" class="wiwu-cart-vacio-fondo-img" alt="reloj"/>
        </div>
    </div>
</div>