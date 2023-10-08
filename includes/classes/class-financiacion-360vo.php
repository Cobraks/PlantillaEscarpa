<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Financiacion_360VO' ) ) :
    class Financiacion_360VO {
        /**
         * The single instance of the class.
         *
         * @var Financiacion_360VO
         */
        protected static $_instance = null;

        /**
         * Main Financiacion_360VO Instance.
         *
         * Ensures only one instance of Financiacion_360VO is loaded or can be loaded.
         *
         * @return Financiacion_360VO - Main instance.
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Financiacion_360VO Constructor.
         */
        public function __construct() {
            $this->includes();
        }

        /**
         * Include required core files used in admin and on the frontend.
         */
        public function includes() {
           // include_once 'funciones-base-de-datos.php';
            include_once GV360_PLUGIN_DIR . 'admin/funciones-base-de-datos.php';
          //  include_once 'includes/funciones_ajax.php';
            //include_once 'opciones-financiacion.php';
           // include_once 'funciones-campos-personalizados.php';
         //  include_once 'enqueue_scripts_financiacion.php';
          // include_once 'funciones-ajax.php'; 
        }
    }
endif;