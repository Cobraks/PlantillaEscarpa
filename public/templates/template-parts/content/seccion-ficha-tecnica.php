<?php
/**
 * caracteristicas-ficha.php
 *
 * @package gv360
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<section class="section-ficha-tecnica" id="seccion-ficha-tecnica">
  <h2 class="title">Ficha técnica</h2>
  <table itemscope itemtype="https://schema.org/Car">
    <!-- <thead>
      <tr>
        <th scope="col">Datos técnicos</th>
        <th scope="col">Descripción</th>
      </tr>
    </thead>-->
    <tbody>
      <?php if ($marca) { ?>  
          <tr itemprop="brand" itemscope itemtype="http://schema.org/Brand">
          <td>Marca</td>
          <td itemprop="name"><?php echo esc_html($nombre_marca);?></td>
          </tr>
          <?php
      } if ($modelo) { ?>  
          <tr itemprop="model" itemscope itemtype="http://schema.org/ProductModel">
          <td>Modelo</td>
          <td itemprop="name"><?php echo esc_html($nombre_modelo);?></td>
          </tr> <?php
      } if ($version) { ?> 
      <tr>
        <td>Versión</td>
        <td><?php echo esc_html($version);?></td>
      </tr> <?php
      } if ($ano) { ?> 
      <tr itemprop="releaseDate">
        <td>Año de fabricación</td>
        <td><?php echo esc_html($ano);?></td>
      </tr> <?php
      } if ($combustible) { ?>
      <tr itemprop="fuelType">
        <td>Tipo de combustible</td>
        <td><?php echo esc_html($combustible);?></td>
      </tr> <?php
      } if ($potencia) { ?>
      <tr itemprop="vehicleEngine" itemscope itemtype="http://schema.org/EngineSpecification">
        <td>Potencia</td>
        <td itemprop="enginePower"><?php echo esc_html($potencia) . 'cv'; ?></td>
      </tr> <?php 
      } if ($aceleracion) { ?> 
          <tr itemprop="releaseDate">
            <td>Aceleración</td>
            <td><?php echo esc_html($aceleracion) .'s';?></td>
          </tr> <?php
      }  if ($traccion) { ?>  
        <tr itemprop="" itemscope itemtype="http://schema.org/Brand">
        <td>Tracción</td>
        <td itemprop="name"><?php echo esc_html($traccion);?></td>
        </tr>
        <?php
    } if ($eficiencia_consumo) { ?> 
          <tr itemprop="releaseDate">
            <td>Consumo</td>
            <td><?php echo esc_html($eficiencia_consumo) .' L/100km';?></td>
          </tr> <?php
      }  if ($kilometros) { ?>
      <tr itemprop="mileageFromOdometer" itemscope itemtype="http://schema.org/QuantitativeValue">
        <td>Kilómetros</td>
        <td itemprop="value"><?php echo esc_html($km_formateado) . 'km';?></td>
      </tr> <?php
      } if ($puertas) { ?>
      <tr itemprop="numberOfDoors">
        <td>Número de puertas</td>
        <td><?php echo esc_html($puertas);?></td>
      </tr> <?php
      } if ($plazas) { ?>
      <tr itemprop="seatingCapacity">
        <td>Número de plazas</td>
        <td><?php echo esc_html($plazas);?></td>
      </tr> <?php
      } if ($color) { ?>
      <tr itemprop="color">
        <td>Color</td>
        <td><?php echo esc_html($color_label);?></td>
      </tr> <?php
      } if ($emisiones) { ?>
      <tr itemprop="emissionsCO2">
        <td>Etiqueta medioambiental</td>
        <td><?php $img_src = GV360_PLUGIN_URL . 'public/assets/images/etiquetas-medioambientales/' . $etiqueta_medioambiental . '.svg';
      echo '<div class="overlay-etiqueta_medioambiental"><img class="etiqueta_medioambiental" height="50" width="50" src="' . esc_attr($img_src) . '" alt="Etiqueta medioambiental ' . esc_attr($etiqueta_medioambiental_label) . '"></div>';
      echo 'Etiqueta ' . esc_html($etiqueta_medioambiental_label);?>
      </td>
      </tr> <?php
      } if ($cambio) { ?>
      <tr itemprop="vehicleTransmission">
        <td>Transmisión</td>
        <td><?php echo esc_html($cambio);?></td>
      </tr> <?php
      } if ($carroceria) { ?>
      <tr itemprop="bodyType">
        <td>Tipo de carrocería</td>
        <td><?php echo esc_html($nombre_carroceria);?></td>
      </tr> <?php
      } ?>
    </tbody>
  </table>
</section>