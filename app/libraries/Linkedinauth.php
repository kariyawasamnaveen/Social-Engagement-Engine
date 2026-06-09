<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Linkedinauth {

    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $scopes = 'openid profile email';

    public function __construct() {
        $this->client_id = get_option('social_login_linkedin_app_id');
        $this->client_secret = get_option('social_login_linkedin_secret_key');
        $this->redirect_uri = cn('auth/callback/linkedin');
    }

    public function createLoginUrl() {
        $state = bin2hex(random_bytes(16));
        set_session('linkedin_oauth_state', $state);
        
        $params = [
            'response_type' => 'code',
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'state' => $state,
            'scope' => $this->scopes
        ];
        
        return 'https://www.linkedin.com/oauth/v2/authorization?' . http_build_query($params);
    }

    public function handleCallback() {
        if (!isset($_GET['code']) || !isset($_GET['state'])) {
            return false;
        }
        
        // State validation
        $saved_state = session('linkedin_oauth_state');
        if ($_GET['state'] !== $saved_state) {
            return false;
        }

        // Get Access Token
        $token_url = 'https://www.linkedin.com/oauth/v2/accessToken';
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

        // Get User Info (OpenID Connect)
        $userinfo_url = 'https://api.linkedin.com/v2/userinfo';
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
            // Standardize output to match Googleauth object style roughly
            $userInfo = new stdClass();
            $userInfo->email = $user_data['email'];
            $userInfo->givenName = isset($user_data['given_name']) ? $user_data['given_name'] : '';
            $userInfo->familyName = isset($user_data['family_name']) ? $user_data['family_name'] : '';
            return $userInfo;
        }

        return false;
    }
}
