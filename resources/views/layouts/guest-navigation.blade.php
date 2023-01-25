<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

               

               
            </div>

            <div class="flex flex-row items-center gap-x-4 text-sm justify-end">
                <x-nav-link href="{{ route('login') }}">
                    Login
                </x-nav-link>
                |
                <x-nav-link href="{{ route('register') }}">
                    Register
                </x-nav-link>
            </div>
        </div>
    </div>

</nav>
