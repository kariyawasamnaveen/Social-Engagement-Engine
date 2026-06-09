<?php
defined('BASEPATH') or exit('No direct script access allowed');

class admin extends My_AdminController
{
    public $tb_users;
    public $tb_staff;

    public function __construct()
    {
        parent::__construct();
        $this->tb_users = USERS;
        $this->tb_staff = STAFFS;
        $this->load->model(get_class($this) . '_model', 'model');
    }

    public function index()
    {
        redirect(admin_url('login'));
    }

    public function login()
    {
        if (session('sid')) {
            redirect(admin_url("statistics"));
        }
        $data = array();
        $this->template->set_layout('auth');
        $this->template->build('auth/sign_in', $data);
    }

    public function ajax_sign_in()
    {
        _is_ajax(get_class($this));
        $email = post("email");
        $password = md5(post("password"));
        $remember = post("remember");

        if ($email == "") {
            ms(array(
                "status" => "error",
                "message" => lang("email_is_required"),
            ));
        }

        if ($password == "") {
            ms(array(
                "status" => "error",
                "message" => lang("Password_is_required"),
            ));
        }

        $user = $this->model->get("id, status, ids, email, password, first_name, last_name, timezone", $this->tb_staff, ['email' => $email]);

        $error = false;
        if (!$user) {
            $error = true;
        } else {
            // check the last hash password
            if ($this->model->app_password_verify(post("password"), $user->password)) {
                $error = false;
            } else {
                $error = true;
            }
        }

        if (!$error) {
            if ($user->status != 1) {
                ms(array(
                    "status" => "error",
                    "message" => lang("your_account_has_not_been_activated"),
                ));
            }
            set_session("sid", $user->id);
            $data_session = array(
                'email' => $user->email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'timezone' => $user->timezone,
            );
            set_session('staff_current_info', $data_session);
            $this->model->history_ip($user->id);

            ms(array(
                "status" => "success",
                "message" => lang("Login_successfully"),
            ));
        } else {
            ms(array(
                "status" => "error",
                "message" => lang("email_address_and_password_that_you_entered_doesnt_match_any_account_please_check_your_account_again"),
            ));
        }
    }

    public function logout()
    {
        unset_session("sid");
        unset_session("staff_current_info");
        $this->session->sess_destroy();
        redirect(admin_url('login'));
    }
}
