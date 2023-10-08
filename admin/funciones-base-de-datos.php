<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

global $wpdb;

$tabla_nombre = $wpdb->prefix . 'financiacion_360vo';

$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $tabla_nombre (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    tin decimal(4,2) NOT NULL,
    meses smallint(5) NOT NULL,
    seguro boolean NOT NULL,
    coeficiente decimal(8,6) NOT NULL,
    PRIMARY KEY  (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );

$coeficientes = array(
    array('tin' => 6.99, 'meses' => 60, 'seguro' => 0, 'coeficiente' => 0.020578),
    array('tin' => 6.99, 'meses' => 72, 'seguro' => 0, 'coeficiente' => 0.017717),
    array('tin' => 6.99, 'meses' => 84, 'seguro' => 0, 'coeficiente' => 0.015684),
    array('tin' => 6.99, 'meses' => 96, 'seguro' => 0, 'coeficiente' => 0.014167),
    array('tin' => 6.99, 'meses' => 60, 'seguro' => 1, 'coeficiente' => 0.021673),
    array('tin' => 6.99, 'meses' => 72, 'seguro' => 1, 'coeficiente' => 0.018730),
    array('tin' => 6.99, 'meses' => 84, 'seguro' => 1, 'coeficiente' => 0.016788),
    array('tin' => 6.99, 'meses' => 96, 'seguro' => 1, 'coeficiente' => 0.015275),

    array('tin' => 7.50, 'meses' => 60, 'seguro' => 0, 'coeficiente' => 0.020829),
    array('tin' => 7.50, 'meses' => 72, 'seguro' => 0, 'coeficiente' => 0.017973),
    array('tin' => 7.50, 'meses' => 84, 'seguro' => 0, 'coeficiente' => 0.015944),
    array('tin' => 7.50, 'meses' => 96, 'seguro' => 0, 'coeficiente' => 0.014432),
    array('tin' => 7.50, 'meses' => 60, 'seguro' => 1, 'coeficiente' => 0.021938),
    array('tin' => 7.50, 'meses' => 72, 'seguro' => 1, 'coeficiente' => 0.019000),
    array('tin' => 7.50, 'meses' => 84, 'seguro' => 1, 'coeficiente' => 0.017066),
    array('tin' => 7.50, 'meses' => 96, 'seguro' => 1, 'coeficiente' => 0.015561),

    array('tin' => 7.99, 'meses' => 60, 'seguro' => 0, 'coeficiente' => 0.021072),
    array('tin' => 7.99, 'meses' => 72, 'seguro' => 0, 'coeficiente' => 0.018221 ),
    array('tin' => 7.99, 'meses' => 84, 'seguro' => 0, 'coeficiente' => 0.016197),
    array('tin' => 7.99, 'meses' => 96, 'seguro' => 0, 'coeficiente' => 0.014690),
    array('tin' => 7.99, 'meses' => 60, 'seguro' => 1, 'coeficiente' => 0.022193),
    array('tin' => 7.99, 'meses' => 72, 'seguro' => 1, 'coeficiente' => 0.019262),
    array('tin' => 7.99, 'meses' => 84, 'seguro' => 1, 'coeficiente' => 0.017337),
    array('tin' => 7.99, 'meses' => 96, 'seguro' => 1, 'coeficiente' => 0.015839 ),

    array('tin' => 8.50, 'meses' => 60, 'seguro' => 0, 'coeficiente' => 0.021327),
    array('tin' => 8.50, 'meses' => 72, 'seguro' => 0, 'coeficiente' => 0.018481),
    array('tin' => 8.50, 'meses' => 84, 'seguro' => 0, 'coeficiente' => 0.016462),
    array('tin' => 8.50, 'meses' => 96, 'seguro' => 0, 'coeficiente' => 0.014961),
    array('tin' => 8.50, 'meses' => 60, 'seguro' => 1, 'coeficiente' => 0.022461),
    array('tin' => 8.50, 'meses' => 72, 'seguro' => 1, 'coeficiente' => 0.019537),
    array('tin' => 8.50, 'meses' => 84, 'seguro' => 1, 'coeficiente' => 0.016131),/**/
    array('tin' => 8.50, 'meses' => 96, 'seguro' => 1, 'coeficiente' => 0.017621),

    array('tin' => 8.99, 'meses' => 60, 'seguro' => 0, 'coeficiente' => 0.021573),
    array('tin' => 8.99, 'meses' => 72, 'seguro' => 0, 'coeficiente' => 0.018732),
    array('tin' => 8.99, 'meses' => 84, 'seguro' => 0, 'coeficiente' => 0.016719),
    array('tin' => 8.99, 'meses' => 96, 'seguro' => 0, 'coeficiente' => 0.015223),
    array('tin' => 8.99, 'meses' => 60, 'seguro' => 1, 'coeficiente' => 0.022721),
    array('tin' => 8.99, 'meses' => 72, 'seguro' => 1, 'coeficiente' => 0.019803),
    array('tin' => 8.99, 'meses' => 84, 'seguro' => 1, 'coeficiente' => 0.017896),
    array('tin' => 8.99, 'meses' => 96, 'seguro' => 1, 'coeficiente' => 0.016414),

    array('tin' => 9.50, 'meses' => 60, 'seguro' => 0, 'coeficiente' => 0.021831),
    array('tin' => 9.50, 'meses' => 72, 'seguro' => 0, 'coeficiente' => 0.018997),
    array('tin' => 9.50, 'meses' => 84, 'seguro' => 0, 'coeficiente' => 0.016990),
    array('tin' => 9.50, 'meses' => 96, 'seguro' => 0, 'coeficiente' => 0.015500),
    array('tin' => 9.50, 'meses' => 60, 'seguro' => 1, 'coeficiente' => 0.022993),
    array('tin' => 9.50, 'meses' => 72, 'seguro' => 1, 'coeficiente' => 0.020082),
    array('tin' => 9.50, 'meses' => 84, 'seguro' => 1, 'coeficiente' => 0.018185),
    array('tin' => 9.50, 'meses' => 96, 'seguro' => 1, 'coeficiente' => 0.016712),

    array('tin' => 9.99, 'meses' => 60, 'seguro' => 0, 'coeficiente' => 0.022081),
    array('tin' => 9.99, 'meses' => 72, 'seguro' => 0, 'coeficiente' => 0.019252),
    array('tin' => 9.99, 'meses' => 84, 'seguro' => 0, 'coeficiente' => 0.017252),
    array('tin' => 9.99, 'meses' => 96, 'seguro' => 0, 'coeficiente' => 0.015768),
    array('tin' => 9.99, 'meses' => 60, 'seguro' => 1, 'coeficiente' => 0.023256),
    array('tin' => 9.99, 'meses' => 72, 'seguro' => 1, 'coeficiente' => 0.020352),
    array('tin' => 9.99, 'meses' => 84, 'seguro' => 1, 'coeficiente' => 0.018466),
    array('tin' => 9.99, 'meses' => 96, 'seguro' => 1, 'coeficiente' => 0.017001),

    array('tin' => 10.50, 'meses' => 60, 'seguro' => 0, 'coeficiente' => 0.022343),
    array('tin' => 10.50, 'meses' => 72, 'seguro' => 0, 'coeficiente' => 0.019521),
    array('tin' => 10.50, 'meses' => 84, 'seguro' => 0, 'coeficiente' => 0.017527),
    array('tin' => 10.50, 'meses' => 96, 'seguro' => 0, 'coeficiente' => 0.016050),
    array('tin' => 10.50, 'meses' => 60, 'seguro' => 1, 'coeficiente' => 0.023531),
    array('tin' => 10.50, 'meses' => 72, 'seguro' => 1, 'coeficiente' => 0.020636),
    array('tin' => 10.50, 'meses' => 84, 'seguro' => 1, 'coeficiente' => 0.018760),
    array('tin' => 10.50, 'meses' => 96, 'seguro' => 1, 'coeficiente' => 0.017305),
);

foreach ($coeficientes as $coeficiente) {
    $wpdb->insert(
        $tabla_nombre,
        array(
            'tin' => $coeficiente['tin'],
            'meses' => $coeficiente['meses'],
            'seguro' => $coeficiente['seguro'],
            'coeficiente' => $coeficiente['coeficiente']
        )
    );
}