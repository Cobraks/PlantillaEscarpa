<?php
/**
* Importamos los formularios de contacto
* @package gv360
*/
// Proteger contra el acceso directo al archivo y definir las constantes
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );
function import_cf7_forms_from_xml() {
    // Define la ruta del archivo XML
    $xml_file_path = GV360_PLUGIN_DIR . 'includes/default-data/formularios_cf7.xml';

    // Carga el archivo XML
    $xml = simplexml_load_file( $xml_file_path );

    // Verifica si se ha cargado el archivo XML correctamente
    if ( $xml === false ) {
        error_log( 'Error al cargar el archivo XML: ' . $xml_file_path );
        return;
    }

    // Recorre cada formulario en el archivo XML
    foreach ( $xml->channel->item as $item ) {
        // Obtén los datos del formulario
        $form_title = (string) $item->title;
        $form_content = (string) $item->children( 'content', true )->encoded;
        $form_meta = array();

        // Obtén los metadatos del formulario
        foreach ( $item->children( 'wp', true ) as $meta ) {
            if ( $meta->getName() === 'postmeta' ) {
                $meta_key = (string) $meta->meta_key;
                $meta_value = (string) $meta->meta_value;

                // Imprime el valor de los metadatos
                error_log( "Valor de los metadatos '$meta_key': " . print_r( $meta_value, true ) );

                // Convierte el valor en un objeto PHP
                $form_meta[ $meta_key ] = json_decode( $meta_value, true );
            }
        }

        // Registra un mensaje de registro con los metadatos del formulario
        error_log( "Metadatos del formulario '$form_title': " . print_r( $form_meta, true ) );

        // Crea una nueva publicación personalizada para el formulario
        $post_id = wp_insert_post( array(
            'post_title' => $form_title,
            'post_content' => $form_content,
            'post_type' => 'wpcf7_contact_form',
            'post_status' => 'publish'
        ) );

        // Verifica si se ha creado la publicación personalizada correctamente
        if ( is_wp_error( $post_id ) ) {
            error_log( "Error al crear el formulario '$form_title': " . $post_id->get_error_message() );
            continue;
        }

        // Agrega los metadatos del formulario a la publicación personalizada
        foreach ( $form_meta as $key => $value ) {
            // Serializa el valor de los metadatos si es necesario
            if ( is_array( $value ) || is_object( $value ) ) {
                $value = serialize( $value );
            }

            add_post_meta( $post_id, $key, maybe_unserialize($value), true );
        }

        // Registra un mensaje de registro para indicar que se ha importado un formulario
        error_log( "Se ha importado el formulario '$form_title' con ID: $post_id" );
    }
}

