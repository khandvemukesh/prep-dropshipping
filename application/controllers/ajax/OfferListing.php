<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OfferListing extends CI_Controller
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

    function getOffer()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $id = $this->session->userdata('id');
        $updatePermission = getDataByVal('update_data', 'permission', array('employee_id' => $id, 'type' => 'manage_offer'));

        $searchData = array();
        foreach ($_POST as $key => $value) {
            $searchData[$key] = $value;
        }
        $query = $this->loginModel->searchData('offers', $searchData);

        $data = [];
        $sno = 1;
        foreach ($query->result() as $r) {
            $offer_id_encoded = id_encode($r->id);
            $offer_id = $r->id;
            $status = $r->status == 1 ? "<span class='badge badge-success'>Enable</span>" : "<span class='badge badge-danger'>Disabled</span>";
            $checkbox_class = $r->status == 1 ? "checkbox_delete" : "checkbox_active";
            $checbox = '<input type="checkbox" class="' . $checkbox_class . '" value="' . $r->id . '">';
            if ($updatePermission == "yes") {
                $updateButton = '
                <a href="' . base_url() . 'admin-create-offers?offer_id=' . $offer_id_encoded . '" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>';
            } else {
                $updateButton = '';
            }
            $image = '<img src="' . base_url() . 'image/offer/' . $r->image . '" class="img img-circle" style="width:50px;">';

            $data[] = array(
                $sno,
                $checbox,
                $status,
                $updateButton,
                $image,
                $r->offer_title,
                $r->offer_position,
                date_conversion($r->start_date) . ' - ' . time_conversion($r->start_time),
                date_conversion($r->end_date) . ' - ' . time_conversion($r->end_time),
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