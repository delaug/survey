<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'text',
        'sort',
        'question_id',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    //protected $with = ['type', 'option'];

    public function answers() {
        return $this->belongsToMany(Answer::class)->withPivot(['question_id','value']);
    }
}
