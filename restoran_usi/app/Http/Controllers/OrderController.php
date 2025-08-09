<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // očekujemo JSON u polju 'cart' i payment_method i table_id
        $request->validate([
            'table_id' => 'required|exists:tables,table_id',
            'cart' => 'required|string', // JSON string
            'payment_method' => 'required|in:cash,card',
        ]);

        $cart = json_decode($request->input('cart'), true);

        if (!is_array($cart) || count($cart) === 0) {
            return back()->with('error', 'Cart is empty.');
        }

        DB::beginTransaction();
        try {
            // kreiraj order (postavi waiter na trenutno ulogovanog)
            $order = Order::create([
                'table_id' => $request->input('table_id'),
                'waiter_id' => auth()->id(), // kod tebe User PK je user_id, Auth::id() radi
                'is_paid' => 0,
                'total_price' => 0, // updateujemo posle
                'payment_method' => $request->input('payment_method'),
            ]);

            $total = 0;

            foreach ($cart as $ci) {
                // svaki element: ['item_id'=>..., 'quantity'=>...]
                $itemId = $ci['item_id'] ?? null;
                $quantity = intval($ci['quantity'] ?? 0);
                if (!$itemId || $quantity <= 0) continue;

                $menuItem = MenuItem::findOrFail($itemId);

                $price = $menuItem->price;
                $lineTotal = $price * $quantity;
                $total += $lineTotal;

                OrderItem::create([
                    'order_id' => $order->order_id,
                    'item_id' => $menuItem->item_id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
            }

            // update total
            $order->total_price = $total;
            $order->save();

            // update table status -> occupied (2)
            $table = Table::findOrFail($request->input('table_id'));
            $table->status = $table::STATUS_OCCUPIED; // koristi konstante iz modela
            $table->save();

            DB::commit();

            return redirect()->route('tables.show', $table->table_id)
                ->with('success', 'Order created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }
}
