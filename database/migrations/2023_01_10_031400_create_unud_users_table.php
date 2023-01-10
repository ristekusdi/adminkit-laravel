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
        Schema::create('unud_users', function (Blueprint $table) {
            $table->string('id');
            $table->string('name');
            $table->string('identifier'); // nip/nim
            $table->string('email')->nullable();
            $table->string('username');
            $table->unsignedBigInteger('sso_id');
            $table->tinyInteger('user_type_id');
            $table->timestamps();

            // Index
            $table->index(['name', 'identifier']);
            $table->index(['email', 'username']);
            $table->index(['sso_id', 'user_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unud_users');
    }
};
