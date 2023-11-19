<?php
defined('ABSPATH') or die('Aucun accès direct au script n\'est autorisé.');

get_header(); ?>

<div>
  HERO
</div>
<div class="page-content">
  <div class="search-bar">
    Zone Trie
  </div>
  <div class="grid-photos">
    Liste des photos
    <?php
    $args = array(
      'post_type' => 'photo', // Remplacez 'photo' par le nom de votre type de contenu personnalisé
      'posts_per_page' => -1, // Afficher tous les articles
    );

    $custom_query = new WP_Query($args);

    if ($custom_query->have_posts()) :
      while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
        <div class="card-photos">
          <?php
          // Afficher l'image à la une (thumbnail) liée à l'article
          if (has_post_thumbnail()) {
            the_post_thumbnail('thumbnail'); // Vous pouvez choisir la taille de l'image (thumbnail, medium, large, etc.)
          }
          ?>
          <div class="overlay">
            <a href="#"><i class="fa fa-expand"></i></a>
            <a href="<?php the_permalink(); ?>"><i class="fa fa-eye"></i></a>
            <div class="footer-card">
              <div class="left">
                <?php echo get_post_meta(get_the_ID(), 'reference', true); ?>
              </div>
              <div class="right">
                <?php $terms = get_the_terms(get_the_ID(), 'categorie');

                if ($terms && !is_wp_error($terms)) {
                  echo 'Catégorie : ';
                  foreach ($terms as $term) {
                    echo '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a> ';
                  }
                } ?>
              </div>
            </div>
          </div>
        </div>
    <?php endwhile;
    else :
      echo 'Aucun article trouvé.';
    endif;

    wp_reset_postdata();
    ?>
  </div>
</div>
<?php get_footer();
