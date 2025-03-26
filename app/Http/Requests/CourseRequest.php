<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class CourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|integer|min:1',
            'sessions_count' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:4048',
            'mode' => 'required|in:online,offline',
            'price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'status' => 'required|in:available,closed,completed',
            'instructor_id' => 'nullable|uuid|exists:instructors,id',
            'track_id' => 'nullable|uuid|exists:tracks,id',
        ];
    }
}
