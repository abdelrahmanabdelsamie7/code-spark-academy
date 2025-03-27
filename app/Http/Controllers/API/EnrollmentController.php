<?php
namespace App\Http\Controllers\API;
use App\Models\Enrollment;
use App\traits\ResponseJsonTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\enrollment\StoreEnrollmentRequest;
use App\Http\Requests\enrollment\UpdateEnrollmentRequest;
use Illuminate\Support\Facades\File;

class EnrollmentController extends Controller
{
    use ResponseJsonTrait;
    public function __construct()
    {
        $this->middleware('auth:admins')->only(['store', 'update', 'destroy']);

    }
    public function index()
    {
        $enrollments = Enrollment::all();
        return $this->sendSuccess('Enrollments Retrieved Successfully!', $enrollments);
    }
    public function store(StoreEnrollmentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth('api')->id();
        if ($request->hasFile('receipt_image')) {
            $imageName = time() . '_' . $request->file('receipt_image')->getClientOriginalName();
            $request->file('receipt_image')->move(public_path('uploads/receipts'), $imageName);
            $data['receipt_image'] = asset('uploads/receipts/' . $imageName);
        }
        $data['payment_status'] = $data['payment_status'] ?? 'pending';
        $enrollment = Enrollment::create($data);
        return $this->sendSuccess('Enrollment Added Successfully!', $enrollment, 201);
    }
    public function show(string $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        return $this->sendSuccess('Enrollment Retrieved Successfully!', $enrollment);
    }
    public function update(UpdateEnrollmentRequest $request, string $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $data = $request->validated();
        $enrollment->update($data);
        return $this->sendSuccess('Enrollment Updated Successfully!', $enrollment, 200);
    }
    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        if ($enrollment->receipt_image) {
            $imagePath = public_path('uploads/receipts/' . basename($enrollment->receipt_image));
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $enrollment->delete();
        return $this->sendSuccess('Enrollment Removed Successfully!');
    }
}
