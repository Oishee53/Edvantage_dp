<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalExamQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'final_exam_id',
        'question_number',
        'question_text',
        'marks',
        'marking_criteria'
    ];

    /**
     * Get the exam this question belongs to
     */
    public function exam()
    {
        return $this->belongsTo(FinalExam::class, 'final_exam_id');
    }

    /**
     * Get all answers for this question
     */
    public function answers()
    {
        return $this->hasMany(FinalExamAnswer::class, 'question_id');
    }

    /**
     * Get answer for a specific submission
     */
    public function getAnswerForSubmission($submissionId)
    {
        return $this->answers()->where('submission_id', $submissionId)->first();
    }
}