<?php

namespace EG\Ecommerce\Http\Requests;

use EG\Base\Enums\BaseStatusEnum;
use EG\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ProductCollectionRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
//        switch (request()->route()->getName()) {
//            case 'product-collections.create':
//                return [
//                    'name' => 'required',
//                    'slug' => 'required|unique:ec_product_collections',
//                ];
//            default:
//                return [
//                    'name' => 'required',
//                ];
//        }
    }
}
