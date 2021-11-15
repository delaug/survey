<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Services\Admin\UserService;
use App\Models\User;
use Illuminate\Http\Response;

class UserController extends Controller
{
    function __construct()
    {
        $this->authorizeResource(User::class, 'subject');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = UserService::all();
        return response()->json(['status' => Response::HTTP_OK, 'data' => $users], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        $user = UserService::create($request);
        return response()->json(['status' => Response::HTTP_OK, 'data' => $user], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $subject
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $subject)
    {
        $subject = UserService::get($subject);
        return response()->json(['status' => Response::HTTP_OK, 'data' => $subject], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest $request
     * @param  User $subject
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, User $subject)
    {
        $subject = UserService::update($request, $subject);
        return response()->json(['status' => Response::HTTP_OK, 'data' => $subject], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $subject
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $subject)
    {
        UserService::delete($subject);
        return response()->json(['status' => Response::HTTP_OK, 'message' => 'User was deleted!'], Response::HTTP_OK);
    }
}
