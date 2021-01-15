<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoWashSubserviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
					Schema::create('auto_wash_subservices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');   
            $table->string('service_name');   			
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
						 Schema::dropIfExists('auto_wash_subservices');
    }
}
