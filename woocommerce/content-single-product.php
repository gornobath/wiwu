<?php defined( 'ABSPATH' ) || exit;
/**
 * Template part for displaying a single product
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

    global $product;
    $claseSiNoExisteImagen = '';
    $imagenBannerDesktop = '';
    $imagenBannerMobile = '';
    $imagenProductoPrincipal = '';
    $imagenProductoSecundaria = '';
    $imagenesProductoDeColor = '';
    $prefijo = '';
    $seccion1Descripcion1 = '';
    $seccion1ImagenPrincipal = '';
    $seccion1ImagenSecundaria = '';
    $seccion1Titulo = '';
    $seccion2Descripcion1 = '';
    $seccion2ImagenPrincipal = '';
    $seccion2ImagenSecundaria = '';
    $seccion2Titulo = '';
    $seccion1InformativaLogo = '';
    $seccion1InformativaTitulo = '';
    $seccion1InformativaTexto = '';
    $tamanoLetraTitulo  = '';
    $classTamanoLetraTitulo  = '';
    

    
    $prefijo = 'wiwu_product_';


    $imagenBannerDesktop = (get_post_meta( get_the_ID(), $prefijo.'banner_desktop_principal', true )) ? esc_url_raw( get_post_meta( get_the_ID(), $prefijo.'banner_desktop_principal', true ) ) : '' ;
    $imagenBannerMobile =  esc_url_raw( get_post_meta( get_the_ID(), $prefijo.'banner_mobile_principal', true ) );
    $imagenProductoPrincipal = esc_url_raw( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID())));
    $imagenProductoSecundaria = esc_url_raw( get_post_meta( get_the_ID(), $prefijo.'imagen_producto', true ));
    $imagenesProductoDeColor =   get_post_meta( get_the_ID(), $prefijo.'grupo_color', true ) ;
    $seccion1ImagenPrincipal = esc_url_raw( get_post_meta( get_the_ID(), $prefijo.'infoadi_1_imagen_principal', true ));
    $seccion1ImagenSecundaria = esc_url_raw( get_post_meta( get_the_ID(), $prefijo.'infoadi_1_imagen_secundaria', true ) );
    $seccion1Titulo = sanitize_text_field( get_post_meta( get_the_ID(), $prefijo.'infoadi_1_titulo', true ) );
    $seccion1Descripcion =  get_post_meta( get_the_ID(), $prefijo.'infoadi_1_textos_informacion_adicional', true ) ;
    $seccion2Descripcion =  get_post_meta( get_the_ID(), $prefijo.'infoadi_2_textos_informacion_adicional', true );
    $seccion2ImagenPrincipal = esc_url_raw( get_post_meta( get_the_ID(), $prefijo.'infoadi_2_imagen_principal', true ));
    $seccion2ImagenSecundaria = esc_url_raw( get_post_meta( get_the_ID(), $prefijo.'infoadi_2_imagen_secundaria', true ));
    $seccion2Titulo = sanitize_text_field( get_post_meta( get_the_ID(), $prefijo.'infoadi_2_titulo', true ) );
    $seccion1InformativaLogo = esc_url_raw( get_post_meta( get_the_ID(), $prefijo.'seccion_1_icono', true ));
    $seccion1InformativaTitulo = sanitize_text_field( get_post_meta( get_the_ID(), $prefijo.'seccion_1_titulo', true ) );
    $seccion1InformativaTexto = sanitize_textarea_field( get_post_meta( get_the_ID(), $prefijo.'seccion_1_texto', true ) );
    $seccion2InformativaLogo = esc_url_raw( get_post_meta( get_the_ID(), $prefijo.'seccion_2_icono', true ));
    $seccion2InformativaTitulo = sanitize_text_field( get_post_meta( get_the_ID(), $prefijo.'seccion_2_titulo', true ) );
    $seccion2InformativaTexto = sanitize_textarea_field( get_post_meta( get_the_ID(), $prefijo.'seccion_2_texto', true ) );
    $tamanoLetraTitulo  = get_post_meta( get_the_ID(), $prefijo.'tamano_letra', true );
   

    if( $tamanoLetraTitulo == 'muy_grande'):
        $classTamanoLetraTitulo  = 'wiwu-product-banner-titulo-muy-grande';
    elseif( $tamanoLetraTitulo == 'grande'):
        $classTamanoLetraTitulo  = 'wiwu-product-banner-titulo-grande';
    elseif( $tamanoLetraTitulo == 'mediano'):
        $classTamanoLetraTitulo  = 'wiwu-product-banner-titulo-mediano';
    elseif( $tamanoLetraTitulo == 'pequeno'):
        $classTamanoLetraTitulo  = 'wiwu-product-banner-titulo-pequeno';
    elseif( $tamanoLetraTitulo == 'muy-pequeno'):
        $classTamanoLetraTitulo  = 'wiwu-product-banner-titulo-muy-pequeno';
    else: 
        $classTamanoLetraTitulo  = 'wiwu-product-banner-titulo-muy-pequeno';
    endif;

    //Si no esta la imagen principal, se muestra la imagen del producto
   $claseSiNoExisteImagen = (!empty($imagenBannerDesktop )) ? '' : 'wiwu-mostrar-imagen-thumbnail' ;

    //$descripcion = wpautop( get_post_meta( get_the_ID(), $prefijo1.'descripcion_metabox', true ) );

?>

<div class="wiwu-product-cont"> 
    <div class="wiwu-product-banner <?php echo esc_attr( $claseSiNoExisteImagen ); ?>" style="background-image: url('<?php echo esc_attr($imagenBannerDesktop); ?>')">
        <div class="wiwu-product-banner-cont">
            <div class="wiwu-product-banner-cont-img">
                <div class="wiwu-product-banner-box-img">
                    <?php //woocommerce_show_product_images(); ?>
                    <?php if(empty($imagenProductoPrincipal )):?>
                            <img src="<?php echo esc_url( $imagenBannerMobile )?>" class="wiwu-product-img-principal wiwu-product-img-principal-activo" alt="<?php esc_html(the_title()) ;?>" />
                    <?php else: ?>
                        <img src="<?php echo esc_url( $imagenProductoPrincipal )?>" class="wiwu-product-img-principal wiwu-product-img-principal-activo" alt="<?php esc_html(the_title()) ;?>" />
                    <?php endif; ?>
                    <?php 
                        foreach($imagenesProductoDeColor as $ipc):?>
                            <img src="<?php  echo  esc_url($ipc[$prefijo.'imagen_color']); ?>" class="wiwu-product-img-principal" id="wiwuProductImg_<?php echo esc_attr($ipc[$prefijo.'nombre_color']);?>"/>
                        <?php endforeach;?>
                    <?php //if(!empty($seccion1ImagenSecundaria )):?>
                        <!-- <img src="<?php echo esc_url( $seccion1ImagenSecundaria)?>" class="wiwu-product-img-secundaria" alt="" /> -->
                    <?php //endif; ?>
                </div>
            </div>
            <div class="wiwu-product-banner-cont-info">
                <div class="wiwu-product-banner-box-1_info">
                    <h1 class="wiwu-product-banner-cont-info-titulo <?php echo esc_attr($classTamanoLetraTitulo);?>"><?php esc_html(the_title()); ?></h1>
                    <div class="wiwu-product-banner-cont-info-texto">
                        <?php the_content(); ?>
                    </div>
                </div>
                
                <div class="wiwu-product-banner-box-2_info">
                    <div class="wiwu-product-banner-cont-info-price">
                        <span class="price"><?php woocommerce_template_single_price(); ?></span>
                    </div>

                    <div class="wiwu-product-banner-cont-info-add-to-cart">
                        <?php 
                        global $product;
                  
                         $tipoProducto = wc_get_product($product->get_id());
                        echo 'tipo:  '.$tipoProducto->get_type();
                      //mostrar_atributo_color_en_producto();
                      if( $tipoProducto->get_type() ===  'simple'):
                            woocommerce_template_single_add_to_cart();
                        elseif( $tipoProducto->get_type() ===  'variable'):
                            woocommerce_template_single_add_to_cart();
                        else: 
                    endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <?php if(!empty($seccion1Descripcion)):?>
        <div class="wiwu-product-infoadi wiwu-product-infoadi">
            <div class="wiwu-product-infoadi-cont">
            <h2 class="wiwu-product-infoadi-cont-info-titulo wiwu-product-infoadi-cont-info-titulo-mobile"><?php echo esc_html($seccion1Titulo);?></h2>
                <div class="wiwu-product-infoadi-cont-img">
                    <div class="wiwu-product-infoadi-box-img">
                        <?php if(!empty($seccion1ImagenPrincipal )):?>
                            <img src="<?php echo esc_url( $seccion1ImagenPrincipal )?>" class="wiwu-product-infoadi-box-img-principal" alt="" />
                        <?php endif; ?>
                        <?php if(!empty($seccion1ImagenSecundaria )):?>
                            <img src="<?php echo esc_url( $seccion1ImagenSecundaria)?>" class="wiwu-product-infoadi-box-img-secundaria" alt="" />
                        <?php endif; ?>
                    </div>
                </div>
                <div class="wiwu-product-infoadi-cont-info">
                    <h2 class="wiwu-product-infoadi-cont-info-titulo wiwu-product-infoadi-cont-info-titulo-escritorio"><?php echo esc_html($seccion1Titulo);?></h2>
                    <div class="wiwu-product-infoadi-cont-info-descripcion">
                        <?php foreach($seccion1Descripcion as $desc1):?>
                            <?php  echo  wpautop($desc1[$prefijo.'infoadi_1_texto_descripcion'])?>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>

    <?php if(!empty($seccion2Descripcion)):?>
        <div class="wiwu-product-infoadi_2">
            <div class="wiwu-product-infoadi-cont">
                
                <div class="wiwu-product-infoadi-cont-info">
                    <?php if($seccion2Titulo != ''):?>
                        <h2 class="wiwu-product-infoadi-cont-info-titulo"><?php echo esc_html($seccion2Titulo);?></h2>
                    <?php endif;?>
                    <div class="wiwu-product-infoadi-cont-info-descripcion">
                        <?php foreach($seccion2Descripcion as $desc2):?>
                            <?php  echo  wpautop($desc2[$prefijo.'infoadi_2_texto_descripcion'])?>
                        <?php endforeach;?>
                    </div>
                </div>
                <div class="wiwu-product-infoadi-cont-img">
                    <div class="wiwu-product-infoadi-box-img">
                        <?php if(!empty($seccion2ImagenPrincipal )):?>
                            <img src="<?php echo esc_url( $seccion2ImagenPrincipal )?>" class="wiwu-product-infoadi-box-img-principal" alt="" />
                        <?php endif; ?>
                        <?php if(!empty($seccion2ImagenSecundaria )):?>
                            <img src="<?php echo esc_url( $seccion2ImagenSecundaria)?>" class="wiwu-product-infoadi-box-img-secundaria" alt="" />
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>

    <?php if($seccion1InformativaTitulo != ''):?>
        <div class="wiwu-product-seccion-informativo">
            <div class="wiwu-product-seccion-informativo-cont">
                <div class="wiwu-product-seccion-informativo-box wiwu-product-seccion-informativo-box-izquierda">
                    <?php if(!empty($seccion1InformativaLogo )):?>
                        <img src="<?php echo esc_url( $seccion1InformativaLogo )?>" class="wiwu-product-seccion-informativo-img" alt="" />
                    <?php endif; ?>
                    <?php if(!empty($seccion1InformativaTitulo )):?>
                        <h3 class="wiwu-product-seccion-informativo-titulo"><?php echo esc_html($seccion1InformativaTitulo);?></h3>
                    <?php endif; ?>
                    <?php if(!empty($seccion1InformativaTexto )):?>
                        <div class="wiwu-product-seccion-informativo-texto"><?php echo wpautop($seccion1InformativaTexto);?></div>
                    <?php endif; ?>
                </div>
                <div class="wiwu-product-seccion-informativo-box wiwu-product-seccion-informativo-box-derecho">
                    <?php if(!empty($seccion2InformativaLogo )):?>
                        <img src="<?php echo esc_url( $seccion2InformativaLogo )?>" class="wiwu-product-seccion-informativo-img" alt="" />
                    <?php endif; ?>
                    <?php if(!empty($seccion2InformativaTitulo )):?>
                        <h3 class="wiwu-product-seccion-informativo-titulo"><?php echo esc_html($seccion2InformativaTitulo);?></h3>
                    <?php endif; ?>
                    <?php if(!empty($seccion2InformativaTexto )):?>
                        <div class="wiwu-product-seccion-informativo-texto"><?php echo wpautop($seccion2InformativaTexto);?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif;?>

	<?php if(shortcode_exists('wiwu-carrusel-productos-relacionados')):?>
	  <div class="wiwu-carrousel-destacados">
			<h2 class="wiwu-carrousel-destacados-titulo">Te puede interesar</h2>
			<div class="wiwu-carrousel-destacados-cont">
				<?php echo do_shortcode('[wiwu-carrusel-productos-relacionados limit="8" columns="4" rows="2"]'); ?>
			</div>
		</div>
	<?php endif;?>

</div>
