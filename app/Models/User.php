<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;
    const ROLE_INSTRUCTOR = 3;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
/**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password', 'field','role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(\App\Models\Courses::class, 'enrollments', 'user_id', 'course_id');
    }
    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }
    public function instructorProfile()
    {
        return $this->hasOne(Instructor::class, 'user_id');
    }


public function videoProgress() {
    return $this->hasMany(VideoProgress::class);
}

public function quizSubmissions() {
    return $this->hasMany(QuizSubmission::class);
}



}
