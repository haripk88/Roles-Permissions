<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles List') }}
            </h2>
            <div>
                <a href="{{ route('roles.create') }}" class="px-4 py-2 bg-blue-500  hover:bg-blue-700 text-white rounded-md">Add New Role</a>
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
                        <th class="px-6 py-3 text-left">Permissions</th>
                        <th class="px-6 py-3 text-left">Created_at</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white-500">
                    @if($roles->isNotEmpty())
                    @foreach($roles as $role)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-left">{{ $role->id }}</td>
                        <td class="px-6 py-4 text-left" style="width:200px;">{{ $role->name }}</td>
                        <td class="px-6 py-4 text-left">
                            @foreach($role->permissions as $permission)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $permission->name }}
                            </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-left" style="width:150px;">{{ \Carbon\Carbon::parse($role->created_at)->format('d M, Y') }}</td>
                        <td class="px-6 py-4 text-center" style="width:200px;">
                            <a href="{{route('roles.edit', $role->id)}}" class="px-2 py-1 bg-blue-500 hover:bg-blue-700 text-white rounded-md">Edit</a>
                            <!-- <a href="javascript:void(0)" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" onclick="deleteRole({{ $role->id }})">Delete</a> -->
                            <button
                                class="px-2 py-1 bg-red-500 hover:bg-red-700 text-white rounded-md delete-btn"
                                data-id="{{ $role->id }}">
                                Delete
                            </button>
                        </td>
                        @endforeach
                        @else
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center">No roles found.</td>
                    </tr>
                    @endif
                    </tr>
                </tbody>
            </table>
            <div class="mt-4">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');

                if (confirm('Are you sure you want to delete this role?')) {
                    $.ajax({
                        url: '/roles',
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