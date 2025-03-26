<?php
namespace App\Http\Controllers\API;
use App\Models\Instructor;
use App\traits\ResponseJsonTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\InstructorRequest;

class InstructorController extends Controller
{
    use ResponseJsonTrait;
    public function __construct()
    {
        $this->middleware('auth:admins')->only(['store', 'update', 'destroy']);
    }
    public function index()
    {
        $instructors = Instructor::all();
        return $this->sendSuccess('All Instructors Retrieved Successfully!', $instructors);
    }
    public function store(InstructorRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $imageName = time() . '_' . $originalName;
            $request->file('image')->move(public_path('uploads/instructors'), $imageName);
            $data['image'] = asset('uploads/instructors/' . $imageName);
        } else {
            $data['image'] = null;
        }
        $instructor = Instructor::create($data);
        return $this->sendSuccess('Instructor Added Successfully', $instructor, 201);
    }
    public function show(string $id)
    {
        $instructor = Instructor::with('courses')->findOrFail($id);
        return $this->sendSuccess('Instructor Data Retrieved Successfully!', $instructor);
    }
    public function update(InstructorRequest $request, string $id)
    {
        $instructor = Instructor::findOrFail($id);
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $oldImagePath = public_path('uploads/instructors/' . basename($instructor->image));
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $originalName = $request->image->getClientOriginalName();
            $imageName = time() . '_' . $originalName;
            $request->image->move(public_path('uploads/instructors'), $imageName);
            $data['image'] = asset('uploads/instructors/' . $imageName);
        }
        $instructor->update($data);
        return $this->sendSuccess('Instructor Data Updated Successfully', $instructor, 200);
    }
    public function destroy($id)
    {
        $instructor = Instructor::findOrFail($id);
        if ($instructor->image && !str_contains($instructor->image, 'default.jpg')) {
            $imageName = basename($instructor->image);
            $imagePath = public_path("uploads/instructors/" . $imageName);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $instructor->delete();
        return $this->sendSuccess('Instructor Removed Successfully');
    }
}
