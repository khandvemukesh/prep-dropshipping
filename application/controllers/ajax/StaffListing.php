<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StaffListing extends CI_Controller
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

    function getStaff()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $id = $this->session->userdata('id');
        $updatePermission = getDataByVal('update_data', 'permission', array('employee_id' => $id, 'type' => 'staff'));

        foreach ($_POST as $key => $value) {
            $data[$key] = $value;
        }
        $query = $this->loginModel->searchData('staff', $data);

        $data = [];
        $sno = 1;
        foreach ($query->result() as $r) {
            $status = $r->status == 1 ? "<span class='badge badge-success'>Enable</span>" : "<span class='badge badge-danger'>Disabled</span>";
            $checkbox_class = $r->status == 1 ? "checkbox_delete" : "checkbox_active";
            $checbox = '<input type="checkbox" class="' . $checkbox_class . '" value="' . $r->id . '">';
            if ($updatePermission == "yes") {
                $updateButton = '
                <button type="button" data-toggle="modal" data-target="#editModal" id="getEditData" data-id="' . $r->id . '" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button>
                <a href="' . base_url() . 'staffPermission/' . $r->id . '" class="btn btn-xs btn-danger text-white">Permission <i class="fa fa-list-alt"></i></a>
                ';
            } else {
                $updateButton = '';
            }
            $img = "<img src='" . base_url() . "image/user.png' class='img img-responsive img-thumbnail img-circle' style='width:50px;'>";
            $data[] = array(
                $sno,
                $checbox,
                $status,
                $updateButton,
                $r->name,
                $r->email,
                $r->mobile,
                $img
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
