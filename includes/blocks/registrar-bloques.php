<?php
/**
 * Registramos bloque boton stock
 *
 * @package gv360
 */

 defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

acf_register_block_type( array(
    'name'            => 'boton_stock',
    'title'           => __( 'botón enlace a stock' ),
    'description'     => __( 'Un botón que lleva a la página de stock de coches, a la marca seleccionada o a la carrocería' ),
    'render_template' => plugin_dir_path( __FILE__ ) . 'templates/boton-stock-template.php',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'botón', 'stock', 'coche' ),
) );

acf_register_block_type( array(
    'name'            => 'seleccion_coches',
    'title'           => __( 'selección de coches' ),
    'description'     => __( 'Muestra un coche individual, una selección de varios, los coches de una marca, de una taxonomía, filtrados por precio, etc' ),
    'render_template' => plugin_dir_path( __FILE__ ) . 'templates/seleccion-coches-template.php',
    'category'        => 'formatting',
    'icon'            => 'admin-comments',
    'keywords'        => array( 'listado', 'seleccion', 'stock', 'coche', 'coches' ),
) );


//Agrego estilos para el bloque de las tarjetas de coches, si no estamos en archive, marca o carricería.
function gv360_enqueue_grid_coches_style( $block_content, $block ) {
    // Agregar un mensaje de error en el archivo de registro de errores de WordPress
    error_log( 'gv360_enqueue_grid_coches_style called' );

    // Verificar si estamos en una página que no sea el archivo del tipo de publicación "coche", ni la taxonomía "marca", ni la taxonomía "carroceria"
    if ( ! is_post_type_archive( 'coche' ) && ! is_tax( 'marca' ) && ! is_tax( 'carroceria' ) ) {
        // Agregar un mensaje de error en el archivo de registro de errores de WordPress
        error_log( 'not coche archive, marca or carroceria taxonomy' );

        // Verificar si estamos renderizando el bloque "seleccion_coches"
        if ( $block['blockName'] === 'acf/seleccion-coches' ) {
            // Agregar un mensaje de error en el archivo de registro de errores de WordPress
            error_log( 'seleccion-coches block found' );

            // Incluir el archivo CSS
            wp_enqueue_style( 'gv360-styles', GV360_PLUGIN_URL . 'public/assets/css/gv360-coches-styles.css' );
        } else {
            // Agregar un mensaje de error en el archivo de registro de errores de WordPress
            error_log( 'seleccion-coches block not found' );
        }
    } else {
        // Agregar un mensaje de error en el archivo de registro de errores de WordPress
        error_log( 'coche archive, marca or carroceria taxonomy found' );
    }
    return $block_content;
}
add_filter( 'render_block', 'gv360_enqueue_grid_coches_style', 10, 2 );


function gv360_enqueue_block_editor_assets() {
    wp_enqueue_style( 'gv360-styles', GV360_PLUGIN_URL . 'public/assets/css/gv360-coches-styles.css' );
}
add_action( 'enqueue_block_editor_assets', 'gv360_enqueue_block_editor_assets' ); 