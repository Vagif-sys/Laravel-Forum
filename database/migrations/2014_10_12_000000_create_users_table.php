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
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('is_admin')->default(0);
            $table->string('country')->nullable();
            $table->string('image')->nullable();
            $table->string('profession')->nullable();
            $table->string('bio')->nullable();
            $table->string('skills')->nullable();
            $table->string('education')->nullable();
            $table->string('is_deleted')->default(0);
            $table->string('is_verified')->default(0);
            $table->string('is_banned')->default(0);
            $table->string('rank')->default(0);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
