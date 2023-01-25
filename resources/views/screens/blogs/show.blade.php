<x-guest-layout :fullWidth="true">
    <x-slot:title>
        {{ $blog->title }}
    </x-slot:title>
    <x-slot:header>
        <h4 class="text-2xl mb-4">
            {{ $blog->title }}
        </h4>

        <div class="text-right text-base">
            @if ($blog->publisher->is_system)
                <em>(imported)</em>
            @else
                By {{ $blog->publisher->name }}
            @endif
            <span class="mx-8">&nbsp;</span>
            published {{ $blog->published_at->format('D M dS, Y') }}  ({{ $blog->published_at->diffForHumans() }})
            
            
        </div>
    </x-slot:header>
    <div class="md:flex flex-row">
        <div class="md:w-2/3 md:pr-4">
            <div class="font-serif pt-6">
                @foreach (preg_split('/\r|\n/', $blog->description) as $line)
                    @if (empty($line))
                        @continue
                    @endif
                    <p class="mb-2">
                        {{ $line }}
                    </p>
                @endforeach
            </div>
        </div>
        <div class="md:w-1/3 bg-white text-gray-600">
            <x-blogs.sidebar-list  :excludeId="$blog->id" :blogRoute="'blogs.show'"></x-blogs.sidebar-list>
        </div>
    </div>
</x-guest-layout>
