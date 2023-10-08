<?php
/**
* @package gv360
*/
// Proteger contra el acceso directo al archivo y definir las constantes
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

class GV360_Init {
    public function __construct() {
        add_action('acf/init', array($this, 'th360_acf_init'));
    }

    public function th360_acf_init() {
        // ... tu código ...
                // Crear custom post, taxonomías y contenido por defecto.
                require_once GV360_PLUGIN_DIR . 'includes/taxonomies.php';
                require_once GV360_PLUGIN_DIR . 'includes/default-data/gv360_default_data.php';
                require_once GV360_PLUGIN_DIR . 'includes/post_type_coche.php';
                require_once GV360_PLUGIN_DIR . 'includes/templates_cp_tax.php';
                require_once GV360_PLUGIN_DIR . 'includes/pre_get_posts.php';
                require_once GV360_PLUGIN_DIR . 'includes/blocks/registrar-bloques.php';
                if ( is_post_type_archive( 'coche' ) || is_tax( 'marca' ) || is_tax( 'carroceria' ) || is_singular( 'coche' ) ) {
                    require_once GV360_PLUGIN_DIR . 'includes/facetwp_functions.php';
                }
                
                // Agregar filtro para hacer que las subpáginas sean seleccionables como ubicaciones en ACF
               
                // Acceder a las variables dentro de la función utilizando la palabra clave global
                global $min_price, $max_price, $min_km, $max_km, $min_ano, $max_ano, $contador_facets;
                include_once ( GV360_PLUGIN_DIR . 'includes/funciones_ajax.php');
    }
}
new GV360_Init();