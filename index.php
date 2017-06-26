<?php /* The main template file. */ ?>

<?php get_header(); ?>

<?php
  if ( have_posts() ) : //start loop
    while ( have_posts() ) :
      the_post();
      the_content();
    endwhile;
  endif; //end loop
?>

<?php get_footer(); ?>
