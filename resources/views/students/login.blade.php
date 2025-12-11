<x-authentication-layout>
    <h1 class="text-3xl text-gray-800 dark:text-gray-100 font-bold mb-6">{{ __('Talaba sifatida kirish') }}</h1>
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif
    <!-- Form -->

    <form method="POST" action="{{ route('students.check') }}">
        @csrf
        <div class="space-y-4">
            <!-- Student ID -->
            <div>
                <x-label for="student_id" value="{{ __('Talaba ID') }}" />
                <x-input id="student_id" type="number" name="student_id" :value="old('student_id', $student_id ?? '')" required autofocus
                    autocomplete="off" />
                @error('student_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password (faqat kerak bo'lganda ko'rsatiladi) -->
            @if (isset($get_password) && $get_password)
                <div>
                    <x-label for="password" value="{{ __('Parol') }}" />
                    <x-input id="password" type="password" name="password" required autocomplete="current-password" />
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('students.forget') && isset($get_password))
                <div class="mr-1">
                    <a class="text-sm underline hover:no-underline" href="{{ route('students.forget') }}">
                        {{ __('Parolni unutdingizmi?') }}
                    </a>
                </div>
            @endif

            <x-button class="ml-auto">
                @if (isset($get_password) && $get_password)
                    {{ __('Kirish') }}
                @else
                    {{ __('Davom etish') }}
                @endif
            </x-button>
        </div>
    </form>
    <x-validation-errors class="mt-4" />

    @if (session('send'))
        <div class="fixed bottom-6 right-6 bg-green-500 text-white-500 rounded-lg shadow-lg z-50">
            <div class="p-4">Xabar yuborildi</div>
        </div>
    @endif


</x-authentication-layout>
