<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['table_number', 'status'];

    protected $searchableFields = ['*'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'table_id', 'table_id');
    }
}
