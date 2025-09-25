<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'item_img' => 'required|mimes:jpg,png',
            'item_name' => 'required' ,
            'item_description' => 'required|max:255',
            'item_categories' => 'required|array|min:1' ,
            'item_condition' => 'required',
            'price' => 'required|numeric|min:0'
        ];
    }

    public function messages()
    {
        {
            return[
                'item_img.required' => '商品画像をアップロードしてください',
                'item_img.mimes' => '商品画像の拡張子はjpegかpngにしてください',
                'item_name.required' => '商品名を入力してください',
                'item_description.required' => '商品説明を入力してください',
                'item_description.max' => '商品説明は255文字以内で入力してください',
                'item_categories.required' => '商品のカテゴリを1つ以上選択してください',
                'item_condition.required' => '商品の状態を選択してください',
                'price.required' => '商品価格を入力してください',
                'price.numeric' => '商品価格は数字で入力してください',
                'price.min' => '商品価格は0円以上で入力してください'
            ];
        }
    }
}
