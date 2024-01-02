<?php

defined('ABSPATH') or die('Aucun accès direct au script n\'est autorisé.');

extract($args); ?>

<form class="search-bar" id="filter-form">
  <div class="filtres">
    <!-- Sélecteur de catégories -->
    <select name="categorie" id="categorie-select">
      <option value="">Catégories</option>
      <?php $categories = get_terms('categorie', array('hide_empty' => true));
      foreach ($categories as $category) : ?>
        <option value="<?php echo esc_attr($category->slug); ?>">
          <?php echo esc_html($category->name); ?>
        </option>
      <?php endforeach; ?>
    </select>

    <!-- Sélecteur de formats -->
    <select name="format" id="format-select">
      <option value="">Formats</option>
      <?php $formats = get_terms('format', array('hide_empty' => true));
      foreach ($formats as $format) : ?>
        <option value="<?php echo esc_attr($format->slug); ?>">
          <?php echo esc_html($format->name); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <select name="order" id="order-select">
    <option value="">Triés par</option>
    <option value="date_desc">Les plus récentes</option>
    <option value="date_asc">Les plus anciennes</option>
  </select>
</form>