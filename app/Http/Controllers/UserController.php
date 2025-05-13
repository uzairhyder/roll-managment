<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards:
            new Middleware('permission:view user',only: ['index']),
            new Middleware('permission:edit user',only: ['edit']),
            new Middleware('permission:create user',only: ['create']),
            new Middleware('permission:delete user',only: ['delete']),
        ];
    }
    //this method will show users page
    public function index(){

        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('adminpanel.users.index',get_defined_vars());
    }

    //this method will show users create page
    public function create(){
        $roles = Role::orderBy('name', 'asc')->get();
        return view('adminpanel.users.create',get_defined_vars());
    }

    //this method will show users store page
    public function store(Request $request){
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

    //this method will show users edit page
    public function edit(Request $request,$encryptedId){
        $id = Crypt::decryptString($encryptedId);
        $useredit = User::find($id);
        $roles = Role::orderBy('name', 'asc')->get();
        $hasroles = $useredit->roles->pluck('id');
        return view('adminpanel.users.edit',get_defined_vars());
    }


    //this method will show users update page
    public function update(Request $request){
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

    //this method will show users delete page
    public function destroy($encrypteddelete){
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
