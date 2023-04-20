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
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('logo');
            $table->string('favicon');

            $table->enum('payment_gateway', ['stripe']);
            $table->string('stripe_test_secret_key');
            $table->string('stripe_test_publish_key');
            $table->string('stripe_live_secret_key');
            $table->string('stripe_live_publish_key');
            
            $table->string('homepage_meta_tag');
            $table->string('homepage_meta_title');
            $table->string('homepage_meta_description');

            $table->string('jobs_meta_tag');
            $table->string('jobs_meta_title');
            $table->string('jobs_meta_description');

            $table->string('carrer_meta_tag');
            $table->string('carrer_meta_title');
            $table->string('carrer_meta_description');

            $table->string('about_meta_tag');
            $table->string('about_meta_title');
            $table->string('about_meta_description');

            $table->string('employer_meta_tag');
            $table->string('employer_meta_title');
            $table->string('employer_meta_description');

            $table->string('employee_meta_tag');
            $table->string('employee_meta_title');
            $table->string('employee_meta_description');

            $table->string('pricing_meta_tag');
            $table->string('pricing_meta_title');
            $table->string('pricing_meta_description');

            $table->string('blog_listing_meta_tag');
            $table->string('blog_listing_meta_title');
            $table->string('blog_listing_meta_description');
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
        Schema::dropIfExists('admin_settings');
    }
};
