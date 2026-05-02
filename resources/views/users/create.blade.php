<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create User') }}
            </h2>
            <div>
                <a href="{{ route('users.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Back</a>
            </div>
        </div>

        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create role') }}
        </h2> -->
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="name" class="text-lg font-medium">User Name</label>
                            <div class="my-4">
                                <input type="text" value="{{ old('name') }}" placeholder="Enter User Name" name="name" id="name" class=" border-gray-500 rounded px-3 py-3 w-1/2">
                                @error('name')
                                <p class="text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="email" class="text-lg font-medium">User Email</label>
                            <div class="my-4">
                                <input type="email" value="{{ old('email') }}" placeholder="Enter User Email" name="email" id="email" class=" border-gray-500 rounded px-3 py-3 w-1/2">
                                @error('email')
                                <p class="text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="password" class="text-lg font-medium">Password</label>
                            <div class="my-4">
                                <input type="password" value="{{ old('password') }}" placeholder="Enter password" name="password" id="password" class=" border-gray-500 rounded px-3 py-3 w-1/2">
                                @error('password')
                                <p class="text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="password_confirmation" class="text-lg font-medium">Confirm Password</label>
                            <div class="my-4">
                                <input type="password" value="{{ old('password_confirmation') }}" placeholder="Confirm password" name="password_confirmation" id="password_confirmation" class=" border-gray-500 rounded px-3 py-3 w-1/2">
                                @error('password_confirmation')
                                <p class="text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-4 my-4">
                                @if($roles->isNotEmpty())

                                @foreach($roles as $role)
                                <div class="mt-3">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->name }}" class="mr-2">
                                    <label for="role_{{ $role->name }}" class="text-gray-700">{{ $role->name }}</label>
                                </div>
                                @endforeach
                                @else
                                <p>No roles available.</p>
                                @endif
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