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
        $router->post("ipn/{secretKey}", ["as" => "ipn", "uses" => "PaymentController@ipnHandler"]);
    });

    /** Service to service direct call without any authorization and authentication */
    $router->group(['prefix' => 'service-to-service-call', 'as' => 'service-to-service-call'], function () use ($router) {

    });


    $router->get("publish", function () {
        $broker = new \App\Helpers\Classes\Broker();
        $broker->publishOn("topic-1", [
            "name" => "Broker22222",
            "email" => "email@gmail.com222"
        ]);
    });
    $router->get("con1", function () {
        $broker = new \App\Helpers\Classes\Broker();
        $sub = $broker->subscribeOn("topic-1");
        $message = $sub->receive();
        $sub->acknowledge($message);
        return $message->getBody();
    });
    $router->get("con2", function () {
        $consumer = \Junges\Kafka\Facades\Kafka::createConsumer(['topic']);

    });
    $router->get("test", function () {
        request()->offsetSet('exchange_name', 'mailSms');
        request()->offsetSet('queue_config_name', 'mail');
        request()->offsetSet('retry_mechanism', true);
        event(new \App\Events\PaymentSuccessEvent([
            "testing"
        ]));

        \Illuminate\Support\Facades\Log::debug("djdjjdjdjjdjd", [
            "time" => time()
        ]);
    });
});



