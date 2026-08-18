<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Kitchen Ticket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-6">

    <div class="bg-white shadow-md rounded-lg max-w-md w-full p-6 border-t-4 border-indigo-600">
        
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Create Kitchen Ticket</h1>

        <form action="{{ route('kitchen-tickets.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Order Selector -->
            <div>
                <label for="order_id" class="block text-sm font-semibold text-gray-700 mb-2">Select Order</label>
                <select name="order_id" id="order_id" class="w-full border border-gray-300 rounded-md p-2.5 bg-white text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                    <option value="" disabled {{ old('order_id') === null ? 'selected' : '' }}>-- Select an Order --</option>
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                            Order #{{ $order->id }} - Token {{ $order->token_number }}
                        </option>
                    @endforeach
                </select>
                @error('order_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Chef Selector -->
            <div>
                <label for="chef_id" class="block text-sm font-semibold text-gray-700 mb-2">Select Chef</label>
                <select name="chef_id" id="chef_id" class="w-full border border-gray-300 rounded-md p-2.5 bg-white text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                    <option value="" {{ old('chef_id') === null ? 'selected' : '' }}>Not Assigned</option>
                    @foreach($chefs as $chef)
                        <option value="{{ $chef->id }}" {{ old('chef_id') == $chef->id ? 'selected' : '' }}>
                            {{ $chef->name }}
                        </option>
                    @endforeach
                </select>
                @error('chef_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Selector -->
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="w-full border border-gray-300 rounded-md p-2.5 bg-white text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                    <option value="waiting" {{ old('status', 'waiting') === 'waiting' ? 'selected' : '' }}>Waiting</option>
                    <option value="cooking" {{ old('status') === 'cooking' ? 'selected' : '' }}>Cooking</option>
                    <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <a href="{{ route('kitchen-tickets.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm transition duration-150">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2.5 rounded-md shadow transition duration-150 text-sm">
                    Create Ticket
                </button>
            </div>

        </form>

    </div>

</body>
</html>