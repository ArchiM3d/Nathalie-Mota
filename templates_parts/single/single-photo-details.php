<?php

defined('ABSPATH') or die('Aucun accès direct au script n\'est autorisé.');

extract($args); ?>

<div class="photo-container-details">
  <div class="photo-details description-photo">
    <h2><?php the_title(); ?></h2>
    <p>Référence : <?php echo $meta_refrence; ?></p>
    <p>Catégorie : <?php echo $link_term_categorie; ?></p>
    <p>Format : <?php echo $link_term_format; ?></p>
    <p>Type : <?php echo get_post_meta(get_the_ID(), 'type', true); ?></p>
    <p>Année : <?php echo get_the_date('Y'); ?></p>
  </div>
</div>
<?php if (has_post_thumbnail()) : ?>
  <div class="featured-image">
    <?php the_post_thumbnail('single-photo', array('class' => 'single-photo-thumbnail')); ?>
  </div>
<?php endif; ?>