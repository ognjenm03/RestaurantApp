<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillsController extends Controller
{
    public function index(Request $request): View
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $bills = Order::with('user', 'table')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('bills.index', compact('bills', 'startDate', 'endDate'));
    }

    public function show(Order $order): View
    {
        $order->load('orderItems.menuItem', 'user', 'table');

        return view('bills.show', compact('order'));
    }
}
