<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('loginModel');
    }

    function index()
    {
        $this->load->view('web/home');
    }

    function about()
    {
        $this->load->view('web/about');
    }

    function contact()
    {
        $this->load->view('web/contact');
    }

    function integrations()
    {
        $this->load->view('web/integrations');
    }

    function partnerships()
    {
        $this->load->view('web/partnerships');
    }
}
