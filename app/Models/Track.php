<?php
namespace App\Models;
use App\Models\Course;
use App\traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Track extends Model
{
    use HasFactory, UsesUuid;
    protected $table = 'tracks';
    protected $fillable = ['name', 'description', 'image'];
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}