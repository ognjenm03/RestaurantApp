<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'created_at',
        'is_paid',
        'total_price',
        'payment_method',
        'user_id',
        'table_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'created_at' => 'datetime',
        'is_paid' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id', 'table_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}
