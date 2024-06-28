<?php

namespace Database\Seeders;

use App\Models\Process;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fakerEn = Factory::create();
        $fakerAr = Factory::create('ar_SA');


        for ($i=0; $i < 30; $i++) {
            # code...
            Process::create([
                'name_en' => $fakerEn->text(50),
                'name_ar' => $fakerAr->text(50),
                'description_en' => $fakerEn->text(),
                'description_ar' => $fakerAr->text(),
                'status' => $fakerEn->boolean()
            ]);
        }
    }
}
