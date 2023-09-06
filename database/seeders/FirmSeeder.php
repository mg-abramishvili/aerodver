<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FirmSeeder extends Seeder
{
    public function run()
    {
        DB::table('firms')->insert([
            [
                'id' => 1,
                'city_id' => 1,
                'name' => 'ООО "Контора"',
                'name_eng' => 'LTC "Kontora"',
                'is_audit' => true,
                'is_arenda' => true,
                'address' => 'ул. Ленина, д. 1, оф. 123',
                'tel' => '+7 347 123-45-67',
                'whatsapp' => '9991234567',
                'price' => 1500,
                'gallery' => '["\/img\/firms\/1.jpg","\/img\/firms\/2.jpg","\/img\/firms\/3.jpg"]',
                'videogallery' => '["\/img\/firms\/video.mp4"]',
                'description' => '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem error dicta esse quasi ab nemo repudiandae quam eius amet consectetur autem voluptatum molestiae, inventore asperiores?</p>',
                'description2' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero asperiores et, adipisci vitae impedit numquam repellat consequuntur soluta rem magnam fugiat culpa placeat laboriosam maxime.</p>',
            ],
            [
                'id' => 2,
                'city_id' => 1,
                'name' => 'ООО "МегаДверь"',
                'name_eng' => 'LTC "MegaDver"',
                'is_audit' => true,
                'is_arenda' => true,
                'address' => 'ул. Пушкина, д. 11, оф. 222',
                'tel' => '+7 347 123-45-67',
                'whatsapp' => '79991234567',
                'price' => 1800,
                'gallery' => '["\/img\/firms\/2.jpg","\/img\/firms\/3.jpg","\/img\/firms\/1.jpg"]',
                'videogallery' => '["\/img\/firms\/video.mp4"]',
                'description' => '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem error dicta esse quasi ab nemo repudiandae quam eius amet consectetur autem voluptatum molestiae, inventore asperiores?</p>',
                'description2' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero asperiores et, adipisci vitae impedit numquam repellat consequuntur soluta rem magnam fugiat culpa placeat laboriosam maxime.</p>',
            ],
            [
                'id' => 3,
                'city_id' => 2,
                'name' => 'ООО "СуперДверь"',
                'name_eng' => 'LTC "SuperDver"',
                'is_audit' => true,
                'is_arenda' => true,
                'address' => 'ул. Проспект Октября, д. 22, оф. 333',
                'tel' => '+7 347 123-45-67',
                'whatsapp' => '79991234567',
                'price' => 2500,
                'gallery' => '["\/img\/firms\/2.jpg","\/img\/firms\/3.jpg","\/img\/firms\/1.jpg"]',
                'videogallery' => '["\/img\/firms\/video.mp4"]',
                'description' => '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem error dicta esse quasi ab nemo repudiandae quam eius amet consectetur autem voluptatum molestiae, inventore asperiores?</p>',
                'description2' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero asperiores et, adipisci vitae impedit numquam repellat consequuntur soluta rem magnam fugiat culpa placeat laboriosam maxime.</p>',
            ],
        ]);
    }
}