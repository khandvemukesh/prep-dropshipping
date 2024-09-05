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

    function addToCart()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $isValidated = true;
            $user_id = $this->checkTableField($this->input->post('user_id'), 'table_value', 'id', 'users');
            $product_id = $this->checkTableField($this->input->post('product_id'), 'table_value', 'id', 'product');
            $unit = $this->checkTableField($this->input->post('unit'), 'required');
            $product_type = $this->checkTableField($this->input->post('product_type'), 'required');
            if ($product_type == 2) {
                $unit_id = $this->checkTableField($this->input->post('unit_id'), 'table_value', 'id', 'product_ram_rom_price');
            } else {
                $unit_id = $this->checkTableField($this->input->post('unit_id'), 'table_value', 'id', 'product_unit_stock_price');
            }
            $unit_value = $this->checkTableField($this->input->post('unit_value'), 'required');
            $type = $this->checkTableField($this->input->post('type'), 'required');

            $cart_type = $this->checkTableField($this->input->post('cart_type'), 'required');

            if ($user_id == false) {
                $isValidated = false;
                $message = 'User ID Is Required';
            }

            if ($product_id == false) {
                $isValidated = false;
                $message = 'Product ID Is Required';
            }

            if ($unit == false) {
                $isValidated = false;
                $message = 'Unit Is Required';
            }

            if ($unit_id == false) {
                $isValidated = false;
                $message = 'Unit ID Is Required';
            }

            if ($unit_value == false) {
                $isValidated = false;
                $message = 'Unit Value Is Required';
            }

            if ($type == false) {
                $isValidated = false;
                $message = 'Type Is Required';
            }

            if ($product_type == false) {
                $isValidated = false;
                $message = 'Product Type Is Required';
            }

            if ($cart_type == false) {
                $isValidated = false;
                $message = 'Cart Type Is Required';
            }

            if ($isValidated == true) {
                $this->db->where('user_id', $user_id);
                $this->db->where('unit_id', $unit_id);
                $this->db->where('product_id', $product_id);
                $query = $this->db->get('cart');
                if ($query->num_rows() > 0) {
                    foreach ($query->result() as $row) {
                        $qty = (int) $row->qty;
                        if ($type == "add") {
                            $data['qty'] = $qty + 1;
                            $this->db->where('id', $row->id);
                            $this->db->update('cart', $data);
                            $message = 'Product Added To Cart';
                        } else {
                            if ($qty > 1) {
                                $data['qty'] = $qty - 1;
                                $this->db->where('id', $row->id);
                                $this->db->update('cart', $data);
                            } else {
                                $this->db->where('id', $row->id);
                                $this->db->delete('cart');
                            }
                            $message = 'Cart Quantity Decreased';
                        }
                    }
                } else {
                    $data['user_id'] = $user_id;
                    $data['product_id'] = $product_id;
                    $data['unit'] = $unit;
                    $data['unit_id'] = $unit_id;
                    $data['unit_value'] = $unit_value;
                    $data['product_type'] = $product_type;
                    $data['cart_type'] = $cart_type;
                    $data['qty'] = 1;
                    if ($this->input->post('color') != "") {
                        $data['color'] = $this->input->post('color');
                    }
                    if ($this->input->post('size') != "") {
                        $data['size'] = $this->input->post('size');
                    }
                    $data['date'] = sys_date();
                    $data['time'] = sys_time();
                    $data['status'] = 1;
                    $this->db->insert('cart', $data);
                    $message = 'Product Added To Cart';
                }

                $chargesArr = $this->getCharges();

                $resdata['cart_count'] = getSumData('cart', array('user_id' => $user_id, 'cart_type' => $cart_type), 'qty');
                $resdata['cart_item'] = getAllDataByVal('cart', array('user_id' => $user_id, 'cart_type' => $cart_type))->num_rows();
                $resdata['qty'] = getDataByVal('qty', 'cart', array('user_id' => $user_id, 'product_id' => $product_id, 'unit_id' => $unit_id));
                $resdata['total'] = $chargesArr['total_price'];
                $res['status'] = true;
                $res['rcode'] = 200;
                $res['message'] = $message;
                $res['data'] = $resdata;
            } else {
                $res['status'] = false;
                $res['rcode'] = 500;
                $res['message'] = $message;
            }
        } else {
            $res = $userRes;
        }
        echo json_encode($res);
    }

    function getCartCount()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $count = 0;
            $total_amount = 0;
            if ($this->input->post('user_id') != "" && $this->input->post('cart_type') != "") {
                $user_id = $this->input->post('user_id');
                $cart_type = $this->input->post('cart_type');
                if ($user_id != "") {
                    $this->db->where('cart_type', $cart_type);
                    $this->db->where('user_id', $user_id);
                    $query = $this->db->get('cart');
                    if ($query->num_rows() > 0) {
                        $data['status'] = true;
                        $data['rcode'] = 200;
                        $data['message'] = 'Cart Count Found';
                        foreach ($query->result() as $row) {
                            $product_type = $row->product_type;
                            if ($product_type == 2) {
                                $stock_status = (int) getDataByVal('stock_status', 'product_ram_rom_price', array('id' => $row->unit_id));
                                $unit_total_sales_price = (int) getDataByVal('unit_sales_price', 'product_ram_rom_price', array('id' => $row->unit_id));
                            } else {
                                $stock_status = (int) getDataByVal('stock_status', 'product_unit_stock_price', array('id' => $row->unit_id));
                                $unit_total_sales_price = (int) getDataByVal('unit_sales_price', 'product_unit_stock_price', array('id' => $row->unit_id));
                            }

                            if ($stock_status > 0) {
                                $product_id = $row->product_id;
                                $productData = getAllDataByVal('product', array('id' => $product_id));
                                if ($productData->num_rows() > 0) {
                                    $productObj = $productData->row();
                                    if ((int) $productObj->status == 1) {
                                        $count += $row->qty;
                                        $tot = $row->qty * $unit_total_sales_price;
                                        $total_amount += $tot;
                                    }
                                }
                            }
                        }
                        if ($this->input->post('unit_id') != "" && $this->input->post('product_type') != "") {
                            $unit_id = $this->input->post('unit_id');
                            $product_type = $this->input->post('product_type');
                            if ($unit_id != "" && $product_type != "") {
                                $qty = 0;
                                if ($product_type == 2) {
                                    $stock_status = (int) getDataByVal('stock_status', 'product_ram_rom_price', array('id' => $unit_id));
                                } else {
                                    $stock_status = (int) getDataByVal('stock_status', 'product_unit_stock_price', array('id' => $unit_id));
                                }
                                if ($stock_status > 0) {
                                    $product_id = $this->input->post('product_id');
                                    $unit_value = $this->input->post('unit_value');
                                    $this->db->where('user_id', $user_id);
                                    $this->db->where('unit_id', $unit_id);
                                    $this->db->where('unit_value', $unit_value);
                                    $this->db->where('product_id', $product_id);
                                    $query = $this->db->get('cart');
                                    if ($query->num_rows() > 0) {
                                        foreach ($query->result() as $row) {
                                            $qty = (int) $row->qty;
                                        }
                                    }
                                }
                                $data['data']['qty'] = $qty;
                            }
                        }

                        $data['data']['count'] = $count;
                        $data['data']['notification_count'] = $this->getNotificationCount();
                        $data['data']['total'] = $total_amount;
                    } else {
                        $data['status'] = false;
                        $data['rcode'] = 202;
                        $data['message'] = 'No data';
                        $data['data']['count'] = 0;
                        $data['data']['notification_count'] = $this->getNotificationCount();
                        $data['data']['total'] = 0;
                    }
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 202;
                    $data['message'] = 'User Id Is Required';
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 500;
                $data['message'] = 'Cart Type And User Id Is Required !!!';
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function viewCart()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "" && $this->input->post('cart_type') != "") {
                $res['check'] = false;
                $data = array();
                $user_id = $this->input->post('user_id');
                $cart_type = $this->input->post('cart_type');
                $total_amount = 0;
                $total_discount = 0;
                $total_mrp = 0;
                $total_gst = 0;
                if ($user_id != "") {
                    $this->db->where('cart_type', $cart_type);
                    $this->db->where('user_id', $user_id);
                    $queryCart = $this->db->get('cart');
                    if ($queryCart->num_rows() > 0) {
                        $res['check'] = true;
                        $i = 0;
                        foreach ($queryCart->result() as $rowCart) {
                            $product_id = $rowCart->product_id;
                            $product_type = $rowCart->product_type;
                            if ($product_type == 2) {
                                $stock_status = (int) getDataByVal('stock_status', 'product_ram_rom_price', array('id' => $rowCart->unit_id));
                            } else {
                                $stock_status = (int) getDataByVal('stock_status', 'product_unit_stock_price', array('id' => $rowCart->unit_id));
                            }

                            if ($stock_status == 1) {
                                $productStatusData = getAllDataByVal('product', array('id' => $product_id));
                                if ($productStatusData->num_rows() > 0) {
                                    $productStatusObj = $productStatusData->row();
                                    if ((int) $productStatusObj->status == 1) {
                                        $qty = $rowCart->qty;
                                        $data[$i]['qty'] = $rowCart->qty;
                                        $data[$i]['id'] = $rowCart->id;
                                        $data[$i]['unit'] = $rowCart->unit;
                                        $unit_id = $rowCart->unit_id;
                                        $unit_value = $rowCart->unit_value;
                                        $gst_type = getDataByVal('gst_type', 'product', array('id' => $product_id));
                                        $gst_percent = (int) getDataByVal('gst_percent', 'product', array('id' => $product_id));

                                        $data[$i]['unit_id'] = $rowCart->unit_id;
                                        $data[$i]['unit_value'] = $rowCart->unit_value;
                                        $data[$i]['color'] = ($rowCart->color != "") ? $rowCart->color : "";
                                        $data[$i]['size'] = ($rowCart->size != "") ? $rowCart->size : "";
                                        $data[$i]['product_type'] = $product_type;

                                        $this->db->where('product_id', $product_id);
                                        $this->db->where('id', $unit_id);
                                        if ($product_type == 2) {
                                            $queryUnit = $this->db->get('product_ram_rom_price');
                                        } else {
                                            $queryUnit = $this->db->get('product_unit_stock_price');
                                        }
                                        foreach ($queryUnit->result() as $rowUnit) {
                                            $unit_sales_price = (float) $rowUnit->unit_sales_price;
                                            $unit_mrp = $rowUnit->unit_mrp;
                                            $discount = $this->vendorModel->calculateDiscount($unit_mrp, $unit_sales_price);

                                            $unit_discount_price = $this->vendorModel->calculateDiscountPrice($unit_mrp, $unit_sales_price);

                                            $gst_price = $this->vendorModel->calculateGstPrice($unit_sales_price, $gst_percent, $gst_type);

                                            $unit_total_mrp = round($unit_mrp * $qty, 2);
                                            $unit_total_sales_price = round($unit_sales_price * $qty, 2);
                                            $unit_total_discount = round($unit_discount_price * $qty, 2);
                                            $unit_gst_price = round($gst_price * $qty, 2);

                                            $data[$i]['unit_sales_price'] = $rowUnit->unit_sales_price;
                                            $data[$i]['unit_mrp'] = $rowUnit->unit_mrp;
                                            $data[$i]['discount'] = $discount;
                                            $data[$i]['stock_status'] = (int) $rowUnit->stock_status;
                                            $data[$i]['gst_price'] = $unit_gst_price;
                                            $data[$i]['gst_percent'] = $gst_percent;

                                            $total_mrp += $unit_total_mrp;
                                            $total_amount += $unit_total_sales_price;
                                            $total_discount += $unit_total_discount;
                                            $total_gst += $unit_gst_price;
                                        }

                                        $this->db->where('id', $product_id);
                                        $query = $this->db->get('product');
                                        foreach ($query->result() as $row) {
                                            $data[$i]['product_id'] = $product_id;
                                            $data[$i]['name'] = $row->product_name;
                                            $data[$i]['title'] = $row->title;
                                            $data[$i]['category_id'] = $row->category;
                                            $data[$i]['category_name'] = $this->mainModel->getDataByField('name', 'category', 'id', $row->category, 1);
                                            $data[$i]['brand_name'] = getDataByVal('name', 'brand', array('id' => $row->brand));
                                            $data[$i]['sub_category_id'] = $row->sub_category;
                                            $data[$i]['sub_category_name'] = $this->mainModel->getDataByField('name', 'sub_category', 'id', $row->sub_category, 1);

                                            $data[$i]['home_image'] = base_url() . 'image/product/' . $row->home_image;
                                        }
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
                $this->db->where('min_value <', $total_amount);
                $this->db->where('max_value >', $total_amount);
                $this->db->where('status', 1);
                $deliveryChargeQry = $this->db->get('delivery_charges');
                if ($deliveryChargeQry->num_rows() > 0) {
                    foreach ($deliveryChargeQry->result() as $deliveryChargeObj) {
                        $delivery_charge = $deliveryChargeObj->delivery_charge;
                        if ($delivery_charge == 0) {
                            $delivery_charge_view = "Free";
                        } else {
                            $delivery_charge_view = $delivery_charge;
                        }
                    }
                } else {
                    $delivery_charge = 0;
                    $delivery_charge_view = "Free";
                }
                $sub_total = $total_amount;

                $cart_total = $total_amount;
                $saving = 0;

                $couponData = getAllDataByVal('user_applied_coupon', array('user_id' => $user_id));
                if ($couponData->num_rows() > 0) {
                    $couponObj = $couponData->row();
                    $minimum_order_value = getDataByVal('minimum_order_value', 'coupon', array('id' => $couponObj->coupon_id));

                    if ($cart_total >= $minimum_order_value) {
                        $coupon_percent = getDataByVal('coupon_percent', 'coupon', array('id' => $couponObj->coupon_id));
                        $maximum_coupon_value = getDataByVal('maximum_coupon_value', 'coupon', array('id' => $couponObj->coupon_id));

                        $saving = (float) ($cart_total * $coupon_percent) / 100;
                        if ($saving > $maximum_coupon_value) {
                            $saving = (float) $maximum_coupon_value;
                        }
                    }
                }
                $total_amount = $total_amount - $saving;
                $total_amount = $total_amount + $delivery_charge;
                $total_discount = $total_discount + $saving;

                $res['status'] = true;
                $res['rcode'] = 200;
                $res['message'] = 'Cart Data';

                $res['delivery_charge'] = $delivery_charge_view;
                $res['total_price'] = round($total_amount, 2);
                $res['sub_total'] = round($sub_total, 2);
                $res['total_mrp'] = round($total_mrp, 2);
                $res['coupon_discount'] = round($saving, 2);
                $res['total_discount'] = round($total_discount, 2);
                $res['total_gst'] = round($total_gst, 2);
                $res['upi_id'] = $this->mainModel->getDataByVal('upi_id', 'user', array('id' => $userRes['vendor_id']));
                $res['data'] = $data;
            } else {
                $res['status'] = false;
                $res['rcode'] = 200;
                $res['message'] = 'User ID and cart type is required !!!';
            }
        } else {
            $res = $userRes;
        }
        echo json_encode($res);
    }

    function getSlot()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $res = array();
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d', strtotime($start_date . ' + 2 days'));
            $res['status'] = true;
            $res['rcode'] = 200;
            $res['message'] = "Slots Found";
            $slotArr = array();
            $i = 0;
            while ($start_date <= $end_date) {
                $day = date('l', strtotime($start_date));
                $cur_date = date("Y-m-d");
                $this->db->where('day', $day);
                $this->db->where('status', 1);
                $query = $this->db->get('slot');
                $k = 0;
                $current_time = date("H:i", strtotime(sys_time() . "- 1 hour"));
                if ($query->num_rows() > 0) {
                    $arr = array();
                    foreach ($query->result() as $slotObj) {
                        if ($start_date == $cur_date) {
                            if ($slotObj->start_time > $current_time) {
                                $arr[$k]['time'] = date('H:i a', strtotime($slotObj->start_time)) . " - " . date('H:i a', strtotime($slotObj->end_time));
                                $arr[$k]['slot_id'] = $slotObj->id;
                                $arr[$k]['status'] = 1;
                                $k++;
                            }
                        } else {
                            $arr[$k]['time'] = date('H:i a', strtotime($slotObj->start_time)) . " - " . date('H:i a', strtotime($slotObj->end_time));
                            $arr[$k]['slot_id'] = $slotObj->id;
                            $arr[$k]['status'] = 1;
                            $k++;
                        }
                    }
                    $slotArr[$i]['date'] = date_conversion($start_date);
                    $slotArr[$i]['slots'] = $arr;
                    $i++;
                }
                $start_date = date('Y-m-d', strtotime($start_date . ' + 1 day'));
            }
            $res['data'] = $slotArr;
        } else {
            $res = $userRes;
        }
        echo json_encode($res);
    }

    function getSlotArr()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $res = array();
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d', strtotime($start_date . ' + 2 days'));
            $slotArr = array();
            $i = 0;
            while ($start_date <= $end_date) {
                $day = date('l', strtotime($start_date));
                $cur_date = date("Y-m-d");
                $this->db->where('day', $day);
                $this->db->where('status', 1);
                $query = $this->db->get('slot');
                $k = 0;
                $current_time = date("H:i", strtotime(sys_time() . "- 1 hour"));
                if ($query->num_rows() > 0) {
                    $arr = array();
                    foreach ($query->result() as $slotObj) {
                        if ($start_date == $cur_date) {
                            if ($slotObj->start_time > $current_time) {
                                $arr[$k]['time'] = date('H:i a', strtotime($slotObj->start_time)) . " - " . date('H:i a', strtotime($slotObj->end_time));
                                $arr[$k]['slot_id'] = $slotObj->id;
                                $arr[$k]['status'] = 1;
                                $k++;
                            }
                        } else {
                            $arr[$k]['time'] = date('H:i a', strtotime($slotObj->start_time)) . " - " . date('H:i a', strtotime($slotObj->end_time));
                            $arr[$k]['slot_id'] = $slotObj->id;
                            $arr[$k]['status'] = 1;
                            $k++;
                        }
                    }
                    $slotArr[$i]['date'] = date_conversion($start_date);
                    $slotArr[$i]['slots'] = $arr;
                    $i++;
                }
                $start_date = date('Y-m-d', strtotime($start_date . ' + 1 day'));
            }
            $res = $slotArr;
        } else {
            $res = $userRes;
        }
        return $res;
    }

    function addAddress()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $isValidated = true;
            if ($this->input->post('user_id') != "") {
                $user_id = $this->input->post('user_id');
                $checkUserId = getAllDataByVal('users', array('id' => $user_id));
                if ($checkUserId->num_rows() > 0) {
                    $data['user_id'] = validate($this->input->post('user_id'));
                    $data['pincode'] = validate($this->input->post('pincode'));
                    $data['address'] = validate($this->input->post('address'));
                    $data['name'] = validate($this->input->post('name'));
                    $data['email'] = validate($this->input->post('email'));
                    $data['mobile_no'] = validate($this->input->post('mobile_no'));
                    $data['street_address'] = validate($this->input->post('street_address'));
                    $data['house_no'] = validate($this->input->post('house_no'));
                    $data['address_type'] = validate($this->input->post('address_type'));
                    $data['state'] = validate($this->input->post('state'));
                    $data['city'] = validate($this->input->post('city'));
                    $data['status'] = 1;
                    $data['date'] = sys_date();
                    $data['time'] = sys_time();
                    $this->db->insert('users_address', $data);
                    $address_id = $this->db->insert_id();
                    $check_user_primary_add = getDataByVal('primary_address', 'users', array('id' => $user_id));
                    if ($check_user_primary_add == "" || $check_user_primary_add == 0) {
                        $upArr['primary_address'] = $address_id;
                        $this->db->where('id', $user_id);
                        $this->db->update('users', $upArr);
                    }
                    $res['status'] = true;
                    $res['rcode'] = 200;
                    $res['message'] = 'Address Successfully Added';
                    $res['address_id'] = $address_id;
                } else {
                    $res['status'] = false;
                    $res['rcode'] = 201;
                    $res['message'] = 'Wrong User ID.';
                }
            } else {
                $res['status'] = false;
                $res['rcode'] = 201;
                $res['message'] = 'User ID Is Required';
            }
        } else {
            $res = $userRes;
        }
        echo json_encode($res);
    }

    function editAddress()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $isValidated = true;
            if ($this->input->post('user_id') != "") {
                $user_id = $this->input->post('user_id');
                $checkUserId = getAllDataByVal('users', array('id' => $user_id));
                if ($checkUserId->num_rows() > 0) {
                    $id = $this->input->post('address_id');
                    $checkId = getAllDataByVal('users_address', array('id' => $id));
                    if ($checkId->num_rows() > 0) {
                        $data['user_id'] = $this->input->post('user_id');
                        $data['pincode'] = $this->input->post('pincode');
                        $data['address'] = $this->input->post('address');
                        $data['name'] = $this->input->post('name');
                        $data['email'] = $this->input->post('email');
                        $data['mobile_no'] = $this->input->post('mobile_no');
                        $data['street_address'] = $this->input->post('street_address');
                        $data['house_no'] = $this->input->post('house_no');
                        $data['address_type'] = $this->input->post('address_type');
                        $data['state'] = $this->input->post('state');
                        $data['city'] = $this->input->post('city');
                        $data['status'] = 1;
                        $data['date'] = sys_date();
                        $data['time'] = sys_time();
                        $this->db->where('id', $id);
                        $this->db->update('users_address', $data);
                        $res['status'] = true;
                        $res['rcode'] = 200;
                        $res['message'] = 'Address Successfully Updated.';
                    } else {
                        $res['status'] = false;
                        $res['rcode'] = 201;
                        $res['message'] = 'Wrong ID.';
                    }
                } else {
                    $res['status'] = false;
                    $res['rcode'] = 201;
                    $res['message'] = 'Wrong User ID.';
                }
            } else {
                $res['status'] = false;
                $res['rcode'] = 201;
                $res['message'] = 'User ID Is Required';
            }
        } else {
            $res = $userRes;
        }
        echo json_encode($res);
    }

    function getAddress()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $isValidated = true;
            if ($this->input->post('user_id') != "") {
                $user_id = $this->input->post('user_id');
                $checkUserId = getAllDataByVal('users', array('id' => $user_id));
                if ($checkUserId->num_rows() > 0) {
                    $primary_address = getDataByVal('primary_address', 'users', array('id' => $user_id));
                    $whereArrAddress = array('user_id' => $user_id, 'status' => 1);
                    $query = $this->vendorModel->getAllDataByVal('users_address', $whereArrAddress);
                    if ($query->num_rows() > 0) {
                        $i = 0;
                        foreach ($query->result() as $addressObj) {

                            $data[$i]['id'] = $addressObj->id;
                            $data[$i]['pincode'] = $addressObj->pincode;
                            $data[$i]['address'] = $addressObj->address;
                            $data[$i]['name'] = $addressObj->name;
                            $data[$i]['email'] = $addressObj->email;
                            $data[$i]['mobile_no'] = $addressObj->mobile_no;
                            $data[$i]['street_address'] = $addressObj->street_address;
                            $data[$i]['house_no'] = $addressObj->house_no;
                            $data[$i]['address_type'] = $addressObj->address_type;
                            $data[$i]['is_primary'] = ($primary_address == $addressObj->id) ? true : false;
                            $i++;
                        }
                        $res['status'] = true;
                        $res['rcode'] = 200;
                        $res['message'] = 'Data Found';
                        $res['data'] = $data;
                    } else {
                        $res['status'] = false;
                        $res['rcode'] = 201;
                        $res['message'] = 'No Data Found';
                    }
                } else {
                    $res['status'] = false;
                    $res['rcode'] = 201;
                    $res['message'] = 'Wrong User ID.';
                }
            } else {
                $res['status'] = false;
                $res['rcode'] = 201;
                $res['message'] = 'User ID Is Required';
            }
        } else {
            $res = $userRes;
        }
        echo json_encode($res);
    }

    function setPrimary()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $isValidated = true;
            if ($this->input->post('user_id') != "") {
                $user_id = $this->input->post('user_id');
                $checkUserId = getAllDataByVal('users', array('id' => $user_id));
                if ($checkUserId->num_rows() > 0) {
                    $address_id = $this->input->post('address_id');
                    $whereArrAddress = array('id' => $address_id);
                    $query = $this->vendorModel->getAllDataByVal('users_address', $whereArrAddress);
                    if ($query->num_rows() > 0) {
                        $i = 0;
                        $this->db->where('id', $user_id);
                        $addDelete = $this->db->update('users', array('primary_address' => $address_id));
                        if ($addDelete) {
                            $res['status'] = true;
                            $res['rcode'] = 200;
                            $res['message'] = 'Addedd As Primary';
                        } else {
                            $res['status'] = false;
                            $res['rcode'] = 500;
                            $res['message'] = 'Something Went Wrong';
                        }
                    } else {
                        $res['status'] = false;
                        $res['rcode'] = 201;
                        $res['message'] = 'Wrong Address';
                    }
                } else {
                    $res['status'] = false;
                    $res['rcode'] = 201;
                    $res['message'] = 'Wrong User ID.';
                }
            } else {
                $res['status'] = false;
                $res['rcode'] = 201;
                $res['message'] = 'User ID Is Required';
            }
        } else {
            $res = $userRes;
        }
        echo json_encode($res);
    }

    function removeAddress()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "") {
                $user_id = $this->input->post('user_id');
                $checkUserId = getAllDataByVal('users', array('id' => $user_id));
                if ($checkUserId->num_rows() > 0) {
                    $address_id = $this->input->post('address_id');
                    $check_primary_address = getDataByVal('primary_address', 'users', array('id' => $user_id));
                    if ($address_id == $check_primary_address) {
                        $upArr['primary_address'] = "";
                        $this->db->where('id', $user_id);
                        $this->db->update('users', $upArr);
                    }
                    $whereArrAddress = array('id' => $address_id);
                    $query = $this->vendorModel->getAllDataByVal('users_address', $whereArrAddress);
                    if ($query->num_rows() > 0) {
                        $i = 0;
                        $this->db->where('id', $address_id);
                        $addDelete = $this->db->update('users_address', array('status' => 0));
                        if ($addDelete) {
                            $res['status'] = true;
                            $res['rcode'] = 200;
                            $res['message'] = 'Address Successfully Removed';
                        } else {
                            $res['status'] = false;
                            $res['rcode'] = 500;
                            $res['message'] = 'Something Went Wrong';
                        }
                    } else {
                        $res['status'] = false;
                        $res['rcode'] = 201;
                        $res['message'] = 'Wrong Address';
                    }
                } else {
                    $res['status'] = false;
                    $res['rcode'] = 201;
                    $res['message'] = 'Wrong User ID.';
                }
            } else {
                $res['status'] = false;
                $res['rcode'] = 201;
                $res['message'] = 'User ID Is Required';
            }
        } else {
            $res = $userRes;
        }
        echo json_encode($res);
    }

    function getBanner()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $data = array();
            if ($this->input->post('category_id') != "") {
                $category_id = $this->input->post('category_id');
                $this->db->where('category_id', $category_id);
            }
            if ($this->input->post('position') != "") {
                $position = $this->input->post('position');
                $this->db->where('position', $position);
            }
            $this->db->where('status', 1);
            $query = $this->db->get('banner');
            if ($query->num_rows() > 0) {
                $i = 0;
                foreach ($query->result() as $offersObj) {
                    $data[$i]['id'] = $offersObj->id;
                    $data[$i]['image'] = base_url() . 'image/banner/' . $offersObj->image;
                    $data[$i]['position'] = $offersObj->position;
                    $i++;
                }
            } else {
                $data = false;
            }
            $res['data'] = $data;
        } else {
            $res = $userRes;
        }
        echo json_encode($res);
    }

    function getCoupon()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "") {
                $user_id = $this->input->post('user_id');
                $userData = getAllDataByVal('users', array('id' => $user_id));
                $cart_total = getCartTotal($user_id);
                $no_of_order_user = getAllDataByVal('order_overview', array('user_id' => $user_id))->num_rows();
                if ($userData->num_rows() > 0) {
                    $this->db->where('status', '1');
                    $queryCoupon = $this->db->get('coupon');
                    if ($queryCoupon->num_rows() > 0) {
                        $i = 0;
                        $data['status'] = true;
                        $data['rcode'] = 200;
                        $data['message'] = "Data Found";
                        foreach ($queryCoupon->result() as $rowCoupon) {
                            $response[$i]['coupon_id'] = $rowCoupon->id;
                            $response[$i]['coupon_name'] = $rowCoupon->coupon_name;
                            $response[$i]['coupon_code'] = $rowCoupon->coupon_code;
                            $response[$i]['discount_percent'] = $rowCoupon->coupon_percent;
                            $response[$i]['minimum_order_value'] = $rowCoupon->minimum_order_value;
                            $response[$i]['maximum_coupon_value'] = $rowCoupon->maximum_coupon_value;
                            $response[$i]['description'] = $rowCoupon->description;
                            $minimum_order_value = $rowCoupon->minimum_order_value;
                            if ($cart_total > $minimum_order_value) {
                                $coupon_percent = $rowCoupon->coupon_percent;
                                $saving = (float) ($cart_total * $coupon_percent) / 100;
                                if ($saving > $rowCoupon->maximum_coupon_value) {
                                    $saving = (float) $rowCoupon->maximum_coupon_value;
                                }
                                if ($rowCoupon->coupon_for == 1) {
                                    $response[$i]['apply_status'] = true;
                                    $response[$i]['apply_message'] = "You will save " . $saving;
                                    $response[$i]['saving'] = $saving;
                                } elseif ($rowCoupon->coupon_for == 2) {
                                    if ($no_of_order_user == 0) {
                                        $response[$i]['apply_status'] = true;
                                        $response[$i]['apply_message'] = "You will save " . $saving;
                                        $response[$i]['saving'] = $saving;
                                    } else {
                                        $response[$i]['apply_status'] = false;
                                        $response[$i]['apply_message'] = "Valid for 1st order only";
                                        $response[$i]['saving'] = 0;
                                    }
                                } elseif ($rowCoupon->coupon_for == 3) {
                                    if ($no_of_order_user < 3) {
                                        $response[$i]['apply_status'] = true;
                                        $response[$i]['apply_message'] = "You will save " . $saving;
                                        $response[$i]['saving'] = $saving;
                                    } else {
                                        $response[$i]['apply_status'] = false;
                                        $response[$i]['apply_message'] = "Valid for first 3 order only";
                                        $response[$i]['saving'] = 0;
                                    }
                                } elseif ($rowCoupon->coupon_for == 4) {
                                    if ($no_of_order_user < 3) {
                                        $response[$i]['apply_status'] = true;
                                        $response[$i]['apply_message'] = "You will save " . $saving;
                                        $response[$i]['saving'] = $saving;
                                    } else {
                                        $response[$i]['apply_status'] = false;
                                        $response[$i]['apply_message'] = "Valid for first 3 order only";
                                        $response[$i]['saving'] = 0;
                                    }
                                } else {
                                    $response[$i]['apply_status'] = false;
                                    $response[$i]['apply_message'] = "Not a valid coupon";
                                    $response[$i]['saving'] = 0;
                                }
                            } else {
                                $remaining_difference = $minimum_order_value - $cart_total;
                                $response[$i]['apply_status'] = false;
                                $response[$i]['apply_message'] = "Add items worth " . $remaining_difference . " more.";
                                $response[$i]['saving'] = 0;
                            }
                            $couponAppliedData = getAllDataByVal('user_applied_coupon', array('user_id' => $user_id, 'coupon_id' => $rowCoupon->id));
                            if ($couponAppliedData->num_rows() > 0) {
                                if ($response[$i]['apply_status'] == true) {
                                    $applied_status = true;
                                } else {
                                    $applied_status = false;
                                }
                            } else {
                                $applied_status = false;
                            }
                            $response[$i]['applied_status'] = $applied_status;
                            $i++;
                        }
                        $data['data'] = $response;
                    } else {
                        $data['status'] = true;
                        $data['rcode'] = 201;
                        $data['message'] = "No Coupon To Show";
                    }
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 201;
                    $data['message'] = "Not a valid user !!";
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 201;
                $data['message'] = "Some fileds Are Missing";
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function setCoupon()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "" && $this->input->post('coupon_id') != "") {
                $user_id = $this->input->post('user_id');
                $coupon_id = $this->input->post('coupon_id');
                $couponData = getAllDataByVal('user_applied_coupon', array('user_id' => $user_id));
                if ($couponData->num_rows() > 0) {
                    $couponObj = $couponData->row();
                    $applied_coupon_id = $couponObj->id;
                    $updateData['coupon_id'] = $coupon_id;
                    $updateData['date'] = sys_date();
                    $updateData['time'] = sys_time();
                    $this->db->where('id', $applied_coupon_id);
                    $queryUpdate = $this->db->update('user_applied_coupon', $updateData);
                    if ($queryUpdate) {
                        $data['status'] = true;
                        $data['rcode'] = 200;
                        $data['message'] = "Coupon Successfully Applied";
                    } else {
                        $data['status'] = false;
                        $data['rcode'] = 500;
                        $data['message'] = "Something went wrong";
                    }
                } else {
                    $insertData['user_id'] = $user_id;
                    $insertData['coupon_id'] = $coupon_id;
                    $insertData['date'] = sys_date();
                    $insertData['time'] = sys_time();
                    $queryInsert = $this->db->insert('user_applied_coupon', $insertData);
                    if ($queryInsert) {
                        $data['status'] = true;
                        $data['rcode'] = 200;
                        $data['message'] = "Coupon Successfully Applied";
                    } else {
                        $data['status'] = false;
                        $data['rcode'] = 500;
                        $data['message'] = "Something went wrong";
                    }
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 201;
                $data['message'] = "Some fileds Are Missing";
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function removeCoupon()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "" && $this->input->post('coupon_id') != "") {
                $user_id = $this->input->post('user_id');
                $coupon_id = $this->input->post('coupon_id');
                $couponData = getAllDataByVal('user_applied_coupon', array('user_id' => $user_id));
                if ($couponData->num_rows() > 0) {
                    $couponObj = $couponData->row();
                    $applied_coupon_id = $couponObj->id;
                    $this->db->where('id', $applied_coupon_id);
                    $queryUpdate = $this->db->delete('user_applied_coupon');
                    if ($queryUpdate) {
                        $data['status'] = true;
                        $data['rcode'] = 200;
                        $data['message'] = "Coupon Successfully Removed";
                    } else {
                        $data['status'] = false;
                        $data['rcode'] = 500;
                        $data['message'] = "Something went wrong";
                    }
                } else {
                    $data['status'] = true;
                    $data['rcode'] = 200;
                    $data['message'] = "No Coupon Applied";
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 201;
                $data['message'] = "Some fileds Are Missing";
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function getAppliedCoupon()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "") {
                $user_id = $this->input->post('user_id');
                $cart_total = getCartTotal($user_id);
                $cart_original_total = getCartOriginalTotal($user_id);
                $couponData = getAllDataByVal('user_applied_coupon', array('user_id' => $user_id));
                $i = 0;
                if ($couponData->num_rows() > 0) {
                    $couponObj = $couponData->row();
                    $minimum_order_value = getDataByVal('minimum_order_value', 'coupon', array('id' => $couponObj->coupon_id));
                    if ($cart_total >= $minimum_order_value) {
                        $coupon_name = getDataByVal('coupon_name', 'coupon', array('id' => $couponObj->coupon_id));
                        $coupon_percent = getDataByVal('coupon_percent', 'coupon', array('id' => $couponObj->coupon_id));
                        $maximum_coupon_value = getDataByVal('maximum_coupon_value', 'coupon', array('id' => $couponObj->coupon_id));

                        $saving = (float) ($cart_total * $coupon_percent) / 100;
                        if ($saving > $maximum_coupon_value) {
                            $saving = (float) $maximum_coupon_value;
                        }
                        $response['status'] = true;
                        $response['rcode'] = 200;
                        $response['message'] = 'Coupon ' . $coupon_name . ' Successfully Applied.';
                        $response['data']['coupon_name'] = $coupon_name;
                        $response['data']['discount'] = $saving;
                        $response['data']['type'] = 1; // coupon type is 1
                    } else {
                        $coupon_name = getDataByVal('coupon_name', 'coupon', array('id' => $couponObj->coupon_id));
                        $remaining_difference = $minimum_order_value - $cart_total;
                        $response['status'] = true;
                        $response['rcode'] = 201;
                        $response['message'] = "Add items worth " . $remaining_difference . " more.";
                        $response['data']['coupon_name'] = $coupon_name;
                        $response['data']['discount'] = 0;
                        $response['data']['type'] = 1; // coupon type is 1
                    }
                    $i++;
                }
                if ($couponData->num_rows() == 0) {
                    $data['status'] = false;
                    $data['rcode'] = 201;
                    $data['message'] = "No Coupon And Offer Applied";
                } else {
                    $data = $response;
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 201;
                $data['message'] = "Some fileds Are Missing";
            }
        } else {
            $data = $userRes;
        }
        return $data;
    }

    function getCharges()
    {
        $user_id = $this->input->post('user_id');
        $cart_type = $this->input->post('cart_type');
        $total_amount = 0;
        $total_discount = 0;
        $total_mrp = 0;
        $total_gst = 0;
        $sub_total = 0;
        if ($user_id != "" && $cart_type != "") {
            $this->db->where('cart_type', $cart_type);
            $this->db->where('user_id', $user_id);
            $queryCart = $this->db->get('cart');
            if ($queryCart->num_rows() > 0) {
                $i = 0;
                foreach ($queryCart->result() as $rowCart) {
                    $product_id = $rowCart->product_id;
                    $product_type = $rowCart->product_type;
                    if ($product_type == 2) {
                        $stock_status = (int) getDataByVal('stock_status', 'product_ram_rom_price', array('id' => $rowCart->unit_id));
                    } else {
                        $stock_status = (int) getDataByVal('stock_status', 'product_unit_stock_price', array('id' => $rowCart->unit_id));
                    }
                    if ($stock_status == 1) {
                        $productStatusData = getAllDataByVal('product', array('id' => $product_id));
                        if ($productStatusData->num_rows() > 0) {
                            $productStatusObj = $productStatusData->row();
                            if ((int) $productStatusObj->status == 1) {
                                $qty = $rowCart->qty;
                                $unit_id = $rowCart->unit_id;
                                $unit_value = $rowCart->unit_value;
                                $gst_type = getDataByVal('gst_type', 'product', array('id' => $product_id));
                                $gst_percent = (int) getDataByVal('gst_percent', 'product', array('id' => $product_id));

                                $this->db->where('product_id', $product_id);
                                $this->db->where('id', $unit_id);
                                //$this->db->where('unit_value', $unit_value);
                                if ($product_type == 2) {
                                    $queryUnit = $this->db->get('product_ram_rom_price');
                                } else {
                                    $queryUnit = $this->db->get('product_unit_stock_price');
                                }
                                foreach ($queryUnit->result() as $rowUnit) {
                                    $unit_sales_price = (float) $rowUnit->unit_sales_price;
                                    $unit_mrp = $rowUnit->unit_mrp;
                                    $discount = $this->vendorModel->calculateDiscount($unit_mrp, $unit_sales_price);

                                    $unit_discount_price = $this->vendorModel->calculateDiscountPrice($unit_mrp, $unit_sales_price);

                                    $gst_price = $this->vendorModel->calculateGstPrice($unit_sales_price, $gst_percent, $gst_type);

                                    $unit_total_mrp = round($unit_mrp * $qty, 2);
                                    $unit_total_sales_price = round($unit_sales_price * $qty, 2);
                                    $unit_total_discount = round($unit_discount_price * $qty, 2);
                                    $unit_gst_price = round($gst_price * $qty, 2);

                                    if ($gst_type == 'excluded') {
                                        $sub_total += $unit_total_sales_price;
                                        $unit_total_with_gst = $unit_total_sales_price + $unit_gst_price;
                                        $total_amount += $unit_total_with_gst;
                                    } else {
                                        $unit_total_without_gst = $unit_total_sales_price - $unit_gst_price;
                                        $sub_total += $unit_total_without_gst;
                                        $total_amount += $unit_total_sales_price;
                                    }
                                    $total_mrp += $unit_total_mrp;
                                    $total_discount += $unit_total_discount;
                                    $total_gst += $unit_gst_price;
                                }
                                $i++;
                            }
                        }
                    }
                }
            }
        }
        $this->db->where('min_value <', $total_amount);
        $this->db->where('max_value >', $total_amount);
        $this->db->where('status', 1);
        $deliveryChargeQry = $this->db->get('delivery_charges');
        if ($deliveryChargeQry->num_rows() > 0) {
            foreach ($deliveryChargeQry->result() as $deliveryChargeObj) {
                $delivery_charge = $deliveryChargeObj->delivery_charge;
                if ($delivery_charge == 0) {
                    $delivery_charge_view = "Free";
                } else {
                    $delivery_charge_view = $delivery_charge;
                }
            }
        } else {
            $delivery_charge = 0;
            $delivery_charge_view = "Free";
        }

        $cart_total = $total_amount;
        $saving = 0;

        $couponData = getAllDataByVal('user_applied_coupon', array('user_id' => $user_id));
        if ($couponData->num_rows() > 0) {
            $couponObj = $couponData->row();
            $minimum_order_value = getDataByVal('minimum_order_value', 'coupon', array('id' => $couponObj->coupon_id));

            if ($cart_total >= $minimum_order_value) {
                $coupon_percent = getDataByVal('coupon_percent', 'coupon', array('id' => $couponObj->coupon_id));
                $maximum_coupon_value = getDataByVal('maximum_coupon_value', 'coupon', array('id' => $couponObj->coupon_id));

                $saving = (float) ($cart_total * $coupon_percent) / 100;
                if ($saving > $maximum_coupon_value) {
                    $saving = (float) $maximum_coupon_value;
                }
            }
        }
        $total_amount = $total_amount - $saving;
        $total_amount = $total_amount + $delivery_charge;
        $total_discount = $total_discount + $saving;

        $res['status'] = true;
        $res['rcode'] = 200;
        $res['message'] = 'Cart Data';

        $res['delivery_charge'] = $delivery_charge_view;
        $res['total_price'] = round($total_amount, 2);
        $res['sub_total'] = round($sub_total, 2);
        $res['total_mrp'] = round($total_mrp, 2);
        $res['coupon_discount'] = round($saving, 2);
        $res['total_discount'] = round($total_discount, 2);
        $res['total_gst'] = round($total_gst, 2);

        return $res;
    }

    function getCartDetails()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "") {
                $user_id = $this->input->post('user_id');
                $address_id = getDataByVal('primary_address', 'users', array('id' => $user_id));
                $addressData = getAllDataByVal('users_address', array('id' => $address_id));
                if ($addressData->num_rows() > 0) {
                    $addressObj = $addressData->row();
                    $addressArr['id'] = $addressObj->id;
                    $addressArr['pincode'] = $addressObj->pincode;
                    $addressArr['address'] = $addressObj->address;
                    $addressArr['name'] = $addressObj->name;
                    $addressArr['email'] = $addressObj->email;
                    $addressArr['mobile_no'] = $addressObj->mobile_no;
                    $addressArr['street_address'] = $addressObj->street_address;
                    $addressArr['house_no'] = $addressObj->house_no;
                    $addressArr['address_type'] = $addressObj->address_type;
                    $addressArr['is_primary'] = ($address_id == $addressObj->id) ? true : false;
                } else {
                    $addressArr = new stdClass();
                }
                $data['status'] = true;
                $data['message'] = 'Data Found';
                $data['rcode'] = 200;
                $data['charges'] = $this->getCharges();
                $data['applied_coupon'] = $this->getAppliedCoupon();
                $data['slot'] = $this->getSlotArr();
                $data['primary_address'] = $addressArr;
                $upi_id = $this->mainModel->getDataByVal('upi_id', 'user', array('id' => $userRes['vendor_id']));
                $delivery_option = $this->mainModel->getDataByVal('delivery_option', 'user', array('id' => $userRes['vendor_id']));
                $delivery_status = false;
                $pickup_status = false;
                if ($delivery_option == "delivery") {
                    $delivery_status = true;
                } elseif ($delivery_option == "pickup") {
                    $pickup_status = true;
                } elseif ($delivery_option == "both") {
                    $delivery_status = true;
                    $pickup_status = true;
                }
                $cod_status = $this->mainModel->getDataByVal('cod_status', 'user', array('id' => $userRes['vendor_id']));
                $online_status = $this->mainModel->getDataByVal('online_status', 'user', array('id' => $userRes['vendor_id']));
                $upi_status = $this->mainModel->getDataByVal('upi_status', 'user', array('id' => $userRes['vendor_id']));
                $data['payment_methods'] = array('cod' => $cod_status, 'online' => $online_status, 'upi' => $upi_status, 'upi_id' => $upi_id, 'delivery_status' => $delivery_status, 'pickup_status' => $pickup_status);
            } else {
                $data['status'] = false;
                $data['message'] = 'User ID Is Required';
                $data['rcode'] = 201;
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function addSalesDetails()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $isValidated = true;
            $vendor_id = $userRes['vendor_id'];
            $razorpay_account_id = $this->mainModel->getDataByVal('razorpay_account_id', 'user', array('id' => $vendor_id));
            $vendor_name = $this->mainModel->getDataByVal('full_name', 'user', array('id' => $vendor_id));
            if ($this->input->post('user_id') != "" && $this->input->post('cart_type') != "") {
                $user_id = $this->input->post('user_id');
                $cart_type = $this->input->post('cart_type');
                $checkUserId = getAllDataByVal('users', array('id' => $user_id));
                if ($checkUserId->num_rows() > 0) {
                    $address_status = true;
                    $address_id = 0;
                    $delivery_type = 0;

                    if ($this->input->post('address_id') == '') {
                        $address_status = false;
                    } else {
                        $address_id = $this->input->post('address_id');
                        $checkAddressId = getAllDataByVal('users_address', array('id' => $address_id));
                        if ($checkAddressId->num_rows() <= 0)
                            $address_status = false;
                    }

                    if ($address_status == true) {
                        $res = false;
                        $total_amount = 0;
                        $total_discount = 0;
                        $total_gst = 0;
                        $total_rate = 0;
                        $total_mrp = 0;
                        $saving = 0;
                        $user_id = $this->input->post('user_id');
                        $address_id = $this->input->post('address_id');
                        //$slot_id = 1;
                        $payment_mode = strtolower($this->input->post('payment_mode'));
                        if ($payment_mode != "" && ($payment_mode == "cod" || $payment_mode == "online" || $payment_mode == "upi")) {
                            if ($payment_mode == "cod") {
                                $payment_status = 0;
                            } else {
                                $payment_status = 1;
                            }
                            $payment_details = $this->input->post('payment_details');
                            if ($cart_type == "ecommerce") {
                                $delivery_date = date("Y-m-d", strtotime(sys_date() . '+ 5 days'));
                                $slot_id = '';
                            } else {
                                $delivery_date = $this->input->post('delivery_date');
                                $slot_id = $this->input->post('slot_id');
                            }
                            $cur_date = date('Y-m-d');
                            if ($delivery_date != "") {
                                $delivery_date = date('Y-m-d', strtotime($delivery_date));
                                if ($delivery_date >= $cur_date) {
                                    $order_from = $this->input->post('order_from');
                                    if ($user_id != "") {
                                        $this->db->where('cart_type', $cart_type);
                                        $this->db->where('user_id', $user_id);
                                        $queryCart = $this->db->get('cart');
                                        if ($queryCart->num_rows() > 0) {
                                            $res['check'] = true;
                                            $i = 0;
                                            foreach ($queryCart->result() as $rowCart) {
                                                $qty = $rowCart->qty;
                                                $unit_id = $rowCart->unit_id;
                                                $unit_value = $rowCart->unit_value;
                                                $product_id = $rowCart->product_id;
                                                $product_type = $rowCart->product_type;
                                                $productDataMain = getAllDataByVal('product', array('id' => $product_id));
                                                if ($productDataMain->num_rows() > 0) {
                                                    $productObjMain = $productDataMain->row();
                                                    if ((int) $productObjMain->status == 1) {
                                                        $productGstArr = array('id' => $product_id);

                                                        $gst_type = $this->vendorModel->getDataByVal('gst_type', 'product', $productGstArr);
                                                        $gst_percent = $this->vendorModel->getDataByVal('gst_percent', 'product', $productGstArr);

                                                        $priceArr = $this->vendorModel->getProductPrice($qty, $product_id, $unit_id, $unit_value, $gst_percent, $gst_type, $product_type);
                                                        if (count($priceArr) > 0) {
                                                            $total_amount += $priceArr[0];
                                                            $total_discount += $priceArr[1];
                                                            $total_rate += $priceArr[2];
                                                            $total_gst += $priceArr[3];
                                                            $total_mrp += $priceArr[6];
                                                        }
                                                    }
                                                }
                                                $i++;
                                            }
                                            $whereArrRewardPoint = array('status' => 1);
                                            $order_value = 10;
                                            $reward_point = 1;

                                            $couponData = getAllDataByVal('user_applied_coupon', array('user_id' => $user_id));
                                            if ($couponData->num_rows() > 0) {
                                                $couponObj = $couponData->row();
                                                $coupon_id = $couponObj->coupon_id;
                                                $minimum_order_value = getDataByVal('minimum_order_value', 'coupon', array('id' => $coupon_id));

                                                if ($total_amount >= $minimum_order_value) {
                                                    $coupon_details = json_encode(getAllDataByVal('coupon', array('id' => $coupon_id))->result());
                                                    $coupon_percent = getDataByVal('coupon_percent', 'coupon', array('id' => $couponObj->coupon_id));
                                                    $maximum_coupon_value = getDataByVal('maximum_coupon_value', 'coupon', array('id' => $couponObj->coupon_id));

                                                    $saving = (float) ($total_amount * $coupon_percent) / 100;
                                                    if ($saving > $maximum_coupon_value) {
                                                        $saving = (float) $maximum_coupon_value;
                                                    }
                                                } else {
                                                    $coupon_details = json_encode(array());
                                                }
                                            } else {
                                                $coupon_details = json_encode(array());
                                            }

                                            $delivery_charge = 0;
                                            $this->db->where('min_value <', $total_amount);
                                            $this->db->where('max_value >', $total_amount);
                                            $this->db->where('status', 1);
                                            $deliveryChargeQry = $this->db->get('delivery_charges');
                                            if ($deliveryChargeQry->num_rows() > 0) {
                                                foreach ($deliveryChargeQry->result() as $deliveryChargeObj) {
                                                    $delivery_charge = $deliveryChargeObj->delivery_charge;
                                                    if ($delivery_charge == 0) {
                                                        $delivery_charge_view = "Free";
                                                    } else {
                                                        $delivery_charge_view = $delivery_charge;
                                                    }
                                                }
                                            } else {
                                                $delivery_charge = 0;
                                                $delivery_charge_view = "Free";
                                            }

                                            $total_amount = $total_amount - $saving;
                                            $total_amount = $total_amount + $delivery_charge;
                                            $total_discount = $total_discount + $saving;

                                            $user_reward_points = ($total_amount / $order_value) * $reward_point;

                                            $orderNoArr = $this->vendorModel->generateOrderNumber();
                                            $data['user_id'] = $user_id;
                                            $data['otp'] = rand(1111, 9999);
                                            $data['order_no'] = "#" . $orderNoArr[0];
                                            $data['order_type'] = $cart_type;
                                            $data['total_rate'] = $total_rate;
                                            $data['total_discount'] = $total_discount;
                                            $data['total_gst'] = $total_gst;
                                            $data['total_amount'] = $total_amount;
                                            $data['total_mrp'] = $total_mrp;
                                            $data['address_id'] = $address_id;
                                            $data['slot_id'] = $slot_id;
                                            $data['order_status'] = 0;
                                            $data['order_date'] = sys_date();
                                            $data['delivery_charge'] = $delivery_charge;
                                            $data['delivery_date'] = $delivery_date;
                                            $data['delivery_type'] = $delivery_type;
                                            $data['payment_mode'] = $payment_mode;
                                            $data['payment_details'] = $payment_details;
                                            $data['payment_status'] = $payment_status;
                                            $data['reward_points'] = $user_reward_points;
                                            $data['sno'] = $orderNoArr[1];
                                            $data['order_source'] = $order_from;
                                            $data['coupon_details'] = $coupon_details;
                                            $data['date'] = sys_date();
                                            $data['time'] = sys_time();
                                            $this->db->insert('order_overview', $data);
                                            $order_id = $this->db->insert_id();

                                            if ($queryCart->num_rows() > 0) {
                                                $res['check'] = true;
                                                $i = 0;
                                                foreach ($queryCart->result() as $rowCart) {
                                                    $product_id = $rowCart->product_id;
                                                    $productDataInner = getAllDataByVal('product', array('id' => $product_id));
                                                    if ($productDataInner->num_rows() > 0) {
                                                        $productObjInner = $productDataInner->row();
                                                        if ((int) $productObjInner->status == 1) {
                                                            $qty = (int) $rowCart->qty;
                                                            $unit = $rowCart->unit;
                                                            $unit_id = $rowCart->unit_id;
                                                            $unit_value = $rowCart->unit_value;
                                                            $color = $rowCart->color;
                                                            $size = $rowCart->size;
                                                            $product_type = $rowCart->product_type;
                                                            $productGstArr = array('id' => $product_id);
                                                            $gst_type = $this->vendorModel->getDataByVal('gst_type', 'product', $productGstArr);
                                                            $gst_percent = $this->vendorModel->getDataByVal('gst_percent', 'product', $productGstArr);

                                                            $priceArr = $this->vendorModel->getProductPrice($qty, $product_id, $unit_id, $unit_value, $gst_percent, $gst_type, $product_type);
                                                            if (count($priceArr) > 0) {
                                                                $dataDetail['order_id'] = $order_id;
                                                                $dataDetail['product_id'] = $product_id;
                                                                $dataDetail['product_type'] = $rowCart->product_type;
                                                                $dataDetail['qty'] = $qty;
                                                                $dataDetail['color'] = $color;
                                                                $dataDetail['size'] = $size;
                                                                $dataDetail['unit'] = $unit;
                                                                $dataDetail['unit_id'] = $unit_id;
                                                                $dataDetail['unit_value'] = $unit_value;
                                                                $dataDetail['mrp'] = $priceArr[6];
                                                                $dataDetail['amount'] = $priceArr[4];
                                                                $dataDetail['gst_percent'] = $gst_percent;
                                                                $dataDetail['gst_amount'] = $priceArr[3];
                                                                $dataDetail['discount'] = $priceArr[1];
                                                                $dataDetail['rate'] = $priceArr[5];
                                                                $dataDetail['total'] = $priceArr[0];
                                                                $dataDetail['status'] = 1;
                                                                $dataDetail['date'] = sys_date();
                                                                $dataDetail['time'] = sys_time();
                                                                $this->db->insert('order_detail', $dataDetail);

                                                                // $current_stock = (int) getDataByVal('current_stock', 'product_unit_stock_price', array('id' => $unit_id));
                                                                // $updateStock['current_stock'] = $current_stock - $qty;
                                                                // $this->db->where('id', $unit_id);
                                                                // $this->db->update('product_unit_stock_price', $updateStock);
                                                            }
                                                            $i++;
                                                        }
                                                    }
                                                }
                                            }
                                            $this->db->where('cart_type', $cart_type);
                                            $this->db->where('user_id', $user_id);
                                            $res = $this->db->delete('cart');

                                            $this->db->where('user_id', $user_id);
                                            $res = $this->db->delete('user_applied_coupon');

                                            $notificationData['user_id'] = $user_id;
                                            $notificationData['title'] = '#' . $orderNoArr[0] . ' - Order Successfully Placed..';
                                            $notificationData['notification'] = 'Order with order no. #' . $orderNoArr[0] . ', amounting ' . $total_amount . ' is successfully placed.';
                                            $notificationData['date'] = sys_date();
                                            $notificationData['time'] = sys_time();
                                            $fcm_token = getDataByVal('fcm_token', 'users', array('id' => $user_id));
                                            $this->notification($user_id, $notificationData, $fcm_token);

                                            $vendorNotificationData['user_id'] = -1;
                                            $vendorNotificationData['title'] = '#' . $orderNoArr[0] . ' - You Have New Order';
                                            $vendorNotificationData['notification'] = 'You Have New Order with order no. #' . $orderNoArr[0] . ', amounting ' . $total_amount;
                                            $vendorNotificationData['date'] = sys_date();
                                            $vendorNotificationData['time'] = sys_time();
                                            $fcm_token = $this->mainModel->getDataByVal('fcm_token', 'user', array('id' => $vendor_id));
                                            $this->notification($user_id, $vendorNotificationData, $fcm_token);

                                            $userSavingsArr = array('id' => $user_id);
                                            $total_savings = $this->vendorModel->getDataByVal('total_savings', 'users', $userSavingsArr);
                                            $old_reward_points = $this->vendorModel->getDataByVal('reward_points', 'users', $userSavingsArr);
                                            $total_savings_update = $total_savings + $total_discount;
                                            $total_reward_points = $old_reward_points + $user_reward_points;
                                            $dataUser['total_savings'] = $total_savings_update;
                                            $dataUser['reward_points'] = $total_reward_points;
                                            $this->db->where('id', $user_id);
                                            $this->db->update('users', $dataUser);
                                            if ($res) {
                                                $response['status'] = true;
                                                $response['rcode'] = 200;
                                                $response['message'] = 'Order Successfully Placed';
                                                $response['order_id'] = $order_id;
                                            } else {
                                                $response['status'] = true;
                                                $response['rcode'] = 500;
                                                $response['message'] = 'Something Went Wrong';
                                                $response['order_id'] = $order_id;
                                            }
                                        } else {
                                            $response['status'] = false;
                                            $response['rcode'] = 201;
                                            $response['message'] = 'No Data In Cart';
                                        }
                                    } else {
                                        $response['status'] = false;
                                        $response['rcode'] = 201;
                                        $response['message'] = 'User ID Is Required';
                                    }
                                } else {
                                    $response['status'] = false;
                                    $response['rcode'] = 200;
                                    $response['message'] = 'Wrong Delivery Date';
                                }
                            } else {
                                $response['status'] = false;
                                $response['rcode'] = 200;
                                $response['message'] = 'Delivery Date Is Required';
                            }
                        } else {
                            $response['status'] = false;
                            $response['rcode'] = 200;
                            $response['message'] = 'Wrong Payment Mode';
                        }
                    } else {
                        $response['status'] = false;
                        $response['rcode'] = 200;
                        $response['message'] = 'Wrong Address ID';
                    }
                } else {
                    $response['status'] = false;
                    $response['rcode'] = 200;
                    $response['message'] = 'Wrong User ID';
                }
            } else {
                $response['status'] = false;
                $response['rcode'] = 200;
                $response['message'] = 'User ID And Cart Type Is Required';
            }
        } else {
            $response['status'] = $userRes;
        }
        echo json_encode($response);
    }

    function routePayment($transferArr, $pay_id, $price_razor_pay)
    {
        $curl1 = curl_init();
        curl_setopt_array(
            $curl1,
            array(
                CURLOPT_URL => 'https://api.razorpay.com/v1/payments/' . $pay_id . '/capture',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                                      "amount": ' . $price_razor_pay . ',
                                      "currency": "INR"
                                    }',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic cnpwX2xpdmVfNm9pVDBxQ2tjV1FlYjI6bUtFaXhRNm5TUGdBUmdpbWFJSjNRNFRU',
                    'Content-Type: application/json'
                ),
            )
        );
        $response1 = curl_exec($curl1);
        curl_close($curl1);

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.razorpay.com/v1/payments/' . $pay_id . '/transfers',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($transferArr),
                CURLOPT_HTTPHEADER => array(
                    'content-type: application/json',
                    'Authorization: Basic cnpwX2xpdmVfNm9pVDBxQ2tjV1FlYjI6bUtFaXhRNm5TUGdBUmdpbWFJSjNRNFRU'
                ),
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);
    }

    function getUserOrders()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $isValidated = true;
            if ($this->input->post('user_id') != "") {
                $user_id = $this->input->post('user_id');
                $checkUserId = getAllDataByVal('users', array('id' => $user_id));
                if ($checkUserId->num_rows() > 0) {
                    $i = 0;
                    $user_id = $this->input->post('user_id');
                    if ($this->input->post('order_id') != "") {
                        $order_id = $this->input->post('order_id');
                        $this->db->where('order_no', $order_id);
                    }
                    if ($this->input->post('start_date') != "" && $this->input->post('end_date') != "") {
                        $start_date = $this->input->post('start_date');
                        $end_date = $this->input->post('end_date');
                        $this->db->where('order_date >=', $start_date);
                        $this->db->where('order_date <=', $end_date);
                    }
                    $this->db->where('user_id', $user_id);
                    $this->db->order_by('order_status', 'ASC');
                    $query = $this->db->get('order_overview');
                    if ($query->num_rows() > 0) {
                        foreach ($query->result() as $row) {
                            $order_id = $row->id;
                            $slotArr = array('id' => $row->slot_id);
                            $slotDetail = getAllDataByVal('slot', $slotArr);
                            if ($slotDetail->num_rows() > 0) {
                                $slotObj = $slotDetail->row();
                                $slot_detail = date_conversion($row->delivery_date);
                            } else {
                                $slot_detail = date_conversion($row->delivery_date);
                            }
                            if ($row->delivery_charge == 0) {
                                $delivery_charge = "FREE";
                            } else {
                                $delivery_charge = $row->delivery_charge;
                            }


                            if ($row->order_status == 0) {
                                $trClass = '#fe9365';
                                $status_text = 'Pending';
                            } elseif ($row->order_status == 1) {
                                $trClass = '#0ac282';
                                $status_text = 'Confirmend';
                            } elseif ($row->order_status == 2) {
                                $trClass = '#2DCEE3';
                                $status_text = 'Packed';
                            } elseif ($row->order_status == 3) {
                                $trClass = '#01a9ac';
                                $status_text = 'Out For Delivery';
                            } elseif ($row->order_status == 4) {
                                $trClass = '#0ac282';
                                $status_text = 'Delivered';
                            } elseif ($row->order_status == 5) {
                                $trClass = '#eb3422';
                                $status_text = 'Cancelled';
                            }

                            if ($row->order_status == 4) {
                                $slot_detail = 'Delivered: ' . $slot_detail;
                            } elseif ($row->order_status == 5) {
                                $slot_detail = '';
                            } else {
                                $slot_detail = 'Expected Delivery: ' . $slot_detail;
                            }
                            $product_id = getDataByVal('product_id', 'order_detail', array('order_id' => $order_id));
                            $product_name = getDataByVal('product_name', 'product', array('id' => $product_id));
                            $home_image = getDataByVal('home_image', 'product', array('id' => $product_id));


                            $data[$i]['id'] = $row->id;
                            $data[$i]['order_no'] = $row->order_no;
                            $data[$i]['otp'] = $row->otp;
                            $data[$i]['slot_details'] = $slot_detail;
                            $data[$i]['total_amount'] = $row->total_amount;
                            $data[$i]['total_mrp'] = $row->total_mrp;
                            $data[$i]['total_discount'] = $row->total_discount;
                            $data[$i]['delivery_charge'] = $delivery_charge;
                            $data[$i]['delivery_type'] = $row->delivery_type;
                            $data[$i]['order_status'] = $row->order_status;
                            $data[$i]['status_text'] = $status_text;
                            $data[$i]['status_color'] = $trClass;
                            $data[$i]['order_date'] = date_conversion($row->date);
                            $data[$i]['total_products'] = getSumData('order_detail', array('order_id' => $row->id), 'qty');
                            $data[$i]['product_image'] = base_url() . 'image/product/' . $home_image;
                            $data[$i]['product_name'] = $product_name;
                            $i++;
                        }
                        $res['status'] = true;
                        $res['rcode'] = 200;
                        $res['message'] = 'Orders Found';
                        $res['data'] = $data;
                    } else {
                        $res['status'] = false;
                        $res['rcode'] = 202;
                        $res['message'] = 'No Orders Found';
                    }
                } else {
                    $res['status'] = false;
                    $res['rcode'] = 201;
                    $res['message'] = 'Wrong User ID';
                }
            } else {
                $res['status'] = false;
                $res['rcode'] = 201;
                $res['message'] = 'User ID Is Required';
            }
        } else {
            $res['status'] = $userRes;
        }
        echo json_encode($res);
    }

    function getOrderDetail()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $isValidated = true;
            if ($this->input->post('user_id') != "") {
                $user_id = $this->input->post('user_id');
                $checkUserId = getAllDataByVal('users', array('id' => $user_id));
                if ($checkUserId->num_rows() > 0) {
                    $res['check'] = false;
                    $data = array();
                    $order_id = $this->input->post('order_id');
                    if ($order_id != "") {
                        $address_id = getDataByVal('address_id', 'order_overview', array('id' => $order_id));
                        $order_status = getDataByVal('order_status', 'order_overview', array('id' => $order_id));
                        $delivery_type = getDataByVal('delivery_type', 'order_overview', array('id' => $order_id));
                        if ($address_id != "" && $address_id != 0) {
                            $addressDetailObj = getAllDataByVal('users_address', array('id' => $address_id))->row();

                            $addressArr['pincode'] = $addressDetailObj->pincode;
                            $addressArr['address'] = $addressDetailObj->address;
                            $addressArr['name'] = $addressDetailObj->name;
                            $addressArr['email'] = $addressDetailObj->email;
                            $addressArr['mobile_no'] = $addressDetailObj->mobile_no;
                            $addressArr['street_address'] = $addressDetailObj->street_address;
                            $addressArr['house_no'] = $addressDetailObj->house_no;
                            $addressArr['address_type'] = $addressDetailObj->address_type;
                            $addressArr['state'] = $addressDetailObj->state;
                            $addressArr['city'] = $addressDetailObj->city;
                            $addressArr['delivery_type'] = $delivery_type;
                        } else {
                            $addressArr['pincode'] = "";
                            $addressArr['address'] = "";
                            $addressArr['name'] = "";
                            $addressArr['email'] = "";
                            $addressArr['mobile_no'] = "";
                            $addressArr['street_address'] = "";
                            $addressArr['house_no'] = "";
                            $addressArr['address_type'] = "";
                            $addressArr['state'] = "";
                            $addressArr['city'] = "";
                            $addressArr['delivery_type'] = $delivery_type;
                        }
                        $data['address_detail'] = $addressArr;

                        $pending_status = 1;
                        $confirmed_status = 0;
                        $packed_status = 0;
                        $on_delivery_status = 0;
                        $delivered_status = 0;
                        $cancelled_status = 0;
                        if ($order_status == 0) {
                            $trClass = '#fe9365';
                            $status_text = 'Pending';
                            $pending_status = 1;
                        } elseif ($order_status == 1) {
                            $trClass = '#0ac282';
                            $status_text = 'Confirmend';
                            $pending_status = 1;
                            $confirmed_status = 1;
                        } elseif ($order_status == 2) {
                            $trClass = '#2DCEE3';
                            $status_text = 'Packed';
                            $pending_status = 1;
                            $confirmed_status = 1;
                            $packed_status = 1;
                        } elseif ($order_status == 3) {
                            $trClass = '#01a9ac';
                            if ($delivery_type == 1) {
                                $status_text = 'Ready For Pickup';
                            } else {
                                $status_text = 'On Delivery';
                            }
                            $pending_status = 1;
                            $confirmed_status = 1;
                            $packed_status = 1;
                            $on_delivery_status = 1;
                        } elseif ($order_status == 4) {
                            $trClass = '#0ac282';
                            if ($delivery_type == 1) {
                                $status_text = 'Picked Up';
                            } else {
                                $status_text = 'Delivered';
                            }
                            $pending_status = 1;
                            $confirmed_status = 1;
                            $packed_status = 1;
                            $on_delivery_status = 1;
                            $delivered_status = 1;
                        } elseif ($order_status == 5) {
                            $trClass = '#eb3422';
                            $status_text = 'Cancelled';
                            $pending_status = 1;
                            $cancelled_status = 1;
                        } else {
                            $trClass = '';
                            $status_text = '';
                            $pending_status = 1;
                            $cancelled_status = 1;
                        }

                        $statusArr = array();
                        if ($order_status != 5) {
                            $statusArr[0]['status_name'] = 'Pending';
                            $statusArr[0]['status_status'] = $pending_status;
                            $statusArr[0]['status_number'] = 0;

                            $statusArr[1]['status_name'] = 'Confirmend';
                            $statusArr[1]['status_status'] = $confirmed_status;
                            $statusArr[1]['status_number'] = 1;

                            $statusArr[2]['status_name'] = 'Packed';
                            $statusArr[2]['status_status'] = $packed_status;
                            $statusArr[2]['status_number'] = 2;

                            if ($delivery_type == 1) {
                                $statusArr[3]['status_name'] = 'Ready For Pickup';
                                $statusArr[3]['status_status'] = $on_delivery_status;
                                $statusArr[3]['status_number'] = 3;
                            } else {
                                $statusArr[3]['status_name'] = 'On Delivery';
                                $statusArr[3]['status_status'] = $on_delivery_status;
                                $statusArr[3]['status_number'] = 3;
                            }
                            if ($delivery_type == 1) {
                                $statusArr[4]['status_name'] = 'Picked Up';
                                $statusArr[4]['status_status'] = $delivered_status;
                                $statusArr[4]['status_number'] = 4;
                            } else {
                                $statusArr[4]['status_name'] = 'Delivered';
                                $statusArr[4]['status_status'] = $delivered_status;
                                $statusArr[4]['status_number'] = 4;
                            }
                        } else {
                            $statusArr[0]['status_name'] = 'Pending';
                            $statusArr[0]['status_status'] = $pending_status;
                            $statusArr[0]['status_number'] = 0;

                            $statusArr[1]['status_name'] = 'Cancelled';
                            $statusArr[1]['status_status'] = $cancelled_status;
                            $statusArr[1]['status_number'] = 5;
                        }


                        $total_mrp = getDataByVal('total_mrp', 'order_overview', array('id' => $order_id));
                        $total_discount = getDataByVal('total_discount', 'order_overview', array('id' => $order_id));

                        $delivery_charge = getDataByVal('delivery_charge', 'order_overview', array('id' => $order_id));
                        if ($delivery_charge == 0) {
                            $delivery_charge = "FREE";
                        }

                        $total_amount = getDataByVal('total_amount', 'order_overview', array('id' => $order_id));
                        $total_rate = getDataByVal('total_rate', 'order_overview', array('id' => $order_id));
                        $total_gst = getDataByVal('total_gst', 'order_overview', array('id' => $order_id));
                        $payment_status = getDataByVal('payment_status', 'order_overview', array('id' => $order_id));
                        if ($payment_status == 1) {
                            $payment_status = 'Payment Done';
                            $payment_color = '#1de021';
                        } else {
                            $payment_status = 'Payment Pending';
                            $payment_color = '#da0606';
                        }

                        $slot_id = getDataByVal('slot_id', 'order_overview', array('id' => $order_id));
                        $delivery_date = getDataByVal('delivery_date', 'order_overview', array('id' => $order_id));
                        $payment_mode = getDataByVal('payment_mode', 'order_overview', array('id' => $order_id));
                        $order_date = getDataByVal('date', 'order_overview', array('id' => $order_id));
                        $order_no = getDataByVal('order_no', 'order_overview', array('id' => $order_id));
                        $slotArr = array('id' => $slot_id);
                        $slotDetail = getAllDataByVal('slot', $slotArr);
                        if ($slotDetail->num_rows() > 0) {
                            foreach ($slotDetail->result() as $slotObj) {
                            }
                            $slot_detail = date_conversion($delivery_date) . " " . date('H:i', strtotime($slotObj->start_time)) . " - " . date('H:i', strtotime($slotObj->end_time));
                        } else {
                            $slot_detail = date_conversion($delivery_date) . " 10:00  - 17:00";
                        }

                        $paymentArr['total_mrp'] = $total_mrp;
                        $paymentArr['total_discount'] = $total_discount;
                        $paymentArr['sub_total'] = $total_rate;
                        $paymentArr['gst_price'] = $total_gst;
                        $paymentArr['delivery_charge'] = $delivery_charge;
                        $paymentArr['total'] = $total_amount;
                        $paymentArr['payment_status'] = $payment_status;
                        $paymentArr['payment_color'] = $payment_color;
                        $paymentArr['slot_details'] = $slot_detail;
                        $paymentArr['status_text'] = $status_text;
                        $paymentArr['status_color'] = $trClass;
                        $paymentArr['payment_mode'] = strtoupper($payment_mode);
                        $paymentArr['order_date'] = date_conversion($order_date);
                        $paymentArr['order_no'] = $order_no;

                        $this->db->where('order_id', $order_id);
                        $queryCart = $this->db->get('order_detail');
                        if ($queryCart->num_rows() > 0) {
                            $res['check'] = true;
                            $i = 0;
                            foreach ($queryCart->result() as $rowCart) {
                                $qty = $rowCart->qty;
                                $product_id = $rowCart->product_id;
                                $dataPro[$i]['qty'] = $rowCart->qty;
                                $dataPro[$i]['id'] = $rowCart->id;
                                $dataPro[$i]['unit'] = $rowCart->unit;
                                $dataPro[$i]['total'] = $rowCart->total;

                                $this->db->where('id', $product_id);
                                $query = $this->db->get('product');
                                foreach ($query->result() as $row) {
                                    $dataPro[$i]['product_id'] = $product_id;
                                    $dataPro[$i]['name'] = $row->product_name;

                                    $whereArrHomeImage = array('product_id' => $product_id);
                                    $homeImagesQry = $this->vendorModel->getAllDataByVal('product_images', $whereArrHomeImage);
                                    if ($homeImagesQry->num_rows() > 0) {
                                        foreach ($homeImagesQry->result() as $homeImagesObj) {
                                            $dataPro[$i]['home_image'] = base_url() . 'image/product/' . $homeImagesObj->image;
                                        }
                                    } else {
                                        $dataPro[$i]['home_image'] = base_url() . 'image/default-image.png';
                                    }
                                }
                                $i++;
                            }

                            $data['products'] = $dataPro;
                            $data['payment_details'] = $paymentArr;
                            $data['statusArr'] = $statusArr;
                            $res['status'] = true;
                            $res['rcode'] = 200;
                            $res['message'] = 'Details Found';
                            $res['data'] = $data;
                        } else {
                            $res['status'] = true;
                            $res['rcode'] = 200;
                            $res['message'] = 'No Product Found For This Order';
                        }
                    } else {
                        $res['status'] = true;
                        $res['rcode'] = 200;
                        $res['message'] = 'Order ID is required';
                    }
                } else {
                    $res['status'] = true;
                    $res['rcode'] = 200;
                    $res['message'] = 'Wrong User ID';
                }
            } else {
                $res['status'] = true;
                $res['rcode'] = 200;
                $res['message'] = 'User ID is required';
            }
        } else {
            $res['status'] = $userRes;
        }
        echo json_encode($res);
    }

    function getUserDetails()
    {
        $user_id = $this->input->post('user_id');
        //$driver_id = $this->input->post('driver_id');
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
            }
            $data['data']['id'] = $row->id;
            $data['data']['mobile_no'] = $row->mobile_no;
            $data['data']['wallet'] = $row->wallet;
            $data['data']['reward_wallet'] = $row->reward_wallet;
            $data['data']['reward_points'] = $row->reward_points;
            $data['data']['total_savings'] = $row->total_savings;
        } else {
            $data['data'] = false;
        }
        echo json_encode($data);
    }

    function textSuggestion()
    {
        $text = $this->input->post('text');
        $cart_type = $this->input->post('cart_type');
        if ($text != "") {
            if ($cart_type == "ecommerce") {
                $where_in = " AND `shop_type` NOT IN ('1') ";
            } else {
                $where_in = " AND `shop_type` IN ('1') ";
            }
            $sql = "SELECT * FROM `product` WHERE (product_name LIKE '%$text%' OR title LIKE '%$text%') AND `status`='1' $where_in ORDER BY `product_name` ASC LIMIT 10";
            $productData = $this->db->query($sql);
            if ($productData->num_rows() > 0) {
                $suggestionArr = array();
                $i = 0;
                $res['status'] = true;
                $res['rcode'] = 200;
                $res['message'] = 'Data Found';
                $suggestionArr[$i]['plain_text'] = $text;
                $suggestionArr[$i]['text'] = $text;
                $i++;
                foreach ($productData->result() as $productDataObj) {
                    $text_html = "";
                    $textSplitArr = str_split($text);
                    $nameSplitArr = str_split($productDataObj->product_name);
                    foreach ($nameSplitArr as $product_name) {
                        $text_html .= $product_name;
                        if (strtolower($text_html) == strtolower($text)) {
                            $text_html = "<b>" . $text_html . "</b>";
                        }
                    }
                    $suggestionArr[$i]['text'] = $text_html;
                    $suggestionArr[$i]['plain_text'] = $productDataObj->product_name;
                    $i++;
                }
                $res['data'] = $suggestionArr;
            } else {
                $res['status'] = false;
                $res['rcode'] = 201;
                $res['message'] = 'No Data Found';
            }
        } else {
            $res['status'] = false;
            $res['rcode'] = 201;
            $res['message'] = 'Enter Text';
        }
        echo json_encode($res);
    }

    function searchData()
    {
        $text = $this->input->post('text');
        $user_id = $this->input->post('user_id');
        $cart_type = $this->input->post('cart_type');
        if ($text != "") {
            if ($cart_type == "ecommerce") {
                $where_in = " AND `shop_type` NOT IN ('1') ";
            } else {
                $where_in = " AND `shop_type` IN ('1') ";
            }
            $sql = "SELECT * FROM `product` WHERE (product_name LIKE '%$text%' OR title LIKE '%$text%') AND `status`='1' $where_in ORDER BY `product_name` ASC LIMIT 10";
            $productData = $this->db->query($sql);
            if ($productData->num_rows() > 0) {
                $i = 0;
                $res['status'] = true;
                $res['rcode'] = 200;
                $res['message'] = 'Data Found';
                foreach ($productData->result() as $row) {
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
                        $data[$i]['product_id'] = $product_id;
                        $data[$i]['name'] = $row->product_name;
                        $data[$i]['brand_id'] = $row->brand;
                        $data[$i]['brand_name'] = getDataByVal('name', 'brand', array('id' => $row->brand));
                        $data[$i]['cart_type'] = $cart_type;

                        $data[$i]['product_type'] = $product_type;
                        $data[$i]['wishlist_status'] = $wishlist_status;
                        if ($row->home_image != "") {
                            $data[$i]['image'] = base_url() . 'image/product/' . $row->home_image;
                        } else {
                            $data[$i]['image'] = "";
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

                                        $data[$i]['cart_qty'] = $qtyCart;
                                        $data[$i]['unit_id'] = $unitObj->id;
                                        $data[$i]['unit_ram'] = $unitObj->ram_size . ' ' . $unitObj->ram_size_type;
                                        $data[$i]['unit_rom'] = $unitObj->rom_size . ' ' . $unitObj->rom_size_type;
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

                                        $data[$i]['cart_qty'] = $qtyCart;
                                        $data[$i]['unit_id'] = $unitObj->id;
                                        $data[$i]['unit'] = $unitObj->unit_value . ' ' . $unit_name;
                                        $data[$i]['unit_value'] = $unitObj->unit_value;
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
                $res['data'] = $data;
            } else {
                $res['status'] = false;
                $res['rcode'] = 201;
                $res['message'] = 'No Data Found';
            }
        } else {
            $res['status'] = false;
            $res['rcode'] = 201;
            $res['message'] = 'Enter Text';
        }
        echo json_encode($res);
    }

    function getProfile()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $isValidated = true;
            if ($this->input->post('user_id') != "") {
                $user_id = $this->input->post('user_id');
                $checkUserId = getAllDataByVal('users', array('id' => $user_id));
                if ($checkUserId->num_rows() > 0) {
                    $userObj = $checkUserId->row();
                    $data['full_name'] = $userObj->full_name;
                    $data['email'] = $userObj->email;
                    $data['mobile_no'] = $userObj->mobile_no;
                    $data['gender'] = $userObj->gender;
                    $data['dob'] = date_conversion($userObj->dob);
                    $address_id = $userObj->primary_address;
                    $addressData = getAllDataByVal('users_address', array('id' => $address_id));
                    if ($addressData->num_rows() > 0) {
                        $addressObj = $addressData->row();
                        $addressArr['id'] = $addressObj->id;
                        $addressArr['pincode'] = $addressObj->pincode;
                        $addressArr['address'] = $addressObj->address;
                        $addressArr['name'] = $addressObj->name;
                        $addressArr['email'] = $addressObj->email;
                        $addressArr['mobile_no'] = $addressObj->mobile_no;
                        $addressArr['street_address'] = $addressObj->street_address;
                        $addressArr['house_no'] = $addressObj->house_no;
                        $addressArr['address_type'] = $addressObj->address_type;
                        $addressArr['is_primary'] = ($address_id == $addressObj->id) ? true : false;
                    } else {
                        $addressArr = new stdClass();
                    }
                    $data['primary_address'] = $addressArr;
                    $res['status'] = true;
                    $res['rcode'] = 200;
                    $res['message'] = 'User Found';
                    $res['data'] = $data;
                } else {
                    $res['status'] = true;
                    $res['rcode'] = 200;
                    $res['message'] = 'Wrong User ID';
                }
            } else {
                $res['status'] = true;
                $res['rcode'] = 200;
                $res['message'] = 'User ID is required';
            }
        } else {
            $res['status'] = $userRes;
        }
        echo json_encode($res);
    }

    function updateProfile()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $isValidated = true;
            if ($this->input->post('user_id') != "" && $this->input->post('full_name') != "" && $this->input->post('email') != "" && $this->input->post('mobile_no') != "") {
                $user_id = $this->input->post('user_id');
                $checkUserId = getAllDataByVal('users', array('id' => $user_id));
                if ($checkUserId->num_rows() > 0) {
                    $userObj = $checkUserId->row();
                    $data['full_name'] = $this->input->post('full_name');
                    $data['email'] = $this->input->post('email');
                    $data['mobile_no'] = $this->input->post('mobile_no');
                    $this->db->where('id', $user_id);
                    $query = $this->db->update('users', $data);
                    if ($query) {
                        $res['status'] = true;
                        $res['rcode'] = 200;
                        $res['message'] = 'User Found';
                        $res['data'] = $data;
                    } else {
                        $res['status'] = false;
                        $res['rcode'] = 500;
                        $res['message'] = 'Something Went Wrong';
                    }
                } else {
                    $res['status'] = true;
                    $res['rcode'] = 200;
                    $res['message'] = 'Wrong User ID';
                }
            } else {
                $res['status'] = true;
                $res['rcode'] = 200;
                $res['message'] = 'User ID is required';
            }
        } else {
            $res['status'] = $userRes;
        }
        echo json_encode($res);
    }

    function getSupportDetail()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $vendor_id = $userRes['vendor_id'];
            $data['work_email'] = $this->mainModel->getDataByVal('email', 'user', array('id' => $vendor_id));
            $data['work_contact'] = $this->mainModel->getDataByVal('mobile', 'user', array('id' => $vendor_id));
            $data['website'] = $this->mainModel->getDataByVal('website', 'company_details', array());
            $res['status'] = true;
            $res['rcode'] = 200;
            $res['message'] = 'Data Found';
            $res['data'] = $data;
        } else {
            $res = $userRes;
        }
        echo json_encode($res);
    }

    function getAboutDetail()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $data['about_us'] = $this->mainModel->getDataByVal('about_us', 'company_details', array());
            $data['privacy_policy'] = $this->mainModel->getDataByVal('privacy_policy', 'company_details', array());
            $data['t_and_c'] = $this->mainModel->getDataByVal('t_and_c', 'company_details', array());
            $data['t_and_c'] = $this->mainModel->getDataByVal('t_and_c', 'company_details', array());
            $res['status'] = true;
            $res['rcode'] = 200;
            $res['message'] = 'Data Found';
            $res['data'] = $data;
        } else {
            $res = $userRes;
        }
        echo json_encode($res);
    }

    function getNotification()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "") {
                $cur_date = date('Y-m-d');
                $cur_time = date('H:i:s');
                $previous_date = date('Y-m-d', strtotime($cur_date . ' - 1 day'));
                $start_date = $cur_date;
                $end_date = date('Y-m-d', strtotime($cur_date . ' - 10 days'));
                $user_id = $this->input->post('user_id');
                $j = 0;
                while ($start_date > $end_date) {
                    $sql = "SELECT * FROM `notification` WHERE `date`='$start_date' AND (`user_id`='$user_id' OR `user_id`='0') ORDER BY `id` DESC";
                    $query = $this->db->query($sql);
                    if ($query->num_rows() > 0) {
                        $i = 0;
                        $res = array();
                        if ($start_date == $cur_date) {
                            $date_title = 'Today';
                        } elseif ($start_date == $previous_date) {
                            $date_title = 'Yesterday';
                        } else {
                            $date_title = date('d-M-Y', strtotime($start_date));
                        }
                        $data[$j]['date'] = $date_title;
                        foreach ($query->result() as $notificationObj) {
                            if ($start_date == $cur_date) {
                                $time = '';
                                $time1 = new DateTime($cur_time);
                                $time2 = new DateTime($notificationObj->time);
                                $interval = $time1->diff($time2);
                                $interval->format('%s second(s)');
                                if ($interval->h > 0) {
                                    $time .= $interval->h . ' Hours ago';
                                } elseif ($interval->i > 0) {
                                    $time .= $interval->i . ' Min ago';
                                } elseif ($interval->s > 0) {
                                    $time .= $interval->s . ' Sec ago';
                                }
                            } else {
                                $time = date('h:i a', strtotime($notificationObj->time));
                            }

                            $this->db->where('user_id', $user_id);
                            $this->db->where('notification_id', $notificationObj->id);
                            $query1 = $this->db->get('notification_seen');
                            if ($query1->num_rows() > 0) {
                                $seen_status = 1;
                            } else {
                                $seen_status = 0;
                            }
                            $res[$i]['id'] = $notificationObj->id;
                            $res[$i]['title'] = $notificationObj->title;
                            $res[$i]['notification'] = $notificationObj->notification;
                            $res[$i]['seen_status'] = $seen_status;
                            $res[$i]['time'] = $time;
                            $i++;
                        }
                        $data[$j]['notifications'] = $res;
                        $j++;
                    }
                    $start_date = date('Y-m-d', strtotime($start_date . ' - 1 day'));
                }
                if (count($data) > 0) {
                    $response['status'] = true;
                    $response['rcode'] = 200;
                    $response['message'] = 'Notification Found';
                    $response['data'] = $data;
                } else {
                    $response['status'] = false;
                    $response['rcode'] = 500;
                    $response['message'] = 'No Data Found';
                }
            } else {
                $response['status'] = false;
                $response['rcode'] = 201;
                $response['message'] = 'User ID Is Required';
            }
        } else {
            $response = $userRes;
        }
        echo json_encode($response);
    }

    function updateNotification()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "") {
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
                    $i = 0;
                    $res = array();
                    if ($query->num_rows() > 0) {
                        foreach ($query->result() as $notificationObj) {
                            $notification_id = $notificationObj->id;
                            $this->db->where('user_id', $user_id);
                            $this->db->where('notification_id', $notification_id);
                            $query1 = $this->db->get('notification_seen');
                            if ($query1->num_rows() > 0) {
                            } else {
                                $insData['notification_id'] = $notification_id;
                                $insData['user_id'] = $user_id;
                                $insData['status'] = 1;
                                $insData['date'] = sys_date();
                                $insData['time'] = sys_time();
                                $this->db->insert('notification_seen', $insData);
                            }
                            $i++;
                        }
                    }
                    $start_date = date('Y-m-d', strtotime($start_date . ' - 1 day'));
                    $j++;
                }
                $data['status'] = true;
                $data['rcode'] = 200;
                $data['message'] = 'Notification Updated';
            } else {
                $data['status'] = false;
                $data['rcode'] = 201;
                $data['message'] = 'User ID Is Required';
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function checkPincode()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $vendor_id = $userRes['vendor_id'];
            if ($this->input->post('pincode') != '') {
                $pincode = $this->input->post('pincode');
                $checkPincode = getAllDataByVal('pincode', array('pincode' => $pincode, 'status' => 1));
                if ($checkPincode->num_rows() > 0) {
                    $data['status'] = true;
                    $data['rcode'] = 200;
                    $data['message'] = 'Pincode Is Valid';
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 201;
                    $data['message'] = 'We Are Not Serving On This Pincode';
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 500;
                $data['message'] = 'Pincode Is Required';
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function getSocialMedia()
    {
        $data = array();
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            $vendor_id = $userRes['vendor_id'];
            $userData = $this->mainModel->getAllDataByVal('user', array('id' => $vendor_id));
            if ($userData->num_rows() > 0) {
                $userRow = $userData->row();
                $res['status'] = true;
                $res['rcode'] = 200;
                $res['message'] = 'Data Found';

                $res['facebook_link'] = ($userRow->facebook_link != '') ? $userRow->facebook_link : '';
                $res['instagram_link'] = ($userRow->instagram_link != '') ? $userRow->instagram_link : '';
                $res['youtube_link'] = ($userRow->youtube_link != '') ? $userRow->youtube_link : '';
                $res['twitter_link'] = ($userRow->twitter_link != '') ? $userRow->twitter_link : '';
                $res['linkedin_link'] = ($userRow->linkedin_link != '') ? $userRow->linkedin_link : '';
                $res['snapchat_link'] = ($userRow->snapchat_link != '') ? $userRow->snapchat_link : '';
                $res['website_link'] = ($userRow->website_link != '') ? $userRow->website_link : '';
                $res['whatsapp'] = ($userRow->whatsapp != '') ? $userRow->whatsapp : '';
            } else {
                $res['status'] = false;
                $res['rcode'] = 202;
                $res['message'] = 'No Data Found';
            }
        } else {
            $res = $userRes;
        }
        echo json_encode($res);
    }

    function addToWishList()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "" && $this->input->post('product_id') != "") {
                $user_id = $this->input->post('user_id');
                $product_id = $this->input->post('product_id');
                $productData = getAllDataByVal('product', array('id' => $product_id));
                if ($productData->num_rows() > 0) {
                    $checkWishlist = getAllDataByVal('user_wishlist', array('user_id' => $user_id, 'product_id' => $product_id));
                    if ($checkWishlist->num_rows() > 0) {
                        $this->db->where('user_id', $user_id);
                        $this->db->where('product_id', $product_id);
                        $queryDelete = $this->db->delete('user_wishlist');
                        if ($queryDelete) {
                            $data['status'] = false;
                            $data['rcode'] = 200;
                            $data['message'] = "Removed from wishlist";
                        } else {
                            $data['status'] = false;
                            $data['rcode'] = 500;
                            $data['message'] = "Something went wrong";
                        }
                    } else {
                        $insData['product_id'] = $product_id;
                        $insData['user_id'] = $user_id;
                        $insData['date'] = sys_date();
                        $insData['time'] = sys_time();
                        $queryInsert = $this->db->insert('user_wishlist', $insData);
                        if ($queryInsert) {
                            $data['status'] = true;
                            $data['rcode'] = 200;
                            $data['message'] = "Added To Wishlist";
                        } else {
                            $data['status'] = false;
                            $data['rcode'] = 500;
                            $data['message'] = "Something went wrong";
                        }
                    }
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 500;
                    $data['message'] = "Wrong Product..";
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 201;
                $data['message'] = "Some fileds Are Missing";
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function removeFromWishList()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "" && $this->input->post('wishlist_id') != "") {
                $user_id = $this->input->post('user_id');
                $wishlist_id = $this->input->post('wishlist_id');
                $this->db->where('id', $wishlist_id);
                $queryDelete = $this->db->delete('user_wishlist');
                if ($queryDelete) {
                    $data['status'] = true;
                    $data['rcode'] = 200;
                    $data['message'] = "Removed From Wishlist";
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 500;
                    $data['message'] = "Something went wrong";
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 201;
                $data['message'] = "Some fileds Are Missing";
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function wishList()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "") {
                $dataArr = array();
                $user_id = $this->input->post('user_id');
                $wishListData = getAllDataByVal('user_wishlist', array('user_id' => $user_id));
                if ($wishListData->num_rows() > 0) {
                    $data['status'] = true;
                    $data['rcode'] = 200;
                    $data['message'] = "Data found";
                    $i = 0;
                    foreach ($wishListData->result() as $wishListObj) {
                        $wishlist_id = $wishListObj->id;
                        $product_id = $wishListObj->product_id;
                        $row = getAllDataByVal('product', array('id' => $product_id))->row();

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
                        $category_id = $row->category;
                        $dataArr[$i]['wishlist_id'] = $wishlist_id;
                        $dataArr[$i]['id'] = $product_id;
                        $dataArr[$i]['name'] = $row->product_name;
                        $dataArr[$i]['brand_id'] = $row->brand;
                        $dataArr[$i]['brand_name'] = getDataByVal('name', 'brand', array('id' => $row->brand));

                        $dataArr[$i]['product_type'] = $product_type;
                        if ($row->home_image != "") {
                            $dataArr[$i]['home_image'] = base_url() . 'image/product/' . $row->home_image;
                        } else {
                            $dataArr[$i]['home_image'] = "";
                        }

                        if ($product_type == 2) {
                            $whereArrUnit = array('product_id' => $product_id);
                            $unitQry = $this->vendorModel->getAllDataByVal('product_ram_rom_price', $whereArrUnit);
                            $n = 0;
                            if ($unitQry->num_rows() > 0) {
                                $unitArr = array();
                                foreach ($unitQry->result() as $unitObj) {
                                    if ((int) $unitObj->stock_status == 1) {
                                        $user_id = $this->input->post('user_id');
                                        $unit_id = $unitObj->id;
                                        $unit_value = $unitObj->ram_size;
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

                                        $dataArr[$i]['unit'] = $unitObj->ram_size . ' ' . $unitObj->ram_size_type;
                                        $dataArr[$i]['unit_sales_price'] = $unitObj->unit_sales_price;
                                        $dataArr[$i]['unit_mrp'] = $unitObj->unit_mrp;
                                        $dataArr[$i]['discount'] = $discount;
                                        $n++;
                                    }
                                }
                                if (count($unitArr) <= 0) {
                                    $unitArr = false;
                                }
                            } else {
                                $unitArr = false;
                            }
                            $dataArr[$i]['unit_details'] = $unitArr;
                        } else {
                            $whereArrUnit = array('product_id' => $product_id);
                            $unitQry = $this->vendorModel->getAllDataByVal('product_unit_stock_price', $whereArrUnit);
                            $n = 0;
                            if ($unitQry->num_rows() > 0) {
                                $unitArr = array();
                                foreach ($unitQry->result() as $unitObj) {
                                    if ((int) $unitObj->stock_status == 1) {
                                        $user_id = $this->input->post('user_id');
                                        $unit_id = $unitObj->id;
                                        $unit_value = $unitObj->unit_value;
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

                                        $dataArr[$i]['unit'] = $unitObj->unit_value . ' ' . $unit_name;
                                        $dataArr[$i]['unit_sales_price'] = $unitObj->unit_sales_price;
                                        $dataArr[$i]['unit_mrp'] = $unitObj->unit_mrp;
                                        $dataArr[$i]['discount'] = $discount;
                                        $n++;
                                    }
                                }
                                if (count($unitArr) <= 0) {
                                    $unitArr = false;
                                }
                            } else {
                                $unitArr = false;
                            }
                            $dataArr[$i]['unit_details'] = $unitArr;
                        }
                        $i++;
                    }
                    $data['data'] = $dataArr;
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 201;
                    $data['message'] = "Nothing to show";
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 201;
                $data['message'] = "Some fileds Are Missing";
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function feedback()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "" && $this->input->post('rating') != "") {
                $user_id = $this->input->post('user_id');
                $rating = validate($this->input->post('rating'));
                $message = validate($this->input->post('message'));
                $feedbackData = getAllDataByVal('feedback', array('user_id' => $user_id));
                if ($feedbackData->num_rows() > 0) {
                    $upData['rating'] = $rating;
                    $upData['message'] = $message;
                    $this->db->where('user_id', $user_id);
                    $query = $this->db->update('feedback', $upData);
                    if ($query) {
                        $data['status'] = true;
                        $data['rcode'] = 200;
                        $data['message'] = 'Feedback successfully updated';
                    } else {
                        $data['status'] = false;
                        $data['rcode'] = 500;
                        $data['message'] = 'Something went wrong';
                    }
                } else {
                    $insData['user_id'] = $user_id;
                    $insData['rating'] = $rating;
                    $insData['message'] = $message;
                    $query = $this->db->insert('feedback', $insData);
                    if ($query) {
                        $data['status'] = true;
                        $data['rcode'] = 200;
                        $data['message'] = 'Feedback successfully added';
                    } else {
                        $data['status'] = false;
                        $data['rcode'] = 500;
                        $data['message'] = 'Something went wrong';
                    }
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 201;
                $data['message'] = "Some fileds Are Missing";
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function getFeedback()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "") {
                $user_id = $this->input->post('user_id');
                $feedbackData = getAllDataByVal('feedback', array('user_id' => $user_id));
                if ($feedbackData->num_rows() > 0) {
                    $feedbackArr = array();
                    $feedbackObj = $feedbackData->row();

                    $feedbackArr['rating'] = $feedbackObj->rating;
                    $feedbackArr['message'] = $feedbackObj->message;

                    $data['status'] = true;
                    $data['rcode'] = 200;
                    $data['message'] = 'Feedback successfully updated';
                    $data['data'] = $feedbackArr;
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 201;
                    $data['message'] = 'No data to show';
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 201;
                $data['message'] = "Some fileds Are Missing";
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function getSupportDetails()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "") {
                $dataArr = array();
                $dataArr['support_email'] = getDataByVal('work_email', 'company_details', array());
                $dataArr['support_contact'] = getDataByVal('work_contact', 'company_details', array());
                $faqArr = array();
                $faqData = getAllDataByVal('faq', array('status' => 1));
                if ($faqData->num_rows() > 0) {
                    $i = 0;
                    foreach ($faqData->result() as $faqObj) {
                        $faqArr[$i]['question'] = $faqObj->question;
                        $faqArr[$i]['answer'] = $faqObj->answer;
                        $i++;
                    }
                }
                $dataArr['faq'] = $faqArr;
                $data['status'] = true;
                $data['rcode'] = 200;
                $data['message'] = '';
                $data['data'] = $dataArr;
            } else {
                $data['status'] = false;
                $data['rcode'] = 201;
                $data['message'] = "Some fileds Are Missing";
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function requestSupport()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "" && $this->input->post('subject') != "" && $this->input->post('message') != "") {
                $user_id = $this->input->post('user_id');
                $insData['user_id'] = $user_id;
                $insData['subject'] = validate($this->input->post('subject'));
                $insData['question'] = validate($this->input->post('message'));
                $query = $this->db->insert('help', $insData);
                if ($query) {
                    $data['status'] = true;
                    $data['rcode'] = 200;
                    $data['message'] = 'Data successfully added';
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 500;
                    $data['message'] = 'Something went wrong !!!';
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 201;
                $data['message'] = "Some fileds Are Missing";
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function changePassword()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('user_id') != "" && $this->input->post('old_password') != "" && $this->input->post('new_password') != "") {
                $user_id = $this->input->post('user_id');
                $new_password = password($this->input->post('new_password'));
                $current_password = getDataByVal('password', 'users', array('id' => $user_id));
                $old_password = password($this->input->post('old_password'));

                if ($old_password == $current_password) {
                    $insData['password'] = $new_password;
                    $this->db->where('id', $user_id);
                    $query = $this->db->update('users', $insData);
                    if ($query) {
                        $data['status'] = true;
                        $data['rcode'] = 200;
                        $data['message'] = 'Password Successfully Changed...';
                    } else {
                        $data['status'] = false;
                        $data['rcode'] = 500;
                        $data['message'] = 'Something went wrong !!!';
                    }
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 201;
                    $data['message'] = 'Old Password Does Not Match';
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 201;
                $data['message'] = "Some fileds Are Missing";
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }

    function forgotPassword()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('mobile_no') != "") {
                $mobile_no = checkMobileFormate($this->input->post('mobile_no'));
                if ($mobile_no != false) {
                    $otp = 1234;
                    $checkMobile = getAllDataByVal('users', array('mobile_no' => $mobile_no));
                    if ($checkMobile->num_rows() > 0) {
                        $data['status'] = true;
                        $data['rcode'] = 200;
                        $data['message'] = 'OTP successfully sent on your mobile number';
                        $data['otp'] = (int) $otp;
                    } else {
                        $data['status'] = false;
                        $data['rcode'] = 500;
                        $data['message'] = 'Wrong Mobile Number';
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

    function changeForgotPassword()
    {
        $userRes = $this->checkUserId();
        if ($userRes['status'] == true) {
            if ($this->input->post('mobile_no') != "" && $this->input->post('new_password') != "") {
                $mobile_no = $this->input->post('mobile_no');
                $new_password = password($this->input->post('new_password'));

                $insData['password'] = $new_password;
                $this->db->where('mobile_no', $mobile_no);
                $query = $this->db->update('users', $insData);
                if ($query) {
                    $data['status'] = true;
                    $data['rcode'] = 200;
                    $data['message'] = 'Password Successfully Changed...';
                } else {
                    $data['status'] = false;
                    $data['rcode'] = 500;
                    $data['message'] = 'Something went wrong !!!';
                }
            } else {
                $data['status'] = false;
                $data['rcode'] = 201;
                $data['message'] = "Some fileds Are Missing";
            }
        } else {
            $data = $userRes;
        }
        echo json_encode($data);
    }
}
