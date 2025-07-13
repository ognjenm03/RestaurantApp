<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserType extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['type_name'];

    protected $searchableFields = ['*'];

    protected $table = 'user_types';

    public function users()
    {
        return $this->hasMany(User::class, 'user_type_id', 'user_type_id');
    }
}
