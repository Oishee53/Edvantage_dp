<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalExamAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'question_id',
        'answer_images',
        'marks_obtained',
        'instructor_comment'
    ];

    protected $casts = [
        'answer_images' => 'array' // JSON array of image URLs
    ];

    /**
     * Get the submission this answer belongs to
     */
    public function submission()
    {
        return $this->belongsTo(FinalExamSubmission::class, 'submission_id');
    }

    /**
     * Get the question this answer is for
     */
    public function question()
    {
        return $this->belongsTo(FinalExamQuestion::class, 'question_id');
    }

    /**
     * Check if answer has been graded
     */
    public function isGraded()
    {
        return $this->marks_obtained !== null;
    }

    /**
     * Get percentage for this answer
     */
    public function getPercentageAttribute()
    {
        if (!$this->isGraded()) {
            return null;
        }

        $totalMarks = $this->question->marks;
        
        return $totalMarks > 0 
            ? round(($this->marks_obtained / $totalMarks) * 100, 2) 
            : 0;
    }
}