<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Helpers\Classes\CustomRouter;
use App\Models\PaymentPurpose;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

$customRouter = function (string $as = '') use ($router) {
    $custom = new CustomRouter($router);
    return $custom->as($as);
};

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1', 'as' => 'api.v1'], function () use ($router, $customRouter) {

    $router->get('/', ['as' => 'api-info', 'uses' => 'ApiInfoController@apiInfo']);

    $router->post('/file-upload', ['as' => 'api-info.upload', 'uses' => 'ApiInfoController@fileUpload']);

    /** Auth routes */
    $router->group(['middleware' => 'auth'], function () use ($customRouter, $router) {

    });


    $router->get('youth-enroll-courses', ["as" => "courses.youth-enroll-courses", "uses" => "CourseEnrollmentController@getYouthEnrollCourses"]);

    /** Public Apis */
    $router->group(['prefix' => 'public', 'as' => 'public'], function () use ($router) {
        /** Course details with trainer */


    });

    //Service to service direct call without any authorization and authentication
    $router->group(['prefix' => 'service-to-service-call', 'as' => 'service-to-service-call'], function () use ($router) {
    });

    $router->group(["prefix" => "course-enrollment", "as" => "course-enrollment"], function () use ($router) {
        $router->post('payment-by-ek-pay/pay-now', ["as" => "payment-by-ek-pay.pay-now", "uses" => "CourseEnrollmentPaymentController@payNowByEkPay"]);
        $router->get('payment-by-ek-pay/success', ["as" => "payment-by-ek-pay.success", "uses" => "CourseEnrollmentPaymentController@ekPayPaymentSuccess"]);
        $router->get('payment-by-ek-pay/failed', ["as" => "payment-by-ek-pay.fail", "uses" => "CourseEnrollmentPaymentController@ekPayPaymentFail"]);
        $router->get('payment-by-ek-pay/cancel', ["as" => "payment-by-ek-pay.cancel", "uses" => "CourseEnrollmentPaymentController@ekPayPaymentCancel"]);
        $router->post('payment-by-ek-pay/ipn-handler/{secretToken}', ["as" => "payment.ipn-handler", "uses" => "CourseEnrollmentPaymentController@ekPayPaymentIpnHandler"]);
    });
});

$router->get("/publish", function () {
   // return Redis::set("name", "piyal");
//    Redis::publish('payment.' . PaymentPurpose::PAYMENT_PURPOSE_CODE_COURSE_ENROLLMENT, json_encode([
//        'name' => PaymentPurpose::PAYMENT_PURPOSE_CODE_COURSE_ENROLLMENT
//    ]));
//
//    Redis::publish('payment' . PaymentPurpose::PAYMENT_PURPOSE_CODE_RTO_APPLICATION, json_encode([
//        'name' => PaymentPurpose::PAYMENT_PURPOSE_CODE_RTO_APPLICATION
//    ]));
//
//    Redis::publish('payment.' . PaymentPurpose::PAYMENT_PURPOSE_CODE_NASCIB_MEMBERSHIP_PAYMENT, json_encode([
//        'name' => PaymentPurpose::PAYMENT_PURPOSE_CODE_NASCIB_MEMBERSHIP_PAYMENT
//    ]));
    Redis::psubscribe(['*'], function ($message, $channel) {
        return [
            $message,
            $channel
        ];
    });
});

