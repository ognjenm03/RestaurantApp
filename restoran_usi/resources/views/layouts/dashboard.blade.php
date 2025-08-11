<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex bg-gray-100">

    <!-- Sidebar -->
    <div class="w-64 bg-gray-800 text-white min-h-screen p-4 flex flex-col justify-between">
    <div>
        <h2 class="text-2xl font-bold mb-6">Dashboard</h2>
        <ul class="space-y-2">
            <li><a href="{{ route('tables.index') }}" class="block p-2 rounded hover:bg-gray-700">Tables</a></li>
            <li><a href="{{ route('statistics.index') }}" class="block p-2 rounded hover:bg-gray-700">Statistic</a></li>
            <li><a href="{{ route('bills.index') }}" class="block p-2 rounded hover:bg-gray-700">Bills</a></li>
            @if(auth()->user()->type?->type_name === 'Admin')
                <li><a href="{{ route('users.index') }}" class="block p-2 rounded hover:bg-gray-700">Users</a></li>
            @endif
        </ul>
    </div>

        <!-- Logout button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full mt-4 p-2 bg-red-600 hover:bg-red-700 rounded">
                Logout
            </button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        @yield('content')
    </div>

    @yield('scripts')

</body>
</html>
