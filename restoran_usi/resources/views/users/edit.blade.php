@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto mt-8 px-4 max-w-lg">
    <h1 class="text-2xl font-semibold mb-6">✏️ Izmeni korisnika</h1>

    @if ($errors->any())
        <div class="mb-4 rounded bg-red-100 px-4 py-3 text-red-700">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6 bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')

        <div>
            <label for="username" class="block font-medium text-gray-700">Korisničko ime</label>
            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label for="full_name" class="block font-medium text-gray-700">Puno ime</label>
            <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $user->full_name) }}" required
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label for="password" class="block font-medium text-gray-700">Nova lozinka <small>(ostavi prazno ako ne menjaš)</small></label>
            <input type="password" name="password" id="password"
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label for="password_confirmation" class="block font-medium text-gray-700">Potvrdi novu lozinku</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label for="user_type_id" class="block font-medium text-gray-700">Tip korisnika</label>
            <select name="user_type_id" id="user_type_id" required
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option value="" disabled {{ old('user_type_id', $user->user_type_id) ? '' : 'selected' }}>Izaberi tip</option>
                @foreach($userTypes as $id => $name)
                    <option value="{{ $id }}" {{ old('user_type_id', $user->user_type_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('users.index') }}" class="rounded border border-gray-300 px-4 py-2 hover:bg-gray-100">Otkaži</a>
            <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">Sačuvaj izmene</button>
        </div>
    </form>
</div>
@endsection
