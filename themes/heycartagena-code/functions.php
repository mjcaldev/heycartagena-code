<?php
/**
 * Theme setup
 */

add_action('after_setup_theme', function () {

  // Core supports
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');

  // Custom logo support (REQUIRED for header layout)
  add_theme_support('custom-logo', [
    'height'      => 80,
    'width'       => 240,
    'flex-height' => true,
    'flex-width'  => true,
  ]);

  // Navigation
  register_nav_menus([
    'primary' => 'Primary Navigation',
  ]);
});

/**
 * Enqueue styles
 */
add_action('wp_enqueue_scripts', function () {

  $css_path = get_stylesheet_directory() . '/assets/css/main.css';
  $css_uri  = get_stylesheet_directory_uri() . '/assets/css/main.css';

  wp_enqueue_style(
    'heycartagena-main',
    $css_uri,
    [],
    file_exists($css_path) ? filemtime($css_path) : null
  );
});
