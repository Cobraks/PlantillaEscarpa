<?php
/**
 * Register Custom Taxonomies
 *
 * @package gv360
 */

defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

function gv360_registrar_taxonomias() {

    if ( function_exists('get_field') ) {
        $slug_stock = get_field('slug-stock', 'option');
    } else {
        //Por defecto
        $slug_stock = 'coches-segunda-mano';
    }

    // Marca
    $labels_marca = array(
        'name'                       => __('Marcas', 'gv360'),
        'singular_name'              => __('Marca', 'gv360'),
        'menu_name'                  => __('Marcas', 'gv360'),
        'all_items'                  => __('Todas las marcas', 'gv360'),
        //'parent_item'                => __('Marca padre', 'gv360'),
        //'parent_item_colon'          => __('Marca padre:', 'gv360'),
        'new_item_name'              => __('Nueva marca', 'gv360'),
        'add_new_item'               => __('Añadir nueva marca', 'gv360'),
        'edit_item'                  => __('Editar marca', 'gv360'),
        'update_item'                => __('Actualizar marca', 'gv360'),
        'view_item'                  => __('Ver marca', 'gv360'),
        'separate_items_with_commas' => __('Separar marcas con comas', 'gv360'),
        'add_or_remove_items'        => __('Añadir o eliminar marcas', 'gv360'),
        'choose_from_most_used'      => __('Elige entre las marcas más usadas', 'gv360'),
        'popular_items'              => __('Marcas populares', 'gv360'),
        'search_items'               => __('Buscar marcas', 'gv360'),
        'not_found'                  => __('No se encontraron marcas', 'gv360'),
        'no_terms'                   => __('Sin marcas', 'gv360'),
        'items_list'                 => __('Lista de marcas', 'gv360'),
        'items_list_navigation'      => __('Navegación de la lista de marcas', 'gv360'),
        "name_field_description"     => __( "Nombre de la marca"),
        "slug_field_description"     => __( "Es lo que aparecerá en la barra de direcciones. Usa minúsculas y guiones si son 2 palabras. Ej. alfa-romeo"),
        "back_to_items"              => __( "Volver al listado de marcas"),
    );

    $args_marca = array(
        'labels'                     => $labels_marca,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_rest'               => true,
        'show_in_nav_menus'          => true,
        "show_in_menu"               => true,
        'show_tagcloud'              => false,
		"rewrite" => [ 'slug' => $slug_stock, 'with_front' => false,  'hierarchical' => true, ],
       // "rewrite"                    => [ 'slug' => $slug_stock, 'with_front' => false ],
        'rest_base'                  => 'marca',
        'rest_controller_class' => 'WP_REST_Terms_Controller',
        "show_in_quick_edit"         => true,
		//"sort" => true,
		"show_in_graphql"            => false,
		"meta_box_cb"                => false,
        'supports'                   => array('title', 'editor', 'thumbnail'),
    );

    register_taxonomy('marca', 'coche', $args_marca);

    // Modelo
    $labels_modelo = array(
        'name'                       => __('Modelos', 'gv360' ),
        'singular_name'              => __('Modelo', 'gv360' ),
        'search_items'               => __('Buscar modelos', 'gv360' ),
        'all_items'                  => __('Todos los modelos', 'gv360' ),
        'parent_item'                => __('Modelo padre', 'gv360' ),
        'parent_item_colon'          => __('Modelo padre:', 'gv360' ),
        'edit_item'                  => __('Editar modelo', 'gv360' ),
        'update_item'                => __('Actualizar modelo', 'gv360' ),
        'add_new_item'               => __('Añadir nuevo modelo', 'gv360' ),
        'new_item_name'              => __('Nuevo modelo', 'gv360' ),
        'menu_name'                  => __('Modelos', 'gv360' ),
        'view_item'                  => __('Ver modelo', 'gv360'),
        'separate_items_with_commas' => __('Separar modelos con comas', 'gv360'),
        'add_or_remove_items'        => __('Añadir o eliminar modelos', 'gv360'),
        'choose_from_most_used'      => __('Elige entre los modelos más usados', 'gv360'),
        'popular_items'              => __('Modelos populares', 'gv360'),
        'search_items'               => __('Buscar modelos', 'gv360'),
        'not_found'                  => __('No se encontraron modelos', 'gv360'),
        'no_terms'                   => __('Sin modelos', 'gv360'),
        'items_list'                 => __('Lista de modelos', 'gv360'),
        'items_list_navigation'      => __('Navegación de la lista de modelos', 'gv360'),
        "name_field_description"     => __( "Nombre del modelo"),
        "slug_field_description"     => __( "Es lo que aparecerá en la barra de direcciones. Usa minúsculas y guiones si son 2 palabras. Ej. serie-1"),
        "back_to_items"              => __( "Volver al listado de modelos"),
    );


    $args_modelo = array(
        'hierarchical'              => true,
        //'public'                     => true,
        'labels'                    => $labels_modelo,
        'show_ui'                   => true,
        'show_admin_column'         => true,
        'show_in_rest'              => true,
        'query_var'                 => true,
       // 'rewrite'                   => array( 'slug' => 'modelo' ),
        'rewrite'                   => [ 'slug' => $slug_stock.'/'.'modelo/'.'%marca_en_modelo%', 'with_front' => true, ],
        'rest_base'                 => 'modelo',
        'rest_controller_class'     => 'WP_REST_Terms_Controller',
        'supports'                  => array('title', 'editor', 'thumbnail'),
        'show_tagcloud'             => false,
        "show_in_graphql"           => false,
        "meta_box_cb"               => false,
    );

    register_taxonomy( 'modelo', 'coche', $args_modelo );

    // Carrocería
    $labels_carroceria = array(
        'name' => __('Carrocerías', 'gv360' ),
        'singular_name' => __('Carrocería', 'gv360' ),
        'search_items' => __('Buscar carrocerías', 'gv360' ),
        'all_items' => __('Todas las carrocerías', 'gv360' ),
        //'parent_item' => __('Carrocería padre', 'gv360' ),
        //'parent_item_colon' => __('Carrocería padre:', 'gv360' ),
        'edit_item' => __('Editar carrocería', 'gv360' ),
        'update_item' => __('Actualizar carrocería', 'gv360' ),
        'add_new_item' => __('Añadir nueva carrocería', 'gv360' ),
        'new_item_name' => __('Nueva carrocería', 'gv360' ),
        'menu_name' => __('Carrocerías', 'gv360' ),
        'view_item'                  => __('Ver carrocería', 'gv360'),
        'separate_items_with_commas' => __('Separar carrocerías con comas', 'gv360'),
        'add_or_remove_items'        => __('Añadir o eliminar carrocerías', 'gv360'),
        'choose_from_most_used'      => __('Elige entre las carrocerías más usadas', 'gv360'),
        'popular_items'              => __('carrocerías populares', 'gv360'),
        'search_items'               => __('carrocerías carrocerías', 'gv360'),
        'not_found'                  => __('No se encontraron carrocerías', 'gv360'),
        'no_terms'                   => __('Sin carrocerías', 'gv360'),
        'items_list'                 => __('Lista de carrocerías', 'gv360'),
        'items_list_navigation'      => __('Navegación de la lista de carrocerías', 'gv360'),
        "name_field_description"     => __( "Nombre de la marca"),
        "slug_field_description"     => __( "Es lo que aparecerá en la barra de direcciones. Usa minúsculas y guiones si son 2 palabras."),
        "back_to_items"              => __( "Volver al listado de carrocerías"),
    );
    
    $args_carroceria = array(
        'hierarchical'               => false,
        'public'                     => true,
        'labels'                     => $labels_carroceria,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'query_var'                  => true,
        'show_in_rest'               => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        //'rewrite' => array( 'slug' => 'carroceria' ),
        "rewrite"                    => [ 'slug' => $slug_stock.'/carroceria', 'with_front' => false, ],
        'rest_base'                  => 'carroceria',
        'rest_controller_class' => 'WP_REST_Terms_Controller',
        "show_in_quick_edit"         => true,
        "show_in_graphql"            => false,
        "meta_box_cb"                => false,
        'supports' => array('title', 'editor', 'thumbnail'),
    );

    register_taxonomy( 'carroceria', 'coche', $args_carroceria );








}

add_action( 'init', 'gv360_registrar_taxonomias' );