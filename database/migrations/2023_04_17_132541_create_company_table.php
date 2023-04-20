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
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('company_website')->nullable();
            $table->string('company_location')->nullable();
            $table->string('company_sector')->nullable();
            $table->string('no_of_employees')->nullable();
            $table->longText('company_description')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_contact_no')->nullable();
            $table->integer('available_resume_count')->nullable();
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
        Schema::dropIfExists('company');
    }
};
