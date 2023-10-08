<?php
/**
* Creamos un nuevo rol de usuario, le asignamos lo que puede y no puede hacer, y ocultamos elementos innecesarios del menú
* @package gv360
*
*/

defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

// Crear un nuevo rol de usuario
function th360_create_user_role() {
    // Nombre del rol
    $role_name = 'administrador_del_concesionario';

    // Capacidades del rol
    $capabilities = array(
        'read' => true,
        'update_plugins' => true,
        'update_themes' => true,
     //   'create_users' => true,
     //   'list_users' => true, 
        'edit_posts' => true,
        'publish_posts' => true,
        'edit_pages' => true,
        'publish_pages' => true,
        'delete_posts' =>true,
        'delete_pages' =>true,
        'edit_published_posts' =>true,
        'edit_others_posts' => true,
        'edit_others_pages' =>true,
        'upload_files' => true,
        'manage_categories' => true,
        'edit_terms' => true,
        'edit_theme_options' => true,
        // Agregar otras capacidades aquí
    );

    // Agregar el rol
    add_role($role_name, 'Administrador del concesionario', $capabilities);
}
add_action('init', 'th360_create_user_role');




function th360_update_user_role() {
    // Nombre del rol
    $role_name = 'administrador_del_concesionario';

    // Obtener el rol
    $role = get_role($role_name);

    // Agregar nuevas capacidades al rol
    $role->add_cap('update_plugins');
    $role->add_cap('update_themes');
 //   $role->add_cap('create_users');
  //  $role->add_cap('list_users');
    $role->add_cap('edit_posts');
    $role->add_cap('publish_posts');
    $role->add_cap('edit_pages');
    $role->add_cap('publish_pages');
    $role->add_cap('delete_posts');
    $role->add_cap('delete_pages');
    $role->add_cap('edit_published_posts');
    $role->add_cap('edit_others_posts');
    $role->add_cap('edit_others_pages');
    $role->add_cap('upload_files');
    $role->add_cap('manage_categories');
    $role->add_cap('edit_terms');
    $role->add_cap('edit_theme_options');
}
add_action('init', 'th360_update_user_role'); 

function th360_hide_admin_menu() {
    // Comprobar si el usuario actual tiene el rol de "Administrador del concesionario"
    if (current_user_can('administrador_del_concesionario')) {
        // Eliminar el menú "Herramientas"
        remove_menu_page('tools.php');
                // Eliminar el menú de Yoast SEO NO FUNCIONA
                remove_menu_page('wpseo_dashboard');
                remove_menu_page('wpcf7');
    }
}
add_action('admin_menu', 'th360_hide_admin_menu');



