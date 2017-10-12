<?php

class Users extends CI_Model {

  function __contstruct()
  {
    parent::__construct();
  }

  public function getUserByHash($email, $hash) {
    if (strlen($email) < 1 || strlen($hash) < 1) {
      return null;
    }

    return $this->db->get_where('users', ['emailaddress' => $email, 'login_hash' => $hash])->row(0, 'Users');
  }

  public function getUserByObject(Users $user) {
    return $this->db->get_where('users', ['emailaddress' => $user->emailaddress, 'login_hash' => $user->login_hash, 'user_id' => $user->user_id])->row(0, 'Users');
  }

  public function getProgress($user_id) {
    $user = $this->db->get_where('user_progress', ['user_id', $user_id])->row(0);

    if (is_null($user)) {
      $this->updateProgress($user_id, 'start');

      return $this->getProgress($user_id);
    }

    return $user->percentage;
  }

  public function updateProgress($user_id, $progress) {
    $old_progress = $this->db->get_where('user_progress', ['user_id', $user_id])->row(0);
    
    $progress_increments = $this->config->item('progress');

    $seen = false;

    if (!is_null($old_progress)) {
      foreach ($progress_increments as $increment => $precentage) {
        if ($increment === $progress) {
          $seen = true;
        }

        if ($increment === $old_progress->progress) {
          if ($seen === true) {
            return;
          }

          break;
        }
      }
    }

    if (is_null($old_progress)) {
      $data = [
        'user_id' => $user_id,
        'progress' => $progress,
        'percentage' => 0
      ];

      $this->db->insert('user_progress', $data);
    } else {
      $percentage = $progress_increments[$progress];
      $new_percentage = $old_progress->percentage + $percentage;

      $this->db
        ->set('percentage', $new_percentage)
        ->set('progress', $progress)
        ->where('user_id', $user_id)
        ->update('user_progress');
    }
  }
}