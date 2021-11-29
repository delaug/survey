<?php

namespace App\Http\Controllers\API\Admin;

use App\Facades\Admin\UserFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
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
        $users = UserFacade::all();
        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        $user = UserFacade::create($request);
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $subject
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $subject)
    {
        $subject = UserFacade::get($subject);
        return response()->json($subject, Response::HTTP_OK);
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
        $subject = UserFacade::update($request, $subject);
        return response()->json($subject, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $subject
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $subject)
    {
        UserFacade::delete($subject);
        return response()->json(null, Response::HTTP_OK);
    }
}
