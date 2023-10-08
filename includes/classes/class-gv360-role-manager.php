<?php
/**
* Creamos un nuevo rol de usuario, le asignamos lo que puede y no puede hacer, y ocultamos elementos innecesarios del menú
* @package gv360
*
*/

defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );
class Role_Manager {
    private $role_name = 'administrador_del_concesionario';
    private $capabilities = array(
        'read' => true,
        'update_plugins' => true,
        'update_themes' => true,
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
        'edit_theme_options' => true
    );

    public function __construct() {
        add_action('init', array($this, 'create_user_role'));
        add_action('init', array($this, 'update_user_role'));
        add_action('admin_menu', array($this, 'hide_admin_menu'));
    }

    public function create_user_role() {
        add_role($this->role_name, 'Administrador del concesionario', $this->capabilities);
    }

    public function update_user_role() {
        $role = get_role($this->role_name);
        foreach ($this->capabilities as $capability => $enabled) {
            $role->add_cap($capability);
        }
    }

    public function hide_admin_menu() {
        if (current_user_can($this->role_name)) {
            remove_menu_page('tools.php');
            remove_menu_page('wpseo_dashboard');
            remove_menu_page('wpcf7');
        }
    }
}
new Role_Manager();