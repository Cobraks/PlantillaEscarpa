<?php
defined( 'ABSPATH' ) or die( 'Acceso directo no permitido.' );
//Tarjeta del coche

/*
echo '<p>Debug: Carga template para ' . get_the_ID() . '</p>';
?>

<p>Debe repetirse en todas [][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]</p>
<?php
while ( have_posts() ) : the_post();

   

?>
<div style="display:inline-block;width:fit-content;margin: 2px;border:solid 1px orange;">
<p>Esta es la tarjeta del coche</p>
<h2><?php the_title(); 


?></h2>
<?php 
echo 'contenido de tarjeta-coche:';
//Debug
echo '<p>Debug: Iniciando el bucle para el coche ' . get_the_ID() . '</p>';





// Recupera y muestra la carrocería del coche
$carrocerias = get_the_terms( get_the_ID(), 'carroceria' );
if ( $carrocerias && ! is_wp_error( $carrocerias ) ) {
 $carroceria = $carrocerias[0]->name;
 echo '<p>Carrocería: ' . esc_html( $carroceria ) . '</p>';
}


// Recupera y muestra la marca del coche
$marcas = get_the_terms( get_the_ID(), 'marca' );
if ( $marcas && ! is_wp_error( $marcas ) ) {
$marca = $marcas[0]->name;
echo '<p>Marca: ' . esc_html( $marca ) . '</p>';
}


$terms_modelo= get_the_terms( get_the_ID(), 'modelo' );
if ( $terms_modelo && ! is_wp_error( $terms_modelo ) ) {
$modelo = $terms_modelo[0]->name;
echo '<p>Modelo: ' . esc_html( $modelo ) . '</p>';
}?>

<p>Esto es también un template part (la tarjeta)</p>
<?php the_content(); ?>
</div>
<?php
endwhile;
*/

