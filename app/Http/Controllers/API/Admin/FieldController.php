<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFieldRequest;
use App\Http\Requests\Admin\UpdateFieldRequest;
use App\Http\Services\Admin\FieldService;
use App\Models\Field;
use Illuminate\Http\Response;

class FieldController extends Controller
{
    function __construct()
    {
        $this->authorizeResource(Field::class, 'field');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $field = FieldService::all();
        return response()->json($field, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFieldRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreFieldRequest $request)
    {
        $field = FieldService::create($request);
        return response()->json($field, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  Field $field
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Field $field)
    {
        $field = FieldService::get($field);
        return response()->json($field, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFieldRequest $request
     * @param  Field $field
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateFieldRequest $request, Field $field)
    {
        $field = FieldService::update($request, $field);
        return response()->json($field, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Field $field
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Field $field)
    {
        FieldService::delete($field);
        return response()->json(null, Response::HTTP_OK);
    }
}
