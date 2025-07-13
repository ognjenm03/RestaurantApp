<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'price',
        'order_item_id',
        'menu_categorie_id',
        'image',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'menu_items';

    public function orderItem()
    {
        return $this->belongsTo(
            OrderItem::class,
            'order_item_id',
            'order_item_id'
        );
    }

    public function menuCategorie()
    {
        return $this->belongsTo(
            MenuCategorie::class,
            'menu_categorie_id',
            'category_id'
        );
    }
}
