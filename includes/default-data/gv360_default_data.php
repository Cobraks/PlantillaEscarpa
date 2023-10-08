<?php
/**
 * Crear marcas y carrocerías por defecto al activar el plugin.
 *  @package gv360
 */

defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );

/* PARA VOLVER A CREAR TÉRMINOS POR DEFECTO, BORRAR terminos_por_defecto en wp_options en la base de datos, y las imágenes de los logos en la carpeta uploads*/

function gv360_marcas_carrocerias_default() {

    // Comprobar si las marcas ya han sido creadas
    $tax_creadas = get_option('terminos_por_defecto');

    if(!$tax_creadas) {
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        // Crear marcas por defecto
        $marcas = array(
            array(
                'name' => 'Alfa Romeo',
                'description' => 'Descripción de Alfa Romeo',
                'image' => 'alfa_romeo.svg',
                'forma_del_logo' => 'circular',
                'modelos' => array(
                    'Giulia',
                    'Stelvio',
                    'Tonale',
                    'Giulietta',
                    '4C',
                    'MiTo',
                    '156',
                    '159',
                    'Brera',
                    'Spider'
                )
            ), 
            array(
                'name' => 'Audi',
                'description' => 'Descripción de Audi',
                'image' => 'audi.svg',
                'forma_del_logo' => 'horizontal_largo',
                'modelos' => array(
                    'A1',
                    'A3',
                    'A4',
                    'A5',
                    'A6',
                    'Q2',
                    'Q3',
                    'Q5',
                    'Q7',
                    'Q8'
                )
            ),
            array(
                'name' => 'BMW',
                'description' => 'Descripción de BMW',
                'image' => 'bmw.svg',
                'forma_del_logo' => 'circular',
                'modelos' => array(
                    'Serie 1',
                    'Serie 2',
                    'Serie 3',
                    'Serie 4',
                    'Serie 5',
                    'X1',
                    'X2',
                    'X3',
                    'X4',
                    'X5'
                )
            ),
            array(
                'name' => 'Cadillac',
                'description' => 'Descripción de Cadillac',
                'image' => 'cadillac.svg',
                'forma_del_logo' => 'horizontal_largo',
                'modelos' => array(
                    'ATS',
                    'CTS',
                    'Escalade'
                ) 
            ),
            array(
                'name' => 'Chevrolet',
                'description' => 'Descripción de Chevrolet',
                'image' => 'chevrolet.svg',
                'forma_del_logo' => 'horizontal_corto',
                'modelos' => array(
                    'Aveo',
                    'Camaro',
                    'Captiva',
                    'Corvette',
                    'Cruze'
                ) 
            ),
            array(
                'name' => 'DFSK',
                'description' => 'Descripción de DFSK',
                'image' => 'dfsk.svg',
                'forma_del_logo' => 'circular',
                'modelos' => array(
                    '500',
                    '580',
                    'Fengon 5',
                    'Seres 3'
                ) 
            ),
            array(
                'name' => 'DS',
                'description' => 'Descripción de DS',
                'image' => 'ds.svg',
                'forma_del_logo' => 'vertical',
                'modelos' => array(
                    '3',
                    '4',
                    '5',
                    '7'
                ) 
            ),
            array(
                'name' => 'Ferrari',
                'description' => 'Descripción de Ferrari',
                'image' => 'ferrari.svg',
                'forma_del_logo' => 'vertical',
                'modelos' => array(
                    '488 GTB',
                    'F12 Berlinetta',
                    'Roma',
                    'California',
                    '458',
                    '812 Superfast',
                    'Enzo',
                    'F50'
                ) 
            ),
            array(
                'name' => 'Fiat',
                'description' => 'Descripción de Fiat',
                'image' => 'fiat.svg',
                'forma_del_logo' => 'horizontal_corto',
                'modelos' => array(
                    '500',
                    '500X',
                    'Panda',
                    'Tipo'
                ) 
            ),
            array(
                'name' => 'Ford',
                'description' => 'Descripción de Ford',
                'image' => 'ford.svg',
                'forma_del_logo' => 'horizontal',
                'modelos' => array(
                    'Bronco',
                    'EcoSport',
                    'Explorer',
                    'Fiesta',
                    'Focus',
                    'Kuga',
                    'Mustang',
                    'Puma'
                ) 
            ),
            array(
                'name' => 'Honda',
                'description' => 'Descripción de Honda',
                'image' => 'honda.svg',
                'forma_del_logo' => 'circular',
                'modelos' => array(
                    'Civic',
                    'CR-V',
                    'e',
                    'HR-V',
                    'Jazz'
                ) 
            ),
            array(
                'name' => 'Jaguar',
                'description' => 'Descripción de Jaguar',
                'image' => 'jaguar.svg',
                'forma_del_logo' => 'horizontal_largo',
                'modelos' => array(
                    'E-Pace',
                    'F-Pace',
                    'F-Type',
                    'i-Pace',
                    'XE',
                    'XF'
                ) 
            ),
            array(
                'name' => 'Jeep',
                'description' => 'Descripción de Jeep',
                'image' => 'jeep.svg',
                'forma_del_logo' => 'horizontal',
                'modelos' => array(
                    'Avenger',
                    'Compass',
                    'Grand Cherokee',
                    'Renegade',
                    'Wrangler'
                ) 
            ),
            array(
                'name' => 'Kia',
                'description' => 'Descripción de Kia',
                'image' => 'kia.svg',
                'forma_del_logo' => 'horizontal_corto',
                'modelos' => array(
                    'Ceed',
                    'Niro',
                    'Picanto',
                    'Rio',
                    'Sorento',
                    'Sportage',
                    'Stonic',
                    'XCeed'
                ) 
            ),
            array(
                'name' => 'Lamborghini',
                'description' => 'Descripción de Lamborghini',
                'image' => 'lamborghini.svg',
                'forma_del_logo' => 'vertical',
                'modelos' => array(
                    'Countach',
                    'Revuelto',
                    'Urus'
                ) 
            ),
            array(
                'name' => 'Lexus',
                'description' => 'Descripción de Lexus',
                'image' => 'lexus.svg',
                'forma_del_logo' => 'horizontal',
                'modelos' => array(
                    'NX 300h',
                    'UX 250h'
                ) 
            ),
            array(
                'name' => 'Land Rover',
                'description' => 'Descripción de Land Rover',
                'image' => 'land_rover.svg',
                'forma_del_logo' => 'horizontal',
                'modelos' => array(
                    'Defender',
                    'Discovery',
                    'Discovery Sport',
                    'Range Rover',
                    'Range Rover Evoque',
                    'Range Rover Sport',
                    'Range Rover Velar'
                ) 
            ),
            array(
                'name' => 'Maserati',
                'description' => 'Descripción de Maserati',
                'image' => 'maserati.svg',
                'forma_del_logo' => 'vertical',
                'modelos' => array(
                    'Ghibli',
                    'GranTurismo',
                    'Levante',
                    'MC20',
                    'Quattroporte'
                ) 
            ),
            array(
                'name' => 'Mazda',
                'description' => 'Descripción de Mazda',
                'image' => 'mazda.svg',
                'forma_del_logo' => 'circular',
                'modelos' => array(
                    'CX-30',
                    'CX-5',
                    'CX-60',
                    'Mazda2',
                    'Mazda3',
                    'Mazda6',
                    'MX-30',
                    'MX-5'
                ) 
            ),
            array(
                'name' => 'Mercedes-Benz',
                'description' => 'Descripción de Mercedes-Benz',
                'image' => 'mercedes_benz.svg',
                'forma_del_logo' => 'circular',
                'modelos' => array(
                    'Clase A',
                    'Clase C',
                    'CLA',
                    'GLA',
                    'GLC'
                ) 
            ),
            array(
                'name' => 'Mini',
                'description' => 'Descripción de Mini',
                'image' => 'mini.svg',
                'forma_del_logo' => 'horizontal_largo',
                'modelos' => array(
                    '3 puertas',
                    '5 Puertas',
                    'Cabrio',
                    'Clubman',
                    'Countryman'
                ) 
            ),
            array(
                'name' => 'Nissan',
                'description' => 'Descripción de Nissan',
                'image' => 'nissan.svg',
                'forma_del_logo' => 'circular',
                'modelos' => array(
                    'Juke',
                    'Qashqai',
                    'Leaf',
                    'Micra',
                    'X-Trail'
                ) 
            ),
            array(
                'name' => 'Opel',
                'description' => 'Descripción de Opel',
                'image' => 'opel.svg',
                'forma_del_logo' => 'circular',
                'modelos' => array(
                    'Astra',
                    'Corsa',
                    'Crossland',
                    'Grandland',
                    'Mokka'
                ) 
            ),
            array(
                'name' => 'Peugeot',
                'description' => 'Descripción de Peugeot',
                'image' => 'peugeot.svg',
                'forma_del_logo' => 'vertical',
                'modelos' => array(
                    '2008',
                    '208',
                    '3008',
                    '308',
                    '508',
                    '5008'
                ) 
            ),
            array(
                'name' => 'Porsche',
                'description' => 'Descripción de Porsche',
                'image' => 'porsche.svg',
                'forma_del_logo' => 'vertical',
                'modelos' => array(
                    '718 Boxster',
                    '718 Cayman',
                    '911',
                    'Cayenne',
                    'Macan',
                    'Taycan'
                ) 
            ),
            array(
                'name' => 'Renault',
                'description' => 'Descripción de Renault',
                'image' => 'renault.svg',
                'forma_del_logo' => 'vertical',
                'modelos' => array(
                    'Captur',
                    'Clio',
                    'Kadjar',
                    'Megane',
                    'Sandero'
                ) 
            ),
            array(
                'name' => 'Seat',
                'description' => 'Descripción de Seat',
                'image' => 'seat.svg',
                'forma_del_logo' => 'circular',
                'modelos' => array(
                    'Arona',
                    'Ibiza',
                    'León'
                ) 
            ),
            array(
                'name' => 'Subaru',
                'description' => 'Descripción de Subaru',
                'image' => 'subaru.svg',
                'forma_del_logo' => 'horizontal',
                'modelos' => array(
                    'Forester',
                    'Impreza',
                    'Levorg',
                    'Outback',
                    'XV'
                ) 
            ),
            array(
                'name' => 'Toyota',
                'description' => 'Descripción de Toyota',
                'image' => 'toyota.svg',
                'forma_del_logo' => 'horizontal',
                'modelos' => array(
                    'C-HR',
                    'Corolla',
                    'Prius',
                    'RAV4',
                    'Yaris'
                ) 
            ),
            array(
                'name' => 'Volkswagen',
                'description' => 'Descripción de Volkswagen',
                'image' => 'volkswagen.svg',
                'forma_del_logo' => 'circular',
                'modelos' => array(
                    'Caddy',
                    'Golf',
                    'Passat',
                    'Polo',
                    'T-Roc',
                    'Tiguan'
                ) 
            ),
            array(
                'name' => 'Volvo',
                'description' => 'Descripción de Volvo',
                'image' => 'volvo.svg',
                'forma_del_logo' => 'circular',
                'modelos' => array(
                    'C40',
                    'EX30',
                    'EX90',
                    'S60',
                    'S90',
                    'V60',
                    'V90',
                    'XC40',
                    'XC60',
                    'XC90'
                ) 
            )
        );
        
        foreach($marcas as $marca) {
            wp_insert_term(
                $marca['name'],  // nombre de la marca
                'marca',  // nombre de la taxonomía
                array(
                    'description' => $marca['description']  // descripción de la marca
                )
            );
            $term_id = get_term_by('name', $marca['name'], 'marca')->term_id;
            
            // Registrar información en el archivo de registro de errores
            error_log('ID del término: ' . $term_id);
            
            // Ruta a la imagen en la carpeta de tu plugin
            $image_path = GV360_PLUGIN_DIR . '/includes/assets/images/logo-marcas/light/' . $marca['image'];
        
            // Copiar el archivo al directorio de subidas de WordPress
            $upload = wp_upload_bits( basename( $image_path ), null, file_get_contents( $image_path ) );
        
            if ( ! $upload['error'] ) {
                // Ruta del archivo en el directorio de subidas
                $upload_path = $upload['file'];
        
                // Información del archivo
                $filetype = wp_check_filetype( basename( $upload_path ), null );
        
                // Preparar un array con los datos del archivo
                $attachment = array(
                    'guid'           => $upload['url'],
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $upload_path ) ),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                );
                
                // Insertar el archivo en la biblioteca de medios
                $attach_id = wp_insert_attachment( $attachment, $upload_path );
                
                // Generar los metadatos del archivo
                $attach_data = wp_generate_attachment_metadata( $attach_id, $upload_path );
                
                // Actualizar los metadatos del archivo
                wp_update_attachment_metadata( $attach_id, $attach_data );
                
                // Asignar la imagen al campo personalizado "logo_marca" de la taxonomía "marca"
                update_term_meta( $term_id, 'logo_marca', $attach_id );
            }
        
            // Asignar el valor al campo personalizado "forma_del_logo" de la taxonomía "marca"
            update_term_meta( $term_id, 'forma_del_logo', $marca['forma_del_logo'] );

            // Crear modelos por defecto y asignarles una marca
            foreach($marca['modelos'] as $modelo) {
                wp_insert_term(
                    $modelo,  // nombre del modelo
                    'modelo',  // nombre de la taxonomía
                    array()
                );
                $modelo_id = get_term_by('name', $modelo, 'modelo')->term_id;
            
                // Asignar el ID de la marca al campo personalizado "marca_en_modelo" del modelo
                update_field( 'marca_en_modelo', $term_id, 'modelo_' . $modelo_id );
            }

        }






       // Crear carrocerías por defecto
$carrocerias = array(
    array(
        'name' => 'Berlina',
        'description' => 'Descripción del tipo de carrocería berlina'
    ),
    array(
        'name' => 'Cabrio',
        'description' => 'Descripción del tipo de carrocería cabrio'
    ),
    array(
        'name' => 'Compacto',
        'description' => 'Descripción del tipo de carrocería compacto'
    ),
    array(
        'name' => 'Deportivo',
        'description' => 'Descripción del tipo de carrocería deportivo'
    ),
    array(
        'name' => 'Familiar',
        'description' => 'Descripción del tipo de carrocería familiar'
    ),
    array(
        'name' => 'Monovolumen',
        'description' => 'Descripción del tipo de carrocería monovolumen'
    ),
    array(
        'name' => 'Sedán',
        'description' => 'Descripción del tipo de carrocería sedan'
    ),
    array(
        'name' => 'Todoterreno-Suv',
        'description' => 'Descripción del tipo de carrocería todoterreno-suv'
    )
);

foreach($carrocerias as $carroceria) {
    
    wp_insert_term(
        $carroceria['name'],  // nombre de la carrocería
        'carroceria',  // nombre de la taxonomía
        array(
            'description' => $carroceria['description']  // descripción de la carrocería
        )
    );
}

// Guardar valor en la base de datos para indicar que las marcas han sido creadas
update_option('terminos_por_defecto', true);
}
}

add_action('init', 'gv360_marcas_carrocerias_default');

