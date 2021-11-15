<?php

namespace App\Http\Services\Admin;

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
    public static function all()
    {
        return User::all();
    }

    /**
     * Create
     *
     * @param StoreUserRequest $request
     * @return mixed
     */
    public static function create(StoreUserRequest $request)
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

        return User::find($user->id);
    }

    /**
     * Get
     *
     * @param User $subject
     * @return User
     */
    public static function get(User $subject)
    {
        return $subject;
    }

    /**
     * Update
     *
     * @param UpdateUserRequest $request
     * @param User $subject
     * @return mixed
     */
    public static function update(UpdateUserRequest $request, User $subject)
    {
        $data = $request->validated();
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

        return User::find($subject->id);
    }

    /**
     * Delete
     *
     * @param User $subject
     * @return bool
     */
    public static function delete(User $subject)
    {
        $subject->delete();
        return true;
    }
}
