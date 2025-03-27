<?php
namespace App\Http\Requests\enrollment;
use Illuminate\Foundation\Http\FormRequest;
class UpdateEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'payment_status' => 'nullable|in:pending,completed,failed',
        ];
    }
}