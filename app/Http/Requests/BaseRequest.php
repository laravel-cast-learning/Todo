<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    /**
     * @throws ValidationException
     */
    protected function prepareForValidation(): void
    {
        if (
            !$this->hasHeader('Content-Type') ||
            !str_contains($this->header('Content-Type'), 'multipart/form-data') &&
            !str_contains($this->header('Content-Type'), 'application/x-www-form-urlencoded')) {
            throw new HttpResponseException(
                response()->json([
                    'success'   => false,
                    'message'   => 'invalid content type ',
                    'errors'    => null,
                    'data'      => null
                ])
            );
        }
    }
}
