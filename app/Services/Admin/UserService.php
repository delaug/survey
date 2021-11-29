<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;

class UserService
{
    /**
     * All
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return User::with(['roles'])->get();
    }

    /**
     * Create
     *
     * @param StoreUserRequest $request
     * @return mixed
     */
    public function create(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        // Extract roles
        $role_ids = $data['role_ids'];
        unset($data['role_ids']);

        $user = User::create($data);

        // Attaching role to user
        if($user)
            $user->roles()->sync($role_ids);

        return User::with(['roles'])->find($user->id);
    }

    /**
     * Get
     *
     * @param User $subject
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function get(User $subject)
    {
        return User::with(['roles'])->find($subject->id);
    }

    /**
     * Update
     *
     * @param UpdateUserRequest $request
     * @param User $subject
     * @return mixed
     */
    public function update(UpdateUserRequest $request, User $subject)
    {
        $data = $request->validated();

        if(!empty($data['password'] ))
            $data['password'] = bcrypt($data['password']);

        $role_ids = [];

        // Extract roles
        if(!empty($data['role_ids'])) {
            $role_ids = $data['role_ids'];
            unset($data['role_ids']);
        }

        $subject->update($data);

        // Attaching role to user
        if($subject && $role_ids)
            $subject->roles()->sync($role_ids);

        return User::with(['roles'])->find($subject->id);
    }

    /**
     * Delete
     *
     * @param User $subject
     * @return bool
     */
    public function delete(User $subject)
    {
        $subject->delete();
        return true;
    }
}
