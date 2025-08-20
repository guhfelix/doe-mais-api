<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
{
    public function authorize(): bool 
    { 
        return true; 
    }

    public function rules(): array
    {
        return [
            'date'      => 'required|date',
            'location'  => 'required|string|max:255',
            'volume_ml' => 'required|integer|min:200|max:650',
            'modality'  => 'required|string|in:whole_blood,platelets,plasma',
            'notes'     => 'nullable|string|max:500',
        ];
    }
}
