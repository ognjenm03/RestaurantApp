<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\MenuCategorie;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        return view('tables.index', compact('tables'));
    }

     public function show(Table $table, Request $request)
    {
        // $categories = MenuCategorie::orderBy('name')->get();

        // $categoryId = $request->query('category');

        // $query = MenuItem::select('item_id', 'name', 'price', 'menu_categorie_id', 'image');

        // if ($categoryId) {
        //     $query->where('menu_categorie_id', $categoryId);
        // }

        // $menuItems = $query->orderBy('name')->get();

        // return view('tables.show', compact('table', 'categories', 'menuItems', 'categoryId'));
        $categories = MenuCategorie::orderBy('name')->get();
        $categoryId = $request->query('category');
        $query = MenuItem::select('item_id', 'name', 'price', 'menu_categorie_id', 'image');

        if ($categoryId) {
            $query->where('menu_categorie_id', $categoryId);
        }

        $menuItems = $query->orderBy('name')->get();

        // Dohvati aktivnu neplaćenu porudžbinu za ovaj sto (ako postoji)
        $activeOrder = $table->orders()
                            ->where('is_paid', 0) // nije placen order
                            ->with('orderItems.menuItem') // eager load stavki i povezanih menija
                            ->first();
        
        // dd($activeOrder->orderItems->first()->menuItem);

        return view('tables.show', compact('table', 'categories', 'menuItems', 'categoryId', 'activeOrder'));
    }
}
