<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\RoleRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserRepository implements UserRepositoryInterface
{
    protected $RoleRepository;

    public function __construct(RoleRepositoryInterface $RoleRepository) {
        $this->RoleRepository = $RoleRepository;
    }

    public function getAllUsers()
    {
        $users =  User::orderBy('created_at', 'desc')->paginate(10);
        return view('adminpanel.users.index',get_defined_vars());
    }

    public function createUser(){
        $roles = $this->RoleRepository->Roles();
        return view('adminpanel.users.create',get_defined_vars());
    }

    public function editUser($encryptedId){
        $id = Crypt::decryptString($encryptedId);
        $useredit = User::find($id);
        $roles = $this->RoleRepository->Roles();
        $hasroles = $useredit->roles->pluck('id');

        return view('adminpanel.users.edit', get_defined_vars());
    }

    public function storeUser($request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
        ]);
        try{
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);
            $user->syncRoles($request->role);
            $notification = ['message' => 'User Created', 'alert-type' => 'success'];
            return redirect()->route('users.index')->with($notification);
        }catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => 'error'];
            return redirect()->route('users.create')->with($notification);
        }
    }

    public function updateUser($request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try{
            $id = Crypt::decryptString($request->id);
            $userupdate = User::find($id);
            $userupdate->name = $request->name;
            $userupdate->email = $request->email;
            $userupdate->password = Hash::make($request->password);
            $userupdate->save();
            $userupdate->syncRoles($request->role);
            $notification = ['message' => 'User Updated', 'alert-type' => 'success'];
            return redirect()->route('users.index')->with($notification);
        }catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => 'error'];
            return redirect()->route('users.edit')->with($notification);
        }
    }
    public function destroyUser($encrypteddelete)
    {
        try {
            $id = Crypt::decryptString($encrypteddelete);
            $userdelete = User::find($id);
            $userdelete->delete();
            $notification = ['message' => 'User Deleted', 'alert-type' => 'success'];
            return redirect()->route('users.index')->with($notification);
        }catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => 'error'];
            return redirect()->route('users.edit')->with($notification);
        }
    }

}
