<?php
/**
 * Funciones para cargar las plantillas de nuestro plugin.
 *
 * @package gv360
 */

 defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

function gv360_load_templates($template) {

    // Si estamos en el backend de WordPress, no hacemos nada
    if ( is_admin() ) {
        return $template;
    }

    // Obtenemos el nombre de la taxonomía actual, si existe
    $taxonomy = get_query_var( 'taxonomy' );

    // Ruta base de la carpeta de plantillas
    $template_path = GV360_PLUGIN_DIR . 'public/templates/';

    // Si es un post de tipo "coche" y está mostrando una vista de single
    if ( is_singular( 'coche' ) ) {
        $template = $template_path . 'single-coche.php';
        
        // Agregamos un die() o exit() aquí para detener la ejecución y ver si la función se está ejecutando correctamente
        //die('Estamos en la plantilla de single-coche.php');
    }
  
    // Si es una vista de archive del post de tipo "coche"
    if ( is_post_type_archive( 'coche' ) ) {
        $template = $template_path . 'archive-coche.php';
    }
  
    // Si es una vista de taxonomía, cargamos la plantilla correspondiente
    if ( ! empty( $taxonomy ) ) {
        $template = $template_path . 'taxonomy-' . $taxonomy . '.php';
    }
  
    return $template;
}
add_filter( 'template_include', 'gv360_load_templates' );