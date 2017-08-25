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
    $user = $this->db->select('progress')->get_where('users', ['user_id', $user_id])->row(0);

    return $user->progress;
  }

  public function updateProgress($user_id, $progress) {
    $old_progress = $this->getProgress($user_id);

    $new_progress = $old_progress + $progress;

    $this->db
      ->set('progress', $new_progress)
      ->where('user_id', $user_id)
      ->update('users');
  }
}