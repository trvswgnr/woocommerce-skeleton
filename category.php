<?php /* The template for displaying category pages. */ ?>

<?php get_header(); ?>
<?php
  if ( have_posts() ) :
    while ( have_posts() ) :
      the_post();
      the_content();
    endwhile;
    the_posts_navigation();
  else :
    if ( is_home() && current_user_can( 'publish_posts' ) ) :
      echo "Go publish your first post!";
    endif;
  endif;
?>
<?php get_footer(); ?>
