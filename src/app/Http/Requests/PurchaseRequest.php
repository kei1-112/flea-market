<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'pay_select' => 'required' ,
            'destination_post_number' => 'sometimes | required',
            'destination_address' => 'sometimes | required',
        ];
    }

    public function messages()
    {
        {
            return[
                'pay_select.required' => '支払い方法を選択してください',
                'destination_post_number.required' => '郵便番号を入力してください',
                'destination_address.required' => '住所を入力してください',
            ];
        }
    }
}
