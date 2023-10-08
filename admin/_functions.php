<?php
/**
* Funciones que se ejecutan en el backend. Calcular precio financiado, recargar taxonomías y custom post con nuevas opciones, y resto de funciones en admin 
* @package gv360
*
*/
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

/*
// Con esto elimino el editor del coche, pero quito también gutenberg
function remove_content_editor() {
    remove_post_type_support( 'coche', 'editor' );
}
add_action( 'init', 'remove_content_editor', 100 );
*/

/*
// Con esto elimino solo el contenido. Pero creo que es más útil utilizar la interfaz antigua 
function hide_content_editor() {
    echo '<style>
        .editor-styles-wrapper .block-editor-block-list__layout {
            display: none;
        }
    </style>';
}
add_action( 'admin_head', 'hide_content_editor' );
*/


function gv360_modify_cpt_labels( $labels ) {
    $labels->attributes = 'Orden de los coches';
    return $labels;
}
add_filter( 'post_type_labels_coche', 'gv360_modify_cpt_labels' );


function gv360_add_order_info_metabox() {
    add_meta_box(
        'gv360_order_info',
        'Información sobre el orden',
        'gv360_order_info_metabox_callback',
        'coche',
        'side',
        'low'
    );
}
add_action( 'add_meta_boxes', 'gv360_add_order_info_metabox' );

function gv360_order_info_metabox_callback( $post ) {
    echo '<p>Poniendo un número mayor en <i>Orden</i>, aparecerá antes que otro con un número menor.</p>';
}



/*
add_action('acf/save_post', 'my_acf_save_post', 20);
function my_acf_save_post($post_id) {
    // Comprobar si se está guardando una página de opciones
    if ($post_id == 'options') {
        // Recargar los archivos necesarios
        require_once GV360_PLUGIN_DIR . 'includes/taxonomies.php';
        require_once GV360_PLUGIN_DIR . 'includes/pre_get_posts.php';
        require_once GV360_PLUGIN_DIR . 'includes/post_type_coche.php';

        // Mostrar un mensaje para depurar
        error_log('Eliminando la opción rewrite_rules');

        // Eliminar la opción rewrite_rules
        delete_option('rewrite_rules');
    } else {
        // Mostrar un mensaje para depurar
        error_log('No se está guardando una página de opciones');
    }
} */

/*Si el usuario es administrador_del_concesionario (creado en gestor_role.php), añadimos la clase admin_concesionario al body*/
function add_user_role_to_admin_body_classes( $classes ) {
    global $current_user;
    foreach ( $current_user->roles as $user_role ) {
        if ( $user_role == 'administrador_del_concesionario' ) {
            $classes .= ' admin_concesionario';
        }
    }
    return $classes;
}
add_filter( 'admin_body_class', 'add_user_role_to_admin_body_classes', 100 );

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
// Verificar si Flamingo está activado
if ( is_plugin_active( 'flamingo/flamingo.php' ) ) {
    function permitir_editar_contactos_flamingo($meta_caps){
        $meta_caps = array(
            'flamingo_edit_contact' => 'delete_pages',
            'flamingo_edit_contacts' => 'delete_pages',
            'flamingo_delete_contact' => 'delete_pages',
            //'flamingo_delete_contacts' => 'delete_pages', //May not be a thing???
            'flamingo_edit_inbound_message' => 'delete_pages',
            'flamingo_edit_inbound_messages' => 'delete_pages',
            'flamingo_delete_inbound_message' => 'delete_pages',
            'flamingo_delete_inbound_messages' => 'delete_pages',
            'flamingo_spam_inbound_message' => 'delete_pages',
            'flamingo_unspam_inbound_message' => 'delete_pages');
        return $meta_caps;
    }

    function cambiar_flamingo_por_mensajes($translated) {
        /*Change Submissions to your preferred label name*/
        $translated = str_ireplace('Flamingo',  'Mensajes',  $translated);
        return $translated;
    }

    function gv360_init() {
        add_filter('flamingo_map_meta_cap', 'permitir_editar_contactos_flamingo');
        add_filter('gettext',  'cambiar_flamingo_por_mensajes');
        add_filter('ngettext',  'cambiar_flamingo_por_mensajes');
    }

    gv360_init();
}