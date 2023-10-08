<?php
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );
class AdminBarSettings {
    public function __construct() {
        add_action('wp_before_admin_bar_render', array($this, 'modificar_wpadminbar'));
        add_action('admin_bar_menu', array($this, 'add_links_to_wpadminbar'), 999);
    }

    public function modificar_wpadminbar() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu( 'comments' );
        // Eliminar opción de agregar nuevo usuario
        $wp_admin_bar->remove_node( 'new-user' );
        $wp_admin_bar->remove_menu('wp-logo');
        // Eliminar opción de agregar nuevo medio
        $wp_admin_bar->remove_node( 'new-media' );
    }

    public function add_links_to_wpadminbar($wp_admin_bar) {
        $wp_admin_bar->add_menu( array(
            'id' => 'flamingo-inbound-messages',
            'title' => '<span class="ab-icon dashicons dashicons-email-alt"></span>' . __('Mensajes'),
            'href' => admin_url( 'admin.php?page=flamingo_inbound' ),
            'parent' => 'top-secondary'
        ) );
        $title = get_field('nombre_del_stock', 'option');
      $args = array(
          'id' => 'coche',
          'title' => '<span class="ab-icon dashicons dashicons-admin-links"></span>' . _($title),
          'href' => get_post_type_archive_link('coche'),
          'parent' => 'top-secondary',
          'meta' => array(
              'class' => 'my-toolbar-page',
              'target' => '_blank',
          ),
      );
      $wp_admin_bar->add_node( $args );
    }
}

new AdminBarSettings();

