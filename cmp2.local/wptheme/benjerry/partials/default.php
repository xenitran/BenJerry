<?php

if(have_posts()) 
{
    while(have_posts())
    {
      
        //Print the title and the content of the current post         
?>
<?php get_nav_menu_locations() ?>
 

  
 <div class="section ">
<?php  the_post(); ?>
                                
<div class="parallax-container">
      <div class="parallax">    
      <?php the_post_thumbnail(array(1600,800)) ?></div>
</div>
     <div class="row content">
        <h3> <?php the_title(); ?></h3>
        <p class="light"><?php  the_content(); ?></p>
     </div>

</div>

 
<?php
    }
}
else
{
    echo 'No content available';
    
}