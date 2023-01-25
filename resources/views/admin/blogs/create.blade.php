<x-app-layout>
    <x-slot:title>
        New Blog
    </x-slot:title>
    <div class="md:flex flex-row dark:text-white  pt-12">
        <div class="md:w-2/3 md:pr-4">
            <form method="POST" action="{{ route('admin.blogs.store') }}">
                @csrf
                <div class="mb-4">
                    
                    <x-text-input autofocus name="title" placeholder="Title of Blog" :value="old('title')" @class([
                        'error' => $errors->has('title'),
                        'block', 'w-full'

                    ])></x-text-input>
                    @if ($errors->has('title'))
                        <x-input-error :messages="$errors->all('title')"></x-input-error>
                    @endif
                </div>

                <div class="mb-4">
                    <x-textarea :rows="10" :cols="20" name="description"  placeholder="Content of Blog" :value="old('description')" @class([
                        'error' => $errors->has('description'),
                        'block', 'w-full'
                    ])></x-textarea>
                    @if ($errors->has('description'))
                        <x-input-error :messages="$errors->all('description')"></x-input-error>
                    @endif
                </div>


                <div class="flex flex-row gap-8 justify-end items-center py-2 pr-4">
                    <x-nav-link href="{{ route('admin.blogs.index') }}">
                        Cancel
                    </x-nav-link>
                    <x-primary-button type="submit">
                        Save
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div class="md:w-1/3 bg-white text-gray-600 pt-8">
            <x-blogs.sidebar-list  :blogRoute="'admin.blogs.show'"></x-blogs.sidebar-list>
        </div>
    </div>
</x-app-layout>
