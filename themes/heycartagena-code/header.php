<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header class="site-header">
  <div class="container">
    <div class="brand">
      <a href="<?php echo esc_url(home_url('/')); ?>">
        <?php echo esc_html(get_bloginfo('name')); ?>
      </a>
    </div>

    <nav class="primary-nav">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container' => false,
        'menu_id' => 'primary-menu',
        'menu_class' => 'primary-menu',
        'depth' => 2,
        'fallback_cb' => false,
      ]);
      ?>
    </nav>
  </div>
</header>

<main id="main">
