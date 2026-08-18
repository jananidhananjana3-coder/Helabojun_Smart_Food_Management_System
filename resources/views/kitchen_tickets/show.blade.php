<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Ticket Details</title>
    <!-- Tailwind CSS for clean styling -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-6">

    <div class="bg-white shadow-md rounded-lg max-w-md w-full p-6 border-t-4 border-indigo-600">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Kitchen Ticket Details</h1>

        <div class="space-y-3 mb-6">
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500 font-medium">Ticket ID:</span>
                <span class="text-gray-900 font-semibold">#{{ $kitchenTicket->id }}</span>
            </div>
            
            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500 font-medium">Order ID:</span>
                <span class="text-gray-900 font-semibold">#{{ $kitchenTicket->order_id }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500 font-medium">Token Number:</span>
                <span class="text-gray-900 font-bold text-indigo-600">{{ $kitchenTicket->order?->token_number ?? 'N/A' }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500 font-medium">Chef:</span>
                <span class="text-gray-900 font-medium">
                    {{ $kitchenTicket->chef ? $kitchenTicket->chef->name : 'Not Assigned' }}
                </span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="text-gray-500 font-medium">Status:</span>
                <span class="px-2 py-1 rounded text-xs font-semibold 
                    {{ $kitchenTicket->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($kitchenTicket->status) }}
                </span>
            </div>
        </div>

        <div class="flex justify-between items-center mt-4">
            <a href="{{ route('kitchen-tickets.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium transition duration-150">
                &larr; Back to Tickets
            </a>
        </div>
    </div>

</body>
</html>