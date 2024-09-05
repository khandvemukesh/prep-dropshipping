<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProductUnitListing extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('loginModel');
    }

    function checkLogin() {
        if($this->session->userdata('id') != "" && $this->session->userdata('type') == "admin") {
        } else {
            redirect(base_url().'admin-login', 'Auto');
        }
    }

    function getProductUnit() {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $id = $this->session->userdata('id');
        $updatePermission = getDataByVal('update_data', 'permission', array('employee_id' => $id, 'type' => 'product'));

        foreach($_POST as $key => $value) {
            $data[$key] = $value;
        }
        $query = $this->loginModel->searchData('product_unit_stock_price', $data);

        $data = [];
        $sno = 1;
        foreach($query->result() as $r) {
            $status = $r->status == 1 ? "<span class='badge badge-success'>Enable</span>" : "<span class='badge badge-danger'>Disabled</span>";

            $stock_status = $r->stock_status == 1 ? "<span class='badge badge-success'>Available</span>" : "<span class='badge badge-danger'>Not Available</span>";

            if($updatePermission == "yes") {
                $updateButton = '<button type="button" data-toggle="modal" data-target="#editUnitModel" id="getEditDataUnit" data-id="'.$r->id.'" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button>
                <button type="button" id="disableProductData" data-column="status" data-table="product_unit_stock_price" data-id="'.$r->id.'" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>';
            } else {
                $updateButton = '';
            }
            $data[] = array(
                $sno,
                $status,
                $updateButton,
                $r->unit_value,
                getDataByVal('name', 'unit', array('id' => $r->unit)),
                $r->unit_sales_price,
                $r->unit_mrp,
                $stock_status
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

    function getMobileProductUnit() {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $id = $this->session->userdata('id');
        $updatePermission = getDataByVal('update_data', 'permission', array('employee_id' => $id, 'type' => 'product'));

        foreach($_POST as $key => $value) {
            $data[$key] = $value;
        }
        $query = $this->loginModel->searchData('product_ram_rom_price', $data);

        $data = [];
        $sno = 1;
        foreach($query->result() as $r) {
            $status = $r->status == 1 ? "<span class='badge badge-success'>Enable</span>" : "<span class='badge badge-danger'>Disabled</span>";

            $stock_status = $r->stock_status == 1 ? "<span class='badge badge-success'>Available</span>" : "<span class='badge badge-danger'>Not Available</span>";

            if($updatePermission == "yes") {
                $updateButton = '<button type="button" data-toggle="modal" data-target="#editMobileUnitModel" id="getEditDataMobileUnit" data-id="'.$r->id.'" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button>
                <button type="button" id="disableProductData" data-column="status" data-table="product_ram_rom_price" data-id="'.$r->id.'" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>';
            } else {
                $updateButton = '';
            }
            $data[] = array(
                $sno,
                $status,
                $updateButton,
                $r->ram_size.' '.$r->ram_size_type,
                $r->rom_size.' '.$r->rom_size_type,
                $r->unit_sales_price,
                $r->unit_mrp,
                $stock_status
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

    function getSize() {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $id = $this->session->userdata('id');
        $updatePermission = getDataByVal('update_data', 'permission', array('employee_id' => $id, 'type' => 'product'));

        foreach($_POST as $key => $value) {
            $data[$key] = $value;
        }
        $query = $this->loginModel->searchData('product_size', $data);

        $data = [];
        $sno = 1;
        foreach($query->result() as $r) {
            $status = $r->status == 1 ? "<span class='badge badge-success'>Enable</span>" : "<span class='badge badge-danger'>Disabled</span>";

            $stock_status = $r->stock_status == 1 ? "<span class='badge badge-success'>Available</span>" : "<span class='badge badge-danger'>Not Available</span>";

            if($updatePermission == "yes") {
                $updateButton = '<button type="button" data-toggle="modal" data-target="#editModal" id="getEditData" data-id="'.$r->id.'" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button>';
            } else {
                $updateButton = '';
            }
            $data[] = array(
                $sno,
                $status,
                $updateButton,
                $r->size,
                $r->size_type,
                $r->price_fluctuation,
                $stock_status,
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

    function getColor() {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $id = $this->session->userdata('id');
        $updatePermission = getDataByVal('update_data', 'permission', array('employee_id' => $id, 'type' => 'product'));

        foreach($_POST as $key => $value) {
            $data[$key] = $value;
        }
        $query = $this->loginModel->searchData('product_color', $data);

        $data = [];
        $sno = 1;
        foreach($query->result() as $r) {
            $status = $r->status == 1 ? "<span class='badge badge-success'>Enable</span>" : "<span class='badge badge-danger'>Disabled</span>";

            $stock_status = $r->stock_status == 1 ? "<span class='badge badge-success'>Available</span>" : "<span class='badge badge-danger'>Not Available</span>";

            if($updatePermission == "yes") {
                $updateButton = '<button type="button" data-toggle="modal" data-target="#editModal" id="getEditData" data-id="'.$r->id.'" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></button>';
            } else {
                $updateButton = '';
            }
            $image = '<img src="'.base_url().'image/product_color/'.$r->image.'" class="img img-thumbnail img-open" style="width:50px;">';
            $data[] = array(
                $sno,
                $status,
                $updateButton,
                $r->color,
                $image,
                $r->price_fluctuation,
                $stock_status,
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