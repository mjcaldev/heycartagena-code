<?php
/**
 * Blog listing template (index.php)
 * 
 * This template controls the main blog listing page.
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
