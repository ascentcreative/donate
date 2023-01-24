<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('donate_profiles', function(Blueprint $table) {
            
            $table->id();
            $table->string('uuid');
            $table->integer('user_id')->nullable()->index();
            $table->string('donor_name');
            $table->string('donor_email');
            $table->float('amount');
            $table->string('recur')->nullable();
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

        Schema::dropIfExists('donate_profiles');
       
    }
}
