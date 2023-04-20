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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('sector_id')->nullable();
            $table->string('job_title')->nullable();
            $table->longText('job_description')->nullable();
            $table->string('type_of_position')->nullable();
            $table->string('job_country')->nullable();
            $table->string('industry')->nullable();
            $table->string('experience')->nullable();
            $table->string('skills_required')->nullable();
            $table->string('monthly_fixed_salary_currency')->nullable();
            $table->string('monthly_fixed_salary_min')->nullable();
            $table->string('monthly_fixed_salary_max')->nullable();
            $table->string('available_vacancies')->nullable();
            $table->date('deadline')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('job_type', ['fulltime', 'parttime', 'contract', 'freelance']);
            $table->enum('job_status', ['active', 'closed', 'expired', 'deleted']);
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
        Schema::dropIfExists('jobs');
    }
};
