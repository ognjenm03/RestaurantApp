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
                <div class="bg-white rounded-lg border p-4 shadow flex flex-col">
                    <img src="{{ $item->image ? '/' . $item->image : '/images/menu_items/placeholder.jpg' }}" alt="{{ $item->name }}" class="h-32 w-full object-cover rounded mb-3" />

                    <h3 class="font-semibold mb-1">{{ $item->name }}</h3>
                    <p class="text-gray-700 mb-3">${{ number_format($item->price, 2) }}</p>

                    <!-- Količina i dugmad -->
                    <div class="flex items-center gap-2 mb-3">
                        <button class="px-2 py-1 border rounded">-</button>
                        <input type="number" value="1" min="1" class="w-16 text-center border rounded px-2 py-1" />
                        <button class="px-2 py-1 border rounded">+</button>
                    </div>

                    <button class="mt-auto bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">ADD</button>
                </div>
            @endforeach
        </div>
    </div>

    <!-- DESNO: order box -->
    <div class="w-96 bg-white rounded-lg border p-4 shadow">
        <h2 class="text-lg font-semibold mb-2">Order • Table {{ $table->table_number }}</h2>
        <p class="text-gray-600">Order details will appear here.</p>
    </div>

</div>

@endsection
