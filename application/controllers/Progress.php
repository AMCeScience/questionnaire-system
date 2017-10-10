<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progress extends MY_Auth {

  public function ajax()
  {
    $progress = filter_input(INPUT_POST, 'progress', FILTER_SANITIZE_NUMBER_INT);
    $completed = filter_input(INPUT_POST, 'completed', FILTER_DEFAULT);

    $this->load->model('users');

    if (!is_null($progress)) {
      echo json_encode(['success' => false]);

      return;
    }

    if ($completed === 'prefill_check') {
      $this->users->updateProgress($this->auth->getUserId(), 'prefill_check');

      echo json_encode(['success' => true]);

      return;
    }

    echo json_encode(['success' => false]);
  }

}
