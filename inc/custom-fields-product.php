<?php

/*=============================================================
*         METABOXES PAGINA DE SERVICIOS
==============================================================*/

add_action( 'cmb2_admin_init', 'wiwu_product_metaboxes' );
/**
 * Hook in and add a metabox that only appears on the 'About' page
 */
function wiwu_product_metaboxes() {
	/**
	 * Metabox to be displayed on a single page ID
	 */
	$prefix = 'wiwu_product_';

	/**
	 * Metabox to be displayed on a single page ID
	 */
	$wiwuProductMetabox = new_cmb2_box( array(
		'id'           => $prefix.'metabox',
		'title'        => esc_html__( 'Información adicional del Producto', 'cmb2' ),
		'object_types' => array( 'product' ),
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true, // Show field names on the left
	) ); 

	$wiwuProductMetabox->add_field( array(
		'name'    => 'Imagen secundaria del Producto',
		'desc'    => 'Sube una imagen relacionada con este producto.',
		'id'      => $prefix . 'imagen_producto', // ID único del campo
		'type'    => 'file',  // Tipo de campo (archivo)
		'options' => array(
			'url' => false, // Desactiva la URL para evitar que se pegue el enlace directamente
		),
		'text' => array(
			'add_upload_file_text' => 'Subir Imagen', // Texto del botón
		),
	) );
	/* ==========================================================
	*  BANNER
	*  ==========================================================*/
	$wiwuProductMetabox = new_cmb2_box( array(
		'id'           => $prefix.'banners_metabox',
		'title'        => esc_html__( 'Configuración Banners', 'cmb2' ),
		'object_types' => array( 'product' ),
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true, // Show field names on the left

	) );

	$wiwuProductMetabox->add_field( array(
        'name'    => 'Tamaño letra del titulo',
        'id'      => $prefix.'tamano_letra',
        'type'    => 'select',
        'options' => array(
            'muy_grande'  => __('Muy Grande', 'textdomain'),
            'grande'  => __('Grande', 'textdomain'),
            'mediano' => __('Mediano', 'textdomain'),
            'pequeno' => __('Pequeño', 'textdomain'),
            'muy-pequeno' => __('Muy Pequeño', 'textdomain'),
        ),
        'default' => 'muy-pequeno',
    ));


	$wiwuProductMetabox->add_field( array(
		'name'    => 'Imagen principal para Para desktop',
		'desc'    => 'Sube una imagen relacionada con este producto.',
		'id'      => $prefix . 'banner_desktop_principal', // ID único del campo
		'type'    => 'file',  // Tipo de campo (archivo)
		'options' => array(
			'url' => false, // Desactiva la URL para evitar que se pegue el enlace directamente
		),
		'text' => array(
			'add_upload_file_text' => 'Subir Imagen', // Texto del botón
		),
	) );

	$wiwuProductMetabox->add_field( array(
		'name'    => 'Imagen principal para Para celular',
		'desc'    => 'Sube una imagen relacionada con este producto.',
		'id'      => $prefix . 'banner_mobile_principal', // ID único del campo
		'type'    => 'file',  // Tipo de campo (archivo)
		'options' => array(
			'url' => false, // Desactiva la URL para evitar que se pegue el enlace directamente
		),
		'text' => array(
			'add_upload_file_text' => 'Subir Imagen', // Texto del botón
		),
	) );


	/*
	$wiwuProductMetabox->add_field( array(
        'id'   => $prefix.'infoadi_2_textos_informacion_adicional',
        'type'        => 'group',
        //'description' => __( 'Textos', 'cmb2' ),
        'options'     => array(
            'group_title'       => __( 'Texto {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'        => __( 'Nueva sección', 'cmb2' ),
            'remove_button'     => __( 'Eliminar', 'cmb2' ),
            'sortable'          => true,
            // 'closed'         => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
        ),
    ) ); 

	$wiwuProductMetabox->add_group_field( $prefix.'infoadi_2_textos_informacion_adicional', array(
		'name'       => __( 'Texto', 'cmb2' ),
		'id'         => $prefix . 'infoadi_2_texto_descripcion',
		'type'       => 'wysiwyg',
		'options'    => array(
            'textarea_rows' => 6, // Número de filas del área de texto
        ),
	) );  
	*/


	$wiwuProductMetabox->add_field(array(
        'id'          => $prefix . 'grupo_color',
        'type'        => 'group',
        'description' => __('Añade imágenes y selecciona su color.', 'cmb2'),
        'options'     => array(
            'group_title'   => __('Imagen {#}', 'cmb2'),
            'add_button'    => __('Añadir Imagen', 'cmb2'),
            'remove_button' => __('Eliminar Imagen', 'cmb2'),
            'sortable'      => true,
        ),
    ));

    // Campo de imagen
	$wiwuProductMetabox->add_group_field($prefix . 'grupo_color', array(
        'name' => __('Imagen', 'cmb2'),
        'id'   =>  $prefix . 'imagen_color',
        'type' => 'file',
        'options' => array(
            'url' => false,
        ),
        'text' => array(
            'add_upload_file_text' => __('Subir Imagen', 'cmb2'),
        ),
    ));

	$color_options = wiwu_obtener_colores_producto();

    // Campo select con valores dinámicos del atributo "color"
	$wiwuProductMetabox->add_group_field($prefix . 'grupo_color', array(
        'name'    => __('Color', 'cmb2'),
        'id'      => $prefix . 'nombre_color',
        'type'    => 'select',
        'options' => $color_options,
    ));  


	/* ==========================================================
	*  SECCION 1
	*  ==========================================================*/

	$wiwuProductMetabox = new_cmb2_box( array(
		'id'           => $prefix.'infoadi_1_metabox',
		'title'        => esc_html__( 'Sección 1', 'cmb2' ),
		'object_types' => array( 'product' ),
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true, // Show field names on the left

	) ); 



	$wiwuProductMetabox->add_field( array(
		'name'    => 'Título',
		'desc'    => 'Este es el campo para el título. Por defecto aparece el titulo Información adicional',
		'id'      => $prefix . 'infoadi_1_titulo', // ID único del campo
		'type'    => 'text',  // Tipo de campo (texto)
		'sanitization_cb' => '_sanitize_text_fields',
		'default' => 'Información adicional', // Valor predeterminado
	) );

	$wiwuProductMetabox->add_field( array(
        'id'   => $prefix.'infoadi_1_textos_informacion_adicional',
        'type'        => 'group',
        //'description' => __( 'Textos', 'cmb2' ),
        'options'     => array(
            'group_title'       => __( 'Texto {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'        => __( 'Nueva sección', 'cmb2' ),
            'remove_button'     => __( 'Eliminar', 'cmb2' ),
            'sortable'          => true,
            // 'closed'         => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
        ),
    ) ); 

	$wiwuProductMetabox->add_field( array(
		'name'    => 'Imagen principal',
		'desc'    => 'Sube una imagen relacionada con este producto.',
		'id'      => $prefix . 'infoadi_1_imagen_principal', // ID único del campo
		'type'    => 'file',  // Tipo de campo (archivo)
		'options' => array(
			'url' => false, // Desactiva la URL para evitar que se pegue el enlace directamente
		),
		'text' => array(
			'add_upload_file_text' => 'Subir Imagen', // Texto del botón
		),
	) );

	$wiwuProductMetabox->add_field( array(
		'name'    => 'Imagen secundaria',
		'desc'    => 'Sube una imagen relacionada con este producto.',
		'id'      => $prefix . 'infoadi_1_imagen_secundaria', // ID único del campo
		'type'    => 'file',  // Tipo de campo (archivo)
		'options' => array(
			'url' => false, // Desactiva la URL para evitar que se pegue el enlace directamente
		),
		'text' => array(
			'add_upload_file_text' => 'Subir Imagen', // Texto del botón
		),
	) );

	$wiwuProductMetabox->add_group_field( $prefix.'infoadi_1_textos_informacion_adicional', array(
		'name'       => __( 'Texto', 'cmb2' ),
		'id'         => $prefix . 'infoadi_1_texto_descripcion',
		'type'       => 'wysiwyg',
		'options'    => array(
            'textarea_rows' => 6, // Número de filas del área de texto
        ),
	) );  



	$wiwuProductMetabox = new_cmb2_box( array(
		'id'           => $prefix.'infoadi_2_metabox',
		'title'        => esc_html__( 'Sección 2', 'cmb2' ),
		'object_types' => array( 'product' ),
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true, // Show field names on the left

	) ); 


	$wiwuProductMetabox->add_field( array(
        'id'   => $prefix.'infoadi_2_textos_informacion_adicional',
        'type'        => 'group',
        //'description' => __( 'Textos', 'cmb2' ),
        'options'     => array(
            'group_title'       => __( 'Texto {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'        => __( 'Nueva sección', 'cmb2' ),
            'remove_button'     => __( 'Eliminar', 'cmb2' ),
            'sortable'          => true,
            // 'closed'         => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
        ),
    ) ); 

	$wiwuProductMetabox->add_group_field( $prefix.'infoadi_2_textos_informacion_adicional', array(
		'name'       => __( 'Texto', 'cmb2' ),
		'id'         => $prefix . 'infoadi_2_texto_descripcion',
		'type'       => 'wysiwyg',
		'options'    => array(
            'textarea_rows' => 6, // Número de filas del área de texto
        ),
	) );  

	$wiwuProductMetabox->add_field( array(
		'name'    => 'Imagen principal',
		'desc'    => 'Sube una imagen relacionada con este producto.',
		'id'      => $prefix . 'infoadi_2_imagen_principal', // ID único del campo
		'type'    => 'file',  // Tipo de campo (archivo)
		'options' => array(
			'url' => false, // Desactiva la URL para evitar que se pegue el enlace directamente
		),
		'text' => array(
			'add_upload_file_text' => 'Subir Imagen', // Texto del botón
		),
	) );

	$wiwuProductMetabox->add_field( array(
		'name'    => 'Imagen secundaria',
		'desc'    => 'Sube una imagen relacionada con este producto.',
		'id'      => $prefix . 'infoadi_2_imagen_secundaria', // ID único del campo
		'type'    => 'file',  // Tipo de campo (archivo)
		'options' => array(
			'url' => false, // Desactiva la URL para evitar que se pegue el enlace directamente
		),
		'text' => array(
			'add_upload_file_text' => 'Subir Imagen', // Texto del botón
		),
	) );

	$wiwuProductMetabox = new_cmb2_box( array(
		'id'           => $prefix.'seccion_1_metabox',
		'title'        => esc_html__( 'Sección Informativa 1', 'cmb2' ),
		'object_types' => array( 'product' ),
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true, // Show field names on the left

	) ); 

	$wiwuProductMetabox->add_field( array(
		'name'    => 'Icono',
		'desc'    => 'Sube una imagen relacionada con este producto.',
		'id'      => $prefix . 'seccion_1_icono', // ID único del campo
		'type'    => 'file',  // Tipo de campo (archivo)
		'options' => array(
			'url' => false, // Desactiva la URL para evitar que se pegue el enlace directamente
		),
		'text' => array(
			'add_upload_file_text' => 'Subir Imagen', // Texto del botón
		),
	) );

	$wiwuProductMetabox->add_field( array(
		'name'    => 'Titulo',
		//'desc'    => 'Este es el campo para el título. Por defecto aparece el titulo Información adicional',
		'id'      => $prefix . 'seccion_1_titulo', // ID único del campo
		'type'    => 'text',  // Tipo de campo (texto)
		'sanitization_cb' => '_sanitize_text_fields',
		//'default' => 'Información adicional', // Valor predeterminado
	) );
	
	$wiwuProductMetabox->add_field( array(
		'name'       => __( 'Texto', 'cmb2' ),
		'id'         => $prefix . 'seccion_1_texto',
		'type'       => 'wysiwyg',
		'options'    => array(
            'textarea_rows' => 6, // Número de filas del área de texto
        ),
	) );  

	$wiwuProductMetabox = new_cmb2_box( array(
		'id'           => $prefix.'seccion_2_metabox',
		'title'        => esc_html__( 'Sección Informativa 2', 'cmb2' ),
		'object_types' => array( 'product' ),
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true, // Show field names on the left

	) ); 

	$wiwuProductMetabox->add_field( array(
		'name'    => 'Icono',
		'desc'    => 'Sube una imagen relacionada con este producto.',
		'id'      => $prefix . 'seccion_2_icono', // ID único del campo
		'type'    => 'file',  // Tipo de campo (archivo)
		'options' => array(
			'url' => false, // Desactiva la URL para evitar que se pegue el enlace directamente
		),
		'text' => array(
			'add_upload_file_text' => 'Subir Imagen', // Texto del botón
		),
	) );

	$wiwuProductMetabox->add_field( array(
		'name'    => 'Titulo',
		//'desc'    => 'Este es el campo para el título. Por defecto aparece el titulo Información adicional',
		'id'      => $prefix . 'seccion_2_titulo', // ID único del campo
		'type'    => 'text',  // Tipo de campo (texto)
		'sanitization_cb' => '_sanitize_text_fields',
		//'default' => 'Información adicional', // Valor predeterminado
	) );
	
	$wiwuProductMetabox->add_field( array(
		'name'       => __( 'Texto', 'cmb2' ),
		'id'         => $prefix . 'seccion_2_texto',
		'type'       => 'wysiwyg',
		'options'    => array(
            'textarea_rows' => 6, // Número de filas del área de texto
        ),
	) );  

	
}


/* =========================================================================
*   LLAMA LOS KEYWORDS A LAS PAGINAS Y POST
*  =========================================================================*/
//add_action( 'cmb2_admin_init', 'md_bb_keywords_metaboxes' );
/**
 * Hook in and add a metabox that only appears on the 'About' page
 */
function md_bb_keywords_metaboxes() {
	/**
	 * Metabox to be displayed on a single page ID
	 */
	$prefix = 'delage_campos_';

	/**
	 * Metabox to be displayed on a single page ID
	 */
	$md_bb_blog_mb = new_cmb2_box( array(
		'id'           => $prefix.'keywords_metabox',
		'title'        => esc_html__( 'Keywords - palabras Clave', 'cmb2' ),
		'object_types' => array( 'post','page' ),
		//'show_on'      => array( 'key' => 'page', 'value' => 'servicios' ),
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true, // Show field names on the left
	) ); 

	$md_bb_blog_mb->add_field( array(
		'name'       => __( 'Keywords', 'cmb2' ),
		'desc'       => __( 'Agregue las keywords o palabras clave que desee. Sí son dos o mas se debe de agregar una coma(,) sin espacios para separarlas. ej, palabra1,palabra2,palabra3.', 'cmb2' ),
		'id'         => $prefix . 'keywords',
		'type'       => 'textarea',

	) );

	  $md_bb_servicios_mb->add_field( array(
        'id'   => $prefix.'posiciones_grupo',
        'type'        => 'group',
        'description' => __( 'Seleccion', 'cmb2' ),
        // 'repeatable'  => false, // use false if you want non-repeatable group
        'options'     => array(
            'group_title'       => __( 'Sección {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'        => __( 'Nueva sección', 'cmb2' ),
            'remove_button'     => __( 'Eliminar', 'cmb2' ),
            'sortable'          => true,
            // 'closed'         => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
        ),
    ) ); 

 	$md_bb_servicios_mb->add_group_field( $prefix.'posiciones_grupo', array(
		'name'       => __( 'Nombre', 'cmb2' ),
		'desc'       => __( 'Seleccione un nombre del servicio. si selecciona "sin servicio" tomara el espacio en blanco.', 'cmb2' ),
		'id'         => $prefix . 'post_category',
		'type'       => 'select',
		'options_cb' => 'cc_cmb2_opcionesCategoria',
	) ); 
}


function wiwu_obtener_colores_producto() {

	if( !function_exists('get_taxonomy') || !function_exists('get_terms')):
		return false;
	endif;
	$attribute = '';
	$attribute = get_taxonomy('pa_colores');

	if ($attribute) :
		$color_options = array();
		$terms = get_terms(array(
			'taxonomy' => 'pa_colores',
			'hide_empty' => false,
		));
		
		if (!empty($terms) && !is_wp_error($terms)) :
			foreach ($terms as $term) :
				if ($term instanceof WP_Term) :
					$slug = sanitize_title($term->slug);
					$name = esc_html($term->name);

					if($slug && $name):
						$color_options[$slug] = $name;
					endif;
				endif;
			endforeach;
			return $color_options;
	
		endif;

	endif;
}