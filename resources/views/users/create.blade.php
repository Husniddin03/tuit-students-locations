<x-app-layout>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mt-10 sm:mt-0">
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div
                            class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow-sm sm:rounded-tl-md sm:rounded-tr-md">
                            <div class="grid grid-cols-6 gap-6">
                                <!-- Student ID -->
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block text-sm font-medium mb-1" for="student_id">
                                        Ismi
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="student_id" name="name"
                                        type="text" required>
                                </div>

                                <!-- First Name -->
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-medium mb-1" for="first_name">
                                        email
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="first_name" name="email"
                                        type="email" required>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-medium mb-1" for="last_name">
                                        Parol
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="last_name" name="password"
                                        type="password" required>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-medium mb-1" for="password_com">
                                        Parolni qaytaring
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="password_com"
                                        name="password_confirmation" type="password">
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-medium mb-1" for="role">
                                        Roli
                                    </label>
                                    <select name="role" class="form-input w-full mt-1 block" id="role">
                                        <option value="admin">Admin</option>
                                        <option value="super_admin">Sepper Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>

                <div
                    class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-700/20 text-right sm:px-6 shadow-sm sm:rounded-bl-md sm:rounded-br-md">
                    <button type="submit"
                        class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white whitespace-nowrap">
                        Saqlash
                    </button>
                </div>
                </form>
            </div>
        </div>

    </div>
    </div>
</x-app-layout>
