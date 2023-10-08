<?php
/**
* Sección características
* @package gv360
*
*/

defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );
?>
<section class="section-caracteristicas" id="seccion-caracteristicas">
    <h2>Características</h2>
    <ul>
      <li><i class="icon-calendar_today"></i><span class="caract">Año</span><span class="valor"><?php echo esc_html($ano);?></span></li>
      <li><i class="icon-map_outline"></i><span class="caract">Kilómetros</span><span class="valor"><?php echo esc_html($km_formateado) . '<span class="sufijo">km</span>';?></span></li>
      <li><i class="icon-car"></i><span class="caract">Carrocería</span><span class="valor"><?php echo esc_html($nombre_carroceria);?></span></li>
      <li><i class="icon-cambio"></i><span class="caract">Cambio</span><span class="valor"><?php echo esc_html($cambio);?></span></li>
      <li><i class="icon-car-door"></i><span class="caract"><?php echo esc_html($puertas);?></span><span class="valor">Puertas</span></li>
      <li><i class="icon-asiento"></i><span class="caract"><?php echo esc_html($plazas);?></span><span class="valor">Plazas</span></li>
      <li><i class="icon-horse"></i><span class="caract">Potencia</span><span class="valor"><?php echo esc_html($potencia) . '<span class="sufijo">cv</span>'; ?></span></li>
      <li class="color <?php echo 'color-' .  esc_attr($color_value);?>"><i class="icon-paleta_outline"></i><span class="caract">Color</span><span class="valor"><?php echo esc_html($color_label);?></span></li>
      <li><i class="icon-combustible"></i><span class="caract">Combustible</span><span class="valor"><?php echo esc_html($combustible);?></span></li>
      <?php if (!empty($etiqueta_medioambiental)) { ?> 
        <li>
        <?php
        $img_src = GV360_PLUGIN_URL . 'public/assets/images/etiquetas-medioambientales/' . $etiqueta_medioambiental . '.svg';
          echo '<img class="etiqueta_medioambiental" height="50" width="50" src="' . esc_attr($img_src) . '" alt="Etiqueta medioambiental ' . esc_attr($etiqueta_medioambiental_label) . '">';?>
        <span class="caract">Etiqueta</span>
        <span class="valor">C</span>
        </li><?php
      } ?>
    
    </ul>
</section><!--caracteristicas-->