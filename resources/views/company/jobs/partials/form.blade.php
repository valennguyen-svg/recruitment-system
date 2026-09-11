@php
    use App\Enums\EmploymentType;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
        <x-input-label for="title" :value="__('job.fields.title')" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                      :value="old('title', $job?->title)" required autofocus />
        @error('title')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <x-input-label for="category_id" :value="__('job.fields.category')" />
        <select id="category_id" name="category_id" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @foreach ($categories as $id => $name)
                <option value="{{ $id }}" @selected(old('category_id', $job?->category_id) == $id)>
                    {{ $name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <x-input-label for="employment_type" :value="__('job.fields.employment_type')" />
        <select id="employment_type" name="employment_type" required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @foreach (EmploymentType::cases() as $type)
                <option value="{{ $type->value }}"
                        @selected(old('employment_type', $job?->employment_type?->value) === $type->value)>
                    {{ $type->label() }}
                </option>
            @endforeach
        </select>
        @error('employment_type')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <x-input-label for="location" :value="__('job.fields.location')" />
        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full"
                      :value="old('location', $job?->location)" required />
        @error('location')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <x-input-label for="deadline" :value="__('job.fields.deadline')" />
        <x-text-input id="deadline" name="deadline" type="date" class="mt-1 block w-full"
                      :value="old('deadline', $job?->deadline?->format('Y-m-d'))" required />
        @error('deadline')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2" x-data="{ negotiable: {{ old('salary_negotiable', $job?->salary_negotiable) ? 'true' : 'false' }} }">
        <label class="inline-flex items-center gap-2">
            <input type="hidden" name="salary_negotiable" value="0">
            <input type="checkbox" name="salary_negotiable" value="1" x-model="negotiable"
                   class="rounded border-gray-300 text-indigo-600">
            <span class="text-sm text-gray-700">{{ __('job.fields.salary_negotiable') }}</span>
        </label>

        <div class="grid grid-cols-2 gap-4 mt-3" x-show="! negotiable">
            <div>
                <x-input-label for="salary_min" :value="__('job.fields.salary_min')" />
                <x-text-input id="salary_min" name="salary_min" type="number" min="0" max="1000000000" step="100000"
                              class="mt-1 block w-full" :value="old('salary_min', $job?->salary_min)" />
                @error('salary_min')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-input-label for="salary_max" :value="__('job.fields.salary_max')" />
                <x-text-input id="salary_max" name="salary_max" type="number" min="0" max="1000000000" step="100000"
                              class="mt-1 block w-full" :value="old('salary_max', $job?->salary_max)" />
                @error('salary_max')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    @foreach (['description', 'requirements', 'benefits'] as $field)
        <div class="md:col-span-2">
            <x-input-label :for="$field" :value="__('job.fields.' . $field)" />
            <textarea id="{{ $field }}" name="{{ $field }}" rows="6"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                      @if ($field === 'description') required @endif>{{ old($field, $job?->{$field}) }}</textarea>
            @error($field)
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    @endforeach
</div>