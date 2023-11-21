<?php

defined('ABSPATH') or die('Aucun accès direct au script n\'est autorisé.');

$meta_refrence = get_post_meta(get_the_ID(), 'reference', true);

$term_categories = get_the_terms(get_the_ID(), 'categorie');
if (!empty($term_categories)) :
  foreach ($term_categories as $term_categorie) :
    $link_term_categorie = '<a href="' . esc_url(get_term_link($term_categorie)) . '">' . esc_html($term_categorie->name) . '</a> ';
  endforeach;
endif;

$term_formats = get_the_terms(get_the_ID(), 'format');
if (!empty($term_formats)) :
  foreach ($term_formats as $term_format) :
    $link_term_format = '<a href="' . esc_url(get_term_link($term_format)) . '">' . esc_html($term_format->name) . '</a> ';
  endforeach;
endif;

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
        get_template_part('templates_parts/single-photo-details', null, $data_photo_single_args); ?>
      </div>
    <?php endwhile; ?>
    <div class="nav-single-photo">
      <p>Cette photo vous intéresse ?</p>
      <button id="open-modal-button" class="CTA">Contact</button>
      <div class="nav-card">
        <div class="nav-card-photo">
          <img src="<?php echo get_stylesheet_directory_uri() . './assets/images/nathalie-0.png' ?>" alt="">
        </div>
        <div class="nav-arrow">
          <a href="#" class="arrow-left">
            <span>
              <svg width="27" height="16" viewBox="0 0 27 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.292893 7.29289C-0.0976311 7.68342 -0.0976311 8.31658 0.292893 8.70711L6.65685 15.0711C7.04738 15.4616 7.68054 15.4616 8.07107 15.0711C8.46159 14.6805 8.46159 14.0474 8.07107 13.6569L2.41421 8L8.07107 2.34315C8.46159 1.95262 8.46159 1.31946 8.07107 0.928932C7.68054 0.538408 7.04738 0.538408 6.65685 0.928932L0.292893 7.29289ZM26 9C26.5523 9 27 8.55228 27 8C27 7.44772 26.5523 7 26 7V9ZM1 9H26V7H1V9Z" fill="black" />
              </svg>
            </span>
          </a>
          <a href="#" class="arrow-right">
            <span>
              <svg width="27" height="16" viewBox="0 0 27 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M26.7071 7.29289C27.0976 7.68342 27.0976 8.31658 26.7071 8.70711L20.3431 15.0711C19.9526 15.4616 19.3195 15.4616 18.9289 15.0711C18.5384 14.6805 18.5384 14.0474 18.9289 13.6569L24.5858 8L18.9289 2.34315C18.5384 1.95262 18.5384 1.31946 18.9289 0.928932C19.3195 0.538408 19.9526 0.538408 20.3431 0.928932L26.7071 7.29289ZM1 9C0.447716 9 0 8.55228 0 8C0 7.44772 0.447716 7 1 7V9ZM26 9H1V7H26V9Z" fill="black" />
              </svg>
            </span>
          </a>
        </div>
    </div>
</div>
<?php else :
    echo 'Aucun article trouvé.';
  endif; ?>
</div>

<?php get_footer(); ?>