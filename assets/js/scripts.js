(function ($) {
  $(document).ready(function ($) {
    const contact_modal = $('#contact-modal');
    const open_modal_button = $('.open-modal-button');

    modalToggleFunc(contact_modal, open_modal_button);
  });

  function modalToggleFunc(contact_modal, open_modal_button) {
    function toggleModal() {
      contact_modal.fadeToggle();
    }

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
})(jQuery);