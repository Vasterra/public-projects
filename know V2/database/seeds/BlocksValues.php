<?php

use Illuminate\Database\Seeder;

class BlocksValues extends Seeder
{
    public function run()
    {
        DB::table( 'blocks_values' )->insert( [
                                                  'block_id'      => '1',
                                                  'value_editing' => 'Заг 1 ред',
                                                  'created_at'    => date( 'Y-m-d' ),
                                                  'updated_at'    => date( 'Y-m-d' ),
                                              ] );
        DB::table( 'blocks_values' )->insert( [
                                                  'block_id'      => '2',
                                                  'value_editing' => 'Заг 2 ред',
                                                  'created_at'    => date( 'Y-m-d' ),
                                                  'updated_at'    => date( 'Y-m-d' ),
                                              ] );
        DB::table( 'blocks_values' )->insert( [
                                                  'block_id'      => '3',
                                                  'value_editing' => 'Заг 3 ред',
                                                  'created_at'    => date( 'Y-m-d' ),
                                                  'updated_at'    => date( 'Y-m-d' ),
                                              ] );
    }
}

