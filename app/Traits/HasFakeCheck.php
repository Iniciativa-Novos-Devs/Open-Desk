<?php

namespace App\Traits;

trait HasFakeCheck
{
    protected static bool $isFake = false;

    /**
     * function fake
     *
     * @param  bool  $isFake = true
     * @return
     */
    public static function fake(bool $isFake = true)
    {
        static::$isFake = $isFake;
    }

    /**
     * function isFake
     *
     * @return bool
     */
    public static function isFake(): bool
    {
        return static::$isFake;
    }
}
