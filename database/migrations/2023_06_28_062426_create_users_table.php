<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('social_type')->nullable();
            $table->string('social_id')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('gender')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('dob')->nullable();
            $table->string('language')->nullable();
            $table->integer('otp')->nullable();
            $table->text('address')->nullable();
            $table->integer('password_otp')->nullable();
            $table->string('timezone')->nullable();
            $table->string('verification_image')->nullable();
            $table->enum('is_premium', ['0', '1'])->default(0)->comment('0 is no premium, 1 is yes premium');
            $table->enum('verification_status', ['0', '1', '2'])->default(1)->comment('0 is pending, 1 is approve,2 is reject	');
            $table->enum('first_time_login', ['0', '1'])->default(0)->comment('0 is no, 1 is yes');
            $table->text('apple_id')->nullable();
            $table->text('google_id')->nullable();
            $table->enum('is_verify', ['0', '1'])->default(0)->comment('0->false, 1->true');
            $table->enum('status', ['0', '1'])->default(0);
            $table->boolean('is_deactivate')->default(false);
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
}
