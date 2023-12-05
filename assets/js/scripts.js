(function ($) {
  $(document).ready(function ($) {
    const contact_modal = $('#contact-modal');
    const open_modal_button = $('.open-modal-button');
    const reference = WP_DATA.meta_refrence;

    const body = $('body');
    const navMenu = $('.nav-menu');
    const menuToggle = $('.menu-toggle');

    menuToggle.on('click', function () {
      menuToggle.toggleClass('menu-active');
      navMenu.toggleClass('menu-active');

      // Basculer overflow hidden pour body
      if (body.css('overflow') === 'hidden') {
        body.css('overflow', 'auto');
      } else {
        body.css('overflow', 'hidden');
      }
    });

    modalToggleFunc(reference, contact_modal, open_modal_button);

    navHoverArrowPhoto();


    $('#charge-all-photos').on('click', function (e) {
      e.preventDefault();

      $.ajax({
        url: WP_DATA.ajaxUrl,
        type: 'POST',
        data: {
          action: 'load_all_photos', // Le nom de l'action dans WordPress
        },
        success: function (response) {
          // Ajouter la réponse à votre conteneur d'affichage
          $('.category-nav').html(response);
        }
      });
    });
  });

  function modalToggleFunc(reference, contact_modal, open_modal_button) {
    function toggleModal() {
      contact_modal.fadeToggle();
    }
    $('#ref-photo').val(reference);

    contact_modal.hide();

    open_modal_button.on('click', function (event) {
      event.preventDefault(); // Empêcher le lien de suivre le href
      console.log('click');
      toggleModal();
    });

    // Fermer la modale lorsque l'utilisateur clique sur le bouton de fermeture (X)
    $('.close').on('click', function () {
      toggleModal();
    });

    // Fermer la modale lorsque l'utilisateur clique en dehors de la modale
    $(window).on('click', function (event) {
      if (event.target == contact_modal[0]) {
        toggleModal();
      }
    });
  }

  function navHoverArrowPhoto() {
    const nav_img_prev = WP_DATA.prev_thumbnail_url;
    const nav_img_next = WP_DATA.next_thumbnail_url;
    // Lors du survol de la flèche gauche
    $('.arrow-left').hover(
      //In
      function () {
        $('.nav-card-photo img').attr('src', nav_img_prev);
      },
      // Out
      function () {
        $('.nav-card-photo img').attr('src', nav_img_prev);
      }
    );

    // Lors du survol de la flèche droite
    $('.arrow-right').hover(
      function () {
        $('.nav-card-photo img').attr('src', nav_img_next);
      },
      function () {
        $('.nav-card-photo img').attr('src', nav_img_next);
      }
    );
  }
})(jQuery);