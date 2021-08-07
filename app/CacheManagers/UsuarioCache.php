<?php
namespace App\CacheManagers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Cache;
use Str;
use Arr;
use Auth;

class UsuarioCache
{
    protected static $clear_cache       = false;
    protected static $default_relations = [
        'areas',
        'roles',
    ];

    public static function byId(int $usuario_id, array $relationships = null)
    {
        $relationships = $relationships === null ? self::$default_relations : [];

        $cache_key = Str::slug(Arr::query(['usuario_id' => $usuario_id, 'relationships' => $relationships]));

        if(self::$clear_cache)
            Cache::forget($cache_key);

        return Cache::remember($cache_key, 1800 /*secs*/, function ()  use ($usuario_id, $relationships) {
            return Usuario::with($relationships)->where('id', $usuario_id)->first();
        });
    }

    public static function byLoggedUser(array $relationships = null)
    {
        if(Auth::user()->id ?? null)
            return self::byId(Auth::user()->id, $relationships);

        return null;
    }

    public function clearCache(bool $clear_cache = null)
    {
        self::$clear_cache = !! $clear_cache;
    }

}
