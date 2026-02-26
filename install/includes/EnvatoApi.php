<?php

class EnvatoApi
{
    protected $api_token;
    protected $config;
    protected $client;
    protected $params;
    protected $secret_key;

    public function __construct($params = [])
    {
        $this->api_token = 'My5MBQDtOnjmo3lbKwWSYBwBtjjM3d8l';
        $this->secret_key = 'aHR0cHM6Ly9zbWFydHBhbmVsc21tLmNvbS9wY192ZXJpZnkvaW5zdGFsbA';
        $this->params = $params;
    }

    public function check_valid_pc()
    {
        $item_pc = trim($this->params['item_pc']);
        if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $item_pc)) {
            ms(array(
                "status" => "error",
                "message" => "Invalid code",
            ));
        }
        if ($this->params['buy_from'] == 'third_party') {
            return $this->third_party();
        } else {
            return $this->directly();
        }
    }

    private function directly()
    {
        return $this->install($this->params);
    }

    private function third_party()
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$this->params['item_pc']}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer {$this->api_token}",
            ),
        ));
        $response = @curl_exec($ch);
        if (curl_errno($ch) > 0) {
            ms(array(
                "status" => "error",
                "message" => "Error connecting to API: " . curl_error($ch),
            ));
        }
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($responseCode === 404) {
            ms(array(
                "status" => "error",
                "message" => "The purchase code was invalid",
            ));
        }
        if ($responseCode !== 200) {
            ms(array(
                "status" => "error",
                "message" => "Failed to validate code due to an error: HTTP {$responseCode}",
            ));
        }
        $body = @json_decode($response);
        if ($body === false && json_last_error() !== JSON_ERROR_NONE) {
            ms(array(
                "status" => "error",
                "message" => "Error parsing response",
            ));
        }
        if ($body->item->id == $this->params['item_id']) {
            return $this->install($this->params);
        } else {
            return false;
        }
    }

    private function install()
    {
        repare_inc(get_json_content($this->secret_key, array_merge(params(), ['purchase_code' => $this->params['item_pc']])));
        return true;
    }
}
