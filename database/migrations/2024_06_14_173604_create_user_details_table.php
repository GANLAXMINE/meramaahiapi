<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('religion')->nullable();
            $table->string('community')->nullable();
            $table->string('relationship_status')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('education_course')->nullable();
            $table->string('education_college_name')->nullable();
            $table->string('education_college_place')->nullable();
            $table->string('working')->nullable();
            $table->string('job_role')->nullable();
            $table->string('company_name')->nullable();
            $table->string('workplace')->nullable();
            $table->text('passions')->nullable(); // Assuming 'passions' will be stored as JSON or text
            $table->string('profile_for')->nullable();
            $table->text('about_me')->nullable();
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
        Schema::dropIfExists('user_details');
    }
}
