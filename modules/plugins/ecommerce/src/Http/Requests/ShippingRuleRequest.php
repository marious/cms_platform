<?php

namespace EG\Ecommerce\Http\Requests;

use EG\Support\Http\Requests\Request;

class ShippingRuleRequest extends Request
{
    public function rules()
    {
        $ruleItems = [];
        foreach ($this->input('shipping_rule_items', []) as $key => $item) {
            $ruleItems['shipping_rule_items.' . $key . '.adjustment_price'] = 'required|numeric';
        }

        return [
                'name'  => 'required|max:120',
                'from'  => 'required|numeric',
                'to'    => 'nullable|numeric|min:' . (float)$this->input('from'),
                'price' => 'required',
                'type'  => 'required',
            ] + $ruleItems;
    }

    public function attributes()
    {
        $attributes = [];
        foreach ($this->input('shipping_rule_items', []) as $key => $item) {
            $attributes['shipping_rule_items.' . $key . '.adjustment_price'] = __('Adjustment price of') . ' ' . $key;
        }

        return $attributes;
    }
}
