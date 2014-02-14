<?php get_header(); ?>

<article>
  <?php
  if ( have_posts() ) while ( have_posts() ) {
    the_post();
    echo "<h1>" . get_the_title() . "</h1>";
    the_content();
  }
  ?>
</article>

<?php get_footer(); ?>
