<?php


namespace App\Models\Interfaces;


interface UseItemInterface
{
    public function useItem($item);
    public function takeItem($item);
    public function dropItem($item);
}
