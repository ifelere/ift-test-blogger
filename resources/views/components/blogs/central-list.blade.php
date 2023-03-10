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
        <x-search-form :url="route($searchRoute)"></x-search-form>
        <form id="sort_form" action="{{ route($searchRoute) }}" class="mt-4 flex flex-row justify-end">
            <select id="ctrl_sort" name="sort" class="text-black">
                @foreach (['date desc' => 'Show latest blog first', 'date asc' => 'Show ealiest blog firist'] as $sort_expression => $text)
                    <option value="{{ $sort_expression }}" @selected(Request::get('sort', 'date desc') == $sort_expression)>
                        {{ $text }}
                    </option>
                @endforeach
            </select>

            @push('scripts')
                <script>
                    window.addEventListener('load', function () {
                        document.getElementById('ctrl_sort').onchange = function (e) {
                            if (e.currentTarget.value) {
                                document.getElementById('sort_form').submit();
                            }
                        };
                    });
                </script>
            @endpush
        </form>
        <div class="mt-4">
            @foreach ($blogs as $blog)
            @php
                $route_args = Auth::check() ? ['blog' => $blog->id] : ['blog' => $blog->slug];
            @endphp
            <a href="{{ route($blogRoute, $route_args) }}" data-id="{{ $blog->id }}" class="block cursor-pointer mb-16">
            <div>
                <div @class([
                    'w-full', 'h-[100px]' => !$loop->first,
                     'h-[150px]' => $loop->first,
                      'bg-cyan-800' => $loop->even, 'bg-emerald-600' => $loop->odd
                ])>
                    &nbsp;
                </div>
                
                <h4 @class([
                    'blog-title',
                    'text-xl' => !$loop->first,
                    'text-xl2' => $loop->first
                    ])">{{ $blog->title }}</h4>

                @auth
                    <p class="blog-meta text-right italic border-b border-gray-400">
                        Published {{ $blog->published_at->diffForHumans() }}
                    </p>
                @endauth

                @guest
                <div class="blog-meta flex flex-row justify-between italic border-b border-gray-400">
                    @if ($blog->publisher->is_system)
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                      </svg>
                      
                    @else
                        <span>
                            Author: {{ $blog->publisher->name }}
                        </span>
                    @endif
                    
                    <span>
                        Published {{ $blog->published_at->diffForHumans() }}
                    </span>
                </div>
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