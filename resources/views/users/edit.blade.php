<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit User') }}
            </h2>
            <div>
                <a href="{{ route('users.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        <!-- @method('PUT') -->
                        <div>
                            <label for="name" class="text-lg font-medium">User Name</label>
                            <div class="my-4">
                                <input type="text" value="{{ old('name', $user->name) }}" placeholder="Enter User Name" name="name" id="name" class=" border-gray-500 rounded px-3 py-3 w-1/2">
                                @error('name')
                                <p class="text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="email" class="text-lg font-medium">User Email</label>
                            <div class="my-4">
                                <input type="email" value="{{ old('email', $user->email) }}" placeholder="Enter User Email" name="email" id="email" class=" border-gray-500 rounded px-3 py-3 w-1/2">
                                @error('email')
                                <p class="text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-4 my-4">
                                @if($roles->isNotEmpty())

                                @foreach($roles as $role)
                                <div class="mt-3">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->name }}" class="mr-2" {{ $user->hasRole($role) ? 'checked' : '' }}>
                                    <label for="role_{{ $role->name }}" class="text-gray-700">{{ $role->name }}</label>
                                </div>
                                @endforeach
                                @else
                                <p>No roles available.</p>
                                @endif



                            </div>

                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>