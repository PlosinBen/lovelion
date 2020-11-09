<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddStatementRequests extends FormRequest
{
    protected $errorBag = 'AddStatement';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'period' => 'required|date_format:Y-m',
            'commitment' => 'required|integer',
            'open_interest' => 'required|integer',
            'profit' => 'required|integer',
            'oversea_commitment' => 'nullable|integer',
            'note' => 'nullable|string',
        ];
    }
}
