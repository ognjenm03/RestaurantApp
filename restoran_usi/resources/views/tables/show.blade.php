@extends('layouts.dashboard')

@section('content')

<div class="flex gap-6">

    <!-- LEVO: kategorije i proizvodi -->
    <div class="flex-1">
        <h1 class="text-2xl font-semibold mb-4">Table {{ $table->table_number }}</h1>

        <!-- Kategorije - vodoravno -->
        <div class="flex gap-3 overflow-x-auto mb-6">
            <a href="{{ route('tables.show', ['table' => $table->table_id]) }}"
               class="px-4 py-2 rounded shadow {{ empty(request('category')) ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-indigo-600 hover:text-white transition' }}">
               All
            </a>
            @foreach($categories as $category)
                <a href="{{ route('tables.show', ['table' => $table->table_id, 'category' => $category->category_id]) }}"
                   class="px-4 py-2 rounded shadow
                          {{ request('category') == $category->category_id ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-indigo-600 hover:text-white transition' }}">
                   {{ $category->name }}
                </a>
            @endforeach
        </div>

        <!-- Proizvodi -->
        <div class="grid grid-cols-3 gap-6">
            @foreach($menuItems as $item)
                <div class="bg-white rounded-lg border p-4 shadow flex flex-col product-card">
                    <img src="{{ $item->image ? '/' . $item->image : '/images/menu_items/placeholder.jpg' }}"
                         alt="{{ $item->name }}" class="h-32 w-full object-cover rounded mb-3" />

                    <h3 class="font-semibold mb-1">{{ $item->name }}</h3>
                    <p class="text-gray-700 mb-3">${{ number_format($item->price, 2) }}</p>

                    <!-- Količina -->
                    <input type="number" value="1" min="1" class="w-20 text-center border rounded px-2 py-1 mb-3 quantity-input" />

                    <button
                        class="mt-auto bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition add-to-order"
                        data-id="{{ $item->item_id }}"
                        data-name="{{ $item->name }}"
                        data-price="{{ $item->price }}">
                        ADD
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    <!-- DESNO: order box -->
   <div class="w-96 bg-white rounded-lg border p-4 shadow flex flex-col" id="orderBox" style="height: 500px;">
    <h2 class="text-lg font-semibold mb-2">Order • Table {{ $table->table_number }}</h2>

    <!-- Lista stavki sa skrolom -->
        <ul id="orderItems" class="mb-4 text-sm text-gray-700 flex-1 overflow-y-auto border rounded p-2">
        @if(isset($activeOrder) && $activeOrder->orderItems->count() > 0)
            @foreach($activeOrder->orderItems as $orderItem)
                <li class="mb-2 font-semibold text-base">
                    {{ $orderItem->quantity }}x {{ $orderItem->menuItem->name ?? 'Unknown item' }} - ${{ number_format($orderItem->price * $orderItem->quantity, 2) }}
                </li>
            @endforeach
        @else
            <li class="text-gray-400 italic">No items yet</li>
        @endif
    </ul>

    <div class="mt-2 font-semibold">
        Price: $<span id="totalPrice">
            {{ isset($activeOrder) ? number_format($activeOrder->total_price, 2) : '0.00' }}
        </span>
    </div>

    <!-- Payment -->
    <div class="mt-2">
        <label><input type="radio" name="payment_method" value="cash" {{ (isset($activeOrder) && $activeOrder->payment_method == 'cash') ? 'checked' : '' }}> Cash</label>
        <label class="ml-4"><input type="radio" name="payment_method" value="card" {{ (isset($activeOrder) && $activeOrder->payment_method == 'card') ? 'checked' : '' }}> Card</label>
    </div>

    <!-- Dugmad -->
    <div class="flex gap-2 mt-3">
        <button id="createOrderBtn" class="flex-1 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            {{ isset($activeOrder) ? 'Pay' : 'Create' }}
        </button>
        <a href="{{ route('tables.index') }}" class="flex-1 bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 text-center">Cancel</a>
    </div>
</div>


</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const orderItems = [];

    // Ucitaj iz localStorage ako postoji
    const savedOrder = localStorage.getItem('orderItems');
    if (savedOrder) {
        try {
            const parsed = JSON.parse(savedOrder);
            if (Array.isArray(parsed)) {
                orderItems.push(...parsed);
            }
        } catch(e) {
            console.error('Error parsing saved orderItems', e);
        }
    }

    function renderOrderList() {
        const orderList = document.getElementById('orderItems');
        orderList.innerHTML = '';
        let totalPrice = 0;

        if(orderItems.length === 0) {
            orderList.innerHTML = '<li class="text-gray-400 italic">No items yet</li>';
        } else {
            orderItems.forEach(item => {
                totalPrice += item.price * item.quantity;
                const li = document.createElement('li');
                li.textContent = `${item.quantity}x ${item.name} - $${(item.price * item.quantity).toFixed(2)}`;
                li.className = 'mb-2 font-semibold text-base';
                orderList.appendChild(li);
            });
        }

        document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
    }

    const buttons = document.querySelectorAll('.add-to-order');
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const productCard = button.closest('.product-card');
            const quantityInput = productCard.querySelector('.quantity-input');
            const quantity = parseInt(quantityInput.value);

            if(quantity < 1 || isNaN(quantity)) {
                alert('Please enter a valid quantity (1 or more).');
                return;
            }

            const itemId = button.dataset.id;
            const itemName = button.dataset.name;
            const itemPrice = parseFloat(button.dataset.price);

            let existing = orderItems.find(item => item.item_id === itemId);
            if(existing) {
                existing.quantity += quantity;
            } else {
                orderItems.push({ item_id: itemId, name: itemName, price: itemPrice, quantity });
            }

            // Sacuvaj u localStorage
            localStorage.setItem('orderItems', JSON.stringify(orderItems));

            renderOrderList();
        });
    });

    // Dodaj event listener za Create dugme
    document.getElementById('createOrderBtn').addEventListener('click', () => {
        if (orderItems.length === 0) {
            alert('Order is empty!');
            return;
        }

        const paymentMethodInput = document.querySelector('input[name="payment_method"]:checked');
        if (!paymentMethodInput) {
            alert('Please select a payment method');
            return;
        }
        const paymentMethod = paymentMethodInput.value;

        const payload = {
            table_id: "{{ $table->table_id }}",
            payment_method: paymentMethod,
            items: orderItems
        };

        fetch("{{ route('orders.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(payload)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            alert(data.message || 'Order created successfully!');
            localStorage.removeItem('orderItems');
            window.location.href = "{{ route('tables.index') }}";
        })
        .catch(async err => {
            console.error('Full error:', err);

            // pokušaj izvući detalje iz json odgovora ako ih ima
            let msg = 'Unknown error';
            if (err instanceof Response) {
                const json = await err.json().catch(() => null);
                if (json && json.message) msg = json.message;
            } else if (err.message) {
                msg = err.message;
            }

            alert('Failed to create order: ' + msg);
        });
    });

    renderOrderList();
});
</script>
@endsection
