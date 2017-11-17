<?php

class Stats extends MY_Auth
{

    public function __construct()
    {
        parent::__construct();

        if ($this->auth->getUser()->emailaddress !== 'a.j.vanaltena@amc.uva.nl') {
            die();
        }
    }

    public function index()
    {
        $this->load->model('users');
        $this->load->model('answers');

        $data = [];

        $users = $this->answers->getUniqueUsersWithAnswers();

        foreach ($users as &$user) {
            $user->completion = $this->answers->totalCompletion($user->user_id);
            $user->metadata = $this->users->getUser($user->user_id);
        }

        $data['users'] = $users;

        $this->load->view('stats', $data);
    }
}
