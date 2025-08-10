<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // public function store(Request $request)
    // {
    //     // očekujemo JSON u polju 'cart' i payment_method i table_id
    //     $request->validate([
    //         'table_id' => 'required|exists:tables,table_id',
    //         'cart' => 'required|string', // JSON string
    //         'payment_method' => 'required|in:cash,card',
    //     ]);

    //     $cart = json_decode($request->input('cart'), true);

    //     if (!is_array($cart) || count($cart) === 0) {
    //         return back()->with('error', 'Cart is empty.');
    //     }

    //     DB::beginTransaction();
    //     try {
    //         // kreiraj order (postavi waiter na trenutno ulogovanog)
    //         $order = Order::create([
    //             'table_id' => $request->input('table_id'),
    //             'waiter_id' => auth()->id(), // kod tebe User PK je user_id, Auth::id() radi
    //             'is_paid' => 0,
    //             'total_price' => 0, // updateujemo posle
    //             'payment_method' => $request->input('payment_method'),
    //         ]);

    //         $total = 0;

    //         foreach ($cart as $ci) {
    //             // svaki element: ['item_id'=>..., 'quantity'=>...]
    //             $itemId = $ci['item_id'] ?? null;
    //             $quantity = intval($ci['quantity'] ?? 0);
    //             if (!$itemId || $quantity <= 0) continue;

    //             $menuItem = MenuItem::findOrFail($itemId);

    //             $price = $menuItem->price;
    //             $lineTotal = $price * $quantity;
    //             $total += $lineTotal;

    //             OrderItem::create([
    //                 'order_id' => $order->order_id,
    //                 'item_id' => $menuItem->item_id,
    //                 'quantity' => $quantity,
    //                 'price' => $price,
    //             ]);
    //         }

    //         // update total
    //         $order->total_price = $total;
    //         $order->save();

    //         // update table status -> occupied (2)
    //         $table = Table::findOrFail($request->input('table_id'));
    //         $table->status = $table::STATUS_OCCUPIED; // koristi konstante iz modela
    //         $table->save();

    //         DB::commit();

    //         return redirect()->route('tables.show', $table->table_id)
    //             ->with('success', 'Order created successfully.');
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         return back()->with('error', 'Failed to create order: ' . $e->getMessage());
    //     }
    // }
    public function store(Request $request)
    {
        $data = $request->validate([
            'table_id' => 'required|exists:tables,table_id',
            'payment_method' => 'required|in:cash,card',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:menu_items,item_id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Kreiraj narudzbinu
            $order = Order::create([
                'table_id' => $data['table_id'],
                'payment_method' => $data['payment_method'],
                // 'status' => 'created', // ili sta vec imas
                'total_price' => 0, // izracunacemo nakon dodavanja stavki
                'is_paid' => 1, // not paid
                'user_id' => auth()->id(), // ili 'user_id' => auth()->id() zavisno od imena kolone
            ]);

            $totalPrice = 0;

            // Kreiraj stavke porudzbine
            foreach ($data['items'] as $item) {
                Log::info('Item in order:', $item);
                $lineTotal = $item['price'] * $item['quantity'];
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'item_id' => $item['item_id'], 
                    'quantity' => $item['quantity'],
                    'price' => $item['price'], // jedinicna cena
                    'total' => $lineTotal,
                ]);
                $totalPrice += $lineTotal;
            }

            // Update total price u order
            $order->total_price = $totalPrice;
            $order->save();

            // Setuj sto kao occupied = true
            $table = Table::findOrFail($data['table_id']);
            $table->status = 2;  // 2 znači occupied
            $table->save();

            DB::commit();

            return response()->json(['message' => 'Order created successfully!', 'order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation error: '.$e->getMessage(), ['exception' => $e]);
            return response()->json(['message' => 'Error creating order', 'error' => $e->getMessage()], 500);
        }
        
    }

    public function pay(Order $order)
    {
        // Proveri da li je narudžbina trenutno neplaćena (1)
        if ($order->is_paid != 1) {
            return response()->json(['message' => 'Order is already paid or invalid status'], 400);
        }

        // Promeni status narudžbine na 2 (plaćeno)
        $order->is_paid = 2;
        $order->save();

        // Oslobodi sto (status = 1)
        $table = $order->table;
        $table->status = 1; // slobodan sto
        $table->save();

        return response()->json(['message' => 'Order paid successfully and table freed']);
    }

}
