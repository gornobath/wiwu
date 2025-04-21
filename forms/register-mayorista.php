<?php defined( 'ABSPATH' ) || exit;
/**
 * Shortcode para formulario de registro de mayoristas
 */
function wholesale_registration_form_shortcode() {
    // Solo mostrar el formulario si el usuario no está logueado
    if (!is_user_logged_in()) {
        ob_start();
        
        // Mostrar mensajes de error/éxito
        if (isset($_GET['registration']) && $_GET['registration'] == 'success') {
            echo '<div class="wholesale-registration-success">¡Registro exitoso! Pronto estaremos en contacto contigo.</div>';
        }
        
        // Mostrar errores si existen
        if (isset($_GET['errors'])) {
            $error_codes = explode(',', $_GET['errors']);
            echo '<div class="wholesale-registration-errors">';
            foreach ($error_codes as $error_code) {
                switch ($error_code) {
                    case 'empty_fields':
                        echo '<p class="wiwu-texto">Por favor completa todos los campos obligatorios.</p>';
                        break;
                    case 'email_invalid':
                        echo '<p class="wiwu-texto">El correo electrónico no es válido.</p>';
                        break;
                    case 'email_exists':
                        echo '<p class="wiwu-texto">Este correo electrónico ya está registrado.</p>';
                        break;
                    case 'phone_invalid':
                        echo '<p class="wiwu-texto">El número de teléfono no es válido.</p>';
                        break;
                    case 'rut_invalid':
                        echo '<p class="wiwu-texto">El RUT no es válido.</p>';
                        break;
                    default:
                        echo '<p class="wiwu-texto">Ocurrió un error durante el registro.</p>';
                        break;
                }
            }
            echo '</div>';
        }
        ?>
        
        <form id="wholesale-registration-form" class="woocommerce-form woocommerce-form-register register" method="post">
            
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="wholesale_first_name">Primer nombre<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="first_name" id="wholesale_first_name" value="<?php echo (!empty($_POST['first_name'])) ? esc_attr($_POST['first_name']) : ''; ?>" required />
            </p>
            
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="wholesale_second_name">Segundo nombre</label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="second_name" id="wholesale_second_name" value="<?php echo (!empty($_POST['second_name'])) ? esc_attr($_POST['second_name']) : ''; ?>" />
            </p>
            
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="wholesale_email">Correo electrónico<span class="required">*</span></label>
                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="wholesale_email" value="<?php echo (!empty($_POST['email'])) ? esc_attr($_POST['email']) : ''; ?>" required />
            </p>
            
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="wholesale_phone">Teléfono<span class="required">*</span></label>
                <input type="tel" class="woocommerce-Input woocommerce-Input--text input-text" name="phone" id="wholesale_phone" value="<?php echo (!empty($_POST['phone'])) ? esc_attr($_POST['phone']) : ''; ?>" required />
            </p>
            
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="wholesale_doc_type">Tipo de documento<span class="required">*</span></label>
                <select class="woocommerce-Input woocommerce-Input--select input-select" name="doc_type" id="wholesale_doc_type" required>
                    <option value="">Seleccionar...</option>
                    <option value="camara_comercio" <?php selected(!empty($_POST['doc_type']) && $_POST['doc_type'] == 'camara_comercio'); ?>>Cámara de comercio</option>
                    <option value="rut" <?php selected(!empty($_POST['doc_type']) && $_POST['doc_type'] == 'rut'); ?>>RUT</option>
                    <option value="cedula_representante" <?php selected(!empty($_POST['doc_type']) && $_POST['doc_type'] == 'cedula_representante'); ?>>Cédula representante legal</option>
                </select>
            </p>
            
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="wholesale_doc_number">Número de documento<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="doc_number" id="wholesale_doc_number" value="<?php echo (!empty($_POST['doc_number'])) ? esc_attr($_POST['doc_number']) : ''; ?>" required />
            </p>
            
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="wholesale_company">Nombre de la empresa<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="company" id="wholesale_company" value="<?php echo (!empty($_POST['company'])) ? esc_attr($_POST['company']) : ''; ?>" required />
            </p>
            
            <p class="woocommerce-form-row form-row">
                <?php wp_nonce_field('wholesale-register', 'wholesale-register-nonce'); ?>
                <button type="submit" class="woocommerce-Button button" name="register" value="Registrarse">
                    <span class="button-text">Registrarse</span>
                    <span class="loading-spinner" style="display:none;">
                        <span class="spinner"></span>
                    </span>
                </button>
            </p>
        </form>
        
        <script>
        jQuery(document).ready(function($) {
            $('#wholesale-registration-form').on('submit', function(e) {
                e.preventDefault();
                
                var $form = $(this);
                var $button = $form.find('button[type="submit"]');
                var $buttonText = $button.find('.button-text');
                var $spinner = $button.find('.loading-spinner');
                
                // Mostrar spinner y deshabilitar botón
                $buttonText.text('Registrando...');
                $spinner.show();
                $button.prop('disabled', true);
                
                // Enviar datos por AJAX
                $.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: 'wholesale_register_user',
                        first_name: $form.find('#wholesale_first_name').val(),
                        second_name: $form.find('#wholesale_second_name').val(),
                        email: $form.find('#wholesale_email').val(),
                        phone: $form.find('#wholesale_phone').val(),
                        doc_type: $form.find('#wholesale_doc_type').val(),
                        doc_number: $form.find('#wholesale_doc_number').val(),
                        company: $form.find('#wholesale_company').val(),
                        security: $form.find('#wholesale-register-nonce').val()
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '<?php echo add_query_arg('registration', 'success', get_permalink()); ?>';
                        } else {
                            // Mostrar errores
                            if (response.data.errors) {
                                var errorParams = response.data.errors.join(',');
                                window.location.href = '<?php echo add_query_arg('errors', 'PLACEHOLDER', get_permalink()); ?>'.replace('PLACEHOLDER', errorParams);
                            }
                        }
                    },
                    complete: function() {
                        $buttonText.text('Registrarse');
                        $spinner.hide();
                        $button.prop('disabled', false);
                    }
                });
            });
        });
        </script>
        
        <style>
        .loading-spinner .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .wholesale-registration-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .wholesale-registration-errors {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        </style>
        <?php
        
        return ob_get_clean();
    } else {
        return '<p class="wiwu-texto">Ya estás registrado y has iniciado sesión.</p>';
    }
}
add_shortcode('wholesale_registration_form', 'wholesale_registration_form_shortcode');

/**
 * Procesar el registro del mayorista via AJAX
 */
function wholesale_register_user_ajax() {
    check_ajax_referer('wholesale-register', 'security');
    
    $errors = array();
    
    // Validar campos obligatorios
    $required_fields = array(
        'first_name' => 'Primer nombre',
        'email' => 'Correo electrónico',
        'phone' => 'Teléfono',
        'doc_type' => 'Tipo de documento',
        'doc_number' => 'Número de documento',
        'company' => 'Nombre de la empresa'
    );
    
    foreach ($required_fields as $field => $name) {
        if (empty($_POST[$field])) {
            $errors[] = 'empty_fields';
            break;
        }
    }
    
    if (!is_email($_POST['email'])) {
        $errors[] = 'email_invalid';
    }
    
    if (email_exists($_POST['email'])) {
        $errors[] = 'email_exists';
    }
    
    // Validación básica de teléfono (puedes ajustarla)
    if (!preg_match('/^[0-9\-\+\(\)\s]{7,20}$/', $_POST['phone'])) {
        $errors[] = 'phone_invalid';
    }
    
    // Validación básica de RUT/documento (puedes ajustarla)
    if (!preg_match('/^[0-9\-\.]{4,20}$/', $_POST['doc_number'])) {
        $errors[] = 'rut_invalid';
    }
    
    // Si hay errores, devolverlos
    if (!empty($errors)) {
        wp_send_json_error(array('errors' => array_unique($errors)));
    }
    
    // Generar contraseña aleatoria
    $password = wp_generate_password(12, true);
    
    // Crear usuario (inactivo por defecto)
    $user_id = wp_create_user($_POST['email'], $password, $_POST['email']);
    
    if (is_wp_error($user_id)) {
        $errors[] = 'registration_failed';
        wp_send_json_error(array('errors' => $errors));
    }
    
    // Actualizar campos del usuario
    wp_update_user(array(
        'ID' => $user_id,
        'first_name' => sanitize_text_field($_POST['first_name']),
        'last_name' => sanitize_text_field(!empty($_POST['second_name']) ? $_POST['second_name'] : ''),
        'role' => 'mayorista' // Rol personalizado para mayoristas
    ));
    
    // Guardar meta datos adicionales
    update_user_meta($user_id, 'wholesale_phone', sanitize_text_field($_POST['phone']));
    update_user_meta($user_id, 'wholesale_doc_type', sanitize_text_field($_POST['doc_type']));
    update_user_meta($user_id, 'wholesale_doc_number', sanitize_text_field($_POST['doc_number']));
    update_user_meta($user_id, 'wholesale_company', sanitize_text_field($_POST['company']));
    update_user_meta($user_id, 'wholesale_account_status', 'pending'); // Estado pendiente de aprobación
    
    // Enviar correo al usuario
    wiwu_enviar_email_a_mayorista_registrado($user_id, $password);
    
    // Enviar correo al administrador
    wiwu_enviar_email_registro_mayorista_a_admin($user_id);
    
    wp_send_json_success();
}
add_action('wp_ajax_nopriv_wholesale_register_user', 'wholesale_register_user_ajax');

/**
 * Añadir campo de estado de cuenta mayorista al perfil de usuario
 */
function add_wholesale_account_status_field($user) {
    if (!current_user_can('edit_users')) return;
    
    $status = get_user_meta($user->ID, 'wholesale_account_status', true);
    ?>
    <h3>Estado de Cuenta Mayorista</h3>
    <table class="form-table">
        <tr>
            <th><label for="wholesale_account_status">Estado</label></th>
            <td>
                <select name="wholesale_account_status" id="wholesale_account_status">
                    <option value="pending" <?php selected($status, 'pending'); ?>>Pendiente</option>
                    <option value="approved" <?php selected($status, 'approved'); ?>>Aprobado</option>
                    <option value="rejected" <?php selected($status, 'rejected'); ?>>Rechazado</option>
                </select>
                <p class="description">Cambia el estado de la cuenta mayorista.</p>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'add_wholesale_account_status_field');
add_action('edit_user_profile', 'add_wholesale_account_status_field');

/**
 * Guardar campo de estado de cuenta mayorista
 */
function save_wholesale_account_status_field($user_id) {
    if (!current_user_can('edit_user', $user_id)) return;
    
    if (isset($_POST['wholesale_account_status'])) {
        update_user_meta($user_id, 'wholesale_account_status', sanitize_text_field($_POST['wholesale_account_status']));
    }
}
add_action('personal_options_update', 'save_wholesale_account_status_field');
add_action('edit_user_profile_update', 'save_wholesale_account_status_field');