<?php get_header(); ?>

<section class="page-content container">
  <?php
  while (have_posts()) :
    the_post();
    the_content();
  endwhile;
  ?>
</section>

<?php get_footer(); ?>