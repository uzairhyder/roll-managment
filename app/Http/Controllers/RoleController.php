<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Interfaces\RoleRepositoryInterface;

class RoleController extends Controller implements HasMiddleware
{

    private RoleRepositoryInterface $RoleRepository;

    public function __construct(RoleRepositoryInterface $RoleRepository)
    {
        $this->RoleRepository = $RoleRepository;
    }

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

        return  $this->RoleRepository->getAllRoles();

    }

    //this method will show role create page
    public function create(){
        return  $this->RoleRepository->createRole();

    }

    //this method will show role store page
    public function store(Request $request){

        return $this->RoleRepository->storeRole($request);

    }

    //this method will show role edit page
    public function edit(Request $request,$encryptedId){
         return $this->RoleRepository->editRole($encryptedId);

    }


    //this method will show role update page
    public function update(Request $request){

       return $this->RoleRepository->updateRole($request);
    }

    //this method will show role delete page
    public function destroy($encrypteddelete){
       return $this->RoleRepository->destroyRole($encrypteddelete);
    }
}
