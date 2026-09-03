<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Thông báo</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-50 text-green-700 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(auth()->user()->unreadNotifications->count() > 0)
                <form method="POST" action="{{ route('notifications.readAll') }}" class="mb-4 text-right">
                    @csrf
                    <button type="submit" class="text-sm text-blue-600 hover:underline">
                        Đánh dấu tất cả đã đọc
                    </button>
                </form>
            @endif

            <div class="bg-white border rounded-lg divide-y">
                @forelse($notifications as $n)
                    <form method="POST" action="{{ route('notifications.read', $n->id) }}">
                        @csrf
                        <button type="submit"
                                class="block w-full text-left px-4 py-4 hover:bg-gray-50 {{ $n->read_at ? '' : 'bg-blue-50' }}">
                            <p class="text-sm text-gray-800">{{ $n->data['message'] ?? 'Thông báo' }}</p>
                            @if(!empty($n->data['reason']))
                                <p class="text-xs text-gray-600 mt-1">Lý do: {{ $n->data['reason'] }}</p>
                            @endif
                            <p class="text-xs text-gray-500 mt-1">{{ $n->created_at->diffForHumans() }}</p>
                        </button>
                    </form>
                @empty
                    <p class="px-4 py-10 text-center text-gray-500">Chưa có thông báo nào</p>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>