<?php
namespace App\Services;
class ProviderSecond extends HttpService
{
    protected function getUrl()
    {
        return env('API_URL') . 'provider2/email';
    }

    protected function getParams()
    {
        return [
            'linkedInProfileUrl' => $this->linked_in
        ];
    }

    protected function getEmails($response)
    {
        return $response;
    }
}
