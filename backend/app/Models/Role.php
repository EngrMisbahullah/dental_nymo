<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description',
        'hierarchy_level',
        'is_staff',
        'is_provider',
        'is_external',
        'color',
    ];

    protected $casts = [
        'hierarchy_level' => 'integer',
        'is_staff' => 'boolean',
        'is_provider' => 'boolean',
        'is_external' => 'boolean',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }
}