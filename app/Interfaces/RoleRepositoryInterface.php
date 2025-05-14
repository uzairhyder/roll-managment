<?php

namespace App\Interfaces;

interface RoleRepositoryInterface
{

    public function getAllRoles();

    //this intrface uses in userrepo only
    public function Roles();

    public function createRole();
    public function storeRole($request);
    public function editRole($encryptedId);
    public function updateRole($request);
    public function destroyRole($encrypteddelete);
}
