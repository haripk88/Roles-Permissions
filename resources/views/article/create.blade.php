<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Article') }}
            </h2>
            <div>
                <a href="{{ route('articles.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Back</a>
            </div>
        </div>

        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Permission') }}
        </h2> -->
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('articles.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="title" class="text-lg font-medium">Article Title</label>
                            <div class="my-4">
                                <input type="text" value="{{ old('title') }}" placeholder="Enter Article Title" name="title" id="title" class=" border-gray-500 rounded px-3 py-3 w-1/2">
                                @error('title')
                                <p class="text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="content" class="text-lg font-medium">Article Content</label>
                            <div class="my-4">
                                <textarea name="content" id="content" placeholder="Enter Article Content" class="border-gray-500 rounded px-3 py-3 w-1/2" cols="30" rows="10">{{ old('content') }}</textarea>
                                @error('content')
                                <p class="text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="author" class="text-lg font-medium">Author</label>
                            <div class="my-4">
                                <input type="text" value="{{ old('author') }}" placeholder="Enter Author Name" name="author" id="author" class=" border-gray-500 rounded px-3 py-3 w-1/2">
                                @error('author')
                                <p class="text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>


                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>