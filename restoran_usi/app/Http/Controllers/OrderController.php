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
            $order = Order::create([
                'table_id' => $data['table_id'],
                'payment_method' => $data['payment_method'],
                'total_price' => 0,
                'is_paid' => 0,
                'user_id' => auth()->id(), 
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

            $order->total_price = $totalPrice;
            $order->save();

            $table = Table::findOrFail($data['table_id']);
            $table->status = 2;  // 2 znaci occupied
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
        Log::info('Pay method called for order', ['order_id' => $order->order_id, 'is_paid_before' => $order->is_paid]);

        if ($order->is_paid == 1) {
            return response()->json(['message' => 'Order is already paid'], 400);
        }

        // placeno = 1
        $order->is_paid = 1; 
        $order->save();

        $table = $order->table;
        $table->status = 1; // slobodan sto
        $table->save();

        return response()->json(['message' => 'Order paid successfully and table freed']);
    }

}
