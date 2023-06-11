<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MarketTrade; 

class MarketTradeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'No' => 16,
                'Direction' => 'sell',
                'Number' => -0.0556,
                'Price' => 25500,
                'Count' => 153966,
                'created_at' => '2023-06-01 07:31:36',
                'updated_at' => '2023-06-01 07:31:36',
            ],
            [
                'id' => 2,
                'No' => 17,
                'Direction' => 'sell',
                'Number' => -0.0557,
                'Price' => 25550,
                'Count' => 153971,
                'created_at' => '2023-06-01 08:31:36',
                'updated_at' => '2023-06-01 08:31:36',
            ],
        ];

        MarketTrade::insert($data);
    }
}
