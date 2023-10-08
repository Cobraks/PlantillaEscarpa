<?php
/**
* @package gv360
*/
// Proteger contra el acceso directo al archivo y definir las constantes
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

class GV360_Admin_Functions {
    public function __construct() {
        add_filter( 'post_type_labels_coche', array($this, 'gv360_modify_cpt_labels') );
        add_action( 'add_meta_boxes', array($this, 'gv360_add_order_info_metabox') );
        add_filter( 'admin_body_class', array($this, 'add_user_role_to_admin_body_classes'), 100 );
        add_filter('flamingo_map_meta_cap', array($this, 'permitir_editar_contactos_flamingo'));
        add_filter('gettext',  array($this, 'cambiar_flamingo_por_mensajes'));
        add_filter('ngettext',  array($this, 'cambiar_flamingo_por_mensajes'));

    }

    public function gv360_modify_cpt_labels( $labels ) {
        $labels->attributes = 'Orden de los coches';
        return $labels;
    }

    public function gv360_add_order_info_metabox() {
        add_meta_box(
            'gv360_order_info',
            'Información sobre el orden',
            array($this, 'gv360_order_info_metabox_callback'),
            'coche',
            'side',
            'low'
        );
    }

    public function gv360_order_info_metabox_callback( $post ) {
        echo '<p>Poniendo un número mayor en <i>Orden</i>, aparecerá antes que otro con un número menor.</p>';
    }

    public function add_user_role_to_admin_body_classes( $classes ) {
        global $current_user;
        foreach ( $current_user->roles as $user_role ) {
            if ( $user_role == 'administrador_del_concesionario' ) {
                $classes .= ' admin_concesionario';
            }
        }
        return $classes;
    }

    public function permitir_editar_contactos_flamingo($meta_caps){
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

    public function cambiar_flamingo_por_mensajes($translated) {
        $translated = str_ireplace('Flamingo',  'Mensajes',  $translated);
        return $translated;
    }
}
new GV360_Admin_Functions();