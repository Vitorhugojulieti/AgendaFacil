<?php
namespace app\classes;
use Google\Client;
use GuzzleHttp\Client as GuzzleClient;
use Google\Service\Oauth2\Userinfo;
use Google\Service\Oauth2 as ServiceOAuth2;

class GoogleClient{
    public readonly Client $client;
    private Userinfo $data;

    public function __construct(){
        $this->client = new Client();
    }

    public function init(){
        $guzzleClient = new GuzzleClient([
            'curl' => [
                CURLOPT_SSL_VERIFYPEER => false, // ou false, dependendo das suas necessidades
            ]
        ]);
        $this->client->setHttpClient($guzzleClient);
        $this->client->setAuthConfig('credentials.json');
        $this->client->setRedirectUri('http://localhost:8889');
        $this->client->addScope(ServiceOAuth2::USERINFO_EMAIL);
        $this->client->addScope(ServiceOAuth2::USERINFO_PROFILE);
    }

    public function generateAuthLink(){
        return $this->client->createAuthUrl();
    }

    public function authorized(){
        if(isset($_GET['code'])){
            $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
            $this->client->setAccessToken($token['access_token']);      
            $googleService = new ServiceOAuth2($this->client);
            $this->data = $googleService->userinfo->get();
            // var_dump($this->data);
            return true;
        }
        return false;
    }

    public function getData(){
        return $this->data;
    }
}

?>