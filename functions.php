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
  wp_enqueue_style('motaphoto-front-page', get_stylesheet_directory_uri() . '/assets/css/front-page.css', array('motaphoto-style'), false);
  wp_enqueue_style('motaphoto-single', get_stylesheet_directory_uri() . '/assets/css/single.css', array('motaphoto-style'), false);
  wp_enqueue_style('motaphoto-typo', get_stylesheet_directory_uri() . '/assets/css/typo.css', array('motaphoto-style'), false);
  wp_enqueue_style('motaphoto-utils', get_stylesheet_directory_uri() . '/assets/css/utils.css', array('motaphoto-style'), false);

  wp_enqueue_script('motaphoto-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0', true);
  $meta_refrence = get_post_meta(get_the_ID(), 'reference', true);
  $prev_post = get_previous_post();
  $next_post = get_next_post();
  $prev_thumbnail_url = $prev_post ? get_the_post_thumbnail_url($prev_post->ID, 'card-photo') : 'path/to/default/image.jpg';
  $next_thumbnail_url = $next_post ? get_the_post_thumbnail_url($next_post->ID, 'card-photo') : 'path/to/default/image.jpg';
  wp_localize_script('motaphoto-scripts', 'WP_DATA', array(
    'ajaxUrl' => admin_url('admin-ajax.php'),
    'meta_refrence' => esc_js($meta_refrence),
    'prev_thumbnail_url' => esc_js($prev_thumbnail_url),
    'next_thumbnail_url' => esc_js($next_thumbnail_url),
  ));

  wp_enqueue_style('motaphoto-lightbox-style', get_stylesheet_directory_uri() . '/assets/css/lightbox.css', array('motaphoto-style'), false);


  wp_enqueue_style('poppins-font', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', array(), false, 'all');
  wp_enqueue_style('poppins-font', 'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), false, 'all');
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

function load_all_photos()
{
  $paged = isset($_POST['page']) ? $_POST['page'] : 1;
  $categorie = isset($_POST['categorie']) ? $_POST['categorie'] : '';
  $format = isset($_POST['format']) ? $_POST['format'] : '';
  $order = isset($_POST['order']) ? $_POST['order'] : '';

  $order_param = 'date'; // Par défaut, trier par date
  $order_dir = 'DESC'; // Par défaut, les plus récentes en premier

  if ($order == 'date_desc') {
    $order_dir = 'DESC';
  } elseif ($order == 'date_asc') {
    $order_dir = 'ASC';
  }

  $tax_query = array();
  if ($categorie) {
    $tax_query[] = array(
      'taxonomy' => 'categorie',
      'field'    => 'slug',
      'terms'    => $categorie
    );
  }

  if ($format) {
    $tax_query[] = array(
      'taxonomy' => 'format',
      'field'    => 'slug',
      'terms'    => $format
    );
  }

  $argsLoad = array(
    'post_type'      => 'photo',
    'posts_per_page' => 12,
    'paged'          => $paged,
    'orderby'        => $order_param,
    'order'          => $order_dir,
    'tax_query'      => $tax_query
  );

  $custom_query = new WP_Query($argsLoad);
  if ($custom_query->have_posts()) {
    while ($custom_query->have_posts()) : $custom_query->the_post();
      get_template_part('templates_parts/utils/card-photo');
    endwhile;
  } else {
    echo ''; // Renvoie une chaîne vide si aucun post n'est trouvé
  }
  wp_reset_postdata();
  die();
}
add_action('wp_ajax_load_all_photos', 'load_all_photos');
add_action('wp_ajax_nopriv_load_all_photos', 'load_all_photos');
