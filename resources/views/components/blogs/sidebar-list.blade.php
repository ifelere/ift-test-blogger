@php
    use Illuminate\Support\Str;
@endphp
@unless ($blogs->isEmpty()) 
<div class="pl-2 pt-4">
    <div class="sidebar-blog-list flex flex-col justify-items-stretch divide-y divide-slate-600 gap-y-4 text-base">
        @foreach ($blogs as $blog)
            @php
                $route_args = Auth::check() ? ['blog' => $blog->id] : ['blog' => $blog->slug];
            @endphp
            <a data-id="{{ $blog->id }}" class="block" href="{{ route($blogRoute, $route_args) }}">
                {{ Str::limit($blog->title, 30, '...') }} 

                <em class="block text-right text-sm text-gray-700 ml-4">
                    {{ $blog->published_at->format('D, M dS, Y') }}
                </em>
            </a>
        @endforeach
        </div>    
</div>
@endunless
