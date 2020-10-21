<?php

use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    public function run()
    {
        DB::table( 'block_categories' )->insert( [
            'name' => 'Загаловки',
            'created_at' => date( 'Y-m-d' ),
            'updated_at' => date( 'Y-m-d' )
                                                 ] );
        DB::table( 'block_categories' )->insert( [
            'name' => 'Абзацы',
            'created_at' => date( 'Y-m-d' ),
            'updated_at' => date( 'Y-m-d' )
                                                 ] );
        DB::table( 'block_categories' )->insert( [
            'name' => 'Таблицы',
            'created_at' => date( 'Y-m-d' ),
            'updated_at' => date( 'Y-m-d' )
                                                 ] );
    }
}
