<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VendorListing extends CI_Controller
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

    function getApprovedVendor()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $id = $this->session->userdata('id');
        $updatePermission = getDataByVal('update_data', 'permission', array('employee_id' => $id, 'type' => 'vendor'));

        foreach ($_POST as $key => $value) {
            $data[$key] = $value;
        }
        $query = $this->loginModel->searchData('user', $data);

        $data = [];
        $sno = 1;
        foreach ($query->result() as $r) {
            $status = $r->status == 1 ? "<span class='badge badge-success'>Enable</span>" : "<span class='badge badge-danger'>Disabled</span>";
            $checkbox_class = $r->status == 1 ? "checkbox_delete" : "checkbox_active";
            $checbox = '<input type="checkbox" class="' . $checkbox_class . '" value="' . $r->id . '">';
            $updateButton = '';
            if ($updatePermission == "yes") {
                $updateButton .= '<button type="button" data-toggle="modal" data-target="#editModal" id="getEditData" data-id="' . $r->id . '" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button>';
                $updateButton .= ' <a href="' . base_url() . 'admin-vendor-product?vendor_id=' . id_encode($r->id) . '" class="btn btn-xs btn-danger"><i class="fa fa-cart-plus"></i> Product List</a>';
                $updateButton .= ' <a href="' . base_url() . 'admin-vendor-user?vendor_id=' . id_encode($r->id) . '" class="btn btn-xs btn-success"><i class="fa fa-users"></i> Users List</a><br><br>';
                $updateButton .= ' <a href="' . base_url() . 'admin-vendor-orders-list?vendor_id=' . id_encode($r->id) . '" class="btn btn-xs btn-warning"><i class="fa fa-list"></i> Orders List</a>';
            } else {
                $updateButton = '';
            }

            $shop_type = '';
            if ($r->shop_type != "") {
                $shopTypeArr = json_decode($r->shop_type, true);
                foreach ($shopTypeArr as $shop_type_id) {
                    $shop_type .= getDataByVal('name', 'shop_type', array('id' => $shop_type_id)) . '<br>';
                }
            }

            $image = '<img src="' . base_url() . 'image/user/' . $r->profile_pic . '" class="img img-circle" style="width:50px;">';
            $data[] = array(
                $sno,
                $checbox,
                $status,
                $updateButton,
                $image,
                id_encode($r->id),
                $r->cred_unique_code,
                $r->shop_name,
                $shop_type,
                $r->full_name,
                $r->email,
                $r->mobile,
                $r->shop_address_line1,
                $r->shop_address_line2,
                $r->shop_pincode,
                getDataByVal('pincode_village', 'pincodes_list', array('pincodeid' => $r->shop_area_id)),
                $r->shop_district,
                $r->shop_state,
                ''
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

    function getPendingVendor()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $id = $this->session->userdata('id');
        $updatePermission = getDataByVal('update_data', 'permission', array('employee_id' => $id, 'type' => 'vendor'));

        foreach ($_POST as $key => $value) {
            $data[$key] = $value;
        }
        $query = $this->loginModel->searchData('user', $data);

        $data = [];
        $sno = 1;
        foreach ($query->result() as $r) {
            $status = $r->status == 1 ? "<span class='badge badge-success'>Enable</span>" : "<span class='badge badge-danger'>Disabled</span>";
            $checkbox_class = $r->status == 1 ? "checkbox_delete" : "checkbox_active";
            $checbox = '<input type="checkbox" class="' . $checkbox_class . '" value="' . $r->id . '">';
            if ($updatePermission == "yes") {
                $updateButton = '<a href="' . base_url() . 'admin-approve-vendor?vendor_id=' . id_encode($r->id) . '" class="btn btn-xs btn-success"><i class="fa fa-check"></i>Approve</a>
                <button type="button" data-toggle="modal" data-target="#rejectModal" data-id="' . $r->id . '" id="reject" class="btn btn-xs btn-danger"><i class="fa fa-times"></i>Reject</button>';
            } else {
                $updateButton = '';
            }
            $image = '<img src="' . base_url() . 'image/user/' . $r->profile_pic . '" class="img img-circle" style="width:50px;">';
            $data[] = array(
                $sno,
                $checbox,
                $status,
                $updateButton,
                $image,
                id_encode($r->id),
                $r->cred_unique_code,
                $r->shop_name,
                getDataByVal('name', 'shop_type', array('id' => $r->shop_type)),
                $r->full_name,
                $r->email,
                $r->mobile,
                $r->shop_address_line1,
                $r->shop_address_line2,
                $r->shop_pincode,
                getDataByVal('pincode_village', 'pincodes_list', array('pincodeid' => $r->shop_area_id)),
                $r->shop_district,
                $r->shop_state,
                ''
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
