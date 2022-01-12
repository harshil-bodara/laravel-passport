<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Coaching;
use App\Models\User;

class ManyCoachings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $c_ids = User::where('id' ,'>' ,0)->pluck('id')->toArray();
        $faker = Faker::create();
        for($i = 1 ; $i <= 10 ; $i++){
            Coaching::create([                
                'user_id'               => $faker->randomElement($array = $c_ids),
                'c_is_active'           => $faker->boolean(),
                'c_title'               => $faker->sentence(),
                'c_description_1'       => $faker->paragraph(),
                'c_city'                => $faker->city(),
                'c_country'             => $faker->country(),
                'c_banner_img'          => $faker->randomElement($array = array('blue-mountains.jpg', 'desert.jpg', 'red-mountains.jpg')),
                'c_language_primary'    => $faker->randomElement($array = array('Chinese', 'Spanish', 'English','Hindi','Arabic','Portuguese','Bengali','Russian', 'Japanese', 'French', 'German','Punjabi','Swahili','Korean','Italian' )),
                'c_language_secondary'  => $faker->randomElement($array = array('Chinese', 'Spanish', 'English','Hindi','Arabic','Portuguese','Bengali','Russian', 'Japanese', 'French', 'German','Punjabi','Swahili','Korean','Italian' )),                
                'c_type_online'         => $faker->boolean(),
                'c_type_offline'        => $faker->boolean(),
                'c_type_inhouse'        => $faker->boolean(),
                'c_avail_morning'        => $faker->boolean(),
                'c_avail_afternoon'      => $faker->boolean(),
                'c_avail_evening'        => $faker->boolean(),
            ]);
        } 
    }
}

// php artisan db:seed --class=ManyCoachings