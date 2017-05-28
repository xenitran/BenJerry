

<?php 
if(have_posts()) 
{
    while(have_posts())
    {
  
?>
<?php get_nav_menu_locations() ?>
    

  
 <div class="section">
              <div class="row">
                    <?php  the_post(); ?>
                <div class="col s12">
                          
                  <div class="card horizontal">
                    <?php the_post_thumbnail(array(1600,800)) ?>
                    <div class="card-content">
                   <a href="<?php the_permalink(); ?>"><h5> <?php the_title(); ?></h5></a> 
                    <p class="light"><?php  the_content(); ?></p>
                    <div class="card-action">
                 
                   <a href="<?php the_permalink(); ?>"><?php Echo Get_post_meta(get_the_ID(), 'Link',true); ?></a>
                </div>
                </div>
 
                  </div>
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
