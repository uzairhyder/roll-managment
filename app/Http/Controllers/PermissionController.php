<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards:
            new Middleware('permission:view permission',only: ['index']),
            new Middleware('permission:edit permission',only: ['edit']),
            new Middleware('permission:create permission',only: ['create']),
            new Middleware('permission:delete permission',only: ['delete']),
        ];
    }

    //this method will show permission page
    public function index(){

        $permissions = Permission::orderBy('created_at', 'desc')->paginate(10);

        return view('adminpanel.permissions.index',get_defined_vars());
    }

    //this method will show permission create page
    public function create(){
        return view('adminpanel.permissions.create');
    }

    //this method will show permission store page
    public function store(Request $request){

        $request->validate([
            'name' => 'required|unique:permissions|max:50',
        ]);
        try{
            Permission::create([
                'name'=>$request->name,
            ]);
            $notification = ['message' => 'Permission Created', 'alert-type' => 'success'];
            return redirect()->route('permissions.index')->with($notification);
        }catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => 'error'];
            return redirect()->route('permissions.create')->with($notification);
        }
    }

    //this method will show permission edit page
    public function edit(Request $request,$encryptedId){
        $id = Crypt::decryptString($encryptedId);
        $permissionedit = Permission::find($id);
        return view('adminpanel.permissions.edit',get_defined_vars());
    }


    //this method will show permission update page
    public function update(Request $request){
        $request->validate([
            'name' => 'required|unique:permissions|max:50',
        ]);
        try{
            $id = Crypt::decryptString($request->id);
                $permissionupdate = Permission::find($id);
                $permissionupdate->name = $request->name;
            $permissionupdate->save();
            $notification = ['message' => 'Permission Updated', 'alert-type' => 'success'];
            return redirect()->route('permissions.index')->with($notification);
        }catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => 'error'];
            return redirect()->route('permissions.index')->with($notification);
        }
    }

    //this method will show permission delete page
    public function destroy($encrypteddelete){
        try {
            $id = Crypt::decryptString($encrypteddelete);
            $permissiondelete = Permission::find($id);
            $permissiondelete->delete();
            $notification = ['message' => 'Permission Deleted', 'alert-type' => 'success'];
            return redirect()->route('permissions.index')->with($notification);
        }catch (\Exception $e) {
            $notification = ['message' => $e->getMessage(), 'alert-type' => 'error'];
            return redirect()->route('permissions.index')->with($notification);
        }
    }
}
