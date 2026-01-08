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

    if ( ! empty( $experiences ) && ! isset( $experiences['_raw'] ) ) :
      ?>
      <div class="experiences-grid">
        <?php foreach ( $experiences as $experience ) : ?>
          <article class="experience-card">
            <?php if ( ! empty( $experience['image'] ) ) : ?>
              <div class="experience-image">
                <img src="<?php echo esc_url( $experience['image'] ); ?>" alt="<?php echo esc_attr( $experience['title'] ); ?>">
              </div>
            <?php endif; ?>
            <div class="experience-content">
              <h3 class="experience-title">
                <?php if ( ! empty( $experience['link'] ) ) : ?>
                  <a href="<?php echo esc_url( $experience['link'] ); ?>" target="_blank" rel="noopener">
                    <?php echo esc_html( $experience['title'] ); ?>
                  </a>
                <?php else : ?>
                  <?php echo esc_html( $experience['title'] ); ?>
                <?php endif; ?>
              </h3>
              <?php if ( ! empty( $experience['rating'] ) && $experience['rating'] > 0 ) : ?>
                <div class="experience-rating">
                  Rating: <?php echo esc_html( number_format( $experience['rating'], 1 ) ); ?>
                </div>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
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