$(function() {
  bind_check_list_completion();

  bind_other_options();

  bind_question_inputs();

  // Bind window change to alert popup
  prevent_window_change();
});

var send_answer = function(question_el, answer) {
  var question_list = $(question_el).closest('.question-container').data('list-name');
  var question_id = $(question_el).closest('fieldset').data('question-id');

  var other_text = $(question_el).closest('fieldset').find('.other-container input').val();
  
  disable_page_buttons();

  $.post({
      url: '/answer/ajax',
      data: {
        question_list: question_list,
        question_id: question_id,
        answer: answer,
        other_text: other_text
      },
      dataType: 'json',
      success: function(response) {
        if (response.success == true) {
          $('.progress-bar').css('width', response.new_progress + '%');
        }

        enable_page_buttons();
      }
    });
}

var disable_page_buttons = function() {
  if ($.active === 0) {
    $('.btn-page-change').find('.btn-previous').addClass('disabled');
    $('.btn-page-change').find('.btn-primary').addClass('disabled').html('<div class="loader-center">Saving <div class="loader light"></div></div>');
  }
}

var enable_page_buttons = function() {
  if ($.active < 2) {
    $('.btn-page-change').find('.btn-previous').removeClass('disabled');
    $('.btn-page-change').find('.btn-primary').removeClass('disabled').html('Next');
  }
}

var prevent_window_change = function() {
  $(window).bind('beforeunload', function() {
      if ($.active > 0) {
          return 'Still busy storing answers, are you sure?';
      }
      
      return;
  });
}

var bind_check_list_completion = function() {
  $('.btn-continue').on('click', function(e) {
    e.preventDefault();

    var btn_el = $(this);
    var question_container = $(this).closest('.question-container');

    // Remove any warnings from last check
    $('.alert').remove();

    $('fieldset', question_container).each(function() {
      $(this).removeClass('warning');
    });

    var question_list = $(question_container).data('list-name');

    $.post({
      url: '/questionnaire/nextCheck',
      data: {
        question_list: question_list
      },
      dataType: 'json',
      success: function(response) {
        if (response.completed === true) {
          window.location = $(btn_el).attr('href');
        } else {
          $(question_container).prepend('<div class="alert alert-warning">Please answer the following questions: ' + response.todo.join(', ') + '</div>');

          $('fieldset', question_container).each(function() {
            if (response.todo.indexOf($(this).data('question-id')) !== -1) {
              $(this).addClass('warning');
            }
          });

          $("html, body").animate({ scrollTop: 0 }, "slow");
        }
      }
    });

    return false;
  });
}

var bind_other_options = function() {
  // Initialise checkbox 'other' input field
  $('.other-option').change(function() {
    var container = $(this).parent().parent().find('.other-container');

    if (this.checked) {
      $(container).show();

      return;
    }

    $(container).hide();
  });

  $('.other-container input').keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);

    if (keycode == '13') {
      var answer_values = get_checkbox_answers($(this).parent().prev().find('.other-option'));

      send_answer(this, answer_values);
    }
  });

  $('.other-container input').blur(function() {
    var answer_values = get_checkbox_answers($(this).parent().prev().find('.other-option'));

    send_answer(this, answer_values);
  });

  // Initialise radio 'other' input field
  $('input[type=radio]').each(function() {
    $(this).change(function() {
      var other_el = $(this).parent().parent().find('.other-container');
    
      if ($(this).val() === '0') {
        $(other_el).show();

        return;
      }

      $(other_el).hide();
    });
  });
}

var bind_question_inputs = function() {
  // Create sliders and bind slider change to ajax
  $('div.sliders').each(function() {
    var slider_class = $(this).data('slider-name');
    var max_answer = $(this).data('max-answer');
    var user_input = $(this).data('question-answer');

    var slider_el = $('.' + slider_class)[0];

    noUiSlider.create(slider_el, {
      start: 1,
      step: 1,
      pips: {
        mode: 'steps',
        density: 20
      },
      range: {
        'min': [1],
        'max': [max_answer]
      }
    });

    if (user_input !== null) {
      slider_el.noUiSlider.set(user_input);
    }

    slider_el.noUiSlider.on('change', function() {
      send_answer(this.target, parseInt(this.get()));
    });
  });

  // Bind checkbox change to ajax
  $('.custom-checkbox input').on('change', $.debounce(1000,
    function() {
      var answer_values = get_checkbox_answers($(this));

      send_answer(this, answer_values);
    }
  ));

  // Bind radio change to ajax
  $('.custom-radio input').on('change', function() {
    send_answer(this, $(this).val());
  });
}

var get_checkbox_answers = function(el) {
  var el_name = $(el).attr('name').replace('[', '').replace(']', '');

  var answer_values = $('input[name^=' + el_name + ']:checkbox:checked').map(function(){
    return $(this).val();
  }).get();
  console.log(answer_values);
  return answer_values;
}