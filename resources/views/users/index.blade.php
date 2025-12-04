<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Barcha Adminlar</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <a href="{{ route('users.create') }}"
                    class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                    <svg class="fill-current shrink-0 xs:hidden" width="16" height="16" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="max-xs:sr-only">Yangi talaba qo'shish</span>
                </a>

            </div>

        </div>

        <!-- Cards -->
        <div class="grid grid-cols-8 gap-6">


            <div class="col-span-full xl:col-span-12 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
                <header class="px-5 py-4 border-b flex border-gray-100 dark:border-gray-700/60">
                    <h2 class="font-semibold text-gray-800 w-full dark:text-gray-100">Adminlar ro'yxati</h2>
                    <form method="GET" class="flex">
                        <label for="count">Adminlar soni</label>
                        <select name="count" id="count" class="form-input w-20" onchange="this.form.submit()">
                            @for ($i = 10; $i <= 100; $i += 10)
                                <option value="{{ $i }}" {{ request('count') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                            <option value="all" {{ request('count') == 'all' ? 'selected' : '' }}>
                                Barcha adminlar
                            </option>

                        </select>
                    </form>

                </header>
                <div class="p-3">

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full dark:text-gray-300">
                            <!-- Table header -->
                            <thead
                                class="text-xs uppercase text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-700/50 rounded-xs">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">F.I.Sh.</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Email</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Roli</div>
                                    </th>
                                </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="text-sm font-medium divide-y divide-gray-100 dark:divide-gray-700/60">
                                <!-- Row -->
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="p-2">
                                            <div class="flex items-center">
                                                <img style="border-radius: 50%; width: 3rem; height: 3rem;"
                                                    src="https://ui-avatars.com/api/?name={{ $user->name}}&background=random&size=64"
                                                    alt="Icon" />

                                                <a href="{{ route('users.show', $user->id) }}"
                                                    class="text-gray-800 dark:text-gray-100 mx-2">{{ $user->name ?? '' }}</a>
                                            </div>
                                        </td>
                                        <td class="p-2">
                                            <div class="text-center">{{ $user->email }}</div>
                                        </td>
                                        <td class="p-2">
                                            <div class="text-center">{{ $user->role }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>


        </div>

    </div>
</x-app-layout>
