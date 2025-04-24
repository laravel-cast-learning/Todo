<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TodoRequest extends ProtectedBaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'title' => 'required',
            'description' => 'required',
        ]);
    }

    public function messages(): array
    {
        return [
          'title.required' => 'Title is required',
          'description.required' => 'Description is required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => $validator->errors()->first(),
            'errors'    => $validator->errors()
        ]));
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'You are not authorized to perform this action',
            'errors'    => null
        ],401));
    }
}
