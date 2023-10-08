<?php
/**
 * Mostramos bloque boton stock
 *
 * @package gv360
 */
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

    $nombre_del_sitio = get_bloginfo( 'name' );
    $complemento_nombre_stock = get_field( 'complemento_nombre', 'option' );
    $marca_seleccionada = get_field( 'stock_de_marca' );
    $carroceria_seleccionada = get_field( 'stock_de_carroceria' );
    $texto_personalizado = get_field( 'texto_boton_stock' );
    
    if ( $texto_personalizado ) {
        $texto_del_boton = $texto_personalizado;
        $aria_label = sprintf( 'Ver %s', $complemento_nombre_stock );
        $title = sprintf( 'Haz clic aquí para ver los %s de %s', $complemento_nombre_stock, $nombre_del_sitio );
    } elseif ( $marca_seleccionada ) {
        $archive_link = get_term_link( $marca_seleccionada, 'marca' );
        $texto_del_boton = sprintf( 'Ver nuestros %s %s', get_term( $marca_seleccionada, 'marca' )->name, $complemento_nombre_stock );
        $aria_label = sprintf( 'Stock de %s %s', get_term( $marca_seleccionada, 'marca' )->name, $complemento_nombre_stock );
        $title = sprintf( 'Haz clic aquí para ver los %s de %s', get_term( $marca_seleccionada, 'marca' )->name, $nombre_del_sitio );
    } elseif ( $carroceria_seleccionada ) {
        $archive_link = get_term_link( $carroceria_seleccionada, 'carroceria' );
        $texto_del_boton = sprintf( 'Ver nuestros coches tipo %s %s', get_term( $carroceria_seleccionada, 'carroceria' )->name, $complemento_nombre_stock );
        $aria_label = sprintf( 'Stock de coches tipo %s %s', get_term( $carroceria_seleccionada, 'carroceria' )->name, $complemento_nombre_stock );
        $title = sprintf( 'Haz clic aquí para ver los coches tipo %s de %s', get_term( $carroceria_seleccionada, 'carroceria' )->name, $nombre_del_sitio );
    } else {
        $archive_link = get_post_type_archive_link( 'coche' );
        $texto_del_boton = get_field( 'nombre_del_stock', 'option' );
        $aria_label = sprintf( 'Stock de %s en %s', get_field( 'nombre_del_stock', 'option' ), $nombre_del_sitio );
        $title = sprintf( 'Haz clic aquí para ver los %s de %s', get_field( 'nombre_del_stock', 'option' ),$nombre_del_sitio);
    }
    
    echo '<a href="' . esc_url( $archive_link ) . '" class="button" aria-label="' . esc_attr( $aria_label ) . '" title="' . esc_attr( $title ) . '">' . esc_html( $texto_del_boton ) . '</a>';