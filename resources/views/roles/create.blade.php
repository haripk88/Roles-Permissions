<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Role') }}
            </h2>
            <div>
                <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Back</a>
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
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="name" class="text-lg font-medium">Role Name</label>
                            <div class="my-4">
                                <input type="text" value="{{ old('name') }}" placeholder="Enter Role Name" name="name" id="name" class=" border-gray-500 rounded px-3 py-3 w-1/2">
                                @error('name')
                                <p class="text-red-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-4 my-4">
                                @if($permissions->isNotEmpty())

                                @foreach($permissions as $permission)
                                <div class="mt-3">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->name }}" class="mr-2">
                                    <label for="permission_{{ $permission->name }}" class="text-gray-700">{{ $permission->name }}</label>
                                </div>
                                @endforeach
                                @else
                                <p>No permissions available.</p>
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