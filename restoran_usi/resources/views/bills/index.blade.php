@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto mt-8 px-4 max-w-5xl">
    <h1 class="text-3xl font-semibold mb-6">🧾 Bills</h1>

    <form method="GET" action="{{ route('bills.index') }}" class="mb-6 flex space-x-4 items-end">
        <div>
            <label for="start_date" class="block font-medium text-gray-700">Start Date</label>
            <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $startDate) }}" class="border rounded px-3 py-1">
        </div>
        <div>
            <label for="end_date" class="block font-medium text-gray-700">End Date</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $endDate) }}" class="border rounded px-3 py-1">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
    </form>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">Bill ID</th>
                <th class="border border-gray-300 px-4 py-2">Date</th>
                <th class="border border-gray-300 px-4 py-2">Table</th>
                <th class="border border-gray-300 px-4 py-2">Waiter</th>
                <th class="border border-gray-300 px-4 py-2 text-right">Total</th>
                <th class="border border-gray-300 px-4 py-2">Payment Method</th>
                <th class="border border-gray-300 px-4 py-2">Details</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bills as $bill)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $bill->order_id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $bill->created_at->format('Y-m-d H:i') }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $bill->table->table_number ?? 'N/A' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $bill->user->full_name ?? 'N/A' }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">${{ number_format($bill->total_price, 2) }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ ucfirst($bill->payment_method) }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <a href="{{ route('bills.show', $bill) }}" class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center p-4">No bills found for the selected period.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $bills->withQueryString()->links() }}
    </div>
</div>
@endsection
