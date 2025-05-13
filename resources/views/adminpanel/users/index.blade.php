<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between ">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User List') }}
        </h2>
            @can('create user')
            <a href="{{route('users.create')}}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">
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
                    <th class="px-6 py-3 text-left">User Name</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Assign Role</th>
                    <th class="px-6 py-3 text-left" width="150">Created</th>
                    <th class="px-6 py-3 text-center" width="180">Action</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @if($users->isNotEmpty())
                @foreach( $users as $key => $user)
                <tr class="border-b">
                    <td class="px-6 py-3 text-left">{{$user->id}}</td>
                    <td class="px-6 py-3 text-left">{{$user->name}}</td>
                    <td class="px-6 py-3 text-left">{{$user->email}}</td>
                    <td class="px-6 py-3 text-left">{{$user->roles->pluck('name')->implode(', ')}}</td>
                    <td class="px-6 py-3 text-left">{{\Carbon\Carbon::parse($user->created_at)->format('d M, Y')}}</td>
                    <td class="px-6 py-3 text-center">
                        @can('edit user')
                        <a href="{{ route('users.edit', ['encryptedId' => Crypt::encryptString($user->id)]) }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600 mr-2">
                        Edit
                        </a>
                        @endcan
                            @can('delete user')
                        <a  onclick="return confirm('Are you sure?')" href="{{route('users.destroy',  ['encrypteddelete' => Crypt::encryptString($user->id)])}}" class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">
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
            {{ $users->links() }}

            </div>
        </div>
    </div>
</x-app-layout>
