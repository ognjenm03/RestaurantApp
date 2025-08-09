<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuCategorie extends Model
{
    use HasFactory;
    use Searchable;

     protected $primaryKey = 'category_id';
    protected $fillable = ['name'];

    protected $searchableFields = ['*'];

    protected $table = 'menu_categories';

    public function menuItems()
    {
        return $this->hasMany(
            MenuItem::class,
            'menu_categorie_id',
            'category_id'
        );
    }
}
