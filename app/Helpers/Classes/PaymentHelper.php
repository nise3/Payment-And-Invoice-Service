<?php

namespace App\Helpers\Classes;

class PaymentHelper
{
    const INVOICE_SIZE = 36;
    const GATEWAY_EKPAY = 'EKPAY';
    const GATEWAY_SSLCOMMERZ = 'SSLCOMMERZ';
    const GATEWAY_BKASH = 'BKASH';
    const GATEWAY_NAGAD = 'NAGAD';
    const GATEWAY_PORTWALLET = 'PORTWALLET';
    const GATEWAY_SHURJOPAY = 'SHURJOPAY';
    const GATEWAY_AAMARPAY = 'AAMARPAY';
    const GATEWAY_2CHECKOUT = '2CHECKOUT';
    const GATEWAY_AUTHORIZEDOTNET = 'AUTHORIZEDOTNET';
    const GATEWAY_STRIPE = 'STRIPE';
    const GATEWAY_PAYPAL = 'PAYPAL';

    /** Payment Purposes */
    const PURPOSE_COURSE_ENROLLMENT = 'COURSE_ENROLLMENT';
    const PURPOSE_ASSOCIATION_NASCIB_MEMBERSHIP = 'ASSOCIATION_NASCIB_MEMBERSHIP';
    const PURPOSE_RPL_CERTIFICATION_APPLICATION = 'RPL_CERTIFICATION_APPLICATION';
    const PURPOSE_RTO_TO_BTEB = 'RTO_TO_BTEB';

    /** Payment Config Accessors */

    const PAYMENT_CONFIG_ACCESSOR_INDUSTRY_ASSOCIATION = "INDUSTRY_ASSOCIATION";
    const PAYMENT_CONFIG_ACCESSOR_INDUSTRY = "INDUSTRY";
    const PAYMENT_CONFIG_ACCESSOR_INSTITUTE = "INSTITUTE";
    const PAYMENT_CONFIG_ACCESSOR_RTO = "RTO";
    const PAYMENT_CONFIG_ACCESSOR_NISE = "NISE";

    const ALL_PAYMENT_GATEWAYS = [
        self::GATEWAY_EKPAY => 'Ekpay',
        self::GATEWAY_SSLCOMMERZ => 'SSLCOMMERZ',
        self::GATEWAY_BKASH => 'bKash',
        self::GATEWAY_NAGAD => 'Nagad',
        self::GATEWAY_PORTWALLET => 'PortWallet',
        self::GATEWAY_SHURJOPAY => 'ShurjaPay',
        self::GATEWAY_AAMARPAY => 'Aamarpay',
        self::GATEWAY_2CHECKOUT => '2Checkout',
        self::GATEWAY_AUTHORIZEDOTNET => 'Authorize.net',
        self::GATEWAY_STRIPE => 'Stripe',
        self::GATEWAY_PAYPAL => 'Paypal'
    ];
    const ALL_PURPOSES = [
        self::PURPOSE_COURSE_ENROLLMENT,
        self::PURPOSE_ASSOCIATION_NASCIB_MEMBERSHIP,
        self::PURPOSE_RPL_CERTIFICATION_APPLICATION,
        self::PURPOSE_RTO_TO_BTEB,
    ];
    const ALL_ACCESSORS = [
        self::PAYMENT_CONFIG_ACCESSOR_INDUSTRY_ASSOCIATION => "Industry Association",
        self::PAYMENT_CONFIG_ACCESSOR_INDUSTRY => "Industry",
        self::PAYMENT_CONFIG_ACCESSOR_INSTITUTE => "Institute",
        self::PAYMENT_CONFIG_ACCESSOR_RTO => "RTO",
        self::PAYMENT_CONFIG_ACCESSOR_NISE => "NISE",
    ];
    const PURPOSE_RELATED_INVOICE_PREFIX = [
        self::PURPOSE_COURSE_ENROLLMENT => "EN",
        self::PURPOSE_ASSOCIATION_NASCIB_MEMBERSHIP => "NM",
        self::PURPOSE_RPL_CERTIFICATION_APPLICATION => "RA",
        self::PURPOSE_RTO_TO_BTEB => "OP",
    ];

    /** Global Rabbit Queue Config for payment service wise */
    const INSTITUTE_PAYMENT = "payment_institute";
    const INDUSTRY_ASSOCIATION_PAYMENT = "payment_industry_association";
    const RABBIT_PAYMENT_QUEUE_LIST = [
        self::INSTITUTE_PAYMENT,
        self::INDUSTRY_ASSOCIATION_PAYMENT
    ];

    const PURPOSE_RELATED_PAYMENT_QUEUE = [
        self::PURPOSE_COURSE_ENROLLMENT => self::INSTITUTE_PAYMENT,
        self::PURPOSE_ASSOCIATION_NASCIB_MEMBERSHIP => self::INDUSTRY_ASSOCIATION_PAYMENT,
        self::PURPOSE_RPL_CERTIFICATION_APPLICATION => self::INSTITUTE_PAYMENT,
        self::PURPOSE_RTO_TO_BTEB => self::INSTITUTE_PAYMENT,
    ];

    /**Payment status*/
    const PAYMENT_STATUS_SUCCESS = 1;
    const PAYMENT_STATUS_PENDING = 2;
    const PAYMENT_STATUS_REJECTED = 3;
    const PAYMENT_STATUS_FAILED = 4;
    const PAYMENT_STATUS_CANCEL = 5;

    const EK_PAY_TRANSACTION_SUCCESS = 1020;
    const EK_PAY_TRANSACTION_FAIL = 1021;
    const EK_PAY_TRANSACTION_CANCEL = 1022;

    const SSL_STATUS_CODE_FAILED = "FAILED";
    const SSL_STATUS_CODE_SUCCESS = "SUCCESS";

    const GENERAL = 1;
    const PHYSICAL_GOODS = 2;
    const NON_PHYSICAL_GOODS = 3;
    const AIRLINE_TICKETS = 4;
    const TRAVEL_VERTICAL = 5;
    const TELECOM_VERTICAL = 6;

    const SSL_COM_PRODUCT_PROFILE = [
        self::GENERAL => "General",
        self::PHYSICAL_GOODS => "Physical Goods",
        self::NON_PHYSICAL_GOODS => "Non Physical Goods",
        self::AIRLINE_TICKETS => "Airline Tickets",
        self::TRAVEL_VERTICAL => "Travel Vertical",
        self::TELECOM_VERTICAL => "Telecom Vertical"
    ];

   // VALID / FAILED / CANCELLED / EXPIRED / UNATTEMPTED
    const SSL_PAYMENT_VALID="VALID";
    const SSL_PAYMENT_VALIDATED="VALIDATED";
    const SSL_PAYMENT_FAILED="FAILED";
    const SSL_PAYMENT_CANCELLED="CANCELLED";
    const SSL_PAYMENT_EXPIRED="EXPIRED";
    const SSL_PAYMENT_UNATTEMPTED="UNATTEMPTED";
}
