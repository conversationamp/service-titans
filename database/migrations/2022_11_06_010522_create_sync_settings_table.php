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
        Schema::create('sync_settings', function (Blueprint $table) {
            $table->id();
            //go high level
            $table->string('pipieline_id')->nullable();
            $table->string('pipieline_name')->nullable();
            $table->string('pipeline_stage_id')->nullable();
            $table->string('pipeline_stage_name')->nullable();
            $table->string('calendar_id')->nullable();
            $table->string('calendar_name')->nullable();
            $table->string('oppurtunity_status')->default('open');
            $table->string('appointment_status')->default('new');

            //service titans
            $table->string('titan_location_id')->nullable();
            $table->string('titan_location_name')->nullable();
            $table->string('business_unit_id')->nullable();
            $table->string('business_unit_name')->nullable();
            $table->string('compaign_id')->nullable();
            $table->string('compaign_name')->nullable();
            $table->string('job_type_id')->nullable();
            $table->string('job_type_name')->nullable();
            $table->string('priority')->nullable();
            $table->string('slot')->nullable();
            $table->string('invoice_id')->nullable();
            
            //main
            $table->boolean('is_default')->default(false);
            $table->integer('position')->nullable();
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
        Schema::dropIfExists('sync_settings');
    }
};
