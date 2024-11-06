<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    public function getAllRoles()
    {
        return Role::all();
    }

    public function createRole(array $data)
    {
        return Role::create($data);
    }

    public function getRoleById($id)
    {
        return Role::find($id);
    }

    public function updateRole($id, array $data)
    {
        $role = Role::find($id);

        if (!$role) {
            return null;
        }

        $role->update($data);

        return $role;
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return false;
        }

        $role->delete();

        return true;
    }
}
