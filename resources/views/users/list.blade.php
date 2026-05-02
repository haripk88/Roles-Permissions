<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users List') }}
            </h2>
            <div>
                <a href="{{ route('users.create') }}" class="px-4 py-2 bg-blue-500  hover:bg-blue-700 text-white rounded-md">Add New User</a>
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
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Roles</th>
                        <th class="px-6 py-3 text-left">Created_at</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white-500">
                    @if($users->isNotEmpty())
                    @foreach($users as $user)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-left">{{ $user->id }}</td>
                        <td class="px-6 py-4 text-left">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-left">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-left">
                            @foreach($user->roles as $role)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $role->name }}
                            </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-left">{{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{route('users.edit', $user->id)}}" class="px-2 py-1 bg-blue-500 hover:bg-blue-700 text-white rounded-md">Edit</a>
                            <button
                                class="px-2 py-1 bg-red-500 hover:bg-red-700 text-white rounded-md delete-btn"
                                data-id="{{ $user->id }}">
                                Delete
                            </button>
                        </td>
                        @endforeach
                        @else
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center">No users found.</td>
                    </tr>
                    @endif
                    </tr>
                </tbody>
            </table>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');

                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        url: '/users',
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