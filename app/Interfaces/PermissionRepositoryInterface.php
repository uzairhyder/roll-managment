<?php

namespace App\Interfaces;

interface PermissionRepositoryInterface
{
    public function getPermissions();

    //    for controller role
    public function permissions();

    public function createPermission();

    public function storePermission($request);

    public function editPermission($encryptedId);

    public function updatePermission($request);

    public function destroyPermission($encrypteddelete);


}
