@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto mt-8 px-4 max-w-5xl">
    <h1 class="text-3xl font-semibold mb-6">📊 Sales Statistics</h1>

    <form method="GET" action="{{ route('statistics.index') }}" class="mb-8 flex space-x-4 items-end">
        <div>
            <label for="start_date" class="block font-medium text-gray-700">Start Date</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $startDate) }}" class="border rounded px-3 py-1">
        </div>
        <div>
            <label for="end_date" class="block font-medium text-gray-700">End Date</label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $endDate) }}" class="border rounded px-3 py-1">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
    </form>

    {{-- 1. Promet po načinu plaćanja --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Payment Method Revenue</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Payment Method</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paymentStats as $payment)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ ucfirst($payment->payment_method) }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">${{ number_format($payment->total, 2) }}</td>
                </tr>
                @endforeach
                @if($paymentStats->isEmpty())
                <tr>
                    <td colspan="2" class="text-center p-4">No data available for selected period.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </section>

    {{-- 2. Najprodavaniji artikli --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Top Selling Items</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Item Name</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">Quantity Sold</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topItems as $item)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $item->menuItem->name ?? 'N/A' }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">{{ $item->total_quantity }}</td>
                </tr>
                @endforeach
                @if($topItems->isEmpty())
                <tr>
                    <td colspan="2" class="text-center p-4">No sales data available for selected period.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </section>

    {{-- 3. Najprometniji stolovi --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Top Tables by Revenue</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Table Number</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topTables as $tableStat)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $tableStat->table->table_number ?? 'N/A' }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">${{ number_format($tableStat->total_revenue, 2) }}</td>
                </tr>
                @endforeach
                @if($topTables->isEmpty())
                <tr>
                    <td colspan="2" class="text-center p-4">No data available for selected period.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </section>

    {{-- 4. Promet po konobarima --}}
    <section class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Revenue by Waiters</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Waiter Name</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paymentByWaiters as $waiterStat)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $waiterStat->user->full_name ?? 'N/A' }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">${{ number_format($waiterStat->total_revenue, 2) }}</td>
                </tr>
                @endforeach
                @if($paymentByWaiters->isEmpty())
                <tr>
                    <td colspan="2" class="text-center p-4">No data available for selected period.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </section>
</div>
@endsection
