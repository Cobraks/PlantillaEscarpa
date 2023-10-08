<?php
/** 
 * Funciones generales del plugin
* @package gv360
*/
/*
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );
function my_cache_busting($src) {
    // Agrega un identificador único a la URL de los recursos estáticos
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    $src = add_query_arg('ver', date('YmdHis'), $src);
    return $src;
}
add_filter('style_loader_src', 'my_cache_busting', 9999);
add_filter('script_loader_src', 'my_cache_busting', 9999);
*/

add_image_size( 'imagen-coche-small', 300, 150, true );
add_image_size( 'imagen-coche-medium', 400, 300, true );

/*
function my_filter_image_sizes( $sizes, $metadata ) {
    // Obtener el ID del post al que pertenece la imagen
    $post_id = $metadata['post_id'];
    
    // Comprobar si el post es del tipo 'coche'
    if ( get_post_type( $post_id ) == 'coche' ) {
        // Si el post es del tipo 'coche', registrar los nuevos tamaños de imagen
        $sizes['imagen-coche-small'] = array(
            'width' => 300,
            'height' => 150,
            'crop' => true
        );
        $sizes['imagen-coche-medium'] = array(
            'width' => 400,
            'height' => 300,
            'crop' => true
        );
    }
    
    return $sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'my_filter_image_sizes', 10, 2 );
*/