<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OrderListing extends CI_Controller
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

    function getVendorOrdersList()
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
        $query = $this->db->get('order_overview');

        $data = [];
        $sno = 1;
        foreach ($query->result() as $r) {
            $order_id_encoded = id_encode($r->id);
            $order_id = $r->id;
            if ((int)$r->delivery_type == 0) $delivery_type = '<span class="badge badge-primary">Delivery</span>';
            else $delivery_type = '<span class="badge badge-warning">Pickup</span>';

            if ($r->payment_mode == 'cod') $payment_mode = '<span class="badge badge-info">Cash On Delivery</span>';
            elseif ($r->payment_mode == 'online') $payment_mode = '<span class="badge badge-danger">Online</span>';
            else $payment_mode = '<span class="badge badge-success">UPI</span>';

            $this->db->where('id', $r->user_id);
            $usersObj = $this->db->get('users')->row();

            $updateButton = '';
            if ($r->order_status == 0) {
                $order_status = '<span class="badge badge-warning">Pending</span>';
                $updateButton .= '<button data-id="' . $order_id . '" data-status="1" class="btn btn-xs btn-success update-order-status"><i class="fa fa-check-circle"></i> Accept</button> ';
                $updateButton .= '<button data-id="' . $order_id . '" data-status="1" class="btn btn-xs btn-danger update-order-status"><i class="fa fa-times-circle"></i> Reject</button> ';
            } elseif ($r->order_status == 1) {
                $order_status = '<span class="badge badge-primary">Accepted</span>';
                $updateButton .= '<button data-id="' . $order_id . '" data-status="2" class="btn btn-xs btn-success update-order-status"><i class="fa fa-dropbox"></i> Packed</button> ';
            } elseif ($r->order_status == 2) {
                $order_status = '<span class="badge badge-info">Packed</span>';
                $updateButton .= '<button data-id="' . $order_id . '" data-status="3" class="btn btn-xs btn-success update-order-status"><i class="fa fa-bicycle"></i> Out For Delivery</button> ';
            } elseif ($r->order_status == 3) {
                $order_status = '<span class="badge badge-secondary">Out For Delivery</span>';
                $updateButton .= '<button data-id="' . $order_id . '" data-status="4" class="btn btn-xs btn-success update-order-status"><i class="fa fa-recycle"></i> Delivered</button> ';
            } elseif ($r->order_status == 4) {
                $order_status = '<span class="badge badge-success">Delivered</span>';
            } else {
                $order_status = '<span class="badge badge-danger">Cancelled</span>';
            }

            $updateButton .= '<a href="' . base_url() . 'admin-vendor-orders-view?vendor_id=4d513d3d&order_id=' . $order_id_encoded . '" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> View Details</a>';

            $data[] = array(
                $sno,
                $order_status,
                $updateButton,
                $usersObj->full_name . ' - ' . $usersObj->mobile_no,
                $r->order_no,
                $r->total_amount,
                $delivery_type,
                $payment_mode,
                date_conversion($r->order_date),
                date_conversion($r->delivery_date)
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
