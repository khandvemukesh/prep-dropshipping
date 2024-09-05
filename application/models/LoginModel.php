<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class LoginModel extends CI_Model
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

	function canLoginRestaurant($username, $password)
	{
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$this->db->where('status', 1);
		$query = $this->db->get('restaurant');
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

	function getDataByField1($getColumn, $table, $whereColumn, $whereValue)
	{
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

	function getDataLimit($table, $orderColumn, $type, $statusType, $start_point, $limit)
	{
		$this->db->where('status', $statusType);
		$this->db->order_by($orderColumn, $type);
		$this->db->limit($limit, $start_point);
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
		if (count($data) > 0) {
			foreach ($data as $key => $value) {
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
		//$this->db->limit(200);
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
		foreach ($query->result() as $getval) {
		}
		$retValue = $getval->$getColumn;
		return $retValue;
	}

	function getAllDataLike($tableName, $whereArray)
	{
		foreach ($whereArray as $key => $value) {
			$this->db->like($key, $value);
		}
		$query = $this->db->get($tableName);
		return $query;
	}

	function getAllDataByVal($tableName, $whereArray)
	{
		foreach ($whereArray as $key => $value) {

			if ($key == "limit") {
				$this->db->limit($value);
			} elseif ($key == "order_by_desc") {
				$this->db->order_by($value, "DESC");
			} elseif ($key == "order_by_asc") {
				$this->db->order_by($value, "ASC");
			} else {
				$this->db->where($key, $value);
			}
		}
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get($tableName);
		return $query;
	}

	function getAllDataByValMin($tableName, $whereArray, $colum)
	{
		$this->db->select("*, MIN(`" . $colum . "`) AS `" . $colum . "`");
		foreach ($whereArray as $key => $value) {

			if ($key == "limit") {
				$this->db->limit($value);
			} else {
				$this->db->where($key, $value);
			}
		}
		$query = $this->db->get($tableName);
		return $query;
	}

	function getDataWithoutWhere($tableName)
	{
		$query = $this->db->get($tableName);
		return $query;
	}

	function searchHotelData($search_data, $search, $lat, $lng)
	{
		if ($lat != "" && $lng != "") {
			$sql = "SELECT *,(3959 * acos(cos(radians($lat)) * cos(radians(lat)) * cos( radians(lng) - radians($lng)) + sin(radians($lat)) * sin(radians(lat)))) AS `distance` FROM `hotel` HAVING `distance` < 15 ORDER BY `distance`";
		} else {
			$sql = "SELECT * FROM `hotel` WHERE (`address` LIKE '%$search_data%' OR `property_name` LIKE '%$search_data%' OR `display_name` LIKE '%$search_data%') OR (`property_name` LIKE '%$search%' OR `display_name` LIKE '%$search%')";
		}
		$query = $this->db->query($sql);
		return $query;
	}

	function noOfOrderForRestaurantByUser($user_id, $restaurant_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('restaurant_id', $restaurant_id);
		$query = $this->db->get('orders');
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return 0;
		}
	}

	public function sendEmail($message, $email, $subject, $attachment = "")
	{
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'mail.dayuse.in',
			'smtp_port' => 25,
			'smtp_user' => 'bookings@dayuse.in',
			'smtp_pass' => 'Dayuse@bookings2021',
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'wordwrap' => TRUE
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('bookings@dayuse.in');
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->attach($attachment);
		if ($this->email->send()) {
			return true;
		} else {
			show_error($this->email->print_debugger());
		}
	}

	public function sendPushNotification($msg, $fcm_token, $server_key)
	{
		$fields = array(
			'to' => $fcm_token,
			'data' => $msg
		);
		$headers = array(
			'Authorization: key=' . $server_key,
			'Content-Type: application/json'
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		curl_close($ch);
	}

	function getVendorUserList($vendor_id)
	{
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('users');
		return $query;
	}

	function getDataByCurl($url, $whereArray = array(), $headers = array())
	{
		$curl = curl_init();

		curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $whereArray,
				CURLOPT_HTTPHEADER => $headers,
			)
		);

		$response = curl_exec($curl);

		curl_close($curl);

		return $response;
	}
}