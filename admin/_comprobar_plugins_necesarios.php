<?php
// Verificar si los plugins necesarios están instalados y activados
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

$required_plugins = array(
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
);

$all_plugins_active = true;
foreach ($required_plugins as $name => $plugin_data) {
    if ( ! is_plugin_active( $plugin_data['plugin'] ) ) {
        $all_plugins_active = false;
        break;
    }
}

// Mostrar mensaje si alguno de los plugins necesarios no está activado
if ( ! $all_plugins_active ) {
    add_action( 'admin_notices', function() use ( $required_plugins ) {
        echo '<div class="notice notice-error">';
        echo '<h1>Plugins necesarios</h1>';
        echo '<p>Para usar el plugin de gestión de vehículos, necesitas instalar y activar los siguientes plugins:</p>';
        echo '<ul>';
        foreach ($required_plugins as $name => $plugin_data) {
            if ( ! is_plugin_active( $plugin_data['plugin'] ) ) {
                echo '<li><a href="' . esc_url( $plugin_data['url'] ) . '">' . esc_html( $name ) . '</a></li>';
            }
        }
        echo '</ul>';
        echo '</div>';
    } );
} else {
   // Mostrar mensaje recordando al usuario que debe activar las licencias
add_action( 'admin_notices', function() {
    // Obtener el ID del usuario actual
    $user_id = get_current_user_id();

    // Verificar si el usuario ha cerrado el mensaje
    $message_closed = get_user_meta( $user_id, 'gv360_message_closed', true );

    // Mostrar el mensaje solo si el usuario no lo ha cerrado
    if ( ! $message_closed ) {
        echo '<div class="notice notice-info is-dismissible">';
        echo '<h1>Gestión 360</h1>';
        echo '<p>Recuerda activar las licencias de FacetWP y Contact Form 7.</p>';
        echo '</div>';

        // Guardar en la base de datos que el usuario ha cerrado el mensaje
        update_user_meta( $user_id, 'gv360_message_closed', true );
    }
} );

    // Aquí iría el resto del código del plugin
}