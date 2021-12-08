<?php
namespace App\CacheManagers;

use Illuminate\Support\Facades\Cache;
use Str;
use Arr;
use Role;

class RoleCache
{
    protected static $clear_cache = false;

    public static function all(bool $update_cache = false, bool $only_clear_cache = false)
    {
        $cache_key = Str::slug(Arr::query(['class' => 'RoleCache', 'method' => 'all']));

        if(self::$clear_cache || $update_cache)
            Cache::forget($cache_key);

        if($update_cache && $only_clear_cache)
            return;

        return Cache::remember($cache_key, (60 * 60/*secs*/), function () {
            return Role::select('name', 'id')->with([
                'permissions' => function($query) {
                    $query->select('id','name',);
                },
            ])->get();
        });
    }

    public function clearCache(bool $clear_cache = null)
    {
        self::$clear_cache = !! $clear_cache;
    }
}
