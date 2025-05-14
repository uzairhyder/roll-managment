<?php

namespace App\Http\Controllers;

use App\Interfaces\PermissionRepositoryInterface;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    private PermissionRepositoryInterface $PermissionRepository;

    public function __construct(PermissionRepositoryInterface $PermissionRepository)
    {
        $this->PermissionRepository = $PermissionRepository;
    }
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

        return $this->PermissionRepository->getPermissions();


    }

    //this method will show permission create page
    public function create(){
      return $this->PermissionRepository->createPermission();
    }

    //this method will show permission store page
    public function store(Request $request){
        return $this->PermissionRepository->storePermission($request);

    }

    //this method will show permission edit page
    public function edit($encryptedId){
     return $this->PermissionRepository->editPermission($encryptedId);
    }


    //this method will show permission update page
    public function update(Request $request){
       return $this->PermissionRepository->updatePermission($request);
    }

    //this method will show permission delete page
    public function destroy($encrypteddelete){
      return $this->PermissionRepository->destroyPermission($encrypteddelete);
    }


}
