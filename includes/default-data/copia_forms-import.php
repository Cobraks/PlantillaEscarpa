<?php
/**
* Importamos los formularios de contacto
* @package gv360
*/
// Proteger contra el acceso directo al archivo y definir las constantes
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );


//AHORA MISMO SOLO SE CARGA EL TÍTULO Y LA DESCRIPCIÓN. HAY QUE HACER QUE SE CARGUEN TAMBIÉN LAS PLANTILLAS DE CORREO Y LOS FORMULARIOS
/*
function import_cf7_forms() {
    // Carga el archivo XML
    $xml = simplexml_load_file( __DIR__ . '/formularios_cf7.xml' );

    // Agrega un registro de errores para imprimir el contenido del archivo XML
    error_log( 'Contenido del archivo XML: ' . print_r( $xml, true ) );

    // Recorre los elementos del archivo XML
    foreach ( $xml->channel->item as $item ) 
        // Crea un nuevo formulario de contacto
        $form = WPCF7_ContactForm::get_template();
        $form->set_title( $item->title );

        // Agrega un registro de errores para imprimir el título del formulario
        error_log( 'Título del formulario: ' . $item->title );

        // Establece las propiedades del formulario
        $properties = array();
        $properties['form'] = (string) $item->{'content:encoded'};
        foreach ( $item->{'wp:postmeta'} as $postmeta ) {
            if ( isset( $postmeta->{'wp:meta_key'} ) && isset( $postmeta->{'wp:meta_value'} ) ) {
                $key = (string) $postmeta->{'wp:meta_key'};
                if ( substr( $key, 0, 1 ) === '_' ) {
                    $key = substr( $key, 1 );
                }
                if ( in_array( $key, array( 'form', 'mail', 'mail_2', 'messages', 'additional_settings', 'locale' ) ) ) {
                    $value = maybe_unserialize( (string) $postmeta->{'wp:meta_value'} );
                    if ( ! is_null( $value ) ) {
                        $properties[ $key ] = $value;
                    }
                }
            }
        }
        $form->set_properties( $properties );

        // Agrega un registro de errores para imprimir las propiedades del formulario
        error_log( 'Propiedades del formulario: ' . print_r( $properties, true ) );

        // Guarda el formulario
        $form->save();

        // Agrega un registro de errores para indicar que se guardó el formulario
        error_log( 'Formulario guardado: ' . $item->title );
    }
}

*/
/*
function import_cf7_forms_from_xml( $xml_file_path ) {
    // Carga el archivo XML
    $xml = simplexml_load_file( $xml_file_path );

    // Recorre cada elemento del archivo XML
    foreach ( $xml->channel->item as $item ) {
        // Crea un nuevo objeto de formulario
        $form = WPCF7_ContactForm::get_template();

        // Establece el título y la descripción del formulario
        $form->set_title( (string) $item->title );
        $form->set_description( (string) $item->{'wp:post_excerpt'} );

        // Establece las propiedades del formulario
        $properties = array();
        $properties['form'] = (string) $item->{'content:encoded'};
        foreach ( $item->{'wp:postmeta'} as $postmeta ) {
            if ( isset( $postmeta->{'wp:meta_key'} ) && isset( $postmeta->{'wp:meta_value'} ) ) {
                $key = (string) $postmeta->{'wp:meta_key'};
                if ( substr( $key, 0, 1 ) === '_' ) {
                    $key = substr( $key, 1 );
                }
                if ( in_array( $key, array( 'form', 'mail', 'mail_2', 'messages', 'additional_settings', 'locale' ) ) ) {
                    $value = maybe_unserialize( (string) $postmeta->{'wp:meta_value'} );
                    if ( ! is_null( $value ) ) {
                        $properties[ $key ] = $value;
                    }
                }
            }
        }
        $form->set_properties( $properties );

        // Guarda el formulario
        if ( ! empty( $_POST['wpcf7-save'] ) && current_user_can( 'wpcf7_edit_contact_form', $_POST['post_ID'] ) ) {
            check_admin_referer( 'wpcf7-save-contact-form_' . $_POST['post_ID'] );
            if ( ! empty( $_POST['wpcf7-locale'] ) && wpcf7_is_valid_locale( $_POST['wpcf7-locale'] ) ) {
                update_post_meta( $_POST['post_ID'], '_locale', $_POST['wpcf7-locale'] );
            }
            if ( ! empty( $_POST['wpcf7-title'] ) && current_user_can( 'wpcf7_edit_contact_form', $_POST['post_ID'] ) ) {
                wp_update_post(
                    array(
                        'ID' => $_POST['post_ID'],
                        'post_title' => sanitize_text_field( $_POST['wpcf7-title'] ),
                    )
                );
            }
            if ( current_user_can( 'wpcf7_edit_contact_form', $_POST['post_ID'] ) && isset( $_POST['wpcf7-form'] ) && is_array( $_POST['wpcf7-form'] ) && isset( $_POST['wpcf7-form']['form-body'] ) && is_string( $_POST['wpcf7-form']['form-body'] ) && '' !== trim( $_POST['wpcf7-form']['form-body'] ) && isset( $_POST['wpcf7-form']['mail-body'] ) && is_string( $_POST['wpcf7-form']['mail-body'] ) && '' !== trim( $_POST['wpcf7-form']['mail-body'] )
            && isset( $_POST['wpcf7-form']['mail-sender'] )
            && is_string( $_POST['wpcf7-form']['mail-sender'] )
            && '' !== trim( $_POST['wpcf7-form']['mail-sender'] )
            && isset( $_POST['wpcf7-form']['mail-subject'] )
            && is_string( $_POST['wpcf7-form']['mail-subject'] )
            && '' !== trim( $_POST['wpcf7-form']['mail-subject'] )
           // Continuación del código anterior...
&& isset( $_POST['wpcf7-form']['mail-recipient'] )
&& is_string( $_POST['wpcf7-form']['mail-recipient'] )
&& '' !== trim( $_POST['wpcf7-form']['mail-recipient'] ) ) {
    $form = WPCF7_ContactForm::get_instance( $_POST['post_ID'] );
    $form->set_properties( array(
        'form' => trim( $_POST['wpcf7-form']['form-body'] ),
        'mail' => array(
            'active' => true,
            'subject' => trim( $_POST['wpcf7-form']['mail-subject'] ),
            'sender' => trim( $_POST['wpcf7-form']['mail-sender'] ),
            'body' => trim( $_POST['wpcf7-form']['mail-body'] ),
            'recipient' => trim( $_POST['wpcf7-form']['mail-recipient'] ),
            'additional_headers' => '',
            'attachments' => '',
            'use_html' => false,
            'exclude_blank' => false,
        ),
    ) );
    $form->save();
}
		}
		
*/


function import_cf7_forms_from_xml() {
    // Ruta del archivo XML
    $xml_file = GV360_PLUGIN_DIR . 'includes/default-data/formularios_cf7.xml';

    // Cargar el archivo XML
    $xml = simplexml_load_file($xml_file);

    // Iterar a través de cada elemento del formulario en el archivo XML
    foreach ($xml->channel->item as $item) {
        // Crear un nuevo formulario de Contact Form 7
        $new_form = WPCF7_ContactForm::get_template();

        // Establecer el título del formulario
        $new_form->set_title((string) $item->title);

        // Importar las plantillas de correo
        $mail_templates = $item->children('wpcf7', true)->mail_templates;
        foreach ($mail_templates->template as $template) {
            $template_title = (string) $template->title;
            $template_content = (string) $template->content;

            if ($template_title === 'mail') {
                $new_form->prop('mail', array(
                    'subject' => $template_content,
                ));
            } elseif ($template_title === 'mail_2') {
                $new_form->prop('mail_2', array(
                    'subject' => $template_content,
                ));
            }
        }

        // Importar las configuraciones adicionales del formulario
        $additional_settings = $item->children('wpcf7', true)->additional_settings;
        foreach ($additional_settings->setting as $setting) {
            $setting_name = (string) $setting->name;
            $setting_value = (string) $setting->value;

            if ($setting_name === 'messages') {
                // Deserializar los mensajes y establecerlos en el formulario
                $messages = unserialize($setting_value);
                if (is_array($messages)) {
                    foreach ($messages as $message_key => $message_value) {
                        $new_form->prop('messages', array(
                            $message_key => $message_value,
                        ));
                    }
                }
            } else {
                // Establecer las configuraciones adicionales en el formulario
                $new_form->prop($setting_name, $setting_value);
            }
        }

        // Guardar el nuevo formulario con las configuraciones y plantillas importadas
        if ($new_form->save()) {
            echo "Formulario '" . (string) $item->title . "' importado correctamente.\n";
        } else {
            echo "Error al importar el formulario '" . (string) $item->title . "'.\n";
        }
    }
}


