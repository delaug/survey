<?php

namespace App\Http\Controllers\API\Admin;

use App\Facades\Admin\FieldFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFieldRequest;
use App\Http\Requests\Admin\UpdateFieldRequest;
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
        $field = FieldFacade::all();
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
        $field = FieldFacade::create($request);
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
        $field = FieldFacade::get($field);
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
        $field = FieldFacade::update($request, $field);
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
        FieldFacade::delete($field);
        return response()->json(null, Response::HTTP_OK);
    }
}
