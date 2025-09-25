<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
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
            'name' => 'sometimes| required' ,
            'post_number' => 'sometimes | required | regex:/^\d{3}-\d{4}$/' ,
            'address' => 'sometimes | required' ,
        ];
    }

    public function messages()
    {
        {
            return[
                'name.required' => 'お名前を入力してください',
                'post_number.required' => '郵便番号を入力してください',
                'post_number.regex' => '郵便番号はハイフンありの123-4567の形で入力してください',
                'address.required' => '住所を入力してください'
            ];
        }
    }
}
