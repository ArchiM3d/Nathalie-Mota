<?php

defined('ABSPATH') or die('Aucun accès direct au script n\'est autorisé.');

get_header(); ?>

<div class="page-content">
  <?php if (have_posts()) :
    while (have_posts()) : the_post();
      the_content();
    endwhile;
  else :
    echo 'Aucun article trouvé.';
  endif; ?>
</div>

<?php get_footer();
