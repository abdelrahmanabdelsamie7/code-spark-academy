<?php
namespace App\Models;
use App\Models\{Track, Instructor, CourseTopic, Enrollment};
use App\traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Course extends Model
{
    use HasFactory, UsesUuid;
    protected $table = 'courses';
    protected $fillable = [
        'title',
        'description',
        'duration',
        'sessions_count',
        'mode',
        'image',
        'price',
        'discount',
        'status',
        'instructor_id',
        'track_id'
    ];
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
    public function track()
    {
        return $this->belongsTo(Track::class);
    }
    public function course_topics()
    {
        return $this->hasMany(CourseTopic::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

}