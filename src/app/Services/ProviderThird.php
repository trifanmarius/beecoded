<?php
namespace App\Services;
class ProviderThird extends HttpService
{
    protected function getUrl()
    {
        return env('API_URL') . 'provider3/email';
    }

    protected function getParams()
    {
        return [
            'linkedInProfileUrl' => $this->linked_in,
            'company' => $this->company
        ];
    }
    protected function getEmails($response)
    {
        $emails = [];
        foreach ($response as $data) {
            $emails[] = $data['Email'];
        }
        return $emails;
    }
}
