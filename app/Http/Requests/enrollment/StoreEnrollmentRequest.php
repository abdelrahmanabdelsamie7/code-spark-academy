<?php

namespace App\Http\Requests\enrollment;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
{
     public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id|uuid',
            'course_id' => 'required|exists:courses,id|uuid',
            'amount_paid' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:vodafone_cash,paypal',
            'receipt_image' => 'required_if:payment_method,vodafone_cash|nullable|image|mimes:jpeg,png,jpg|max:4048',
            'payment_status' => 'nullable|in:pending,completed,failed',
        ];
    }
}
