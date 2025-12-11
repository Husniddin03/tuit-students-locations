<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Parolni unutgan talabalar
                </h1>
            </div>


        </div>

        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">


            <div class="col-span-full xl:col-span-12 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
                <header class="px-5 py-4 border-b flex border-gray-100 dark:border-gray-700/60">
                    <h2 class="font-semibold text-gray-800 w-full dark:text-gray-100">Hozirgi holatlari</h2>
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
                                        <div class="font-semibold text-center">Talaba ismi</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Talaba ID</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Talaba bilan bog'lanish</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Holati</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Sana</div>
                                    </th>
                                </tr>
                            </thead>
                            <!-- Table body -->
                            <tbody class="text-sm font-medium divide-y divide-gray-100 dark:divide-gray-700/60">
                                <!-- Row -->
                                @foreach ($students as $student)
                                    <tr>
                                        <td class="p-2">
                                            <div class="text-center"><a
                                                    href="{{ route('students.show', $student->id) }}">{{ $student->student->first_name . ' ' . $student->student->last_name }}</a>
                                            </div>
                                        </td>
                                        <td class="p-2">
                                            <div class="text-center">{{ $student->student_id }}</div>
                                        </td>
                                        <td class="p-2">
                                            <div class="text-center">{{ $student->messeng }}</div>
                                        </td>
                                        <td class="p-2">
                                            @if ($student->status == 0)
                                                <div class="text-center text-red-500">Parolni tiklash
                                                    kutmoqda</div>
                                            @else
                                                <div class="text-center text-green-500">Parol yangilangan</div>
                                            @endif
                                        </td>
                                        <td class="p-2">
                                            <div class="text-center">{{ $student->updated_at }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>

    </div>
</x-app-layout>
