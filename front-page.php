<?php /* The template for displaying the Home Page */ ?>

<?php get_header(); ?>
<h1>This is the Home Page</h1>
<?php
  if ( have_posts() ) :
    while ( have_posts() ) :
      the_post();
      the_content();
    endwhile;
  endif;
?>
<?php get_footer(); ?>
