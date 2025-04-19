jQuery(document).ready(function($) {

    /*  ================================================================== 
    *     CUANDO EL ADMINISTRADOR CAMBIA EL ESTADO DEL MAYORISTA A APROBADO
    *     SE GENERA LA ACION DEL AJAX PARA ENVIAR UN CORREO AL MAYORISTA QUE
    *     FUE APROBADO Y QUE CAMBIE LA CONTRASEÑA
    *   ================================================================== */
    if($('#wholesale_account_status').length > 0){
        $('#wholesale_account_status').on('change', function() {
            var opcionActual = $(this).find('option:selected').val();
            if(opcionActual == 'approved') {
                var idDestinatario = $('#user_id').val();
                $('#submit').on('click',function(){
                    $.ajax({
                        url: admin_url.ajax_url,
                        type: "POST",
                        data: {
                            action: "wiwu_mensaje_email_mayorista_aprovado",
                            idDestinatario: idDestinatario,
                            nonce: admin_url.nonce
                        },
                        success: function(response) {
                            if(response.success) {
                                alert(response.data);
                            } else {
                                alert('Error: ' + response.data);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Error en la petición: ' + error);
                        }
                    }); 
                })
            }
        });
    }
});