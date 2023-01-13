<?php

namespace App\CacheManagers;

use App\Models\Usuario;
use Arr;
use Auth;
use Illuminate\Support\Facades\Cache;
use Str;

class UsuarioCache
{
    protected static $clear_cache = false;

    protected static $default_relations = [
        'areas',
        'roles',
    ];

    public static function byId(int $usuario_id, ?array $relationships = null)
    {
        $relationships = $relationships === null ? self::$default_relations : [];

        $cache_key = Str::slug(Arr::query(['usuario_id' => $usuario_id, 'relationships' => $relationships]));

        if (self::$clear_cache) {
            Cache::forget($cache_key);
        }

        return Cache::remember($cache_key, 1800 /*secs*/, fn () => Usuario::with($relationships)->where('id', $usuario_id)->first());
    }

    public static function byLoggedUser(?array $relationships = null)
    {
        if (Auth::user()->id ?? null) {
            return self::byId(Auth::user()->id, $relationships);
        }

        return null;
    }

    public static function all(?string $role = null, array $attributes = [], ?int $limit = null)
    {
        $cache_key = Str::slug(Arr::query(['role' => ($role ?? 'all'), 'limit' => ($limit ? $limit : 'no-limit'), 'attributes' => $attributes]));

        if (self::$clear_cache) {
            Cache::forget($cache_key);
        }

        return Cache::remember($cache_key, (60 * 60/*secs*/), function () use ($role, $attributes, $limit) {
            $query = Usuario::with('roles');

            if ($role) {
                $query->whereHas('roles', function ($query) use ($role) {
                    $query->where('name', $role);
                });
            }

            if ($attributes) {
                $query->select($attributes);
            }

            if ($limit) {
                $query->limit($limit);
            }

            return $query->get();
        });
    }

    public function clearCache(?bool $clear_cache = null)
    {
        self::$clear_cache = (bool) $clear_cache;
    }
}
