<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['table_number', 'status'];

    protected $searchableFields = ['*'];

    const STATUS_FREE = 1;
    const STATUS_OCCUPIED = 2;

    // Relacija ka narudžbinama
    public function orders()
    {
        return $this->hasMany(Order::class, 'table_id', 'table_id');
    }

    // Helper accessor za čitljiv status
    public function getStatusTextAttribute()
    {
        return $this->status == self::STATUS_FREE ? 'Free' : 'Occupied';
    }
}
