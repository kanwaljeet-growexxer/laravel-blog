<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="grid grid-rows-2 gap-6">
                            <div>
                                <x-label for="title" :value="__('Title')" />
                                <p>{{ $post->title }}</p>
                            </div>
                            <div>
                                <x-label for="description" :value="__('Description')" />
                                <p>{{ $post->description }}</p>
                            </div>
                            <div>
                                <x-label for="category" :value="__('Category')" />
                                <p>{{ $post->category }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center mt-4">
                        <a href="{{ url('/post/' . $post->id . '/edit') }}" class="btn btn-success btn-sm">
                            <x-button class="ml-3">
                                {{ __('Edit Post') }}
                            </x-button>
                        </a>
                        <form method="POST"
                        action="{{ url('/post' . '/' . $post->id) }}" accept-charset="UTF-8" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <x-button class="ml-3" type="submit" onclick="return confirm('Do you want to delete this post?')">
                                    {{ __('Delete Post') }}
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>