<?php
$company_name = $this->session->userdata('company_name');
$userType = $this->session->userdata('type');
foreach ($mainQuery->result() as $mainRow) {
    $byId = $mainRow->id;
    $nameUser = $mainRow->name;
    $emailUser = $mainRow->email;
    $imageUser = $mainRow->image;
}
