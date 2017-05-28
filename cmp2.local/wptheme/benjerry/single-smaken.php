
<?php get_header(); ?>

<?php 
if(have_posts()) 
{
    while(have_posts())
    {
      
        
?>
<?php get_nav_menu_locations() ?>
 
 <div class="section ">
              <div class="row content">
             <?php  the_post(); ?>

             <div class="col s12 m12 l3">
                      <div class=" smaak-img"><?php the_post_thumbnail() ?>
                      
                      </div>
            </div>
            <div class="col s12 m12 l9 smaakcontent">
                    <h3> <?php the_title(); ?></h3>
            
                    <p class="light"><?php  the_content(); ?></p>
                    <h5>Ingredienten:</h5>
                    
                    <p> <?php 
                      // oproepen van ingredienten megabox
                      Echo Get_post_meta(get_the_ID(), 'ingredienten',true); 
                      ?></p>

            <h5> Voedingswaardetabel: </h5>
                    <?php
                    //voedingsxaardetabel oproepen
                     if (class_exists('MultiPostThumbnails')
                    && MultiPostThumbnails::has_post_thumbnail('smaken', 'secondary-image')) :
                    MultiPostThumbnails::the_post_thumbnail('smaken', 'secondary-image', NULL, 'post-secondary-image-thumbnail'); endif;
                         ?>
          </div>
         </div>
</div>
<?php
    }
}
else
{
    echo 'No content available';
    
}

?>

  <div class="previouspost left z-depth-2"><?php previous_post_link( '%link','Vorige smaak' ) ?></div>
<div class="nextpost right z-depth-2"><?php next_post_link( '%link','Volgende smaak' ) ?></div>
<?php get_footer(); ?>