<?php

/**
 * Extend the MY_Controller to add a login protected controller
 */
class MY_Auth extends CI_Controller
{
    function __construct()
    {
        // Call CI_Controller __construct first
        parent::__construct();
        // Call user authentication function
        $this->auth->checkLogin();
    }
}