$(function() {
  $('.other-option').change(function() {
    if (this.checked) {
      $(this).parent().parent().find('.other-container').show();

      return;
    }

    $(this).parent().parent().find('.other-container').hide();
  })
});