<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between ">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('User Edit') }}
            </h2>
            <a href="{{route('users.index')}}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">
                Back
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('users.update')}}" method="Post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ Crypt::encryptString($useredit->id) }}">
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input type="text" class="border gray 300 shadow-sm w-1/2 rounded lg text-black" placeholder="Enter User Name" name="name"
                                       value="{{old('name',$useredit->name)}}">
                            </div>
                            <div  class="my-3">
                                @error('name')
                                <span class="text-red-800">{{ $message }}</span>
                                @enderror
                            </div>

                                <label for="" class="text-lg font-medium">Email</label>
                                <div class="my-3">
                                    <input type="text" class="border gray 300 shadow-sm w-1/2 rounded lg text-black" placeholder="Enter User Email" name="email"
                                           value="{{old('email',$useredit->email)}}">
                                </div>
                                <div  class="my-3">
                                    @error('email')
                                    <span class="text-red-800">{{ $message }}</span>
                                    @enderror
                                </div>


                                    <label for="" class="text-lg font-medium">Password</label>
                                    <div class="my-3">
                                        <input type="text" class="border gray 300 shadow-sm w-1/2 rounded lg text-black" placeholder="Enter User Password" name="password"
                                               value="{{old('password')}}">
                                    </div>
                                    <div  class="my-3">
                                        @error('password')
                                        <span class="text-red-800">{{ $message }}</span>
                                        @enderror
                                    </div>



                            <div class="grid grid-col-4 mb-3">
                                @if($roles->isNotEmpty())
                                    @foreach($roles as $key => $role)
                                        <div class="mt-3">
{{--                                            {{($hasroles->contains($permission->name)) ? 'checked':''}}--}}
                                            <input  {{($hasroles->contains($role->id)) ? 'checked':''}}  type="checkbox" class="rounded" id="role-{{$role->id}}" name="role[]" value="{{$role->name}}">
                                            <label for="role-{{$role->id}}">{{$role->name}}</label>
                                        </div>
                                    @endforeach
                                @endif


                            </div>

                            <button class="bg-slate-700 text-sm rounded-md px-5 py-3" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
