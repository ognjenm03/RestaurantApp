<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(Request $request): View
    {
        // Period za filtriranje: ako nema inputa, uzima tekući mesec
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        // 1. Promet po načinu plaćanja (keš, kartica)
        $paymentStats = Order::select('payment_method', DB::raw('SUM(total_price) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('payment_method')
            ->get();

        // 2. Najprodavaniji artikli (sumira količine)
        $topItems = OrderItem::select('item_id', DB::raw('SUM(quantity) as total_quantity'))
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->with('menuItem')
            ->groupBy('item_id')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        // 3. Najprometniji stolovi (sumira promet po stolovima)
        $topTables = Order::select('table_id', DB::raw('SUM(total_price) as total_revenue'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('table_id')
            ->orderByDesc('total_revenue')
            ->take(5)
            ->with('table')
            ->get();

        // 4. Promet po konobarima (sumira promet po waiter_id)
        $paymentByWaiters = Order::select('user_id', DB::raw('SUM(total_price) as total_revenue'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('user_id')
            ->orderByDesc('total_revenue')
            ->with('user') // relacija prema korisniku
            ->get();

        return view('statistics.index', compact('paymentStats', 'topItems', 'topTables', 'paymentByWaiters', 'startDate', 'endDate'));
    }
}
