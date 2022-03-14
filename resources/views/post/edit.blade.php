<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-validation-errors />

                    <form method="POST" action="/post/{{ $post->id }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-6">
                            <div class="grid grid-rows-2 gap-6">
                                <div>
                                    <x-label for="title" :value="__('Title')" />
                                    <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $post->title }}" autofocus />
                                </div>
                                <div>
                                    <x-label for="description" :value="__('Description')" />
                                    <x-input id="description" class="block mt-1 w-full" type="text" name="description" value="{{ $post->description }}" />
                                </div>
                                <div>
                                    <x-label for="category" :value="__('Category')" />
                                    <select name="category" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $post->category }}">
                                        <option value="IT">IT</option>
                                        <option value="Railway">Railway</option>
                                        <option value="Food">Food</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-4">
                            <x-button class="ml-3">
                                {{ __('Edit Post') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>