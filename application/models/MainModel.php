<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class MainModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->db2 = $this->load->database('main', TRUE);
    }


    function getDataByField($getColumn, $table, $whereColumn, $whereValue, $statusType)
    {
        $this->db2->where('status', $statusType);
        $this->db2->where($whereColumn, $whereValue);
        $query = $this->db2->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                return $row->$getColumn;
            }
        } else {
            return false;
        }
    }

    function getAllData($table, $whereColumn, $whereValue, $statusType)
    {
        $this->db2->where('status', $statusType);
        $this->db2->where($whereColumn, $whereValue);
        $query = $this->db2->get($table);
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return $query;
        }
    }

    function getData($table, $orderColumn, $type, $statusType)
    {
        $this->db2->where('status', $statusType);
        $this->db2->order_by($orderColumn, $type);
        $query = $this->db2->get($table);
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return $query;
        }
    }

    function insertData($table_name, $data)
    {
        $this->db2->insert($table_name, $data);
        $afftectedRows = $this->db2->affected_rows();
        if ($afftectedRows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function insertDataReturnId($table_name, $data)
    {
        $this->db2->insert($table_name, $data);
        $id = $this->db2->insert_id();
        if ($id > 0) {
            return $id;
        } else {
            return FALSE;
        }
    }

    function updateData($whereColumn, $id, $table_name, $data)
    {
        $this->db2->where($whereColumn, $id);
        $this->db2->update($table_name, $data);
        $afftectedRows = $this->db2->affected_rows();
        if ($afftectedRows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteData($whereColumn, $id, $table_name)
    {
        $this->db2->where($whereColumn, $id);
        $this->db2->delete($table_name);
        $afftectedRows = $this->db2->affected_rows();
        if ($afftectedRows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function searchData($table_name, $data)
    {
        foreach ($data as $row => $value) {
            if ($row != "" && $value != "") {
                if ($row == "start_date") {
                    $this->db2->where('date >=', $value);
                } elseif ($row == "end_date") {
                    $this->db2->where('date <=', $value);
                } else {
                    $this->db2->where($row, $value);
                }
            }
        }
        $query = $this->db2->get($table_name);
        return $query;
    }

    function getAllDataWithoutStatus($table, $whereColumn, $whereValue)
    {
        $this->db2->where($whereColumn, $whereValue);
        $query = $this->db2->get($table);
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return $query;
        }
    }

    function getDataByVal($getColumn, $tableName, $whereArray)
    {
        foreach ($whereArray as $key => $value) {
            $this->db2->where($key, $value);
        }
        $query = $this->db2->get($tableName);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $getval) {
                $retValue = $getval->$getColumn;
            }
        } else {
            $retValue = "";
        }
        return $retValue;
    }

    function getAllDataByVal($tableName, $whereArray)
    {
        foreach ($whereArray as $key => $value) {
            if ($key == "limit") {
                $this->db2->limit($value);
            } elseif ($key == "name") {
                $this->db2->like('name', $value);
            } elseif ($key == "full_name") {
                $this->db2->like('full_name', $value);
            } elseif ($key == "order_by_desc") {
                $this->db2->order_by($value, "DESC");
            } elseif ($key == "order_by_asc") {
                $this->db2->order_by($value, "ASC");
            } elseif ($key == "start_date_order") {
                $this->db2->where('order_date >=', $value);
            } elseif ($key == "end_date_order") {
                $this->db2->where('order_date <=', $value);
            } elseif ($key == "not_in_order_status") {
                $this->db2->where_not_in('order_status', $value);
            } elseif ($key == "in_order_status") {
                $this->db2->where_in('order_status', $value);
            } elseif ($key == "not_in_shop_type") {
                $this->db2->where_not_in('shop_type', $value);
            } elseif ($key == "in_shop_type") {
                $this->db2->where_in('shop_type', $value);
            } else {
                $this->db2->where($key, $value);
            }
        }
        $query = $this->db2->get($tableName);
        return $query;
    }

    function getDataWithoutWhere($tableName)
    {
        $query = $this->db2->get($tableName);
        return $query;
    }

    function calculateDiscount($unit_mrp, $unit_sales_price)
    {
        $unit_mrp_sales_minus = $unit_mrp - $unit_sales_price;
        $unit_mrp_sales_divide = $unit_mrp_sales_minus / $unit_mrp;
        $discount = $unit_mrp_sales_divide * 100;
        return round($discount);
    }

    function calculateDiscountPrice($unit_mrp, $unit_sales_price)
    {
        $discount_price = $unit_mrp - $unit_sales_price;
        return round($discount_price);
    }

    function calculateRate($sales_price, $gst_percent, $gst_type)
    {
        $rate = 0;
        if ($gst_type == "included") {
            $multiply = $sales_price * 100;
            $multiply_gst = 100 + $gst_percent;
            $rate = $multiply / $multiply_gst;
        } else {
            $rate = $sales_price;
        }
        return round($rate, 2);
    }

    function calculateGstPrice($sales_price, $gst_percent, $gst_type)
    {
        $gst_price = 0;
        if ($gst_type == "included") {
            $multiply = $sales_price * 100;
            $multiply_gst = 100 + $gst_percent;
            $rate = $multiply / $multiply_gst;
            $gst_price = $sales_price - $rate;
        } else {
            $multiply = $sales_price * $gst_percent;
            $gst_price = $multiply / 100;
        }
        return round($gst_price, 2);
    }

    function getProductPrice($qty, $product_id, $unit_id, $unit_value, $gst_percent, $gst_type)
    {
        $productData = getAllDataByVal('product', array('id' => $product_id));
        if ($productData->num_rows() > 0) {
            $productObj = $productData->row();
            if ((int) $productObj->status == 1) {
                $this->db2->where('product_id', $product_id);
                $this->db2->where('id', $unit_id);
                $this->db2->where('unit_value', $unit_value);
                $queryUnit = $this->db2->get('product_unit_stock_price');
                foreach ($queryUnit->result() as $rowUnit) {
                    $sales_price = $rowUnit->unit_sales_price;
                    $mrp = $rowUnit->unit_mrp;
                    $discount = $this->calculateDiscountPrice($mrp, $sales_price);
                    $rate = $this->calculateRate($sales_price, $gst_percent, $gst_type);
                    $gst_price = $this->calculateGstPrice($sales_price, $gst_percent, $gst_type);

                    if ($gst_type == "included") {
                        $amount = $sales_price;
                    } else {
                        $amount = $sales_price + $gst_price;
                    }

                    $single_total = $amount * $qty;
                    $single_discount = $discount * $qty;
                    $single_rate = $rate * $qty;
                    $single_gst_price = $gst_price * $qty;
                    $single_mrp = $mrp * $qty;
                }
                $arr = array($single_total, $single_discount, $single_rate, $single_gst_price, $amount, $rate, $single_mrp);
            } else {
                $arr = array();
            }
        } else {
            $arr = array();
        }
        return $arr;
    }

    function generateOrderNumber()
    {
        $date = sys_date();
        $year = date("Y", strtotime(sys_date()));
        $month = date("m", strtotime(sys_date()));
        $qry = "SELECT MAX(sno) AS sno FROM `order_overview` WHERE YEAR(`order_date`)='$year' AND MONTH(`order_date`)='$month';";
        $result = $this->db2->query($qry);
        if ($result->num_rows() <= 0) {
            $sno = 1;
            $year = date("y", strtotime($date));
            $order_no = $year . $month . $sno;
            $value = array($order_no, $sno);
            return ($value);
        } else {
            foreach ($result->result() as $row) {
            }
            $sno = $row->sno;
            $sno += 1;
            $year = date("y", strtotime($date));
            $order_no = $year . $month . $sno;
            $value = array($order_no, $sno);
            return ($value);
        }
    }

    function getNewOrders($start_date, $end_date)
    {
        if ($start_date != "" && $end_date != "") {
            $this->db2->where('order_date >=', $start_date);
            $this->db2->where('order_date <=', $end_date);
        }
        $query = $this->db2->get('order_overview');
        return $query->num_rows();
    }

    function getPendingOrders($start_date, $end_date)
    {
        if ($start_date != "" && $end_date != "") {
            $this->db2->where('order_date >=', $start_date);
            $this->db2->where('order_date <=', $end_date);
        }
        $this->db2->where('status', 0);
        $query = $this->db2->get('order_overview');
        return $query->num_rows();
    }

    function getCompletedOrders($start_date, $end_date)
    {
        if ($start_date != "" && $end_date != "") {
            $this->db2->where('order_date >=', $start_date);
            $this->db2->where('order_date <=', $end_date);
        }
        $this->db2->where('status', 4);
        $query = $this->db2->get('order_overview');
        return $query->num_rows();
    }

    function getDeliveries($start_date, $end_date)
    {
        if ($start_date != "" && $end_date != "") {
            $this->db2->where('delivery_date >=', $start_date);
            $this->db2->where('delivery_date <=', $end_date);
        }
        $query = $this->db2->get('order_overview');
        return $query->num_rows();
    }

    function getOrders($start_date, $end_date)
    {
        if ($start_date != "" && $end_date != "") {
            $this->db2->where('order_date >=', $start_date);
            $this->db2->where('order_date <=', $end_date);
        }
        $this->db2->limit(5);
        $this->db2->order_by('id', 'DESC');
        $query = $this->db2->get('order_overview');
        return $query;
    }
    function getAllDeliveries($start_date, $end_date)
    {
        if ($start_date != "" && $end_date != "") {
            $this->db2->where('delivery_date >=', $start_date);
            $this->db2->where('delivery_date <=', $end_date);
        }
        $this->db2->limit(5);
        $this->db2->order_by('id', 'DESC');
        $query = $this->db2->get('order_overview');
        return $query;
    }

    function checkVendorSubscription($vendor_id)
    {
        //$cur_date = date('Y-m-d');
        // $sql = "SELECT * FROM `sellers_subscription` WHERE `user_id`='$vendor_id' AND `subscription_start_date`<='$cur_date' AND `subscription_end_date`>='$cur_date'";
        // $query = $this->db2->query($sql);
        // if ($query->num_rows() > 0) {
        return true;
        // } else {
        //     return false;
        // }
    }
}