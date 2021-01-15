<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoWashCaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
			        Schema::create('auto_wash_cases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('case_name');                        
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
				 Schema::dropIfExists('auto_wash_cases');
    }
}
