<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards:
            new Middleware('permission:view role',only: ['index']),
            new Middleware('permission:edit role',only: ['edit']),
            new Middleware('permission:create role',only: ['create']),
            new Middleware('permission:delete role',only: ['delete']),
        ];
    }

    //this method will show role page
    public function index(){

        $roles = Role::orderBy('created_at', 'desc')->paginate(10);

        return view('adminpanel.roles.index',get_defined_vars());
    }

    //this method will show role create page
    public function create(){
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('adminpanel.roles.create',get_defined_vars());
    }

    //this method will show role store page
    public function store(Request $request){
        $request->validate([
            'name' => 'required|unique:roles|max:50',
        ]);
        try{
          $role =  Role::create([
                'name'=>$request->name,
            ]);

            if(!empty($request->permission)){
                foreach($request->permission as $permission){
                        $role->givePermissionTo($permission);
                }
            }
            $notification = ['message' => 'Role Created', 'alert-type' => 'success'];
            return redirect()->route('roles.index')->with($notification);
        }catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => 'error'];
            return redirect()->route('roles.create')->with($notification);
        }
    }

    //this method will show role edit page
    public function edit(Request $request,$encryptedId){
        $id = Crypt::decryptString($encryptedId);
        $roleedit = Role::find($id);
        $haspermissions = $roleedit->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('adminpanel.roles.edit',get_defined_vars());
    }


    //this method will show role update page
    public function update(Request $request){

        try{
            $id = Crypt::decryptString($request->id);
            $request->validate([
                'name' => 'required|max:50|unique:roles,name,'.$id.',id',
            ]);
            $roleupdate = Role::find($id);
            $roleupdate->name = $request->name;
            $roleupdate->save();
            if(!empty($request->permission)){
                    $roleupdate->syncPermissions($request->permission);
            }
            else{
                $roleupdate->syncPermissions([]);
            }
            $notification = ['message' => 'Role Updated', 'alert-type' => 'success'];
            return redirect()->route('roles.index')->with($notification);
        }catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => 'error'];
            return redirect()->route('roles.index')->with($notification);
        }
    }

    //this method will show role delete page
    public function destroy($encrypteddelete){
        try {
            $id = Crypt::decryptString($encrypteddelete);
            $roledelete = Role::find($id);
            $roledelete->delete();
            if(!empty($roledelete->permissions)){
                $roledelete->syncPermissions([]);
            }
            $notification = ['message' => 'Role Deleted', 'alert-type' => 'success'];
            return redirect()->route('roles.index')->with($notification);
        }catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => 'error'];
            return redirect()->route('roles.index')->with($notification);
        }
    }
}
