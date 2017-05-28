
<?php get_header(); ?>

<section id="waarden" class="waarden section">
              <div class="row">
                   <div class="col s12">

<h2>Onze waarden</h2>
</div>
                </div>
      
</section>

<?php 
if(have_posts()) 
{
    while(have_posts())
    {
  
?>
    

<section id="waarden" class="waarden section">

 <?php  the_post(); ?>
      <div class="row">
        <div class="col s12">
          <div class="card">
            <a href="<?php echo get_post_field('post_name', get_post());?>">
            <div class="card-image">
              <?php the_post_thumbnail(array(800,400)) ?>
              <span class="card-title">
              <?php the_title(); ?></a>
              </span>
            </div>
          </div>
        </div>
      </div>
                     
</section>

<?php
    }
}
else
{
    echo 'No content available';
    
}

?>
</div>
<?php get_footer(); ?>