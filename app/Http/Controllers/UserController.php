<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Interfaces\UserRepositoryInterface;

class UserController extends Controller implements HasMiddleware
{

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
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

       return $this->userRepository->getAllUsers();

    }

    //this method will show users create page
    public function create(){

    return $this->userRepository->createUser();

    }

    //this method will show users store page
    public function store(Request $request){
        return $this->userRepository->storeUser($request);
    }

    //this method will show users edit page
    public function edit(Request $request,$encryptedId){
        return $this->userRepository->editUser($encryptedId);
    }


    //this method will show users update page
    public function update(Request $request){
        return $this->userRepository->updateUser($request);
    }

    //this method will show users delete page
    public function destroy($encrypteddelete){
        return $this->userRepository->destroyUser($encrypteddelete);
    }
}
