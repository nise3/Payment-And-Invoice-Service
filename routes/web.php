<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Helpers\Classes\CustomRouter;
use Enqueue\RdKafka\RdKafkaConnectionFactory;
use Junges\Kafka\Facades\Kafka;

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
        $router->post("ipn/{secretKey}", ["as" => "ipn", "uses" => "PaymentController@ipn"]);
        $router->post("success", ["as" => "success", "uses" => "PaymentController@success"]);
    });

    /** Service to service direct call without any authorization and authentication */
    $router->group(['prefix' => 'service-to-service-call', 'as' => 'service-to-service-call'], function () use ($router) {
        $router->post("payment-config", ["as" => "payment-config", "uses" => "PaymentController@paymentConfig"]);
        $router->post("pay-now", ["as" => "pay-now", "uses" => "PaymentController@payNow"]);
    });

});



