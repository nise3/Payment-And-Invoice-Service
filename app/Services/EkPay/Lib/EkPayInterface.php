<?php

namespace App\Services\EkPay\Lib;

interface EkPayInterface
{
    public function getMerchantInfo();

    public function validation(array $data);

    public function buildPayload(array $data);

    public function callApi(array $payload);
}
