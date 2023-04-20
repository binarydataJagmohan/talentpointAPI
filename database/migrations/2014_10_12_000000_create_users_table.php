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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['superadmin', 'admin', 'employee', 'employer', 'staff']);

            $table->integer('company_id')->nullable();
            $table->integer('available_resume_count')->nullable();

            $table->string('where_job_search')->nullable();
            $table->string('job_type')->nullable();
            $table->enum('job_status', ['ready_to_interview', 'open_to_offer', 'not_looking']);
            $table->string('where_currently_based')->nullable();
            $table->string('current_position')->nullable();
            $table->integer('profile_complete_percentage')->nullable();
            $table->boolean('unlock_instant_apply')->default(false);
            $table->string('linked_id')->nullable();
            $table->string('google_id')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('contact_no')->nullable();
            $table->integer('login_count')->nullable();
            $table->boolean('first_login')->default(false);
            $table->enum('is_approved', ['0', '1', '2']); //0=pending, 1=approved, 2=decline
            $table->enum('status', ['pending', 'active', 'deleted']);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
