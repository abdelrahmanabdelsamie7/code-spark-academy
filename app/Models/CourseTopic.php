<?php
namespace App\Models;
use App\Models\Course;
use App\traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseTopic extends Model
{
    use HasFactory, UsesUuid;
    protected $table = 'course_topics';
    protected $fillable = [
        'title',
        'course_id',
        'order'
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
