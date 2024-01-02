<?php
defined('ABSPATH') or die('Aucun accès direct au script n\'est autorisé.');

get_header();
?>

<?php $argsHero = array(
  'post_type'      => 'photo',
  'posts_per_page' => -1,
);
$hero_query = new WP_Query($argsHero);
if ($hero_query->have_posts()) {
  $random_photo_key = array_rand($hero_query->posts);
  $random_photo = $hero_query->posts[$random_photo_key];

  $random_photo_url = get_the_post_thumbnail_url($random_photo->ID, 'full');
} ?>

<div class="header-hero" style="background-image: url('<?php echo esc_url($random_photo_url); ?>');">
  <h1>PHOTOGRAPHE EVENT</h1>
</div>

<div class="page-content">
  <?php get_template_part('templates_parts/front-page/search-bar'); ?>
  <?php get_template_part('templates_parts/front-page/category-nav'); ?>
</div>

<?php get_footer();
