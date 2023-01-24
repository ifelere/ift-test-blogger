<x-app-layout>
    <x-slot:title>
        New Blog
    </x-slot>
    <div class="md:flex flex-row dark:text-white">
        <div class="md:w-2/3 md:pr-4">
            <form method="POST" action="{{ route('admin.blogs.store') }}">
                @csrf
                <div class="mb-4">
                    <x-input-label for="title">
                        Title of Blug
                    </x-input-label>
                    <x-text-input name="title" :value="old("title")" @class([
                        'error' => $errors->has('title'),
                    ])></x-text-input>
                    @if ($errors->has('title'))
                        <x-input-error :messages="$errors->all('title')"></x-input-error>
                    @endif
                </div>

                <div class="mb-4">
                    <x-textarea name="description" placeholder="Content of Blog" :value="old("description")" @class([
                        'error' => $errors->has('description'),
                    ])></x-textarea>
                    @if ($errors->has('description'))
                        <x-input-error :messages="$errors->all('description')"></x-input-error>
                    @endif
                </div>


                <div class="flex flex-row justify-end items-center py-2 pr-4">
                    <x-nav-link href="{{ route('admin.blogs.index') }}">
                        Cancel
                    </x-nav-link>
                    <x-primary-button type="submit">
                        Save
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div class="md:w-1/3 bg-white text-gray-600">
            <x-blogs.sidebar-list  :blogRoute="'admin.blogs.show'"></x-blogs.sidebar-list>
        </div>
    </div>
</x-app-layout>
