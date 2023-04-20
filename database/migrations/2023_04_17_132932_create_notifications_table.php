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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('notification');
            $table->string('link');
            $table->boolean('is_read')->default(false);
            $table->enum('notification_type', ['jobs', 'job_apply', 'membership', 'message', 'interview', 'register', 'forget_password', 'login', 'resume_view', 'resume_view_count']);
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
        Schema::dropIfExists('notifications');
    }
};
