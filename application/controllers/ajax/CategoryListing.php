<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CategoryListing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('loginModel');
    }

    function checkLogin()
    {
        if ($this->session->userdata('id') != "" && $this->session->userdata('type') == "admin") {
        } else {
            redirect(base_url() . 'admin-login', 'Auto');
        }
    }

    function getCategories()
    {
        $this->checkLogin();
        $search_text = $this->input->post('search_text');
        $searchArr = array();
        if ($search_text != "")
            $searchArr['name'] = $search_text;

        $searchArr['status'] = 1;

        $categoryData = getAllDataByVal('shop_type', $searchArr);
        if ($categoryData->num_rows() == 0) {
            echo false;
        } elseif ($categoryData->num_rows() > 0) {
            $data['categoryData'] = $categoryData;
            $this->load->view('admin/ajax/get-categories', $data);
        }
    }

    function getLowerCategories()
    {
        $this->checkLogin();
        $shop_type = id_decode($this->input->post('shop_type'));
        $search_text = $this->input->post('search_text');
        $searchArr = array();
        if ($shop_type != "")
            $searchArr['shop_type'] = $shop_type;
        if ($search_text != "")
            $searchArr['name'] = $search_text;

        $searchArr['status'] = 1;

        $categoryData = getAllDataByVal('category', $searchArr);
        if ($categoryData->num_rows() == 0) {
            echo false;
        } elseif ($categoryData->num_rows() > 0) {
            $data['categoryData'] = $categoryData;
            $this->load->view('admin/ajax/get-lower-categories', $data);
        }
    }

    function getSubCategories()
    {
        $this->checkLogin();
        $category_id = id_decode($this->input->post('category_id'));
        $search_text = $this->input->post('search_text');
        $searchArr = array();
        if ($search_text != "")
            $searchArr['name'] = $search_text;
        if ($category_id != "")
            $searchArr['category'] = $category_id;

        $searchArr['status'] = 1;
        $categoryData = getAllDataByVal('sub_category', $searchArr);
        if ($categoryData->num_rows() == 0) {
            echo false;
        } elseif ($categoryData->num_rows() > 0) {
            $data['categoryData'] = $categoryData;
            $this->load->view('admin/ajax/get-sub-categories', $data);
        }
    }

    function getCategory()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $id = $this->session->userdata('id');
        $updatePermission = getDataByVal('update_data', 'permission', array('employee_id' => $id, 'type' => 'category'));

        foreach ($_POST as $key => $value) {
            $data[$key] = $value;
        }
        $query = $this->loginModel->searchData('category', $data);

        $data = [];
        $sno = 1;
        foreach ($query->result() as $r) {
            $status = $r->status == 1 ? "<span class='badge badge-success'>Enable</span>" : "<span class='badge badge-danger'>Disabled</span>";
            $checkbox_class = $r->status == 1 ? "checkbox_delete" : "checkbox_active";
            $checbox = '<input type="checkbox" class="' . $checkbox_class . '" value="' . $r->id . '">';
            if ($updatePermission == "yes") {
                $updateButton = '<button type="button" data-toggle="modal" data-target="#editModal" id="getEditData" data-id="' . $r->id . '" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button>';
            } else {
                $updateButton = '';
            }
            $image = '<img src="' . base_url() . 'image/category/' . $r->image . '" class="img img-circle" style="width:50px;">';
            $data[] = array(
                $sno,
                $checbox,
                $status,
                $updateButton,
                getDataByVal('name', 'shop_type', array('id' => $r->shop_type)),
                $r->name,
                $image
            );
            $sno++;
        }

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $query->num_rows(),
            "recordsFiltered" => $query->num_rows(),
            "data" => $data
        );

        echo json_encode($result);
    }
}