<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Coaching;
use App\Models\Fee;

class ManyFees extends Seeder
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
            Fee::create([                
                'coaching_id'           => $faker->randomElement($array = $c_ids),
                'fee_service'           => $faker->randomElement($array = array('online','offline','inhouse')),
                'fee_price'             => $faker->numberBetween(20, 200),
                'fee_unit'              => $faker->randomElement($array = array('20 min', '40 min', '60 min')),
                'fee_currency'          => $faker->randomElement($array = array('EUR', 'USD', 'GBP')),
            ]);
        } 
    }
}




// php artisan db:seed --class=ManyFees