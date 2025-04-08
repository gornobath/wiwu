<?php

/* =================================================================
*  FUNCION PARA CAMBIAR EL TEXTO DE LOST YOUR PASSWORD DEL FORM DE
*  LOGIN DE ELEMENTOR
*  ================================================================= */

function wiwcustom_lost_password_text( $text ) {
    if ( $text === 'Lost your password?' ) {
        return '¿Olvidaste tu contraseña?'; // Cambia esto por el texto que desees
    }
    return $text;
}
add_filter( 'gettext', 'wiwcustom_lost_password_text' ); 


/* =================================================================
*  FUNCION PARA CAMBIAR EL TEXTO DE You are logged in as DEL FORM DE
*  LOGIN DE ELEMENTOR CUANDO EL USUARIO ESTA LOGUEADO
*  ================================================================= */
function wiwcustom_cambiar_mensaje_logged_in($text) {
    if( strpos($text, 'You are logged in as') !== false ) {
        $text = str_replace('You are logged in as', 'Ha iniciado sesión como', $text);
    }
    return $text;
}
add_filter('gettext', 'wiwcustom_cambiar_mensaje_logged_in');