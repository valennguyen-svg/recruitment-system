<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" type="button" class="relative p-2 rounded hover:bg-gray-100">
        <span class="text-xl">Thông Báo</span>
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-1.5 min-w-[18px]">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open"
         @click.outside="open = false"
         x-cloak
         class="absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded-lg shadow-lg z-50">

        <div class="px-4 py-2 border-b flex justify-between items-center">
            <span class="font-semibold text-sm">Thông báo</span>
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button type="submit" class="text-xs text-blue-600 hover:underline">
                        Đánh dấu đã đọc
                    </button>
                </form>
            @endif
        </div>

        @forelse($unread as $n)
            <form method="POST" action="{{ route('notifications.read', $n->id) }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-3 hover:bg-gray-50 border-b">
                    <p class="text-sm text-gray-800">{{ $n->data['message'] ?? 'Thông báo mới' }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $n->created_at->diffForHumans() }}</p>
                </button>
            </form>
        @empty
            <p class="px-4 py-6 text-sm text-gray-500 text-center">Không có thông báo mới</p>
        @endforelse

        <a href="{{ route('notifications.index') }}"
           class="block px-4 py-2 text-center text-sm text-blue-600 hover:bg-gray-50">
            Xem tất cả
        </a>
    </div>
</div>