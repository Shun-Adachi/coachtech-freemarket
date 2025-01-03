<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class SellRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'categories' => ['required'],
            'condition' => ['required'],
            'price' => ['required', 'integer', 'min:0'],
        ];

        // 画像が新たに選択されていない場合、一時保存された画像を利用
        if (!$this->hasFile('image') && $this->temp_image) {
            // 画像が既に一時保存されている場合は必須チェックをスキップ
            $rules['image'] = [];
        } else {
            // 通常のバリデーションルール
            $rules['image'] = ['required', 'mimes:jpg,jpeg,png', 'max:2048'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'image.required' => '商品画像を選択してください',
            'image.mimes' => '画像ファイルはJPEGもしくはPNGを選択してください',
            'name.required' => '商品名を入力してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '商品説明は255以下で入力してください',
            'categories.required' => 'カテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '販売価格を入力してください',
            'price.integer' => '販売価格は整数を入力してください',
            'price.min' => '販売価格は0円以上で入力してください',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // 新しいファイルがアップロードされた場合の処理
        if ($this->hasFile('image')) {
            // 既存の一時ファイルを削除
            if ($this->temp_image) {
                Storage::disk('public')->delete($this->temp_image);
            }
            // 新しいファイルを保存
            $path = $this->file('image')->store('temp', 'public');
            // セッションにパスを保存
            $this->session()->flash('temp_image', $path);
        }
        // ファイルがアップロードされておらず、一時ファイルが存在する場合の処理
        elseif ($this->temp_image) {
            //　セッションにパスを保存
            $this->session()->flash('temp_image', $this->temp_image);
        }

        parent::failedValidation($validator);
    }
}
