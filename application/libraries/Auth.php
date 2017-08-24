<?php

class Auth extends MY_Library {
  
  public function checkLogin()
  {
    $this->load->model('users');

    $user = $this->session->user;

    if (is_null($user) || is_a($user, 'Users')) {
      return false;
    }

    fixObject($user);

    $validated_user = $this->users->getUserByObject($user);

    if (is_null($validated_user)) {
      return false;
    }

    return true;
  }

  public function login($email, $hash)
  {
    $this->load->model('users');

    $user = $this->users->getUserByHash($email, $hash);

    if (is_null($user)) {
      return false;
    }

    $this->session->user = $user;

    return true;
  }

  public function logout()
  {
    $this->session->sess_destroy();
  }

}