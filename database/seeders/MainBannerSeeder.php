<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MainBannerSeeder extends Seeder
{
    public function run()
    {
        DB::table('main_banners')->insert([
            [
                'id' => 1,
                'title' => 'В данный момент Сайт компании AeroDver.ru Находиться в разработке !',
                'title_eng' => 'В данный момент Сайт компании AeroDver.ru Находиться в разработке !',
                'subtitle' => 'Оффицальный Старт Продаж Середина Сентября 2023 г.',
                'subtitle_eng' => 'Оффицальный Старт Продаж Середина Сентября 2023 г.',
            ],
        ]);
    }
}