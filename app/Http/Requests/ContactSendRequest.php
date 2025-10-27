<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactSendRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array {
        return [
            'name'    => ['required','string','max:255'],
            'email'   => ['required','email','max:255'],
            'message' => ['required','string','min:5'],
            // Honeypot (nếu dùng ở Day 2 thì thêm field ẩn, rule 'prohibited' khi có value)
        ];
    }
}
