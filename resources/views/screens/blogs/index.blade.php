<x-guest-layout>
    <div class="md:flex flex-row dark:text-white">
        <div class="md:w-2/3 md:pr-4">
            <x-blogs.central-list :searchRoute="'blogs.index'" :blogRoute="'blogs.show'"></x-blogs.central-list>
        </div>
        <div class="md:w-1/3 bg-white text-gray-600">
            <x-blogs.sidebar-list  :blogRoute="'blogs.show'"></x-blogs.sidebar-list>
        </div>
    </div>

   
</x-guest-layout>
