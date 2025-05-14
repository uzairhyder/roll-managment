<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function createUser();
    public function editUser($encryptedId);
    public function storeUser($request);
    public function updateUser($request);
    public function destroyUser($encrypteddelete);
}
