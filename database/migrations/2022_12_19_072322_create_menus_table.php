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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('path');
            $table->string('icon')->nullable();
            $table->unsignedInteger('parent');
            $table->unsignedInteger('order')->nullable();
            $table->unsignedBigInteger('created_by')->nullable(); // unud_sso_id
            $table->timestamp('created_at')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable(); // unud_sso_id
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable(); // unud_sso_id
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
