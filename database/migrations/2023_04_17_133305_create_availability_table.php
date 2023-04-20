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
        Schema::create('availability', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('interview_id')->nullable();
            $table->date('availability_date')->nullable();
            $table->string('availabel')->nullable();
            $table->string('from_time')->nullable();
            $table->string('to_time')->nullable();
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
        Schema::dropIfExists('availability');
    }
};
