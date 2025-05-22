<?php

namespace App\Models;

use App\Models\Operation\Parks;
use App\Models\Operation\Roles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'role_id',
        'parks_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function park()
    {
        return $this->hasOne(Parks::class, 'id', 'parks_id');
    }

    public function role()
    {
        return $this->hasOne(Roles::class, 'id', 'role_id');
    }

    public function userCreator()
    {
        return $this->hasOne(self::class, 'id', 'user_creator');
    }

    public function userUpdate()
    {
        return $this->hasOne(self::class, 'id', 'user_last_update');
    }
}
