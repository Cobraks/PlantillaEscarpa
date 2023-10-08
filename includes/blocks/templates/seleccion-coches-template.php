<?php
/**
 * Mostramos bloque seleccion coches
 *
 * @package gv360
 */
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );


/*

Añadir lógica slider (si seleccionado, cargar js)
*/


// Incluir el archivo JavaScript
/*wp_enqueue_script( 'mi-script', get_stylesheet_directory_uri() . '/ruta/a/mi-script.js', array( 'jquery' ), '', true ); */


// Obtener el valor del campo "Elige qué coches quieres mostrar"
$tipo_coches = get_field( 'elige_coches' );

// Inicializar los argumentos de la consulta
$args = array(
    'post_type' => 'coche', // Asegúrate de usar el nombre correcto del tipo de publicación "coche"
);

// Construir los argumentos de la consulta en función del tipo de coches seleccionado
if ( $tipo_coches == 'un_varios_coches' ) {
    // Obtener el valor del campo "select_un_varios_coches"
    $coches_seleccionados = get_field( 'select_un_varios_coches' );
    if ( $coches_seleccionados ) {
        // Asignar el valor del campo "select_un_varios_coches" a la variable "$coches_ids"
        $coches_ids = $coches_seleccionados;
        // Agregar el parámetro "post__in" a la consulta
        $args['post__in'] = $coches_ids;
    }
} elseif ( $tipo_coches == 'coches_marca' ) {
    // Obtener el valor del campo "coches_de_marca"
    $marca_seleccionada = get_field( 'coches_de_marca' );
    if ( $marca_seleccionada ) {
        // Agregar el parámetro "tax_query" a la consulta
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'marca', // Asegúrate de usar el nombre correcto de la taxonomía "marca"
                'field'    => 'term_id',
                'terms'    => $marca_seleccionada,
            ),
        );
    }
} elseif ( $tipo_coches == 'coches_carroceria' ) {
    // Obtener el valor del campo "coches_de_carroceria"
    $carroceria_seleccionada = get_field( 'coches_de_carroceria' );
    if ( $carroceria_seleccionada ) {
        // Agregar el parámetro "tax_query" a la consulta
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'carroceria', // Asegúrate de usar el nombre correcto de la taxonomía "carroceria"
                'field'    => 'term_id',
                'terms'    => $carroceria_seleccionada,
            ),
        );
    }
}

// Realizar la consulta
$coches_query = new WP_Query( $args );

// Mostrar los resultados de la consulta
if ( $coches_query->have_posts() ) {

?>
<div class="contenedor-coches">


<?php
// Mostrar el enlace en función del tipo de coches seleccionado
//MOVER A LA PARTE DEL FINAL
if ( get_field( 'presentacion_mostrar_enlace_stock' ) ) {
    if ( $tipo_coches == 'un_varios_coches' ) {
        // Mostrar el enlace al archivo de coches
        echo '<a href="' . get_post_type_archive_link( 'coche' ) . '">' . ( get_field( 'presentacion_cambiar_texto_del_enlace_stock' ) ? get_field( 'presentacion_cambiar_texto_del_enlace_stock' ) : __( 'Ver nuestro stock', 'text-domain' ) ) . '</a>';
    } elseif ( $tipo_coches == 'coches_marca' ) {
        // Obtener el nombre de la marca seleccionada
        $marca_seleccionada = get_field( 'coches_de_marca' );
        $marca_nombre = get_term( $marca_seleccionada, 'marca' )->name;
        // Mostrar el enlace a la taxonomía de esa marca
        echo '<a href="' . get_term_link( $marca_seleccionada, 'marca' ) . '">' . ( get_field( 'presentacion_cambiar_texto_del_enlace_stock' ) ? get_field( 'presentacion_cambiar_texto_del_enlace_stock' ) : sprintf( __( 'Ver nuestros %s', 'text-domain' ), $marca_nombre ) ) . '</a>';
    } elseif ( $tipo_coches == 'coches_carroceria' ) {
        // Obtener el nombre de la carrocería seleccionada
        $carroceria_seleccionada = get_field( 'coches_de_carroceria' );
        $carroceria_nombre = get_term( $carroceria_seleccionada, 'carroceria' )->name;
        // Mostrar el enlace al archivo de los coches
        echo '<a href="' . get_post_type_archive_link( 'coche' ) . '">' . ( get_field( 'presentacion_cambiar_texto_del_enlace_stock' ) ? get_field( 'presentacion_cambiar_texto_del_enlace_stock' ) : sprintf( __( 'Ver nuestros coches tipo %s', 'text-domain' ), $carroceria_nombre ) ) . '</a>';
    }
}



?>







<?php
    
    while ( $coches_query->have_posts() ) {
        $coches_query->the_post();
           
    // Variables de cada coche
    
    $marcas = get_the_terms( get_the_ID(), 'marca' );
    if ( $marcas && ! is_wp_error( $marcas ) ) {
    // Obtener el primer término
    $marca = $marcas[0];
    // Asignar nombre_mraca a nombre del término
    $nombre_marca = $marca->name;
    // Obtener el valor del campo "logo_marca" para este término
    $logo_marca = get_field( 'logo_marca', $marca );
    $forma_logo = get_field ('forma_del_logo', $marca );
    } else {
        // No hay términos de la taxonomía "marca" asociados a esta publicación
        $nombre_marca = 'Sin marca';
        $logo_marca = 'imagen genérica'; /*Cambiarlo por imagen genérica*/
    }
    //Carrocería
    $carrocerias = get_the_terms( get_the_ID(), 'carroceria' );
    if ( $carrocerias && ! is_wp_error( $carrocerias ) ) {
        $carroceria = $carrocerias[0];
        $nombre_carroceria = $carroceria->name;
    } else {
        $nombre_carroceria = '';
    }
    //Modelos
    $modelos = get_the_terms( get_the_ID(), 'modelo' );
    if ( $modelos && ! is_wp_error( $modelos ) ) {
        $modelo = $modelos[0];
        $nombre_modelo = $modelo->name;
    } else {
        $nombre_modelo = '';
    }
    $ano = get_field( 'datos_generales_ano', get_the_ID() );
    $kilometros = get_field('especificaciones_tecnicas_kilometros', get_the_ID());
$km_formateado = number_format( $kilometros, 0, ',', '.' );
$version = get_field('datos_generales_version', get_the_ID());
$cambio = get_field('especificaciones_tecnicas_cambio', get_the_ID());
$combustible = get_field('especificaciones_tecnicas_combustible', get_the_ID());
$potencia = get_field('especificaciones_tecnicas_potencia', get_the_ID());

$precio = get_field('precio_y_descuentos_precio', get_the_ID());

$emisiones = get_field('especificaciones_tecnicas_emisiones', get_the_ID());
$etiqueta_medioambiental = $emisiones['value'];
$etiqueta_medioambiental_label = $emisiones['label'];

$portada_coche = get_field('portadax_coche', get_the_ID());
$iva_deducible = get_field('precio_y_descuentos_iva_deducible', get_the_ID());
$link_coche = get_the_permalink();
$mostrar_contado = get_field( 'mostrar_contado', 'option' );

$precio_formateado = number_format( $precio, 0, ',', '.' );

$precio_financiado = get_field('precio_y_descuentos_precio_financiado', get_the_ID());

$descuento_financiacion = get_field('precio_y_descuentos_descuento_financiacion', get_the_ID());

$financiado = $precio - $descuento_financiacion;

$financiado_format = number_format( $financiado, 0, ',', '.' );
?>


<article class="coche-card" itemscope itemtype="https://schema.org/Car">
  <a href="<?php echo esc_url($link_coche);?>" title="<?php echo esc_attr( 'Ver detalles del ' . $nombre_marca . ' ' . $nombre_modelo . ' ' . $version );?>" itemprop="url">
    <div class="portada-container">
        <img class="portada_coche" src="https://picsum.photos/300/200" alt="Imagen del coche" itemprop="image">
        <?php


        ?>
        <div class="overlay-fotos">
            <i class="icon-photo_camera"></i><span class="total-fotos">5</span>
        </div>




        <?php

if (!empty($etiqueta_medioambiental)) {
    $img_src = GV360_PLUGIN_URL . 'public/assets/images/etiquetas-medioambientales/' . $etiqueta_medioambiental . '.svg';
    echo '<div class="overlay-etiqueta_medioambiental"><img class="etiqueta_medioambiental" height="50" width="50" src="' . esc_attr($img_src) . '" alt="Etiqueta medioambiental ' . esc_attr($etiqueta_medioambiental_label) . '"></div>';
}

        ?>
    </div>
    <div class="header-card">
    <div class="logo-container <?php echo esc_attr($forma_logo)?>">
        <?php
        echo wp_get_attachment_image( $logo_marca, 'full', false, array(
            'alt' => 'Logo de ' . ' ' . $nombre_marca,
            'title' => $nombre_marca,
            'height' => 120,
            'width' => 120,
            'class' => 'logo-marca' 
        ) );
       
        
        ?>
    </div>
      <!-- <img src="https://picsum.photos/50" alt="Logo de <?php //echo esc_attr($nombre_marca);?>" class="logo-marca"> -->
      <div class="titulo-coche-card">
      <h2 itemprop="name"><span class="marca-modelo"><span class="marca" itemprop="brand" itemscope itemtype="https://schema.org/Brand"><span itemprop="name"><?php echo esc_html($nombre_marca);?></span></span> <span class="modelo" itemprop="model"><?php echo esc_html($nombre_modelo);?></span></span> <span class="version" itemprop="vehicleConfiguration"><?php echo esc_html($version);?></span></h2>
       
      </div>
      <div class="precio-card" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
      <?php

if ( $mostrar_contado ) { ?>
    <span class="cantidad" itemprop= "price"><?php echo esc_html( $precio_formateado ) . '€';?></span>
    <meta content= "<?php echo esc_attr( $precio ); ?>"/>
    <meta itemprop= "priceCurrency" content= "EUR"/>
    <span class= "text-precio" itemprop= "priceSpecification">Al contado</span> <?php
} else { ?>
    <span class="cantidad" itemprop= "price"><?php echo esc_html($financiado_format) . '€';?></span>
    <meta content= "<?php echo esc_attr( $financiado ); ?>"/>
    <meta itemprop= "priceCurrency" content= "EUR"/>
    <span class= "text-precio" itemprop= "priceSpecification">Financiado</span> <?php
} 
?>
      </div>
    </div>
    <div class= "info-card">
      <ul>
    <?php 
      if (!empty($ano)){ 
      ?>
      <li><i class= "icon-calendar_today"></i><span itemprop= "dateVehicleFirstRegistered"><?php echo esc_html($ano); ?></span></li>
      <?php
      }
      if (!empty($cambio)){ ?>
        <li><i class= "icon-cambio"></i><span itemprop= "vehicleTransmission"><?php echo esc_html($cambio); ?></span></li>
      <?php } 
           if (!empty($potencia)){ 
            ?>
            <li>
            <i class="icon-horse"></i>
            <span itemprop="vehicleEngine" itemscope itemtype="https://schema.org/EngineSpecification">
                <meta itemprop="enginePower" content="<?php echo esc_attr($potencia);?>">
                <span><?php echo esc_html($potencia) . 'cv'; ?></span>
            </span>
            </li>
            <?php
            }
            if (!empty($kilometros)){ 
                ?>
                    <li>
                        <i class="icon-map"></i>
                        <span itemprop="mileageFromOdometer" itemscope itemtype="https://schema.org/QuantitativeValue">
                            <meta itemprop="value" content="<?php echo esc_attr($kilometros);?>">
                            <meta itemprop="unitCode" content="KMT">
                            <span><?php echo esc_html($km_formateado) . 'km';?></span>
                        </span>
                    </li>
                <?php
                }
       if (!empty($nombre_carroceria)){ 
        ?>
        <li><i class= "icon-car"></i><span itemprop= "bodyType"><?php echo esc_html($nombre_carroceria); ?></span></li>
        <?php
       }
  


       if (!empty($combustible)){ 
        ?>
            <li>
                <i class="icon-combustible"></i>
                <span itemprop="fuelType"><?php echo esc_html($combustible);?></span>
            </li>
        <?php
        }
       ?>
      </ul>
      
    </div>
  </a>
  <?php
if ( current_user_can( 'edit_posts' ) ) {
    edit_post_link( 'Editar coche', '<div class="boton-editar-coche">', '</div>' );
}
?>
</article>


<?php
    
    }

    ?>
</div> <!--/div contenedor-coches-->
    <?php
} else {
    // No se encontraron coches
}

// Restablecer la publicación global
wp_reset_postdata();