<?php
// Enqueue des styles CSS et scripts JS
function enqueue_motaphoto_styles_and_scripts()
{
  wp_enqueue_style('motaphoto-style', get_stylesheet_uri());
  //wp_enqueue_script('motaphoto-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
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

// Gestion de la modale de contact
function display_contact_modal()
{
  
}
add_action('wp_footer', 'display_contact_modal');

// Fonction pour réduire la taille des images téléchargées
function custom_image_sizes()
{
  
}
add_action('after_setup_theme', 'custom_image_sizes');

// Désactiver les requêtes API de WordPress non nécessaires
function disable_wp_api()
{
  // Désactivez ici les requêtes API de WordPress non nécessaires
}
add_action('init', 'disable_wp_api');
