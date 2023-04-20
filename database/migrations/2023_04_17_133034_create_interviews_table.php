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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->integer('job_id');
            $table->integer('company_id');
            $table->integer('applicant_id');
            $table->string('meeting_link');
            $table->date('interview_schedule_date');
            $table->date('interview_schedule_time');
            $table->enum('interview_status', ['pending', 'completed', 'deleted', 'canceled']);
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
        Schema::dropIfExists('interviews');
    }
};
