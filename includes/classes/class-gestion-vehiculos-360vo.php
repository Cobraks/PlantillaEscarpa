<?php

defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

if ( ! class_exists( 'GestionVehiculos360VO' ) ) {
    require_once dirname( __FILE__ ) . '/../class-plugin-checker.php';

    class GestionVehiculos360VO {
        /**
         * The single instance of the class.
         *
         * @var GestionVehiculos360VO
         */
        protected static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        private function __construct() {
            // Inicializa tu clase aquí
            $this->hooks();
        }

        private function hooks() {
            // Engancha tus funciones y ganchos aquí
            add_action( 'wp_loaded', array( $this, 'conditional_ajax_loading' ) );
            add_filter( 'term_link', array( $this, 'custom_term_link' ), 10, 3 );
            add_action( 'init', array( $this, 'custom_rewrite_rule' ) );

            // Verificar plugins necesarios
            PluginChecker::check_required_plugins();
        }

        public function initialize_plugin() {
            // Lógica de inicialización principal del plugin.
            // Esto es lo que se ejecutará si todos los plugins necesarios están activos.

            // Incluye otros archivos necesarios para la funcionalidad del plugin
            require_once GV360_PLUGIN_DIR . '/../funciones_generales.php';
            require_once GV360_PLUGIN_DIR . '/../cf7_functions.php';
            require_once GV360_PLUGIN_DIR . '/../gv360_functions.php';
            
            //Agregar páginas de menú al plugin
            require_once GV360_PLUGIN_DIR . 'admin/options/menu_options.php';
            
            // Crear custom post, taxonomías y contenido por defecto.
            require_once GV360_PLUGIN_DIR . '/../taxonomies.php';
            require_once GV360_PLUGIN_DIR . '/../default-data/gv360_default_data.php';
            require_once GV360_PLUGIN_DIR . '/../post_type_coche.php';
            require_once GV360_PLUGIN_DIR . '/../templates_cp_tax.php';
            require_once GV360_PLUGIN_DIR . '/../pre_get_posts.php';
            require_once GV360_PLUGIN_DIR . '/../blocks/registrar-bloques.php';
            
            if ( is_post_type_archive( 'coche' ) || is_tax( 'marca' ) || is_tax( 'carroceria' ) || is_singular( 'coche' ) ) {
                require_once GV360_PLUGIN_DIR . '/../facetwp_functions.php';
            }
            
            //Añadir rol de usuario y permisos
            require_once GV360_PLUGIN_DIR . 'admin/gestor_role.php'; 
            //Funciones que se ejecutan en backend. Filtros y hooks de plugins. Calcular precio financiado.
            if ( is_admin() ) {
                require_once GV360_PLUGIN_DIR . 'admin/functions.php';
            }
            //Encolar archivos
            require_once GV360_PLUGIN_DIR . '/../gv360_enqueue_scripts.php';
            //Funciones para mejorar el dashboard y el admin-bar de WordPress
            require_once GV360_PLUGIN_DIR . 'admin/admin_settings.php';
            
            // En el archivo principal de tu plugin
            require_once GV360_PLUGIN_DIR . '/../gv360_buscador_ajax.php';

            // Agrega más inicializaciones aquí según tu lógica.
        }

        public function conditional_ajax_loading() {
            // Tu función gv360_conditional_ajax_loading() va aquí
            if ( is_post_type_archive( 'coche' ) || is_tax( array( 'marca', 'carroceria', 'modelo' ) ) ) { // Cargar el archivo gv360_buscador_ajax.php 
                require_once GV360_PLUGIN_DIR . '/../gv360_buscador_ajax.php'; 
            }
        }

        public function custom_term_link( $termlink, $term, $taxonomy ) {
            // Tu función my_custom_term_link() va aquí
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

        public function custom_rewrite_rule() {
            // Tu función my_custom_rewrite_rule() va aquí
            add_rewrite_rule(
                '^coches-de-segunda-mano-modelos/([^/]+)/([^/]+)/?$',
                'index.php?modelo=$matches[2]&marca_en_modelo=$matches[1]',
                'top'
            );
        }
    }
}

