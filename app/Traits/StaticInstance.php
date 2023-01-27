<?php

namespace App\Traits;

trait StaticInstance
{
    protected static ?object $instance = null;

    /**
     * function getInstance
     *
     * Retorna uma instância dessa classe. Para ser usado em métodos estáticos
     *
     * @param
     * @return object
     */
    public static function getInstance(...$params)
    {
        return static::$instance ?? (new static(...$params));
    }
}
