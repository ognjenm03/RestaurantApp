<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory, Searchable, HasApiTokens;

    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'username',
        'password',
        'full_name',
        'user_type_id',
        'email'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $searchableFields = ['*'];

    public function type()
    {
        return $this->belongsTo(UserType::class, 'user_type_id', 'user_type_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'user_id');
    }

    public function isSuperAdmin(): bool
    {
        return in_array($this->email, config('auth.super_admins'));
    }

    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    public function getUserTypeNameAttribute()
    {
        return match($this->user_type_id) {
            1 => 'Admin',
            2 => 'Konobar',
            default => 'N/A',
        };
    }
}
