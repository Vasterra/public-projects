<?php

use Illuminate\Database\Seeder;

class BlockTypesSeed extends Seeder
{
    public function run()
    {
        DB::table( 'block_types' )->insert( [
                                                'name'       => 'H1 заголовое',
                                                'template_production'       => 'H1',
                                                'template_edition'       => 'H1',
                                                'default_class'       => 'default',
                                                'category_id'       => '1',
                                                'field_count'=>'2',
                                                'created_at' => date( 'Y-m-d' ),
                                                'updated_at' => date( 'Y-m-d' ),
                                            ] );
        DB::table( 'block_types' )->insert( [
                                                'name'       => 'H1 красный',
                                                'template_production'       => 'H1RED',
                                                'template_edition'       => 'H1RED',
                                                'default_class'       => 'default',
                                                'category_id'       => '1',
                                                'field_count'=>'2',
                                                'created_at' => date( 'Y-m-d' ),
                                                'updated_at' => date( 'Y-m-d' ),
                                            ] );
        DB::table( 'block_types' )->insert( [
                                                'name'       => 'Абзац простой',
                                                'template_production'       => 'p',
                                                'template_edition'       => 'p',
                                                'default_class'       => 'default',
                                                'category_id'       => '2',
                                                'field_count'=>'1',
                                                'created_at' => date( 'Y-m-d' ),
                                                'updated_at' => date( 'Y-m-d' ),
                                            ] );
    }
}

