<?php
namespace App\Services;

class ProviderFirst extends HttpService
{
   protected function getUrl()
   {
       return env('API_URL') . 'provider1/email';
   }

    protected function getParams()
    {
        return [
            'name' => $this->name,
            'company' => $this->company
        ];
    }

    protected function getEmails($response)
    {
        $emails = [];
        foreach ($response as $data) {
            $emails[] = $data['email'];
        }
        return $emails;
    }
}
