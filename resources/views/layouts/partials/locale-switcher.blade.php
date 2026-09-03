@php
    use App\Constants\LocaleConstants;

    $current = app()->getLocale();
@endphp

<div class="flex items-center gap-1 text-sm">
    @foreach (LocaleConstants::SUPPORTED as $locale)
        <form method="POST" action="{{ route('locale.switch') }}">
            @csrf
            <input type="hidden" name="locale" value="{{ $locale }}">
            <button type="submit"
                    class="px-2 py-1 rounded {{ $current === $locale
                        ? 'bg-gray-800 text-white'
                        : 'text-gray-500 hover:text-gray-800' }}">
                {{ strtoupper($locale) }}
            </button>
        </form>
    @endforeach
</div>