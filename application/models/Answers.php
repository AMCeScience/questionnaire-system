<?php

class Answers extends CI_Model {

  private $question_lists = ['generic', 'specific', 'usability'];

  public function store($user_id, $question_list, $question_id, $answer, $other = '')
  {
    // Check question_list is valid
    if (!in_array($question_list, $this->question_lists)) {
      return false;
    }

    // Check question_id is valid
    $questions = $this->config->item($question_list . '_questions');

    if (!in_array($question_id, array_keys($questions))) {
      return false;
    }

    // Implode answers from checkboxes
    if (is_array($answer)) {
      $answer = implode(', ', $answer);
    }

    // Set other to empty string if null
    if (is_null($other)) {
      $other = '';
    }

    $data = [
      'user_id' => $user_id,
      'question_list' => $question_list,
      'question_id' => $question_id,
      'answer' => $answer,
      'other' => $other
    ];

    // Check if question already has an answer
    $existing_id = $this->existingId($user_id, $question_list, $question_id);

    // Update answer or insert new row
    if (!is_null($existing_id)) {
      $this->db->where('answer_id', $existing_id->answer_id)->update('answers', $data);
    } else {
      $this->db->insert('answers', $data);
    }

    $progress = $this->updateProgress($user_id);

    return [true, $progress];
  }

  public function get_answers($user_id)
  {
    $answers = [];

    foreach ($this->question_lists as $list) {
      $list_questions = $this->config->item($list . '_questions');

      $list_answers = $this->get_list($user_id, $list);

      $answer_arr = [];

      foreach ($list_answers as $list_answer) {
        if ($list_questions[$list_answer->question_id]['type'] === 'checkbox') {
          $list_answer->answer = explode(', ', $list_answer->answer);
        }

        $answer_arr[$list_answer->question_id] = $list_answer;
      }

      $answers[$list] = $answer_arr;
    }

    return $answers;
  }

  public function get_list($user_id, $question_list)
  {
    return $this->db->from('answers')->where(['user_id' => $user_id, 'question_list' => $question_list])->get()->result();
  }

  public function existingId($user_id, $question_list, $question_id)
  {
    return $this->db->from('answers')->where(['user_id' => $user_id, 'question_list' => $question_list, 'question_id' => $question_id])->get()->row(0);
  }

  public function updateProgress($user_id)
  {    
    $progress_increments = $this->config->item('progress');

    $list_progress_increment = $progress_increments['question_lists'];

    $list_completion = $this->totalCompletion($user_id);

    $new_percentage = $progress_increments['prefill_check'] + round(($list_completion / $list_progress_increment) * 100, 0);
    
    $this->db
        ->set('percentage', $new_percentage)
        ->set('progress', 'question_lists')
        ->where('user_id', $user_id)
        ->update('user_progress');

    return $new_percentage;
  }

  public function totalCompletion($user_id)
  {
    $this->load->model('prefills');

    $user_type = $this->prefills->userType($user_id);

    switch ($user_type) {
      case 'using':
        $total_percentage = 0;

        foreach($this->question_lists as $list_name) {
          list($percentage, $question_ids) = $this->listCompletion($user_id, $list_name);

          $total_percentage += $percentage;
        }

        $percentage = $total_percentage / 3;

        break;
      case 'considering':
        list($percentage, $question_ids) = $this->listCompletion($user_id, $list_name);

        break;
      case 'no_use':
        list($percentage, $question_ids) = $this->listCompletion($user_id, $list_name);

        break;
    }

    return $percentage * 100;
  }

  public function listCompletion($user_id, $question_list)
  {
    $to_do = $this->config->item($question_list . '_questions');

    $answered = $this->get_list($user_id, $question_list);

    $answered_arr = [];

    foreach ($answered as $item) {
      $answered_arr[$item->question_id] = $item;
    }

    $total_to_do = 0;
    $option_questions = [];
    $question_ids_done = [];
    $question_ids_to_do = [];

    // Loop al questions in the list
    foreach ($to_do as $question_id => $answer) {
      // Check if the question has been answered
      if (array_key_exists($question_id, $answered_arr) && $answered_arr[$question_id]->answer !== '') {
        $question_ids_done[] = $question_id;

        // If this is a question that has a follow up, add the follow up question to the list of required items
        if (array_key_exists('follow_up', $answer) && $answer['follow_up'] !== '' && $answered_arr[$question_id]->answer === 'yes') {
          $option_questions[] = $question_id + 1;
        }
      } else if (!array_key_exists('is_follow_up', $answer)) {
        // Question has not been answered, add it to the to do list
        // Skip all items that are a follow up question
        $question_ids_to_do[] = $question_id;
      }

      // Check if this is a follow up question
      if (array_key_exists('is_follow_up', $answer) && $answer['is_follow_up'] === true) {
        // Check if this question is in the list of required follow up questions
        if (in_array($question_id, $option_questions)) {
          $total_to_do++;

          // Check if this questions has been answered yet, if not add it to the to do list
          if (!array_key_exists($question_id, $answered_arr) || strlen($answered_arr[$question_id]->answer) < 1) {
            $question_ids_to_do[] = $question_id;
          }
        }

        continue;
      }

      $total_to_do++;
    }

    return array(count($question_ids_done) / $total_to_do, $question_ids_to_do);
  }

}