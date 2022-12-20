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
        Schema::create('contacts', function (Blueprint $table) {
        
            $table->id();
            $table->string('go_contact_id')->nullable();
            $table->string('titan_customer_id')->nullable();
            $table->string('location')->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('contacts');
    }
};
