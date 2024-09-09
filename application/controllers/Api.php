<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
class Api extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('vendorModel');
        $this->load->model('mainModel');
    }

    function checkUserId()
    {
        // $isValidated = true;
        // $vendor_id = "";
        // $server_key_user = "";
        // if ($this->input->post('vendor_id') != "") {
        //     if ($this->input->post('vendor_id') == '0') {
        //         $isValidated = true;
        //     } else {
        //         $vendor_id = id_decode($this->input->post('vendor_id'));
        //         $checkUser = $this->mainModel->getAllDataByVal('user', array('id' => $vendor_id));
        //         if ($checkUser->num_rows() == 0) $isValidated = false;
        //         else {
        //             $userObj = $checkUser->row();
        //             $server_key_user = $userObj->fcm_server_key;
        //         }
        //     }
        // } else {
        //     $isValidated = false;
        // }
        // if ($isValidated == true) {
        $data['status'] = true;
        $data['vendor_id'] = 1;
        $data['fcm_server_key'] = 'AAAAikVlbc8:APA91bFOb9d8zzN6FmjSkOzAMcr5jJ12-By0rZzEHazQhjdODLYCg-5LMiEDCR1o18Ogo8kYqWFsi8wjjlmh5YvikSDzjjS_cmtR8nYHPqKm7q5hrU35-N-eol-la1UGfDN7k4jlCo5H';
        return $data;
        // } else {
        //     $data['status'] = false;
        //     $data['rcode'] = 500;
        //     $data['message'] = "Not A Valid User";
        //     $data['fcm_server_key'] = $server_key_user;
        //     return $data;
        // }
    }

    function getVersion()
    {
        $update_type = 0;
        if ($this->input->post('version') != "") {
            $version = $this->input->post('version');
            $this->db->where('version >', $version);
            $versionData = $this->db->get('user_app_version');
            if ($versionData->num_rows() > 0) {
                $update_type = 1;
                foreach ($versionData->result() as $versionObj) {
                    if ((int) $versionObj->type == 2)
                        $update_type = 2;
                    elseif ((int) $versionObj->type == 3)
                        $update_type = 3;
                }
            }
        }
        return $update_type;
    }

    function checkTableField($value, $type, $coloum = '', $table = '')
    {
        if ($type == "required") {
            if ($value == "") {
                return false;
            } else {
                return $value;
            }
        } else {
            $this->db->where($coloum, $value);
            $check = $this->db->get($table);
            if ($check->num_rows() > 0) {
                return $value;
            } else {
                return false;
            }
        }
    }

    function notification($user_id, $data, $fcm_token)
    {
        $this->db->insert('notification', $data);

        if ($data['user_id'] == -1) {
            $server_key = $this->mainModel->getDataByVal('fcm_server_key', 'company_details', array());
        } else {
            $userRes = $this->checkUserId();
            $server_key = $userRes['fcm_server_key'];
        }

        $msgArr = array(
            'body' => $data['notification'],
            'title' => $data['title'],
        );

        $fields = array(
            'to' => $fcm_token,
            'data' => $msgArr
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

    function notificationTest($user_id)
    {
        //$this->db->insert('notification', $data);
        $server_key = 'AAAAikVlbc8:APA91bFOb9d8zzN6FmjSkOzAMcr5jJ12-By0rZzEHazQhjdODLYCg-5LMiEDCR1o18Ogo8kYqWFsi8wjjlmh5YvikSDzjjS_cmtR8nYHPqKm7q5hrU35-N-eol-la1UGfDN7k4jlCo5H';

        $msgArr = array(
            'body' => 'Test ' . date('H:i'),
            'title' => 'Hello Abhishek how are you doing. is your design ready. please submit it before 6:00PM. its urgent',
            //'image' => base_url() . 'image/banner/BAN-115.jpg',
            // 'badge' => 1,
        );

        $fields = array(
            'to' => 'exPqkW3RTvOhDC-h9fyA4n:APA91bGKA7CFxMH-rTUunj4dEp-Hxk3KSk6YAc98Mxg1yVGVBYBipa-DrY4ixJXHsf6TCtuTup7O5q4XkiosMwpnBqLU341wB1ed7tql8hxTJ4_2x8FfbW46eG-glVPSzYgwVNS2IYib',
            'data' => $msgArr
        );
        $headers = array(
            'Authorization: key=' . $server_key,
            'Content-Type: application/json'
        );

        echo json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        echo $result;
    }

    function sendMessage($user_id, $vendor_id, $type, $mobile, $message, $otp)
    {
        $message = urlencode($message);
        $url = 'http://tran.rocktwosms.com/api.php?username=advitotp1&password=379245&to=' . $mobile . '&from=WELCOM&message=' . $message . '&PEID=1201159183715504593&templateid=1507163457072741162';
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
                CURLOPT_CUSTOMREQUEST => 'GET',
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);
        $data['user_id'] = $user_id;
        $data['mobile_no'] = $mobile;
        $data['otp'] = $otp;
        $data['message'] = $message;
        $data['message_type'] = $type;
        $data['vendor_id'] = $vendor_id;
        $data['response'] = $response;
        $data['date'] = sys_date();
        $data['time'] = sys_time();
        $this->mainModel->insertData('sms_db', $data);
    }

    function sendWhatsAppMessage($user_id, $vendor_id, $type, $mobile, $message, $otp)
    {
        $message = urlencode($message);

        $dataArr['messaging_product'] = 'whatsapp';
        $dataArr['recipient_type'] = 'individual';
        $dataArr['to'] = $mobile;
        $dataArr['type'] = 'template';
        $dataArr['template']['name'] = 'grobig_new_vendors';
        $dataArr['template']['language']['code'] = 'en';
        $dataArr['template']['components'][0]['type'] = 'body';
        $dataArr['template']['components'][0]['parameters'][0]['type'] = 'text';
        $dataArr['template']['components'][0]['parameters'][0]['text'] = 'Hello';
        $dataArr['template']['components'][0]['parameters'][1]['type'] = 'text';
        $dataArr['template']['components'][0]['parameters'][1]['text'] = 'hii';
        $dataArr['template']['components'][0]['parameters'][2]['type'] = 'text';
        $dataArr['template']['components'][0]['parameters'][2]['text'] = 'who';

        echo json_encode($dataArr);

        // $url = 'https://graph.facebook.com/v15.0/103990335875981/messages';
        // $curl = curl_init();
        // curl_setopt_array(
        //     $curl,
        //     array(
        //         CURLOPT_URL => $url,
        //         CURLOPT_RETURNTRANSFER => true,
        //         CURLOPT_ENCODING => '',
        //         CURLOPT_MAXREDIRS => 10,
        //         CURLOPT_TIMEOUT => 0,
        //         CURLOPT_FOLLOWLOCATION => true,
        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //         CURLOPT_CUSTOMREQUEST => 'POST',
        //         CURLOPT_POSTFIELDS => json_encode($dataArr),
        //         CURLOPT_HTTPHEADER => array(
        //             'Content-Type: application/json',
        //             'Authorization: Bearer EAAPcgqaTrU8BAM2wXkAxbKnWtvZBOeG4F1eGFZBOp6X8ZBzC5AjTs3tQCtZAlytXoLJonR7fdiRW4R550AgSmIZAff3i9KtTqG9EwNOUE0GQgon78WSn7ncLklUVXuDlZAm4zKs8dZCZAYEt8wZCYjImbfSqkxi6uZAixEtlTCdPhlUQfZBPNUwYYG1AaJaA9QqgvEBcJnTqjOJswZDZD'
        //         ),
        //     )
        // );
        // echo $response = curl_exec($curl);
        // curl_close($curl);
    }

    function splashApi()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "") {
                $user_id = $this->input->post('user_id');
                $checkUser = getAllDataByVal('users', array('id' => $user_id));
                if ($checkUser->num_rows() > 0) {
                    $update_status = $this->getVersion();
                    $data['update_status'] = $update_status;
                    if ($update_status == 1) {
                        $data['update_message'] = 'A new version of the Maamus app is available in the Play Store. Please update your app to use all of our amazing features.';
                        $data['update_title'] = 'We are better than ever';
                    } elseif ($update_status == 2) {
                        $data['update_message'] = 'A new version of the Maamus app is available in the Play Store. Please update your app to use all of our amazing features.';
                        $data['update_title'] = 'We are better than ever';
                    } else {
                        $data['update_message'] = 'The application is under maintanance. Please bear us for some time. We are very sorry for the inconvinience caused.';
                        $data['update_title'] = 'We are better than ever';
                    }
                    $fcm_token = $this->input->post('fcm_token');

                    $this->db->where('id', $user_id);
                    $this->db->update('users', array('fcm_token' => $fcm_token));

                    $data['vendor_status'] = true;
                    $data['message'] = '';
                    $data['status'] = true;
                    $data['rcode'] = 200;
                    $data['user_id'] = $user_id;
                } else {
                    $data['vendor_status'] = false;
                    $data['message'] = 'Wrong User ID';
                    $data['status'] = false;
                    $data['rcode'] = 201;
                }
            } else {
                $data['vendor_status'] = false;
                $data['message'] = 'User ID is required';
                $data['status'] = false;
                $data['rcode'] = 201;
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function vendorProfile()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $vendor_id = $userRes['vendor_id'];
            $userObj = $this->mainModel->getAllDataByVal('user', array('id' => $vendor_id))->row();
            $data['status'] = true;
            $data['rcode'] = 200;
            $data['message'] = 'Profile Details';
            $data['data']['vendor_id'] = $userObj->cred_unique_code;
            $data['data']['full_name'] = $userObj->full_name;
            $data['data']['email'] = $userObj->email;
            $data['data']['mobile'] = $userObj->mobile;
            $data['data']['shop_name'] = $userObj->shop_name;
            $data['data']['shop_address_line1'] = $userObj->shop_address_line1;
            $data['data']['shop_address_line2'] = $userObj->shop_address_line2;
            $data['data']['shop_area_id'] = $userObj->shop_area_id;
            $data['data']['shop_area_name'] = $this->mainModel->getDataByVal('pincode_village', 'pincodes_list', array('pincodeid' => $userObj->shop_area_id));
            $data['data']['shop_district'] = $userObj->shop_district;
            $data['data']['shop_state'] = $userObj->shop_state;
            $data['data']['shop_pincode'] = $userObj->shop_pincode;
            $shopImagesData = $this->mainModel->getAllDataByVal('shop_image', array('user_id' => $vendor_id));

            $subscriptionDetailsObj = $this->mainModel->getAllDataByVal('sellers_subscription', array('user_id' => $vendor_id, 'status' => 1))->row();
            $subscriptionDetailsArr['subscription_name'] = $this->mainModel->getDataByVal('name', 'subscription', array('id' => $subscriptionDetailsObj->subscription_id));
            $subscriptionDetailsArr['start_date'] = date_conversion($subscriptionDetailsObj->subscription_start_date);
            $subscriptionDetailsArr['end_date'] = date_conversion($subscriptionDetailsObj->subscription_end_date);
            $subscriptionDetailsArr['amount_paid'] = $subscriptionDetailsObj->payment_amount;

            $data['data']['shop_image'] = base_url() . 'image/shop/' . $userObj->shop_logo;
            $data['data']['profile_pic'] = base_url() . 'image/user/' . $userObj->profile_pic;
            $data['data']['lat'] = $userObj->lat;
            $data['data']['lng'] = $userObj->lng;
            $data['data']['google_fulladdress'] = $userObj->google_fulladdress;
            $data['data']['upi_id'] = $userObj->upi_id;
            $data['data']['delivery_option'] = $userObj->delivery_option;
            $data['data']['cod_status'] = $userObj->cod_status;
            $data['data']['online_status'] = $userObj->online_status;
            $data['data']['upi_status'] = $userObj->upi_status;

            $data['data']['subscription_details'] = $subscriptionDetailsArr;
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function dashboard()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $vendor_id = $userRes['vendor_id'];
            $shop_type = $this->mainModel->getDataByVal('shop_type', 'user', array('id' => $vendor_id));
            $dashboard_type = $this->input->post('dashboard_type');

            $cart_total = 0;
            $cart_total_amount = 0;
            $primary_address = "";
            $data["status"] = true;
            $data["rcode"] = 200;
            $data["message"] = 'Data Found';
            if ($this->input->post('user_id') != "") {
                $user_id = $this->input->post('user_id');
                $cart_total = getSumData('cart', array('user_id' => $user_id), 'qty');
                if ($cart_total == "")
                    $cart_total = 0;
                $chargesArr = $this->getCharges();
                $cart_total_amount = $chargesArr['total_price'];

                $primary_address = getDataByVal('primary_address', 'users', array('id' => $user_id));
                if ($primary_address != "" && $primary_address != 0) {
                    $addressObj = getAllDataByVal('users_address', array('id' => $primary_address))->row();
                    $addressArr['address_id'] = $addressObj->id;
                    $addressArr['address'] = $addressObj->address;
                    $addressArr['pincode'] = $addressObj->pincode;
                    $addressArr['name'] = $addressObj->name;
                    $addressArr['email'] = $addressObj->email;
                    $addressArr['mobile_no'] = $addressObj->mobile_no;
                    $addressArr['street_address'] = $addressObj->street_address;
                    $addressArr['house_no'] = $addressObj->house_no;
                    $addressArr['address_type'] = $addressObj->address_type;
                    $addressArr['state'] = $addressObj->state;
                    $addressArr['city'] = $addressObj->city;
                } else {
                    $addressArr = new stdClass();
                }
            } else {
                $addressArr = new stdClass();
            }
            $delivery_option = $this->mainModel->getDataByVal('delivery_option', 'user', array('id' => $userRes['vendor_id']));
            $delivery_type = 0;
            if ($delivery_option == "delivery") {
                $delivery_type = 0;
            } elseif ($delivery_option == "pickup") {
                $delivery_type = 1;
            } elseif ($delivery_option == "both") {
                $delivery_type = 2;
            }

            $data['cart_count'] = $cart_total;
            $data['cart_amount'] = $cart_total_amount;
            $data['delivery_type'] = $delivery_type;
            $data['notification_count'] = $this->getNotificationCount();
            $data['shop_name'] = $this->mainModel->getDataByVal('shop_name', 'user', array('id' => $vendor_id));
            $data['shop_image'] = base_url() . 'image/shop/' . $this->mainModel->getDataByVal('shop_logo', 'user', array('id' => $vendor_id));
            $data['notification_count'] = $this->getNotificationCount();
            $data['version_update_status'] = $this->getVersion();
            $data['primary_address'] = ($primary_address == "") ? 0 : 1;
            $data['address_details'] = $addressArr;

            $s = 0;

            $data['data'][$s]['type'] = 'main_banner';
            $data['data'][$s]['title'] = 'Not Required';
            $data['data'][$s]['data'] = $this->getOfferBanner(1, 'dashboard');
            $s++;

            $data['data'][$s]['type'] = 'category';
            $data['data'][$s]['title'] = 'Shop By Category';
            $data['data'][$s]['data'] = $this->getCategoryCommon();
            $s++;

            $data['data'][$s]['type'] = 'recently_viewed';
            $data['data'][$s]['title'] = 'Recently Viewed Products';
            $data['data'][$s]['data'] = $this->getRecentlyViewedProduct('', 'dashboard', array());
            $s++;

            $data['data'][$s]['type'] = 'brand';
            $data['data'][$s]['title'] = 'Popular Brands';
            $data['data'][$s]['data'] = $this->getBrand('dashboard');
            $s++;

            $data['data'][$s]['type'] = 'banner';
            $data['data'][$s]['title'] = 'Not Required';
            $data['data'][$s]['data'] = $this->getOfferBanner(2, 'dashboard');
            $s++;

            $data['data'][$s]['type'] = 'product';
            $data['data'][$s]['title'] = 'Featured Products';
            $data['data'][$s]['data'] = $this->getProduct('featured', 'dashboard', array('limit' => 10, 'featured' => 1));
            $s++;

            $data['data'][$s]['type'] = 'banner1';
            $data['data'][$s]['title'] = 'Not Required';
            $data['data'][$s]['data'] = $this->getOfferBanner(3, 'dashboard');
            $s++;

            $data['data'][$s]['type'] = 'product1';
            $data['data'][$s]['title'] = 'Sponsored Products';
            $data['data'][$s]['data'] = $this->getProduct('sponsored', 'dashboard', array('limit' => 10, 'sponsored' => 1));
            $s++;

            $data['data'][$s]['type'] = 'banner2';
            $data['data'][$s]['title'] = 'Not Required';
            $data['data'][$s]['data'] = $this->getOfferBanner(4, 'dashboard');
            $s++;

            $data['data'][$s]['type'] = 'category_list';
            $data['data'][$s]['title'] = 'Shop By Category';
            $data['data'][$s]['data'] = $this->getCategoryCommon();
            $s++;
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function getNotificationCount()
    {
        $count = 0;
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $vendor_id = $userRes['vendor_id'];
            $shop_type = $this->mainModel->getDataByVal('shop_type', 'user', array('id' => $vendor_id));
            if ($this->input->post('user_id') != "") {
                $user_id = $this->input->post('user_id');
                $cur_date = date('Y-m-d');
                $cur_time = date('H:i:s');
                $previous_date = date('Y-m-d', strtotime($cur_date . ' - 1 day'));
                $start_date = $cur_date;
                $end_date = date('Y-m-d', strtotime($cur_date . ' - 10 days'));
                $user_id = $this->input->post('user_id');
                $j = 0;
                while ($start_date > $end_date) {
                    $sql = "SELECT * FROM `notification` WHERE `date`='$start_date' AND (`user_id`='$user_id' OR `user_id`='0')";
                    $query = $this->db->query($sql);
                    if ($query->num_rows() > 0) {
                        foreach ($query->result() as $notificationObj) {
                            $this->db->where('user_id', $user_id);
                            $this->db->where('notification_id', $notificationObj->id);
                            $query1 = $this->db->get('notification_seen');
                            if ($query1->num_rows() > 0) {
                            } else {
                                $count += 1;
                            }
                        }
                    }
                    $start_date = date('Y-m-d', strtotime($start_date . ' - 1 day'));
                }
            }
        }
        return $count;
    }

    function getCategory()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $categoryArr = array();
            if ($this->input->post('limit_status') == true) {
                $whereArr['limit'] = $this->input->post('limit');
            }
            $whereArr['status'] = 1;

            $query = getAllDataByVal('category', $whereArr);
            if ($query->num_rows() > 0) {
                $i = 0;
                foreach ($query->result() as $row) {
                    $max_discount = "New Arrival";
                    $discountArr = array();
                    $catArr = array('category' => $row->id, 'status' => 1);
                    $productData = getAllDataByVal('product', $catArr);
                    $no_of_product = 0;
                    if ($productData->num_rows() > 0) {
                        foreach ($productData->result() as $productObj) {
                            $product_id = $productObj->id;
                            $whereArrUnit = array('product_id' => $product_id, 'status' => 1);
                            $unitQry = $this->vendorModel->getAllDataByVal('product_unit_stock_price', $whereArrUnit);
                            foreach ($unitQry->result() as $unitObj) {
                                $unit_sales_price = $unitObj->unit_sales_price;
                                $unit_mrp = $unitObj->unit_mrp;
                                $discountArr[] = $this->vendorModel->calculateDiscount($unit_mrp, $unit_sales_price);
                            }
                            $no_of_product++;
                        }
                        if (count($discountArr) > 0) {
                            $max_discount = "Upto " . max($discountArr) . "% Off";
                        } else {
                            $max_discount = "New Arrival";
                        }
                        $select_status = 'false';
                    }
                    if ($no_of_product > 0) {
                        $categoryArr[] = array('category_id' => $row->id, 'image' => base_url() . 'image/category/' . $row->image, 'name' => $row->name, 'maximum_discount' => $max_discount, 'no_of_product' => $no_of_product);
                    }
                    $i++;
                }
                $data['status'] = true;
                $data['rcode'] = 200;
                $data['data'] = $categoryArr;
            } else {
                $data['status'] = false;
                $data['rcode'] = 404;
                $data['data'] = 'No Data ';
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function getBrand($request_type = "")
    {
        $data = array();
        $brandArr = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $vendor_id = $userRes['vendor_id'];
            if ($this->input->post('dashboard_type') != "") {
                if ($this->input->post('dashboard_type') == "grocery") {
                    $whereArr['in_shop_type'] = array(1);
                } else {
                    $whereArr['not_in_shop_type'] = array(1);
                }
            }
            $query = $this->mainModel->getAllDataByVal('brand', $whereArr);
            if ($query->num_rows() > 0) {
                $i = 0;
                foreach ($query->result() as $brandObj) {
                    $brandArr[$i]['brand_id'] = $brandObj->id;
                    $brandArr[$i]['brand_name'] = $brandObj->name;
                    $brandArr[$i]['brand_logo'] = base_url() . 'image/brand/' . $brandObj->image;
                    $i++;
                }
                $data["status"] = true;
                $data["rcode"] = 200;
                $data["message"] = 'Data Found';
                $data['data'] = $brandArr;
            }
        } else {
            $data = $userRes;
        }
        if ($request_type == "dashboard") {
            return $brandArr;
        } else {
            echo json_encode($data);
        }
    }

    function getCategoryCommon($shop_type = "", $category_id = "")
    {
        $categoryArr = array();
        $whereArr['status'] = 1;
        if ($this->input->post('dashboard_type') != "") {
            if ($this->input->post('dashboard_type') == "grocery") {
                $whereArr['in_shop_type'] = array(1);
            } else {
                $whereArr['not_in_shop_type'] = array(1);
            }
        }
        $query = $this->mainModel->getAllDataByVal('category', $whereArr);
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result() as $row) {
                $max_discount = "New Arrival";
                $select_status = "false";
                $discountArr = array();
                $catArr = array('category' => $row->id, 'status' => 1);
                $productData = $this->vendorModel->getAllDataByVal('product', $catArr);
                if ($productData->num_rows() > 0) {
                    foreach ($productData->result() as $productObj) {
                        $product_id = $productObj->id;
                        $whereArrUnit = array('product_id' => $product_id, 'status' => 1);
                        $unitQry = $this->vendorModel->getAllDataByVal('product_unit_stock_price', $whereArrUnit);
                        foreach ($unitQry->result() as $unitObj) {
                            $unit_sales_price = $unitObj->unit_sales_price;
                            $unit_mrp = $unitObj->unit_mrp;
                            $discountArr[] = $this->vendorModel->calculateDiscount($unit_mrp, $unit_sales_price);
                        }
                    }
                    if (count($discountArr) > 0) {
                        $max_discount = "Upto " . max($discountArr) . "% Off";
                    } else {
                        $max_discount = "New Arrival";
                    }
                    $select_status = 'false';
                    if ($category_id != "") {
                        if ($row->id == $category_id) {
                            $select_status = 'true';
                        }
                    }
                    // $categoryArr[] = array('category_id' => $row->id, 'image' => base_url() . 'image/category/' . $row->image, 'name' => $row->name, 'maximum_discount' => $max_discount, 'is_selected' => $select_status);
                    // $i++;
                }
                $categoryArr[] = array('category_id' => $row->id, 'image' => base_url() . 'image/category/' . $row->image, 'name' => $row->name, 'maximum_discount' => $max_discount, 'is_selected' => $select_status);
                $i++;
            }
        } else {
            $categoryArr = array();
        }
        return $categoryArr;
    }

    function getSubCategory()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $vendor_id = $userRes['vendor_id'];
            $shop_type = $this->mainModel->getDataByVal('shop_type', 'user', array('id' => $vendor_id));
            if ($this->input->post('category_id') != "") {
                $category = $this->input->post('category_id');
                $shop_type_id = $this->mainModel->getDataByVal('shop_type', 'category', array('id' => $category));

                $query = $this->mainModel->getAllDataByVal('sub_category', array('category' => $category, 'status' => 1));
                if ($query->num_rows() > 0) {
                    $data["status"] = true;
                    $data["rcode"] = 200;
                    $data["message"] = 'Data Found';
                    $data['related_category'] = $this->getCategoryCommon($shop_type_id, $category);
                    $i = 0;
                    foreach ($query->result() as $row) {
                        $subcatArr = array('sub_category' => $row->id);
                        $productData = $this->vendorModel->getAllDataByVal('product', $subcatArr);
                        if ($productData->num_rows() > 0) {
                            $data['data'][] = array('sub_category_id' => $row->id, 'image' => base_url() . 'image/sub_category/' . $row->image, 'name' => $row->name);
                            $i++;
                        }
                    }
                } else {
                    $data["status"] = false;
                    $data["rcode"] = 500;
                    $data["message"] = 'No Data Found';
                }
            } else {
                $data["status"] = false;
                $data["rcode"] = 500;
                $data["message"] = 'Category ID is required';
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function getOfferBanner($position = "", $page_type = "")
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $vendor_id = $userRes['vendor_id'];
            $whereArr['status'] = 1;
            if ($position != "")
                $whereArr['position'] = $position;
            if ($this->input->post('dashboard_type') != "") {
                $dashboard_type = $this->input->post('dashboard_type');
                if ($dashboard_type == "grocery") {
                    $this->db->where('banner_for', 2);
                } else {
                    $this->db->where('banner_for', 1);
                }
            }
            $bannerData = getAllDataByVal('banner', $whereArr);
            if ($bannerData->num_rows() > 0) {
                $i = 0;
                $bannerArr = array();
                foreach ($bannerData->result() as $bannerObj) {
                    $bannerArr[$i]['banner_id'] = (int) $bannerObj->id;
                    $bannerArr[$i]['category_id'] = (int) $bannerObj->category_id;
                    $bannerArr[$i]['category_name'] = $this->mainModel->getDataByVal('name', 'category', array('id' => $bannerObj->category_id));
                    $bannerArr[$i]['image'] = base_url() . 'image/banner/' . $bannerObj->image;
                    $i++;
                }
                if ($page_type != "" && $page_type == "dashboard") {
                    $data = $bannerArr;
                } else {
                    $data['status'] = true;
                    $data['rcode'] = 200;
                    $data['message'] = 'Data Found';
                    $data['data'] = $bannerArr;
                }
            } else {
                if ($page_type != "" && $page_type == "dashboard") {
                    $data = array();
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 500;
                    $data['message'] = 'No Data Found';
                }
            }
        } else {
            $data = $userRes;
        }
        if ($page_type != "" && $page_type == "dashboard") {
            return $data;
        } else {
            echo json_encode($data);
        }
    }

    function getOtherBanner($position = "", $page_type = "")
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $vendor_id = $userRes['vendor_id'];
            $whereArr['status'] = 1;
            if ($position != "")
                $whereArr['position'] = $position;
            $bannerData = getAllDataByVal('banner', $whereArr);
            if ($bannerData->num_rows() > 0) {
                $i = 0;
                $bannerArr = array();
                foreach ($bannerData->result() as $bannerObj) {
                    $bannerArr[$i]['banner_id'] = (int) $bannerObj->id;
                    $bannerArr[$i]['category_id'] = (int) $bannerObj->category_id;
                    $bannerArr[$i]['category_name'] = $this->mainModel->getDataByVal('name', 'category', array('id' => $bannerObj->category_id));
                    $bannerArr[$i]['image'] = base_url() . 'image/banner/' . $bannerObj->image;
                    $i++;
                }
                if ($page_type != "" && $page_type == "dashboard") {
                    $data = $bannerArr;
                } else {
                    $data['status'] = true;
                    $data['rcode'] = 200;
                    $data['message'] = 'Data Found';
                    $data['data'] = $bannerArr;
                }
            } else {
                if ($page_type != "" && $page_type == "dashboard") {
                    $data = array();
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 500;
                    $data['message'] = 'No Data Found';
                }
            }
        } else {
            $data = $userRes;
        }
        if ($page_type != "" && $page_type == "dashboard") {
            return $data;
        } else {
            echo json_encode($data);
        }
    }

    function getRecentlyViewedProduct($type = "", $page_type = "", $whereArr = array())
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $user_id = "";
            if ($this->input->post('user_id') != "" && $this->input->post('dashboard_type') != "") {
                $user_id = $this->input->post('user_id');

                $this->db->where('user_id', $user_id);
                $this->db->where('status', 1);
                if ($this->input->post('dashboard_type') != "") {
                    if ($this->input->post('dashboard_type') == "grocery") {
                        $this->db->where_in('type', array(1));
                    } else {
                        $this->db->where_not_in('type', array(1));
                    }
                }
                $query = $this->db->get('recently_viewed_product');
                if ($query->num_rows() > 0) {
                    $i = 0;
                    $category_id = '';
                    foreach ($query->result() as $rowRecent) {
                        $row = getAllDataByVal('product', array('id' => $rowRecent->product_id))->row();
                        $product_type = 1;
                        $product_id = $row->id;
                        $shop_type_id = $row->shop_type;
                        $shop_type_name = getDataByVal('name', 'shop_type', array('id' => $shop_type_id));
                        $shopTypeNameArr = explode(' ', $shop_type_name);
                        if (in_array('Mobile', $shopTypeNameArr) != false || in_array('Electronics', $shopTypeNameArr) != false) {
                            $unitQry = $this->vendorModel->getAllDataByVal('product_ram_rom_price', array('product_id' => $product_id, 'stock_status' => 1));
                            $product_type = 2;
                        } else {
                            $unitQry = $this->vendorModel->getAllDataByVal('product_unit_stock_price', array('product_id' => $product_id, 'stock_status' => 1));
                            $product_type = 1;
                        }
                        if ($unitQry->num_rows() > 0) {
                            $category_id = $row->category;
                            $wishlist_status = 0;
                            if ($user_id != "") {
                                $checkWishList = getAllDataByVal('user_wishlist', array('user_id' => $user_id, 'product_id' => $product_id));
                                if ($checkWishList->num_rows() > 0)
                                    $wishlist_status = 1;
                            }

                            $data[$i]['id'] = $product_id;
                            $data[$i]['name'] = $row->product_name;
                            $data[$i]['brand_id'] = $row->brand;
                            $data[$i]['brand_name'] = getDataByVal('name', 'brand', array('id' => $row->brand));

                            $data[$i]['product_type'] = $product_type;
                            $data[$i]['wishlist_status'] = $wishlist_status;
                            if ($row->home_image != "") {
                                $data[$i]['home_image'] = base_url() . 'image/product/' . $row->home_image;
                            } else {
                                $data[$i]['home_image'] = "";
                            }

                            if ($product_type == 2) {
                                $whereArrUnit = array('product_id' => $product_id);
                                $unitQry = $this->vendorModel->getAllDataByVal('product_ram_rom_price', $whereArrUnit);
                                $n = 0;
                                if ($unitQry->num_rows() > 0) {
                                    $unitArr = array();
                                    foreach ($unitQry->result() as $unitObj) {
                                        if ((int) $unitObj->stock_status == 1) {
                                            $unit_id = $unitObj->id;
                                            $unit_value = $unitObj->ram_size;
                                            if ($user_id != "") {
                                                $this->db->where('user_id', $user_id);
                                                $this->db->where('unit_id', $unit_id);
                                                $this->db->where('product_id', $product_id);
                                                $this->db->where('product_type', 2);
                                                $query = $this->db->get('cart');
                                                $this->db->last_query();
                                                if ($query->num_rows() > 0) {
                                                    foreach ($query->result() as $row) {
                                                        $qtyCart = $row->qty;
                                                    }
                                                } else {
                                                    $qtyCart = "0";
                                                }
                                            } else {
                                                $qtyCart = "0";
                                            }
                                            $unitArr[$n]['cart_qty'] = $qtyCart;
                                            $unitArr[$n]['unit_id'] = $unitObj->id;
                                            $unitArr[$n]['unit_ram'] = $unitObj->ram_size . ' ' . $unitObj->ram_size_type;
                                            $unitArr[$n]['unit_rom'] = $unitObj->rom_size . ' ' . $unitObj->rom_size_type;
                                            $unitArr[$n]['unit_sales_price'] = $unitObj->unit_sales_price;
                                            $unitArr[$n]['unit_mrp'] = $unitObj->unit_mrp;
                                            $unit_sales_price = $unitObj->unit_sales_price;
                                            $unit_mrp = $unitObj->unit_mrp;
                                            $discount = $this->vendorModel->calculateDiscount($unit_mrp, $unit_sales_price);
                                            $unitArr[$n]['discount'] = $discount;

                                            $data[$i]['unit'] = $unitObj->ram_size . ' ' . $unitObj->ram_size_type;
                                            $data[$i]['unit_sales_price'] = $unitObj->unit_sales_price;
                                            $data[$i]['unit_mrp'] = $unitObj->unit_mrp;
                                            $data[$i]['discount'] = $discount;
                                            $n++;
                                        }
                                    }
                                    if (count($unitArr) <= 0) {
                                        $unitArr = false;
                                    }
                                } else {
                                    $unitArr = false;
                                }
                                $data[$i]['unit_details'] = $unitArr;
                            } else {
                                $whereArrUnit = array('product_id' => $product_id);
                                $unitQry = $this->vendorModel->getAllDataByVal('product_unit_stock_price', $whereArrUnit);
                                $n = 0;
                                if ($unitQry->num_rows() > 0) {
                                    $unitArr = array();
                                    foreach ($unitQry->result() as $unitObj) {
                                        if ((int) $unitObj->stock_status == 1) {
                                            $unit_id = $unitObj->id;
                                            $unit_value = $unitObj->unit_value;
                                            if ($user_id != "") {
                                                $this->db->where('user_id', $user_id);
                                                $this->db->where('unit_id', $unit_id);
                                                $this->db->where('product_id', $product_id);
                                                $this->db->where('product_type', 1);
                                                $query = $this->db->get('cart');
                                                $this->db->last_query();
                                                if ($query->num_rows() > 0) {
                                                    foreach ($query->result() as $row) {
                                                        $qtyCart = $row->qty;
                                                    }
                                                } else {
                                                    $qtyCart = "0";
                                                }
                                            } else {
                                                $qtyCart = "0";
                                            }
                                            $unitArr[$n]['cart_qty'] = $qtyCart;
                                            $unitArr[$n]['unit_id'] = $unitObj->id;
                                            $unitArr[$n]['unit_value'] = $unitObj->unit_value;
                                            $unit_name = $this->mainModel->getDataByField('name', 'unit', 'id', $unitObj->unit, 1);
                                            $unitArr[$n]['unit'] = $unitObj->unit_value . ' ' . $unit_name;
                                            $unitArr[$n]['unit_sales_price'] = $unitObj->unit_sales_price;
                                            $unitArr[$n]['unit_mrp'] = $unitObj->unit_mrp;
                                            $unit_sales_price = $unitObj->unit_sales_price;
                                            $unit_mrp = $unitObj->unit_mrp;
                                            $discount = $this->vendorModel->calculateDiscount($unit_mrp, $unit_sales_price);
                                            $unitArr[$n]['discount'] = $discount;

                                            $data[$i]['unit'] = $unitObj->unit_value . ' ' . $unit_name;
                                            $data[$i]['unit_sales_price'] = $unitObj->unit_sales_price;
                                            $data[$i]['unit_mrp'] = $unitObj->unit_mrp;
                                            $data[$i]['discount'] = $discount;
                                            $n++;
                                        }
                                    }
                                    if (count($unitArr) <= 0) {
                                        $unitArr = false;
                                    }
                                } else {
                                    $unitArr = false;
                                }
                                $data[$i]['unit_details'] = $unitArr;
                            }
                            $i++;
                        }
                    }

                    if ($page_type != "" && $page_type == "dashboard") {
                        $res = $data;
                    } else {
                        $res['status'] = true;
                        $res['rcode'] = 200;
                        $res['message'] = 'Data Found';
                        $res['data'] = $data;
                    }
                } else {
                    if ($page_type != "" && $page_type == "dashboard") {
                        $res = array();
                    } else {
                        $res['status'] = false;
                        $res['rcode'] = 500;
                        $res['message'] = 'No Data Found';
                    }
                }
            } else {
                if ($page_type != "" && $page_type == "dashboard") {
                    $res = array();
                } else {
                    $res['status'] = false;
                    $res['rcode'] = 500;
                    $res['message'] = 'User ID is required';
                }
            }
        } else {
            if ($page_type != "" && $page_type == "dashboard") {
                $res = array();
            } else {
                $res = $userRes;
            }
        }
        if ($page_type != "" && $page_type == "dashboard") {
            return $res;
        } else {
            echo json_encode($res);
        }
    }

    function getProduct($type = "", $page_type = "", $whereArr = array())
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('search_text') != "") {
                $this->db->like('product_name', $this->input->post('search_text'));
                $this->db->like('title', $this->input->post('search_text'));
            }
            if ($this->input->post('category_id') != "") {
                $this->db->where('category', $this->input->post('category_id'));
            }
            if ($this->input->post('sub_category_id') != "") {
                $this->db->where('sub_category', $this->input->post('sub_category_id'));
            }
            if ($this->input->post('brand_id') != "") {
                $this->db->where('brand', $this->input->post('brand_id'));
            }
            if ($this->input->post('type') != "") {
                if ($this->input->post('type') == "sponsored") {
                    $this->db->where('sponsored', 1);
                }
                if ($this->input->post('type') == "featured") {
                    $this->db->where('featured', 1);
                }
            }
            if ($this->input->post('dashboard_type') != "") {
                if ($this->input->post('dashboard_type') == "grocery") {
                    $this->db->where_in('shop_type', array(1));
                } else {
                    $this->db->where_not_in('shop_type', array(1));
                }
            }
            if ($this->input->post('limit') != "") {
                if ($this->input->post('start_val') && $this->input->post('start_val') > 0) {
                    $start_val = $this->input->post('start_val');
                } else {
                    $start_val = 0;
                }
                if ($this->input->post('max_limit') && $this->input->post('max_limit') > 0) {
                    $max_limit = $this->input->post('max_limit');
                } else {
                    $max_limit = 16;
                }
                $this->db->limit($max_limit, $start_val);
            }

            if (count($whereArr) > 0) {
                foreach ($whereArr as $key => $value) {
                    if ($key == "limit")
                        $this->db->limit($value);
                    else
                        $this->db->where($key, $value);
                }
            }

            $this->db->where('status', 1);
            $query = $this->db->get('product');
            if ($query->num_rows() > 0) {
                $user_id = "";
                if ($this->input->post('user_id') != "") {
                    $user_id = $this->input->post('user_id');
                }
                $i = 0;
                $category_id = '';
                $dataSimilar = array();
                foreach ($query->result() as $row) {
                    $product_type = 1;
                    $product_id = $row->id;
                    $shop_type_id = $row->shop_type;
                    $shop_type_name = getDataByVal('name', 'shop_type', array('id' => $shop_type_id));
                    $shopTypeNameArr = explode(' ', $shop_type_name);
                    if (in_array('Mobile', $shopTypeNameArr) != false || in_array('Electronics', $shopTypeNameArr) != false) {
                        $unitQry = $this->vendorModel->getAllDataByVal('product_ram_rom_price', array('product_id' => $product_id, 'stock_status' => 1));
                        $product_type = 2;
                    } else {
                        $unitQry = $this->vendorModel->getAllDataByVal('product_unit_stock_price', array('product_id' => $product_id, 'stock_status' => 1));
                        $product_type = 1;
                    }
                    if ($unitQry->num_rows() > 0) {
                        $category_id = $row->category;
                        $wishlist_status = 0;
                        if ($user_id != "") {
                            $checkWishList = getAllDataByVal('user_wishlist', array('user_id' => $user_id, 'product_id' => $product_id));
                            if ($checkWishList->num_rows() > 0)
                                $wishlist_status = 1;
                        }

                        $data[$i]['id'] = $product_id;
                        $data[$i]['name'] = $row->product_name;
                        $data[$i]['brand_id'] = $row->brand;
                        $data[$i]['brand_name'] = getDataByVal('name', 'brand', array('id' => $row->brand));

                        $data[$i]['product_type'] = $product_type;
                        $data[$i]['wishlist_status'] = $wishlist_status;
                        if ($row->home_image != "") {
                            $data[$i]['home_image'] = base_url() . 'image/product/' . $row->home_image;
                        } else {
                            $data[$i]['home_image'] = "";
                        }

                        if ($product_type == 2) {
                            $whereArrUnit = array('product_id' => $product_id);
                            $unitQry = $this->vendorModel->getAllDataByVal('product_ram_rom_price', $whereArrUnit);
                            $n = 0;
                            if ($unitQry->num_rows() > 0) {
                                $unitArr = array();
                                foreach ($unitQry->result() as $unitObj) {
                                    if ((int) $unitObj->stock_status == 1) {
                                        $unit_id = $unitObj->id;
                                        $unit_value = $unitObj->ram_size;
                                        if ($user_id != "") {
                                            $this->db->where('user_id', $user_id);
                                            $this->db->where('unit_id', $unit_id);
                                            $this->db->where('product_id', $product_id);
                                            $this->db->where('product_type', 2);
                                            $query = $this->db->get('cart');
                                            $this->db->last_query();
                                            if ($query->num_rows() > 0) {
                                                foreach ($query->result() as $row) {
                                                    $qtyCart = $row->qty;
                                                }
                                            } else {
                                                $qtyCart = "0";
                                            }
                                        } else {
                                            $qtyCart = "0";
                                        }
                                        $unitArr[$n]['cart_qty'] = $qtyCart;
                                        $unitArr[$n]['unit_id'] = $unitObj->id;
                                        $unitArr[$n]['unit_ram'] = $unitObj->ram_size . ' ' . $unitObj->ram_size_type;
                                        $unitArr[$n]['unit_rom'] = $unitObj->rom_size . ' ' . $unitObj->rom_size_type;
                                        $unitArr[$n]['unit_sales_price'] = $unitObj->unit_sales_price;
                                        $unitArr[$n]['unit_mrp'] = $unitObj->unit_mrp;
                                        $unit_sales_price = $unitObj->unit_sales_price;
                                        $unit_mrp = $unitObj->unit_mrp;
                                        $discount = $this->vendorModel->calculateDiscount($unit_mrp, $unit_sales_price);
                                        $unitArr[$n]['discount'] = $discount;

                                        $data[$i]['unit'] = $unitObj->ram_size . ' ' . $unitObj->ram_size_type;
                                        $data[$i]['unit_sales_price'] = $unitObj->unit_sales_price;
                                        $data[$i]['unit_mrp'] = $unitObj->unit_mrp;
                                        $data[$i]['discount'] = $discount;
                                        $n++;
                                    }
                                }
                                if (count($unitArr) <= 0) {
                                    $unitArr = false;
                                }
                            } else {
                                $unitArr = false;
                            }
                            $data[$i]['unit_details'] = $unitArr;
                        } else {
                            $whereArrUnit = array('product_id' => $product_id);
                            $unitQry = $this->vendorModel->getAllDataByVal('product_unit_stock_price', $whereArrUnit);
                            $n = 0;
                            if ($unitQry->num_rows() > 0) {
                                $unitArr = array();
                                foreach ($unitQry->result() as $unitObj) {
                                    if ((int) $unitObj->stock_status == 1) {
                                        $unit_id = $unitObj->id;
                                        $unit_value = $unitObj->unit_value;
                                        if ($user_id != "") {
                                            $this->db->where('user_id', $user_id);
                                            $this->db->where('unit_id', $unit_id);
                                            $this->db->where('product_id', $product_id);
                                            $this->db->where('product_type', 1);
                                            $query = $this->db->get('cart');
                                            $this->db->last_query();
                                            if ($query->num_rows() > 0) {
                                                foreach ($query->result() as $row) {
                                                    $qtyCart = $row->qty;
                                                }
                                            } else {
                                                $qtyCart = "0";
                                            }
                                        } else {
                                            $qtyCart = "0";
                                        }
                                        $unitArr[$n]['cart_qty'] = $qtyCart;
                                        $unitArr[$n]['unit_id'] = $unitObj->id;
                                        $unitArr[$n]['unit_value'] = $unitObj->unit_value;
                                        $unit_name = $this->mainModel->getDataByField('name', 'unit', 'id', $unitObj->unit, 1);
                                        $unitArr[$n]['unit'] = $unitObj->unit_value . ' ' . $unit_name;
                                        $unitArr[$n]['unit_sales_price'] = $unitObj->unit_sales_price;
                                        $unitArr[$n]['unit_mrp'] = $unitObj->unit_mrp;
                                        $unit_sales_price = $unitObj->unit_sales_price;
                                        $unit_mrp = $unitObj->unit_mrp;
                                        $discount = $this->vendorModel->calculateDiscount($unit_mrp, $unit_sales_price);
                                        $unitArr[$n]['discount'] = $discount;

                                        $data[$i]['unit'] = $unitObj->unit_value . ' ' . $unit_name;
                                        $data[$i]['unit_sales_price'] = $unitObj->unit_sales_price;
                                        $data[$i]['unit_mrp'] = $unitObj->unit_mrp;
                                        $data[$i]['discount'] = $discount;
                                        $n++;
                                    }
                                }
                                if (count($unitArr) <= 0) {
                                    $unitArr = false;
                                }
                            } else {
                                $unitArr = false;
                            }
                            $data[$i]['unit_details'] = $unitArr;
                        }
                        $i++;
                    }
                }

                if ($this->input->post('limit')) {
                    $next_limit = $start_val + $max_limit;
                    $this->db->limit($max_limit, $next_limit);
                    $this->db->where('status', 1);
                    $checkProductQuery = $this->db->get('product');
                    if ($checkProductQuery->num_rows() > 0) {
                        $res['checkMoreProduct'] = true;
                    } else {
                        $res['checkMoreProduct'] = false;
                    }
                }
                if ($page_type != "" && $page_type == "dashboard") {
                    $res = $data;
                } else {
                    $res['status'] = true;
                    $res['rcode'] = 200;
                    $res['message'] = 'Data Found';
                    $res['data'] = $data;
                    if ($this->input->post('product_id') != "") {
                        $res['similar_product'] = $dataSimilar;
                    }
                }
            } else {
                if ($page_type != "" && $page_type == "dashboard") {
                    $res = array();
                } else {
                    $res['status'] = false;
                    $res['rcode'] = 500;
                    $res['message'] = 'No Data Found';
                    $res['checkMoreProduct'] = false;
                }
            }
        } else {
            $res = $userRes;
        }
        if ($page_type != "" && $page_type == "dashboard") {
            return $res;
        } else {
            echo json_encode($res);
        }
    }

    function getProductDetails()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $dataSimilar = array();
            if ($this->input->post('product_id') != '') {
                $product_id = $this->input->post('product_id');
                $checkProductId = getAllDataByVal('product', array('id' => $product_id));
                if ($checkProductId->num_rows() > 0) {
                    $row = $checkProductId->row();
                    $shop_type_id = $row->shop_type;
                    $user_id = "";
                    if ($this->input->post('user_id') != "") {
                        $user_id = $this->input->post('user_id');
                        $checkRecentlyViewedList = getAllDataByVal('recently_viewed_product', array('user_id' => $user_id, 'product_id' => $product_id));
                        if ($checkRecentlyViewedList->num_rows() <= 0) {
                            $insRecent['user_id'] = $user_id;
                            $insRecent['product_id'] = $product_id;
                            $insRecent['type'] = $shop_type_id;
                            $insRecent['date'] = sys_date();
                            $insRecent['time'] = sys_time();
                            $insRecent['status'] = 1;
                            $this->db->insert('recently_viewed_product', $insRecent);
                        }
                    }

                    $product_type = 1;
                    $product_id = $row->id;

                    $shop_type_name = getDataByVal('name', 'shop_type', array('id' => $shop_type_id));
                    $shopTypeNameArr = explode(' ', $shop_type_name);
                    if (in_array('Mobile', $shopTypeNameArr) != false || in_array('Electronics', $shopTypeNameArr) != false) {
                        $unitQry = $this->vendorModel->getAllDataByVal('product_ram_rom_price', array('product_id' => $product_id, 'stock_status' => 1));
                        $product_type = 2;
                    } else {
                        $unitQry = $this->vendorModel->getAllDataByVal('product_unit_stock_price', array('product_id' => $product_id, 'stock_status' => 1));
                        $product_type = 1;
                    }
                    if ($unitQry->num_rows() > 0) {
                        $wishlist_status = 0;
                        if ($user_id != "") {
                            $checkWishList = getAllDataByVal('user_wishlist', array('user_id' => $user_id, 'product_id' => $product_id));
                            if ($checkWishList->num_rows() > 0)
                                $wishlist_status = 1;
                        }

                        $category_id = $row->category;
                        $data['id'] = $product_id;
                        $data['name'] = $row->product_name;
                        $data['category_id'] = $row->category;
                        $data['category_name'] = $this->mainModel->getDataByField('name', 'category', 'id', $row->category, 1);
                        $data['brand_id'] = $row->brand;
                        $data['brand_name'] = getDataByVal('name', 'brand', array('id' => $row->brand));
                        $data['sub_category_id'] = $row->sub_category;
                        $data['sub_category_name'] = $this->mainModel->getDataByField('name', 'sub_category', 'id', $row->sub_category, 1);
                        $data['description'] = $row->description;
                        $data['additional_detaiils'] = $row->additional_detaiils;
                        $data['disclaimer'] = $row->disclaimer;

                        $data['shelf_life'] = $row->shelf_life;
                        $data['origin'] = $row->origin;
                        $data['manufacturer'] = $row->manufacturer;
                        $data['product_type'] = $product_type;
                        $data['wishlist_status'] = $wishlist_status;
                        if ($row->home_image != "") {
                            $data['home_image'] = base_url() . 'image/product/' . $row->home_image;
                        } else {
                            $data['home_image'] = "";
                        }

                        $whereArrGalleryImage = array('product_id' => $product_id);
                        $galleryImagesQry = $this->vendorModel->getAllDataByVal('product_images', $whereArrGalleryImage);
                        $m = 0;
                        if ($galleryImagesQry->num_rows() > 0) {
                            foreach ($galleryImagesQry->result() as $galleryImagesObj) {
                                $imgArr[$m]['image'] = base_url() . 'image/product/' . $galleryImagesObj->image;
                                $m++;
                            }
                        } else {
                            $imgArr = array();
                        }
                        $data['gallery_image'] = $imgArr;

                        $whereArrSpecification = array('product_id' => $product_id);
                        $specificationQry = $this->vendorModel->getAllDataByVal('product_specification', $whereArrSpecification);
                        $l = 0;
                        $specificationArr = array();
                        if ($specificationQry->num_rows() > 0) {
                            foreach ($specificationQry->result() as $specificationObj) {
                                $field_type = getDataByVal('field_type', 'form_fields', array('id' => $specificationObj->specification_key));
                                $specificationArr[$l]['specification_key'] = getDataByVal('field_name', 'form_fields', array('id' => $specificationObj->specification_key));
                                if ($field_type == "select")
                                    $specificationArr[$l]['specification_value'] = getDataByVal('form_field_value', 'form_field_values', array('id' => $specificationObj->specification_value));
                                else
                                    $specificationArr[$l]['specification_value'] = $specificationObj->specification_value;
                                $l++;
                            }
                        }
                        $data['specification'] = $specificationArr;

                        $sizeQry = $this->vendorModel->getAllDataByVal('product_size', array('product_id' => $product_id));
                        $f = 0;
                        $sizeArr = array();
                        if ($sizeQry->num_rows() > 0) {
                            foreach ($sizeQry->result() as $sizeObj) {
                                $sizeArr[$f]['size_id'] = $sizeObj->id;
                                $sizeArr[$f]['size'] = $sizeObj->size;
                                $sizeArr[$f]['size_type'] = $sizeObj->size_type;
                                $sizeArr[$f]['stock_status'] = $sizeObj->stock_status;
                                $f++;
                            }
                            $size_availablity = 1;
                        } else
                            $size_availablity = 0;

                        $data['size_availablity'] = $size_availablity;
                        $data['size_list'] = $sizeArr;

                        $colorQry = $this->vendorModel->getAllDataByVal('product_color', array('product_id' => $product_id));
                        $c = 0;
                        $colorArr = array();
                        if ($colorQry->num_rows() > 0) {
                            foreach ($colorQry->result() as $colorObj) {
                                $colorArr[$c]['color_id'] = $colorObj->id;
                                $colorArr[$c]['color'] = $colorObj->color;
                                $colorArr[$c]['color_image'] = base_url() . 'image/product_color/' . $colorObj->image;
                                $colorArr[$c]['stock_status'] = $colorObj->stock_status;
                                $c++;
                            }
                            $color_availablity = 1;
                        } else
                            $color_availablity = 0;

                        $data['color_availablity'] = $color_availablity;
                        $data['color_list'] = $colorArr;

                        if ($product_type == 2) {
                            $whereArrUnit = array('product_id' => $product_id);
                            $unitQry = $this->vendorModel->getAllDataByVal('product_ram_rom_price', $whereArrUnit);
                            $n = 0;
                            if ($unitQry->num_rows() > 0) {
                                $unitArr = array();
                                foreach ($unitQry->result() as $unitObj) {
                                    if ((int) $unitObj->stock_status == 1) {
                                        $unit_id = $unitObj->id;
                                        $unit_value = $unitObj->ram_size;
                                        if ($user_id != "") {
                                            $this->db->where('user_id', $user_id);
                                            $this->db->where('unit_id', $unit_id);
                                            $this->db->where('product_id', $product_id);
                                            $this->db->where('product_type', 2);
                                            $query = $this->db->get('cart');
                                            $this->db->last_query();
                                            if ($query->num_rows() > 0) {
                                                foreach ($query->result() as $row) {
                                                    $qtyCart = $row->qty;
                                                }
                                            } else {
                                                $qtyCart = "0";
                                            }
                                        } else {
                                            $qtyCart = "0";
                                        }
                                        $unitArr[$n]['cart_qty'] = $qtyCart;
                                        $unitArr[$n]['unit_id'] = $unitObj->id;
                                        $unitArr[$n]['unit_ram'] = $unitObj->ram_size . ' ' . $unitObj->ram_size_type;
                                        $unitArr[$n]['unit_rom'] = $unitObj->rom_size . ' ' . $unitObj->rom_size_type;
                                        $unitArr[$n]['unit_sales_price'] = $unitObj->unit_sales_price;
                                        $unitArr[$n]['unit_mrp'] = $unitObj->unit_mrp;
                                        $unit_sales_price = $unitObj->unit_sales_price;
                                        $unit_mrp = $unitObj->unit_mrp;
                                        $discount = $this->vendorModel->calculateDiscount($unit_mrp, $unit_sales_price);
                                        $unitArr[$n]['discount'] = $discount;
                                        $unitArr[$n]['stock_status'] = $unitObj->stock_status;

                                        // $data[$i]['unit'] = $unitObj->ram_size . ' ' . $unitObj->ram_size_type;
                                        // $data[$i]['unit_sales_price'] = $unitObj->unit_sales_price;
                                        // $data[$i]['unit_mrp'] = $unitObj->unit_mrp;
                                        // $data[$i]['discount'] = $discount;
                                        $n++;
                                    }
                                }
                                if (count($unitArr) <= 0) {
                                    $unitArr = false;
                                }
                            } else {
                                $unitArr = false;
                            }
                            $data['unit_details'] = $unitArr;
                        } else {
                            $whereArrUnit = array('product_id' => $product_id);
                            $unitQry = $this->vendorModel->getAllDataByVal('product_unit_stock_price', $whereArrUnit);
                            $n = 0;
                            if ($unitQry->num_rows() > 0) {
                                $unitArr = array();
                                foreach ($unitQry->result() as $unitObj) {
                                    if ((int) $unitObj->stock_status == 1) {
                                        $unit_id = $unitObj->id;
                                        $unit_value = $unitObj->unit_value;
                                        if ($user_id != "") {
                                            $this->db->where('user_id', $user_id);
                                            $this->db->where('unit_id', $unit_id);
                                            $this->db->where('product_id', $product_id);
                                            $this->db->where('product_type', 1);
                                            $query = $this->db->get('cart');
                                            $this->db->last_query();
                                            if ($query->num_rows() > 0) {
                                                foreach ($query->result() as $row) {
                                                    $qtyCart = $row->qty;
                                                }
                                            } else {
                                                $qtyCart = "0";
                                            }
                                        } else {
                                            $qtyCart = "0";
                                        }
                                        $unitArr[$n]['cart_qty'] = $qtyCart;
                                        $unitArr[$n]['unit_id'] = $unitObj->id;
                                        $unitArr[$n]['unit_value'] = $unitObj->unit_value;
                                        $unit_name = $this->mainModel->getDataByField('name', 'unit', 'id', $unitObj->unit, 1);
                                        $unitArr[$n]['unit'] = $unitObj->unit_value . ' ' . $unit_name;
                                        $unitArr[$n]['unit_sales_price'] = $unitObj->unit_sales_price;
                                        $unitArr[$n]['unit_mrp'] = $unitObj->unit_mrp;
                                        $unit_sales_price = $unitObj->unit_sales_price;
                                        $unit_mrp = $unitObj->unit_mrp;
                                        $discount = $this->vendorModel->calculateDiscount($unit_mrp, $unit_sales_price);
                                        $unitArr[$n]['discount'] = $discount;
                                        $unitArr[$n]['stock_status'] = $unitObj->stock_status;

                                        // $data[$i]['unit'] = $unitObj->unit_value . ' ' . $unit_name;
                                        // $data[$i]['unit_sales_price'] = $unitObj->unit_sales_price;
                                        // $data[$i]['unit_mrp'] = $unitObj->unit_mrp;
                                        // $data[$i]['discount'] = $discount;
                                        $n++;
                                    }
                                }
                                if (count($unitArr) <= 0) {
                                    $unitArr = false;
                                }
                            } else {
                                $unitArr = false;
                            }
                            $data['unit_details'] = $unitArr;
                        }
                    }
                    if (count($data) > 0) {
                        if ($category_id != '') {
                            $product_id = $this->input->post('product_id');
                            $this->db->where('category', $category_id);
                            $this->db->where('status', 1);
                            $this->db->where_not_in('id', array($product_id));
                            $querySimilar = $this->db->get('product');
                            if ($querySimilar->num_rows() > 0) {
                                $s = 0;
                                foreach ($querySimilar->result() as $row) {
                                    $product_type = 1;
                                    $product_id = $row->id;
                                    $wishlist_status = 0;
                                    if ($user_id != "") {
                                        $checkWishList = getAllDataByVal('user_wishlist', array('user_id' => $user_id, 'product_id' => $product_id));
                                        if ($checkWishList->num_rows() > 0)
                                            $wishlist_status = 1;
                                    }
                                    $shop_type_id = $row->shop_type;
                                    $shop_type_name = getDataByVal('name', 'shop_type', array('id' => $shop_type_id));
                                    $shopTypeNameArr = explode(' ', $shop_type_name);
                                    if (in_array('Mobile', $shopTypeNameArr) != false || in_array('Electronics', $shopTypeNameArr) != false) {
                                        $unitQry = $this->vendorModel->getAllDataByVal('product_ram_rom_price', array('product_id' => $product_id, 'stock_status' => 1));
                                        $product_type = 2;
                                    } else {
                                        $unitQry = $this->vendorModel->getAllDataByVal('product_unit_stock_price', array('product_id' => $product_id, 'stock_status' => 1));
                                        $product_type = 1;
                                    }
                                    if ($unitQry->num_rows() > 0) {
                                        $category_id = $row->category;
                                        $dataSimilar[$s]['id'] = $product_id;
                                        $dataSimilar[$s]['name'] = $row->product_name;
                                        $dataSimilar[$s]['brand_id'] = $row->brand;
                                        $dataSimilar[$s]['brand_name'] = getDataByVal('name', 'brand', array('id' => $row->brand));

                                        $dataSimilar[$s]['product_type'] = $product_type;
                                        $dataSimilar[$s]['wishlist_status'] = $wishlist_status;

                                        if ($row->home_image != "") {
                                            $dataSimilar[$s]['home_image'] = base_url() . 'image/product/' . $row->home_image;
                                        } else {
                                            $dataSimilar[$s]['home_image'] = "";
                                        }

                                        if ($product_type == 2) {
                                            $whereArrUnit = array('product_id' => $product_id);
                                            $unitQry = $this->vendorModel->getAllDataByVal('product_ram_rom_price', $whereArrUnit);
                                            $n = 0;
                                            if ($unitQry->num_rows() > 0) {
                                                $unitArr = array();
                                                foreach ($unitQry->result() as $unitObj) {
                                                    if ((int) $unitObj->stock_status == 1) {
                                                        $unit_id = $unitObj->id;
                                                        $unit_value = $unitObj->ram_size;
                                                        if ($user_id != "") {
                                                            $this->db->where('user_id', $user_id);
                                                            $this->db->where('unit_id', $unit_id);
                                                            $this->db->where('product_id', $product_id);
                                                            $this->db->where('product_type', 2);
                                                            $query = $this->db->get('cart');
                                                            $this->db->last_query();
                                                            if ($query->num_rows() > 0) {
                                                                foreach ($query->result() as $row) {
                                                                    $qtyCart = $row->qty;
                                                                }
                                                            } else {
                                                                $qtyCart = "0";
                                                            }
                                                        } else {
                                                            $qtyCart = "0";
                                                        }
                                                        $unitArr[$n]['cart_qty'] = $qtyCart;
                                                        $unitArr[$n]['unit_id'] = $unitObj->id;
                                                        $unitArr[$n]['unit_ram'] = $unitObj->ram_size . ' ' . $unitObj->ram_size_type;
                                                        $unitArr[$n]['unit_rom'] = $unitObj->rom_size . ' ' . $unitObj->rom_size_type;
                                                        $unitArr[$n]['unit_sales_price'] = $unitObj->unit_sales_price;
                                                        $unitArr[$n]['unit_mrp'] = $unitObj->unit_mrp;
                                                        $unit_sales_price = $unitObj->unit_sales_price;
                                                        $unit_mrp = $unitObj->unit_mrp;
                                                        $discount = $this->vendorModel->calculateDiscount($unit_mrp, $unit_sales_price);
                                                        $unitArr[$n]['discount'] = $discount;

                                                        $dataSimilar[$s]['unit'] = $unitObj->ram_size . ' ' . $unitObj->ram_size_type;
                                                        $dataSimilar[$s]['unit_sales_price'] = $unitObj->unit_sales_price;
                                                        $dataSimilar[$s]['unit_mrp'] = $unitObj->unit_mrp;
                                                        $dataSimilar[$s]['discount'] = $discount;
                                                        $n++;
                                                    }
                                                }
                                                if (count($unitArr) <= 0) {
                                                    $unitArr = false;
                                                }
                                            } else {
                                                $unitArr = false;
                                            }
                                            $dataSimilar[$s]['unit_details'] = $unitArr;
                                        } else {
                                            $whereArrUnit = array('product_id' => $product_id);
                                            $unitQry = $this->vendorModel->getAllDataByVal('product_unit_stock_price', $whereArrUnit);
                                            $n = 0;
                                            if ($unitQry->num_rows() > 0) {
                                                $unitArr = array();
                                                foreach ($unitQry->result() as $unitObj) {
                                                    if ((int) $unitObj->stock_status == 1) {
                                                        $unit_id = $unitObj->id;
                                                        $unit_value = $unitObj->unit_value;
                                                        if ($user_id != "") {
                                                            $this->db->where('user_id', $user_id);
                                                            $this->db->where('unit_id', $unit_id);
                                                            $this->db->where('product_id', $product_id);
                                                            $this->db->where('product_type', 1);
                                                            $query = $this->db->get('cart');
                                                            $this->db->last_query();
                                                            if ($query->num_rows() > 0) {
                                                                foreach ($query->result() as $row) {
                                                                    $qtyCart = $row->qty;
                                                                }
                                                            } else {
                                                                $qtyCart = "0";
                                                            }
                                                        } else {
                                                            $qtyCart = "0";
                                                        }
                                                        $unitArr[$n]['cart_qty'] = $qtyCart;
                                                        $unitArr[$n]['unit_id'] = $unitObj->id;
                                                        $unitArr[$n]['unit_value'] = $unitObj->unit_value;
                                                        $unit_name = $this->mainModel->getDataByField('name', 'unit', 'id', $unitObj->unit, 1);
                                                        $unitArr[$n]['unit'] = $unitObj->unit_value . ' ' . $unit_name;
                                                        $unitArr[$n]['unit_sales_price'] = $unitObj->unit_sales_price;
                                                        $unitArr[$n]['unit_mrp'] = $unitObj->unit_mrp;
                                                        $unit_sales_price = $unitObj->unit_sales_price;
                                                        $unit_mrp = $unitObj->unit_mrp;
                                                        $discount = $this->vendorModel->calculateDiscount($unit_mrp, $unit_sales_price);
                                                        $unitArr[$n]['discount'] = $discount;

                                                        $dataSimilar[$s]['unit'] = $unitObj->unit_value . ' ' . $unit_name;
                                                        $dataSimilar[$s]['unit_sales_price'] = $unitObj->unit_sales_price;
                                                        $dataSimilar[$s]['unit_mrp'] = $unitObj->unit_mrp;
                                                        $dataSimilar[$s]['discount'] = $discount;
                                                        $n++;
                                                    }
                                                }
                                                if (count($unitArr) <= 0) {
                                                    $unitArr = false;
                                                }
                                            } else {
                                                $unitArr = false;
                                            }
                                            $dataSimilar[$s]['unit_details'] = $unitArr;
                                        }
                                        $s++;
                                    }
                                }
                            }
                        }
                    }

                    $res['status'] = true;
                    $res['rcode'] = 200;
                    $res['message'] = 'Data Found';
                    $res['data'] = $data;
                    $res['similar_product'] = $dataSimilar;
                } else {
                    $res['status'] = false;
                    $res['rcode'] = 500;
                    $res['message'] = 'Wrong Data';
                }
            } else {
                $res['status'] = false;
                $res['rcode'] = 500;
                $res['message'] = 'Product ID Is Required';
            }
        } else {
            $res = $userRes;
        }
        echo json_encode($res);
    }

    function sendOtp()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $vendor_id = $userRes['vendor_id'];
            if ($this->input->post('mobile_no') != "") {
                $otp = mt_rand(1111, 9999);
                $mobile_no = checkMobileFormate($this->input->post('mobile_no'));
                if ($mobile_no == 9999999999) {
                    $otp = 1234;
                }
                $user_id = getDataByVal('id', 'users', array('mobile_no' => $mobile_no));
                $message = 'Dear Participant, Your OTP is ' . $otp . ' is valid for 10 Minutes EPS';
                $this->sendMessage($user_id, $vendor_id, 'otp', $mobile_no, $message, $otp);
                if ($mobile_no != false) {
                    $data['status'] = true;
                    $data['rcode'] = 200;
                    $data['message'] = "OTP Successfully Sent On Mobile Number";
                    $data['otp'] = (int) $otp;
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 500;
                    $data['message'] = 'Wrong Mobile Number';
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 500;
                $data['message'] = 'Mobile Number Is Required';
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function login()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('email_or_mobile') != "" && $this->input->post('password') != "") {
                $isValidated = true;
                $email_or_mobile = emailCheck($this->input->post('email_or_mobile'));
                $password = password($this->input->post('password'));
                if ($email_or_mobile == false) {
                    $email_or_mobile = onlyNumber($this->input->post('email_or_mobile'));
                    if ($email_or_mobile == false) {
                        $isValidated = false;
                    }
                }

                if ($isValidated == true) {
                    $sql = "SELECT * FROM `users` WHERE (`email`='$email_or_mobile' OR `mobile_no`='$email_or_mobile') AND `password`='$password'";
                    $checkUser = $this->db->query($sql);
                    if ($checkUser->num_rows() > 0) {
                        $userObj = $checkUser->row();
                        $status = (int) $userObj->status;
                        if ($status == 1) {
                            $data['status'] = true;
                            $data['rcode'] = 200;
                            $data['message'] = 'Logged In Succsessfully';
                            $data['user_id'] = $userObj->id;
                            $data['full_name'] = $userObj->full_name;
                            $data['email'] = $userObj->email;
                            $data['mobile_no'] = $userObj->mobile_no;
                            $data['gender'] = $userObj->gender;
                            $data['dob'] = date('d-M-Y', strtotime($userObj->dob));
                        } else {
                            $data['status'] = false;
                            $data['rcode'] = 500;
                            $data['message'] = 'Inactive Profile !!';
                        }
                    } else {
                        $data['status'] = false;
                        $data['rcode'] = 500;
                        $data['message'] = 'Wrong Credentials';
                    }
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 500;
                    $data['message'] = 'Wrong Data';
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 500;
                $data['message'] = 'Required Fileds Cannot Be Empty';
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function signup()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('mobile_no') != "" && $this->input->post('email') != "" && $this->input->post('full_name') != "" && $this->input->post('gender') != "" && $this->input->post('dob') != "" && $this->input->post('password') != "") {
                $mobile_no = checkMobileFormate($this->input->post('mobile_no'));
                $email = emailCheck($this->input->post('email'));
                $full_name = onlyText($this->input->post('full_name'));
                $gender = onlyText($this->input->post('gender'));
                if ($mobile_no != false && $email != false && $full_name != false && $gender != false) {
                    $checkMobile = getAllDataByVal('users', array('mobile_no' => $mobile_no));
                    if ($checkMobile->num_rows() > 0) {
                        $data['status'] = false;
                        $data['rcode'] = 500;
                        $data['message'] = 'Mobile Number Already Registered';
                    } else {
                        $checkEmail = getAllDataByVal('users', array('email' => $email));
                        if ($checkEmail->num_rows() > 0) {
                            $data['status'] = false;
                            $data['rcode'] = 500;
                            $data['message'] = 'Email Already Registered';
                        } else {
                            $insData['full_name'] = $full_name;
                            $insData['mobile_no'] = $mobile_no;
                            $insData['email'] = $email;
                            $insData['gender'] = $gender;
                            $insData['dob'] = date('Y-m-d', strtotime($this->input->post('dob')));
                            $insData['password'] = password($this->input->post('password'));
                            $this->db->insert('users', $insData);
                            $user_id = $this->db->insert_id();
                            if ($user_id != '') {
                                $data['status'] = true;
                                $data['rcode'] = 200;
                                $data['message'] = 'Successfully Registered';
                                $data['user_id'] = $user_id;
                            } else {
                                $data['status'] = false;
                                $data['rcode'] = 500;
                                $data['message'] = 'Something Went Wrong !!!';
                            }
                        }
                    }
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 500;
                    $data['message'] = 'Wrong Data';
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 500;
                $data['message'] = 'Required Field Cannot Be Empty';
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function checkMobile()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('mobile_no') != "") {
                $mobile_no = checkMobileFormate($this->input->post('mobile_no'));
                if ($mobile_no != false) {
                    $otp = 1234;
                    $checkMobile = getAllDataByVal('users', array('mobile_no' => $mobile_no));
                    if ($checkMobile->num_rows() > 0) {
                        $data['status'] = false;
                        $data['rcode'] = 500;
                        $data['message'] = 'Mobile Already Registered !!!';
                    } else {
                        $data['status'] = true;
                        $data['rcode'] = 200;
                        $data['message'] = 'OTP successfully sent on your mobile number';
                        $data['otp'] = (int) $otp;
                    }
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 500;
                    $data['message'] = 'Wrong Mobile Number';
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 500;
                $data['message'] = 'Mobile Number Is Required';
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function checkEmail()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('email') != "") {
                $email = emailCheck($this->input->post('email'));
                if ($email != false) {
                    $otp = 1234;
                    $checkEmail = getAllDataByVal('users', array('email' => $email));
                    if ($checkEmail->num_rows() > 0) {
                        $data['status'] = false;
                        $data['rcode'] = 500;
                        $data['message'] = 'Email Already Registered !!!';
                    } else {
                        $data['status'] = true;
                        $data['rcode'] = 200;
                        $data['message'] = 'Email Verified';
                    }
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 500;
                    $data['message'] = 'Wrong Email';
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 500;
                $data['message'] = 'Email Is Required';
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }
}
