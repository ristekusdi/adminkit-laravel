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
        Schema::create('group_role', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->unsignedBigInteger('group_id')
                ->comment('For external user')
                ->nullable();
            $table->unsignedBigInteger('unud_group_id')
                ->comment('For Udayana user')
                ->nullable();

            // Index
            $table->index(['role_id', 'group_id', 'unud_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_role');
    }
};
