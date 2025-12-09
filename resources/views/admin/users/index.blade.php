<x-admin-layout>
    <div class="flex items-center justify-between mb-10">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-neutral-400 mb-1">Community</p>
            <h1 class="text-3xl font-bold tracking-tighter">Customers</h1>
        </div>

        {{-- Search (Minimal) --}}
        <div class="relative group">
            <input type="text" placeholder="FIND CLIENT..."
                class="pl-3 pr-8 py-2 bg-transparent border-b border-neutral-200 text-sm focus:border-black focus:ring-0 placeholder-neutral-400 w-40 transition-all focus:w-64">
            <svg class="w-4 h-4 text-neutral-400 absolute right-2 top-2.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <div class="bg-white">
        @if($users->isEmpty())
        <div class="text-center py-24 border-t border-neutral-100">
            <p class="text-neutral-400">No customers found.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-neutral-100 text-[10px] uppercase tracking-[0.2em] text-neutral-400">
                        <th class="py-4 pl-2 font-medium">Client Profile</th>
                        <th class="py-4 font-medium">Joined Date</th>
                        <th class="py-4 font-medium text-right">Orders</th>
                        <th class="py-4 pr-2 font-medium text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50 text-sm">
                    @foreach($users as $user)
                    <tr class="group hover:bg-neutral-50 transition">
                        {{-- Profile Info --}}
                        <td class="py-4 pl-2">
                            <div class="flex items-center gap-4">
                                {{-- Avatar Placeholder --}}
                                <div
                                    class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold text-xs">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-neutral-900">{{ $user->name }}</div>
                                    <div class="text-xs text-neutral-400">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Joined --}}
                        <td class="py-4 text-neutral-500 font-mono text-xs">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>

                        {{-- Stats --}}
                        <td class="py-4 text-right">
                            <span class="font-mono text-neutral-900">{{ $user->orders_count }}</span>
                            <span class="text-xs text-neutral-400 ml-1">orders</span>
                        </td>

                        {{-- Actions --}}
                        <td class="py-4 pr-2 text-right">
                            <a href="{{ route('admin.users.show', $user->id) }}"
                                class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 hover:text-black transition border border-neutral-200 px-3 py-1.5 rounded hover:border-black">
                                Profile
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $users->links() }}</div>
        @endif
    </div>
</x-admin-layout>