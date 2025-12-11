<div class="min-w-fit">
    <!-- Sidebar backdrop (mobile only) -->
    <div class="fixed inset-0 bg-gray-900/30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="flex lg:flex! flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-[100dvh] overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:w-64! shrink-0 bg-white dark:bg-gray-800 p-4 transition-all duration-200 ease-in-out {{ $variant === 'v2' ? 'border-r border-gray-200 dark:border-gray-700/60' : 'rounded-r-2xl shadow-xs' }}"
        :class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false">

        <!-- Sidebar header -->
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-gray-500 hover:text-gray-400" @click.stop="sidebarOpen = !sidebarOpen"
                aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="block" href="{{ route('dashboard') }}">
                <svg class="fill-violet-500" xmlns="http://www.w3.org/2000/svg" width="32" height="32">
                    <path
                        d="M31.956 14.8C31.372 6.92 25.08.628 17.2.044V5.76a9.04 9.04 0 0 0 9.04 9.04h5.716ZM14.8 26.24v5.716C6.92 31.372.63 25.08.044 17.2H5.76a9.04 9.04 0 0 1 9.04 9.04Zm11.44-9.04h5.716c-.584 7.88-6.876 14.172-14.756 14.756V26.24a9.04 9.04 0 0 1 9.04-9.04ZM.044 14.8C.63 6.92 6.92.628 14.8.044V5.76a9.04 9.04 0 0 1-9.04 9.04H.044Z" />
                </svg>
            </a>
        </div>

        <!-- Links -->

        <div class="space-y-8">
            <!-- Pages group -->
            <div>
                <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Pages</span>
                </h3>
                <ul class="mt-3">

                    {{-- Asosiy --}}
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition"
                            href="{{ route('dashboard') }}">
                            <div class="flex items-center">
                                {{-- Dashboard icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 12h7V3H3v9Zm0 9h7v-7H3v7Zm11 0h7v-9h-7v9ZM14 3v5h7V3h-7Z" />
                                </svg>

                                <span class="text-sm font-medium ml-4">Asosiy</span>
                            </div>
                        </a>
                    </li>

                    {{-- Barcha talabalar --}}
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition"
                            href="{{ route('students.index') }}">
                            <div class="flex items-center">
                                {{-- Users icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M17 20v-2a4 4 0 0 0-3-3.87M7 20v-2a4 4 0 0 1 3-3.87m3 0A4 4 0 1 0 8 9m6 1a4 4 0 1 1 8 0" />
                                </svg>

                                <span class="text-sm font-medium ml-4">Barcha talabalar</span>
                            </div>
                        </a>
                    </li>

                    {{-- Yotoqxona --}}
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition"
                            href="{{ route('students.dormitory') }}">
                            <div class="flex items-center">
                                {{-- Building / Home icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 10.5 12 3l9 7.5V21H3V10.5Z" />
                                    <path d="M9 21V12h6v9" />
                                </svg>

                                <span class="text-sm font-medium ml-4">Yotoqxona</span>
                            </div>
                        </a>
                    </li>

                    {{-- Ijara --}}
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition"
                            href="{{ route('students.rent') }}">
                            <div class="flex items-center">
                                {{-- Key icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M15 7a5 5 0 1 0-4 9l-2 2v3h3v-2l2-2a5 5 0 0 0 1-10Z" />
                                </svg>

                                <span class="text-sm font-medium ml-4">Barcha ijaradagi talabalr</span>
                            </div>
                        </a>
                    </li>

                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition"
                            href="{{ route('students.rent', ['type' => 'owner']) }}">
                            <div class="flex items-center">
                                {{-- Key icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M15 7a5 5 0 1 0-4 9l-2 2v3h3v-2l2-2a5 5 0 0 0 1-10Z" />
                                </svg>

                                <span class="text-sm font-medium ml-4">O'z uyidagi</span>
                            </div>
                        </a>
                    </li>

                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition"
                            href="{{ route('students.rent', ['type' => 'relative']) }}">
                            <div class="flex items-center">
                                {{-- Key icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M15 7a5 5 0 1 0-4 9l-2 2v3h3v-2l2-2a5 5 0 0 0 1-10Z" />
                                </svg>

                                <span class="text-sm font-medium ml-4">Qarindoshinikida</span>
                            </div>
                        </a>
                    </li>

                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition"
                            href="{{ route('students.rent', ['type' => 'rent']) }}">
                            <div class="flex items-center">
                                {{-- Key icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M15 7a5 5 0 1 0-4 9l-2 2v3h3v-2l2-2a5 5 0 0 0 1-10Z" />
                                </svg>

                                <span class="text-sm font-medium ml-4">Begonanikida</span>
                            </div>
                        </a>
                    </li>

                    {{-- Adminlar --}}
                    @auth
                        @if (Auth::user()->role == 'super_admin')
                            <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0">
                                <a class="block text-gray-800 dark:text-gray-100 truncate transition"
                                    href="{{ route('students.forgets') }}">
                                    <div class="flex items-center">
                                        {{-- Key icon --}}
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path d="M15 7a5 5 0 1 0-4 9l-2 2v3h3v-2l2-2a5 5 0 0 0 1-10Z" />
                                        </svg>

                                        <span class="text-sm font-medium ml-4">Parolni unutganlar</span>
                                    </div>
                                </a>
                            </li>
                            <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0">
                                <a class="block text-gray-800 dark:text-gray-100 truncate transition"
                                    href="{{ route('users.index') }}">
                                    <div class="flex items-center">
                                        {{-- Shield / Users Cog --}}
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path d="M12 3l7 4v5c0 5-3.5 9-7 9s-7-4-7-9V7l7-4Z" />
                                            <path d="M15 11a3 3 0 1 1-6 0" />
                                        </svg>

                                        <span class="text-sm font-medium ml-4">Adminlar</span>
                                    </div>
                                </a>
                            </li>
                        @endif
                    @endauth

                </ul>

            </div>
        </div>

        <!-- Expand / collapse button -->
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="w-12 pl-4 pr-3 py-2">
                <button
                    class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors"
                    @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500 sidebar-expanded:rotate-180"
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path
                            d="M15 16a1 1 0 0 1-1-1V1a1 1 0 1 1 2 0v14a1 1 0 0 1-1 1ZM8.586 7H1a1 1 0 1 0 0 2h7.586l-2.793 2.793a1 1 0 1 0 1.414 1.414l4.5-4.5A.997.997 0 0 0 12 8.01M11.924 7.617a.997.997 0 0 0-.217-.324l-4.5-4.5a1 1 0 0 0-1.414 1.414L8.586 7M12 7.99a.996.996 0 0 0-.076-.373Z" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>
