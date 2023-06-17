<?php

namespace Database\Seeders;

use App\Models\OrderDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 15) as $id) {
            OrderDetail::create([
                "product_id" => $id,
                "order_id" => rand(1, 15),
                "total_price" => 123.7,
                "rate" => rand(1, 5),
                "quantity" => rand(1, 4),
            ]);
        }
        foreach (range(1, 9) as $id) {
            OrderDetail::create([
                "product_id" => $id,
                "order_id" => rand(1, 15),
                "total_price" => 110,
                "rate" => rand(1, 5),
                "quantity" => rand(1, 4),
            ]);
        }
        foreach (range(4, 7) as $id) {
            OrderDetail::create([
                "product_id" => $id,
                "order_id" => rand(1, 15),
                "total_price" => 60,
                "rate" => rand(1, 5),
                "quantity" => rand(1, 4),
            ]);
        }
    }
}
