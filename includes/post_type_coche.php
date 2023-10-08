<?php
/**
 * Creamos el custom post type coche, con variables de opciones
 * @package gv360
 */

defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );



function crear_post_type_coche() {

    if ( function_exists('get_field') ) {
        $nombre_del_stock = get_field('nombre_del_stock', 'option');
        $stock_single_coche = get_field('slug-single', 'option');
        $stock_slug = get_field('slug-stock', 'option');
    } else {
        // ACF no está instalado o activado, muestra un mensaje de error o desactiva tu plugin
        // O utiliza valores predeterminados para tus opciones
        $stock_single_coche = 'coche-segunda-mano';
        $nombre_del_stock = 'Coches de segunda mano';
        $stock_slug = 'coches-segunda-mano';
    }



$labels = array(
    'name' => __('Coches', 'gv360' ),
    'singular_name' => __('Coche', 'gv360' ),
    'menu_name' => __('Mis coches', 'gv360' ),
    'all_items' => __('Todos los coches', 'gv360' ),
    'add_new' => __('Añadir coche', 'gv360' ),
    'add_new_item' => __('Añadir nuevo coche', 'gv360' ),
    'edit_item' => __('Editar coche', 'gv360' ),
    'archives' => __($nombre_del_stock, 'gv360' ),
    'new_item' => __('Nuevo coche', 'gv360' ),
    'view_item' => __('Ver coche', 'gv360' ),
    'search_items' => __('Buscar coches', 'gv360' ),
    'not_found' => __('No se encontraron coches', 'gv360' ),
    'not_found_in_trash' => __('No hay coches en la papelera', 'gv360' ),
    "uploaded_to_this_item" => __( "Subido a este coche", "gv360"),
    "filter_items_list" => __( "Filtrar la lista de coches", "gv360"),
    "items_list_navigation" => __( "Navegación de la lista de coches", "gv360"),
    "items_list" => __( "Lista de coches", "gv360"),
    "attributes" => __( "Atributos de coches", "gv360"),
    "name_admin_bar" => __( "Coche", "gv360"),
    "item_published" => __( "¡Coche publicado!", "gv360"),
    "item_published_privately" => __( "Coche publicado como privado.", "gv360"),
    "item_reverted_to_draft" => __( "Coche devuelto a borrador.", "gv360"),
    "item_scheduled" => __( "Coche programado", "gv360"),
    "item_updated" => __( "¡Coche actualizado!", "gv360"),
    "insert_into_item" => __( "Insertar en el coche", "gv360"),
    "featured_image" => __( "Imagen de portada para este coche", "gv360"),
    "set_featured_image" => __( "Establece una imagen de portada para este coche", "gv360"),
    "remove_featured_image" => __( "Eliminar la imagen de portada de este coche", "gv360"),
    "use_featured_image" => __( "Usar como imagen de portada en este coche", "gv360"),
    );

    $args = array(
		"label" => __( "Coches"),
		"labels" => $labels,
		"description" => "Gestiona tu stock de coches disponibles",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => $stock_slug,
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => $stock_slug,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true, 
		"hierarchical" => false, 
		"can_export" => true,
		"rewrite" => [ "slug" => $stock_single_coche, "with_front" => false ],
		"query_var" => true,
		"menu_position" => 2,
		"menu_icon" => "dashicons-car",
		"supports" => [ "title", /*"editor", */ "trackbacks", "custom-fields", "revisions", "author", "page-attributes" ],
		"taxonomies" => [ "marca", "modelo" ],
		"show_in_graphql" => false,
    );

    register_post_type('coche', $args);

   // add_post_type_support( 'coches', 'editor' );
}

add_action('init', 'crear_post_type_coche');