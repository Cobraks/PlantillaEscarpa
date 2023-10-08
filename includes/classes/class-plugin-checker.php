<?php
// Verificar si los plugins necesarios están instalados y activados
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );


include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
class Plugin_Checker {
     private $all_plugins_active = true;
    private $required_plugins = array(
        'ACF' => array(
            'plugin' => 'advanced-custom-fields-pro/acf.php',
            'url' => 'https://wordpress.org/plugins/advanced-custom-fields.com/pro/'
        ),
        'Flamingo' => array(
            'plugin' => 'flamingo/flamingo.php',
            'url' => 'https://wordpress.org/plugins/flamingo/'
        ),
        'FacetWP' => array(
            'plugin' => 'facetwp/index.php',
            'url' => 'https://facetwp.com/'
        ),
        'Contact Form 7' => array(
            'plugin' => 'contact-form-7/wp-contact-form-7.php',
            'url' => 'https://wordpress.org/plugins/contact-form-7/'
        ),
        'Yoast SEO' => array(
            'plugin' => 'wordpress-seo/wp-seo.php',
            'url' => 'https://wordpress.org/plugins/wordpress-seo/'
        )
        // ... el resto de tus plugins ...
    );

    public function __construct() {
        add_action( 'admin_init', array( $this, 'check_required_plugins' ) );
    }

    public function check_required_plugins() {
        $this->all_plugins_active = true;
        foreach ($this->required_plugins as $plugin_data) {
            if ( ! is_plugin_active( $plugin_data['plugin'] ) ) {
                $this->all_plugins_active = false;
                break;
            }
        }
    
        if ( ! $this->all_plugins_active ) {
            add_action( 'admin_notices', array( $this, 'show_error_notice' ) );
        } else {
            add_action( 'admin_notices', array( $this, 'show_info_notice' ) );
        }
    }
    
    

    public function show_error_notice() {
        // Obtener el ID del usuario actual
        $user_id = get_current_user_id();
    
        // Guardar en la base de datos que el usuario no ha visto el mensaje
        update_user_meta( $user_id, 'gv360_message_seen', false );
    
        // Mostrar mensaje si alguno de los plugins necesarios no está activado
        echo '<div class="notice notice-error">';
        echo '<h1>Plugins necesarios</h1>';
        echo '<p>Para usar el plugin de gestión de vehículos, necesitas instalar y activar los siguientes plugins:</p>';
        echo '<ul>';
        foreach ($this->required_plugins as $name => $plugin_data) {
            if ( ! is_plugin_active( $plugin_data['plugin'] ) ) {
                echo '<li><a href="' . esc_url( $plugin_data['url'] ) . '">' . esc_html( $name ) . '</a></li>';
            }
        }
        echo '</ul>';
        echo '</div>';
    }
    

    public function show_info_notice() {
        // Obtener el ID del usuario actual
        $user_id = get_current_user_id();
    
        // Verificar si el usuario ha visto el mensaje
        $message_seen = get_user_meta( $user_id, 'gv360_message_seen', true );
    
        // Mostrar el mensaje solo si el usuario no lo ha visto
        if ( ! $message_seen ) {
            echo '<div class="notice notice-success is-dismissible">';
            echo '<h1>¡Todo listo!</h1>';
            echo '<p>Todos los plugins necesarios para usar el plugin de gestión de vehículos están activos.</p>';
            echo '</div>';
    
            // Guardar en la base de datos que el usuario ha visto el mensaje
            update_user_meta( $user_id, 'gv360_message_seen', true );
        }
    }
    
    

    public function are_all_plugins_active() {
        return $this->all_plugins_active;
    }
}
new Plugin_Checker();











