<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questionnaire extends MY_Auth {

  public function index()
  {
    $data['tab_active'] = 'landing';

    $this->layout->questionnaireView('questionnaire/landing', $data);
  }

  public function software()
  {
    $data['tab_active'] = 'software_check';

    $this->layout->questionnaireView('questionnaire/software_check', $data);
  }

  public function form()
  {
    $data['tab_active'] = 'questionnaire';

    $this->layout->questionnaireView('questionnaire/questionnaire_form', $data);
  }

}
