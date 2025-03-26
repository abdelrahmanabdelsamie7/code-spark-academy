<?php
namespace App\Models;
use App\Models\Course;
use App\traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instructor extends Model
{
    use HasFactory, UsesUuid;
    protected $table = 'instructors';
    protected $fillable = ['name', 'job_title', 'bio', 'linkedin', 'github', 'whatsapp', 'youtube', 'image'];
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
