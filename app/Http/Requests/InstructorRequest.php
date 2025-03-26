<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class InstructorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'linkedin' => 'nullable|url|max:255',
            'github' => 'nullable|url|max:255',
            'whatsapp' => 'nullable|string',
            'youtube' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:4048',
        ];
    }
}