<?php
defined('BASEPATH') or exit('No direct script access allowed');

class payhere extends MX_Controller
{
    public $tb_users;
    public $tb_transaction_logs;
    public $tb_payments;
    public $tb_payments_bonuses;
    public $payment_type;
    public $payment_id;
    public $currency_code;
    public $mode;
    public $merchant_id;
    public $merchant_secret;
    public $take_fee_from_user;

    public function __construct($payment = "")
    {
        parent::__construct();
        $this->load->model('add_funds_model', 'model');

        $this->tb_users = USERS;
        $this->payment_type = 'payhere';
        $this->tb_transaction_logs = TRANSACTION_LOGS;
        $this->tb_payments = PAYMENTS_METHOD;
        $this->tb_payments_bonuses = PAYMENTS_BONUSES;
        $this->currency_code = get_option("currency_code", "LKR");
        
        if (!$payment) {
            $payment = $this->model->get('id, type, name, params', $this->tb_payments, ['type' => $this->payment_type]);
        }
        $this->payment_id = $payment->id;
        $params                   = $payment->params;
        $option                   = get_value($params, 'option');
        $this->mode               = get_value($option, 'environment');
        $this->take_fee_from_user = get_value($params, 'take_fee_from_user');
        
        $this->merchant_id      = get_value($option, 'merchant_id');
        $this->merchant_secret  = get_value($option, 'merchant_secret');
    }

    public function index()
    {
        redirect(cn("add_funds"));
    }

    /**
     * Create payment
     */
    public function create_payment($data_payment = "")
    {
        _is_ajax($data_payment['module']);
        $amount = $data_payment['amount'];
        if (!$amount) {
            _validation('error', lang('There_was_an_error_processing_your_request_Please_try_again_later'));
        }

        if (!$this->merchant_id || !$this->merchant_secret) {
            _validation('error', lang('this_payment_is_not_active_please_choose_another_payment_or_contact_us_for_more_detail'));
        }

        $users = session('user_current_info');
        $transaction_id = ids();

        $data_tnx_log = array(
            "ids" => $transaction_id,
            "uid" => session("uid"),
            "type" => $this->payment_type,
            "transaction_id" => $transaction_id,
            "amount" => $amount,
            "status" => 0,
            "created" => NOW,
        );
        $this->db->insert($this->tb_transaction_logs, $data_tnx_log);

        // Calculate PayHere hash (optional for checkout, required for IPN, but good practice)
        $hash = strtoupper(md5($this->merchant_id . $transaction_id . number_format($amount, 2, '.', '') . $this->currency_code . strtoupper(md5($this->merchant_secret))));

        $action_url = ($this->mode == 'sandbox') ? 'https://sandbox.payhere.lk/pay/checkout' : 'https://www.payhere.lk/pay/checkout';

        $html = '<form action="' . $action_url . '" method="POST" id="payhere_form">';
        $html .= '<input type="hidden" name="merchant_id" value="' . $this->merchant_id . '">';
        $html .= '<input type="hidden" name="return_url" value="' . cn("add_funds/payhere/complete") . '">';
        $html .= '<input type="hidden" name="cancel_url" value="' . cn("add_funds/unsuccess") . '">';
        $html .= '<input type="hidden" name="notify_url" value="' . cn("add_funds/payhere/ipn") . '">';
        $html .= '<input type="hidden" name="order_id" value="' . $transaction_id . '">';
        $html .= '<input type="hidden" name="items" value="Deposit to ' . get_option('website_name') . '">';
        $html .= '<input type="hidden" name="currency" value="' . $this->currency_code . '">';
        $html .= '<input type="hidden" name="amount" value="' . $amount . '">';
        $html .= '<input type="hidden" name="first_name" value="' . $users['first_name'] . '">';
        $html .= '<input type="hidden" name="last_name" value="' . $users['last_name'] . '">';
        $html .= '<input type="hidden" name="email" value="' . $users['email'] . '">';
        $html .= '<input type="hidden" name="phone" value="0000000000">';
        $html .= '<input type="hidden" name="address" value="Sri Lanka">';
        $html .= '<input type="hidden" name="city" value="Colombo">';
        $html .= '<input type="hidden" name="country" value="Sri Lanka">';
        $html .= '<input type="hidden" name="hash" value="' . $hash . '">';
        $html .= '</form>';
        $html .= '<script>document.getElementById("payhere_form").submit();</script>';

        if ($this->input->is_ajax_request()) {
            ms(['status' => 'success', 'redirect_url' => cn('add_funds/payhere/redirect?id=' . $transaction_id)]);
        }
    }

    public function redirect()
    {
        $transaction_id = get('id');
        if (!$transaction_id) {
            redirect(cn("add_funds"));
        }

        $transaction = $this->model->get('*', $this->tb_transaction_logs, ['ids' => $transaction_id, 'uid' => session('uid'), 'status' => 0]);
        if (!$transaction) {
            redirect(cn("add_funds"));
        }
        
        $users = session('user_current_info');
        $amount = $transaction->amount;
        $hash = strtoupper(md5($this->merchant_id . $transaction_id . number_format($amount, 2, '.', '') . $this->currency_code . strtoupper(md5($this->merchant_secret))));
        $action_url = ($this->mode == 'sandbox') ? 'https://sandbox.payhere.lk/pay/checkout' : 'https://www.payhere.lk/pay/checkout';

        $data = array(
            'action_url' => $action_url,
            'merchant_id' => $this->merchant_id,
            'return_url' => cn("add_funds/payhere/complete"),
            'cancel_url' => cn("add_funds/unsuccess"),
            'notify_url' => cn("add_funds/payhere/ipn"),
            'order_id' => $transaction_id,
            'items' => 'Deposit to ' . get_option('website_name'),
            'currency' => $this->currency_code,
            'amount' => $amount,
            'first_name' => $users['first_name'],
            'last_name' => $users['last_name'],
            'email' => $users['email'],
            'hash' => $hash
        );
        $this->load->view("payhere/redirect", $data);
    }

    public function complete()
    {
        set_session("transaction_id", get('order_id'));
        redirect(cn("add_funds/success"));
    }

    public function ipn()
    {
        $merchant_id = $_POST['merchant_id'];
        $order_id = $_POST['order_id'];
        $payhere_amount = $_POST['payhere_amount'];
        $payhere_currency = $_POST['payhere_currency'];
        $status_code = $_POST['status_code'];
        $md5sig = $_POST['md5sig'];

        $local_md5sig = strtoupper(md5($merchant_id . $order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5($this->merchant_secret))));

        if (($local_md5sig === $md5sig) && ($status_code == 2) ) {
            $transaction = $this->model->get('*', $this->tb_transaction_logs, ['ids' => $order_id, 'status' => 0]);
            if ($transaction) {
                $amount = $transaction->amount;
                $fee = 0;
                if ($this->take_fee_from_user) {
                    $fee = get_value($this->model->get('params', $this->tb_payments, ['id' => $this->payment_id])->params, 'take_fee_from_user');
                    $fee = $amount * ($fee / 100);
                }
                $final_amount = $amount - $fee;

                $this->db->update($this->tb_transaction_logs, ['status' => 1, 'transaction_id' => $_POST['payment_id'], 'txn_fee' => $fee], ['id' => $transaction->id]);
                $this->model->add_funds_bonus_email($transaction, $this->payment_id);
            }
        }
    }
}
