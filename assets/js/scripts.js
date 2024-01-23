(function ($) {
  // Initialisation des éléments et des événements
  $(document).ready(function () {
    initModal();
    initNavigation();
    initPhotoChargement();
    initLightBox();
  });

  function initModal() {
    const contact_modal = $('#contact-modal');
    const open_modal_button = $('.open-modal-button');
    const reference = WP_DATA.meta_refrence;

    $('#ref-photo').val(reference);
    contact_modal.hide();

    open_modal_button.on('click', toggleModal);
    $('.close').on('click', toggleModal);
    $(window).on('click', function (event) {
      if (event.target == contact_modal[0]) toggleModal();
    });

    function toggleModal(event) {
      event?.preventDefault();
      contact_modal.fadeToggle();
    }
  }

  function initNavigation() {
    const menuToggle = $('.menu-toggle');
    const navMenuMobile = $('.nav-menu-mobile'); // Assurez-vous que c'est le menu mobile

    menuToggle.on('click', function () {
      $(this).toggleClass('menu-active');
      navMenuMobile.fadeToggle(300);
      $('body').css('overflow', $('body').css('overflow') === 'hidden' ? 'auto' : 'hidden');
    });

    $('.arrow-left, .arrow-right').hover(toggleHoverImage, toggleHoverImage);

    function toggleHoverImage() {
      const cadre_photo_img = $('.nav-card-photo img');
      const img_src = $(this).hasClass('arrow-left') ? WP_DATA.prev_thumbnail_url : WP_DATA.next_thumbnail_url;
      cadre_photo_img.show().attr('src', img_src);
    }
  }

  function initPhotoChargement() {
    $('.custom-select').click(function () {
      var selectFiltre = '#' + $(this).attr('id');
      var optionsFiltre = selectFiltre.split('-')[0] + '-options';
      var widthSelect = $(selectFiltre).width();
      var heightSelect = $(selectFiltre).height();
      var selectPos = $(selectFiltre).position();

      var topOffsetOption = (selectPos.top + (heightSelect + 2));
      var leftOffsetOption = (selectPos.left);

      $(optionsFiltre).width(widthSelect);
      $(optionsFiltre).css({ top: topOffsetOption, left: leftOffsetOption }).toggle();

      $(selectFiltre).toggleClass('open');
      /* Ajouts des chevrons au click */
      $(this).find('.chevron-updown').toggleClass('chevron-up');
      $(this).find('.chevron-updown').toggleClass('chevron-down');
    });

    // Stocker le texte par défaut de chaque sélecteur dans un attribut data
    $('.custom-select').each(function () {
      var defaultText = $(this).find('.selected').text();
      $(this).data('default-text', defaultText);
    });

    $('.options li').click(function () {
      var value = $(this).data('value');
      var optionsId = $(this).closest('.options').attr('id');
      var selectFiltre = '#' + optionsId.replace('-options', '-select');

      // Vérifier si l'option cliquée est l'option vide
      if (value === '') {
        // Récupérer et utiliser le texte par défaut du sélecteur
        var defaultText = $(selectFiltre).data('default-text');
        $(selectFiltre).find('.selected').text(defaultText);
        // Mettre à jour la valeur par défaut pour les requêtes
        $(selectFiltre).find('.selected').data('value', '');
      } else {
        // Sinon, utiliser le texte de l'option cliquée
        $(selectFiltre).find('.selected').text($(this).text()).data('value', value);
      }

      // Fermer le menu d'options et charger les photos
      $(this).parent().hide();
      $('#charge-all-photos').data('page', 1);
      chargerAjax(1);

      // Enlever la classe 'open' du sélecteur
      $(selectFiltre).removeClass('open');
    });

    $('#charge-all-photos').on('click', function () {
      var nextPage = $(this).data('page') + 1;
      $(this).data('page', nextPage);
      chargerAjax(nextPage);
    });

    function chargerAjax(page) {
      const categorie = $('#categorie-select .selected').data('value') || '';
      const format = $('#format-select .selected').data('value') || '';
      const order = $('#order-select .selected').data('value') || '';

      $.ajax({
        url: WP_DATA.ajaxUrl,
        type: 'POST',
        data: {
          action: 'load_all_photos',
          categorie,
          format,
          order,
          page
        },
        success: function (response) {
          if (page === 1) {
            $('.card-grid').html(response);
          } else {
            $('.card-grid').append(response);
          }

          if ($.trim(response) === '') {
            $('#message-photos').html('<p>Toutes les photos sont là.</p>').show();
            $('#charge-all-photos').hide();
          } else {
            $('#message-photos').hide();
            $('#charge-all-photos').show();
          }
          initLightBox();
        }
      });
    }
  }

  function initLightBox() {
    var lightbox = $('#lightbox');
    var lightboxPhotoContent = $('#lightbox-photo-content');
    var lightboxFooterLeft = $('.lightbox-footer-left');
    var lightboxFooterRight = $('.lightbox-footer-right');

    function updateAllPhotosData() {
      var allPhotos = $('.photo-card');
      return allPhotos.map(function () {
        return {
          imgSrc: $(this).find('.img-container img').attr('src'),
          reference: $(this).find('.description-photo').first().text(),
          category: $(this).find('.description-photo').last().text()
        };
      }).get();
    }

    var allPhotosData = updateAllPhotosData();

    $('.card-grid').off('click').on('click', '.topRightIcon', function (e) {
      e.preventDefault();
      allPhotosData = updateAllPhotosData();
      var currentCard = $(this).closest('.photo-card');
      var currentIndex = $('.photo-card').index(currentCard);
      updateLightbox(allPhotosData, currentIndex);
      lightbox.fadeIn(300);
    });

    // Gestionnaires d'événements pour les boutons Précédent et Suivant
    $('#lightbox-prev, #lightbox-next').off('click').on('click', function () {
      var newIndex = $(this).data('index');
      updateLightbox(allPhotosData, newIndex); // Mise à jour de la lightbox avec le nouvel index
    });

    lightbox.find('#lightbox-close, .lightbox-overlay').on('click', function () {
      lightbox.fadeOut(300);
      lightboxPhotoContent.fadeOut(300);
      lightboxFooterLeft.fadeOut(300);
      lightboxFooterRight.fadeOut(300);
    });

    function updateLightbox(allPhotosData, index) {
      var photoData = allPhotosData[index];

      lightboxPhotoContent.fadeOut(300, function () {
        lightboxPhotoContent.html('<img src="' + photoData.imgSrc + '" alt="' + photoData.reference + '" loading="lazy">');
        lightboxFooterLeft.text(photoData.reference);
        lightboxFooterRight.text(photoData.category);
        lightboxPhotoContent.fadeIn(300);
      });

      lightboxFooterLeft.fadeOut(300, function () {
        lightboxFooterLeft.text(photoData.reference).fadeIn(300);
      });

      lightboxFooterRight.fadeOut(300, function () {
        lightboxFooterRight.text(photoData.category).fadeIn(300);
      });

      setNavigation(index, allPhotosData.length); // Mise à jour de la navigation avec la longueur actuelle
    }

    function setNavigation(currentIndex, totalPhotos) {
      var prevIndex = currentIndex > 0 ? currentIndex - 1 : totalPhotos - 1;
      var nextIndex = currentIndex < totalPhotos - 1 ? currentIndex + 1 : 0;

      $('#lightbox-prev').data('index', prevIndex);
      $('#lightbox-next').data('index', nextIndex);
    }
  }
})(jQuery);