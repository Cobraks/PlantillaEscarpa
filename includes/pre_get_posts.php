<?php
/**
 * Precargamos la query de cada coche, con las opciones elegidas
 * @package gv360
 */
/*
CONTINUAR POR AQUÍ. FALTA QUE, AL SELECCIONAR ORDEN POR DEFECTO, OBTENGA EL VALOR Y LO CONVIERTA. EJ, SI ES POR MENOR NÚMERO DE KM, QUE ME DE EL VALOR PARA EL ORDER DIRECTAMENTE, Y LUEGO PASARLO A LA VARIABLE
*/
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

function gv360_get_opciones() {
    $opciones = array(
        'coches_por_pag' => 10,
        'orden_por_defecto' => 'default'
    );
    if ( function_exists('get_field') ) {
        $opciones['coches_por_pag'] = get_field('numero_de_coches_por_pag', 'option');
        $opciones['orden_por_defecto'] = get_field('orden_por_defecto', 'option');
    }
    return $opciones;
}

 //Actualizamos el valor de coches por página por el campo de opciones seleccionado
 add_filter( 'facetwp_preload_url_vars', function( $url_vars ) {
    if ( function_exists('get_field') ) {
        $coches_por_pag = get_field('numero_de_coches_por_pag', 'option');
        $url_vars['per_page'] = $coches_por_pag;
    }
    return $url_vars;
} );

function gv360_modify_query( $query ) {
    // Solo modificamos la consulta principal en el frontend
    if ( ! is_admin() && $query->is_main_query() ) {
        // Si estamos en una de las plantillas especificadas
        if ( is_post_type_archive( 'coche' ) || is_tax( 'marca' ) || is_tax( 'carroceria' ) ) {
            // Elimina esta parte del código para no filtrar por el campo personalizado "estado_de_venta"
            
            $meta_query = array(
                array(
                    'key'     => 'visibilidad_del_vehiculo_estado_de_venta',
                    'value'   => array( 'disponible', 'reservado', 'vendido-visible' ),
                    'compare' => 'IN',
                ),
            );
            $query->set( 'meta_query', $meta_query );
            
            $opciones = gv360_get_opciones();
            // Establecemos el número de coches a mostrar por página
            $query->set( 'posts_per_page', $opciones['coches_por_pag'] );
            $query->set( 'orderby', array( 'menu_order' => 'DESC', 'date' => 'DESC' ) );
           // $query->set( 'order', 'DESC' );
            // Habilitamos la paginación
           // $query->set( 'paged', get_query_var( 'paged' ) );
            $query->set( 'facetwp', true );
        }
    }
}



add_action( 'pre_get_posts', 'gv360_modify_query' );


