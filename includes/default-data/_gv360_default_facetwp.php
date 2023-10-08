<?php
/**
 * Creamos los filtros por defecto
 * @package gv360
 */

defined('ABSPATH') or die('¡Acceso denegado!');
/*
add_filter( 'facetwp_facets', function( $facets ) {
    // Decodifica el JSON exportado por FacetWP
    $imported_facets = json_decode( '***AQUI TU CODIGO***', true );

    // Agrega cada uno de los facets importados a la matriz $facets
    foreach ( $imported_facets['facets'] as $imported_facet ) {
        $facets[] = $imported_facet;
    }

    // Devuelve la matriz $facets modificada
    return $facets;
}, 10, 1 );

*/
error_log('SE CARGA DEFAULT FACET');

add_filter( 'facetwp_facets', function( $facets ) {
    // Decodifica el JSON exportado por FacetWP
    $imported_facets = json_decode( '{"facets":[{"name":"modelo","label":"Modelos","type":"checkboxes","source":"tax/modelo","parent_term":"","modifier_type":"off","modifier_values":"","hierarchical":"no","show_expanded":"no","ghosts":"yes","preserve_ghosts":"yes","operator":"or","orderby":"term_order","count":"-1","soft_limit":"12"},{"name":"marcas","label":"Marcas","type":"checkboxes","source":"tax/marca","parent_term":"","modifier_type":"off","modifier_values":"","hierarchical":"no","show_expanded":"no","ghosts":"yes","preserve_ghosts":"yes","operator":"or","orderby":"display_value","count":"-1","soft_limit":"5"},{"name":"carrocerias","label":"Carrocerias","type":"checkboxes","source":"tax/carroceria","parent_term":"","modifier_type":"off","modifier_values":"","hierarchical":"no","show_expanded":"no","ghosts":"no","preserve_ghosts":"no","operator":"or","orderby":"count","count":"10","soft_limit":"5"}]}', true );

    // Agrega cada uno de los facets importados a la matriz $facets
    foreach ( $imported_facets['facets'] as $imported_facet ) {
        // Comprueba si el facet ya existe
        $facet_exists = false;
        foreach ( $facets as $facet ) {
            if ( $facet['name'] === $imported_facet['name'] ) {
                $facet_exists = true;
                break;
            }
        }

        // Si el facet no existe, agrégalo a la matriz $facets
        if ( ! $facet_exists ) {
            $facets[] = $imported_facet;
        }
    }

    // Devuelve la matriz $facets modificada
    return $facets;
}, 10, 1 );