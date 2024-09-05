<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserListing extends CI_Controller
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

    function getVendorUsers()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $id = $this->session->userdata('id');
        $updatePermission = getDataByVal('update_data', 'permission', array('employee_id' => $id, 'type' => 'product'));

        
        foreach ($_POST as $key => $value) {
            if ($key == "vendor_id") {
            } else {
                if ($key != "" && $value != "") {
                    if ($key == "limit") {
                        $this->db->limit($value);
                    } elseif ($key == "name") {
                        $this->db->like($key, $value);
                    } elseif ($key == "product_name") {
                        $this->db->like($key, $value);
                    } elseif ($key == "order_by_desc") {
                        $this->db->order_by($value, "DESC");
                    } elseif ($key == "order_by_asc") {
                        $this->db->order_by($value, "ASC");
                    } elseif ($key == "start_date") {
                        $this->db->where('date >=', $value);
                    } elseif ($key == "end_date") {
                        $this->db->where('date <=', $value);
                    } elseif ($key == "start_date_order") {
                        $this->db->where('order_date >=', $value);
                    } elseif ($key == "end_date_order") {
                        $this->db->where('order_date <=', $value);
                    } elseif ($key == "not_in_order_status") {
                        $this->db->where_not_in('order_status', $value);
                    } elseif ($key == "in_order_status") {
                        $this->db->where_in('order_status', $value);
                    } else {
                        $this->db->where($key, $value);
                    }
                }
            }
        }
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('users');

        $data = [];
        $sno = 1;
        foreach ($query->result() as $r) {
            $product_id_encoded = id_encode($r->id);
            $product_id = $r->id;
            $status = $r->status == 1 ? "<span class='badge badge-success'>Enable</span>" : "<span class='badge badge-danger'>Disabled</span>";
            if ($updatePermission == "yes") {
                $updateButton = '';
            } else {
                $updateButton = '';
            }

            $data[] = array(
                $sno,
                $status,
                $updateButton,
                $r->full_name,
                $r->email,
                $r->mobile_no,
                date_conversion($r->dob),
                $r->gender,
                0,
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
