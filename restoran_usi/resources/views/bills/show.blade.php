@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto mt-8 px-4 max-w-3xl">
    <h1 class="text-3xl font-semibold mb-6">Bill Details - #{{ $order->order_id }}</h1>

    <div class="mb-6">
        <p><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
        <p><strong>Table:</strong> {{ $order->table->table_number ?? 'N/A' }}</p>
        <p><strong>Waiter:</strong> {{ $order->user->full_name ?? 'N/A' }}</p>
        <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
    </div>

    <table class="w-full border-collapse border border-gray-300 mb-6">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2 text-left">Item</th>
                <th class="border border-gray-300 px-4 py-2 text-right">Quantity</th>
                <th class="border border-gray-300 px-4 py-2 text-right">Price per unit</th>
                <th class="border border-gray-300 px-4 py-2 text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ $item->menuItem->name ?? 'N/A' }}</td>
                <td class="border border-gray-300 px-4 py-2 text-right">{{ $item->quantity }}</td>
                <td class="border border-gray-300 px-4 py-2 text-right">${{ number_format($item->price, 2) }}</td>
                <td class="border border-gray-300 px-4 py-2 text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="border border-gray-300 px-4 py-2 text-right">Total</th>
                <th class="border border-gray-300 px-4 py-2 text-right">${{ number_format($order->total_price, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <a href="{{ route('bills.index') }}" class="text-blue-600 hover:underline">Back to Bills List</a>
</div>
@endsection
