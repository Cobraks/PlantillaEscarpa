<?php
/*
Modificamos el script de schema
*/
defined( 'ABSPATH' ) or die( 'No direct access allowed.' );

add_filter( 'wpseo_schema_graph_pieces', 'remove_breadcrumbs_from_schema', 11, 2 );
add_filter( 'wpseo_schema_webpage', 'remove_breadcrumbs_property_from_webpage', 11, 1 );

/**
 * Removes the breadcrumb graph pieces from the schema collector.
 *
 * @param array  $pieces  The current graph pieces.
 * @param string $context The current context.
 *
 * @return array The remaining graph pieces.
 */
function remove_breadcrumbs_from_schema( $pieces, $context ) {
    return \array_filter( $pieces, function( $piece ) {
        return ! $piece instanceof \Yoast\WP\SEO\Generators\Schema\Breadcrumb;
    } );
}

/**
 * Removes the breadcrumb property from the WebPage piece.
 *
 * @param array $data The WebPage's properties.
 *
 * @return array The modified WebPage properties.
 */
function remove_breadcrumbs_property_from_webpage( $data ) {
    if (array_key_exists('breadcrumb', $data)) {
        unset($data['breadcrumb']);
    }
    return $data;
}

add_filter( 'wpseo_schema_graph_pieces', 'add_autodealer_to_schema', 11, 2 );

function add_autodealer_to_schema( $pieces, $context ) {
    require_once GV360_PLUGIN_DIR . 'includes/schema/class-autodealer-schema.php';
    $pieces[] = new AutoDealer_Schema( $context );
    return $pieces;
}


    add_filter( 'wpseo_schema_graph', 'my_custom_schema_changes', 10, 2 );
    function my_custom_schema_changes( $data, $context ) {
        // Verificar si estamos viendo la página del archivo del custom post type coche
        if ( is_post_type_archive( 'coche' ) ) {
            $url_listado = get_post_type_archive_link( 'coche' );
            // Aquí puedes agregar tu código para modificar el schema
            // Por ejemplo, para cambiar el @id y la url de CollectionPage:
            foreach ( $data as $key => $value ) {
                if ( isset( $value['@type'] ) && $value['@type'] === 'CollectionPage' ) {
                    $data[$key]['@id'] = $url_listado;
                    $data[$key]['url'] = $url_listado;
                }
            }
        }
        return $data;
    }