
<?php get_header(); ?>



<section id="smaken" class="smaak section">
              <div class="row">
                <div class="col s12">
                  <h2>Onze lactosevrije smaken</h2>
                </div>
             </div>
 
</section>
<section id="smaken" class="smaak">
        <div class=" text-center">
          
     
     <div class="row z-depth-2 content">

        <!-- LOOP -->

        <?php while ( have_posts()) : the_post(); ?>
        

          <a href="<?php echo get_post_field('post_name', get_post());?>">
                   <div class="smaakbox effect">

                       <?php the_post_thumbnail('', array(
                        'class' => 'image',
                        )); ?>
                       <?php
                    //open potje afb oproepen
                     if (class_exists('MultiPostThumbnails')
                    && MultiPostThumbnails::has_post_thumbnail('smaken', 'open-image')) :
                    MultiPostThumbnails::the_post_thumbnail('smaken', 'open-image', NULL, 'post-secondary-image-thumbnail image hover'); endif;
                         ?>
              
              
                <a href="<?php echo get_post_field('post_name', get_post());?>">
                <h5> <?php the_title(); ?> </h5>
        
                <?php the_content(); ?>

                  </div></a>
                <?php endwhile; ?>
         </div>
     </div>
</section><!--//smaken-->

    

<?php get_footer(); ?>