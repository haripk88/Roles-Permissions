<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Article List') }}
            </h2>
            <div>
                <a href="{{ route('articles.create') }}" class="px-4 py-2 bg-blue-500  hover:bg-blue-700 text-white rounded-md">Add New Article</a>
            </div>

        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Title</th>
                        <th class="px-6 py-3 text-left">Content</th>
                        <th class="px-6 py-3 text-left">Author</th>
                        <th class="px-6 py-3 text-left">Created_at</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white-500">
                    @if($articles->isNotEmpty())
                    @foreach($articles as $article )
                    <tr class="border-b">
                        <td class="px-6 py-4 text-left">{{ $article->id }}</td>
                        <td class="px-6 py-4 text-left" style="width:150px;">{{ $article->title }}</td>
                        <td class="px-6 py-4 text-left">{{ Str::limit($article->content, 100) }}</td>
                        <td class="px-6 py-4 text-left" style="width:150px;">{{ $article->author }}</td>
                        <td class="px-6 py-4 text-left" style="width:150px;">{{ \Carbon\Carbon::parse($article->created_at)->format('d M, Y') }}</td>
                        <td class="px-6 py-4 text-center" style="width:200px;">
                            <a href="{{route('articles.edit', $article->id)}}" class="px-4 py-1 bg-blue-500 hover:bg-blue-700 text-white rounded-md">Edit</a>
                            <!-- <a href="javascript:void(0)" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" onclick="deleteArticle({{ $article->id }})">Delete</a> -->
                            <button
                                class="px-2 py-1 bg-red-500 hover:bg-red-700 text-white rounded-md delete-btn"
                                data-id="{{ $article->id }}">
                                Delete
                            </button>
                        </td>
                        @endforeach
                        @else
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center">No articles found.</td>
                    </tr>
                    @endif
                    </tr>
                </tbody>
            </table>
            <div class="mt-4">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');

                if (confirm('Are you sure you want to delete this article?')) {
                    $.ajax({
                        url: '/articles',
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            'id': id
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            window.location.reload();
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        </script>
    </x-slot>
</x-app-layout>