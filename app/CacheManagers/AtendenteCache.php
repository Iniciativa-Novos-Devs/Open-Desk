<?php
namespace App\CacheManagers;

use Illuminate\Support\Facades\Cache;
use Str;
use Arr;

class AtendenteCache
{
    protected static $clear_cache       = false;
    protected static $default_relations = [
        'atividades',
        'atendentes',
    ];

    // public static function byId(int $area_id, array $relationships = null)
    // {
    //     $relationships = $relationships === [] ? self::$default_relations : [];

    //     $cache_key = Str::slug(Arr::query(['area_id' => $area_id, 'relationships' => $relationships]));

    //     if(self::$clear_cache)
    //         Cache::forget($cache_key);

    //     return Cache::remember($cache_key, (60 * 60/*secs*/), function () use ($area_id, $relationships) {
    //         return Area::with($relationships)->where('id', $area_id)->first();
    //     });
    // }

    public static function all(array $attributes = [], int $limit = null)
    {
        $cache_key = Str::slug(Arr::query(['role' => 'atendente', 'limit' => ($limit ? $limit : 'no-limit'), 'attributes' => $attributes]));

        if(self::$clear_cache)
            Cache::forget($cache_key);

        return Cache::remember($cache_key, (60 * 60/*secs*/), function () use ($attributes, $limit) {
            return UsuarioCache::all('atendente', $attributes, $limit);
        });
    }

    public function clearCache(bool $clear_cache = null)
    {
        self::$clear_cache = !! $clear_cache;
    }

}
