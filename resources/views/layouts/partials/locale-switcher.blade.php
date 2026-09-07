@php
    use App\Constants\LocaleConstants;

    $current = app()->getLocale();
@endphp

<div class="flex items-center gap-1 text-sm">
    @foreach (LocaleConstants::SUPPORTED as $locale)
        <a href="{{ route('locale.switch', ['locale' => $locale]) }}"
           class="px-2 py-1 rounded {{ $current === $locale
                ? 'bg-indigo-600 text-white'
                : 'text-gray-600 hover:bg-gray-100' }}">
            {{ LocaleConstants::LABELS[$locale] }}
        </a>
    @endforeach
</div>