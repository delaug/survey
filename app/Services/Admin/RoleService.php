<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Models\Role;

class RoleService
{
    /**
     * All
     *
     * @return Role[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Role::all();
    }

    /**
     * Create
     *
     * @param StoreRoleRequest $request
     * @return mixed
     */
    public function create(StoreRoleRequest $request)
    {
        return Role::create($request->validated());
    }

    /**
     * Get
     *
     * @param Role $subject
     * @return Role
     */
    public function get(Role $role)
    {
        return $role;
    }

    /**
     * Update
     *
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return mixed
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());

        $role = Role::find($role->id);
        return $role;
    }

    /**
     * Delete
     *
     * @param Role $subject
     * @return bool
     */
    public function delete(Role $role)
    {
        $role->delete();
        return true;
    }
}
