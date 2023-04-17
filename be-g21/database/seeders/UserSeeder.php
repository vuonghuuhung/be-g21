<?php

namespace Database\Seeders;

use App\Models\users;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $randPassword = 'Admin@123';

        foreach (range(1, 15) as $id) {
            users::create([
                "email" => 'admin' . $id . '@gmail.com',
                "firstname" => 'Fname' . $id,
                "lastname" => 'Lname' . $id,
                "password" => Hash::make($randPassword),
                "token" => Str::random(10),
                "city_id" => 1,
                "district_id" => 1,
                "urban_id" => 1,
                "address_node" => 'Ngõ 1',
                "phone" => "0123456789",
            ]);
        }
    }
}
