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
        Schema::create('opportuninties', function (Blueprint $table) {

            $table->id();
            $table->string('opportunity_id')->nullable();
            $table->string('location_id')->nullable();
            $table->string('job_id')->nullable();
            $table->longText('go_response')->nullable();
            $table->longText('titan_response')->nullable();
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
        Schema::dropIfExists('opportuninties');
    }
};
