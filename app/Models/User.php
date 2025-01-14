<?php

namespace App\Models;

use App\Models\Role;
use App\Enums\RoleName;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /* protected function getDefaultGuardName() : string {
        return 'web';
    } */

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        "user_type"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public function roles(): BelongsToMany
    // {
    //     return $this->belongsToMany(Role::class);
    // }

    public function isAdmin(): bool
    {
        return $this->hasRole(RoleName::ADMIN);
    }

    public function isTeacher(): bool
    {
        return $this->hasRole(RoleName::TEACHER);
    }

    public function isStudent(): bool
    {
        return $this->hasRole(RoleName::STUDENT);
    }

    public function isParent(): bool
    {
        return $this->hasRole(RoleName::PARENT);
    }

    // public function hasRole(RoleName $role): bool
    // {
    //     return $this->roles()->where('name', $role->value)->exists();
    // }

    // public function permissions(): array
    // {
    //     return $this->roles()->with('permissions')->get()
    //         ->map(function ($role) {
    //             return $role->permissions->pluck('name');
    //         })->flatten()->values()->unique()->toArray();
    // }

    // public function hasPermission(string $permission): bool
    // {
    //     return in_array($permission, $this->permissions(), true);
    // }

    public function school(): HasOne
    {
        return $this->hasOne(School::class, 'principal_code');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
