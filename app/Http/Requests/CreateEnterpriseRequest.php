<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateEnterpriseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('employer')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:100", "min:5"],
            "company_name" => ["required", "string", "max:100", "min:5"],
            "phone" => ["required", "integer"],
            "address" => ["required", "string", "max:100", "min:5"],
            "country" => ["required", "string", "max:100"],
            "sectors" => ["required", "array","max:8"],            
            "region" => ["required", "string", "max:100"],
            "facebook" => ["nullable", "email", "max:100"],
            "linkedin" => ["nullable", "email", "max:100"],
            "twitter" => ["nullable", "email", "max:100"],
            "email" => ["required", "email", "max:100"],
            "type" => ["required", "string", "max:100"],
            "postal" => ["nullable", "string", "max:100"],
            "logo" => ["nullable", "file", "mimes:png,jpg,jpeg"],
        ];
    }
}
