<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between ">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permission List') }}
        </h2>
            @can('create permission')
            <a href="{{route('permissions.create')}}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">
                Create
            </a>
                @endcan
        </div>
    </x-slot>
{{--    ['encryptedId' => Crypt::encryptString($reservationDetail->id)]) }}--}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="w-full">
                <thead class="bg-gray-50">
                <tr class="border-b">
                    <th class="px-6 py-3 text-left" width="60">ID</th>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left" width="150">Created</th>
                    <th class="px-6 py-3 text-center" width="180">Action</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @if($permissions->isNotEmpty())
                @foreach( $permissions as $key => $permission)
                <tr class="border-b">
                    <td class="px-6 py-3 text-left">{{$permission->id}}</td>
                    <td class="px-6 py-3 text-left">{{$permission->name}}</td>
                    <td class="px-6 py-3 text-left">{{\Carbon\Carbon::parse($permission->created_at)->format('d M, Y')}}</td>
                    <td class="px-6 py-3 text-center">

                        @can('edit permission')
                        <a href="{{ route('permission.edit', ['encryptedId' => Crypt::encryptString($permission->id)]) }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600 mr-2">
                        Edit
                        </a>
                        @endcan
                            @can('delete permission')
                        <a  onclick="return confirm('Are you sure?')" href="{{route('permission.destroy',  ['encrypteddelete' => Crypt::encryptString($permission->id)])}}" class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">
                            Delete
                        </a>
                                @endcan

                    </td>
                </tr>
                @endforeach
                @endif
                </tbody>
            </table>
            <div class="my-3">
            {{ $permissions->links() }}

            </div>
        </div>
    </div>
</x-app-layout>
