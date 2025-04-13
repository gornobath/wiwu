<?php defined( 'ABSPATH' ) || exit;

function custom_registration_form_shortcode() {
    // Solo mostrar el formulario si el usuario no está logueado
    if (!is_user_logged_in()) {
        ob_start();
        
        // Mostrar mensajes de error/éxito
        if (isset($_GET['registration']) && $_GET['registration'] == 'success') {
            echo '<div class="registration-success">¡Registro exitoso! Por favor revisa tu correo electrónico.</div>';
        }
        
        // Mostrar errores si existen
        if (isset($_GET['errors'])) {
            $error_codes = explode(',', $_GET['errors']);
            echo '<div class="registration-errors">';
            foreach ($error_codes as $error_code) {
                switch ($error_code) {
                    case 'empty_fields':
                        echo '<p>Por favor completa todos los campos.</p>';
                        break;
                    case 'email_invalid':
                        echo '<p>El correo electrónico no es válido.</p>';
                        break;
                    case 'email_exists':
                        echo '<p>Este correo electrónico ya está registrado.</p>';
                        break;
                    case 'password_length':
                        echo '<p>La contraseña debe tener al menos 6 caracteres.</p>';
                        break;
                    default:
                        echo '<p>Ocurrió un error durante el registro.</p>';
                        break;
                }
            }
            echo '</div>';
        }
        ?>
        
        <form id="custom-registration-form" class="woocommerce-form woocommerce-form-register wiwu-woocommerce-form register" method="post">
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_first_name">Nombre</label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="first_name" id="reg_first_name" value="" required />
            </p>
            
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_last_name">Apellido</label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="last_name" id="reg_last_name" value="" required />
            </p>
            
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_email">Correo electrónico</label>
                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="" required />
            </p>
            
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_password">Contraseña</label>
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" required />
            </p>
            
            <p class="woocommerce-form-row form-row form-row-boton">
                <?php wp_nonce_field('custom-register', 'custom-register-nonce'); ?>
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
            $('#custom-registration-form').on('submit', function(e) {
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
                        action: 'custom_register_user',
                        first_name: $form.find('#reg_first_name').val(),
                        last_name: $form.find('#reg_last_name').val(),
                        email: $form.find('#reg_email').val(),
                        password: $form.find('#reg_password').val(),
                        security: $form.find('#custom-register-nonce').val()
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
        

        <?php
        
        return ob_get_clean();
    } else {
        return '<p>Ya estás registrado y has iniciado sesión...</p>';
    }
}
add_shortcode('custom_registration_form', 'custom_registration_form_shortcode');

function custom_register_user_ajax() {
    check_ajax_referer('custom-register', 'security');
    
    $errors = array();
    
    // Validar campos
    if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['password'])) {
        $errors[] = 'empty_fields';
    }
    
    if (!is_email($_POST['email'])) {
        $errors[] = 'email_invalid';
    }
    
    if (email_exists($_POST['email'])) {
        $errors[] = 'email_exists';
    }
    
    if (strlen($_POST['password']) < 6) {
        $errors[] = 'password_length';
    }
    
    // Si hay errores, devolverlos
    if (!empty($errors)) {
        wp_send_json_error(array('errors' => $errors));
    }
    
    // Crear usuario
    $emailSanitizado =  isset($_POST['email']) ? sanitize_email( wp_unslash( $_POST['email'] ) ) :  '';
    $user_id = wp_create_user($emailSanitizado, $_POST['password'], $emailSanitizado);
    
    if (is_wp_error($user_id)) {
        $errors[] = 'registration_failed';
        wp_send_json_error(array('errors' => $errors));
    }
    
    // Actualizar campos adicionales
    wp_update_user(array(
        'ID' => $user_id,
        'first_name' => sanitize_text_field($_POST['first_name']),
        'last_name' => sanitize_text_field($_POST['last_name']),
        'display_name' => sanitize_text_field($_POST['first_name'] . ' ' . $_POST['last_name']),
        'role' => 'customer' // Rol por defecto para WooCommerce
    ));
    
    // Enviar correo de notificación
    wp_new_user_notification($user_id, null, 'both');
    
    // Iniciar sesión automáticamente
    wp_set_auth_cookie($user_id);
    
    wp_send_json_success();
}
add_action('wp_ajax_nopriv_custom_register_user', 'custom_register_user_ajax');
add_action('wp_ajax_custom_register_user', 'custom_register_user_ajax');
