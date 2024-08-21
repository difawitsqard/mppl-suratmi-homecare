<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class OrderServiceRequest extends FormRequest
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
        $validStatuses = ['pending', 'approved', 'completed', 'rejected', 'canceled'];

        return [
            'customer_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'note' => 'nullable|string',
            'date' => 'required|date|after_or_equal:now',
            'status' => ['string', Rule::in($validStatuses)],
        ];
    }

    protected function prepareForValidation(): void
    {
        $user = auth()->user();

        if (!$user->address || !$user->phone_number) {
            throw ValidationException::withMessages([
                'customer' => 'Lengkapi alamat dan nomor telepon terlebih dahulu.',
            ]);
        }

        $this->merge([
            'customer_id' => auth()->id(),
        ]);
    }
}
