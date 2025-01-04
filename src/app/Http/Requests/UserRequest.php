<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class UserRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'post_code' => 'required | regex:/^\d{3}-\d{4}$/',
            'address' => 'required',
        ];

        if (!$this->hasFile('image') && $this->temp_image) {
            // 一時保存されている場合は必須チェックをスキップ
            $rules['image'] = [];
        } else {
            // 通常のバリデーションルール
            $rules['image'] = ['mimes:jpg,jpeg,png', 'max:2048'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'image.mimes' => '画像ファイルはJPEGもしくはPNGを選択してください',
            'name.required' => 'ユーザー名を入力してください',
            'post_code.required' => '郵便番号を入力してください',
            'post_code.regex' => '郵便番号は8文字(ハイフンあり)の形で入力してください',
            'address.required' => '住所を入力してください',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        handleTempImageUpload($this, $validator);
        parent::failedValidation($validator);
    }
}
