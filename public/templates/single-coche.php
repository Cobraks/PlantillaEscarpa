<?php
/*RCsuL4rd5MJTghqdSNVkiB8mZ-liHFjN12wo-GC8sjc
Antigua dns fjdmotor
/**
 * Single-coche.php
 *
 * @package gv360
 */

if (!defined('ABSPATH')) {
  exit;
}



get_header();?>
<style>
    
#loading span {
    display: inline-block;
    margin: 0 2px;
    font-size: 20px;
    animation: loading 1s infinite;
}

#loading span:nth-child(2) {
    animation-delay: 0.2s;
}

#loading span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes loading {
    0% { transform: scale(1); }
    50% { transform: scale(1.5); }
    100% { transform: scale(1); }
}

</style>
<?php


$precio_financiado = get_field('precio_y_descuentos_precio_financiado');
$field_tin = get_field( 'opciones_financiacion_tin', 'option' );
$value_tin = $field_tin['value'];
$label_tin = $field_tin['label'];
$seguro = get_field('opciones_financiacion_con_seguro', 'option');
 if (($seguro) == 1 ) {
    $valor_seguro = 'SÍ';
  } else {
    $valor_seguro = 'NO';
  }
// Variables de cada coche

$marcas = get_the_terms(get_the_ID(), 'marca');
if ($marcas && !is_wp_error($marcas)) {
  // Obtener el primer término
  $marca = $marcas[0];
  // Asignar nombre_mraca a nombre del término
  $nombre_marca = $marca->name;
  // Obtener el valor del campo "logo_marca" para este término
  $logo_marca = get_field('logo_marca', $marca);
  $logo_marca_white = get_field('logo_marca_white', $marca);
  $forma_logo = get_field('forma_del_logo', $marca);
} else {
  // No hay términos de la taxonomía "marca" asociados a esta publicación
  $nombre_marca = 'Sin marca';
  $logo_marca = 'imagen genérica'; /*Cambiarlo por imagen genérica*/
}
//Carrocería
$carrocerias = get_the_terms(get_the_ID(), 'carroceria');
if ($carrocerias && !is_wp_error($carrocerias)) {
  $carroceria = $carrocerias[0];
  $nombre_carroceria = $carroceria->name;
} else {
  $nombre_carroceria = '';
}
//Modelos
$modelos = get_the_terms(get_the_ID(), 'modelo');
if ($modelos && !is_wp_error($modelos)) {
  $modelo = $modelos[0];
  $nombre_modelo = $modelo->name;
} else {
  $nombre_modelo = '';
}
$ano = get_field('datos_generales_ano');
$kilometros = get_field('especificaciones_tecnicas_kilometros');
$km_formateado = number_format($kilometros, 0, ',', '.');
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
$traccion = get_field('especificaciones_tecnicas_traccion');
$puertas = get_field('especificaciones_tecnicas_puertas');
$plazas = get_field('especificaciones_tecnicas_asientos');
$color = get_field('datos_generales_color');

$eficiencia_consumo = get_field('especificaciones_tecnicas_eficiencia_consumo');

$aceleracion = get_field('especificaciones_tecnicas_aceleracion');



$color_value = $color['value'];
$color_label = $color['label'];

$link_coche = get_the_permalink();
$mostrar_contado = get_field('mostrar_contado', 'option');
$precio_formateado = number_format($precio, 0, ',', '.');
$precio_financiado = get_field('precio_y_descuentos_precio_financiado');

$entrada_maxima = $precio_financiado - 1000;

$financiado_formateado = number_format($precio_financiado, 0, ',', '.');

$descuento_financiacion = get_field('precio_y_descuentos_descuento_financiacion');
$descuento_formateado = number_format($descuento_financiacion, 0, ',', '.');

/*Esto es para los cálculos, pero los hacemos directamente en el backend y los tenemos ya guardados en la db*/
$financiado = $precio - $descuento_financiacion;
$financiado_format = number_format($financiado, 0, ',', '.');

$portada_coche = get_field('portada_coche');
$full_thmb = wp_get_attachment_image_src($portada_coche, 'full');

/*Galerías*/
$unir_galerias = get_field( 'galeria_de_fotos_unir_galerias' );

// Obtener el valor del campo como un array
$video_field_value = get_field('otros_datos_video_ficha_archive', get_the_ID());
// Obtener la URL del vídeo del array
if ($video_field_value) {
  $video_url = $video_field_value['url'];
}

//global $videoUrl;
$image_counter = 0;

?>

<div class="content-wrapper">
  <main id="single_coche" class="main-single-coche">
   <!-- <div class="contenedor-ficha">
      <aside class="barra-izquierda">
  barra izquierda
      </aside>
      <div class="contenido-coche">
        <section class="seccion-ficha">
          hero, caracteristicas etc
        </section>
      </div>
      <aside class="barra-derecha">
  barra derecha
      </aside>
    </div> -->

    <?php
    if ($video_field_value ) { ?>
      <div id="video-container">
      <?php
        // Mostrar el vídeo
        echo '<video controls autoplay muted loop>';
        echo '<source src="' . $video_url . '" type="video/mp4">';
        echo 'Tu navegador no soporta la etiqueta de vídeo.';
        echo '</video>';
      ?>
        <div class="title-ficha-container">
  
          <div class="titulo-coche-ficha">
  
            <div class="logo-container <?php echo esc_attr($forma_logo) ?>">
              <?php
                  echo wp_get_attachment_image($logo_marca_white, 'full', false, array(
                  'alt' => 'Logo de ' . ' ' . $nombre_marca,
                  'title' => $nombre_marca,
                  'height' => 120,
                  'width' => 120,
                  'class' => 'logo-marca',
                  'loading' => 'lazy'
                ));
              ?>
            </div>
              <div class="h1-wrapper">
            <h1 itemprop="name">
              <span class="marca-modelo">
                <span class="marca" itemprop="brand" itemscope itemtype="https://schema.org/Brand">
                  <span itemprop="name"><?php echo esc_html($nombre_marca); ?>
                  </span>
                </span>
                <span class="modelo" itemprop="model"><?php echo esc_html($nombre_modelo); ?>
                </span>
              </span>
              <span class="version" itemprop="vehicleConfiguration"><?php echo esc_html($version); ?>
              </span>
            </h1>
                <div class="datos-resumen">
                  <?php if ($ano){ ?> Año <b><?php echo esc_html($ano); ?></b> / <?php } ?> <?php if ($kilometros) { echo esc_html($km_formateado) . 'km'; ?> / <?php } if ($combustible) { echo esc_html($combustible); ?> / <?php } if ($cambio) { echo esc_html($cambio); ?> / <?php } if ($nombre_carroceria) { echo esc_html($nombre_carroceria); ?> / <?php } if ($potencia){ echo '<b>' . esc_html($potencia) . '</b>'.  'cv'; }?>
                </div>
            </div>
  
            <div class="precio-ficha" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
            <?php
            if ($mostrar_contado) { ?>
              <span class="cantidad" itemprop="price"><?php echo esc_html($precio_formateado) . '<span class="symbol">€</span>'; ?>
              </span>
              <meta content="<?php echo esc_attr($precio); ?>" />
              <meta itemprop="priceCurrency" content="EUR" />
              <span class="text-precio" itemprop="priceSpecification">Al contado</span>
              <?php
            } else { ?>
              <span class="cantidad" itemprop="price"><?php echo esc_html($financiado_format) . '<span class="symbol">€</span>'; ?></span>
              <meta content="<?php echo esc_attr($financiado); ?>" />
              <meta itemprop="priceCurrency" content="EUR" />
              <span class="text-precio" itemprop="priceSpecification">Financiado</span>
              <?php
            }?>
            <p class="text-contado">12.000€ al contado</p>
            <!-- <button>¡Me interesa!</button> -->
            </div>
          </div>
        </div>
      </div> <!--Video container-->
        
    <?php
    } else { //Si no hay vídeo 
    ?>
      <section class="titulo-no-video">
  
        <div class="titulo-coche-ficha">
  
          <div class="logo-container <?php echo esc_attr($forma_logo) ?>">
          <?php
            echo wp_get_attachment_image($logo_marca, 'full', false, array(
            'alt' => 'Logo de ' . ' ' . $nombre_marca,
            'title' => $nombre_marca,
            'height' => 120,
            'width' => 120,
            'class' => 'logo-marca',
            'loading' => 'lazy'
          ));
          ?>
          </div>
  
          <h1 itemprop="name">
            <span class="marca-modelo">
              <span class="marca" itemprop="brand" itemscope itemtype="https://schema.org/Brand">
                <span itemprop="name"><?php echo esc_html($nombre_marca); ?>
                </span>
              </span>
              <span class="modelo" itemprop="model"><?php echo esc_html($nombre_modelo); ?>
              </span>
            </span>
            <span class="version" itemprop="vehicleConfiguration"><?php echo esc_html($version); ?>
            </span>
          </h1>
  
          <div class="precio-ficha" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
            <?php
            if ($mostrar_contado) { ?>
              <span class="cantidad" itemprop="price"><?php echo esc_html($precio_formateado) . '<span class="symbol">€</span>'; ?></span>
              <meta content="<?php echo esc_attr($precio); ?>" />
              <meta itemprop="priceCurrency" content="EUR" />
              <span class="text-precio" itemprop="priceSpecification">Al contado</span> <?php
            } else { ?>
              <span class="cantidad" itemprop="price"><?php echo esc_html($financiado_format) . '<span class="symbol">€</span>'; ?></span>
              <meta content="<?php echo esc_attr($financiado); ?>" />
              <meta itemprop="priceCurrency" content="EUR" />
              <span class="text-precio" itemprop="priceSpecification">Financiado</span> <?php
            } ?>
          </div>
  
        </div> <!--titulo coche ficha-->
      </section>
        <?php
        } //Fin si no hay vídeo
        ?>


    <nav id="menu-navegacion-container">

      <!-- El menú de navegación se agregará aquí -->

    </nav>



    <section class="container-secciones">
<div>




<?php
//Sección galería
// Verificar si alguna de las galerías tiene imágenes
$galeria_unida = get_field('galeria_de_fotos_galeria_unida');
$galeria_interior = get_field('galeria_de_fotos_galeria_interior');
$galeria_exterior = get_field('galeria_de_fotos_galeria_exterior');

if ($unir_galerias && !empty($galeria_unida)) {
    // Hay imágenes en la galería unida, entonces carga el include
    include GV360_PLUGIN_DIR . "public/templates/template-parts/content/galeria-ficha.php";
} elseif (!$unir_galerias && (!empty($galeria_interior) || !empty($galeria_exterior))) {
    // Hay imágenes en al menos una de las galerías interior o exterior, entonces carga el include
    include GV360_PLUGIN_DIR . "public/templates/template-parts/content/galeria-ficha.php";
}

//Sección características 
include GV360_PLUGIN_DIR . "public/templates/template-parts/content/seccion-caracteristicas.php"; 

//Sección ficha técnica
include GV360_PLUGIN_DIR . "public/templates/template-parts/content/seccion-ficha-tecnica.php"; ?>

  </section> <!--sección principal-->
  <aside>
  <div class="datos-resumen-mobile">
    <ul><?php 
      if ($ano) { 
        echo '<li>' . esc_html($ano) . '</li>';
      } if ($kilometros) { 
        echo '<li>' . esc_html($km_formateado) . 'km</li>';
      } if ($combustible) { 
        echo '<li>' . esc_html($combustible) . '</li>'; 
      } if ($cambio) { 
        echo '<li>' . esc_html($cambio) . '</li>'; 
      } if ($nombre_carroceria) { 
        echo '<li>' . esc_html($nombre_carroceria) . '</li>'; 
      } if ($potencia) {
        echo '<li><b>' . esc_html($potencia) . '</b>cv</li>'; 
      } ?>
    </ul>
  </div>
  <div style="background:white; padding:2rem; border-radius:4rem;margin:0 auto;width:50%">
<?php echo '<b> Precio financiado: </b>' . $precio_financiado;?><br><br>
<span><b>Coeficiente:</b> </span><span id="coeficiente"></span><br>
<?php echo '<b>TIN: </b> ' . $label_tin;?><br>
<?php echo '<b> Seguro: </b> ' .  $valor_seguro;?><br>
<span><b>Meses:</b> </span><span id="meses"></span><br><br>
<span><b>Cuota: </b> </span><span id="cuota"></span><br>
<span><b>Cuota redondeada: </b></span><span id="cuota-redondeada"></span><div id="loading" style="display: none;">
    <span>.</span><span>.</span><span>.</span>
</div>
<br>

<?php
//   echo '<b>Valor tin: </b> ' . $value_tin;  ?>
  
  
  <?php //echo '<b> Seguro: </b> ' .  $valor_seguro;?>
  <?php /* if (($seguro) == 1 ) {
    echo '<b> Con seguro </b><br>';
  } else {
    echo '<b> Sin seguro </b><br>';
  } */?>
  <?php // echo '<b> Precio financiado: </b>' . $precio_financiado;?>

<form id="mesesForm">
    <p><b>Plazos:</b></p>
    <input type="radio" name="meses" value="60" > 60
    <input type="radio" name="meses" value="72"> 72
    <input type="radio" name="meses" value="84"> 84
    <input type="radio" name="meses" value="96" checked> 96
    <p><b>Entrada: </b></p>
    <input type="text" id="entrada" name="entrada" placeholder="0€">

</form>
<div id="entrada"></div>
<div>
  

</div>
</div>
  <div class="personalizar-financiacion">
          <div class="titulo-financiacion"><span>Personalizar financiación</span><i class="icon-arrow_forward"></i></div>
          <p class="resultado-cuota">Desde 299€ al mes</p>
          <div style="display:none" class="deslizar-financiacion">
            <div class="wrapper-input">
              <div class="wrapper-input-label">
                <label>Entrada</label>
                <div><span id="valorEntrada"></span>€</div>
              </div>
              <div class="slider-container">
                <input type="range" min="0" max="<?php echo esc_attr($precio_financiado);?>" step="300" value="0" class="slider" id="entradaSlider">
              </div>
            </div>



            <div class="wrapper-input">
  <div class="wrapper-input-label">
    <label>Entrada</label>
    <div><span id="valorEntradaNoUi"></span>€</div>
  </div>
  <div class="slider-container">
    <div id="entradaSliderNoUi"></div>
    <div class="tooltips">
      <span>0€</span>
      <span> <?php echo esc_html(number_format($entrada_maxima, 0, ',', '.') . '€');
?></span>
    </div>
  </div>
</div>
<!-- _acme-challenge.fjdmotor.es.		TXT	cOmUH8qXIf-_rbqPOaEGGqX3aAmuuJ6CgTlVcjwdOkg 

ns2.grupomuromultiservicios.es.	
	ns1.grupomuromultiservicios.es.

-->





            <div class="wrapper-input">
              <label>Periodo</label>
              <p>72 meses</p>
            </div>
            <div class="wrapper-input-mensaje">
              <p>Fináncialo por</p>
              <p class="resultado-mensaje">230€ al mes a 72 meses*</p>
              <p class="a-cambio">* Financiación estimada y no vinculante</p>
            </div>
          </div>








          
        </div>
  <div class="ficha-cta border-radius">
        <div class="wrapper-precio">
            <span style="display:none;" class="titulo-precio">Precio financiado</span>
            <ul class="vertical">
                <li>
                    <span class="izquierda">Precio contado inicial</span>
                    <span class="derecha"><?php echo esc_html($precio_formateado).'€';?></span>
                </li>
                                <li>
                    <span class="izquierda">Descuento financiación</span>
                    <span class="derecha">-<?php echo esc_html($descuento_formateado).'€';?></span>
                </li>
                                <li>
                    <span class="izquierda">Revisión pre-entrega 50 puntos</span>
                    <span class="derecha">Gratis</span>
                </li>
                                  <li>
                    <span class="izquierda">12 meses de garantía</span>
                    <span class="derecha">Gratis</span>
                  </li>
                                  
                
                                <li class="precio-final">
                    <span class="izquierda">Precio Final</span>
                    <span class="derecha"><?php echo esc_html($financiado_formateado);?><span class="sufijo">€</span></span>
                </li>
                 
            </ul>
        </div>
       <p class="a-cambio"> Si tienes un coche a cambio, te lo tasamos y lo descontamos del precio final</p>

       <div class="button-wrapper">
          
           <button id="me-interesa">¡Me interesa!</button>
       </div>


         </div>

</div>


        <!--Fin CTA-->
  </aside>

<?php

  ?>


  </main>
</div> <!--content-wrapper-->








    <section class="header-ficha-container">
      <div class="header-ficha-coche">

      <section class="wrapper-video">
       
   
         


   















          <div class="contenido-ficha">
   
      </div>

        </section>

        <aside class="tarjeta-ficha">



          <?php

          // Comprobar si el campo 'portada_coche' tiene un valor
          

          ?>
          
          <article class="ficha-tarjeta">
            <?php
            if ($image_id = get_field('otros_datos_portada_coche')) {
              // Incrementar el contador de imágenes
              $image_counter++;

              // Determinar el valor del atributo loading
              $loading = ($image_counter <= 5) ? 'eager' : 'lazy';

              // Obtener el valor del atributo alt
              $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
              if (empty($alt)) {
                // Establecer un valor predeterminado para el atributo alt utilizando las variables
                $alt = 'Foto exterior ' . $nombre_marca . ' ' . $nombre_modelo . ' ' . $version;
              }

              // Generar el código HTML para mostrar la imagen con srcset y sizes
              echo wp_get_attachment_image($image_id, 'imagen-coche-medium', false, array('loading' => $loading, 'class' => 'portada_principal_coche', 'alt' => $alt));
            } else {
              // Mostrar la imagen predeterminada
              $default_image_url = GV360_PLUGIN_URL . 'public/assets/images/defaults/presentacion_azul.png';
              $loading = ($image_counter <= 4) ? 'eager' : 'lazy';
              echo '<img src="' . esc_url($default_image_url) . '" alt="' . esc_attr($nombre_marca . ' ' . $nombre_modelo . ' ' . $version) . '" loading="' . $loading . '" class="portada_principal_coche" width="400" height="256" >';
            }
            ?>

          </article>





        <!--CTA-->
 
        </aside>

      </div> <!--header ficha coche-->
      </section>
     







      <!-- <section class="video-youtube-container">
    <iframe src="https://www.youtube.com/embed/a9-tGfYNi-s?autoplay=1&mute=1&controls=0&showinfo=0&loop=1&rel=0" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0" allowfullscreen></iframe>
</section> -->
      <?php
      // En su archivo PHP (video.php) /*
      if (isset($_POST['videoUrl'])) { /*
    $videoUrl = $_POST['videoUrl'];
    echo `<iframe src="${videoUrl}" frameborder="0" allowfullscreen></iframe>`;

    */
      }

      ?>




      <script>
        /*   // 2. Este código carga la API de IFrame Player en una etiqueta <script> asíncrona.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. Esta función crea un <iframe> (y un reproductor de YouTube)
      // después de que se haya cargado el código JavaScript de la API.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '360',
          width: '640',
          videoId: 'M7lc1UVf-VE',
          playerVars: {
            'autoplay': 1,
            'controls': 0
          },
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 4. Las funciones API llaman a esta función cuando el reproductor está listo.
      function onPlayerReady(event) {
        event.target.playVideo();
      }

      var done = false;
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
          setTimeout(stopVideo, 6000);
          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      } */
      </script>


      <!-- <script src="https://www.youtube.com/iframe_api"></script> -->







      <?php
      // En tu archivo single-coche.php
      /*
$video_url = get_field('otros_datos_video_ficha');
if ($video_url) {
  parse_str(parse_url($video_url, PHP_URL_QUERY), $url_params);
  $video_id = $url_params['v'];
} else {
  $video_id = 'MINA2QOFOVA';
}
// global $video_id;
// Pasar el ID del video a JavaScript
//OJO, que poniendo el localize script aquí, no hace falta poner las globales (quitar de enqueue scripts)
wp_localize_script( 'gv360-single_coche', 'gv360_single_coche_data', array(
  'video_id' => $video_id
));

echo 'URL: ' . $video_url .' <br> ID: ' . $video_id; */
      ?>
      <!--
  <div id="video-container">
  <div id="video-player"></div>
  <div id="video-overlay"></div>
</div>
-->


</div> <!-- content wrapper -->
  

<div class="call-action border-radius wrapper-padding">
       <!-- <div class="titulo-llamada">
            <img src="/logo-ford.svg">
              <img class="logo-marca" src="https://www.showcars.es/wp-content/uploads/2023/05/mini-logo-1.svg" height="48" width="48" alt="Logo de Mini "> 
                       
            <div>
                <span class="marca-modelo">
                Mini COOPER                </span>
                <span class="version">
                JOHN COOPER WORKS                </span>
                <span class="cantidad">
                33.600 €                </span>
            </div>
        </div> -->
       <div class="button-wrapper">
         
           <button id="me-interesa-mobile">¡Me interesa este BMW!</button>
       </div>
    </div>





<section class="section-single-coche">

  <?php echo 'Marca:' . $nombre_marca . ' ' . $nombre_modelo; ?>
  <?php while (have_posts()) : the_post(); ?>
    <?php the_content(); ?>
    <?php // get_template_part( 'template-parts/content', 'coche' );



    echo 'ARCHIVE VIDEO:';


    /*
// Obtener la URL del vídeo
// Obtener el valor del campo como un array
$field_value = get_field('otros_datos_video_ficha_archive', get_the_ID());

// Obtener la URL del vídeo del array
$video_url = $field_value['url'];

// Mostrar el vídeo
if ($video_url) {
  echo '<video controls>';
  echo '<source src="' . $video_url . '" type="video/mp4">';
  echo 'Tu navegador no soporta la etiqueta de vídeo.';
  echo '</video>'; 
}

*/











    echo do_shortcode('[contact-form-7 id="8728" title="Me interesa"]');

    // Recuperar los valores de las variables de consulta
    $marca = get_query_var('gv360_marca');
    $carroceria = get_query_var('gv360_carroceria');
    $modelo = get_query_var('gv360_modelo');
    $logo_marca = get_query_var('gv360_logo_marca');
    // Mostrar los valores de las variables
    /*echo 'marca::::' . $marca[0]->name;
echo '<br>Marca_name' . $marcaname[0]->name;
echo 'carro::::' . $carroceria[0]->name;
echo 'modelo::::' . $modelo[0]->name;
echo '<img src="' . $logo_marca . '" alt="Logo Marca">';
echo '<br>Enlace a la marca: <a href="' . get_term_link($marca[0]) . '">' . $marca[0]->name . '</a>';
      
      */
    ?>

    <?php the_post_navigation(); ?>


  <?php endwhile; ?>
</section> <!-- section single coche -->


<?php get_footer(); 
// include_once GV360_PLUGIN_DIR . 'public/template-parts/content-coche.php';
?>
