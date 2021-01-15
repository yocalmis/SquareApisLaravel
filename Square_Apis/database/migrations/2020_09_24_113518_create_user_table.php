<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->nullable();
            $table->string('password');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();           
            $table->string('email')->nullable();
            $table->string('tel');
            $table->string('adress')->nullable();
            $table->boolean('status');
            $table->boolean('member_type');
            $table->integer('parent_id');
            //$table->integer('business_id'); 
			$table->string('comments'); 
            $table->date('start_date');
            $table->date('finish_date');
            $table->string('device')->nullable();           
            $table->integer('login_code')->nullable();  
            $table->string('key')->nullable();                                  
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
        Schema::dropIfExists('users');
    }
}
