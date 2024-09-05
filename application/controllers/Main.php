<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller {
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

    function getPermission($type, $customized = array()) {
        $id = $this->session->userdata('id');
        array_key_exists('addButton', $customized) ? ($data['addButton'] = $customized['addButton']) : ($data['addButton'] = getDataByVal('add_data', 'permission', array('employee_id' => $id, 'type' => $type)));

        array_key_exists('disableButton', $customized) ? ($data['disableButton'] = $customized['disableButton']) : ($data['disableButton'] = getDataByVal('delete_data', 'permission', array('employee_id' => $id, 'type' => $type)));

        array_key_exists('enableButton', $customized) ? ($data['enableButton'] = $customized['enableButton']) : ($data['enableButton'] = getDataByVal('delete_data', 'permission', array('employee_id' => $id, 'type' => $type)));

        array_key_exists('deletButton', $customized) ? ($data['deletButton'] = $customized['deletButton']) : ($data['deletButton'] = getDataByVal('delete_data', 'permission', array('employee_id' => $id, 'type' => $type)));
        $data['reloadButton'] = "yes";

        array_key_exists('notificationButton', $customized) ? ($data['notificationButton'] = $customized['notificationButton']) : ($data['notificationButton'] = getDataByVal('notification_data', 'permission', array('employee_id' => $id, 'type' => $type)));

        array_key_exists('messageButton', $customized) ? ($data['messageButton'] = $customized['messageButton']) : ($data['messageButton'] = getDataByVal('message_data', 'permission', array('employee_id' => $id, 'type' => $type)));

        array_key_exists('searchButton', $customized) ? ($data['searchButton'] = $customized['searchButton']) : ($data['searchButton'] = getDataByVal('search_data', 'permission', array('employee_id' => $id, 'type' => $type)));

        array_key_exists('emailButton', $customized) ? ($data['emailButton'] = $customized['emailButton']) : ($data['emailButton'] = getDataByVal('email_data', 'permission', array('employee_id' => $id, 'type' => $type)));

        array_key_exists('update', $customized) ? ($data['update'] = $customized['update']) : ($data['update'] = getDataByVal('update_data', 'permission', array('employee_id' => $id, 'type' => $type)));

        array_key_exists('view', $customized) ? ($data['view'] = $customized['view']) : ($data['view'] = getDataByVal('view_data', 'permission', array('employee_id' => $id, 'type' => $type)));
        return $data;
    }

    function getModulePermission($type) {
        $module_permission = getDataByVal('permission_status', 'module_permission', array('module_name' => $type));
        if($module_permission == 1) {
        } else {
            redirect(base_url(), 'Auto');
        }
    }

    public function login() {
        $this->load->view('admin/login');
    }

    function getPassword() {
        echo password('Advit#');
    }

    public function checkLoginDetails() {
        $res = false;
        if($this->input->post('email') != "" && $this->input->post('password') != "") {
            $email = $this->input->post('email');
            $password = password($this->input->post('password'));
            $this->db->where('email', $email);
            $this->db->where('password', $password);
            $this->db->where('status', '1');
            $loginStatus = $this->db->get('staff');
            if($loginStatus->num_rows() > 0) {
                $staffDataObj = $loginStatus->row();
                $session_data = array(
                    'id' => $staffDataObj->id,
                    'company_name' => $staffDataObj->name,
                    'user_name' => $staffDataObj->email,
                    'date' => sys_date(),
                    'time' => sys_time(),
                    'type' => 'admin',
                );
                $this->session->set_userdata($session_data);
                $res = true;
            }
        }
        echo $res;
    }

    public function index() {
        $this->checkLogin();
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $this->session->userdata('id'), '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('dashboard');
        $this->load->view('admin/dashboard', $data);
    }

    public function disableData() {
        $this->checkLogin();
        $table_name = $this->input->post('table_name');
        $id = $this->input->post('checkbox_value');
        for($i = 0; $i < count($id); $i++) {
            $data = array(
                'status' => 0
            );
            echo $this->loginModel->updateData('id', $id[$i], $table_name, $data);
        }
    }

    public function enableData() {
        $this->checkLogin();
        $table_name = $this->input->post('table_name');
        $id = $this->input->post('checkbox_value');
        for($i = 0; $i < count($id); $i++) {
            $data = array(
                'status' => 1
            );
            $this->loginModel->updateData('id', $id[$i], $table_name, $data);
        }
    }

    public function deleteData() {
        $this->checkLogin();
        $table_name = $this->input->post('table_name');
        $id = $this->input->post('checkbox_value');
        for($i = 0; $i < count($id); $i++) {
            $this->loginModel->deleteData('id', $id[$i], $table_name);
        }
    }

    public function deleteSingleDataByColumn() {
        $table_name = $this->input->post('table_name');
        $id = $this->input->post('id');
        $column_name = $this->input->post('column_name');
        echo $this->loginModel->deleteData($column_name, $id, $table_name);
    }

    public function addData($table_name) {
        if(isset($_FILES['image'])) {
            $data['image'] = $this->uploadImage('image', $table_name);
        }
        foreach($_POST as $key => $value) {
            if($key == "image") {
            } else {
                $data[$key] = validate($this->input->post($key));
            }
        }
        echo $this->db->insert($table_name, $data);
    }

    public function updateData($table_name, $id, $where_coloum) {
        if(isset($_FILES['image'])) {
            if(isset($_POST['multi'])) {
                $img = $this->input->post("oldImage");
                for($k = 0; $k < count($_FILES['image']['name']); $k++) {
                    if($img != "") {
                        $img .= " --> ".$this->updateMultiImage('image', $table_name, $k);
                    } else {
                        $img .= $this->updateMultiImage('image', $table_name, $k);
                    }
                }
                $data['image'] = $img;
            } else {
                $data['image'] = $this->updateImage('image', $table_name);
            }
        }
        foreach($_POST as $key => $value) {
            if($key == "image" || $key == "oldImage" || $key == "qrcode" || $key == "oldQrcode" || $key == "multi") {
            } else {
                $data[$key] = $this->input->post($key);
            }
        }
        $this->db->where($where_coloum, $id);
        echo $this->db->update($table_name, $data);
    }

    public function uploadImage($key, $destfolder) {
        if(empty($_FILES[$key]['name'])) {
            $new_name = "default-image.png";
            return $new_name;
        } else {
            $new_name = rand().'.'.pathinfo($_FILES[$key]["name"], PATHINFO_EXTENSION);
            $destination = "./image/".$destfolder."/".$new_name;
            move_uploaded_file($_FILES[$key]['tmp_name'], $destination);
            return $new_name;
        }
    }

    public function updateImage($key, $destfolder) {
        if(empty($_FILES[$key]['name'])) {
            $old_name = $this->input->post('oldImage');
            return $old_name;
        } else {
            $old_name = $this->input->post('oldImage');
            if($old_name != "default.png" && $old_name != "") {
                unlink("./image/".$destfolder."/".$old_name);
            }
            $new_name = rand().'.'.pathinfo($_FILES[$key]["name"], PATHINFO_EXTENSION);
            $destination = "./image/".$destfolder."/".$new_name;
            move_uploaded_file($_FILES[$key]['tmp_name'], $destination);
            return $new_name;
        }
    }

    public function updateMultiImage($key, $destfolder, $i) {
        $new_name = rand().'-'.$_FILES[$key]["name"][$i];
        $destination = "./image/".$destfolder."/".$new_name;
        move_uploaded_file($_FILES[$key]['tmp_name'][$i], $destination);
        return $new_name;
    }

    public function searchData($table_name, $pageName) {
        foreach($_GET as $key => $value) {
            $data[$key] = $this->input->get($key);
        }
        $pagedata = $this->loginModel->searchData($table_name, $data);
        $this->$pageName('', $pagedata);
    }

    public function getEditData() {
        $table_name = $this->input->post('table_name');
        $id = $this->input->post('id');
        $this->load->model('loginModel');
        $data = $this->loginModel->getAllData($table_name, 'id', $id, 1)->row();
        echo json_encode($data);
    }

    public function getEditDataByColumn() {
        $table_name = $this->input->post('table_name');
        $column = $this->input->post('column');
        $id = $this->input->post('id');
        $this->load->model('loginModel');
        $data = $this->loginModel->getAllData($table_name, $column, $id, 1)->result();
        echo json_encode($data);
    }

    public function checkData() {
        $table_name = $this->input->post('table');
        $column = $this->input->post('column');
        $value = $this->input->post('value');
        $this->load->model('loginModel');
        $query = $this->loginModel->getAllDataWithoutStatus($table_name, $column, $value);
        if($query->num_rows() > 0) {
            $status = false;
        } else {
            $status = true;
        }
        echo $status;
    }

    function globalUpdate() {
        $update_data = array(
            $this->input->post('table_column') => $this->input->post('value')
        );
        $this->load->model('loginModel');
        $table_name = $this->input->post('table_name');
        $this->loginModel->updateData('id', $this->input->post('id'), $table_name, $update_data);
    }

    public function getOptions() {
        $data = "<option value=''>-- Select Data --</option>";
        $table = $this->input->post('table');
        $column = $this->input->post('column');
        $value = $this->input->post('value');
        $coulum_to_show = $this->input->post('coulum_to_show');
        $query = getAllDataByVal($table, array($column => $value));
        foreach($query->result() as $row) {
            $data .= "<option value='".$row->id."'>".$row->$coulum_to_show."</option>";
        }
        echo $data;
    }

    public function staff() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('staff');
        $this->load->view('admin/staff', $data);
    }

    public function addStaff($table_name) {
        foreach($_POST as $key => $value) {
            if($key == "password") {
                $data[$key] = password($this->input->post($key));
            } else {
                $data[$key] = $this->input->post($key);
            }
        }
        $query = $this->db->insert($table_name, $data);
        if($query) {
            $staff_id = $this->db->insert_id();
            $this->basicPermission($staff_id);
            echo $staff_id;
        } else {
            echo false;
        }
    }

    public function staffPermission($employee_id) {
        $this->checkLogin();
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $this->session->userdata('id'), '1');
        $this->load->view('admin/header', $data);

        $data['pagedata'] = getAllDataByVal('permission', array('employee_id' => $employee_id, 'status' => '1'));
        $this->load->view('admin/permission', $data);
    }

    public function updatePermission() {
        $status = $this->input->post('status');
        $column = $this->input->post('column');
        $id = $this->input->post('id');
        $change_type = $this->input->post('change_type');
        $type = getDataByVal('type', 'permission', array('id' => $id));
        if($change_type == "single") {
            $updateData[$column] = $status;
            $this->db->where('id', $id);
            $query = $this->db->update('permission', $updateData);
        } else {
            $getPermission = getAllDataByVal('permission', array('id' => $id))->row();
            if($status == "yes") {
                if($getPermission->add_data == "no")
                    $updateData['add_data'] = "yes";
                if($getPermission->view_data == "no")
                    $updateData['view_data'] = "yes";
                if($getPermission->search_data == "no")
                    $updateData['search_data'] = "yes";
                if($getPermission->update_data == "no")
                    $updateData['update_data'] = "yes";
                if($getPermission->delete_data == "no")
                    $updateData['delete_data'] = "yes";
                if($getPermission->notification_data == "no")
                    $updateData['notification_data'] = "yes";
                if($getPermission->message_data == "no")
                    $updateData['message_data'] = "yes";
            } else {
                if($getPermission->add_data == "yes")
                    $updateData['add_data'] = "no";
                if($getPermission->view_data == "yes")
                    $updateData['view_data'] = "no";
                if($getPermission->search_data == "yes")
                    $updateData['search_data'] = "no";
                if($getPermission->update_data == "yes")
                    $updateData['update_data'] = "no";
                if($getPermission->delete_data == "yes")
                    $updateData['delete_data'] = "no";
                if($getPermission->notification_data == "yes")
                    $updateData['notification_data'] = "no";
                if($getPermission->message_data == "yes")
                    $updateData['message_data'] = "no";
            }
            $this->db->where('id', $id);
            $query = $this->db->update('permission', $updateData);
        }

        $data = getAllDataByVal('permission', array('id' => $id))->row();

        if(($data->add_data == "yes" || $data->add_data == "") && ($data->view_data == "yes" || $data->view_data == "") && ($data->search_data == "yes" || $data->search_data == "") && ($data->update_data == "yes" || $data->update_data == "") && ($data->delete_data == "yes" || $data->delete_data == "") && ($data->notification_data == "yes" || $data->notification_data == "") && ($data->message_data == "yes" || $data->message_data == "")) {
            $all = "yes";
        } else {
            $all = "no";
        }

        if($all == "yes")
            echo "all";
        else
            echo "no";
    }

    public function basicPermission($employee_id) {
        $dashboardPermission = array(
            'employee_id' => $employee_id,
            'type' => 'dashboard',
            'add_data' => '',
            'view_data' => 'no',
            'search_data' => '',
            'update_data' => '',
            'delete_data' => '',
            'notification_data' => '',
            'message_data' => '',
        );
        $this->db->insert('permission', $dashboardPermission);

        $employeePermission = array(
            'employee_id' => $employee_id,
            'type' => 'staff',
            'add_data' => 'no',
            'view_data' => 'no',
            'search_data' => 'no',
            'update_data' => 'no',
            'delete_data' => 'no',
            'notification_data' => '',
            'message_data' => '',
        );
        $this->db->insert('permission', $employeePermission);

        $shopTypePermission = array(
            'employee_id' => $employee_id,
            'type' => 'shop_type',
            'add_data' => 'no',
            'view_data' => 'no',
            'search_data' => 'no',
            'update_data' => 'no',
            'delete_data' => 'no',
            'notification_data' => '',
            'message_data' => '',
        );
        $this->db->insert('permission', $shopTypePermission);
    }

    public function shopType() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('shop_type');
        $this->load->view('admin/shop-type', $data);
    }

    public function category() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('category');
        $data['shopTypeData'] = getAllDataByVal('shop_type', array('status' => 1));
        $this->load->view('admin/category', $data);
    }

    public function subCategory() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('sub_category');
        $data['categoryData'] = getAllDataByVal('category', array('status' => 1));
        $this->load->view('admin/sub-category', $data);
    }

    public function brands() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('brand');
        $data['shopTypeData'] = getAllDataByVal('shop_type', array('status' => 1));
        $this->load->view('admin/brand', $data);
    }

    public function unit() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('unit');
        $data['shopTypeData'] = getAllDataByVal('shop_type', array('status' => 1));
        $this->load->view('admin/unit', $data);
    }

    public function formFields() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('unit');
        $data['shopTypeData'] = getAllDataByVal('shop_type', array('status' => 1));
        $this->load->view('admin/form-field', $data);
    }

    function insertFormFields() {
        $isValidated = true;
        $isValidatedShopType = true;

        if($this->input->post('shop_type') == "") {
            $isValidatedShopType = false;
            $isValidated = false;
            $message = 'Shop Type Is Required';
        }

        if($this->input->post('field_name') == "") {
            $isValidated = false;
            $message = "Field Name Is Required";
        }
        if($this->input->post('field_type') == "") {
            $isValidated = false;
            $message = 'Field Type Is Required';
        }

        if($isValidatedShopType == true) {
            $shop_type_id = $this->input->post('shop_type');
            $checkShopType = getAllDataByVal('shop_type', array('id' => $shop_type_id));
            if($checkShopType->num_rows() <= 0) {
                $isValidated = false;
                $message = "Wrong Super Category";
            }
        }


        if($isValidated == true) {
            $insData['super_category_id	'] = validate($this->input->post('shop_type'));
            $insData['field_name'] = validate($this->input->post('field_name'));
            $insData['field_type'] = validate($this->input->post('field_type'));
            $insData['field_validation'] = 'not-required';
            $insData['date'] = sys_date();
            $insData['time'] = sys_time();
            $insData['status'] = 1;
            $query = $this->db->insert('form_fields', $insData);
            if($query) {
                $form_field_id = $this->db->insert_id();
                if($this->input->post('form_field_value')) {
                    if(is_array($this->input->post('form_field_value'))) {
                        for($l = 0; $l < count($_POST['form_field_value']); $l++) {
                            $insDataValue['form_field_id'] = $form_field_id;
                            $insDataValue['form_field_value'] = $_POST['form_field_value'][$l];
                            $insDataValue['status'] = 1;
                            $insDataValue['date'] = sys_date();
                            $insDataValue['time'] = sys_time();
                            $this->db->insert('form_field_values', $insDataValue);
                        }
                    }
                }
                $message = 'Form Field Successfully Added';
                $data['status'] = true;
                $data['rcode'] = 200;
                $data['message'] = $message;
                $data['size_id'] = (int)$form_field_id;
            } else {
                $data['status'] = false;
                $data['rcode'] = 500;
                $data['message'] = 'Something Went Wrong';
            }
        } else {
            $data['status'] = false;
            $data['rcode'] = 500;
            $data['message'] = $message;
        }
        echo json_encode($data);
    }

    public function subscription() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('subscription');
        $data['shopTypeData'] = getAllDataByVal('shop_type', array('status' => 1));
        $this->load->view('admin/subscription', $data);
    }

    public function addProduct() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('product');
        $data['shopTypeData'] = getAllDataByVal('shop_type', array('status' => 1));
        $data['categoryData'] = getAllDataByVal('category', array('status' => 1));
        $data['subCategoryData'] = getAllDataByVal('sub_category', array('status' => 1));
        $this->load->view('admin/create-product', $data);
    }

    public function createProductDetails() {
        $this->checkLogin();
        $product_id = $shop_type_id = $category_id = $sub_category_id = $product_id = "";
        $id = $this->session->userdata('id');
        if($this->input->get('product_id') != "") {
            $product_id = id_decode($this->input->get('product_id'));
            $checkProductId = getAllDataByVal('product', array('id' => $product_id));
            if($checkProductId->num_rows() <= 0)
                redirect(base_url().'admin-dashboard', 'auto');
        }
        if($this->input->get('shop_type_id') != "")
            $shop_type_id = id_decode($this->input->get('shop_type_id'));
        if($this->input->get('category_id') != "")
            $category_id = id_decode($this->input->get('category_id'));
        if($this->input->get('sub_category_id') != "")
            $sub_category_id = id_decode($this->input->get('sub_category_id'));

        if($product_id != "") {
            $shop_type_id = getDataByVal('shop_type', 'product', array('id' => $product_id));
            $category_id = getDataByVal('category', 'product', array('id' => $product_id));
            $sub_category_id = getDataByVal('sub_category', 'product', array('id' => $product_id));
        }

        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('product');
        $data['shop_type'] = $shop_type_id;
        $data['category_id'] = $category_id;
        $data['sub_category_id'] = $sub_category_id;
        $data['shop_type_name'] = getDataByVal('name', 'shop_type', array('id' => $shop_type_id));
        $data['product_id'] = $product_id;
        $data['unitData'] = getAllDataByVal('unit', array('status' => 1));
        $data['specificationData'] = getAllDataByVal('form_fields', array('super_category_id' => $shop_type_id, 'status' => 1));
        $data['brandData'] = getAllDataByVal('brand', array('status' => 1));
        $this->load->view('admin/manage-product', $data);
    }

    public function addProductFunction() {
        $isValidated = true;
        $isValidatedCategory = true;
        $isValidatedSubCategory = true;
        $isValidatedProduct = true;
        $validationRes = array();

        if($this->input->post('product_id')) {
            if($this->input->post('product_id') == "") {
                $isValidatedProduct = false;
                $isValidated = false;
                $message = 'Product Id Is Required';
            }
            $activity_type = 'update';
        } else {
            $activity_type = 'add';
        }

        if($this->input->post('product_name') == "") {
            $isValidated = false;
            $message = 'Product Name Is Required';
        }
        if($this->input->post('category_id') == "") {
            $isValidated = false;
            $isValidatedCategory = false;
            $message = 'Category Is Required';
        }
        if($this->input->post('sub_category_id') == "") {
            $isValidated = false;
            $isValidatedSubCategory = false;
            $message = 'Sub Category Is Required';
        }
        if($this->input->post('brand') == "") {
            $isValidated = false;
            $message = 'Brand Is Required';
        }

        if($isValidatedCategory == true) {
            $category_id = validate($this->input->post('category_id'));
            $checkCategory = getAllDataByVal('category', array('id' => $category_id));
            if($checkCategory->num_rows() == 0) {
                $isValidated = false;
                $message = 'Wrong Category';
            }
        }
        if($isValidatedSubCategory == true) {
            $sub_category_id = validate($this->input->post('sub_category_id'));
            $checkSubCategory = getAllDataByVal('sub_category', array('id' => $sub_category_id));
            if($checkSubCategory->num_rows() == 0) {
                $isValidated = false;
                $message = 'Wrong Sub Category';
            }
        }

        if($activity_type == "update") {
            if($isValidatedProduct == true) {
                $product_id = validate($this->input->post('product_id'));
                $checkProduct = getAllDataByVal('product', array('id' => $product_id));
                if($checkProduct->num_rows() == 0) {
                    $isValidated = false;
                    $message = 'Wrong Product';
                }
            }
        }

        if($isValidated == true) {
            $product_name = validate($this->input->post('product_name'));
            $insData['shop_type'] = validate($this->input->post('shop_type'));
            $insData['product_name'] = validate($this->input->post('product_name'));
            $insData['title'] = validate($this->input->post('product_name'));
            $insData['category'] = validate($this->input->post('category_id'));
            $insData['sub_category'] = validate($this->input->post('sub_category_id'));
            $insData['brand'] = validate($this->input->post('brand'));
            $insData['gst_percent'] = validate($this->input->post('gst_percent'));
            $insData['gst_type'] = validate($this->input->post('gst_type'));
            $insData['description'] = $this->input->post('description');
            $insData['disclaimer'] = $this->input->post('disclaimer');
            $insData['additional_detaiils'] = $this->input->post('additional_detaiils');
            $insData['origin'] = validate($this->input->post('origin'));
            $insData['hsn'] = validate($this->input->post('hsn'));
            $insData['date'] = sys_date();
            $insData['time'] = sys_time();
            $insData['status'] = 1;
            if($activity_type == "add") {
                $query = $this->db->insert('product', $insData);
            } else {
                $product_id = validate($this->input->post('product_id'));
                $this->db->where('id', $product_id);
                $query = $this->db->update('product', $insData);
            }
            if($query) {
                $data['status'] = true;
                $data['rcode'] = 200;
                if($activity_type == "add") {
                    $product_id = $this->db->insert_id();
                    $data['message'] = 'Product Successfully Added';
                } else
                    $data['message'] = 'Product Successfully Updated';

                $data['product_id'] = id_encode($product_id);
            } else {
                $data['status'] = false;
                $data['rcode'] = 500;
                $data['message'] = $message;
            }
        } else {
            $data['status'] = false;
            $data['rcode'] = 500;
            $data['message'] = $message;
        }
        echo json_encode($data);
    }

    function uploadProductImages() {
        $product_id = $this->input->post('product_id');
        $home_image = getDataByVal('home_image', 'product', array('id' => $product_id));
        if(!empty($_FILES)) {
            $files = $_FILES;
            $count = count($_FILES['product_images']['name']);
            for($i = 0; $i < $count; $i++) {
                $k = $i + 1;
                $_FILES['product_images']['name'] = $files['product_images']['name'][$i];
                $_FILES['product_images']['type'] = $files['product_images']['type'][$i];
                $_FILES['product_images']['tmp_name'] = $files['product_images']['tmp_name'][$i];
                $_FILES['product_images']['error'] = $files['product_images']['error'][$i];
                $_FILES['product_images']['size'] = $files['product_images']['size'][$i];

                $config['upload_path'] = './image/product/';
                $config['file_name'] = 'PRO'.mt_rand(11, 99).'-'.$k;
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = 500;
                $config['remove_spaces'] = true;
                $this->load->library('upload', $config);

                if(!$this->upload->do_upload('product_images')) {
                    $error = $this->upload->display_errors();
                    $res_status = false;
                } else {
                    $uploadedImage = $this->upload->data();
                    $image_name = $uploadedImage['file_name'];
                    $imgData['product_id'] = $product_id;
                    $imgData['image'] = $image_name;
                    $imgData['status'] = 1;
                    $imgData['date'] = sys_date();
                    $imgData['time'] = sys_time();
                    $this->db->insert('product_images', $imgData);
                    if($home_image == "") {
                        $upData['home_image'] = $image_name;
                        $this->db->where('id', $product_id);
                        $this->db->update('product', $upData);
                    }
                    $res_status = true;
                }
            }
        } else {
            $res_status = false;
        }
        echo $res_status;
    }

    function listProductImages() {
        $product_id = $this->input->post('product_id');
        $data['home_image'] = getDataByVal('home_image', 'product', array('id' => $product_id));
        $data['imageData'] = getAllDataByVal('product_images', array('product_id' => $product_id));
        $this->load->view('admin/ajax/product-images', $data);
    }

    function deleteProductImage() {
        $id = $this->input->post('id');
        $image = getDataByVal('image', 'product_images', array('id' => $id));
        if($image != '') {
            if(file_exists('./image/product'.$image)) {
                unlink('./image/product'.$image);
            }
            $this->db->where('id', $id);
            $this->db->delete('product_images');
        }
    }

    function imageSetAsDefault() {
        $image = $this->input->post('image');
        $product_id = $this->input->post('product_id');
        $upData['home_image'] = $image;
        $this->db->where('id', $product_id);
        $this->db->update('product', $upData);
    }

    public function productUnitStockPrice($product_id_encoded) {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('product');
        $data['shopTypeData'] = getAllDataByVal('shop_type', array('status' => 1));
        $data['unitData'] = getAllDataByVal('unit', array('status' => 1));
        $data['product_id'] = id_decode($product_id_encoded);
        $this->load->view('admin/product-unit-stock-price', $data);
    }

    function addUnitAndPrice() {
        $isValidated = true;
        $isValidatedUnit = true;
        $isValidatedProduct = true;
        $isValidatedUnitAndPrice = true;
        $validationRes = array();

        if($this->input->post('unit_and_price_id')) {
            if($this->input->post('unit_and_price_id') == "") {
                $isValidatedUnitAndPrice = false;
                $isValidated = false;
                $message = 'Unit And Price Id Is Required';
            }
            $activity_type = 'update';
        } else {
            $activity_type = 'add';
        }

        if($this->input->post('unit_value') == "") {
            $isValidated = false;
            $message = "Unit Value Is Required";
        }
        if($this->input->post('unit_id') == "") {
            $isValidated = false;
            $isValidatedUnit = false;
            $message = 'Unit Is Required';
        }
        if($this->input->post('selling_price') == "") {
            $isValidated = false;
            $message = 'Selling Price Is Required';
        }
        if($this->input->post('stock_status') == "") {
            $isValidated = false;
            $message = 'Stock Status Is Required';
        }
        if($this->input->post('product_id') == "") {
            $isValidated = false;
            $isValidatedProduct = false;
            $message = 'Product Is Required';
        }

        if($isValidatedUnit == true) {
            $unit_id = validate($this->input->post('unit_id'));
            $checkUnit = getAllDataByVal('unit', array('id' => $unit_id));
            if($checkUnit->num_rows() == 0) {
                $isValidated = false;
                $message = 'Wrong Unit';
            }
        }

        if($isValidatedProduct == true) {
            $product_id = validate($this->input->post('product_id'));
            $checkProduct = getAllDataByVal('product', array('id' => $product_id));
            if($checkProduct->num_rows() == 0) {
                $isValidated = false;
                $message = 'Wrong Product';
            }
        }

        if($activity_type == 'update') {
            if($isValidatedUnitAndPrice == true) {
                $unit_and_price_id = validate($this->input->post('unit_and_price_id'));
                $checkUnitAndPrice = getAllDataByVal('product_unit_stock_price', array('id' => $unit_and_price_id));
                if($checkUnitAndPrice->num_rows() == 0) {
                    $isValidated = false;
                    $message = 'Wrong Unit And Product Id';
                }
            }
        }

        if($isValidated == true) {
            $insData['product_id'] = validate($this->input->post('product_id'));
            $insData['unit'] = validate($this->input->post('unit_id'));
            $insData['unit_value'] = validate($this->input->post('unit_value'));
            $insData['unit_sales_price'] = validate($this->input->post('selling_price'));
            $insData['unit_mrp'] = validate($this->input->post('mrp'));
            $insData['stock_status'] = validate($this->input->post('stock_status'));
            $insData['date'] = sys_date();
            $insData['time'] = sys_time();
            $insData['status'] = 1;
            if($activity_type == "add") {
                $query = $this->db->insert('product_unit_stock_price', $insData);
            } else {
                $unit_and_price_id = validate($this->input->post('unit_and_price_id'));
                $this->db->where('id', $unit_and_price_id);
                $query = $this->db->update('product_unit_stock_price', $insData);
            }
            if($query) {
                if($activity_type == "add") {
                    $unit_and_price_id = $this->db->insert_id();
                    $message = 'Unit And Prices Successfully Added';
                } else {
                    $unit_and_price_id = validate($this->input->post('unit_and_price_id'));
                    $message = 'Unit And Prices Successfully Updated';
                }
                $data['status'] = true;
                $data['rcode'] = 200;
                $data['message'] = $message;
                $data['unit_and_price_id'] = (int)$unit_and_price_id;
            } else {
                $data['status'] = false;
                $data['rcode'] = 500;
                $data['message'] = 'Something Went Wrong';
            }
        } else {
            $data['status'] = false;
            $data['rcode'] = 500;
            $data['message'] = $message;
        }
        echo json_encode($data);
    }


    function addMobileUnitAndPrice() {
        $isValidated = true;
        $isValidatedUnit = true;
        $isValidatedProduct = true;
        $isValidatedUnitAndPrice = true;
        $validationRes = array();

        if($this->input->post('unit_and_price_id')) {
            if($this->input->post('unit_and_price_id') == "") {
                $isValidatedUnitAndPrice = false;
                $isValidated = false;
                $message = 'Unit And Price Id Is Required';
            }
            $activity_type = 'update';
        } else {
            $activity_type = 'add';
        }

        if($this->input->post('ram_size') == "") {
            $isValidated = false;
            $message = "RAM Size Is Required";
        }
        if($this->input->post('ram_size_type') == "") {
            $isValidated = false;
            $message = 'Type Is Required';
        }
        if($this->input->post('rom_size') == "") {
            $isValidated = false;
            $message = 'ROM Size Is Required';
        }
        if($this->input->post('rom_size_type') == "") {
            $isValidated = false;
            $message = 'Type Is Required';
        }
        if($this->input->post('selling_price') == "") {
            $isValidated = false;
            $message = 'Selling Price Is Required';
        }
        if($this->input->post('stock_status') == "") {
            $isValidated = false;
            $message = 'Stock Status Is Required';
        }
        if($this->input->post('product_id') == "") {
            $isValidated = false;
            $isValidatedProduct = false;
            $message = 'Product Is Required';
        }


        if($isValidatedProduct == true) {
            $product_id = validate($this->input->post('product_id'));
            $checkProduct = getAllDataByVal('product', array('id' => $product_id));
            if($checkProduct->num_rows() == 0) {
                $isValidated = false;
                $message = 'Wrong Product';
            }
        }

        if($activity_type == 'update') {
            if($isValidatedUnitAndPrice == true) {
                $unit_and_price_id = validate($this->input->post('unit_and_price_id'));
                $checkUnitAndPrice = getAllDataByVal('product_unit_stock_price', array('id' => $unit_and_price_id));
                if($checkUnitAndPrice->num_rows() == 0) {
                    $isValidated = false;
                    $message = 'Wrong Unit And Product Id';
                }
            }
        }

        if($isValidated == true) {
            $insData['product_id'] = validate($this->input->post('product_id'));
            $insData['ram_size'] = validate($this->input->post('ram_size'));
            $insData['ram_size_type'] = validate($this->input->post('ram_size_type'));
            $insData['rom_size'] = validate($this->input->post('rom_size'));
            $insData['rom_size_type'] = validate($this->input->post('rom_size_type'));
            $insData['unit_sales_price'] = validate($this->input->post('selling_price'));
            $insData['unit_mrp'] = validate($this->input->post('mrp'));
            $insData['stock_status'] = validate($this->input->post('stock_status'));
            $insData['date'] = sys_date();
            $insData['time'] = sys_time();
            $insData['status'] = 1;
            if($activity_type == "add") {
                $query = $this->db->insert('product_ram_rom_price', $insData);
            } else {
                $unit_and_price_id = validate($this->input->post('unit_and_price_id'));
                $this->db->where('id', $unit_and_price_id);
                $query = $this->db->update('product_ram_rom_price', $insData);
            }
            if($query) {
                if($activity_type == "add") {
                    $unit_and_price_id = $this->db->insert_id();
                    $message = 'Unit And Prices Successfully Added';
                } else {
                    $unit_and_price_id = validate($this->input->post('unit_and_price_id'));
                    $message = 'Unit And Prices Successfully Updated';
                }
                $data['status'] = true;
                $data['rcode'] = 200;
                $data['message'] = $message;
                $data['unit_and_price_id'] = (int)$unit_and_price_id;
            } else {
                $data['status'] = false;
                $data['rcode'] = 500;
                $data['message'] = 'Something Went Wrong';
            }
        } else {
            $data['status'] = false;
            $data['rcode'] = 500;
            $data['message'] = $message;
        }
        echo json_encode($data);
    }

    function addSize() {
        $isValidated = true;
        $isValidatedProduct = true;
        $isValidatedUnitAndPrice = true;

        if($this->input->post('size_id')) {
            if($this->input->post('size_id') == "") {
                $isValidatedUnitAndPrice = false;
                $isValidated = false;
                $message = 'Size ID Is Required';
            }
            $activity_type = 'update';
        } else {
            $activity_type = 'add';
        }

        if($this->input->post('size') == "") {
            $isValidated = false;
            $message = "Size Is Required";
        }
        if($this->input->post('stock_status') == "") {
            $isValidated = false;
            $message = 'Stock Status Is Required';
        }
        if($this->input->post('product_id') == "") {
            $isValidated = false;
            $isValidatedProduct = false;
            $message = 'Product Is Required';
        }


        if($isValidatedProduct == true) {
            $product_id = validate($this->input->post('product_id'));
            $checkProduct = getAllDataByVal('product', array('id' => $product_id));
            if($checkProduct->num_rows() == 0) {
                $isValidated = false;
                $message = 'Wrong Product';
            }
        }

        if($activity_type == 'update') {
            if($isValidatedUnitAndPrice == true) {
                $size_id = validate($this->input->post('size_id'));
                $checkUnitAndPrice = getAllDataByVal('product_size', array('id' => $size_id));
                if($checkUnitAndPrice->num_rows() == 0) {
                    $isValidated = false;
                    $message = 'Wrong Size Id';
                }
            }
        }

        if($isValidated == true) {
            $insData['product_id'] = validate($this->input->post('product_id'));
            $insData['size'] = validate($this->input->post('size'));
            $insData['size_type'] = validate($this->input->post('size_type'));
            $insData['price_fluctuation'] = validate($this->input->post('price_fluctuation'));
            $insData['stock_status'] = validate($this->input->post('stock_status'));
            $insData['date'] = sys_date();
            $insData['time'] = sys_time();
            $insData['status'] = 1;
            if($activity_type == "add") {
                $query = $this->db->insert('product_size', $insData);
            } else {
                $size_id = validate($this->input->post('size_id'));
                $this->db->where('id', $size_id);
                $query = $this->db->update('product_size', $insData);
            }
            if($query) {
                if($activity_type == "add") {
                    $unit_and_price_id = $this->db->insert_id();
                    $message = 'Size Successfully Added';
                } else {
                    $unit_and_price_id = validate($this->input->post('size_id'));
                    $message = 'Unit And Prices Successfully Updated';
                }
                $data['status'] = true;
                $data['rcode'] = 200;
                $data['message'] = $message;
                $data['size_id'] = (int)$unit_and_price_id;
            } else {
                $data['status'] = false;
                $data['rcode'] = 500;
                $data['message'] = 'Something Went Wrong';
            }
        } else {
            $data['status'] = false;
            $data['rcode'] = 500;
            $data['message'] = $message;
        }
        echo json_encode($data);
    }

    function addColor() {
        $isValidated = true;
        $isValidatedProduct = true;
        $isValidatedUnitAndPrice = true;

        if($this->input->post('color_id')) {
            if($this->input->post('color_id') == "") {
                $isValidatedUnitAndPrice = false;
                $isValidated = false;
                $message = 'Color ID Is Required';
            }
            $activity_type = 'update';
        } else {
            $activity_type = 'add';
        }

        if($this->input->post('color') == "") {
            $isValidated = false;
            $message = "Color Is Required";
        }
        if($this->input->post('stock_status') == "") {
            $isValidated = false;
            $message = 'Stock Status Is Required';
        }
        if($this->input->post('product_id') == "") {
            $isValidated = false;
            $isValidatedProduct = false;
            $message = 'Product Is Required';
        }


        if($isValidatedProduct == true) {
            $product_id = validate($this->input->post('product_id'));
            $checkProduct = getAllDataByVal('product', array('id' => $product_id));
            if($checkProduct->num_rows() == 0) {
                $isValidated = false;
                $message = 'Wrong Product';
            }
        }

        if($activity_type == 'update') {
            if($isValidatedUnitAndPrice == true) {
                $color_id = validate($this->input->post('color_id'));
                $checkUnitAndPrice = getAllDataByVal('product_color', array('id' => $color_id));
                if($checkUnitAndPrice->num_rows() == 0) {
                    $isValidated = false;
                    $message = 'Wrong Color Id';
                }
            }
        }

        if($isValidated == true) {
            $insData['product_id'] = validate($this->input->post('product_id'));
            $insData['color'] = validate($this->input->post('color'));
            $insData['image'] = $this->uploadImage('color_image', 'product_color');
            $insData['price_fluctuation'] = validate($this->input->post('price_fluctuation'));
            $insData['stock_status'] = validate($this->input->post('stock_status'));
            $insData['date'] = sys_date();
            $insData['time'] = sys_time();
            $insData['status'] = 1;
            if($activity_type == "add") {
                $query = $this->db->insert('product_color', $insData);
            } else {
                $color_id = validate($this->input->post('color_id'));
                $this->db->where('id', $color_id);
                $query = $this->db->update('product_color', $insData);
            }
            if($query) {
                if($activity_type == "add") {
                    $unit_and_price_id = $this->db->insert_id();
                    $message = 'Color Successfully Added';
                } else {
                    $unit_and_price_id = validate($this->input->post('color_id'));
                    $message = 'Unit And Prices Successfully Updated';
                }
                $data['status'] = true;
                $data['rcode'] = 200;
                $data['message'] = $message;
                $data['size_id'] = (int)$unit_and_price_id;
            } else {
                $data['status'] = false;
                $data['rcode'] = 500;
                $data['message'] = 'Something Went Wrong';
            }
        } else {
            $data['status'] = false;
            $data['rcode'] = 500;
            $data['message'] = $message;
        }
        echo json_encode($data);
    }

    function setSpecification() {
        $isValidated = true;
        $isValidatedProduct = true;
        $isValidatedKey = true;

        $product_id = $this->input->post('product_id');
        $key = $this->input->post('key');
        $value = $this->input->post('value');
        if($this->input->post('product_id') == "") {
            $isValidated = false;
            $isValidatedProduct = false;
            $message = "Product ID Is Required";
        }
        if($this->input->post('key') == "") {
            $isValidated = false;
            $isValidatedKey = false;
            $message = "Key Is Required";
        }
        if($this->input->post('value') == "") {
            $isValidated = false;
            $message = "Value Is Required";
        }
        if($isValidatedProduct == true) {
            $checkProduct = getAllDataByVal('product', array('id' => $product_id));
            if($checkProduct->num_rows() <= 0) {
                $isValidated = false;
                $message = 'Wrong Product';
            }
        }
        if($isValidatedKey == true) {
            $checkKey = getAllDataByVal('form_fields', array('id' => $key));
            if($checkKey->num_rows() <= 0) {
                $isValidated = false;
                $message = 'Wrong Key';
            }
        }
        if($isValidated == true) {
            $checkSpecification = getAllDataByVal('product_specification', array('specification_key' => $key, 'product_id' => $product_id));
            if($checkSpecification->num_rows() > 0) {
                $insData['specification_value'] = $value;
                $this->db->where('specification_key', $key);
                $this->db->where('product_id', $product_id);
                $this->db->update('product_specification', $insData);
            } else {
                $insData['specification_value'] = $value;
                $insData['specification_key'] = $key;
                $insData['product_id'] = $product_id;
                $this->db->insert('product_specification', $insData);
            }
            $res['status'] = true;
            $res['rcode'] = 200;
            $res['message'] = "Updated";
        } else {
            $res['status'] = false;
            $res['rcode'] = 500;
            $res['message'] = $message;
        }
        echo json_encode($res);
    }

    public function updateProduct($product_id_encoded) {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $product_id = id_decode($product_id_encoded);
        $productData = getAllDataByVal('product', array('id' => $product_id));
        $productImagesData = getAllDataByVal('product_images', array('product_id' => $product_id));
        if($productData->num_rows() > 0) {
            $data['permission'] = $this->getPermission('product');
            $data['shopTypeData'] = getAllDataByVal('shop_type', array('status' => 1));
            $data['categoryData'] = getAllDataByVal('category', array('status' => 1));
            $data['subCategoryData'] = getAllDataByVal('sub_category', array('status' => 1));
            $data['productObj'] = $productData->row();
            $data['productImagesData'] = $productImagesData;
            $this->load->view('admin/update-product', $data);
        } else {
            redirect(base_url().'admin-view-product', 'Auto');
        }
    }

    public function productList() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('product', array('addButton' => 'no'));
        $data['shopTypeData'] = getAllDataByVal('shop_type', array('status' => 1));
        $data['categoryData'] = getAllDataByVal('category', array('status' => 1));
        $data['subCategoryData'] = getAllDataByVal('sub_category', array('status' => 1));
        $this->load->view('admin/product-list', $data);
    }

    public function addProductToCategory() {
        $this->checkLogin();
        $table_name = "product";
        $category_id = $this->input->post('category_id');
        $sub_category_id = $this->input->post('sub_category_id');
        $id = $this->input->post('checkbox_value');
        for($i = 0; $i < count($id); $i++) {
            $data = array(
                'sub_category' => $sub_category_id,
                'category' => $category_id,
            );
            $this->loginModel->updateData('id', $id[$i], $table_name, $data);
        }
    }

    public function disableProductData() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $column = $this->input->post('column');
        $updateArr[$column] = 0;
        $this->db->where('id', $id);
        $this->db->update($table, $updateArr);
    }

    public function vendorList() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('vendor', array('addButton' => 'no'));
        $data['shopTypeData'] = getAllDataByVal('shop_type', array('status' => 1));
        $this->load->view('admin/vendor-list', $data);
    }

    public function pendingVendor() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('vendor', array('addButton' => 'no', 'disableButton' => 'no', 'enableButton' => 'no', 'deletButton' => 'no'));
        $data['shopTypeData'] = getAllDataByVal('shop_type', array('status' => 1));
        $this->load->view('admin/pending-vendor', $data);
    }

    function vendorProductList() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        if($this->input->get('vendor_id') != "") {
            $vendor_id = id_decode($this->input->get('vendor_id'));
            $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
            $this->load->view('admin/header', $data);
            $data['permission'] = $this->getPermission('vendor', array('addButton' => 'no', 'disableButton' => 'no', 'enableButton' => 'no', 'deletButton' => 'no'));
            $data['vendorObj'] = getAllDataByVal('user', array('id' => $vendor_id))->row();
            $data['vendor_id'] = $vendor_id;
            $data['shopTypeData'] = getAllDataByVal('shop_type', array('status' => 1));
            $data['categoryData'] = getAllDataByVal('category', array('status' => 1));
            $data['subCategoryData'] = getAllDataByVal('sub_category', array('status' => 1));
            $this->load->view('admin/vendor-product-list', $data);
        } else {
            redirect(base_url().'admin-vendor-list', 'auto');
        }
    }

    function vendorUserList() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('vendor', array('addButton' => 'no', 'disableButton' => 'no', 'enableButton' => 'no', 'deletButton' => 'no'));
        $this->load->view('admin/vendor-user-list', $data);
    }

    function vendorOrdersList() {

        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        if($this->input->get('vendor_id') != "") {
            $vendor_id = id_decode($this->input->get('vendor_id'));
            $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
            $this->load->view('admin/header', $data);
            $data['permission'] = $this->getPermission('vendor', array('addButton' => 'no', 'disableButton' => 'no', 'enableButton' => 'no', 'deletButton' => 'no'));
            $data['vendorObj'] = getAllDataByVal('user', array('id' => $vendor_id))->row();
            $data['vendor_id'] = $vendor_id;
            $data['vendorUserList'] = $this->loginModel->getVendorUserList($vendor_id);
            $this->load->view('admin/vendor-orders-list', $data);
        } else {
            redirect(base_url().'admin-vendor-list', 'auto');
        }
    }

    function vendorOrdersView() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        if($this->input->get('vendor_id') != "" && $this->input->get('order_id') != "") {
            $vendor_id = id_decode($this->input->get('vendor_id'));
            $order_id = id_decode($this->input->get('order_id'));
            $sub_domain = 'grobig_'.getDataByVal('cred_unique_code', 'user', array('id' => $vendor_id));
            $unique_token = getDataByVal('unique_token', 'user', array('id' => $vendor_id));
            $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
            $this->load->view('admin/header', $data);
            $data['permission'] = $this->getPermission('vendor', array('addButton' => 'no', 'disableButton' => 'no', 'enableButton' => 'no', 'deletButton' => 'no'));
            $data['vendorObj'] = getAllDataByVal('user', array('id' => $vendor_id))->row();
            $data['vendor_id'] = $vendor_id;

            $orderDetails = json_decode($this->loginModel->getDataByCurl(base_url().'vendorApi/getOrderDetail', array('user_id' => id_encode($vendor_id), 'order_id' => $order_id), array('Auth:'.$unique_token)), true);

            $data['vendorOrderDetails'] = $orderDetails['data'];
            $this->load->view('admin/vendor-orders-view', $data);
        } else {
            redirect(base_url().'admin-vendor-list', 'auto');
        }
    }

    function addAgent() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $vendor_id = id_decode($this->input->get('vendor_id'));
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('agent', array());
        $this->load->view('admin/add-agent', $data);
    }

    function agentList() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $vendor_id = id_decode($this->input->get('vendor_id'));
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('agent', array('addButton' => 'no'));
        $this->load->view('admin/agent-list', $data);
    }

    function agentPackage() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $vendor_id = id_decode($this->input->get('vendor_id'));
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('agent_package', array());
        $this->load->view('admin/agent-package', $data);
    }


    public function addOffersPage() {
        $this->checkLogin();
        $offer_id = "";
        if($this->input->get('offer_id') != "")
            $offer_id = id_decode($this->input->get('offer_id'));
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('manage_offer', array());
        $data['categoryData'] = $this->loginModel->getData('category', 'id', 'DESC', 1);
        $data['subcategoryData'] = $this->loginModel->getData('sub_category', 'id', 'DESC', 1);
        $data['brandData'] = $this->loginModel->getData('brand', 'id', 'DESC', 1);
        $data['productData'] = $this->loginModel->getData('product', 'id', 'DESC', 1);
        $data['offer_id'] = $offer_id;
        $this->load->view('admin/manage-offer', $data);
    }

    public function insertOffers() {
        $offer_id = $message = "";
        $res = array();
        $isValidated = true;
        if($this->input->post('offer_title') == "") {
            $isValidated = false;
            $message = "Offer Title Is Required";
        }
        if($this->input->post('start_date') == "") {
            $isValidated = false;
            $message = "Start Date Is Required";
        }
        if($this->input->post('start_time') == "") {
            $isValidated = false;
            $message = "Start Time Is Required";
        }
        if($this->input->post('end_date') == "") {
            $isValidated = false;
            $message = "End Date Is Required";
        }
        if($this->input->post('end_time') == "") {
            $isValidated = false;
            $message = "End Time Is Required";
        }
        if($isValidated == true) {
            $dataOffer['offer_title'] = $this->input->post('offer_title');
            $dataOffer['start_date'] = $this->input->post('start_date');
            $dataOffer['start_time'] = $this->input->post('start_time');
            $dataOffer['end_date'] = $this->input->post('end_date');
            $dataOffer['end_time'] = $this->input->post('end_time');
            $dataOffer['offer_position'] = $this->input->post('offer_position');
            $dataOffer['date'] = sys_date();
            $dataOffer['time'] = sys_time();
            $dataOffer['ip'] = getRealIpAddr();
            $dataOffer['byid'] = $this->session->userdata('id');
            $dataOffer['status'] = 1;
            $this->db->insert('offers', $dataOffer);
            $offer_id = $this->db->insert_id();
            $message = "Offer SuccessFully Created";
        }
        $res['status'] = $isValidated;
        $res['message'] = $message;
        $res['offer_id'] = id_encode($offer_id);
        echo json_encode($res);
    }

    function deleteOffer() {
        $offer_id = $this->input->post('id');
        $this->db->where('id', $offer_id);
        $query = $this->db->delete('offers');

        $this->db->where('offer_id', $offer_id);
        $this->db->delete('offers_data');

        $this->db->where('offer_id', $offer_id);
        $this->db->delete('offers_images');

        if($query) {
            echo true;
        } else {
            echo false;
        }
    }

    public function offersList() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('manage_offer', array());
        $this->load->view('admin/list-offer', $data);
    }

    public function manageCoupon() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('manage_coupon', array());
        $this->load->view('admin/manage-coupon', $data);
    }

    public function insertCoupon() {
        $data = array();
        if($this->input->post('coupon_name') != "" && $this->input->post('coupon_code') != "" && $this->input->post('coupon_percent') != "" && $this->input->post('minimum_order_value') != "" && $this->input->post('maximum_coupon_value') != "" && $this->input->post('coupon_for') != "" && $this->input->post('coupon_start_date') != "" && $this->input->post('coupon_start_time') != "" && $this->input->post('coupon_end_date') != "" && $this->input->post('coupon_end_time') != "") {

            $coupon_start_date_time_str = $this->input->post('coupon_start_date')." ".$this->input->post('coupon_start_time');
            $coupon_end_date_time_str = $this->input->post('coupon_end_date')." ".$this->input->post('coupon_end_time');
            $coupon_start_date_time = date("Y-m-d H:i", strtotime($coupon_start_date_time_str));
            $coupon_end_date_time = date("Y-m-d H:i", strtotime($coupon_end_date_time_str));
            $current_date_time = date("Y-m-d H:i");
            if($current_date_time <= $coupon_start_date_time) {
                if($coupon_end_date_time > $coupon_start_date_time) {
                    $end_time = $this->input->post('coupon_start_time');
                    $start_time = $this->input->post('coupon_end_time');
                    $couponData['coupon_name'] = $this->input->post('coupon_name');
                    $couponData['coupon_code'] = $this->input->post('coupon_code');
                    $couponData['minimum_order_value'] = $this->input->post('minimum_order_value');
                    $couponData['maximum_coupon_value'] = $this->input->post('maximum_coupon_value');
                    $couponData['coupon_for'] = $this->input->post('coupon_for');
                    $couponData['coupon_percent'] = $this->input->post('coupon_percent');
                    $couponData['description'] = $this->input->post('description');
                    $couponData['coupon_start_date'] = date('Y-m-d', strtotime($this->input->post('coupon_start_date')));
                    $couponData['coupon_start_time'] = $this->input->post('coupon_start_time');
                    $couponData['coupon_end_date'] = date('Y-m-d', strtotime($this->input->post('coupon_end_date')));
                    $couponData['coupon_end_time'] = $this->input->post('coupon_end_time');
                    $couponData['status'] = 1;
                    $couponData['date'] = sys_date();
                    $couponData['time'] = sys_time();
                    $query = $this->db->insert('coupon', $couponData);
                    $coupon_id = $this->db->insert_id();
                    if($query) {
                        $files = $_FILES;
                        $count = count($_FILES['image']['name']);
                        for($i = 0; $i < $count; $i++) {
                            $_FILES['image']['name'] = $files['image']['name'][$i];
                            $_FILES['image']['type'] = $files['image']['type'][$i];
                            $_FILES['image']['tmp_name'] = $files['image']['tmp_name'][$i];
                            $_FILES['image']['error'] = $files['image']['error'][$i];
                            $_FILES['image']['size'] = $files['image']['size'][$i];

                            $config['upload_path'] = './image/coupon/';
                            $config['allowed_types'] = 'jpg|png|jpeg|webp';
                            $config['max_size'] = 2000;
                            $config['remove_spaces'] = true;
                            $this->load->library('upload', $config);

                            if(!$this->upload->do_upload('image')) {
                                $error = $this->upload->display_errors();
                                $res = $error;
                            } else {
                                $uploadedImage = $this->upload->data();
                                $image_name = $uploadedImage['file_name'];

                                $data['coupon_id'] = $coupon_id;
                                $data['image'] = $image_name;
                                $data['date'] = sys_date();
                                $data['time'] = sys_time();
                                $data['ip'] = getRealIpAddr();
                                $data['byid'] = $this->session->userdata('id');
                                $data['status'] = 1;
                                $query = $this->db->insert('coupon_images', $data);
                                $res = $query;
                            }
                        }
                        $data['status'] = true;
                        $data['rcode'] = 200;
                        $data['message'] = "Data Successfully Inserted";
                    } else {
                        $data['status'] = false;
                        $data['rcode'] = 201;
                        $data['message'] = "Something Went Wrong";
                    }
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 202;
                    $data['message'] = "End date Cannot be less then start date";
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 202;
                $data['message'] = "Start date cannot be less then current date";
            }
        } else {
            $data['status'] = false;
            $data['rcode'] = 202;
            $data['message'] = "Required Fields Cannot Be Left Empty";
        }

        echo json_encode($data);
    }

    public function getCoupon() {
        $data = "";
        $this->load->model('loginModel');
        $whereArrCoupon = array('status' => 1);
        $couponQry = $this->loginModel->getAllDataByVal('coupon', $whereArrCoupon);

        if($couponQry->num_rows() > 0) {
            $i = 1;
            foreach($couponQry->result() as $couponRow) {
                if($couponRow->coupon_end_date < sys_date()) {
                    $rowClass = "style='background:#ffbfbf;'";
                    $statusClass = "<span class='label label-danger'>Expired</span>";
                } else {
                    $rowClass = "";
                    $statusClass = "<span class='label label-success'>Active</span>";
                }

                $data .= '
                        <tr '.$rowClass.'>
                            <td>'.$i.'</td>
                            <td>'.$couponRow->coupon_name.'</td>
                            <td>
                                Coupon Code : '.$couponRow->coupon_code.'<br>
                                Coupon For : '.$couponRow->coupon_for.'<br>
                                Coupon Value In : '.$couponRow->coupon_in.'<br>
                                Minimum Order Value To Readeem : '.$couponRow->minimum_order_value.'<br>
                                Maximum Reward Value : '.$couponRow->maximum_coupon_value.'<br>
                            </td>
                            <td>'.date_conversion($couponRow->coupon_start_date).' - '.time_conversion($couponRow->coupon_start_time).'</td>
                            <td>'.date_conversion($couponRow->coupon_end_date).' - '.time_conversion($couponRow->coupon_end_time).'</td>
                            <td>';
                $whereArrImage = array('coupon_id' => $couponRow->id);
                $couponImageArr = $this->loginModel->getAllDataByVal('coupon_images', $whereArrImage);
                foreach($couponImageArr->result() as $couponImageObj) {
                    $data .= '<center><img src="'.base_url().'image/coupon/'.$couponImageObj->image.'" class="img img-responsive img-thumbnail" style="max-width:100px;"><br><button type="button" id="deleteImageCoupon" data-id="'.$couponImageObj->id.'" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button></center><br>';
                }
                $data .= '</td>
                            <td>'.$statusClass.'</td>
                            <td>
                                <button type="button" id="updateCoupon" data-id="'.$couponRow->id.'" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></button>
                                <button type="button" onclick="deleteCoupon(\''.$couponRow->id.'\')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>';
                $i++;
            }
        }
        echo $data;
    }

    function deleteCoupon() {
        $coupon_id = $this->input->post('id');
        $this->db->where('id', $coupon_id);
        $query = $this->db->update('coupon', array('status' => 0));

        if($query) {
            echo true;
        } else {
            echo false;
        }
    }

    public function banners() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('manage_offer', array());
        $data['categoryData'] = $this->loginModel->getData('category', 'id', 'DESC', 1);
        $data['subcategoryData'] = $this->loginModel->getData('sub_category', 'id', 'DESC', 1);
        $data['brandData'] = $this->loginModel->getData('brand', 'id', 'DESC', 1);
        $this->load->view('admin/manage-banners', $data);
    }

    function insertBanner() {
        $message = "";
        $res = array();
        $isValidated = true;
        if($this->input->post('banner_for') == "") {
            $isValidated = false;
            $message = "Please Select Type";
        }
        if($this->input->post('position') == "") {
            if($this->input->post('frequency') == "") {
                $isValidated = false;
                $message = "Please Select Position Or Frequency";
            }
        }
        if(count($_FILES['image']) <= 0) {
            $isValidated = false;
            $message = "Please Add Atleast One Banner";
        }
        if($isValidated == true) {
            $files = $_FILES;
            $count = count($_FILES['image']['name']);
            for($i = 0; $i < $count; $i++) {
                $_FILES['image']['name'] = $files['image']['name'][$i];
                $_FILES['image']['type'] = $files['image']['type'][$i];
                $_FILES['image']['tmp_name'] = $files['image']['tmp_name'][$i];
                $_FILES['image']['error'] = $files['image']['error'][$i];
                $_FILES['image']['size'] = $files['image']['size'][$i];

                $config['upload_path'] = './image/banner/';
                $config['allowed_types'] = 'jpg|png|jpeg|webp';
                $config['max_size'] = 2000;
                $config['remove_spaces'] = true;
                $this->load->library('upload', $config);

                if(!$this->upload->do_upload('image')) {
                    $error = $this->upload->display_errors();
                    $message = $error;
                } else {
                    $uploadedImage = $this->upload->data();
                    $image_name = $uploadedImage['file_name'];

                    $data['banner_type'] = $this->input->post('banner_type');
                    $data['banner_for'] = $this->input->post('banner_for');
                    if($this->input->post('position') != "") {
                        $data['position'] = $this->input->post('position');
                    }
                    if($this->input->post('frequency') != "") {
                        $data['frequency'] = $this->input->post('frequency');
                    }
                    if($this->input->post('category_id') != "") {
                        $data['category_id'] = $this->input->post('category_id');
                    }
                    if($this->input->post('brand_id') != "") {
                        $data['brand_id'] = $this->input->post('brand_id');
                    }
                    $data['image'] = $image_name;
                    $data['date'] = sys_date();
                    $data['time'] = sys_time();
                    $data['ip'] = getRealIpAddr();
                    $data['byid'] = $this->session->userdata('id');
                    $data['status'] = 1;
                    $query = $this->db->insert('banner', $data);
                    $message = 'Successfully Added';
                }
            }
        }
        $res['status'] = $isValidated;
        $res['message'] = $message;
        echo json_encode($res);
    }

    function getBanners() {
        $banner_type = $this->input->post('banner_type');
        $data['bannerData'] = getAllDataByVal('banner', array('banner_type' => $banner_type));
        $this->load->view('admin/ajax/banner-list', $data);
    }

    function deleteBanner() {
        $banner_id = $this->input->post('id');
        $image = getDataByVal('image', 'banner', array('id' => $banner_id));
        $image_url = './image/banner/'.$image;
        if(file_exists($image_url)) {
            unlink($image_url);
        }
        $this->db->where('id', $banner_id);
        $query = $this->db->delete('banner');

        if($query) {
            echo true;
        } else {
            echo false;
        }
    }

    function getCategoryByType() {
        $html = "<option value=''>-- Select Category --</option>";
        $type = $this->input->post('type');
        if($type != "") {
            if($type == 1)
                $this->db->where_not_in('shop_type', array(1));
            else
                $this->db->where_in('shop_type', array(1));
            $query = $this->db->get('category');
            if($query->num_rows() > 0) {
                foreach($query->result() as $row) {
                    $html .= '<option value="'.$row->id.'">'.$row->name.'</option>';
                }
            }
        }
        echo $html;
    }

    function changeProductStatus() {
        $id = $this->input->post('id');
        $column = $this->input->post('column');
        $status = $this->input->post('status');
        $this->db->where('id', $id);
        $this->db->update('product', array($column => $status));
    }

    public function vendorApproval() {
        $this->checkLogin();
        $id = $this->session->userdata('id');
        $this->load->model('loginModel');
        $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
        $this->load->view('admin/header', $data);
        $data['permission'] = $this->getPermission('vendor_approval_module');

        $this->load->view('admin/vendor-approval', $data);
    }

    function vendorDetails() {
        $this->checkLogin();
        if($this->input->get('vendor_id') != "" && $this->input->get('type') != "") {
            $vendor_id = id_decode($this->input->get('vendor_id'));
            $type = id_decode($this->input->get('type'));
            $check_vendor_id = getAllDataByVal('vendor', array('id' => $vendor_id));
            if($check_vendor_id->num_rows() > 0) {
                $id = $this->session->userdata('id');
                $this->load->model('loginModel');
                $data['mainQuery'] = $this->loginModel->getAllData('staff', 'id', $id, '1');
                $this->load->view('admin/header', $data);
                $data['permission'] = $this->getPermission('vendor_approval_module');
                $data['vendorDetailsArr'] = getAllDataByVal('vendor', array('id' => $vendor_id))->row_array();
                $data['type'] = $type;
                $data['vendor_id_encoded'] = $this->input->get('vendor_id');
                $this->load->view('admin/vendor-view', $data);
            } else {
                redirect(base_url().'admin-vendor-approval', 'auto');
            }
        } else {
            redirect(base_url().'admin-vendor-approval', 'auto');
        }
    }

    function approveVendor() {
        $res = array();
        $this->checkLogin();
        $column = $this->input->post('column');
        if($column != '') {
            $vendor_id = id_decode($this->input->post('vendor_id'));
            $check_vendor_id = getAllDataByVal('vendor', array('id' => $vendor_id));
            if($check_vendor_id->num_rows() > 0) {
                $this->db->where('id', $vendor_id);
                $query = $this->db->update('vendor', array($column => 1));
                if($query) {
                    $basic_details_verification = getDataByVal('basic_details_verification', 'vendor', array('id' => $vendor_id));
                    $address_details_verification = getDataByVal('address_details_verification', 'vendor', array('id' => $vendor_id));
                    $aadhaar_front_verification = getDataByVal('aadhaar_front_verification', 'vendor', array('id' => $vendor_id));
                    $aadhaar_back_verification = getDataByVal('aadhaar_back_verification', 'vendor', array('id' => $vendor_id));
                    $pan_verification = getDataByVal('pan_verification', 'vendor', array('id' => $vendor_id));
                    if($basic_details_verification == 1 && $address_details_verification == 1 && $aadhaar_front_verification == 1 && $aadhaar_back_verification == 1 && $pan_verification == 1) {
                        $finalUpData['verification_status'] = 1;
                        $finalUpData['status'] = 1;
                        $finalUpData['verification_date'] = sys_date();
                        $this->db->where('id', $vendor_id);
                        $this->db->update('vendor', $finalUpData);
                    }
                    $res['status'] = true;
                    $res['message'] = "Approved";
                    $res['rcode'] = 200;
                } else {
                    $res['status'] = false;
                    $res['message'] = "Something went wrong !!!";
                    $res['rcode'] = 500;
                }
            } else {
                $res['status'] = false;
                $res['message'] = "Wrong data !!!";
                $res['rcode'] = 500;
            }
        } else {
            $res['status'] = false;
            $res['message'] = "Wrong data !!!";
            $res['rcode'] = 500;
        }
        echo json_encode($res);
    }

    function rejectVendor() {
        $res = array();
        $this->checkLogin();
        $column = $this->input->post('column');
        if($column != '') {
            $vendor_id = id_decode($this->input->post('vendor_id'));
            $verification_message = $this->input->post('verification_message');
            $check_vendor_id = getAllDataByVal('vendor', array('id' => $vendor_id));
            if($check_vendor_id->num_rows() > 0) {
                $this->db->where('id', $vendor_id);
                $query = $this->db->update('vendor', array($column => 2));
                if($query) {
                    $finalUpData['verification_status'] = 0;
                    $finalUpData['verification_message'] = $verification_message;
                    $finalUpData['status'] = 0;
                    $finalUpData['verification_date'] = sys_date();
                    $this->db->where('id', $vendor_id);
                    $this->db->update('vendor', $finalUpData);
                    $res['status'] = true;
                    $res['message'] = "Approved";
                    $res['rcode'] = 200;
                } else {
                    $res['status'] = false;
                    $res['message'] = "Something went wrong !!!";
                    $res['rcode'] = 500;
                }
            } else {
                $res['status'] = false;
                $res['message'] = "Wrong data !!!";
                $res['rcode'] = 500;
            }
        } else {
            $res['status'] = false;
            $res['message'] = "Wrong data !!!";
            $res['rcode'] = 500;
        }
        echo json_encode($res);
    }
    // * Vendor Approval Functions *
}