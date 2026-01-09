<?php
/**
 * Archive template (archive.php)
 * 
 * This template controls category, tag, and date archive pages.
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

