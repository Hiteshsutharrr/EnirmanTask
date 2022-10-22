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
        Schema::create('ifsc_codes', function (Blueprint $table) {
            $table->id();
            $table->string('ifsc_code');
            $table->string('name');
            $table->string('city');
            $table->string('state');
            $table->bigInteger('pincode');
            $table->bigInteger('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->SoftDeletes();
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
        Schema::dropIfExists('ifsc_codes');
    }
};
