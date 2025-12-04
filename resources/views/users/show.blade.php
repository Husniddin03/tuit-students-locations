<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 space-y-8">

        {{-- ================= Talaba ma'lumotlari ================= --}}
        <div class=" shadow p-6 rounded">
            <h2 class="text-2xl font-semibold mb-6">Admin Ma'lumotlari</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div><strong>Ismi:</strong> {{ $user->name }}</div>
                <div><strong>Email:</strong> {{ $user->email }}</div>
                <div><strong>Role:</strong> {{ $user->role }}</div>
            </div>
        </div>

        {{-- Back button --}}
        <div class="text-right flex">
            <div>
                <a href="{{ route('users.index') }}" class="btn px-4 py-2 rounded text-black bg-gray-600 ">
                    Orqaga
                </a>
                <a href="{{ route('users.edit', $user->id) }}" class="btn px-4 py-2 rounded text-black bg-green-600 ">
                    Taxrirlash
                </a>
            </div>
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="mx-1"
                onsubmit="return confirm('Rostdan {{ $user->name }} talabani o‘chirilsinmi?');">
                @csrf
                <input type="hidden" name="_method" id="" value="DELETE">
                <button type="submit" class="btn px-4 py-2 rounded text-black bg-red-600 ">
                    O'chirish
                </button>
            </form>
        </div>

    </div>

</x-app-layout>
