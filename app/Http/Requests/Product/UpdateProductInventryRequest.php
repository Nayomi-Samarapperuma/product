<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductInventryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => ['required','string'],
            'date' => ['required','date_format:d.m.Y'],
            'quantity' => ['required','numeric'],
            'reason' => ['required','string','max:255'],
        ];
    }
}