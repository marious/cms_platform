<?php

namespace EG\Ecommerce\Http\Requests;


use EG\Support\Http\Requests\Request;

class ProductRequest extends Request
{
    public function rules(): array
    {
        return [
            'name'              => 'required',
            'price'             => 'numeric|nullable',
            'start_date'        => 'date|nullable|required_if:sale_type,1',
            'end_date'          => 'date|nullable|after:' . ($this->input('start_date') ?? now()->toDateTimeString()),
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'          => __('Please enter product\'s name'),
            'sale_price.max'         => __('The discount must be less than the original price'),
            'sale_price.required_if' => __('Must enter a discount when you want to schedule a promotion'),
            'end_date.after'         => __('End date must be after start date'),
            'start_date.required_if' => __('Discount start date cannot be left blank when scheduling is selected'),
            'sale_price'             => __('Discounts cannot be left blank when scheduling is selected'),
        ];
    }
}
