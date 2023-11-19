<footer>
  <?php wp_nav_menu(array(
    'theme_location' => 'footer-menu', // Utilisez le nom de l'emplacement du menu déclaré dans votre thème
    'menu_class' => 'footer-menu', // Classe CSS pour le menu
  )); ?>
</footer>
<?php wp_footer(); ?>
</body>

</html>