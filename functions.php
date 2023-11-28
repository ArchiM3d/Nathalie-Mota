<?php

defined('ABSPATH') or die('Aucun accès direct au script n\'est autorisé.');

add_filter('wpcf7_autop_or_not', '__return_false');

function enqueue_motaphoto_styles_and_scripts()
{
  wp_enqueue_style('motaphoto-style', get_stylesheet_uri(), array(), false);
  wp_enqueue_style('motaphoto-header', get_stylesheet_directory_uri() . '/assets/css/header.css', array('motaphoto-style'), false);
  wp_enqueue_style('motaphoto-footer', get_stylesheet_directory_uri() . '/assets/css/footer.css', array('motaphoto-style'), false);
  wp_enqueue_style('motaphoto-modal', get_stylesheet_directory_uri() . '/assets/css/modal.css', array('motaphoto-style'), false);
  wp_enqueue_style('motaphoto-page', get_stylesheet_directory_uri() . '/assets/css/page.css', array('motaphoto-style'), false);
  wp_enqueue_style('motaphoto-single', get_stylesheet_directory_uri() . '/assets/css/single.css', array('motaphoto-style'), false);
  wp_enqueue_style('motaphoto-typo', get_stylesheet_directory_uri() . '/assets/css/typo.css', array('motaphoto-style'), false);

  wp_enqueue_script('motaphoto-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_motaphoto_styles_and_scripts');

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

function motaphoto_setup()
{
  $defaults = array(
    'height'      => 100,
    'width'       => 400,
    'flex-height' => true,
    'flex-width'  => true,
  );
  add_theme_support('custom-logo', $defaults);
  add_theme_support('post-thumbnails');
  add_theme_support('title-tag');
  add_theme_support('post-formats', array('quote', 'image', 'video'));

  add_image_size('single-photo', 563, 844, true);
  add_image_size('card-photo', 564, 495, true);
}
add_action('after_setup_theme', 'motaphoto_setup');

/* 
function add_contact_modal_to_header_menu($items, $args)
{
  if ($args->theme_location == 'header-menu') {
    $items .= '<li><a id="open-modal-button" href="#contact-modal">Contact</a></li>';
  }
  return $items;
}
add_filter('wp_nav_menu_items', 'add_contact_modal_to_header_menu', 10, 2); */
