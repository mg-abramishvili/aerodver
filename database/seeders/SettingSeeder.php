<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SettingSeeder extends Seeder
{
    public function run()
    {
        DB::table('settings')->insert([
            [
                'id' => 1,
                'about_text' => '<p>Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев более менее осмысленного текста рыбы на русском языке, а начинающему оратору отточить навык публичных выступлений в домашних условиях. При создании генератора мы использовали небезизвестный универсальный код речей. Текст генерируется абзацами случайным образом от двух до десяти предложений в абзаце, что позволяет сделать текст более привлекательным и живым для визуально-слухового восприятия.</p><p>По своей сути рыбатекст является альтернативой традиционному lorem ipsum, который вызывает у некторых людей недоумение при попытках прочитать рыбу текст. В отличии от lorem ipsum, текст рыба на русском языке наполнит любой макет непонятным смыслом и придаст неповторимый колорит советских времен.</p>',
                'about_text_eng' => '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus et debitis minus vitae accusantium, assumenda eligendi praesentium veritatis nesciunt tempora, atque necessitatibus voluptatum sunt aliquam culpa facere aut excepturi? Aliquid atque, molestias minus accusantium, cupiditate odit mollitia distinctio, saepe architecto rem recusandae autem magnam dolore sit facere voluptates molestiae itaque?</p><p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Libero porro consequuntur quo quisquam doloribus, facilis nihil necessitatibus recusandae quos tenetur nemo eius assumenda quis corrupti!</p>',
                'video_bg' => '/img/video/video.mp4',
                'telegram' => '#',
                'whatsapp' => '#',
                'youtube' => '#',
                'instagram' => '#',
                'email' => '#',
            ],
        ]);
    }
}