<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between ">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Role Create') }}
            </h2>
            <a href="{{ route('roles.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('roles.store') }}" method="Post" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input type="text" class="border gray 300 shadow-sm w-1/2 rounded lg text-black"
                                    placeholder="Enter Role Name" name="name" value="{{ old('name') }}">
                            </div>
                            <div class="my-3">
                                @error('name')
                                    <span class="text-red-800">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="grid grid-col-4 mb-3">
                                @if ($permissions->isNotEmpty())
                                    <!-- Select All Checkbox -->
                                    <div class="col-span-4 mb-2">
                                        <input type="checkbox" id="select-all" class="rounded">
                                        <label for="select-all"><strong>Select All</strong></label>
                                    </div>


                                    @foreach ($permissions as $key => $permission)
                                        <div class="mt-3">
                                            <input type="checkbox" class="rounded" id="permission-{{ $permission->id }}"
                                                name="permission[]" value="{{ $permission->name }}">
                                            <label
                                                for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                @endif


                            </div>
                            <button class="bg-slate-700 text-sm rounded-md px-5 py-3" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
