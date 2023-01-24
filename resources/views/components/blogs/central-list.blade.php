@php
    use Illuminate\Support\Str;
@endphp
<div>
   
    @if ($blogs->isEmpty())
    <div>
        <div class="flex flex-col items-center justify-center my-24">
            <p class="text-9xl">😞</p>

            @if (empty(Request::old('q')))
            <h4 class="text-md mt-12">
                Oh oh. This space is empty! I promise you you will find lots of interesting stuff here when you check later.
            </h4>
            @else
            <h4 class="text-md mt-12">
                Unfortunately I could find any story that match you search.
            </h4>
            @endif
        </div>
    </div>
    @else
    <form action="#" method="GET" class="flex flex-row justify-end items-center rounded-md overflow-clip">
        <x-text-input type="search" name="q" value="{{ Request::old('q') }}" placeholder="Search"></x-text-input>
        <x-primary-button>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </x-primary-button>
    </form>
        <div class="blogs-central-list divide-y   divide-gray-600">
            @foreach ($blogs as $blog)
            <a href="#" class="block cursor-pointer">
            <div>
                <div @class([
                    'w-full', 'h-[100px]' => !$loop->first,
                     'h-[150px]' => $loop->first,
                      'bg-cyan-800' => $loop->even, 'bg-emerald-600' => $loop->odd
                ])>
                    &nbsp;
                </div>
                
                <h4 @class(['blog-title',
                 'text-xl' => !$loop->first,
                 'text-xl2' => $loop->first])">{{ $blog->title }}</h4>

                @auth
                    <p class="blog-meta text-right italic border-b border-gray-400">
                        Created {{ $blog->diffForHumans() }}
                    </p>
                @endauth

                @guest
                <p class="blog-meta flex flex-row justify-between italic border-b border-gray-400">
                    <span>
                        Author: {{ $blog->publisher->name }}
                    </span>
                    <span>
                        Created {{ $blog->published_at->diffForHumans() }}
                    </span>
                </p>
                @endguest

                <p class="blog-body-snippet">
                    {{ Str::limit($blog->description, 120, '...') }}
                </p>
                </div>
             </a>

            @endforeach


        </div>
        
    @endif
</div>