<?php
/**
 * Front Page template
 */
get_header();
?>

<section class="hero">
  <div class="container">
    <h1>Hey Cartagena</h1>
    <p>
      Local experiences, real recommendations, and help planning your trip to Cartagena, Colombia.
    </p>

    <div class="hero-actions">
      <a href="<?php echo esc_url(home_url('/experiences')); ?>" class="btn">
        Explore Experiences
      </a>
      <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-outline">
        Contact Us
      </a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <h2>What we help with</h2>
    <ul class="features">
      <li>Island trips & boat days</li>
      <li>Food & city tours</li>
      <li>Nightlife & transport</li>
      <li>Custom itineraries</li>
    </ul>
  </div>
</section>

<section class="section section-muted">
  <div class="container">
    <h2>Featured experiences</h2>
    <?php
    $experiences = heycartagena_tripadvisor_get_featured_experiences();

    // Rendering will be implemented once schema is finalized.
    // Currently handles _raw response or empty state with graceful fallback.
    if ( empty( $experiences ) || isset( $experiences['_raw'] ) ) :
      ?>
      <p>Featured experiences will be available soon.</p>
    <?php endif; ?>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php
    if (have_posts()) :
      while (have_posts()) :
        the_post();
        the_content();
      endwhile;
    endif;
    ?>
  </div>
</section>

<?php get_footer(); ?>