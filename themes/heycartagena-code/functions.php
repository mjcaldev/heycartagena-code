<?php
/**
 * Theme setup
 */

add_action('after_setup_theme', function () {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');

  register_nav_menus([
    'primary' => 'Primary Navigation',
  ]);
});

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style(
    'heycartagena-main',
    get_stylesheet_directory_uri() . '/assets/css/main.css',
    [],
    '1.0'
  );
});
