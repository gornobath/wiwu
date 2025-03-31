jQuery(function ($) {
    $('.wewo-menu-mobile-navicon').on('click',() =>{
        $('.wewo-menu-mobile-cont').addClass('wewo-menu-mobile-cont-mostrar')
    })

    $('#wiwu-btn-cerrar-menu').on('click',() =>{
        $('.wewo-menu-mobile-cont').removeClass('wewo-menu-mobile-cont-mostrar')
    })

 /*    $('.wiwu-home-ultra-producto-btn').hover( 
        function(){
            let idContenedorCaracteristica = $(this).attr('id').split('-').pop();
            $('#wiwu-home-ultra-producto-box-info-'+idContenedorCaracteristica).addClass('wiwu-home-ultra-producto-box-info-mostrar');
            $('#wiwu-home-ultra-producto-btn-'+idContenedorCaracteristica).removeClass('wiwu-home-ultra-producto-btn-mostrar');
        },
        function(){
            $('#wiwu-home-ultra-producto-box-info').removeClass('wiwu-home-ultra-producto-box-info-mostrar');
            $('#wiwu-home-ultra-producto-btn-'+idContenedorCaracteristica).addClass('wiwu-home-ultra-producto-btn-mostrar');
        }
    ); */

    $('.wiwu-home-ultra-producto-btn').on('mouseenter', function(){
        let idContenedorCaracteristica = $(this).attr('id').split('-').pop();
            $('#wiwu-home-ultra-producto-box-info-'+idContenedorCaracteristica).addClass('wiwu-home-ultra-producto-box-info-mostrar');
            $('#wiwu-home-ultra-producto-btn-'+idContenedorCaracteristica).addClass('wiwu-home-ultra-producto-btn-mostrar');
    }) 

    $('.wiwu-home-ultra-producto-box-info').on('mouseleave', function(){
        $('.wiwu-home-ultra-producto-box-info').removeClass('wiwu-home-ultra-producto-box-info-mostrar');
        $('.wiwu-home-ultra-producto-btn').removeClass('wiwu-home-ultra-producto-btn-mostrar');
    }) 

   $('.wiwu-home-mobile-ultra-producto-btn').on('click',function(){
        let idPopupCaracteristica = $(this).attr('id').split('-').pop();
        $('#wiwu-home-mobile-ultra-producto-cont-info-'+idPopupCaracteristica).addClass('wiwu-home-mobile-ultra-producto-cont-info-mostrar')
   })

  /*  $('#wiwu-home-mobile-ultra-producto-btn-2').on('click',function(){
        let idPopupCaracteristica = $(this).attr('id').split('-').pop();
        $('#wiwu-home-mobile-ultra-producto-cont-info-'+idPopupCaracteristica).addClass('wiwu-home-mobile-ultra-producto-cont-info-mostrar')
        alert('2')
    }) */

    $('.wiwu-home-mobile-ultra-producto-cont-info-btn-cerrar').on('click',function(){
        $('.wiwu-home-mobile-ultra-producto-cont-info').removeClass('wiwu-home-mobile-ultra-producto-cont-info-mostrar')
    })



    /* ===========================================================
    *   Activel carrito de compra al pasar el cursor sobre el boton
    * ===========================================================*/
   $('.wiwu-header-cart-btn').on('mouseenter', function() {
        $('.wiwu-header-cart').addClass('wiwu-header-cart-mostrar')
   }); 
   $('.wiwu-header-cart').on('mouseleave', function() {
        $('.wiwu-header-cart').removeClass('wiwu-header-cart-mostrar')
   }); 
   $('.wiwu-cart-header-btn-cerrar').on('click', function() {
        $('.wiwu-header-cart').removeClass('wiwu-header-cart-mostrar')
   }); 


   let estadoBotonMorrales = false;
   $('#wiwu-tienda-categoria-cont-botonera-boton-1').on('click',function(){
   
    if(estadoBotonMorrales == false){
        $(this).addClass('wiwu-tienda-categoria-cont-botonera-boton-activo')
        $('.wiwu-tienda-banner').addClass('wiwu-tienda-banner-ocultar');
        $('.wiwu-tienda-titulo-principal').addClass('wiwu-tienda-titulo-principal-ocultar');
        $('.wiwu-tienda-morrales').addClass('wiwu-tienda-morrales-mostrar');
        $('.wiwu-tienda-cont-1-izquierda').addClass('wiwu-tienda-cont-1-izquierda-mostrar');
        estadoBotonMorrales = true
    }else{
        $(this).removeClass('wiwu-tienda-categoria-cont-botonera-boton-activo')
        $('.wiwu-tienda-banner').removeClass('wiwu-tienda-banner-ocultar');
        $('.wiwu-tienda-titulo-principal').removeClass('wiwu-tienda-titulo-principal-ocultar');
        $('.wiwu-tienda-morrales').removeClass('wiwu-tienda-morrales-mostrar');
        $('.wiwu-tienda-cont-1-izquierda').removeClass('wiwu-tienda-cont-1-izquierda-mostrar');
        estadoBotonMorrales = false
    }
   })



   let estadoBotonPortatiles = false;
   $('#wiwu-tienda-categoria-cont-botonera-boton-2').on('click',function(){
    if(estadoBotonPortatiles == false){
        $(this).addClass('wiwu-tienda-categoria-cont-botonera-boton-activo')
        $('.wiwu-tienda-ipad').addClass('wiwu-tienda-titulo-principal-ocultar');
        $('.wiwu-tienda-portatil').addClass('wiwu-tienda-portatil-mostrar');
        $('.wiwu-tienda-cont-2-derecha').addClass('wiwu-tienda-cont-2-derecha-mostrar');
        estadoBotonPortatiles = true
    }else{
        $(this).removeClass('wiwu-tienda-categoria-cont-botonera-boton-activo')
        $('.wiwu-tienda-ipad').removeClass('wiwu-tienda-titulo-principal-ocultar');
        $('.wiwu-tienda-portatil').removeClass('wiwu-tienda-portatil-mostrar');
        $('.wiwu-tienda-cont-2-derecha').removeClass('wiwu-tienda-cont-2-derecha-mostrar');
        estadoBotonPortatiles = false
    }
   })

let estadoBotonIpad = false;
   $('#wiwu-tienda-categoria-cont-botonera-boton-3').on('click',function(){
    if(estadoBotonIpad == false){
        $(this).addClass('wiwu-tienda-categoria-cont-botonera-boton-activo')
        $('.wiwu-tienda-portatil').addClass('wiwu-tienda-titulo-principal-ocultar');
        $('.wiwu-tienda-ipad').addClass('wiwu-tienda-ipad-mostrar');
        $('.wiwu-tienda-cont-3-izquierda').addClass('wiwu-tienda-cont-3-izquierda-mostrar');
        estadoBotonIpad = true
    }else{
        $(this).removeClass('wiwu-tienda-categoria-cont-botonera-boton-activo')
        $('.wiwu-tienda-portatil').removeClass('wiwu-tienda-titulo-principal-ocultar');
        $('.wiwu-tienda-ipad').removeClass('wiwu-tienda-ipad-mostrar');
        $('.wiwu-tienda-cont-3-izquierda').removeClass('wiwu-tienda-cont-3-izquierda-mostrar');
        estadoBotonIpad = false
    }
   })

   let estadoBotonSmarthphone= false;
   $('#wiwu-tienda-categoria-cont-botonera-boton-4').on('click',function(){
    if(estadoBotonSmarthphone == false){
        $(this).addClass('wiwu-tienda-categoria-cont-botonera-boton-activo')
        $('.wiwu-tienda-categoria-cont-4-botonera').addClass('wiwu-tienda-categoria-cont-4-botonera-activo')
        $('.wiwu-tienda-smartphone').addClass('wiwu-tienda-smartphone-mostrar');
        $('.wiwu-tienda-cont-4-derecha').addClass('wiwu-tienda-cont-4-derecha-mostrar');
        estadoBotonSmarthphone = true
    }else{
        $(this).removeClass('wiwu-tienda-categoria-cont-botonera-boton-activo')
        $('.wiwu-tienda-smartphone').removeClass('wiwu-tienda-smartphone-mostrar');
        $('.wiwu-tienda-cont-4-derecha').removeClass('wiwu-tienda-cont-4-derecha-mostrar');
        $('.wiwu-tienda-categoria-cont-4-botonera').removeClass('wiwu-tienda-categoria-cont-4-botonera-activo')
        estadoBotonSmarthphone = false
    }
   })




   let estadoBotonMorralesMobile = false;
   $('.wiwu-tienda-morrales-mobile').on('click',function(){
        if(estadoBotonMorralesMobile == false){
            $(this).find('.wiwu-tienda-categoria-cont-botonera-boton').addClass('wiwu-tienda-categoria-cont-botonera-boton-activo');
            $(this).addClass('wiwu-tienda-morrales-mobile-activo');
            $('.wiwu-tienda-mobile-menu').addClass('wiwu-tienda-mobile-menu-activo');
            
            estadoBotonMorralesMobile = true;
        }else{
            $(this).removeClass('wiwu-tienda-morrales-mobile-activo')
            $('.wiwu-tienda-mobile-menu').removeClass('wiwu-tienda-mobile-menu-activo');
            $(this).find('.wiwu-tienda-categoria-cont-botonera-boton').removeClass('wiwu-tienda-categoria-cont-botonera-boton-activo');
            estadoBotonMorralesMobile = false;
        }
   })

   let estadoBotonPortatilesMobile = false;
   $('.wiwu-tienda-portatiles-mobile').on('click',function(){
        if(estadoBotonPortatilesMobile == false){
            $(this).find('.wiwu-tienda-categoria-cont-botonera-boton').addClass('wiwu-tienda-categoria-cont-botonera-boton-activo');
            $(this).addClass('wiwu-tienda-portatiles-mobile-activo');
            $('.wiwu-tienda-mobile-menu').addClass('wiwu-tienda-mobile-menu-activo');
            estadoBotonPortatilesMobile = true;
        }else{
            $(this).removeClass('wiwu-tienda-portatiles-mobile-activo')
            $('.wiwu-tienda-mobile-menu').removeClass('wiwu-tienda-mobile-menu-activo');
            $(this).find('.wiwu-tienda-categoria-cont-botonera-boton').removeClass('wiwu-tienda-categoria-cont-botonera-boton-activo');
            estadoBotonPortatilesMobile = false;
        }
   })

   let estadoBotonIpadMobile = false;
   $('.wiwu-tienda-ipad-mobile').on('click',function(){
        if(estadoBotonIpadMobile == false){
            $(this).find('.wiwu-tienda-categoria-cont-botonera-boton').addClass('wiwu-tienda-categoria-cont-botonera-boton-activo');
            $(this).addClass('wiwu-tienda-ipad-mobile-activo');
            $('.wiwu-tienda-mobile-menu').addClass('wiwu-tienda-mobile-menu-activo');
            estadoBotonIpadMobile = true;
        }else{
            $(this).removeClass('wiwu-tienda-ipad-mobile-activo')
            $('.wiwu-tienda-mobile-menu').removeClass('wiwu-tienda-mobile-menu-activo');
            $(this).find('.wiwu-tienda-categoria-cont-botonera-boton').removeClass('wiwu-tienda-categoria-cont-botonera-boton-activo');
            estadoBotonIpadMobile = false;
        }
   })

   let estadoBotonSmartphonesMobile = false;
   $('.wiwu-tienda-smartphones-mobile').on('click',function(){
        if(estadoBotonSmartphonesMobile == false){
            $(this).find('.wiwu-tienda-categoria-cont-botonera-boton').addClass('wiwu-tienda-categoria-cont-botonera-boton-activo');
            $(this).addClass('wiwu-tienda-smartphones-mobile-activo');
            $('.wiwu-tienda-mobile-menu').addClass('wiwu-tienda-mobile-menu-activo');
            
            estadoBotonSmartphonesMobile = true;
        }else{
            $(this).removeClass('wiwu-tienda-smartphones-mobile-activo')
            $('.wiwu-tienda-mobile-menu').removeClass('wiwu-tienda-mobile-menu-activo');
            $(this).find('.wiwu-tienda-categoria-cont-botonera-boton').removeClass('wiwu-tienda-categoria-cont-botonera-boton-activo');
            estadoBotonSmartphonesMobile = false;
        }
   })

if($('.wiwu-woo-carousel-products .products').length > 0){
   $('.wiwu-woo-carousel-products .products').slick({
        slidesToShow: 4,
        slidesToScroll: 2,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 6000,
        dots: false, // Activar los bullets (puntos)
        arrows: true, // Activar las flechas
        prevArrow: '<button type="button" class="slick-prev"><</button>', // Flecha anterior
        nextArrow: '<button type="button" class="slick-next">></button>', // Flecha siguiente
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
}

/* ==============================================================
*   FUNCION PARA CAMBIAR LA IMAGEN DEL PRODUCTO CUANDO SE HACE 
*   CLIC EN EL COLOR 
*  ============================================================== */
    $('.wiwu-single-product-color-label').on('click',function(){
        let $this = $(this);
        let $radio = $this.find('.wiwu-single-product-color-radio');

        if ($radio.length === 0) return; // Evita errores si no se encuentra el radio

        let valorColor = $radio.attr('value');

        if (!valorColor) return; // Verifica que el valor no sea vacío o undefined

        // Escapar y sanitizar el valor antes de usarlo en un selector
        let safeValorColor = valorColor.replace(/[^a-zA-Z0-9_-]/g, ''); 
        let slugImagenColor = `#wiwuProductImg_${safeValorColor}`;

        let $imagenObjetivo = $(slugImagenColor);

        if ($imagenObjetivo.length === 0) return; // Evita errores si la imagen no existe

        $('.wiwu-product-img-principal').removeClass('wiwu-product-img-principal-activo');
        $imagenObjetivo.addClass('wiwu-product-img-principal-activo');
    })


});