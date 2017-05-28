<?php get_header(); ?>

<?php get_template_part( 'partials/default'); ?>


<?php get_template_part( 'partials/comments'); ?>
  <div class="previouspost left z-depth-2"><?php previous_post_link( '%link','Vorig recept' ) ?></div>
<div class="nextpost right z-depth-2"><?php next_post_link( '%link','Volgend recept' ) ?></div>
<?php get_footer(); ?>