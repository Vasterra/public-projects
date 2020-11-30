<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        for($i=1; $i < 6; $i++) {
        	DB::table('formulas')->insert([ 'title' => 'Formula '.$i, 'name' => 'Name '.$i, 'value' => '']);
        }
        DB::table('settings')->insert([ 'name' => 'order', 'value' => '']);
    }
}
