<?php

namespace App\Models\Buttons;


use Illuminate\Support\Facades\Log;

class Buttons
{
    public function mainMenu() {
        return [
            'keyboard' => [
                [
                    [
                        'text' => 'Идти'
                    ],
//                    [
//                        'text' => 'Атаковать'
//                    ],
//                    [
//                        'text' => 'Говорить'
//                    ],
                ],
                [
//                    [
//                        'text' => 'Инвентарь'
//                    ],
                    [
                        'text' => 'Исследовать'
                    ]
                ]
            ],
            'resize_keyboard' => true
        ];
    }

    public function attackMenu() {

    }

    public function attack($mobs) {

    }

    public function moveMenu($rooms) {
        $row1 = [];
        foreach ($rooms as $room){
            $row1[0][] = ['text' => $room->getTitle()];
        }
        return [
            'keyboard' => [
                $row1[0],
                [
                    [
                        'text' => 'Назад'
                    ]
                ]
            ],
            'resize_keyboard' => true
        ];
    }

    public function sayMenu() {

    }

    public function searchMenu() {
        return [
            'keyboard' => [
                [
                    [
                        'text' => 'Карта'
                    ]
                ],
                [
                    [
                        'text' => 'Назад'
                    ]
                ]
            ],
            'resize_keyboard' => true
        ];
    }

    public function inventoryMenu($items) {

    }

    public function mobs($mobs) {

    }




    public function item($item) {

    }

    public function use($item) {

    }

    public function pick($item) {

    }

    public function drop($item) {

    }

    public function infoAbout($obj) {
        $obj->getInfo();
    }

    public function move($rooms) {
        $rooms->getInfo();
    }

    public function back($lastButton) {

    }
}
//Действие игрока
//-атака
//--(список мобов)
//--назад
//-движение
//--номер комнаты(4)
//-говорить
//--(список мобов)
//-исследовать
//--моба
//---(список мобов)
//---назад
//--комнату
//--предмет
//---(список предметов)
//---назад
//--информация о себе
//--назад
//-инвентарь
//--выбросить предмет
//---(список предметов)
//---назад
//--использовать предмет
//---(список предметов)
//---назад
//--назад
