<?php

namespace Database\Seeders;

use App\Models\Setting;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        /*****Contact Us***** */
        Setting::create([
            'key' => 'twitter',
            'value' => 'https://www.facebook.com/',
            'language' => 'en',
        ]);

        Setting::create([
            'key' => 'twitter',
            'value' => 'https://www.facebook.com/',
            'language' => 'ar',
        ]);

        Setting::create([
            'key' => 'insta',
            'value' => 'https://www.facebook.com/',
            'language' => 'en',
        ]);

        Setting::create([
            'key' => 'insta',
            'value' => 'https://www.facebook.com/',
            'language' => 'ar',
        ]);


        Setting::create([
            'key' => 'linkedIn',
            'value' => 'https://www.facebook.com/',
            'language' => 'en',
        ]);

        Setting::create([
            'key' => 'linkedIn',
            'value' => 'https://www.facebook.com/',
            'language' => 'ar',
        ]);

        Setting::create([
            'key' => 'whatsapp',
            'value' => '01143124020',
            'language' => 'en'
        ]);

        Setting::create([
            'key' => 'whatsapp',
            'value' => '01143124020',
            'language' => 'ar'
        ]);


        Setting::create([
            'key' => 'mobile',
            'value' => '01143124020',
            'language' => 'en'
        ]);

        Setting::create([
            'key' => 'mobile',
            'value' => '01143124020',
            'language' => 'ar'
        ]);

        Setting::create([
            'key' => 'email',
            'value' => 'khairymahmoud795@gmail.com',
            'language' => 'en'
        ]);

        Setting::create([
            'key' => 'email',
            'value' => 'khairymahmoud795@gmail.com',
            'language' => 'ar'
        ]);
        Setting::create([
            'key' => 'address',
            'value' => $faker->streetAddress(),
            'language' => 'en'
        ]);

        Setting::create([
            'key' => 'address',
            'value' => 'اسيوط , شارع الجمهوريه',
            'language' => 'ar'
        ]);
        /*****Contact Us***** */

        /*******About us & vission&mission*** */
        Setting::create([
            'key' => 'who_are_you',
            'value' => 'description One',
            'language' => 'en'
        ]);
        Setting::create([
            'key' => 'who_are_you',
            'value' =>   'وصف من نحن',
            'language' => 'ar'
        ]);


        Setting::create([
            'key' => 'vision',
            'value' => 'description on vision',
            'language' => 'en'
        ]);

        Setting::create([
            'key' => 'vision',
            'value' => 'وصف المهمه',
            'language' => 'ar'
        ]);
        /******End About us & vission&mission**** */

        /****Home*****/
        Setting::create([
            'key' => 'title_home',
            'value' => 'Title home',
            'language' => 'en'
        ]);

        Setting::create([
            'key' => 'title_home',
            'value' => 'عنوان الهوم',
            'language' => 'ar'
        ]);

        Setting::create([
            'key' => 'description_home',
            'value' => 'Description home',
            'language' => 'en'
        ]);

        Setting::create([
            'key' => 'description_home',
            'value' => 'وصف الهوم',
            'language' => 'ar'
        ]);
        /*****End Home***** */
    }
}
