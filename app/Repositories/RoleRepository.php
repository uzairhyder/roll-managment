<?php

namespace App\Repositories;
use App\Interfaces\RoleRepositoryInterface;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Interfaces\PermissionRepositoryInterface;
class RoleRepository implements RoleRepositoryInterface
{
    protected $PermissionRepository;

    public function __construct(PermissionRepositoryInterface $PermissionRepository) {
        $this->PermissionRepository = $PermissionRepository;
    }
    public function getAllRoles()
    {
        $roles =  Role::orderBy('created_at', 'desc')->paginate(10);
        return view('adminpanel.roles.index',get_defined_vars());
    }
        //this function use in only userrepo
    public function Roles(){
        return $roles = Role::orderBy('name', 'asc')->get();
    }

    public function createRole(){
        $permissions = $this->PermissionRepository->permissions();
        return view('adminpanel.roles.create',get_defined_vars());
    }

    public function storeRole($request)
    {
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

    public function editRole($encryptedId){
        $id = Crypt::decryptString($encryptedId);
        $roleedit = Role::find($id);
        $haspermissions = $roleedit->permissions->pluck('name');
        $permissions =  $this->PermissionRepository->permissions();

        return view('adminpanel.roles.edit',get_defined_vars());
    }

    public function updateRole($request){
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

    public function destroyRole($encrypteddelete){
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
