<?php

defined('ABSPATH') or die('Aucun accès direct au script n\'est autorisé.');

get_header(); ?>

<?php if (have_posts()) :
  while (have_posts()) : the_post();
    the_title();
    the_content();
  endwhile;
else :
  echo 'Aucun article trouvé.';
endif; ?>

<?php get_footer();
