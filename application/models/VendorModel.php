<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class VendorModel extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function canLogin($username, $password)
	{
		$this->db->where('email', $username);
		$this->db->where('password', $password);
		$query = $this->db->get('staff');
		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return false;
		}
	}


	function getDataByField($getColumn, $table, $whereColumn, $whereValue, $statusType)
	{
		$this->db->where('status', $statusType);
		$this->db->where($whereColumn, $whereValue);
		$query = $this->db->get($table);
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
		$this->db->where('status', $statusType);
		$this->db->where($whereColumn, $whereValue);
		$query = $this->db->get($table);
		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return $query;
		}
	}

	function getData($table, $orderColumn, $type, $statusType)
	{
		$this->db->where('status', $statusType);
		$this->db->order_by($orderColumn, $type);
		$query = $this->db->get($table);
		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return $query;
		}
	}

	function updateData($whereColumn, $id, $table_name, $data)
	{
		$this->db->where($whereColumn, $id);
		$this->db->update($table_name, $data);
		$afftectedRows = $this->db->affected_rows();
		if ($afftectedRows > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function deleteData($whereColumn, $id, $table_name)
	{
		$this->db->where($whereColumn, $id);
		$this->db->delete($table_name);
		$afftectedRows = $this->db->affected_rows();
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
					$this->db->where('date >=', $value);
				} elseif ($row == "end_date") {
					$this->db->where('date <=', $value);
				} else {
					$this->db->where($row, $value);
				}
			}
		}
		$query = $this->db->get($table_name);
		return $query;
	}

	function getAllDataWithoutStatus($table, $whereColumn, $whereValue)
	{
		$this->db->where($whereColumn, $whereValue);
		$query = $this->db->get($table);
		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return $query;
		}
	}

	function getDataByVal($getColumn, $tableName, $whereArray)
	{
		foreach ($whereArray as $key => $value) {
			$this->db->where($key, $value);
		}
		$query = $this->db->get($tableName);
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
			$this->db->where($key, $value);
		}
		$query = $this->db->get($tableName);
		return $query;
	}

	function getDataWithoutWhere($tableName)
	{
		$query = $this->db->get($tableName);
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

	function getProductPrice($qty, $product_id, $unit_id, $unit_value, $gst_percent, $gst_type, $product_type = 1)
	{
		$productData = getAllDataByVal('product', array('id' => $product_id));
		if ($productData->num_rows() > 0) {
			$productObj = $productData->row();
			$single_total = 0;
			$single_discount = 0;
			$single_rate = 0;
			$single_gst_price = 0;
			$single_mrp = 0;
			$amount = 0;
			$rate = 0;
			if ((int) $productObj->status == 1) {
				$shop_type_id = $productObj->shop_type;
				$shop_type_name = getDataByVal('name', 'shop_type', array('id' => $shop_type_id));
				$shopTypeNameArr = explode(' ', $shop_type_name);

				$this->db->where('product_id', $product_id);
				$this->db->where('id', $unit_id);
				if ($product_type == 2) {
					$queryUnit = $this->db->get('product_ram_rom_price');
				} else {
					$queryUnit = $this->db->get('product_unit_stock_price');
				}

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
		$result = $this->db->query($qry);
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
			$this->db->where('order_date >=', $start_date);
			$this->db->where('order_date <=', $end_date);
		}
		$query = $this->db->get('order_overview');
		return $query->num_rows();
	}

	function getPendingOrders($start_date, $end_date)
	{
		if ($start_date != "" && $end_date != "") {
			$this->db->where('order_date >=', $start_date);
			$this->db->where('order_date <=', $end_date);
		}
		$this->db->where('status', 0);
		$query = $this->db->get('order_overview');
		return $query->num_rows();
	}

	function getCompletedOrders($start_date, $end_date)
	{
		if ($start_date != "" && $end_date != "") {
			$this->db->where('order_date >=', $start_date);
			$this->db->where('order_date <=', $end_date);
		}
		$this->db->where('status', 4);
		$query = $this->db->get('order_overview');
		return $query->num_rows();
	}

	function getDeliveries($start_date, $end_date)
	{
		if ($start_date != "" && $end_date != "") {
			$this->db->where('delivery_date >=', $start_date);
			$this->db->where('delivery_date <=', $end_date);
		}
		$query = $this->db->get('order_overview');
		return $query->num_rows();
	}

	function getOrders($start_date, $end_date)
	{
		if ($start_date != "" && $end_date != "") {
			$this->db->where('order_date >=', $start_date);
			$this->db->where('order_date <=', $end_date);
		}
		$this->db->limit(5);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('order_overview');
		return $query;
	}
	function getAllDeliveries($start_date, $end_date)
	{
		if ($start_date != "" && $end_date != "") {
			$this->db->where('delivery_date >=', $start_date);
			$this->db->where('delivery_date <=', $end_date);
		}
		$this->db->limit(5);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('order_overview');
		return $query;
	}
}