<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Googleauth {

    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $scopes = 'email profile';

    public function __construct() {
        $this->client_id = get_option('social_login_google_app_id');
        $this->client_secret = get_option('social_login_google_secret_key');
        $this->redirect_uri = cn('auth/callback/google');
    }

    public function createLoginUrl() {
        $params = [
            'response_type' => 'code',
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'scope' => $this->scopes,
            'access_type' => 'online',
            'prompt' => 'select_account'
        ];
        
        return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
    }

    public function handleCallback() {
        if (!isset($_GET['code'])) {
            return false;
        }

        // 1. Get Access Token
        $token_url = 'https://oauth2.googleapis.com/token';
        $params = [
            'grant_type' => 'authorization_code',
            'code' => $_GET['code'],
            'redirect_uri' => $this->redirect_uri,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $token_data = json_decode($response, true);
        if (!isset($token_data['access_token'])) {
            return false;
        }

        $access_token = $token_data['access_token'];
        set_session('access_token', $token_data);

        // 2. Get User Info
        $userinfo_url = 'https://www.googleapis.com/oauth2/v3/userinfo';
        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_URL, $userinfo_url);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $access_token
        ]);
        $user_response = curl_exec($ch2);
        curl_close($ch2);

        $user_data = json_decode($user_response, true);
        
        if (isset($user_data['email'])) {
            $userInfo = new stdClass();
            $userInfo->email = $user_data['email'];
            $userInfo->givenName = isset($user_data['given_name']) ? $user_data['given_name'] : '';
            $userInfo->familyName = isset($user_data['family_name']) ? $user_data['family_name'] : '';
            return $userInfo;
        }

        return false;
    }
}
