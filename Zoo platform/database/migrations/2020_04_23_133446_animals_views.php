<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnimalsViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'animal_views', function( Blueprint $table ) {
            $table->id();
            $table->string( 'name' )->nullable( FALSE );
            $table->string( 'slug', 100 )->unique()->nullable( FALSE );
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
        Schema::dropIfExists( 'animal_views' );
    }
}
