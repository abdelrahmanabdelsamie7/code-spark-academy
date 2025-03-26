<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class CourseTopicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'course_id' => 'required|uuid|exists:courses,id',
            'title' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0'
        ];
    }
}