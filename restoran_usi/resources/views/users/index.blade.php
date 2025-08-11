@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <h1 class="text-3xl font-semibold mb-6">📋 Lista korisnika</h1>

    <a href="{{ route('users.create') }}" class="inline-block mb-4 rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">
        ➕ Dodaj korisnika
    </a>

    @if(session('success'))
        <div class="mb-4 rounded bg-green-100 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-lg border border-gray-300 shadow-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Korisničko ime</th>
                    <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Puno ime</th>
                    <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Tip korisnika</th>
                    <th class="px-6 py-3 text-center text-sm font-medium uppercase tracking-wider">Akcije</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $user->id }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $user->username }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $user->full_name }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $user->user_type_name }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium space-x-1">
                        <a href="{{ route('users.show', $user) }}" class="inline-block rounded bg-blue-500 px-3 py-1 text-white hover:bg-blue-600 transition">
                            👁 Prikaži
                        </a>
                        <a href="{{ route('users.edit', $user) }}" class="inline-block rounded bg-yellow-400 px-3 py-1 text-white hover:bg-yellow-500 transition">
                            ✏ Uredi
                        </a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Da li ste sigurni?')" class="rounded bg-red-600 px-3 py-1 text-white hover:bg-red-700 transition">
                                🗑 Obriši
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                        Nema korisnika.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
