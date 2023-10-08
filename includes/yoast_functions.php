<?php
/**
 * Funciones y mejoras para Yoast SEO. Forzar URl canónica, obtener opciones de ACF y pasarlas como variables de Yoast, 
 *
 *
 * @package 360vo-theme

 */

defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

/*Aseguramos URL canónica para archive coches, y quitamos wpseo_nect_rel_link*/
add_filter('wpseo_canonical', 'url_canonica_archive_coches');

function url_canonica_archive_coches($canonical) {
    if (is_post_type_archive('coche')) {
        $canonical = get_post_type_archive_link('coche');
    }
    return $canonical;
}
add_filter('wpseo_next_rel_link', '__return_false');

//Pasar variables de opciones de ACF a variable de YOAST para usar en títulos y metadescripciones
add_filter( 'wpseo_replacements', 'add_custom_yoast_variables', 10, 2 );
function add_custom_yoast_variables( $replacements, $args ) {
    // Verificar si las funciones existen
    if ( function_exists( 'get_field' ) && function_exists( 'wpseo_replace_vars' ) ) {
        // Obtener el valor del campo de opciones de ACF
        $complemento_nombre_stock = get_field( 'complemento_nombre', 'option' );
        $nombre_stock = get_field( 'nombre_del_stock', 'option' );
        // Agregar nuevas variables a la lista de reemplazos
        $replacements['%%complemento_nombre_stock%%'] = $complemento_nombre_stock;
        $replacements['%%nombre_stock%%'] = $nombre_stock;
    }
    return $replacements;
}