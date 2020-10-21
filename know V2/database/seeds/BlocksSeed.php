<?php

use Illuminate\Database\Seeder;

class BlocksSeed extends Seeder
{
    public function run()
    {
        DB::table( 'bloks' )->insert( [
                                          'sort'       => '1',
                                          'class'      => 'default',
                                          'type_id'    => '1',
                                          'template_id' => '1',
                                          'created_at' => date( 'Y-m-d' ),
                                          'updated_at' => date( 'Y-m-d' ),
                                      ] );
        DB::table( 'bloks' )->insert( [
                                          'sort'       => '2',
                                          'class'      => 'default',
                                          'type_id'    => '1',
                                          'template_id' => '2',
                                          'created_at' => date( 'Y-m-d' ),
                                          'updated_at' => date( 'Y-m-d' ),
                                      ] );
        DB::table( 'bloks' )->insert( [
                                          'sort'       => '3',
                                          'class'      => 'default',
                                          'type_id'    => '1',
                                          'template_id' => '3',
                                          'created_at' => date( 'Y-m-d' ),
                                          'updated_at' => date( 'Y-m-d' ),
                                      ] );

    }
}

