<?php

namespace App\Enums\CachedEnums;

use App\Models\Role;
use Str;
use Arr;
use Illuminate\Support\Facades\Cache;

class RoleCachedEnum
{
    public static function getRoleData(string $role, bool $clear_cache = false)
    {
        $cache_key = Str::slug(Arr::query(['method' => 'getRoleData', 'role' => $role]));

        if($clear_cache)
            Cache::forget($cache_key);

        $role = Cache::remember($cache_key, 360 /*secs*/, function () use ($role) {
            return Role::whereRaw('LOWER(name) like ?', [strtolower($role)])->first();
        });

        return $role ?? null;
    }

    public static function getRoleUid(string $role, bool $clear_cache = false)
    {
        $cache_key = Str::slug(Arr::query(['method' => 'getRoleUid', 'role' => $role]));

        if($clear_cache)
            Cache::forget($cache_key);

        $role_uid = Cache::remember($cache_key, 360 /*secs*/, function () use ($role, $clear_cache) {
            $role = self::getRoleData($role, $clear_cache);
            return $role->uid ?? null;
        });

        return $role_uid ?? null;
    }

    public static function getRoleDataByUid(int $uid, bool $clear_cache = false)
    {
        $cache_key = Str::slug(Arr::query(['method' => 'getRoleDataByUid', 'uid' => $uid]));

        if($clear_cache)
            Cache::forget($cache_key);

        $uid = Cache::remember($cache_key, 360 /*secs*/, function () use ($uid) {
            return Role::where('uid', $uid)->first();
        });

        return $uid ?? null;
    }

    public static function getRoleName(int $uid, bool $clear_cache = false)
    {
        $cache_key = Str::slug(Arr::query(['method' => 'getRoleName', 'uid' => $uid]));

        if($clear_cache)
            Cache::forget($cache_key);

        $role_name = Cache::remember($cache_key, 360 /*secs*/, function () use ($uid, $clear_cache) {
            $role = self::getRoleDataByUid($uid, $clear_cache);
            return $role->name ?? null;
        });

        return $role_name ?? null;
    }
}
