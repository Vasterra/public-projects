<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call( CategorySeed::class );
        $this->call( BlockTypesSeed::class );
        $this->call( BlocksSeed::class );
        $this->call( BlocksValues::class );
        $this->call( TemplateCategorySeed::class );
        $this->call( Templates::class );
    }
}
