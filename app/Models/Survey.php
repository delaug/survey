<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'publish_at',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    //protected $with = ['questions'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'publish_at' => 'date:Y-m-d H:i:s',
        'created_at' => 'date:Y-m-d H:i:s',
        'updated_at' => 'date:Y-m-d H:i:s',
    ];

    protected $appends = ['answers_to_questions_count'];

    public function getAnswersToQuestionsCountAttribute()
    {
        return $this->answersToQuestionsCount();
    }

    public function answersToQuestionsCount()
    {
        return $this->answers()
            ->where('user_id', auth('sanctum')->id())
            ->select('question_id')
            ->distinct()
            ->count('question_id');
    }

    public function answers()
    {
        return $this->hasManyThrough(Answer::class, Question::class);
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeWithUser($query)
    {
        return $query->with([
            'user' => fn($q) => $q->select(['id','name'])
        ]);
    }
}
