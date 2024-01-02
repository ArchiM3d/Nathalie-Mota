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
    $('#filter-form select').on('change', function () {
      $('#charge-all-photos').data('page', 1);
      chargerAjax(1);
    });

    $('#charge-all-photos').on('click', function () {
      var page = $(this).data('page') + 1;
      $(this).data('page', page);
      chargerAjax(page);
    });

    function chargerAjax(page) {
      const categorie = $('#categorie-select').val() || '';
      const format = $('#format-select').val() || '';
      const order = $('#order-select').val() || '';

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
            // Gestion du message et du bouton
            $('#message-photos').html('<p>Toutes les photos sont là.</p>').show();
            $('#charge-all-photos').hide();
          } else {
            $('#message-photos').hide();
            $('#charge-all-photos').show();
          }
        }
      });
    }
  }

  function initLightBox() {
    var lightbox = $('#lightbox');
    var lightboxPhotoContent = $('#lightbox-photo-content');
    var lightboxFooterLeft = $('.lightbox-footer-left');
    var lightboxFooterRight = $('.lightbox-footer-right');
    var allPhotos = $('.photo-card');

    var allPhotosData = updateAllPhotosData();

    $('.card-grid').on('click', '.topRightIcon', function (e) {
      e.preventDefault();
      allPhotosData = updateAllPhotosData();
      var currentCard = $(this).closest('.photo-card');
      var currentIndex = allPhotos.index(currentCard);
      updateLightbox(currentIndex);
      lightbox.fadeIn(300);
    });

    $('#lightbox-prev, #lightbox-next').on('click', function () {
      updateLightbox($(this).data('index'));
    });

    lightbox.find('#lightbox-close, .lightbox-overlay').on('click', function () {
      lightbox.fadeOut(300);
      lightboxPhotoContent.fadeOut(300);
      lighlightboxFooterLefttbox.fadeOut(300);
      lightboxFooterRight.fadeOut(300);
    });

    function updateAllPhotosData() {
      return allPhotos.map(function () {
        return {
          imgSrc: $(this).find('.img-container img').attr('src'),
          reference: $(this).find('.description-photo').first().text(),
          category: $(this).find('.description-photo').last().text()
        };
      }).get();
    }

    function updateLightbox(index) {
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

      setNavigation(index);
    }

    function setNavigation(index) {
      var prevIndex = index > 0 ? index - 1 : allPhotosData.length - 1;
      var nextIndex = index < allPhotosData.length - 1 ? index + 1 : 0;

      lightbox.find('#lightbox-prev').data('index', prevIndex);
      lightbox.find('#lightbox-next').data('index', nextIndex);
    }
  }
})(jQuery);