<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Animals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'animals', function( Blueprint $table ) {
            $table->increments( 'id' );
            $table->string( 'name' )->nullable( FALSE );
            $table->string( 'description' )->nullable( FALSE );
            $table->integer( 'id_wiew' )->nullable( FALSE );
            $table->integer( 'id_category' )->nullable( FALSE );
            $table->timestamps();
        } );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'animals' );
    }
}
