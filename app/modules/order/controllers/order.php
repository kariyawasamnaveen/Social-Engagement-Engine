<?php
defined('BASEPATH') or exit('No direct script access allowed');

class order extends My_UserController
{
    public $tb_users;
    public $tb_users_price;
    public $tb_order;
    public $tb_orders_refill;
    public $tb_categories;
    public $tb_services;
    public $tb_staff;
    public $module;
    public $module_name;
    public $module_icon;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(get_class($this) . '_model', 'main_model');
        $this->load->model(get_class($this) . '_model', 'model');

        $this->controller_name = strtolower(get_class($this));
        $this->controller_title = ucfirst(str_replace('_', ' ', get_class($this)));
        $this->path_views = "";
        $this->params = [];
        $this->columns = [];

        //Config Module
        $this->tb_users = USERS;
        $this->tb_staff = STAFFS;
        $this->tb_users_price = USERS_PRICE;
        $this->tb_order = ORDER;
        $this->tb_orders_refill = ORDERS_REFILL;
        $this->tb_categories = CATEGORIES;
        $this->tb_services = SERVICES;
        $this->module = get_class($this);
        $this->module_name = 'Order';
        $this->module_icon = "fa ft-users";

        

        $this->columns = array(
            "id" => ['name' => lang("order_id"), 'class' => 'text-center'],
            "order_details" => ['name' => lang("order_basic_details"), 'class' => 'text-center'],
            "created" => ['name' => lang("Created"), 'class' => 'text-center'],
            "status" => ['name' => lang("Status"), 'class' => 'text-center'],
        );

    }
   
    // New order page
    public function new_order()
    {
        $this->load->model("services/services_model", 'services_model');
        $items_service = $this->services_model->list_items(null, ['task' => 'list-items', 'no_group' => true]);
        $this->load->model('client/client_model', 'client_model');
        $items_category = $this->client_model->list_items(null, ['task' => 'list-items-category-in-services']);
        
        $data = array(
            "controller_name" => $this->controller_name,
            'items_category'                => $items_category,
            'items_service'                 => $items_service,
        );

        $this->template->set_layout('user');
        $this->template->build('add/add', $data);
    }

    public function ajax_add_order()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(cn($this->controller_name));
        }

        $this->main_model->check_blacklist();
        $service_id = post("service_id");
        
        $quantity = post("quantity");
        $link = post("link");
        $runs = post("runs");
        $interval = post("interval");
        $is_drip_feed = isset($_POST["is_drip_feed"]) && $_POST["is_drip_feed"] == "on" ? 1 : 0;
        $speed = post("speed");
        $agree = isset($_POST["agree"]) && $_POST["agree"] == "on" ? 1 : 0;

        /*----------  Handling Speed Logic (Auto Drip-feed)  ----------*/
        if ($speed != "instant" && !$is_drip_feed) {
            $check_service = $this->main_model->check_record("*", $this->tb_services, $service_id, false, true);
            if ($check_service && $check_service->dripfeed) {
                $is_drip_feed = 1;
                if ($speed == "slow") {
                    $runs = 24; // 24 chunks
                    $interval = 120; // Every 2 hours
                    $quantity = ceil($quantity / $runs);
                } else if ($speed == "organic") {
                    $runs = 10; // 10 chunks
                    $interval = 60; // Every hour
                    $quantity = ceil($quantity / $runs);
                }
            }
        }

        if (!$service_id) {
            _validation('error', lang("please_choose_a_service"));
        }

        $check_service = $this->main_model->check_record("*", $this->tb_services, $service_id, false, true);
        if (!$check_service) {
            _validation('error', lang("service_does_not_exists"));
        }
        
        $check_category = $this->main_model->check_record("id, name", $this->tb_categories, $check_service->cate_id, false, true);
        if (!$check_category) {
            _validation('error', lang("category_does_not_exists"));
        }

        // Check agree
        if (!$agree) {
            _validation('error', lang("you_must_confirm_to_the_conditions_before_place_order"));
        }

        /*----------  Handling Tagging Logic (Gender & Interests)  ----------*/
        $gender = '';
        if (stripos($check_service->name, 'female') !== false) {
            $gender = 'female';
        } else if (stripos($check_service->name, 'male') !== false) {
            $gender = 'male';
        }

        if ($gender != '') {
            $inventory = $this->main_model->check_account_inventory(['gender' => $gender]);
            if ($inventory < $quantity) {
                 _validation('error', sprintf(lang("not_enough_tagged_accounts_in_inventory"), ucfirst($gender)));
            }
        }

        $cate_id = $check_category->id;

        /*----------  Add all order without quantity  ----------*/
        $service_type = $check_service->type;
        $api_provider_id = $check_service->api_provider_id;
        $api_service_id = $check_service->api_service_id;
        if ($service_type == "subscriptions") {
            $this->add_order_subscriptions($_POST, $check_service, $check_category);
            exit();
        }
        if (!$link) {
            _validation('error', lang("invalid_link"));
        }
        $link = strip_tags($link);

        // check duplicate order
        if ($check_service->deny_duplicates) {
            $check_deny_duplicate_order = $this->main_model->get_item(['service_id' => $service_id, 'link' => $link], ['task' => 'check-duplicate-order']);
            if ($check_deny_duplicate_order) {
                _validation('error', lang('deny_duplicates_error'));
            }
        }

        switch ($service_type) {
            case 'custom_comments':
                
                $comments = strip_tags(trim($_POST['comments']));
                if (!$comments) {
                    _validation('error', lang("comments_field_is_required"));
                }

                $lines = preg_split('/\r\n|\r|\n/', $comments);
                $filtered_lines = array_filter($lines, function($line) {
                    return trim($line) !== '';
                });
                $quantity = count($filtered_lines);

                break;

            case 'mentions_custom_list':
                $usernames_custom = post("usernames_custom");
                if (!$usernames_custom) {
                    _validation('error', lang("username_field_is_required"));
                }

                $lines = preg_split('/\r\n|\r|\n/', $usernames_custom);
                $filtered_lines = array_filter($lines, function($line) {
                    return trim($line) !== '';
                });
                $quantity = count($filtered_lines);

                break;

            case 'package':
                $quantity = 1;
                break;

            case 'custom_comments_package':
                $comments = strip_tags($_POST['comments_custom_package']);
                if (!$comments) {
                    _validation('error', lang("comments_field_is_required"));
                }

                $quantity = 1;
                break;
        }

        if (!$quantity) {
            _validation('error', lang("quantity_is_required"));
        }

        /*----------  Check dripfeed  ----------*/
        if ($is_drip_feed && !$check_service->dripfeed) {
            _validation('error', lang("service_does_not_support_dripfeed"));
        }
        
        if ($is_drip_feed && $check_service->dripfeed) {
            if (!$runs) {
                _validation('error', lang("runs_is_required"));
            }

            if (!$interval) {
                _validation('error', lang("interval_time_is_required"));
            }

            if ($interval > 1440) {
                _validation('error', 'Invalid interval time');
            }

            $total_quantity = $runs * $quantity;
        } else {
            $total_quantity = $quantity;
        }
        /*----------  Check quantity  ----------*/
        $min = $check_service->min;
        $max = $check_service->max;
        $price = get_user_price(session('uid'), $check_service);

        if ($service_type == "package" || $service_type == "custom_comments_package") {
            $total_charge = $price;
        } else {
            $total_charge = ($price * $total_quantity) / 1000;
        }

        if ($total_quantity <= 0 || ($total_quantity < $min) || $quantity < $min) {
            _validation('error', lang("quantity_must_to_be_greater_than_or_equal_to_minimum_amount"));
        }

        if ($total_quantity > $max) {
            _validation('error', lang("quantity_must_to_be_less_than_or_equal_to_maximum_amount"));
        }
        /*----------  Get balance ----------*/
        $user = $this->main_model->get("balance", $this->tb_users, ['id' => session('uid')]);

        
        // check balance
        if ($user->balance < $total_charge) {
            _validation('error', lang("not_enough_funds_on_balance"));
        }

        /*----------  Collect data import to database  ----------*/
        $data = [
            "ids" => ids(),
            "uid"           => session("uid"),
            "cate_id"       => $cate_id,
            "service_id"    => $service_id,
            "service_type"  => $service_type,
            "mode"          => $check_service->add_type == 'api' ? 1 : 0,
            "link"          => $link,
            "quantity"      => $total_quantity,
            "charge"        => $total_charge,
            "api_provider_id" => $api_provider_id,
            "api_service_id" => $api_service_id,
            "is_drip_feed" => $is_drip_feed,
            "status" => ORDER_STATUS_AWAITING,
            "changed" => NOW,
            "created" => NOW,
        ];
        /*----------  get the different required paramenter for each service type  ----------*/
        switch ($service_type) {

            case 'mentions_with_hashtags':
                $hashtags = post("hashtags");
                $usernames = post("usernames");
                $usernames = strip_tags($usernames);
                if (!$usernames) {
                    _validation('error', lang("username_field_is_required"));
                }

                if (!$hashtags) {
                    _validation('error', lang("hashtag_field_is_required"));
                }

                $data["usernames"] = $usernames;
                $data["hashtags"] = $hashtags;
                break;

            case 'mentions_hashtag':
                $hashtag = post("hashtag");
                if (!$hashtag) {
                    _validation('error', lang("hashtag_field_is_required"));
                }

                $data["hashtag"] = $hashtag;
                break;

            case 'comment_likes':
                $username = post("username");
                $username = strip_tags($username);
                if (!$username) {
                    _validation('error', lang("username_field_is_required"));
                }

                $data["username"] = $username;
                break;

            case 'mentions_user_followers':
                $username = post("username");
                $username = strip_tags($username);
                if (!$username) {
                    _validation('error', lang("username_field_is_required"));
                }

                $data["username"] = $username;
                break;

            case 'mentions_media_likers':
                $media_url = post("media_url");

                if ($media_url == "" || !filter_var($media_url, FILTER_VALIDATE_URL)) {
                    _validation('error', lang("invalid_link"));
                }
                $data["media"] = $media_url;
                break;

            case 'custom_comments':
                $data["comments"] = json_encode($comments);
                break;

            case 'custom_comments_package':
                $data["comments"] = json_encode($comments);
                break;

            case 'mentions_custom_list':
                $data["usernames"] = json_encode($usernames_custom);
                break;

        }
        

        if ($is_drip_feed) {
            $data['runs'] = $runs;
            $data['interval'] = $interval;
            $data['dripfeed_quantity'] = $quantity;
            $data['status'] = ORDER_STATUS_ACTIVE;
        }

        if (!empty($api_provider_id) && !empty($api_service_id)) {
            $data['api_order_id'] = -1;
        }

        // Check order refill, cancel
        if ($check_service->refill && is_table_exists($this->tb_orders_refill)) {
            $data['refill'] = 1;
        }
        if ($check_service->cancel && is_table_exists(ORDERS_CANCEL)) {
            $data['cancel'] = 1;
        }
        $more_params['service_name'] = $check_service->name;
        $this->save_order($this->tb_order, $data, $user->balance, $total_charge, $more_params);
    }

    private function add_order_subscriptions($post, $check_service, $item_category)
    {
        $api_provider_id = $check_service->api_provider_id;
        $api_service_id = $check_service->api_service_id;
        $service_id = $check_service->id;
        $cate_id = $check_service->cate_id;
        $agree = (isset($post['agree']) && $post["agree"] == "on") ? 1 : 0;
        $service_type = $check_service->type;
        $link = $post["link"];
        $link = strip_tags($link);

        /*----------  Collect data import to database  ----------*/
        $data = [
            "ids" => ids(),
            "uid" => session("uid"),
            "cate_id" => $cate_id,
            "service_id" => $service_id,
            "service_type" => $service_type,
            "service_mode" => $check_service->add_type,
            "api_provider_id" => $api_provider_id,
            "api_service_id" => $api_service_id,
            "sub_status" => ORDER_STATUS_ACTIVE,
            "status" => ORDER_STATUS_AWAITING,
            "changed" => NOW,
            "created" => NOW,
        ];
        switch ($service_type) {
            case 'subscriptions':
                $username = $post["sub_username"];
                $posts = (int) $post["sub_posts"];
                $min = (int) $post["sub_min"];
                $max = (int) $post["sub_max"];
                $delay = (int) $post["sub_delay"];
                $expiry = $post["sub_expiry"];

                if ($username == "") {
                    _validation('error', lang("username_field_is_required"));
                }

                if ($min == "") {
                    _validation('error', lang("quantity_must_to_be_greater_than_or_equal_to_minimum_amount"));
                }

                if ($min < $check_service->min) {
                    _validation('error', lang("quantity_must_to_be_greater_than_or_equal_to_minimum_amount"));
                }

                if ($max < $min) {
                    _validation('error', lang("min_cannot_be_higher_than_max"));
                }

                if ($max > $check_service->max) {
                    _validation('error', lang("quantity_must_to_be_less_than_or_equal_to_maximum_amount"));
                }

                if (!in_array($delay, array(0, 5, 10, 15, 30, 60, 90))) {
                    _validation('error', lang("incorrect_delay"));
                }

                if ($posts <= 0 || $posts == "") {
                    _validation('error', lang("new_posts_future_posts_must_to_be_greater_than_or__equal_to_1"));
                }

                // Check agree
                if (!$agree) {
                    _validation('error', lang("you_must_confirm_to_the_conditions_before_place_order"));
                }
                // calculate total charge
                $price = get_user_price(session('uid'), $check_service);
                $charge = ($max * $posts * $price) / 1000;

                // check balance
                $user = $this->main_model->get("balance", $this->tb_users, ['id' => session('uid')]);
                if (($user->balance != 0 && $user->balance < $charge) || $user->balance == 0) {
                    _validation('error', lang("not_enough_funds_on_balance"));
                }
                if ($expiry != "") {
                    $expiry = str_replace('/', '-', $expiry);
                    $expiry = date("Y-m-d", strtotime($expiry));
                } else {
                    $expiry = "";
                }

                $data["username"] = $username;
                $data["sub_posts"] = ($posts == "") ? -1 : $posts;
                $data["sub_min"] = $min;
                $data["sub_max"] = $max;
                $data["sub_delay"] = $delay;
                $data["sub_expiry"] = $expiry;

                // From V3.6
                $data["charge"] = $charge;
                // $data["formal_charge"] = $expiry;
                // $data["profit"] = $expiry;

                if (!empty($api_provider_id) && !empty($api_service_id)) {
                    $data['api_order_id'] = -1;
                }
                $more_params['service_name'] = $check_service->name;
                $more_params['order_type'] = 'subscriptions';
                $this->save_order($this->tb_order, $data, $user->balance, $charge, $more_params);
                break;
        }
    }

    /*----------  insert data to order  ----------*/
    private function save_order($table, $data_orders, $user_balance = "", $total_charge = "", $more_params = [])
    {
        $this->db->trans_start();

        try {
            $service_mode = $data_orders['mode'];
            $new_balance = $user_balance - $total_charge;
            $new_balance = ($new_balance > 0) ? $new_balance : 0;
            $this->db->update($this->tb_users, ["balance" => $new_balance], ["id" => session("uid")]);

            if ($this->db->affected_rows() > 0) {
                $this->db->insert($table, $data_orders);
                $order_id = $this->db->insert_id();
                /*----------  Send Order notificaltion notice to Admin  ----------*/
                if (get_option("is_order_notice_email", '')) {
                    $user_email = $this->model->get("email", $this->tb_users, "id = '" . session('uid') . "'")->email;
                    $subject = getEmailTemplate("order_success")->subject;
                    $subject = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $subject);
                    $email_content = getEmailTemplate("order_success")->content;
                    $email_content = str_replace("{{user_email}}", $user_email, $email_content);
                    $email_content = str_replace("{{order_id}}", $order_id, $email_content);
                    $email_content = str_replace("{{currency_symbol}}", get_option("currency_symbol", ""), $email_content);
                    $email_content = str_replace("{{total_charge}}", $total_charge, $email_content);
                    $email_content = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $email_content);

                    $mail_params = [
                        'template' => [
                            'subject' => $subject,
                            'message' => $email_content,
                            'type' => 'default',
                        ],
                    ];
                    $staff_mail = $this->model->get("id, email", $this->tb_staff, [], "id", "ASC")->email;
                    if ($staff_mail) {
                        $send_message = $this->model->send_mail_template($mail_params['template'], $staff_mail);
                        if ($send_message) {
                            send_mail_error_log(["status" => "error", "message" => $send_message]);
                        }
                    }
                }

                /*----------  Notification for admin (new manual order email)  ----------*/
                if (get_option("is_new_manual_order_notice_email", 0) && $service_mode) {
                    $user_email = $this->model->get("email", $this->tb_users, "id = '" . session('uid') . "'")->email;

                    $subject = getEmailTemplate("new_manual_order")->subject;
                    $subject = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $subject);
                    $email_content = getEmailTemplate("new_manual_order")->content;
                    $email_content = str_replace("{{user_email}}", $user_email, $email_content);
                    $email_content = str_replace("{{order_id}}", $order_id, $email_content);
                    $email_content = str_replace("{{website_name}}", get_option("website_name", "SmartPanel"), $email_content);
                    $mail_params = [
                        'template' => [
                            'subject' => $subject,
                            'message' => $email_content,
                            'type' => 'default',
                        ],
                    ];
                    $staff_mail = $this->model->get("id, email", $this->tb_staff, [], "id", "ASC")->email;
                    if ($staff_mail) {
                        $send_message = $this->model->send_mail_template($mail_params['template'], $staff_mail);
                        if ($send_message) {
                            send_mail_error_log(["status" => "error", "message" => $send_message]);
                        }
                    }
                }
                $data_order_message_success = [
                    'status' => 'success',
                    'notification_type' => 'place-order',
                    'user_balance' => get_option('currency_symbol', "$") . currency_format($new_balance),
                    'order_type' => 'default',
                    'order_detail' => [
                        'id' => $order_id,
                        'service_name' => $more_params['service_name'],
                    ],
                ];
                if (isset($more_params['order_type']) && $more_params['order_type'] == 'subscriptions') {
                    $data_order_message_success['order_type'] = 'subscriptions';
                    $data_order_message_success['order_detail']['username'] = $data_orders['username'];
                    $data_order_message_success['order_detail']['posts'] = $data_orders['sub_posts'];
                    $data_order_message_success['order_detail']['charge'] = $total_charge;
                    $data_order_message_success['order_detail']['balance'] = currency_format($new_balance);
                } else {
                    $data_order_message_success['order_detail']['link'] = $data_orders['link'];
                    $data_order_message_success['order_detail']['quantity'] = $data_orders['quantity'];
                    $data_order_message_success['order_detail']['charge'] = $total_charge;
                    $data_order_message_success['order_detail']['balance'] = currency_format($new_balance);
                }
                $this->db->trans_complete();
                
                ms($data_order_message_success);

            } else {
                _validation('error', lang("There_was_an_error_processing_your_request_Please_try_again_later"));
                $this->db->trans_rollback(); // Rollback the transaction
            }
        } catch (Exception $e) {
            // Nếu có lỗi xảy ra trong quá trình thực hiện
            $this->db->trans_rollback(); // Rollback the transaction
            _validation('error', lang("There_was_an_error_processing_your_request_Please_try_again_later"));
        }
    }

    // MASS ORDER
    public function ajax_mass_order()
    {
        if (!$this->input->is_ajax_request()) {
            redirect(cn($this->controller_name));
        }

        $mass_order = post("mass_order");
        $agree = (post("agree") == "on") ? 1 : 0;

        if (!$agree) {
            _validation('error', lang("you_must_confirm_to_the_conditions_before_place_order"));
        }

        if ($mass_order == "") {
            _validation('error', lang("field_cannot_be_blank"));
        }

        /*----------  get balance   ----------*/
        $user = $this->model->get("balance", $this->tb_users, ['id' => session('uid')]);

        if ($user->balance == 0) {
            _validation('error', lang("you_do_not_have_enough_funds_to_place_order"));
        }
        $total_order = 0;
        $total_errors = 0;
        $sum_charge = 0;
        $error_details = array();
        $orders = array();
        if (is_array($mass_order)) {
            foreach ($mass_order as $key => $row) {
                $order = explode("|", $row);

                // check format
                $order_count = count($order);
                if ($order_count > 3 || $order_count <= 2) {
                    $error_details[$row] = lang("invalid_format_place_order");
                    continue;
                }
                $service_id = $order[0];
                $quantity = $order[1];
                $link = $order[2];

                // check service id
                $check_service = $this->model->check_record("*", $this->tb_services, $service_id, false, true);
                if (empty($check_service)) {
                    $error_details[$row] = lang("service_id_does_not_exists");
                    continue;
                }

                // check quantity and balance
                $min = $check_service->min;
                $max = $check_service->max;
                $price = get_user_price(session('uid'), $check_service);
                $charge = (double) $price * ($quantity / 1000);

                if ($quantity <= 0 || $quantity < $min) {
                    $error_details[$row] = lang("quantity_must_to_be_greater_than_or_equal_to_minimum_amount");
                    continue;
                }

                if ($quantity > $max) {
                    $error_details[$row] = lang("quantity_must_to_be_less_than_or_equal_to_maximum_amount");
                    continue;
                }

                // Order charge to .00 decimal points
                $charge = number_format($charge, 2, '.', '');

                /*----------  Get Formal Charge and profit  ----------*/
                $formal_charge = ($check_service->original_price * $charge) / $check_service->price;
                $profit = $charge - $formal_charge;

                // every thing is ok
                $orders[] = array(
                    "ids" => ids(),
                    "uid" => session("uid"),
                    "cate_id" => $check_service->cate_id,
                    "service_id" => $service_id,
                    "link" => $link,
                    "quantity" => $quantity,
                    "charge" => $charge,
                    "formal_charge" => $formal_charge,
                    "profit" => $profit,
                    "api_provider_id" => $check_service->api_provider_id,
                    "api_service_id" => $check_service->api_service_id,
                    "api_order_id" => (!empty($check_service->api_provider_id) && !empty($check_service->api_service_id)) ? -1 : 0,
                    "status" => ORDER_STATUS_AWAITING,
                    "order_source_type" => ORDER_SOURCE_MASS,
                    "changed" => NOW,
                    "created" => NOW,
                );
                $sum_charge += $charge;
            }

            // check sum_charge and balance
            if ($sum_charge > $user->balance) {
                _validation('error', lang("not_enough_funds_on_balance"));
            }
            if (!empty($orders)) {
                $this->db->insert_batch($this->tb_order, $orders);
                $new_balance = $user->balance - $sum_charge;
                $this->db->update($this->tb_users, ["balance" => $new_balance], ["id" => session("uid")]);
            }
        }
        if (!empty($error_details)) {
            $this->load->view("add/mass_order_notification", ["error_details" => $error_details]);
        } else {
            ms(array(
                "status" => "success",
                "message" => lang("place_order_successfully"),
            ));
        }

    }
}
