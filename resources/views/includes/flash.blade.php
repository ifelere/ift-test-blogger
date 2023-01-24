@php
    use Illuminate\Support\Arr;

    $flash_message_class_map = [
        'error' => 'bg-red-100 text-red-900',
        'danger' => 'bg-red-100 text-red-900',
        'success' => 'bg-green-100 text-green-900',
        'plain' => ''
    ];
@endphp
@if (Session::has('flash_message'))
<div class="w-full m-4 px-2 py-2 rounded drop-shadow-md {{ Arr::get($flash_message_class_map, Session::get('flash_type', ''), '') }}">
    {{ Session::get('flash_message') }}
</div>
@endif