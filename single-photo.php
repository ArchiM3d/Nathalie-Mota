<?php

defined('ABSPATH') or die('Aucun accès direct au script n\'est autorisé.');

$current_post_id = get_the_ID();

$meta_refrence = get_post_meta($current_post_id, 'reference', true);

$term_categories = get_the_terms($current_post_id, 'categorie');
if (!empty($term_categories)) :
  foreach ($term_categories as $term_categorie) :
    $link_term_categorie = '<a href="' . esc_url(get_term_link($term_categorie)) . '">' . esc_html($term_categorie->name) . '</a> ';
  endforeach;
endif;

$term_formats = get_the_terms($current_post_id, 'format');
if (!empty($term_formats)) :
  foreach ($term_formats as $term_format) :
    $link_term_format = '<a href="' . esc_url(get_term_link($term_format)) . '">' . esc_html($term_format->name) . '</a> ';
  endforeach;
endif;

// Récupérez les posts précédent et suivant
$prev_post = get_previous_post();
$next_post = get_next_post();

get_header(); ?>

<div class="page-content">
  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
      <div class="photo-container">
        <?php $data_photo_single_args = array(
          'meta_refrence' => $meta_refrence,
          'term_categories' => $term_categories,
          'link_term_categorie' => $link_term_categorie,
          'term_formats' => $term_formats,
          'link_term_format' => $link_term_format,
        );
        get_template_part('templates_parts/single/single-photo-details', null, $data_photo_single_args); ?>
      </div>
    <?php endwhile; ?>

    <?php $data_photo_nav_args = array(
      'meta_refrence' => $meta_refrence,
      'prev_post' => $prev_post,
      'next_post' => $next_post,
    );
    get_template_part('templates_parts/single/single-photo-navigation', null, $data_photo_nav_args); ?>

    <?php $data_single_prop_args = array(
      'current_post_id' => $current_post_id,
    );
    get_template_part('templates_parts/single/single-photo-propositions', null, $data_single_prop_args); ?>

  <?php else :
    echo 'Aucun article trouvé.';
  endif; ?>
</div>

<?php get_footer(); ?>

<?php
/* 
  $data_single_nav_args = array(
    'meta_refrence' => $meta_refrence,
  );
  get_template_part('templates_parts/single/single-photo-navigation', null, $data_single_nav_args);  
*/
?>