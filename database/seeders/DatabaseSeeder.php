<?php

namespace Database\Seeders;

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
        $this->call([
            ManyFees::class
        ]);
        $this->call([
            ManyTags::class
        ]);
        $this->call([
            ManyCoachings::class
        ]);
        $this->call([
            ManyQualifications::class
        ]);
    }
}
