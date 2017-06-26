<?php /* The template for displaying all single posts. */ ?>

<?php get_header(); ?>

<?php
  if ( have_posts() ) : //start loop
    while ( have_posts() ) :
      the_post();
      the_title( '<h1 class="post__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
      if ( has_post_thumbnail() ) {
        the_post_thumbnail('fullsize', array('class' => 'post__featured-image'));
      }
      the_content();
    endwhile;
  endif; //end loop
?>

<?php get_footer(); ?>
