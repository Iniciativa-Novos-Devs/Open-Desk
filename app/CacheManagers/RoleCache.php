<?php
namespace App\CacheManagers;

use Illuminate\Support\Facades\Cache;
use Str;
use Arr;
use Role;

class RoleCache
{
    protected static $clear_cache = false;

    public static function all(bool $update_cache = false, bool $only_clear_cache = false, int $role_id = null)
    {
        $cache_key = Str::slug(http_build_query([
            'class'  => 'RoleCache',
            'method' => 'all',
            'id'     => $role_id
        ], '', '-'));

        if(self::$clear_cache || $update_cache)
            Cache::forget($cache_key);

        if($update_cache && $only_clear_cache)
            return;

        $data =  Cache::remember($cache_key, (60 * 60/*secs*/), function () use ($role_id) {
            $query_builder =  Role::select('name', 'id')->with([
                'permissions' => function($query) {
                    $query->select('id','name',);
                },
            ]);

            if($role_id)
                return $query_builder->where('id', $role_id)->first();

            return $query_builder->get();
        });

        if (!$data)
        {
            Cache::forget($cache_key);
            return null;
        }

        return $data ?? null;
    }

    /**
     * function getById
     *
     * @param int $role_id
     * @return
     */
    public static function getById(int $role_id = null, bool $update_cache = false, bool $only_clear_cache = false)
    {
        if (!$role_id)
        {
            return null;
        }

        return self::all($update_cache, $only_clear_cache, $role_id);
    }

    public function clearCache(bool $clear_cache = null)
    {
        self::$clear_cache = !! $clear_cache;
    }
}
