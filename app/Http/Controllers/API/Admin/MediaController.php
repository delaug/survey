<?php

namespace App\Http\Controllers\API\Admin;

use App\Facades\Admin\MediaFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMediaRequest;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class MediaController
 * @package App\Http\Controllers\API\Admin
 */
class MediaController extends Controller
{
    /**
     * MediaController constructor.
     */
    function __construct()
    {
        $this->authorizeResource(Media::class, 'media');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $media = MediaFacade::all();
        return response()->json($media, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreMediaRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreMediaRequest $request)
    {
        $media = MediaFacade::create($request);
        return response()->json($media, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  Media $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Media $media)
    {
        $media = MediaFacade::get($media);
        return response()->json($media, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Media $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Media $media)
    {
        MediaFacade::delete($media);
        return response()->json(null, Response::HTTP_OK);
    }
}
