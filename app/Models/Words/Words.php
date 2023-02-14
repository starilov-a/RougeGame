<?php

namespace App\Models\Words;

class Words
{
    public function viewMap() {
        $i = rand(0,2);
        $words = [
            0 => 'GPS укажет путь.',
            1 => 'Кто оставил эти пометки?',
            2 => 'Теперь я не заблужусь! Хотя я уже заблудился...'
        ];
        return $words[$i] . "\r\n \r\n Вы раскрыли карту: \r\n x - ваше местоположение \r\n d - изученная территория \r\n ? - неизвестность \r\n \r\n";
    }

    public  function whereGo() {
        return "Куда бы пойти?";
    }
}
