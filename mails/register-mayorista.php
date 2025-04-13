<?php defined( 'ABSPATH' ) || exit;


/**
 * Enviar correo al usuario mayorista
 */
function wiwu_enviar_email_a_mayorista_registrado($user_id, $password) {
    $user = get_userdata($user_id);
    $first_name = sanitize_text_field( get_user_meta($user_id, 'first_name', true) );
    $second_name = sanitize_text_field(get_user_meta($user_id, 'second_name', true) );
    $company = sanitize_text_field(get_user_meta($user_id, 'wholesale_company', true) );
    
    $to = $user->user_email;
    $subject = 'Registro de Mayorista Recibido';
    
    $message = "Hola ". esc_html($first_name .' '. $second_name) .",\n\n";
    $message .= "Gracias por registrarte como mayorista en nuestra tienda.\n\n";
    $message .= "Tu solicitud ha sido recibida correctamente y está siendo revisada por nuestro equipo.\n";
    $message .= "Pronto estaremos en contacto contigo para informarte sobre el estado de tu registro.\n\n";
    $message .= "Datos de tu solicitud:\n";
    $message .= "Empresa: ". esc_html($company)." \n";
    $message .= "Correo electrónico: {". esc_html($user->user_email)."}\n\n";
    $message .= "Si tienes alguna pregunta, no dudes en contactarnos.\n\n";
    $message .= "Atentamente,\n";
    $message .= get_bloginfo('name');
    
    wp_mail($to, $subject, $message);
}

/**
 * Enviar correo al administrador
 */
function wiwu_enviar_email_registro_mayorista_a_admin($user_id) {
    $user = get_userdata($user_id);
    $first_name = sanitize_text_field(get_user_meta($user_id, 'first_name', true) );
    $second_name = sanitize_text_field(get_user_meta($user_id, 'last_name', true) );
    $phone = sanitize_text_field(get_user_meta($user_id, 'wholesale_phone', true) );
    $doc_type = sanitize_text_field(get_user_meta($user_id, 'wholesale_doc_type', true) );
    $doc_number = sanitize_text_field(get_user_meta($user_id, 'wholesale_doc_number', true) );
    $company = sanitize_text_field(get_user_meta($user_id, 'wholesale_company', true) );
    
    // Traducir tipo de documento
    $doc_types = array(
        'camara_comercio' => 'Cámara de comercio',
        'rut' => 'RUT',
        'cedula_representante' => 'Cédula representante legal'
    );
    $doc_type_name = isset($doc_types[$doc_type]) ? $doc_types[$doc_type] : $doc_type;
    
    $to = get_option('admin_email');
    $subject = 'Nuevo Registro de Mayorista - ' . $company;
    
    $message =  "Se ha registrado un nuevo mayorista:\n\n";
    $message .= "Nombre: $first_name $second_name\n";
    $message .= "Empresa: $company\n";
    $message .= "Correo electrónico: $user->user_email\n";
    $message .= "Teléfono: $phone\n";
    $message .= "Tipo de documento: $doc_type_name\n";
    $message .= "Número de documento: $doc_number\n\n";
    $message .= "Para aprobar o rechazar este registro, accede al panel de administración de WordPress.\n\n";
    $message .= "Enlace directo: " . admin_url('user-edit.php?user_id=' . $user_id);
    
    wp_mail($to, $subject, $message);
}


/**
 * Notificar al usuario cuando su cuenta es aprobada
 */
function wiwu_enviar_email_al_mayorista_aprovado($user_id) {
    // Sanitize user ID
    $message = '';

    // Get and sanitize status
    $status = sanitize_text_field(get_user_meta($user_id, 'wholesale_account_status', true));
    if (empty($status)) return;

    // Set email from name filter (applies to both cases)
    add_filter('wp_mail_from_name', function($name) {
        return esc_html__('Wiwu Colombia', 'text-domain');
    });

    // Get user data
    $user = get_userdata($user_id);
    if (!$user) return;

    // Common variables
    
    $blog_name = esc_html(get_bloginfo('name'));
    
    if ($status === 'approved') {
        $subject = esc_html__('Tu cuenta de mayorista ha sido aprobada', 'text-domain');
        $message = wiwu_mensaje_email_mayorista_aprovado($user_id,$blog_name);
    } elseif ($status === 'rejected') {
        $subject = esc_html__('Tu cuenta de mayorista ha sido rechazada', 'text-domain');
        $message = wiwu_mensaje_email_mayorista_rechazado();
    } else {
        return; // Invalid status
    }

    // Send email
    wp_mail(
        sanitize_email($user->user_email),
        $subject,
        $message
    );
}

add_action('profile_update', 'wiwu_enviar_email_al_mayorista_aprovado');

function wiwu_mensaje_email_mayorista_aprovado($user_id,$blog_name){
    $message = '';
    $company = sanitize_text_field(get_user_meta($user_id, 'wholesale_company', true));
    $first_name = sanitize_text_field(get_user_meta($user_id, 'first_name', true));

    $message = sprintf(
        esc_html__("Hola %s,\n\n", 'text-domain'),
        $first_name
    );
    $message .= sprintf(
        esc_html__("Nos complace informarte que tu registro como mayorista para %s ha sido aprobado.\n\n", 'text-domain'),
        $company
    );
    /*$message .= esc_html__("Ahora puedes acceder a tu cuenta y disfrutar de los beneficios exclusivos para mayoristas.\n", 'text-domain');
    $message .= sprintf(
        esc_html__("Puedes iniciar sesión aquí: %s\n\n", 'text-domain'),
        $login_url
    ); */

    $user = get_userdata(54);
    $login_url = esc_url(wp_login_url());
    $password_set_link = '';

    $key = get_password_reset_key($user);
    if (!is_wp_error($key)) {
        $password_set_link = esc_url(network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login'));
    }


    if (!empty($password_set_link)) {
        $message .= esc_html__("Por favor, establece tu contraseña usando el siguiente enlace:\n", 'text-domain');
        $message .= $password_set_link . "\n\n";
        $message .= esc_html__("Después de establecer tu contraseña, podrás acceder a tu cuenta y disfrutar de los beneficios exclusivos para mayoristas.\n", 'text-domain');
    } else {
        $message .= esc_html__("Ahora puedes acceder a tu cuenta y disfrutar de los beneficios exclusivos para mayoristas.\n", 'text-domain');
        $message .= sprintf(
            esc_html__("Puedes iniciar sesión aquí: %s\n\n", 'text-domain'),
            $login_url
        );
    }
    $message .= esc_html__("Si tienes alguna pregunta, no dudes en contactarnos.\n\n", 'text-domain');
    $message .= sprintf(
        esc_html__("Atentamente,\n%s", 'text-domain'),
        $blog_name);
        return $message; 
}

function wiwu_mensaje_email_mayorista_rechazado(){   
    $message = '';
    $first_name = sanitize_text_field(get_user_meta($user_id, 'first_name', true));
        $message = sprintf(
            esc_html__("Hola %s,\n\n", 'text-domain'),
            $first_name
        );
        $message .= esc_html__("Su solicitud ha sido rechazada.\n\n", 'text-domain');
        $message .= esc_html__("Por favor, comuníquese con nosotros.", 'text-domain');
        return $message; 
}

function mostrar_informacion(){
    $user = get_userdata(54);
    $login_url = esc_url(wp_login_url());
    $password_set_link = '';
    $status = sanitize_text_field(get_user_meta(54, 'wholesale_account_status', true));

    $key = get_password_reset_key($user);
    if (!is_wp_error($key)) {
        $password_set_link = esc_url(network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login'));
    }


    $message  = '';
    if (!empty($password_set_link)) {
        $message .= esc_html__("Por favor, establece tu contraseña usando el siguiente enlace:\n", 'text-domain');
        $message .= $password_set_link . "\n\n";
        $message .= esc_html__("Después de establecer tu contraseña, podrás acceder a tu cuenta y disfrutar de los beneficios exclusivos para mayoristas.\n", 'text-domain');
    } else {
        $message .= esc_html__("Ahora puedes acceder a tu cuenta y disfrutar de los beneficios exclusivos para mayoristas.\n", 'text-domain');
        $message .= sprintf(
            esc_html__("Puedes iniciar sesión aquí: %s\n\n", 'text-domain'),
            $login_url
        );
    }
    echo $status;
}

//add_action( 'wp_footer', 'mostrar_informacion' );