@extends('layouts.dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Tables</h1>

    <div class="grid grid-cols-4 gap-6">
        @foreach($tables as $table)
            <a href="{{ route('tables.show', $table) }}" class="block p-6 rounded-lg shadow-md border-2
                {{ $table->status == 1 ? 'bg-green-100 border-green-500' : 'bg-red-100 border-red-500' }} hover:shadow-lg transition-shadow"
                >
                <h2 class="text-lg font-bold mb-2">Table {{ $table->table_number }}</h2>
                @if($table->status == 1)
                    <p class="text-green-700 font-semibold">Free</p>
                @elseif($table->status == 2)
                    <p class="text-red-700 font-semibold">Occupied</p>
                @else
                    <p class="text-gray-500">Status unknown</p>
                @endif
            </a>
        @endforeach
    </div>
@endsection
