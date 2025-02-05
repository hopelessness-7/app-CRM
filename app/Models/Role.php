<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Role extends Model
{
    use HasFactory;

    public const DEFAULT_ROLE_CACHE_KEY = 'default_role';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }

    public static function getDefaultRole(): Role
    {
        return Cache::rememberForever(self::DEFAULT_ROLE_CACHE_KEY, function () {
            return self::where('slug', config('auth.default_role_slug'))
                ->firstOrCreate([
                    'slug' => config('auth.default_role_slug'),
                    'name' => config('auth.default_role_name'),
                ]);
        });
    }
    public static function clearDefaultRoleCache(): void
    {
        Cache::forget(self::DEFAULT_ROLE_CACHE_KEY);
    }
}
