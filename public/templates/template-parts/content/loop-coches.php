<?php
/**
* Loop para los coches. Tarjetas de coches
* @package gv360
*
*/

defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );
?>
<div class="contenedor-coches">

<?php
// Agregar un contador para llevar la cuenta de las imágenes
$image_counter = 0;
while ( have_posts() ) :
    the_post();
    
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
    $ano = get_field('datos_generales_ano');
    $kilometros = get_field('especificaciones_tecnicas_kilometros');
    $km_formateado = number_format( $kilometros, 0, ',', '.' );
    $version = get_field('datos_generales_version');
    $cambio = get_field('especificaciones_tecnicas_cambio');
    $combustible = get_field('especificaciones_tecnicas_combustible');
    $potencia = get_field('especificaciones_tecnicas_potencia');
  
    $precio = get_field('precio_y_descuentos_precio');
   // $etiqueta_medioambiental = get_field('emisiones');


   $emisiones = get_field('especificaciones_tecnicas_emisiones');
   $etiqueta_medioambiental = $emisiones['value'];
   $etiqueta_medioambiental_label = $emisiones['label'];
    $portada_coche = get_field('portadax_coche');
    $iva_deducible = get_field('grupo_caracteristicas_iva_deducible');
    $link_coche = get_the_permalink();
    $mostrar_contado = get_field( 'mostrar_contado', 'option' );
    $precio_formateado = number_format( $precio, 0, ',', '.' );
    $precio_financiado = get_field('precio_y_descuentos_precio_financiado');
    $descuento_financiacion = get_field('precio_y_descuentos_descuento_financiacion');
    $financiado = $precio - $descuento_financiacion;
    $financiado_format = number_format( $financiado, 0, ',', '.' );

    $portada_coche = get_field('portada_coche');
    $full_thmb = wp_get_attachment_image_src( $portada_coche, 'full' );

?>
<article class="coche-card cargando <?php if (is_user_logged_in()) { echo esc_attr('tiene-mensajes');}?>" itemscope itemtype="https://schema.org/Car">



    <?php /* echo get_the_date() . '<br> Actualizado el: ' . get_the_modified_date(); */?>
  <a class="link-coche" href="<?php echo esc_url($link_coche);?>" title="<?php echo esc_attr( 'Ver detalles del ' . $nombre_marca . ' ' . $nombre_modelo . ' ' . $version );?>" itemprop="url">
    <div class="portada-container">
  <!--      <img class="portada_coche" src="https://picsum.photos/300/200" alt="Imagen del coche" itemprop="image"> -->









<?php 
// Comprobar si el campo 'portada_coche' tiene un valor
if ( $image_id = get_field( 'otros_datos_portada_coche' ) ) {
    // Incrementar el contador de imágenes
    $image_counter++;

    // Determinar el valor del atributo loading
    $loading = ( $image_counter <= 5 ) ? 'eager' : 'lazy';

    // Obtener el valor del atributo alt
    $alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
    if ( empty( $alt ) ) {
        // Establecer un valor predeterminado para el atributo alt utilizando las variables
        $alt = 'Foto exterior ' . $nombre_marca . ' ' . $nombre_modelo . ' ' . $version;
    }

    // Generar el código HTML para mostrar la imagen con srcset y sizes
    echo wp_get_attachment_image( $image_id, 'imagen-coche-medium', false, array( 'loading' => $loading, 'class' => 'portada_principal_coche', 'alt' => $alt ) );
} else {
// Mostrar la imagen predeterminada
$default_image_url = GV360_PLUGIN_URL . 'public/assets/images/defaults/presentacion_azul.png';
$loading = ( $image_counter <= 4 ) ? 'eager' : 'lazy';
echo '<img src="' . esc_url( $default_image_url ) . '" alt="' . esc_attr( $nombre_marca . ' ' . $nombre_modelo . ' ' . $version ) . '" loading="' . $loading . '" class="portada_principal_coche" width="400" height="256" >';

}


?>
<?php 
if (!empty($iva_deducible)) {
    ?>
    <div class="overlay iva-deducible">
          <span class="total-fotos">IVA deducible</span>
        </div> <?php
}

?>

        <div class="overlay fotos">
            <i class="icon-photo_camera"></i><span class="total-fotos">5</span>
        </div>
        
        <?php

if (!empty($etiqueta_medioambiental)) {
    $img_src = GV360_PLUGIN_URL . 'public/assets/images/etiquetas-medioambientales/' . $etiqueta_medioambiental . '.svg';
    echo '<div class="overlay-etiqueta_medioambiental"><img class="etiqueta_medioambiental" height="50" width="50" src="' . esc_attr($img_src) . '" alt="Etiqueta medioambiental ' . esc_attr($etiqueta_medioambiental_label) . '"></div>';
}

        ?>
        
    </div>
    <div class="caca">
    <header class="header-card">


    <?php

// Variable para almacenar si se debe mostrar el logo
$mostrarLogo = true;

// Comprobar si el usuario está logueado
if (is_user_logged_in()) {
    // Obtener el valor del campo repeater
    $repeater = get_field('clientes_interesados', get_the_ID());

    // Contador de filas
    $contador = 0;

    // Comprobar si el valor del campo repeater es un array
    if (is_array($repeater)) {
        // Recorrer las filas del campo repeater
        foreach ($repeater as $fila) {
            // Comprobar si la casilla "ocultar petición" está desactivada
            if (!$fila['ocultar_peticion']) {
                // Incrementar el contador
                $contador++;
            }
        }
    }

    // Comprobar si el contador es mayor que 0
    if ($contador > 0) {
        // Mostrar el contador
        echo '<div class="contador-mensajes"><i class="icon-email"></i>' . $contador . '</div>';
        // Establecer la variable $mostrarLogo en false
        $mostrarLogo = false;
    }
}

// Comprobar si se debe mostrar el logo
if ($mostrarLogo) {
    ?>
    <div class="logo-container <?php echo esc_attr($forma_logo)?>">
        <?php
        echo wp_get_attachment_image( $logo_marca, 'full', false, array(
            'alt' => 'Logo de ' . ' ' . $nombre_marca,
            'title' => $nombre_marca,
            'height' => 120,
            'width' => 120,
            'class' => 'logo-marca',
            'loading' => 'lazy'
        ) );
        ?>
    </div>
    <?php
}
?>

      <div class="titulo-coche-card">
      <h2 itemprop="name"><span class="marca-modelo"><span class="marca" itemprop="brand" itemscope itemtype="https://schema.org/Brand"><span itemprop="name"><?php echo esc_html($nombre_marca);?></span></span> <span class="modelo" itemprop="model"><?php echo esc_html($nombre_modelo);?></span></span> <span class="version" itemprop="vehicleConfiguration"><?php echo esc_html($version);?></span></h2>
       
      </div>
      <div class="precio-card" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
      <?php

if ( $mostrar_contado ) { ?>
    <span class="cantidad" itemprop= "price"><?php echo esc_html( $precio_formateado ) . '<span class="symbol">€</span>';?></span>
    <meta content= "<?php echo esc_attr( $precio ); ?>"/>
    <meta itemprop= "priceCurrency" content= "EUR"/>
    <span class= "text-precio" itemprop= "priceSpecification">Al contado</span> <?php
} else { ?>
    <span class="cantidad" itemprop= "price"><?php echo esc_html($financiado_format) . '<span class="symbol">€</span>';?></span>
    <meta content= "<?php echo esc_attr( $financiado ); ?>"/>
    <meta itemprop= "priceCurrency" content= "EUR"/>
    <span class= "text-precio" itemprop= "priceSpecification">Financiado</span> <?php
} 
?>
      </div>
        </header>
    <div class= "info-card">
    <ul>
    <?php 
      if (!empty($ano)){ 
      ?>
      <li><i class= "icon-calendar_today"></i><div><span class="desplazamiento-span" itemprop= "dateVehicleFirstRegistered"><?php echo esc_html($ano); ?></span></div></li>
      <?php
      }
      if (!empty($cambio)){ ?>
        <li><i class= "icon-cambio"></i><div><span class="desplazamiento-span" itemprop= "vehicleTransmission"><?php echo esc_html($cambio); ?></span></div></li>
      <?php } 
           if (!empty($potencia)){ 
            ?>
            <li>
            <i class="icon-horse"></i><div>
            <span class="desplazamiento-span" itemprop="vehicleEngine" itemscope itemtype="https://schema.org/EngineSpecification">
                <meta itemprop="enginePower" content="<?php echo esc_attr($potencia);?>">
                <span><?php echo esc_html($potencia) . 'cv'; ?></span>
            </span></div>
            </li>
            <?php
            }
            if (!empty($kilometros)){ 
                ?>
                    <li>
                        <i class="icon-map"></i><div>
                        <span class="desplazamiento-span" itemprop="mileageFromOdometer" itemscope itemtype="https://schema.org/QuantitativeValue">
                            <meta itemprop="value" content="<?php echo esc_attr($kilometros);?>">
                            <meta itemprop="unitCode" content="KMT">
                            <span><?php echo esc_html($km_formateado) . 'km';?></span>
                        </span></div>
                    </li>
                <?php
                }
       if (!empty($nombre_carroceria)){ 
        ?>
        <li><i class= "icon-car"></i><div><span class="desplazamiento-span" itemprop= "bodyType"><?php echo esc_html($nombre_carroceria); ?></span></div></li>
        <?php
       }
       if (!empty($combustible)){ 
        ?>
            <li>
                <i class="icon-combustible"></i><div>
                <span class="desplazamiento-span" itemprop="fuelType"><?php echo esc_html($combustible);?></span></div>
            </li>
        <?php
        }
       ?>
</ul>
<footer class="footer-card">



      <?php

if ( $mostrar_contado ) { ?>
     <div class="precio-card-container mostrar-contado">
        <div class="precio-card" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
            <span class="cantidad" itemprop= "price"><?php echo esc_html( $precio_formateado ) . '<span class="symbol">€</span>';?></span>
            <meta content= "<?php echo esc_attr( $precio ); ?>"/>
            <meta itemprop= "priceCurrency" content= "EUR"/>
            <span class= "text-precio" itemprop= "priceSpecification">Al contado</span>
        </div>  <!-- /precio-card-->
     </div> <!-- /precio-card-container-->
    <div class="precio-card-container mostrar-contado">
        <div class="precio-card" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
            <span class="cantidad" itemprop= "price?"><?php echo esc_html($financiado_format) . '<span class="symbol">€</span> financiado';?></span>  
            <meta content= "<?php echo esc_attr( $financiado_format ); ?>"/>
            <meta itemprop= "priceCurrency" content= "EUR"/>
            <span class= "text-precio" itemprop= "priceSpecification">Financiado</span> 

        </div> <!-- /precio-card-->
    </div> <!-- /precio-card-container--><?php
        
} else { ?>
    <div class="precio-card-container mostrar-financiado">
        <div class="precio-card" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
            <span class="cantidad" itemprop= "price"><?php echo esc_html( $precio_formateado ) . '<span class="symbol">€</span>';?></span>
            <meta content= "<?php echo esc_attr( $precio_formateado ); ?>"/>
            <meta itemprop= "priceCurrency" content= "EUR"/>
            <span class= "text-precio" itemprop= "priceSpecification">al contado</span> 
        </div> <!-- /precio-card -->
        <div class="precio-card financiado" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
            <span class="cantidad" itemprop= "price"><?php echo esc_html($financiado_format) . '<span class="symbol">€</span>';?></span>
            <meta content= "<?php echo esc_attr( $financiado ); ?>"/>
            <meta itemprop= "priceCurrency" content= "EUR"/>
            <span class= "text-precio" itemprop= "priceSpecification">Financiado</span> 
        </div> <!-- /precio-card -->
    </div> <!-- /precio-card-container-->
<?php
} ?>
      


<?php




if ( $mostrar_contado ) { ?>

<?php
} else { ?>

<?php
} 
?>
</footer>
      
    </div>
</div> <!-- caca -->
  </a>
  <?php

if ( current_user_can( 'edit_posts' ) ) {
    ?> <div class="wrapper-admin-control"> <?php
    if ( is_user_logged_in() && get_post_field( 'menu_order', get_the_ID() ) != 0 ) : ?>
        
        <div class="orden-coche"> Orden <span> <?php echo get_post_field( 'menu_order', get_the_ID() ); ?> </span></div> 
    <?php endif;
    edit_post_link( 'Editar coche', '<div class="boton-editar-coche">', '</div>', null, 'button' );
    ?>
    </div> <?php
}

?>
</article>
<?php 
endwhile;
?>
</div> <!-- Contenedor_coches-->