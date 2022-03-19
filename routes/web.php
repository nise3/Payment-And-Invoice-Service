<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Helpers\Classes\CustomRouter;
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

$router->get("kafka",function (){
    $producer = Kafka::publishOn('kafka')
        ->withConfigOptions(['key' => 'value'])
        ->withKafkaKey('your-kafka-key')
        ->withKafkaKey('kafka-key')
        ->withHeaders(['header-key' => 'header-value']);

   return $producer->send();
});

