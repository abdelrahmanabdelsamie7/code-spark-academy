<?php
namespace App\Http\Controllers\API;
use App\Models\Course;
use App\traits\ResponseJsonTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use Illuminate\Support\Facades\File;

class CourseController extends Controller
{
    use ResponseJsonTrait;
    public function __construct()
    {
        $this->middleware('auth:admins')->only(['store', 'update', 'destroy']);
    }
    public function index()
    {
        $courses = Course::all();
        return $this->sendSuccess('Courses Retrieved Successfully!', $courses);
    }
    public function store(CourseRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $imageName = time() . '_' . $originalName;
            $request->file('image')->move(public_path('uploads/courses'), $imageName);
            $data['image'] = asset('uploads/courses/' . $imageName);
        } else {
            $data['image'] = null;
        }
        $course = Course::create($data);
        return $this->sendSuccess('Course Added Successfully', $course, 201);
    }
    public function show(string $id)
    {
        $course = Course::with(['instructor', 'track', 'course_topics'])->findOrFail($id);
        return $this->sendSuccess('Course Data Retrieved Successfully!', $course);
    }
    public function update(CourseRequest $request, string $id)
    {
        $course = Course::findOrFail($id);
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $oldImagePath = public_path('uploads/courses/' . basename($course->image));
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $originalName = $request->image->getClientOriginalName();
            $imageName = time() . '_' . $originalName;
            $request->image->move(public_path('uploads/courses'), $imageName);
            $data['image'] = asset('uploads/courses/' . $imageName);
        }
        $course->update($data);
        return $this->sendSuccess('Course Data Updated Successfully', $course, 200);
    }
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        if ($course->image && !str_contains($course->image, 'default.jpg')) {
            $imageName = basename($course->image);
            $imagePath = public_path("uploads/courses/" . $imageName);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $course->delete();
        return $this->sendSuccess('Course Removed Successfully');
    }
}