<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionType;
use Illuminate\Http\Response;

class QuestionTypeController extends Controller
{
    function __construct()
    {
        $this->authorizeResource(QuestionType::class, 'question_type');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $types = QuestionType::all();
        return response()->json($types, Response::HTTP_OK);
    }
}
