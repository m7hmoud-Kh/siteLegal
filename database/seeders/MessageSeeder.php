<?php

namespace Database\Seeders;

use App\Models\Message;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();


        for ($i=0; $i < 30; $i++) {
            # code...
            Message::create([
                'name' => $faker->name,
                'email' => $faker->safeEmail(),
                'mobile' => $faker->phoneNumber(),
                'message' => $faker->text()
            ]);
        }
    }
}
