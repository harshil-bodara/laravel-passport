<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Qualification;
use App\Models\Coaching;
use App\Models\Fee;

class ManyQualifications extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $c_ids = Coaching::where('id' ,'>' ,0)->pluck('id')->toArray();
        $faker = Faker::create();
        for($i = 1 ; $i <= 30 ; $i++){
            Qualification::create([                
                'coaching_id'       => $faker->randomElement($array = $c_ids),
                'q_title'           => $faker->catchPhrase(),
                'q_type'            => $faker->randomElement($array = array('certificate','degree','diploma','advanced training')),
                'q_institution'     => $faker->randomElement($array = array(
                    'University of Alabama',
                    'Cole University',
                    'Rossieshire Institute of Technology',
                    'College of Louisiana',
                    'University of Hawaii',
                    'O`Kon College',
                    'Little Institute of Technology',
                    'Utah University',
                    'Kshlerin College',
                    'Connelly University',
                    'Kassulke High',
                    'Koepp Secondary School',
                    'South Cooper School',
                    'Russelborough Institute',
                    'North Lianaton School',
                    'Reganville Institute',
                    'Port Karen Elementary',
                    'Emmerich High School',
                    'South Burdette Elementary',
                    'West Lukaston School of Fine Arts',
                )),
                'q_start'           => $faker->numberBetween(2010, 2012),
                'q_end'             => $faker->numberBetween(2012, 2016),                
            ]);
        } 
    }
}




// php artisan db:seed --class=ManyQualifications