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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->boolean('account_access')->default(true);
            $table->boolean('newsletter_access')->default(true);
            $table->boolean('recommendations_access')->default(true);
            $table->boolean('announcements_access')->default(true);
            $table->boolean('message_from_candidate_access')->default(true);
            $table->boolean('display_contact_no')->default(true);
            $table->boolean('display_email_address')->default(true);
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
        Schema::dropIfExists('settings');
    }
};
