<?php
/**
* Plugin Name: Gestión de vehículos 360vo
* Plugin URI: https:/www.360vo.es
* Description: Descripción del Plugin
* Version: 3.2
* Author: Carlos Marín - 360VO
* Author URI: http://www.360vo.es
* License: GPL2
* @package gv360
*/
// Proteger contra el acceso directo al archivo y definir las constantes
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );
define( 'GV360_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'GV360_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'GV360_PLUGIN_FILE', __FILE__ );


/*Comprobar plugins necesarios*/
require_once GV360_PLUGIN_DIR . 'includes/classes/class-plugin-checker.php';
$plugin_checker = new Plugin_Checker();
if ( $plugin_checker->are_all_plugins_active() ) {
    require_once GV360_PLUGIN_DIR . 'includes/classes/class-gv360-loader.php';
    new GV360_Loader();
    require_once GV360_PLUGIN_DIR . 'includes/classes/class-gv360-init.php';
    require_once GV360_PLUGIN_DIR . 'includes/classes/class-gv360-role-manager.php';
    if ( is_admin() ) {
        require_once GV360_PLUGIN_DIR . 'includes/classes/class-gv369-admin-functions.php';
    }
    require_once GV360_PLUGIN_DIR . 'includes/classes/class-gv360-asset-loader.php';
    
     //require_once GV360_PLUGIN_DIR . 'admin/admin_settings.php';
   require_once GV360_PLUGIN_DIR . 'includes/classes/class-dashboard-settings.php';
    require_once GV360_PLUGIN_DIR . 'includes/classes/class-adminbar-settings.php';
    //He dividido el admin_settings en 2 clases. En local no funciona lo de ocultar las peticiones, hay que comprobarlo bien. 

    require_once GV360_PLUGIN_DIR . 'includes/gv360_buscador_ajax.php';

    function gv360_conditional_ajax_loading() { // Comprobar si estamos en el archive-coche o en las taxonomías marca, carroceria o modelo
        if ( is_post_type_archive( 'coche' ) || is_tax( array( 'marca', 'carroceria', 'modelo' ) ) ) { // Cargar el archivo gv360_buscador_ajax.php 
            require_once GV360_PLUGIN_DIR . 'includes/gv360_buscador_ajax.php'; 
        }
    } // Enganchar la función al hook wp_loaded
    add_action( 'wp_loaded', 'gv360_conditional_ajax_loading' );

    function my_custom_term_link( $termlink, $term, $taxonomy ) {
        if ( $taxonomy == 'modelo' ) {
            // Registrar el valor de $termlink antes de reemplazar el marcador de posición
            error_log( 'URL antes de reemplazar el placeholder: ' . $termlink );
            // Obtener el ID del término para el custom field "marca_en_modelo"
            $marca_en_modelo_id = get_field( 'marca_en_modelo', $term );
            // Registrar el valor del campo personalizado "marca_en_modelo"
            error_log( 'Valor del custom field "marca_en_modelo": ' . print_r( $marca_en_modelo_id, true ) );
            if ( ! empty( $marca_en_modelo_id ) ) {
                // Obtener el objeto de término para el custom field "marca_en_modelo"
                $marca_en_modelo = get_term( $marca_en_modelo_id );
                if ( ! empty( $marca_en_modelo ) && ! is_wp_error( $marca_en_modelo ) ) {
                    // Agregar el valor del custom field "marca_en_modelo" a la URL
                    $termlink = str_replace( '%marca_en_modelo%', $marca_en_modelo->slug, $termlink );
                    // Registrar el valor de $termlink después de reemplazar el marcador de posición
                    error_log( 'URL después de reemplazar el placeholder: ' . $termlink );
                }
            } else {
                // Si no hay un valor para el custom field "marca_en_modelo", usamos un valor por defecto
                $termlink = str_replace( '%marca_en_modelo%', 'modelo', $termlink );
                // Registrar el valor de $termlink después de reemplazar el marcador de posición
                error_log( 'URL después de reemplazar el placeholder con un valor por defecto: ' . $termlink );
            }
        }
        return $termlink;
    }
    add_filter( 'term_link', 'my_custom_term_link', 10, 3 );

    include_once GV360_PLUGIN_DIR . 'includes/classes/class-financiacion-360vo.php';
    
/**
 * Main instance of Financiacion_360VO.
 *
 * Returns the main instance of Financiacion_360VO to prevent the need to use globals.
 *
 * @return Financiacion_360VO
 */
/*
function financiacion_360vo() {
    return Financiacion_360VO::instance();
}

// Global for backwards compatibility.
$GLOBALS['financiacion_360vo'] = financiacion_360vo(); */


}

//Revisar esto:
function my_custom_rewrite_rule() {
    add_rewrite_rule(
        '^coches-de-segunda-mano-modelos/([^/]+)/([^/]+)/?$',
        'index.php?modelo=$matches[2]&marca_en_modelo=$matches[1]',
        'top'
    );
}
add_action( 'init', 'my_custom_rewrite_rule' );


function gv360_activar_plugin() {
    require_once GV360_PLUGIN_DIR . 'includes/default-data/import-cf7-forms.php';	
    //import_cf7_forms_from_xml( 'forms.xml' );
    import_cf7_forms_from_xml( GV360_PLUGIN_DIR . 'includes/default-data/formularios_cf7.xml' );

    // Importa los ajustes de Yoast SEO desde el archivo XML
    if ( function_exists( 'yoast_import_settings' ) ) {
        $file_path = GV360_PLUGIN_DIR . 'includes/default-data/gv360_yoast-settings.xml';
        yoast_import_settings( $file_path );
    }
}
register_activation_hook( __FILE__, 'gv360_activar_plugin' );

// Funciones que se ejecutan al desactivar el plugin
require_once GV360_PLUGIN_DIR . 'includes/deactivation.php';