<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Override;

class VocabularyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'word'=> ['required', 'max:100'],
            'meaning'=> ['required', 'max:500'],
            'part_of_speech'=>['nullable'],
            'example'=>['nullable'],
            'is_mastered'=>['boolean']
        ];
    }

    #[Override]
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response(
            [
                'errors'=>$validator->getMessageBag()
            ], 422
        ));
    }
}
