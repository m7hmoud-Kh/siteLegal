<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['guard_name' => 'api', 'name' => 'super_admin']);
        Role::create(['guard_name' => 'api', 'name' => 'admin']);
        Role::create(['guard_name' => 'api', 'name' => 'supervisor']);


        $faker = Factory::create();

        $superAdmin = User::create([
            'name' => $faker->name(),
            'email' => 'khairymahmoud795@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        $superAdmin->assignRole('super_admin');
    }
}
