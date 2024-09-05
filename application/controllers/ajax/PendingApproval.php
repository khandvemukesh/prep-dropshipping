<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PendingApproval extends CI_Controller
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

    function getVendorApproval()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $id = $this->session->userdata('id');
        $updatePermission = getDataByVal('update_data', 'permission', array('employee_id' => $id, 'type' => 'vendor_approval_module'));

        $searchData = array();
        foreach ($_POST as $key => $value) {
            $searchData[$key] = $value;
        }
        $this->db->where_not_in('verification_status', array('1'));
        $query = $this->loginModel->searchData('vendor', $searchData);

        $data = [];
        $sno = 1;
        foreach ($query->result() as $r) {
            $vendor_id_encoded = id_encode($r->id);
            $vendor_id = $r->id;
            $type = id_encode('approval');

            if ($updatePermission == "yes") {
                $updateButton = '
                <a href="' . base_url() . 'admin-update-vendor?vendor_id=' . $vendor_id_encoded . '" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                <a href="' . base_url() . 'admin-vendor-details?vendor_id=' . $vendor_id_encoded . '&type=' . $type . '" class="btn btn-xs btn-danger"><i class="fa fa-eye"></i>View</a>';
            } else {
                $updateButton = '';
            }

            $data[] = array(
                $sno,
                $updateButton,
                $r->firm_name,
                $r->concern_person,
                $r->mobile_no,
                $r->email
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