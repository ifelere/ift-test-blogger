@php
    use Illuminate\Support\Arr;

    $flash_message_class_map = [
        'error' => 'bg-red-100 text-red-900',
        'danger' => 'bg-red-100 text-red-900',
        'success' => 'bg-green-100 text-green-900',
        'plain' => 'bg-white border-gray-500 text-black'
    ];
@endphp
@if (Session::has('flash_message'))
<div id="flash_container" class="clear-both absolute left-auto right-8 top-0 z-40  mr-auto m-4 px-2 py-2 rounded drop-shadow-md {{ Arr::get($flash_message_class_map, Session::get('flash_type', ''), '') }}">
    <a id="close_flash" class="ml-8 float-right hover:font-bold cursor-pointer">&times;</a>
    <span>
        {{ Session::get('flash_message') }}
    </span>
    
</div>


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var btn = document.querySelector('#close_flash');
        btn.onclick = function () {
            var container = document.querySelector('#flash_container');
            container.parentElement.removeChild(container);

        };
    });
</script>
@endpush
@endif

