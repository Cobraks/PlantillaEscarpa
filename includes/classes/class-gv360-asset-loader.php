<?php
/**
 * Encolar archivos css y js del plugin
 * @package gv360
 */

defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );
class GV360_Asset_Loader {
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array($this, 'gv360_enqueue_admin_assets') );
        add_action( 'wp_enqueue_scripts', array($this, 'gv360_enqueue_public_assets'), 200 );
        add_action( 'wp_print_styles', array($this, 'gv360_deregister_styles'), 200 );
        add_filter( 'facetwp_assets', array($this, 'remove_nouislider_css') );
    }

    public function dequeue_wp_styles() {
        wp_dequeue_style('wp-block-library-css');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'classic-theme-styles' );
    }

    public function gv360_deregister_styles() {
        wp_deregister_style( 'contact-form-7' );
        wp_deregister_style( 'cmplz-general' );
    }
    public function remove_nouislider_css($assets) {
        unset( $assets['nouislider.css'] );
        return $assets;
    }

    public function gv360_enqueue_admin_assets() {
        global $post;
        if ( $post && $post->post_type == 'coche' ) {
            wp_enqueue_script( 'gv360-modelos-to-marca', GV360_PLUGIN_URL . 'admin/assets/js/gv360_modelos_to_marca.js', array( 'jquery' ), false, true );
    
            // Obtener el valor de la taxonomía "modelo" para este custom post
            $modelo = wp_get_post_terms($post->ID, 'modelo', array('fields' => 'names'));
            $modelo = !empty($modelo) ? $modelo[0] : '';
    
            // Pasar el valor de la taxonomía "modelo" y el ID del post a JavaScript
            wp_localize_script('gv360-modelos-to-marca', 'gv360_data', array(
                'modelo' => $modelo,
                'post_id' => $post->ID,
            ));
        }
        wp_localize_script('gv360-functions-admin', 'gv360_ajax', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'gv360-nonce' )
        ));
        $css_file = GV360_PLUGIN_DIR . 'admin/assets/css/gv360_admin_styles.css';
        if ( file_exists($css_file) ) {
            wp_enqueue_style( 'gv360-admin-styles', GV360_PLUGIN_URL . 'admin/assets/css/gv360_admin_styles.css' );
            error_log('gv360_enqueue_admin_assets: CSS file exists');
        } else {
            error_log('gv360_enqueue_admin_assets: CSS file does not exist');
        }
    }

    public function gv360_enqueue_public_assets() {
        if ( is_post_type_archive( 'coche' ) || is_tax( 'marca' ) || is_tax( 'carroceria' )) {        
            $this->dequeue_wp_styles();
            wp_enqueue_script( 'gv360-listado-coches-functions', GV360_PLUGIN_URL . 'public/assets/js/listado-coches-functions.js', array('jquery'), false, true );
            wp_enqueue_script( 'buscador-coches', GV360_PLUGIN_URL . 'public/assets/js/buscador-coches.js', array('jquery'), false, true );
            add_filter( 'script_loader_tag', function( $tag, $handle ) {
                if ( 'buscador-coches' === $handle ) {
                    return str_replace( ' src', ' async src', $tag );
                }
                return $tag;
            }, 10, 2 );
            wp_enqueue_style( 'gv360-coches-styles', GV360_PLUGIN_URL . 'public/assets/css/gv360-coches-styles.css' );

            // Pasar la URL de admin-ajax.php y un nonce a JavaScript
            wp_localize_script( 'buscador-coches', 'gv360_ajax', array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( 'gv360-nonce' )
            ));
        } elseif ( is_singular( 'coche' ) ) {
            $this->dequeue_wp_styles();
            wp_enqueue_style( 'splide-css', GV360_PLUGIN_URL . 'public/assets/css/splide.min.css' );
            wp_enqueue_style( 'gv360-styles', GV360_PLUGIN_URL . 'public/assets/css/gv360-single-coche.css' );
            wp_enqueue_script( 'splide-js', GV360_PLUGIN_URL . 'public/assets/js/splide.min.js', array(), false, true );
            wp_script_add_data( 'splide-js', 'async', true );
            wp_enqueue_script( 'gv360-single_coche', GV360_PLUGIN_URL . 'public/assets/js/gv360_single_coche.js', array('jquery'), false, true );
            wp_script_add_data( 'gv360-single_coche', 'async', true );
            wp_enqueue_script( 'magnificpopup', GV360_PLUGIN_URL . 'public/assets/js/magnificpopup.min.js', array('jquery'), false, true );
            wp_script_add_data( 'magnificpopup', 'async', true );
            wp_enqueue_script( 'nouislider', plugins_url( 'facetwp/assets/vendor/noUiSlider/nouislider.min.js', WP_PLUGIN_DIR . '/facetwp.php' ), array('jquery'), '4.2.5', true );

            // Obtener el precio financiado
            $precio_financiado = get_field('precio_y_descuentos_precio_financiado');
            wp_localize_script( 'nouislider', 'precioFinanciado', array($precio_financiado) );

            $field_tin = get_field( 'opciones_financiacion_tin', 'option' );
            $value_tin = $field_tin['value'];
            $seguro = get_field('opciones_financiacion_con_seguro', 'option');
            wp_localize_script(
                'gv360-single_coche', // El mismo nombre del script que has encolado.
                'objeto_financiacion', // El nombre del objeto que contendrá las variables en JavaScript.
                array(
                    'precio_financiado' => $precio_financiado,
                    'value_tin' => $value_tin,
                    'seguro' => $seguro,
                    'ajaxurl' => admin_url('admin-ajax.php')
                )
            );
            
        }
    } //Fin gv360_enqueue_public_assets
}
new GV360_Asset_Loader();