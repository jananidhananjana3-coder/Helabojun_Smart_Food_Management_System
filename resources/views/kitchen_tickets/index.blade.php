<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Tickets</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">
        
        <!-- Header Actions -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-800">Kitchen Ticket Management</h1>
            <a href="{{ route('kitchen-tickets.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-md shadow transition duration-150 text-sm">
                + Create Kitchen Ticket
            </a>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-50 text-gray-700 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Order ID</th>
                        <th class="px-6 py-3">Chef</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($kitchenTickets as $ticket)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 font-semibold text-gray-900">#{{ $ticket->id }}</td>
                            <td class="px-6 py-4 text-gray-500">#{{ $ticket->order_id }}</td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $ticket->chef ? $ticket->chef->name : 'Not Assigned' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
                                    {{ $ticket->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('kitchen-tickets.show', $ticket->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-xs">
                                    View
                                </a>
                                <span class="text-gray-300">|</span>
                                <a href="{{ route('kitchen-tickets.edit', $ticket->id) }}" class="text-amber-600 hover:text-amber-900 font-medium text-xs">
                                    Edit
                                </a>
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('kitchen-tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-xs">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                No kitchen tickets found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Optional Pagination Links -->
        @if(method_exists($kitchenTickets, 'links'))
            <div class="mt-4">
                {{ $kitchenTickets->links() }}
            </div>
        @endif

    </div>

</body>
</html>