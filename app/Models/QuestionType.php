<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionType extends Model
{
    use HasFactory, SoftDeletes;

    const CHECKBOX = 1;
    const RADIO = 2;
    const TEXT = 3;
    const TEXTAREA = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name'
    ];
}
