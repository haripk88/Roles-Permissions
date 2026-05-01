<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Categories List') }}
            </h2>
            <div>
                <a href="{{ route('categories.create') }}" class="px-4 py-2 bg-blue-500  hover:bg-blue-700 text-white rounded-md">Add New Category</a>
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
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Description</th>
                        <th class="px-6 py-3 text-left">Created_at</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white-500">
                    @if($categories->isNotEmpty())
                    @foreach($categories as $category)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-left">{{ $category->id }}</td>
                        <td class="px-6 py-4 text-left">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-left">{{ $category->description }}</td>
                        <td class="px-6 py-4 text-left">{{ \Carbon\Carbon::parse($category->created_at)->format('d M, Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{route('categories.edit', $category->id)}}" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">Edit</a>
                            <!-- <a href="javascript:void(0)" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" onclick="deleteCategory({{ $category->id }})">Delete</a> -->
                            <button
                                class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md delete-btn"
                                data-id="{{ $category->id }}">
                                Delete
                            </button>
                        </td>
                        @endforeach
                        @else
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center">No categories found.</td>
                    </tr>
                    @endif
                    </tr>
                </tbody>
            </table>
            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');

                if (confirm('Are you sure you want to delete this category?')) {
                    $.ajax({
                        url: '/categories',
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