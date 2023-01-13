<?php

namespace App\Libs\Helpers;

class ColorGenerator
{
    public static function randomColor(string|null $type = 'rgb'): string
    {
        $types = ['rgb', 'hex'];

        if (! in_array($type, $types)) {
            $type = 'rgb';
        }

        return ($type == 'rgb') ? static::randomRGB() : static::randomHexColor();
    }

    public static function randomRGB()
    {
        $r = rand(0, 255);
        $g = rand(0, 255);
        $b = rand(0, 255);

        return "rgb({$r}, {$g}, {$b})";
    }

    public static function randomHexColor()
    {
        return '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
    }

    public static function generateArrayOfColors(int $quantity, string|null $type = 'rgb'): array
    {
        $colors = [];
        for ($i = 0; $i < $quantity;) {
            $color = static::randomColor($type);

            if (! in_array($color, $colors)) {
                $colors[] = $color;
                $i++;
            }
        }

        return $colors;
    }
}
