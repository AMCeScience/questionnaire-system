<?php

class Auth extends MY_Library {
  
  public function checkLogin()
  {
    $this->load->helper('url');
    $this->load->model('users');

    $user = $this->session->user;

    if (is_null($user) || is_a($user, 'Users')) {
      redirect('/login/error');
    }

    fixObject($user);

    $validated_user = $this->users->getUserByObject($user);

    if (is_null($validated_user)) {
      redirect('/login/error');
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