<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatRequest extends FormRequest
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
            'message' => 'required|max:400' ,
            'item_img' => 'nullable|mimes:jpeg,png'
        ];
    }

    public function messages()
    {
        {
            return[
                'message.required' => '本文を入力してください',
                'message.max' => '本文は400文字以内で入力してください',
                'item_img.mimes' => '商品画像の拡張子はjpegかpngにしてください'
            ];
        }
    }
}
