<?php

defined('ABSPATH') or die('Aucun accès direct au script n\'est autorisé.'); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <header>
    <div class="logo">
      <a href="<?php echo home_url(); ?>">
        <?php $custom_logo_id = get_theme_mod('custom_logo');
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
        if ($logo) :
          echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '">';
        else :
          echo '<h1>' . get_bloginfo('name') . '</h1>';
        endif;
        ?>
      </a>
    </div>
    <nav class="nav-menu-desktop">
      <?php wp_nav_menu(array(
        'theme_location' => 'header-menu',
        'menu_class' => 'header-menu'
      )); ?>
    </nav>
    <nav class="nav-menu-mobile" style="display: none;">
      <?php wp_nav_menu(array(
        'theme_location' => 'header-menu',
        'menu_class' => 'header-menu'
      )); ?>
    </nav>
    <button class="menu-toggle">
      <span class="menu-bar"></span>
      <span class="menu-bar"></span>
      <span class="menu-bar"></span>
    </button>
  </header>
  <main>