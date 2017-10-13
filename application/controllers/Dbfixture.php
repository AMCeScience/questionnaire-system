<?php

/**
 * Dbfixture class, used to run migrations
 * Invoke from command line: php index.php dbfixture migrate
 * 
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class Dbfixture extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // if (is_cli() === false) {
        //     show_error('Not called from CLI.', 401);
        // }
    }

    public function migrate()
    {
        $this->load->library('migration');

        if (is_cli() === false) {
            die();
        }

        if ($this->migration->current() === false) {
            echo $this->migration->error_string() . PHP_EOL;
        }
    }

    // TODO: remove before going live
    public function cleanUser()
    {
        $user_id = $this->uri->segment(3);

        $this->db->where('user_id', $user_id)->delete('answers');
        $this->db->where('user_id', $user_id)->delete('comments');
    }
}
