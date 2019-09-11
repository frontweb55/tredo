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
//        $faker = Faker\Factory::create();
//        foreach (range(1,500) as $index) {
//            $day = rand(10, 30);
//            $month = rand(1,6);
//            DB::table('customers')->insert([
//                'fio' => $faker->name,
//                'uin' => rand(100000000000, 990000000000),
//                'created_at' => date('Y-m-d H:i:s', strtotime('2019-0'.$month .'-'.$day ))
//            ]);
//        }
        foreach (range(1,10000) as $index) {
            $day = rand(10, 30);
            $order = $day>20 ? 'rent' : 'refund';
            $month = rand(1,5);
            DB::table('orders')->insert([
                'order' => $order,
                'customer_id' => rand(1, 500),
                'created_at' => date('Y-m-d H:i:s', strtotime('2019-0'.$month .'-'.$day ))
            ]);
        }
    }
}
