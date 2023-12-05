<?php

defined('ABSPATH') or die('Aucun accès direct au script n\'est autorisé.');

extract($args); ?>

<div class="card-grid">
  <?php
  $custom_query = new WP_Query($args);

  if ($custom_query->have_posts()) :
    while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
      <div class="photo-card">
        <div class="img-container">
          <?php if (has_post_thumbnail()) :
            the_post_thumbnail('card-photo', array('class' => 'img-thumb'));
          endif; ?>
          <div class="overlay">
            <img class="midlleIcon" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icons/Icon_eye.png'; ?>" alt="">
          </div>
          <div class="footer-card">
            <p class="left description-photo">
              <?php echo esc_html(get_post_meta(get_the_ID(), 'reference', true)); ?>
            </p>
            <p class="right description-photo">
            </p>
          </div>
        </div>
        <a class="linkCard" href="<?php echo esc_url(get_permalink()); ?>"></a>
        <a class="topRightIcon" href="#">
          <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icons/Icon_fullscreen.png'; ?>" alt="">
        </a>
        <p class="left description-photo">
          <?php echo esc_html(get_post_meta(get_the_ID(), 'reference', true)); ?>
        </p>
        <?php $terms = get_the_terms(get_the_ID(), 'categorie');
        if ($terms && !is_wp_error($terms)) :
          foreach ($terms as $term) : ?>
            <a href="<?php echo esc_url(get_term_link($term)); ?>" class="right description-photo"><?php echo esc_html($term->name); ?></a>
        <?php endforeach;
        endif; ?>
      </div>
  <?php endwhile;
  else :
    echo 'Aucun article trouvé.';
  endif;
  wp_reset_postdata(); ?>
</div>