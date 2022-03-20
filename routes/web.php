<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Helpers\Classes\CustomRouter;

$customRouter = function (string $as = '') use ($router) {
    $custom = new CustomRouter($router);
    return $custom->as($as);
};

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1', 'as' => 'api.v1'], function () use ($router, $customRouter) {

    $router->get('/', ['as' => 'api-info', 'uses' => 'ApiInfoController@apiInfo']);

    /** Public Apis */
    $router->group(['prefix' => 'public', 'as' => 'public'], function () use ($router) {
        $router->post("pay-now", ["as" => "pay-now", "uses" => "PaymentController@payNow"]);
        $router->post("ipn/{secretKey}", ["as" => "ipn", "uses" => "PaymentController@ipnHandler"]);
    });

    /** Service to service direct call without any authorization and authentication */
    $router->group(['prefix' => 'service-to-service-call', 'as' => 'service-to-service-call'], function () use ($router) {

    });

});

$router->get("config", function () {
    $paymentConfig = \App\Models\PaymentPurpose::where('code', \App\Models\PaymentPurpose::PAYMENT_PURPOSE_CODE_COURSE_ENROLLMENT)->firstOrFail();
    $paymentConfigData=$paymentConfig->paymentConfigurations(\App\Models\PaymentConfiguration::EK_PAY_LABEL)->firstOrFail();
    $configChild = env('IS_SANDBOX', false) ? "sandbox" : "production";
    return $paymentConfigData['configuration'][$configChild];
});


