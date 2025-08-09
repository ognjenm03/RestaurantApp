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
    <div class="w-64 bg-gray-800 text-white min-h-screen p-4">
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

    <!-- Main Content -->
    <div class="flex-1 p-6">
        @yield('content')
    </div>

</body>
</html>
