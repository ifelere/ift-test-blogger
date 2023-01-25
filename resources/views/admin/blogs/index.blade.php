<x-app-layout>
    <x-slot name="header">
        <div class="text-right pr-4">
            <a class="add-blog text-white" href="{{ route('admin.blogs.create') }}">
                New Blog
            </a>
        </div>
    </x-slot>
    <div class="md:flex flex-row pt-8">
        <div class="md:w-2/3 md:pr-4 text-white">
            <x-blogs.central-list :searchRoute="'admin.blogs.index'" :showSortFields="true" :blogRoute="'admin.blogs.show'"></x-blogs.central-list>
        </div>
        <div class="md:w-1/3 bg-white text-gray-600">
            <x-blogs.sidebar-list  :blogRoute="'admin.blogs.show'"></x-blogs.sidebar-list>
        </div>
    </div>

   
</x-app-layout>
