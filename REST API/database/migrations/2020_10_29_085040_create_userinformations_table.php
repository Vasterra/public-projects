<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserinformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userinformations', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->unique();
            $table->string("telephone", 100)->default('');
            $table->integer("type_of_contract")->default(0);
            $table->integer("id_country")->default(0);
            $table->float("rate")->default(0);
            $table->integer("rate_interval_id")->default(0);
            $table->dateTime("birdhday")->default(date("Y-m-d"));
            $table->string("address", 240)->default("");
            $table->integer("employement_id")->default(0);
            $table->integer("id_payment")->default(0);
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
        Schema::dropIfExists('userinformations');
    }
}
