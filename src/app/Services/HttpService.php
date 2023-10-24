<?php
namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

abstract class HttpService
{
    public function __construct(public $name, public $company, public $linked_in) {
    }
    public function handle() {
        $client = new Client();
        $response = $client->request('GET', $this->getUrl(), [
            'headers' => ['Authorization' => env('LOGIN_BEARER')],
            'query' => $this->getParams()
        ]);
        return $this->getEmails(json_decode($response->getBody()->getContents(), true));
    }

    abstract protected function getEmails($response);

    abstract protected function getUrl();
    abstract protected function getParams();
}
