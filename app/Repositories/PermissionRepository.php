<?php

namespace App\Repositories;


use App\Interfaces\PermissionRepositoryInterface;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface {
        public function getPermissions(){
            $permissions = Permission::orderBy('created_at', 'desc')->paginate(10);
            return view('adminpanel.permissions.index',get_defined_vars());
        }
        public function permissions(){
            return Permission::orderBy('name', 'asc')->get();
        }

        public function createPermission()
        {
            return view('adminpanel.permissions.create');
        }
        public function storePermission($request){
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

        public function editPermission($encryptedId){
            $id = Crypt::decryptString($encryptedId);
            $permissionedit = Permission::find($id);
            return view('adminpanel.permissions.edit',get_defined_vars());
        }

        public function updatePermission($request){
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
                public function destroyPermission($encrypteddelete){
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
