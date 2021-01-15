<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('categories_id');
            $table->integer('product_id');           
            $table->integer('user_id');
            $table->text('comment');           
            $table->string('star');
            $table->string('image');                                  
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
        Schema::dropIfExists('comments');
    }
}
