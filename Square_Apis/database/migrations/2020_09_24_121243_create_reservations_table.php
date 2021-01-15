<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('categories_id');
            $table->string('product_id');   
            //$table->string('product_owner_id');           
            $table->date('date');    
            $table->date('start_date');
            $table->date('finish_date');                   
            $table->string('price');
            $table->string('principal');
            $table->string('commission');  
            $table->string('comments')->nullable();                       
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('reservations');
    }
}
