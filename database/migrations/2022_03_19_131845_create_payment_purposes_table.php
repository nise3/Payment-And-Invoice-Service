<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentPurposesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_purposes', function (Blueprint $table) {
            $table->increments("id");
            $table->string("code")->unique();
            $table->string("title");
            $table->string("title_en")->nullable();
            $table->string("invoice_prefix")->unique();
            $table->string("invoice_key_size")->nullable();
            $table->string("payment_related_queue_name");
            $table->unsignedTinyInteger("row_status")->default(1);
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
        Schema::dropIfExists('payment_purposes');
    }
}
