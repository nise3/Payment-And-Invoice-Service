<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transaction_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->char('invoice', 36);
            $table->string('payment_purpose');
            $table->unsignedInteger('payment_purpose_related_id');
            $table->string('payment_gateway_type')
                ->comment("1 => Ek-Pay, 2 => SSLCOMMERZ, 2 => DBBL Mobile Banking, 3 => Bkash, 4 => Nagad, 5 => PortWallet");
            $table->string('customer_id');
            $table->string('customer_name', 500)->nullable();
            $table->string('customer_name_en', 250)->nullable();
            $table->string('customer_mobile', 15)->nullable();
            $table->string('customer_email', 150)->nullable();
            $table->char('transaction_currency', 3)->comment('BDT');
            $table->unsignedDecimal('amount', 12, 4);
            $table->json('request_payload')->nullable();
            $table->json('response_message')->nullable();
            $table->string('payment_status')->default(2)->comment("1=>Success, 2=>Pending, 3=>Fail, 5=>Cancel");
            $table->dateTime("transaction_created_at");
            $table->dateTime("transaction_completed_at")->nullable();
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
        Schema::dropIfExists('payment_transaction_logs');
    }
}
