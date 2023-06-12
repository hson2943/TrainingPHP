<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'prices' => 'required|numeric|min:10000|max:1000000000',
            'category_id' => 'required',
            'brand_id' => 'required|exists:brand,id',
            'thumbnail' => 'required',
            'description' => 'max:500',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm không được để trống',
            'price.required' => 'Giá sản phẩm không được để trống (từ 10,000 đến 1,000,000,000)',
            'price.max' => 'Giá phải từ 10,000 đến 1,000,000,000',
            'price.min' => 'Giá phải từ 10,000 đến 1,000,000,000',
            'price.numeric' => 'Giá phải là số',
            'category_id.required' => 'Danh mục không được để trống',
            'brand_id.required' => 'Hãng không được để trống',
            'thumbnail.required' => 'Ảnh không được để trống',
            'description.max' => 'Tối đa 500 ký tự',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'errors' => $validator->errors(),
        ], 422));
    }
}
