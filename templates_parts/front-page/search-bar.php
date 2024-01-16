<?php

defined('ABSPATH') or die('Aucun accès direct au script n\'est autorisé.');

extract($args); ?>

<form class="search-bar" id="filter-form">
  <div class="filtres">
    <!-- Liste personnalisée pour les catégories -->
    <div class="custom-select" id="categorie-select">
      <div class="selected">Catégories</div>
    </div>

    <!-- Liste personnalisée pour les formats -->
    <div class="custom-select" id="format-select">
      <div class="selected">Formats</div>
    </div>
  </div>

  <!-- Liste personnalisée pour le tri -->
  <div class="custom-select" id="order-select">
    <div class="selected">Triés par</div>
  </div>
</form>

<ul class="options" id="categorie-options">
  <li data-value=""></li>
  <?php $categories = get_terms('categorie', array('hide_empty' => true));
  foreach ($categories as $category) : ?>
    <li data-value="<?php echo esc_attr($category->slug); ?>">
      <?php echo esc_html($category->name); ?>
    </li>
  <?php endforeach; ?>
</ul>

<ul class="options" id="format-options">
  <li data-value=""></li>
  <?php $formats = get_terms('format', array('hide_empty' => true));
  foreach ($formats as $format) : ?>
    <li data-value="<?php echo esc_attr($format->slug); ?>">
      <?php echo esc_html($format->name); ?>
    </li>
  <?php endforeach; ?>
</ul>

<ul class="options" id="order-options">
  <li data-value="date_desc">Les plus récentes</li>
  <li data-value="date_asc">Les plus anciennes</li>
</ul>