@php
    use Illuminate\Support\Str;
@endphp
@unless ($blogs->isEmpty()) 
<div class="pl-4 pt-4 md:rounded-md bg-stone-400 pr-2">
    <ul class="sidebar-blog-list divide-y divide-slate-600">
        @foreach ($blogs as $blog)
            <li class="mb-2">
                <a class="block" href="#">
                    {{ Str::limit($blog->title, 70, '...') }} 
                    <em class="text-gray-700 ml-4">
                        {{ $blog->published_at->format('D, M dS, Y') }}
                    </em>
                </a>
            </li>
        @endforeach
    </ul>    
</div>
@endunless
