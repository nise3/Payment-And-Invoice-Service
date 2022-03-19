<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentPurposeConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_purpose_configuration', function (Blueprint $table) {
            $table->unsignedInteger('payment_purpose_id');
            $table->unsignedInteger('payment_configuration_id');
            $table->foreign('payment_purpose_id',"purpose_configuration_fk_id")
                ->references('id')
                ->on('payment_purposes')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_purpose_configurations');
    }
}
