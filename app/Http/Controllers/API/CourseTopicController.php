<?php
namespace App\Http\Controllers\API;
use App\Http\Requests\CourseTopicRequest;
use App\Models\CourseTopic;
use App\traits\ResponseJsonTrait;
use App\Http\Controllers\Controller;
class CourseTopicController extends Controller
{
    use ResponseJsonTrait;
    public function __construct()
    {
        $this->middleware('auth:admins')->only(['store', 'update', 'destroy']);
    }
    public function store(CourseTopicRequest $request)
    {
        $topic = CourseTopic::create($request->validated());
        return $this->sendSuccess('Topic Of Course Added Successfully', $topic, 201);
    }
    public function show(string $id)
    {
        $topic = CourseTopic::findOrFail($id);
        return $this->sendSuccess('Topic Data Retrieved Successfully!', $topic);
    }
    public function update(CourseTopicRequest $request, string $id)
    {
        $topic = CourseTopic::findOrFail($id);
        $topic->update($request->validated());
        return $this->sendSuccess('Topic Data Updated Successfully', $topic, 200);
    }
    public function destroy($id)
    {
        $topic = CourseTopic::findOrFail($id);
        $topic->delete();
        return $this->sendSuccess('Topic Deleted Successfully');
    }
}
