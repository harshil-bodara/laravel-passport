<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Coaching;
use App\Models\Category;
use App\Models\Tag;

class ManyTags extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $c_ids = Coaching::where('id' ,'>' ,0)->pluck('id')->toArray();
        $cat_ids = Category::where('id' ,'>' ,0)->pluck('id')->toArray();
        $faker = Faker::create();
        for($i = 1 ; $i <= 20 ; $i++){
            Tag::create([                
                'coaching_id'       => $faker->randomElement($array = $c_ids),
                'tag_name'          => $faker->word(),
                'category_id'       => $faker->randomElement($array = $cat_ids),
                'tag_description'   => $faker->paragraph(),
                'tag_language'      => $faker->countryCode()
                /* 'tag_language'      => $faker->randomElement($array = array('de', 'en', 'fr', 'es', 'ru', 'it', 'fi', 'pt', 'ch', 'jp')) */
            ]);
        } 
    }
}


// php artisan db:seed --class=ManyTags