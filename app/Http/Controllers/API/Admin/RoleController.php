<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Http\Services\Admin\RoleService;
use App\Models\Role;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $roles = RoleService::all();
        return response()->json(['status' => Response::HTTP_OK, 'data' => $roles], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRoleRequest $request)
    {
        $role = RoleService::create($request);
        return response()->json(['status' => Response::HTTP_OK, 'data' => $role], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        $role = RoleService::get($role);
        return response()->json(['status' => Response::HTTP_OK, 'data' => $role], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleRequest $request
     * @param  Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role = RoleService::update($request, $role);
        return response()->json(['status' => Response::HTTP_OK, 'data' => $role], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        RoleService::delete($role);
        return response()->json(['status' => Response::HTTP_OK, 'message' => 'Role was deleted!'], Response::HTTP_OK);
    }
}
