<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    public function run()
    {
        DB::table('pages')->insert([
            [
                'id' => 1,
                'name' => 'Контакты',
                'content' => '<p>Текст страницы Контакты.</p>',
                'gallery' => null,
            ],
            [
                'id' => 2,
                'name' => 'О компании',
                'content' => '<p>Текст страницы О компании.</p>',
                'gallery' => null,
            ],
            [
                'id' => 3,
                'name' => 'Сотрудничество',
                'content' => '<p>Текст страницы Сотрудничество.</p>',
                'gallery' => null,
            ],
            [
                'id' => 4,
                'name' => 'Доставка и Оплата',
                'content' => '<p>Текст страницы Доставка и Оплата.</p>',
                'gallery' => null,
            ],
        ]);
    }
}