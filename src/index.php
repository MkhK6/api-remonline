<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

class Remonline
{
    private $apiKey;
    public $tokenInfo;
    private $client;
    private $type;
    private $lifeTimeToken = 600;

    public function __construct($apiKey)
    {
        $this->client = new Client(['base_uri' => 'https://api.remonline.ru/']);
        $this->apiKey = $apiKey;
    }

    public function contact($params = [])
    {
        if ($params == []) {
            $this->type = 'GET';
        } else $this->type = 'POST';

        $this->checkToken();
        $result = $this->client->request($this->type, 'clients/', [
            'query' => ['token' => $this->tokenInfo['token']],
            'form_params' => ['form_params' => $params]['form_params']
        ]);
        return json_decode($result->getBody()->getContents());
    }

    public function order($params = [])
    {
        if ($params == []) {
            $this->type = 'GET';
        } else $this->type = 'POST';

        $this->checkToken();
        $result = $this->client->request($this->type, 'order/', [
            'query' => ['token' => $this->tokenInfo['token']],
            'form_params' => ['form_params' => $params]['form_params']
        ]);
        return json_decode($result->getBody()->getContents());
    }

    public function update($params = [])
    {
        $this->checkToken();
        $result = $this->client->request('PUT', 'clients/', [
            'query' => ['token' => $this->tokenInfo['token']],
            'form_params' => ['form_params' => $params]['form_params']
        ]);
        return json_decode($result->getBody()->getContents());
    }

    public function updateStatus($params = [])
    {
        $this->checkToken();
        $result = $this->client->request('POST', 'order/status/', [
            'query' => ['token' => $this->tokenInfo['token']],
            'form_params' => ['form_params' => $params]['form_params']
        ]);
        return json_decode($result->getBody()->getContents());
    }

    private function getToken()
    {
        $url = 'token/new';
        $params = [
            'form_params' => ['api_key' => $this->apiKey]
        ];
        $request = $this->client->request('POST', $url, $params);
        $token = json_decode($request->getBody())->token;
        $this->tokenInfo['token'] = $token;
        $this->tokenInfo['time'] = time();
    }

    private function checkToken()
    {
        if (isset($this->tokenInfo['token']) && (time() - $this->tokenInfo['time'] <= $this->lifeTimeToken)) {
            return true;
        }
        $this->getToken();
    }
}
