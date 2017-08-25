$(function() {
  var load_overlay = "<div class='load-overlay'><div class='loader-center'><div class='loader'></div></div></div>";

  $('.software-table input[type="radio"]').on('change', function() {
    var parent_el = $(this).parent().parent();
    var position = $(parent_el).position();
    var el = $(load_overlay);

    $('body').append(el);
    
    $(el).css({
      position: 'absolute',
      top: position.top,
      left: position.left,
      width: $(parent_el).width(),
      height: $(parent_el).height()
    });

    $.post({
      url: '/questionnaire/updateSoftware',
      data: {
        new_value: $(this).val(),
        software_id: $(this).attr('name')
      },
      dataType: 'json',
      success: function(response) {
        $(el).remove();
      }
    });
  });

  $('.prefill input[type="radio"]').on('change', function() {
    var parent_el = $(this).closest('.prefill');
    var position = $(parent_el).position();
    var el = $(load_overlay);

    $('body').append(el);
    
    $(el).css({
      position: 'absolute',
      top: position.top - 10,
      left: position.left - 10,
      width: $(parent_el).width() + 20,
      height: $(parent_el).height() + 8
    });

    $.post({
      url: '/questionnaire/updatePrefill',
      data: {
        new_value: $(this).val(),
        type: $(this).attr('name')
      },
      dataType: 'json',
      success: function(response) {
        $(el).remove();
      }
    });
  });

  $('.btn-continue').on('click', function(e) {
    e.preventDefault();

    $.post({
      url: '/questionnaire/progress',
      data: {
        completed: 'prefill_check'
      },
      dataType: 'json',
      success: function() {
        window.location = '/questionnaire'
      }
    });

    return false;
  });
});