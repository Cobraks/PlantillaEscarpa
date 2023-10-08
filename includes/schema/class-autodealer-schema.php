<?php
/**
* Añadimos la clase AutoDealer al schema
*
* @package 360vo-theme

*/
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

use Yoast\WP\SEO\Generators\Schema\Abstract_Schema_Piece;

class AutoDealer_Schema extends Abstract_Schema_Piece {

    /**
     * Determines whether the schema piece is needed.
     *
     * @return bool Whether the schema piece is needed.
     */
    public function is_needed() {
        return true;
    }

    /**
     * Generates the schema piece.
     *
     * @return array The schema piece.
     */
    public function generate() {

        $horario = get_field('horario', 'option');
        $conf_horario = $horario['conf_horario'];
        $horario_alt = $conf_horario['horario_alt'];
    
    if( !$horario_alt ) {
        //Horario de lunes a viernes
      
        $lunes_a_viernes = $horario['lunes_a_viernes'];
        $horario_sabado = $horario['horario_sabado'];
        $horario_domingo = $horario['horario_domingo'];
        
        // Lunes a viernes
        $entrada_lun_vier = $lunes_a_viernes['entrada_lun_vier'];
        $salida_lun_vier = $lunes_a_viernes['salida_lun_vier'];
        $horario_tarde = $lunes_a_viernes['horario_tarde'];
        $entrada_lun_vier_tarde = $lunes_a_viernes['entrada_lun_vier_tarde'];
        $salida_lun_vier_tarde = $lunes_a_viernes['salida_lun_vier_tarde'];
        
        // Sábado
        $abierto_sabados = $horario_sabado['abierto_sabados'];
        $entrada_sab = $horario_sabado['entrada_sab'];
        $salida_sab = $horario_sabado['salida_sab'];
        $horario_tarde_sab = $horario_sabado['horario_tarde_sab'];
        $entrada_sab_tarde = $horario_sabado['entrada_sab_tarde'];
        $salida_sab_tarde = $horario_sabado['salida_sab_tarde'];
        
        // Domingo
        $abierto_domingos = $horario_domingo['abierto_domingos'];
        $entrada_dom = $horario_domingo['entrada_dom'];
        $salida_dom = $horario_domingo['salida_dom'];
        $horario_tarde_dom = $horario_domingo['horario_tarde_dom'];
        $entrada_dom_tarde = $horario_domingo['entrada_dom_tarde'];
        $salida_dom_tarde = $horario_domingo['salida_dom_tarde'];
        
        // Generar horarios
        $lunes_viernes_horarios = "Mo-Fr {$entrada_lun_vier}-{$salida_lun_vier}";
        if( $horario_tarde ) {
            $lunes_viernes_horarios .= ",{$entrada_lun_vier_tarde}-{$salida_lun_vier_tarde}";
        }
        
        $sabado_horarios = "";
        if( $abierto_sabados ) {
            $sabado_horarios .= "Sa {$entrada_sab}-{$salida_sab}";
            if( $horario_tarde_sab ) {
                $sabado_horarios .= ",{$entrada_sab_tarde}-{$salida_sab_tarde}";
            }
        }
        
        $domingo_horarios = "";
        if( $abierto_domingos ) {
            $domingo_horarios .= "Su {$entrada_dom}-{$salida_dom}";
            if( $horario_tarde_dom ) {
                $domingo_horarios .= ",{$entrada_dom_tarde}-{$salida_dom_tarde}";
            }
        }
        
        // Unir horarios
        $horarios_array = array($lunes_viernes_horarios);
        if( !empty($sabado_horarios) ) {
            array_push($horarios_array, $sabado_horarios);
        }
        if( !empty($domingo_horarios) ) {
            array_push($horarios_array, $domingo_horarios);
        }
        $horario_comercio = implode(',', $horarios_array);
    } else {
        //Horario alternativo (días y horas por separado)
       
    }
        $site_name = get_bloginfo('name'); // Obtener el nombre del sitio
        $direccion = get_field('direccion_del_concesionario_direccion', 'option');
        $codigo_postal = get_field('direccion_del_concesionario_codigo_postal', 'option');
        $localidad = get_field('direccion_del_concesionario_localidad', 'option');
        $provincia = get_field('direccion_del_concesionario_provincia', 'option');
        $map_url = 'https://www.google.com/maps/place/' . urlencode($direccion . ', ' . $codigo_postal . ' ' . $localidad . ', ' . $provincia);
        $telefono = '+34' . get_field('correo_y_telefono_telefono_principal', 'option');
        $correo = get_field('correo_y_telefono_correo_principal', 'option');
        $home_url = home_url();
        $descripcion_web = get_bloginfo('description');
        $currenciesAccepted = 'EUR';
        $paymentAccepted = 'Efectivo, Tarjeta de crédito';
        $priceRange = get_field('rango_de_precios', 'option');

        $data = [
            '@type' => ['Organization', 'AutoDealer'],
            'name' => $site_name,
            '@id' => 'http://eskarpar.local/#organization_AutoDealer',
            'description' => $descripcion_web,
            'url' => $home_url,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $direccion,
                'addressLocality' => $localidad,
                'addressRegion' => $provincia,
                'postalCode' => $codigo_postal,
                'addressCountry' => 'ES'
            ],
            'hasMap' => $map_url,
            'telephone' => $telefono,
            'email' => $correo,
            'openingHours' => $horario_comercio,
            'currenciesAccepted' => $currenciesAccepted,
            'paymentAccepted' => $paymentAccepted,
            'priceRange' => $priceRange,
          //  'image' => $image_concesionario
        ];

        return $data;
    }
}