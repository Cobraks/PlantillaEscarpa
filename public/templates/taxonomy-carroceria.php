<?php
get_header();
?><h1>PLANTILLA CARROCERÍA?¿</h1><?PHP
$term = get_queried_object();
$logo_marca = get_field( 'logo_marca', $term );
$complemento_nombre = get_field('complemento_nombre', 'option');
?>

<?php
echo 'Logo marca:';
if( $logo_marca ) {
         echo wp_get_attachment_image( $logo_marca, 'full', false, array(
            'alt' =>  $term->name . ' ' . $complemento_nombre,
            'title' => $term->name
        ) );
}
if ( have_posts() ) :
  echo 'Hay post';
  // get_template_part( '/template-parts/loop', 'coches' );
  ?>
  <section class="contenedor-wrapper-coches">
  <?php
  include( GV360_PLUGIN_DIR . 'public/templates/template-parts/loop-coches.php' );
  ?>
  </section>
  <?php
else :
  // No hay publicaciones para mostrar
  echo 'No hay post';
  // Mostrar mensaje de "No se encontraron publicaciones" aquí
endif;  
      ?>




<div id="primary" class="content-area">
  <?php echo $term->name;?>
    <main id="main" class="site-main">
        <?php if ( have_posts() ) : ?>
            <header class="page-header">
              <p>Plantilla común para el listado (listadocoches-content.php)</p>
              <p>Incluye el buscador, los ordenes, el wrapper para los coches (aquí de nuevo hay un if have post)</p>
              <h2>wey</h2>
                <?php
                    the_archive_title( '<h1 class="page-title">', '</h1>' );
                    the_archive_description( '<div class="archive-description">', '</div>' );
                ?>
            </header>
            <div class="car-cards-container">
            <?php
         
            while ( have_posts() ) :
                the_post();
             
              
                include( GV360_PLUGIN_DIR . 'public/template-parts/tarjeta-coche.php' );
              
            endwhile;
            ?>
            </div>
            <?php
            the_posts_navigation();
        else :
            get_template_part( 'public/template-parts/content', 'none' );
        endif;
        ?>
    </main>
</div>

<?php get_sidebar(); ?>



























<!-- 

<div class="container">
<H1>TAXONOMY MARCA</H1>
<div class="row">
    <div class="col-md-3">
      
    Icon:<span class="icon-altavoz_outline">i</span>
      <?php /* get_template_part( 'template-parts/filtro', 'coches' ); 
       
       ?>
       <br><br><br><br><br><br><br><br><br><br><br><br>
       <?php echo get_field('telefono-principal', 'option'); ?>
       <?php
       echo 'princi:';
       
       $telefono_principal = get_field('telefono-principal', 'option');
      ?>
      <br><br><br>
    </div>
    <div class="col-md-9">
      <?php
        get_template_part( 'template-parts/listado', 'coches' ); 
      ?>
      Variables:
      <?php
      //$telefono_principal = get_field('telefono-principal', 'option');
      //echo esc_html($telefono_principal);
     
     
     
     
     
     
     
     
     
  
    
      
      // Utilizamos los valores de los campos personalizados
      echo 'Teléfono principal: ' . $telefono_principal;
     // echo 'Correo electrónico: ' . $correo_electronico;
     
     
     
     
     
     
     
     
     
     ?>











    </div>
  </div>
</div> -->
   */   