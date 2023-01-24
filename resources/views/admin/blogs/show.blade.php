<x-app-layout>
    <x-slot:header>
        {{ $blog->title }}
    </x-slot:header>
    <div class="md:flex flex-row dark:text-white">
        <div class="md:w-2/3 md:pr-4">
            <div class="font-serif">
                @foreach (preg_split(/\r|\n/, $blog->description) as $line)
                    @if (empty($line))
                        @continue
                    @endif
                    <p>
                        {{ $line }}
                    </p>
                @endforeach
            </div>
        </div>
        <div class="md:w-1/3 bg-white text-gray-600">
            <x-blogs.sidebar-list :excludeId="$blog->id" :blogRoute="'admin.blogs.show'"></x-blogs.sidebar-list>
        </div>
    </div>
</x-app-layout>
