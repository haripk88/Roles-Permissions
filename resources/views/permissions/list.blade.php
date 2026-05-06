<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permissions List') }}
            </h2>
            <div>
                <a href="{{ route('permissions.create') }}" class="px-4 py-2 bg-blue-500  hover:bg-blue-700 text-white rounded-md">Add New Permission</a>
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
                        <th class="px-6 py-3 text-left">Created_at</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white-500">
                    @if($permissions->isNotEmpty())
                    @foreach($permissions as $permission)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-left">{{ $permission->id }}</td>
                        <td class="px-6 py-4 text-left">{{ $permission->display_name }}</td>
                        <td class="px-6 py-4 text-left">{{ \Carbon\Carbon::parse($permission->created_at)->format('d M, Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <!-- <a href="{{route('permissions.edit', $permission->id)}}" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">Edit</a> -->
                            <!-- <a href="javascript:void(0)" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" onclick="deletePermission({{ $permission->id }})">Delete</a> -->
                            <button
                                class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md delete-btn"
                                data-id="{{ $permission->id }}">
                                Delete
                            </button>
                        </td>
                        @endforeach
                        @else
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center">No permissions found.</td>
                    </tr>
                    @endif
                    </tr>
                </tbody>
            </table>
            <div class="mt-4">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');

                if (confirm('Are you sure you want to delete this permission?')) {
                    $.ajax({
                        url: '/permissions',
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
        <!-- <script type="text/javascript">
            function deletePermission(id) {
                if (confirm('Are you sure you want to delete this permission?')) {
                    $.ajax({
                        url: '{{ route("permissions.destroy")}}',
                        type: 'delete',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            window.location.href = '{{ route("permissions.index")}}';
                        },
                        error: function(xhr) {
                            window.location.href = '{{ route("permissions.index")}}';
                        }
                    })
                }
            }
        </script> -->
    </x-slot>
</x-app-layout>