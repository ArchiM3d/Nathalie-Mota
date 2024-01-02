<?php

defined('ABSPATH') or die('Aucun accès direct au script n\'est autorisé.');

extract($args);

$term_categories = get_the_terms(get_the_ID(), 'categorie');

$category_ids = array();
foreach ($term_categories as $term) {
  $category_ids[] = $term->term_id;
}
?>

<div class="category-nav">
  <h3>Vous aimerez AUSSI</h3>
  <div class="card-grid">
    <?php
    $argsPost = array(
      'post_type' => 'photo', // Custom post type photo
      'posts_per_page' => 2, // 2 articles max
      'orderby' => 'rand', // Proposition aléatoire
      'post__not_in' => array(get_the_ID()), // Enleve le post actuel des proposition
      'tax_query' => array(
        array(
          'taxonomy' => 'categorie',
          'field'    => 'term_id',
          'terms'    => $category_ids,
        ), // seulement de la taxonomy personalisé 'categorie' 
      ),
    );

    $custom_query = new WP_Query($argsPost);

    if ($custom_query->have_posts()) :
      while ($custom_query->have_posts()) : $custom_query->the_post();
        get_template_part('templates_parts/utils/card-photo');
      endwhile;
    else :
      echo 'Aucun article trouvé.';
    endif;
    wp_reset_postdata(); ?>
  </div>

  <button id="go-all-photos" onclick="window.location.href='<?php echo home_url(); ?>';" class="CTA">Toutes les photos</button>
</div>