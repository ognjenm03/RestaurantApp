<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['quantity', 'price', 'order_id'];

    protected $searchableFields = ['*'];

    protected $table = 'order_items';

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function menuItems()
    {
        return $this->hasMany(
            MenuItem::class,
            'order_item_id',
            'order_item_id'
        );
    }
}
