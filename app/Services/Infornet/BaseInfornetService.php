<?php

namespace App\Services\Infornet;

use Illuminate\Support\Facades\Http;

abstract class BaseInfornetService
{
    protected $baseUrl;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->baseUrl = 'https://nhen90f0j3.execute-api.us-east-1.amazonaws.com/v1/api/';
        $this->username = config('services.infornet.username', 'user_infornet');
        $this->password = config('services.infornet.password', 'pass_infornet');
    }

    protected function client()
    {
        return Http::withBasicAuth($this->username, $this->password)
                   ->baseUrl($this->baseUrl)
                   ->acceptJson();
    }
}