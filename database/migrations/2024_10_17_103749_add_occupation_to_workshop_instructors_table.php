<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('workshop_instructors', function (Blueprint $table) {
            $table->string('occupation'); // Correct the typo
        });
    }

    public function down()
    {
        Schema::table('workshop_instructors', function (Blueprint $table) {
            $table->dropColumn('occupation'); // In case of rollback
        });
    }
};
