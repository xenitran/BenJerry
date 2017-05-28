
<?php get_header(); ?>

<section id="waarden" class="waarden section">
              <div class="row">
                   <div class="col s12">

<h2>Ben &amp; Jerry's recepten</h2>
</div>
                </div>
      
</section>


<section>
<div class="row z-depth-2 ">
   



<?php $i = 1; while (have_posts() && $i < 6) : the_post(); ?>

    <div class="card recept">
        <a href="<?php echo get_post_field('post_name', get_post());?>">

        <div class="card-image">
        <?php the_post_thumbnail(array(800,400)) ?> 
        <span class="card-title"> <?php the_title(); ?></span> </a>
        </div>
    </div>
    
               
   <?php $i++; endwhile; ?>
 

<div class="previouspost right z-depth-2"><?php next_posts_link( 'Volgende recepten' ); ?></div>
<div class="nextpost left z-depth-2"><?php previous_posts_link( 'Vorige recepten' ); ?></div>
</div>
</section>




<?php get_footer(); ?>

