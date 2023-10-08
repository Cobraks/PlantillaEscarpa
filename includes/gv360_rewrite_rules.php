<?php
/**
 * Rewrite rules para los tipos de contenido
 * @package gv360
 */

defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

//Añadir marca a url del modelo
function gv360_marca_en_modelo_url_tax( $termlink, $term, $taxonomy ) {
    if ( $taxonomy == 'modelo' ) {
        // Registrar el valor de $termlink antes de reemplazar el marcador de posición
        error_log( 'URL antes de reemplazar el placeholder: ' . $termlink );
        // Obtener el ID del término para el custom field "marca_en_modelo"
        $marca_en_modelo_id = get_field( 'marca_en_modelo', $term );
        // Registrar el valor del campo personalizado "marca_en_modelo"
        error_log( 'Valor del custom field "marca_en_modelo": ' . print_r( $marca_en_modelo_id, true ) );
        if ( ! empty( $marca_en_modelo_id ) ) {
            // Obtener el objeto de término para el custom field "marca_en_modelo"
            $marca_en_modelo = get_term( $marca_en_modelo_id );
            if ( ! empty( $marca_en_modelo ) && ! is_wp_error( $marca_en_modelo ) ) {
                // Agregar el valor del custom field "marca_en_modelo" a la URL
                $termlink = str_replace( '%marca_en_modelo%', $marca_en_modelo->slug, $termlink );
                // Registrar el valor de $termlink después de reemplazar el marcador de posición
                error_log( 'URL después de reemplazar el placeholder: ' . $termlink );
            }
        } else {
            // Si no hay un valor para el custom field "marca_en_modelo", usamos un valor por defecto
            $termlink = str_replace( '%marca_en_modelo%', 'modelo', $termlink );
            // Registrar el valor de $termlink después de reemplazar el marcador de posición
            error_log( 'URL después de reemplazar el placeholder con un valor por defecto: ' . $termlink );
        }
    }
    return $termlink;
}
add_filter( 'term_link', 'gv360_marca_en_modelo_url_tax', 10, 3 );


function gv360_rewrite_rules() {
    if ( function_exists('get_field') ) {
        $stock_slug = get_field('slug-stock', 'option');
    } else {
        $stock_slug = 'coches-segunda-mano';
    }
    
    // Regla de reescritura personalizada para la taxonomía "modelo"
    add_rewrite_rule(
        str_replace( 'coches-de-segunda-mano', $stock_slug, '^coches-de-segunda-mano/modelo/([^/]+)/([^/]+)/?$' ),
        'index.php?modelo=$matches[2]&marca_en_modelo=$matches[1]',
        'top'
    );
    
    // Regla de reescritura personalizada para la taxonomía "carrocería"
    add_rewrite_rule(
        str_replace( 'coches-de-segunda-mano', $stock_slug, '^coches-de-segunda-mano/carroceria/([^/]+)/?$' ),
        'index.php?carroceria=$matches[1]',
        'top'
    );
}
add_action( 'init', 'gv360_rewrite_rules' );

