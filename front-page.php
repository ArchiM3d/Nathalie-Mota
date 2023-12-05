<?php
defined('ABSPATH') or die('Aucun accès direct au script n\'est autorisé.');


$argsHero = array(
  'post_type'      => 'photo',
  'posts_per_page' => -1,
);
$hero_query = new WP_Query($argsHero);
if ($hero_query->have_posts()) {
  $random_photo_key = array_rand($hero_query->posts);
  $random_photo = $hero_query->posts[$random_photo_key];

  $random_photo_url = get_the_post_thumbnail_url($random_photo->ID, 'full');
  $random_photo_title = get_the_title($random_photo->ID);
}

$argsListe = array(
  'post_type' => 'photo',
  'posts_per_page' => 8,
);

get_header();
?>

<div class="header-hero" style="background-image: url('<?php echo esc_url($random_photo_url); ?>');">
  <h1><?php echo esc_html($random_photo_title); ?></h1>
</div>

<div class="page-content">

  <form class="search-bar" action="">
    <div class="filtres">
      <select name="" id="">
        <option value="">Catégories</option>
      </select>
      <select name="" id="">
        <option value="">Formats</option>
      </select>
    </div>
    <select name="" id="">
      <option value="">Triés par</option>
    </select>
  </form>

  <div class="category-nav">
    <?php $card_photo_args = array(
      'args' => $argsListe
    );
    get_template_part('templates_parts/utils/card-photo', null, $card_photo_args); ?>

    <button id="charge-all-photos" class="CTA">Charger plus</button>
  </div>
</div>
<?php get_footer();
