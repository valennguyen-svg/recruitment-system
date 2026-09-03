@php
    use App\Enums\UserRole;

    $user    = auth()->user();
    $isStaff = $user?->hasAnyRole([UserRole::ADMIN->value, UserRole::RECRUITER->value]) ?? false;
    $profile = $user?->candidateProfile;

    $closed  = $jobPost->deadline !== null && $jobPost->deadline->isPast();
    $resumes = $profile?->resumes ?? collect();

    $applied = $profile !== null
        && $profile->applications()->where('job_post_id', $jobPost->getKey())->exists();
@endphp

<h3 class="font-semibold text-lg mb-3">{{ __('application.fields.title') }}</h3>

@guest
    <p class="text-sm text-gray-600 mb-3">{{ __('application.messages.login_first') }}</p>

    <a href="{{ route('login') }}"
       class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg px-4 py-2.5">
        {{ __('nav.login') }}
    </a>

    <a href="{{ route('register') }}"
       class="block w-full text-center mt-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg px-4 py-2.5">
        {{ __('nav.register') }}
    </a>
@else
    @if ($isStaff)
        <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600">
            {{ __('application.messages.staff_cannot', [
                'role' => $user->hasRole(UserRole::ADMIN->value)
                    ? UserRole::ADMIN->label()
                    : UserRole::RECRUITER->label(),
            ]) }}
        </div>

    @elseif ($resumes->isEmpty())
        <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-sm text-yellow-800">
            {{ __('application.messages.need_cv') }}
        </div>

        <a href="{{ route('candidate.cv.create') }}"
           class="block w-full text-center mt-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg px-4 py-2.5">
            {{ __('application.messages.upload_cv') }}
        </a>

    @elseif ($applied)
        <div class="p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-800">
            {{ __('application.messages.already_sent') }}
        </div>

        <a href="{{ route('applications.index') }}"
           class="block w-full text-center mt-3 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-lg px-4 py-2.5">
            {{ __('application.messages.view_applied') }}
        </a>

    @elseif ($closed)
        <div class="p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
            {{ __('application.messages.job_closed') }}
        </div>

    @else
        <form method="POST" action="{{ route('applications.store', $jobPost) }}" class="space-y-3">
            @csrf

            <div>
                <label for="resume_id" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('application.fields.choose_cv') }}
                </label>
                <select name="resume_id" id="resume_id" required
                        class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach ($resumes as $resume)
                        <option value="{{ $resume->getKey() }}" @selected(old('resume_id') == $resume->getKey())>
                            {{ $resume->title }}
                        </option>
                    @endforeach
                </select>
                @error('resume_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('application.fields.cover_letter') }}
                    <span class="text-gray-400 font-normal">{{ __('application.fields.optional') }}</span>
                </label>
                <textarea name="cover_letter" id="cover_letter" rows="4"
                          placeholder="{{ __('application.fields.placeholder') }}"
                          class="w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('cover_letter') }}</textarea>
                @error('cover_letter')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg px-4 py-2.5">
                {{ __('application.fields.submit') }}
            </button>
        </form>

        <div class="mt-3 pt-3 border-t">
            <a href="{{ route('candidate.cv.create') }}"
               class="block w-full text-center border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg px-4 py-2">
                {{ __('application.messages.upload_other') }}
            </a>
        </div>
    @endif
@endguest