<?php
namespace App\Http\Controllers\API;
use App\Models\Track;
use App\traits\ResponseJsonTrait;
use App\Http\Requests\TrackRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class TrackController extends Controller
{
    use ResponseJsonTrait;
    public function __construct()
    {
        $this->middleware('auth:admins')->only(['store', 'update', 'destroy']);
    }
    public function index()
    {
        $tracks = Track::all();
        return $this->sendSuccess('Tracks Of Programming Retrieved Successfully!', $tracks);
    }
    public function store(TrackRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $imageName = time() . '_' . $originalName;
            $request->file('image')->move(public_path('uploads/tracks'), $imageName);
            $data['image'] = asset('uploads/tracks/' . $imageName);
        } else {
            $data['image'] = null;
        }
        $track = Track::create($data);
        return $this->sendSuccess('Track Added Successfully', $track, 201);
    }
    public function show(string $id)
    {
        $track = Track::with('courses')->findOrFail($id);
        return $this->sendSuccess('Track & thier Courses Retrieved Successfully!', $track);
    }
    public function update(TrackRequest $request, string $id)
    {
        $track = Track::findOrFail($id);
        $data = $request->validated();
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];
        if ($request->hasFile('image')) {
            $oldImagePath = public_path('uploads/tracks/' . basename($track->image));
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $originalName = $request->image->getClientOriginalName();
            $imageName = time() . '_' . $originalName;
            $request->image->move(public_path('uploads/tracks'), $imageName);
            $data['image'] = asset('uploads/tracks/' . $imageName);
        }
        $track->update($data);
        return $this->sendSuccess('Track Data Updated Successfully', $track, 200);
    }
    public function destroy($id)
    {
        $track = Track::findOrFail($id);
        if ($track->image && !str_contains($track->image, 'default.jpg')) {
            $imageName = basename($track->image);
            $imagePath = public_path("uploads/tracks/" . $imageName);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $track->delete();
        return $this->sendSuccess('Track Removed Successfully');
    }
}
