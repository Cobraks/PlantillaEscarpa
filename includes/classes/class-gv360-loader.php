<?php
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );
class GV360_Loader {
    public function __construct() {
        $this->load_includes();
    }

    private function load_includes() {
        //No convertir en clase
        require_once GV360_PLUGIN_DIR . 'includes/funciones_generales.php';
        
        //require_once GV360_PLUGIN_DIR . 'includes/cf7_functions.php';
        require_once GV360_PLUGIN_DIR . 'includes/classes/class-cf7-functions.php';
        new CF7_Functions();

        //Convertir en clase
        require_once GV360_PLUGIN_DIR . 'includes/gv360_functions.php';

        //Convertir en clase
        require_once GV360_PLUGIN_DIR . 'admin/options/menu_options.php';

        //No convertir en clase
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        //Convertir en clase
        require_once GV360_PLUGIN_DIR . 'includes/yoast_functions.php';

        //Convertir en clase
        //Schema correcto
        include_once GV360_PLUGIN_DIR . 'includes/schema/gv360_schema-functions.php';
    }
}
