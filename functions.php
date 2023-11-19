<?php
// Enqueue des styles CSS et scripts JS
function enqueue_motaphoto_styles_and_scripts()
{
  wp_enqueue_style('motaphoto-style', get_stylesheet_uri(), array(), false);
  wp_enqueue_style('motaphoto-header', get_stylesheet_directory_uri() . '/assets/css/header.css', array('motaphoto-style'), false);
  wp_enqueue_style('motaphoto-footer', get_stylesheet_directory_uri() . '/assets/css/footer.css', array('motaphoto-style'), false);
  
  wp_enqueue_script('motaphoto-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_motaphoto_styles_and_scripts');

// Ajouter la prise en charge du menu de navigation
function register_motaphoto_menus()
{
  register_nav_menus(
    array(
      'header-menu' => __('Menu du header'),
      'footer-menu' => __('Menu du footer'),
    )
  );
}
add_action('init', 'register_motaphoto_menus');

// Personnalisation du logo
function custom_logo_setup()
{
  $defaults = array(
    'height'      => 100,
    'width'       => 400,
    'flex-height' => true,
    'flex-width'  => true,
  );
  add_theme_support('custom-logo', $defaults);
}
add_action('after_setup_theme', 'custom_logo_setup');
