
<?php get_header(); ?>


 <div class="container">



<section id="smaken" class="smaak">
        <div class=" text-center">
          
     
     <div class="row z-depth-2 content">

            <!-- LOOP -->

              <h2 class="title">Smaken</h2>
               <?php while ( have_posts()) : the_post(); ?>
          
                    <a href="<?php echo get_post_field('post_name', get_post());?>"
 >
                    <div class="smaakbox">
                  
                      <?php the_post_thumbnail();     ?>

                            <h5> <?php the_title(); ?> </h5>
               
                    <?php the_content(); ?></div></a>

                   
                <?php endwhile; ?>
                 </div>

        </div>
    </section><!--//smaken-->

    

<?php get_footer(); ?>