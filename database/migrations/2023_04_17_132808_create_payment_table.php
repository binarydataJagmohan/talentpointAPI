<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('company_id');
            $table->integer('plan_id');
            $table->string('membership_id');
            $table->string('amount');
            $table->string('payment_gateway');
            $table->date('purchase_at');
            $table->string('transaction_id');
            $table->string('card_holder_name');
            $table->string('card_no');
            $table->string('card_expire_month_year');
            $table->string('card_cvv');
            $table->enum('status', ['pending', 'active', 'deleted']);
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
        Schema::dropIfExists('payment');
    }
};
