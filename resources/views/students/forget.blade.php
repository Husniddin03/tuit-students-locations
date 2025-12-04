<x-authentication-layout>
    <h1 class="text-3xl text-gray-800 dark:text-gray-100 font-bold mb-6">{{ __('Talaba sifatida kirish') }}</h1>
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif   
    <!-- Form -->
    <form method="POST" action="{{ route('students.send') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <x-label for="email" value="{{ __('Talaba ID') }}" />
                <x-input id="email" type="number" name="student_id" :value="old('student_id')" required autofocus/>                
            </div>
            <div>
                <x-label for="password" value="{{ __('Yangi parol qayerga yuborilsin') }}" />
                <x-input id="password" type="text" name="messeng" required autocomplete="current-password" />                
            </div>
        </div>
        <div class="flex items-center justify-between mt-6">
            @if (Route::has('students.login'))
                <div class="mr-1">
                    <a class="text-sm underline hover:no-underline" href="{{ route('students.login') }}">
                        {{ __('Kirish') }}
                    </a>
                </div>
            @endif            
            <x-button class="ml-3">
                {{ __('Yuborish') }}
            </x-button>            
        </div>
    </form>
    <x-validation-errors class="mt-4" />  
</x-authentication-layout>
