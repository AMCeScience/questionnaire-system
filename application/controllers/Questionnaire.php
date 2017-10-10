<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questionnaire extends MY_Auth {

  private $progress;
  private $user_id;

  function __construct()
  {
    parent::__construct();

    $this->load->model('users');

    $this->progress = $this->users->getProgress($this->auth->getUserId());
    $this->user_id = $this->auth->getUserId();
  }

  public function index()
  { 
    $data['tab_active'] = 'landing';
    $data['progress'] = $this->progress;

    $this->layout->questionnaireView('questionnaire/landing', $data);
  }

  public function software()
  {
    $this->load->model('prefills');

    $prefill_data = $this->prefills->getPrefills($this->user_id);

    $data['tab_active'] = 'software_check';
    $data['software'] = $prefill_data['software'];
    $data['reviews'] = $prefill_data['reviews'];
    $data['progress'] = $this->progress;
    
    $this->layout->questionnaireView('questionnaire/software_check', $data);
  }

  public function form()
  {
    $this->load->model('prefills');
    $this->load->model('answers');

    $form_page = $this->uri->segment(3);
    
    $data['form_page'] = null;
    
    if (!is_null($form_page) && is_numeric($form_page) && $form_page < 3) {
      $data['form_page'] = $form_page;
    }

    $data['tab_active'] = 'questionnaire';
    $data['progress'] = $this->progress;

    $data['user_type'] = $this->prefills->userType($this->user_id);

    $data['generic_questions'] = $this->config->item('generic_questions');
    $data['tool_questions'] = $this->config->item('specific_questions');
    $data['sus_questions'] = $this->config->item('usability_questions');

    $data['user_answers'] = $this->answers->get_answers($this->user_id);

    $this->layout->questionnaireView('questionnaire/questionnaire_form', $data);
  }

  public function nextCheck()
  {
    $question_lists = ['generic', 'specific', 'usability'];

    $question_list = $this->input->post('question_list');

    if (!in_array($question_list, $question_lists)) {
      return false;
    }

    $this->load->model('answers');

    list($completion, $to_do) = $this->answers->listCompletion($this->user_id, $question_list);

    echo json_encode(['completed' => $completion === 1, 'todo' => $to_do]);
  }

}
