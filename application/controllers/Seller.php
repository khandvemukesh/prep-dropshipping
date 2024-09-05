<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('loginModel');
    }

    function index()
    {
        $this->load->view('seller/login');
    }

    function dashboard()
    {
        $this->load->view('seller/dashboard');
    }

    function subscription()
    {
        $this->load->view('seller/subscription');
    }

    function importList()
    {
        $this->load->view('seller/import-list');
    }

    function setting()
    {
        $this->load->view('seller/setting');
    }

    function getCategories()
    {
        $requestData = array();
        foreach ($_POST as $key => $value) {
            $requestData[$key] = $value;
        }
        $data['categoryData'] = json_decode(curlRequest(base_url() . 'api/getCategory', $requestData), true);
        $this->load->view('seller/ajax/categories', $data);
    }

    function getProducts()
    {
        $requestData = array();
        foreach ($_POST as $key => $value) {
            $requestData[$key] = $value;
        }
        $data['productData'] = json_decode(curlRequest(base_url() . 'api/getProduct', $requestData), true);
        $this->load->view('seller/ajax/products', $data);
    }
}
