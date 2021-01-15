<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoWashCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		
		
        Schema::create('auto_wash_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->integer('user_id');
            $table->string('name');
            $table->string('coordinates')->nullable();
            $table->string('image')->nullable();           
            $table->string('email')->nullable();
            $table->string('tel')->nullable();
            $table->string('adress')->nullable();
            $table->string('country')->nullable();			
            $table->boolean('status'); 
			$table->string('comments'); 
            $table->date('start_date');                            
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
		        Schema::dropIfExists('auto_wash_companies');
    }
}
