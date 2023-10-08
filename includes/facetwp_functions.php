<?php
/**
 * Ajustes para facetwp: Cambiar textos de coches por página, modificar ordenar por, remplazar valores
 *
 *
 * @package 360vo-theme
 */
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

add_filter( 'facetwp_facet_html', function( $output, $params ) {
    if ( 'coches_por_pagina' == $params['facet']['name'] ) {
        // Agrega un atributo title al elemento select
        $output = str_replace( '<select', '<select title="Selecciona el número de coches por página"', $output );
    }
    return $output;
}, 10, 2 );



//FACETWP

add_filter( 'facetwp_sort_options', function( $options, $params ) {
    $options['default']['label'] = 'Ordenar por';
    return $options;
}, 10, 2 );

add_filter( 'facetwp_sort_options', function( $options, $params ) {
    $options['precio_alto'] = [
        'label' => 'Precio más alto',
        'query_args' => [
            'orderby' => 'meta_value_num',
            'meta_key' => 'precio',
            'order' => 'DESC',
        ]
    ];
    return $options;
}, 10, 2 );

add_filter( 'facetwp_sort_options', function( $options, $params ) {
    $options['precio_bajo'] = [
        'label' => 'Precio más bajo',
        'query_args' => [
            'orderby' => 'meta_value_num',
            'meta_key' => 'precio',
            'order' => 'ASC',
        ]
    ];
    return $options;
}, 10, 2 );

add_filter( 'facetwp_sort_options', function( $options, $params ) {
    $options['km_ascendente'] = [
        'label' => 'Menor nº kilómetros',
        'query_args' => [
            'orderby' => 'meta_value_num',
            'meta_key' => 'kilometros',
            'order' => 'ASC',
        ]
    ];
    return $options;
}, 10, 2 );

add_filter( 'facetwp_sort_options', function( $options, $params ) {
    $options['km_descendente'] = [
        'label' => 'Mayor nº kilómetros',
        'query_args' => [
            'orderby' => 'meta_value_num',
            'meta_key' => 'kilometros',
            'order' => 'DESC',
        ]
    ];
    return $options;
}, 10, 2 );

add_filter( 'facetwp_sort_options', function( $options, $params ) {
    unset( $options['title_asc'] );
    return $options;
}, 10, 2 );

add_filter( 'facetwp_sort_options', function( $options, $params ) {
    unset( $options['title_desc'] );
    return $options;
}, 10, 2 );

add_filter( 'facetwp_render_output', function( $output ) {
    $output['settings']['modelo']['showSearch'] = false;
    return $output;
});



add_filter( 'facetwp_facet_display_value', function( $label, $params ) {

    // only apply to a facet named "vehicle_type"
    if ( 'disponibles' == $params['facet']['name'] ) {

        // get the raw value
        $val = $params['row']['facet_value'];

        // use the raw value to generate the image URL
        $label = 'Ocultar reservados';
        $label = str_replace( '{val}', $val, $label );
    }
    return $label;
}, 10, 2 );


add_filter( 'facetwp_index_row', function( $params, $class ) {
    if ( 'modelos' == $params['facet_name'] ) { // replace 'your_facet_name' with the name of your facet
      $value = $params['facet_value'];
      $value = str_replace( ',', '-', $value );
      $value = str_replace( '&', '-', $value );
      $params['facet_value'] = $value;
    }
    return $params;
  }, 10, 2 );


  //Actualizamos el valor de coches por página por el campo de opciones seleccionado
  add_filter( 'facetwp_preload_url_vars', function( $url_vars ) {
    if ( function_exists('get_field') ) {
        $coches_por_pag = get_field('numero_de_coches_por_pag', 'option');
        $url_vars['per_page'] = $coches_por_pag;
    }
    return $url_vars;
} );