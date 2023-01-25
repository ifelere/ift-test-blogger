@props(['url' => '#', 'variable' => 'q'])
<form action="{{ $url }}" method="GET" class="bg-slate-900 flex flex-row items-center justify-end rounded-md overflow-hidden shadow-sm">
    {{ $slot }}
    <input type="search" name="{{ $variable  }}" value="{{ Request::get($variable) }}" 
        class="flex-grow border-gray-300 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-60" />
        <button class="border-none px-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </button>
</form>