<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('configuration_owner')->comment("INDUSTRY_ASSOCIATION,INDUSTRY,INSTITUTE,RTO");
            $table->unsignedInteger('configuration_owner_id');
            $table->string('payment_gateway_type')->comment("EK_PAY,SSL_COMMERZ");
            $table->json("configuration");
            $table->unsignedTinyInteger("row_status");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_configurations');
    }
}
