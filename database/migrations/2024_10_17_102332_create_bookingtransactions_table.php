<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('bookingtransactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workshop_id');
            $table->unsignedBigInteger('participant_id');
            $table->timestamps();
            $table->softDeletes(); // Optional: If you want to use soft deletes
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookingtransactions');
    }
}
