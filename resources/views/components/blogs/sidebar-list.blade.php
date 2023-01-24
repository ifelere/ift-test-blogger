@php
    use Illuminate\Support\Str;
@endphp
@unless ($blogs->isEmpty()) 
<div class="pl-4 pt-4 md:rounded-md bg-stone-400 pr-2">
    <ul class="sidebar-blog-list">
        @foreach ($blogs as $blog)
            <li>
                <a class="block" href="#">
                    {{ Str::limit($blog->title, 70, '...') }}
                </a>
            </li>
        @endforeach
    </ul>    
</div>
@endunless
