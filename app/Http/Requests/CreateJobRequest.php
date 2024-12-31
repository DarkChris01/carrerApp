<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateJobRequest extends FormRequest
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
            'poste' => ["required", "string", "max:100"],
            'mission' => ["required", "string",],
            'salary' => ["required", "integer"],
            'type' => ["required", "string"],
            'delay' => ["required", "date"],
            'domain' => ['required', 'string','exists:domains,id'],
            'formation' => ['required', 'string'],
            'experience' => ['required', 'integer'],
            'effective' => ['required', 'integer'],
            'country' => ['required', 'string'],
            'competence1' => ["required","string"],
            'competence2' => ["sometimes",],
            'competence3' => ["sometimes",],
            'competence4' => ["sometimes",],
            'competence5' => ["sometimes",],
            'competence6' => ["sometimes"],
        ];
    }
}
