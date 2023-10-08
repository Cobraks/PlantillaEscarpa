<?php
/**
* Importamos los formularios de contacto
* @package gv360
*/
// Proteger contra el acceso directo al archivo y definir las constantes
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

function import_cf7_forms() {
    // Carga el archivo XML
    $xml = simplexml_load_file( __DIR__ . '/formularios_cf7.xml' );


    // Recorre los elementos del archivo XML
    foreach ( $xml->contact_form as $contact_form ) {
        // Crea un nuevo formulario de contacto
        $form = WPCF7_ContactForm::get_template();
        $form->set_title( $contact_form->title );

        // Establece las propiedades del formulario
        $properties = array();
        foreach ( $contact_form->properties->children() as $key => $value ) {
            $properties[ $key ] = (string) $value;
        }
        $form->set_properties( $properties );

        // Guarda el formulario
        $form->save();
    }
}
