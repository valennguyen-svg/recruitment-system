<form method="GET" action="{{ route('jobs.index') }}" id="filterForm"
      class="bg-white border rounded-xl p-4 shadow-sm">

    <div class="flex flex-col md:flex-row gap-3">

        <div class="flex-1">
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Tên vị trí, công ty, kỹ năng..."
                   class="w-full px-3 py-2.5 border-gray-300 rounded-lg text-sm">
        </div>

        <div class="md:w-48">
            <input type="text" name="location" value="{{ request('location') }}"
                   placeholder="Địa điểm"
                   class="w-full px-3 py-2.5 border-gray-300 rounded-lg text-sm">
        </div>

        <div class="md:w-52">
            <select name="category" onchange="this.form.submit()"
                    class="w-full py-2.5 border-gray-300 rounded-lg text-sm">
                <option value="">Tất cả ngành nghề</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(request('category') == $c->id)>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit"
                class="px-6 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 whitespace-nowrap">
            Tìm kiếm
        </button>
    </div>

    <div x-data="{ open: {{ (request('employment_type') || request('salary_min')) ? 'true' : 'false' }} }" class="mt-3">
        <button type="button" @click="open = !open" class="text-sm text-blue-600 hover:underline">
            <span x-show="!open">+ Bộ lọc nâng cao</span>
            <span x-show="open" x-cloak>− Thu gọn</span>
        </button>

        <div x-show="open" x-cloak class="mt-3 flex flex-col md:flex-row gap-3">
            <div class="md:w-52">
                <select name="employment_type" onchange="this.form.submit()"
                        class="w-full py-2.5 border-gray-300 rounded-lg text-sm">
                    <option value="">Mọi loại hình</option>
                    <option value="full_time"  @selected(request('employment_type') === 'full_time')>Toàn thời gian</option>
                    <option value="part_time"  @selected(request('employment_type') === 'part_time')>Bán thời gian</option>
                    <option value="contract"   @selected(request('employment_type') === 'contract')>Hợp đồng</option>
                    <option value="internship" @selected(request('employment_type') === 'internship')>Thực tập</option>
                </select>
            </div>

            <div class="md:w-52">
                <select name="salary_min" onchange="this.form.submit()"
                        class="w-full py-2.5 border-gray-300 rounded-lg text-sm">
                    <option value="">Mọi mức lương</option>
                    <option value="10000000" @selected(request('salary_min') == 10000000)>Từ 10 triệu</option>
                    <option value="15000000" @selected(request('salary_min') == 15000000)>Từ 15 triệu</option>
                    <option value="20000000" @selected(request('salary_min') == 20000000)>Từ 20 triệu</option>
                    <option value="30000000" @selected(request('salary_min') == 30000000)>Từ 30 triệu</option>
                </select>
            </div>

            @if(request()->hasAny(['q', 'location', 'category', 'employment_type', 'salary_min']))
                <a href="{{ route('jobs.index') }}"
                   class="px-4 py-2.5 border rounded-lg text-sm text-gray-600 hover:bg-gray-50 self-start">
                    Xóa bộ lọc
                </a>
            @endif
        </div>
    </div>
</form>

<script>
(function () {
    const form = document.getElementById('filterForm');
    let timer;

    form.querySelectorAll('input[type="text"]').forEach(function (input) {
        input.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(function () { form.submit(); }, 600);
        });
    });
})();
</script>