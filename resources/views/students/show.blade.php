<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 space-y-8">

        {{-- ================= Talaba ma'lumotlari ================= --}}
        <div class=" shadow p-6 rounded">
            <h2 class="text-2xl font-semibold mb-6">Talaba Ma'lumotlari</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div><strong>Student ID:</strong> {{ $student->student_id }}</div>
                <div><strong>Ism:</strong> {{ $student->first_name }}</div>
                <div><strong>Familiya:</strong> {{ $student->last_name }}</div>
                <div><strong>Sharif:</strong> {{ $student->middle_name ?? '-' }}</div>
                <div><strong>Fakultet:</strong> {{ $student->faculty }}</div>
                <div><strong>Guruh:</strong> {{ $student->group }}</div>
                <div><strong>Telefon:</strong> {{ $student->phone ?? '-' }}</div>
                <div><strong>Coach:</strong> {{ $student->coach ?? '-' }}</div>
                <div><strong>Otasining ismi:</strong> {{ $student->father ?? '-' }}</div>
                <div><strong>Onasining ismi:</strong> {{ $student->mather ?? '-' }}</div>
                <div><strong>Viloyat:</strong> {{ $student->province ?? '-' }}</div>
                <div><strong>Tuman:</strong> {{ $student->region ?? '-' }}</div>
                <div><strong>Manzil:</strong> {{ $student->address ?? '-' }}</div>
                <div><strong>Otasining telefoni:</strong> {{ $student->father_phone ?? '-' }}</div>
                <div><strong>Onasining telefoni:</strong> {{ $student->mather_phone ?? '-' }}</div>
            </div>
        </div>

        {{-- ================= Yotoqxona ================= --}}
        @if ($student->dormitory)
            <div class=" shadow p-6 rounded">
                <h2 class="text-2xl font-semibold mb-6">Yotoqxona Ma'lumotlari</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div><strong>Yotoqxona nomi:</strong> {{ $student->dormitory->dormitory }}</div>
                    <div><strong>Xona raqami:</strong> {{ $student->dormitory->room }}</div>
                    <div><strong>Imtiyoz (%):</strong> {{ $student->dormitory->privileged }}</div>
                    <div><strong>To'lov miqdori:</strong> {{ $student->dormitory->amount }}</div>
                </div>
            </div>
        @endif

        {{-- ================= IJARA ================= --}}
        @if ($student->rent)
            <div class=" shadow p-6 rounded">
                <h2 class="text-2xl font-semibold mb-6">Ijara Ma'lumotlari</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div><strong>Viloyat:</strong> {{ $student->rent->province ?? '-' }}</div>
                    <div><strong>Tuman:</strong> {{ $student->rent->region ?? '-' }}</div>
                    <div><strong>Manzil:</strong> {{ $student->rent->address ?? '-' }}</div>
                    <div><strong>Toifa:</strong> {{ $student->rent->category ?? '-' }}</div>
                    <div><strong>Uy egasi:</strong> {{ $student->rent->owner_name ?? '-' }}</div>
                    <div><strong>Uy egasi telefoni:</strong> {{ $student->rent->owner_phone ?? '-' }}</div>
                    <div><strong>Shartnoma summasi:</strong> {{ $student->rent->contract }}</div>
                    <div><strong>To'lov miqdori:</strong> {{ $student->rent->amount }}</div>
                </div>
            </div>
        @endif

        {{-- ================= Xarita ================= --}}
        <div class=" shadow p-6 rounded">
            <h2 class="text-2xl font-semibold mb-4">Joylashuv Xaritada</h2>
            <div id="map" style="width: 100%; height: 400px;"></div>
        </div>

        {{-- Back button --}}
        <div class="text-right flex">
            <div>
                @auth
                    <a href="{{ route('students.index') }}" class="btn px-4 py-2 rounded text-black bg-gray-600 ">
                        Orqaga
                    </a>
                @endauth
                <a href="{{ route('students.edit', $student->id) }}"
                    class="btn px-4 py-2 rounded text-black bg-green-600 ">
                    Taxrirlash
                </a>
            </div>
            @auth
                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="mx-1"
                    onsubmit="return confirm('Rostdan {{ $student->first_name }} talabani o‘chirilsinmi?');">
                    @csrf
                    <input type="hidden" name="_method" id="" value="DELETE">
                    <button type="submit" class="btn px-4 py-2 rounded text-black bg-red-600 ">
                        O'chirish
                    </button>
                </form>
            @endauth
        </div>

    </div>

    {{-- ================= Google Map JS ================= --}}
    <script>
        function initMap() {
            // Default location: agar studentda latitude/longitude bo'lmasa Tashkent
            let lat = parseFloat("{{ $student->dormitory->latitude ?? ($student->rent->latitude ?? 41.311081) }}");
            let lng = parseFloat("{{ $student->dormitory->longitude ?? ($student->rent->longitude ?? 69.240562) }}");

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: {
                    lat: lat,
                    lng: lng
                },
            });

            // Marker qo'yish
            new google.maps.Marker({
                position: {
                    lat: lat,
                    lng: lng
                },
                map: map,
                title: "{{ $student->first_name }} {{ $student->last_name }}"
            });
        }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAM-lcwS2aMgdJd5AMxE8N_1Lu7M3aHJUw&callback=initMap"></script>
</x-app-layout>
