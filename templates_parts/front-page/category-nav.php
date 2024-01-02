<?php

defined('ABSPATH') or die('Aucun accès direct au script n\'est autorisé.');

extract($args); ?>

<div class="category-nav">
  <div class="card-grid">
    <?php $argsListe = array(
      'post_type' => 'photo',
      'posts_per_page' => 12,
      'paged' => get_query_var('paged') ? get_query_var('paged') : 1
    );

    $custom_query = new WP_Query($argsListe);
    if ($custom_query->have_posts()) :
      while ($custom_query->have_posts()) : $custom_query->the_post();
        get_template_part('templates_parts/utils/card-photo');
      endwhile;
    else :
      echo 'Aucun article trouvé.';
    endif;
    wp_reset_postdata(); ?>
  </div>
  <button id="charge-all-photos" class="CTA" data-page="1">Charger plus</button>
  <div id="message-photos" style="display: none;"></div>
</div>