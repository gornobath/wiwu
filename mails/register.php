<?php defined( 'ABSPATH' ) || exit;

function custom_user_registration_email($wp_new_user_notification_email, $user, $blogname) {
    $user_login = $user->user_login;
    $user_email = $user->user_email;
    $first_name = get_user_meta($user->ID, 'first_name', true);
    $last_name = get_user_meta($user->ID, 'last_name', true);
    
    $subject = sprintf('¡Bienvenido a %s!', $blogname);
    
    $message = sprintf("Hola %s %s,\n\n", $first_name, $last_name);
    $message .= sprintf("¡Gracias por registrarte en %s!\n\n", $blogname);
    $message .= "Tu registro ha sido exitoso. A continuación tienes tus datos de acceso:\n\n";
    $message .= sprintf("Usuario: %s\n", $user_login);
    $message .= sprintf("Correo electrónico: %s\n\n", $user_email);
    $message .= "Puedes acceder a tu cuenta en cualquier momento visitando nuestro sitio web.\n\n";
    $message .= "¡Gracias!\n";
    $message .= "El equipo de " . $blogname;
    
    $wp_new_user_notification_email['subject'] = $subject;
    $wp_new_user_notification_email['message'] = $message;
    
    return $wp_new_user_notification_email;
}
add_filter('wp_new_user_notification_email', 'custom_user_registration_email', 10, 3);