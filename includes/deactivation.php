<?php
/* Función que se ejecuta al desactivar el plugin
* @package gv360
*/
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

function gv360_desactivar_plugin() {
    // Obtener todos los usuarios
    $users = get_users();

    // Recorrer los usuarios y eliminar el valor guardado en la base de datos
    foreach ( $users as $user ) {
        delete_user_meta( $user->ID, 'gv360_message_closed' );
    }
}
register_deactivation_hook( GV360_PLUGIN_FILE, 'gv360_desactivar_plugin' );

?>