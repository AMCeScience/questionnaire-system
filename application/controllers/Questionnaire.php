<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questionnaire extends MY_Auth {

  public function index()
  {
    $this->load->model('users');
    
    $data['tab_active'] = 'landing';
    $data['progress'] = $this->users->getProgress($this->auth->getUserId());

    $this->layout->questionnaireView('questionnaire/landing', $data);
  }

  public function software()
  {
    $this->load->model('prefills');
    $this->load->model('users');

    $prefill_data = $this->prefills->getPrefills($this->auth->getUserId());

    $data['tab_active'] = 'software_check';
    $data['software'] = $prefill_data['software'];
    $data['reviews'] = $prefill_data['reviews'];
    $data['progress'] = $this->users->getProgress($this->auth->getUserId());
    
    $this->layout->questionnaireView('questionnaire/software_check', $data);
  }

  public function form()
  {
    $this->load->model('users');

    $data['tab_active'] = 'questionnaire';
    $data['progress'] = $this->users->getProgress($this->auth->getUserId());

    $this->layout->questionnaireView('questionnaire/questionnaire_form', $data);
  }

  public function updateSoftware()
  {
    $new_value = filter_input(INPUT_POST, 'new_value', FILTER_SANITIZE_NUMBER_INT);
    $software_id = filter_input(INPUT_POST, 'software_id', FILTER_SANITIZE_NUMBER_INT);

    if (!is_null($new_value) && !is_null($software_id)) {
      $this->load->model('prefills');

      $this->prefills->updateSoftware($software_id, $this->auth->getUserId(), $new_value);

      echo json_encode(['success' => true]);

      return;
    }

    echo json_encode(['success' => false]);
  }

  public function updatePrefill()
  {
    $new_value = filter_input(INPUT_POST, 'new_value', FILTER_SANITIZE_NUMBER_INT);
    $type = filter_input(INPUT_POST, 'type', FILTER_DEFAULT);

    if ($type !== 'reviews' && $type !== 'papers') {
      return;
    }

    $this->load->model('prefills');

    $this->prefills->updatePrefill($type, $this->auth->getUserId(), $new_value);

    echo json_encode(['success' => true]);
  }

  public function progress()
  {
    $progress = filter_input(INPUT_POST, 'progress', FILTER_SANITIZE_NUMBER_INT);
    $completed = filter_input(INPUT_POST, 'completed', FILTER_DEFAULT);

    $this->load->model('users');

    if (!is_null($progress)) {
      // TODO
    }

    if ($completed === 'prefill_check' && $this->users->getProgress($this->auth->getUserId()) < 1) {
      $progress_increments = $this->config->item('progress');

      $this->users->updateProgress($this->auth->getUserId(), $progress_increments['prefill_check']);

      echo json_encode(['success' => true]);

      return;
    }

    echo json_encode(['success' => false]);
  }

}
