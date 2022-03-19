<?php

namespace App\Models;


class PaymentConfiguration extends BaseModel
{
    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE;

    /** INDUSTRY_ASSOCIATION,INDUSTRY,INSTITUTE,RTO */
    public const PAYMENT_CONFIG_OWNER_INDUSTRY_ASSOCIATION = "INDUSTRY_ASSOCIATION";
    public const PAYMENT_CONFIG_OWNER_INDUSTRY = "INDUSTRY";
    public const PAYMENT_CONFIG_OWNER_INSTITUTE = "INSTITUTE";
    public const PAYMENT_CONFIG_OWNER_RTO = "RTO";

    public const PAYMENT_CONFIG_OWNERS = [
        self::PAYMENT_CONFIG_OWNER_INDUSTRY_ASSOCIATION => "Industry Association",
        self::PAYMENT_CONFIG_OWNER_INDUSTRY => "Industry",
        self::PAYMENT_CONFIG_OWNER_INSTITUTE => "Institute",
        self::PAYMENT_CONFIG_OWNER_RTO => "RTO",
    ];

    /** Payment Gateway Type */
    public const EK_PAY_LABEL = " EK_PAY";
    public const SSLCOMMERZ_LABEL = "SSL_COMMERZ";
    public const DBBL_MOBILE_BANKING = "DBBL_MOBILE_BANKING";
    public const BKASH = "BKASH";
    public const PORT_WALLET = "PORT_WALLET";

    public const PAYMENT_GATEWAYS = [
        self::EK_PAY_LABEL => "Ek Pay",
        self::SSLCOMMERZ_LABEL => "Ssl Commerz",
        self::DBBL_MOBILE_BANKING => "DBBL Mobile Banking",
        self::BKASH => "BKash",
        self::PORT_WALLET => "Port Wallet"
    ];
}
