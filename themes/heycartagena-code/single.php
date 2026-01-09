<?php
/**
 * Single post template (single.php)
 * 
 * This template controls individual blog post pages.
 */
get_header();
?>

<section class="content container">
  <?php
  while (have_posts()) :
    the_post();
    the_content();
  endwhile;
  ?>
</section>

<?php get_footer(); ?>

