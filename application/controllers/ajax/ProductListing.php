<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProductListing extends CI_Controller
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

    function getProduct()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $id = $this->session->userdata('id');
        $updatePermission = getDataByVal('update_data', 'permission', array('employee_id' => $id, 'type' => 'product'));

        $searchData = array();
        foreach ($_POST as $key => $value) {
            $searchData[$key] = $value;
        }
        $query = $this->loginModel->searchData('product', $searchData);

        $data = [];
        $sno = 1;
        foreach ($query->result() as $r) {
            $product_id_encoded = id_encode($r->id);
            $product_id = $r->id;
            $status = $r->status == 1 ? "<span class='badge badge-success'>Enable</span>" : "<span class='badge badge-danger'>Disabled</span>";
            $checkbox_class = $r->status == 1 ? "checkbox_delete" : "checkbox_active";
            $checbox = '<input type="checkbox" class="' . $checkbox_class . '" value="' . $r->id . '">';
            if ($updatePermission == "yes") {
                $updateButton = '
                <a href="' . base_url() . 'admin-create-product-details?product_id=' . $product_id_encoded . '" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>';
            } else {
                $updateButton = '';
            }
            $image = '<img src="' . base_url() . 'image/product/' . $r->home_image . '" class="img img-circle" style="width:50px;">';

            $shop_type_name = getDataByVal('name', 'shop_type', array('id' => $r->shop_type));
            $shop_type = '<span class="badge badge-secondary">' . $shop_type_name . '</span>';

            $featured_html = '<span class="fa fa-2x fa-toggle-off change-status text-success" data-id="' . $r->id . '" data-column="featured" data-status="1"></span>';
            if ($r->featured == 1)
                $featured_html = '<span class="fa fa-2x fa-toggle-on change-status text-success" data-id="' . $r->id . '" data-column="featured" data-status="0"></span>';

            $spaonsored_html = '<span class="fa fa-2x fa-toggle-off change-status text-warning" data-id="' . $r->id . '" data-column="sponsored" data-status="1"></span>';
            if ($r->sponsored == 1)
                $spaonsored_html = '<span class="fa fa-2x fa-toggle-on change-status text-warning" data-id="' . $r->id . '" data-column="sponsored" data-status="0"></span>';

            $data[] = array(
                $sno,
                $checbox,
                $status,
                $updateButton,
                $featured_html,
                $spaonsored_html,
                $image,
                $shop_type,
                substr($r->product_name, 0, 20),
                getDataByVal('name', 'category', array('id' => $r->category)),
                getDataByVal('name', 'sub_category', array('id' => $r->sub_category)),
                $r->brand,
                $r->gst_percent . ' - ' . $r->gst_type,
                substr($r->description, 0, 50),
                $r->origin
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

    function getVendorProduct()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $id = $this->session->userdata('id');
        $updatePermission = getDataByVal('update_data', 'permission', array('employee_id' => $id, 'type' => 'product'));

        $vendor_id = $this->input->post('vendor_id');

        $db_host = getDataByVal('cred_bd_host', 'user', array('id' => $vendor_id));
        $db_user = getDataByVal('cred_bd_user', 'user', array('id' => $vendor_id));
        $db_pass = getDataByVal('cred_bd_pass', 'user', array('id' => $vendor_id));
        $db_name = getDataByVal('cred_bd_name', 'user', array('id' => $vendor_id));
        if ($db_host != '')
            $db_host = id_decode($db_host);
        if ($db_user != '')
            $db_user = id_decode($db_user);
        if ($db_pass != '')
            $db_pass = id_decode($db_pass);
        if ($db_name != '')
            $db_name = id_decode($db_name);

        $config['database'] = $db_name;
        $config['hostname'] = $db_host;
        $config['username'] = $db_user;
        $config['password'] = $db_pass;
        $config['dbdriver'] = "mysqli";
        $config['dbprefix'] = "";
        $config['pconnect'] = FALSE;
        $config['db_debug'] = TRUE;

        $DB2 = $this->load->database($config, TRUE);

        foreach ($_POST as $key => $value) {
            if ($key == "vendor_id") {
            } else {
                if ($key != "" && $value != "") {
                    if ($key == "limit") {
                        $DB2->limit($value);
                    } elseif ($key == "name") {
                        $DB2->like($key, $value);
                    } elseif ($key == "product_name") {
                        $DB2->like($key, $value);
                    } elseif ($key == "order_by_desc") {
                        $DB2->order_by($value, "DESC");
                    } elseif ($key == "order_by_asc") {
                        $DB2->order_by($value, "ASC");
                    } elseif ($key == "start_date") {
                        $DB2->where('date >=', $value);
                    } elseif ($key == "end_date") {
                        $DB2->where('date <=', $value);
                    } elseif ($key == "start_date_order") {
                        $DB2->where('order_date >=', $value);
                    } elseif ($key == "end_date_order") {
                        $DB2->where('order_date <=', $value);
                    } elseif ($key == "not_in_order_status") {
                        $DB2->where_not_in('order_status', $value);
                    } elseif ($key == "in_order_status") {
                        $DB2->where_in('order_status', $value);
                    } else {
                        $DB2->where($key, $value);
                    }
                }
            }
        }
        $DB2->order_by('id', 'DESC');
        $query = $DB2->get('product');

        $data = [];
        $sno = 1;
        foreach ($query->result() as $r) {
            $product_id_encoded = id_encode($r->id);
            $product_id = $r->id;
            $status = $r->status == 1 ? "<span class='badge badge-success'>Enable</span>" : "<span class='badge badge-danger'>Disabled</span>";
            $checkbox_class = $r->status == 1 ? "checkbox_delete" : "checkbox_active";
            $checbox = '<input type="checkbox" class="' . $checkbox_class . '" value="' . $r->id . '">';
            if ($updatePermission == "yes") {
                $updateButton = '
                <a href="' . base_url() . 'admin-update-product/' . $product_id_encoded . '" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                <a href="' . base_url() . 'admin-product-unit-stock/' . $product_id_encoded . '" class="btn btn-xs btn-warning"><i class="fa fa-plus"></i> Unit</a>';
            } else {
                $updateButton = '';
            }
            $image = '<img src="' . base_url() . 'image/product/' . $r->home_image . '" class="img img-circle" style="width:50px;">';

            $shop_type_name = getDataByVal('name', 'shop_type', array('id' => $r->shop_type));
            $shop_type = '<span class="badge badge-secondary">' . $shop_type_name . '</span>';

            $data[] = array(
                $sno,
                $checbox,
                $status,
                $updateButton,
                $image,
                $shop_type,
                $r->product_name,
                getDataByVal('name', 'category', array('id' => $r->category)),
                getDataByVal('name', 'sub_category', array('id' => $r->sub_category)),
                $r->brand,
                $r->gst_percent . ' - ' . $r->gst_type,
                substr($r->description, 0, 50),
                $r->origin
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