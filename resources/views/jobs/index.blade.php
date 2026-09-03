@php
    use App\Enums\EmploymentType;
    use App\Enums\SortOption;
@endphp

<select name="employment_type" class="...">
    <option value="">{{ __('job.attributes.employment_type') }}</option>
    @foreach (EmploymentType::cases() as $type)
        <option value="{{ $type->value }}" @selected(request('employment_type') === $type->value)>
            {{ $type->label() }}
        </option>
    @endforeach
</select>

<select name="sort" class="...">
    @foreach (SortOption::cases() as $option)
        <option value="{{ $option->value }}" @selected(request('sort') === $option->value)>
            {{ $option->label() }}
        </option>
    @endforeach
</select>