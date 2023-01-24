<x-app-layout>
    <x-slot name="header">
        <x-blogs.stats></x-blogs.stats>
        <div class="text-right pr-4">
            <a class="add-blog" href="{{ route('admin.blogs.create') }}">
                New Blog
            </a>
        </div>
    </x-slot>
    <div class="md:flex flex-row dark:text-white">
        <div class="md:w-2/3 md:pr-4">
            <x-blogs.central-list :searchRoute="'admin.blogs.index'" :blogRoute="'admin.blogs.show'"></x-blogs.central-list>
        </div>
        <div class="md:w-1/3 bg-white text-gray-600">
            <x-blogs.sidebar-list  :blogRoute="'admin.blogs.show'"></x-blogs.sidebar-list>
        </div>
    </div>
</x-app-layout>
