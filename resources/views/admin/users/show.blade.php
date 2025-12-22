<x-admin-layout>
    <div class="mb-10">
        <a href="{{ route('admin.users.index') }}"
            class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 hover:text-black transition mb-2 block">
            &larr; Back to Customers
        </a>
        <h1 class="text-3xl font-bold tracking-tighter">Customer Profile</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

        {{-- LEFT: CLIENT CARD --}}
        <div class="space-y-8">
            {{-- Info Card --}}
            <div class="bg-neutral-50 p-8 border border-neutral-100 text-center">
                <div
                    class="w-20 h-20 bg-black text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                <p class="text-sm text-neutral-500 mb-6">{{ $user->email }}</p>

                <div class="grid grid-cols-2 gap-4 border-t border-neutral-200 pt-6">
                    <div>
                        <span class="block text-[10px] uppercase tracking-widest text-neutral-400">Orders</span>
                        <span class="font-mono text-lg font-medium">{{ $orders->total() }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase tracking-widest text-neutral-400">Spent</span>
                        <span class="font-mono text-lg font-medium">₫{{ number_format($totalSpent, 0, ',', '.')
                            }}</span>
                    </div>
                </div>
            </div>

            {{-- Contact Info --}}
            <div>
                <h3
                    class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400 mb-4 border-b border-neutral-100 pb-2">
                    Contact Details</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-neutral-400 block text-xs">Email</span>
                        <span class="font-medium">{{ $user->email }}</span>
                    </div>
                    <div>
                        <span class="text-neutral-400 block text-xs">Phone</span>
                        <span class="font-medium">{{ $user->phone ?? 'Not provided' }}</span>
                    </div>
                    <div>
                        <span class="text-neutral-400 block text-xs">Address</span>
                        <span class="font-medium">{{ $user->address ?? 'Not provided' }}</span>
                    </div>
                    <div>
                        <span class="text-neutral-400 block text-xs">Member Since</span>
                        <span class="font-mono">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="pt-8">
                <form id="delete-user-form" action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                    class="inline-block">
                    @csrf @method('DELETE')
                    <button type="button" onclick="confirmDeleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')"
                        class="text-red-500 text-xs font-bold uppercase tracking-widest hover:text-red-700 border-b border-red-200 pb-0.5">
                        Delete Customer
                    </button>
                </form>
            </div>
        </div>

        {{-- RIGHT: ORDER HISTORY --}}
        <div class="lg:col-span-2">
            <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400 mb-6">Recent Orders</h3>

            @if($orders->isEmpty())
            <div class="p-8 bg-neutral-50 border border-dashed border-neutral-200 text-center text-neutral-400 text-sm">
                No orders placed yet.
            </div>
            @else
            <div class="bg-white border border-neutral-100">
                <table class="w-full text-left">
                    <thead class="bg-neutral-50">
                        <tr class="text-[10px] uppercase tracking-wider text-neutral-400">
                            <th class="p-4 font-medium">Order</th>
                            <th class="p-4 font-medium">Date</th>
                            <th class="p-4 font-medium">Status</th>
                            <th class="p-4 font-medium text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 text-sm">
                        @foreach($orders as $order)
                        <tr class="group hover:bg-neutral-50 transition cursor-pointer"
                            onclick="window.location='{{ route('admin.orders.show', $order->id) }}'">
                            <td class="p-4 font-mono font-medium text-black">#{{ $order->id }}</td>
                            <td class="p-4 text-neutral-500">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="p-4">
                                <span
                                    class="inline-block px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide border rounded-sm
                                        {{ $order->status === 'completed' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-white text-neutral-600 border-neutral-200' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="p-4 text-right font-mono font-medium">
                                ₫{{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $orders->links() }}</div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDeleteUser(userId, userName) {
            Swal.fire({
                title: 'Delete Customer?',
                html: `<p class="text-gray-600">You are about to delete: <span class="font-semibold text-black">${userName}</span></p>
                       <p class="text-sm text-red-500 mt-2">This action cannot be undone. All orders and user data will be permanently deleted.</p>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000000',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'rounded-none',
                    confirmButton: 'rounded-none font-bold uppercase tracking-wider text-xs px-6 py-3',
                    cancelButton: 'rounded-none font-bold uppercase tracking-wider text-xs px-6 py-3',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-user-form').submit();
                }
            });
        }
    </script>
    @endpush
</x-admin-layout>