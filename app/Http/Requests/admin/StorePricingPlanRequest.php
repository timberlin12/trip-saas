<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePricingPlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'plan_name'      => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'billing_cycle'  => 'required|in:monthly,yearly,lifetime',
            'features'       => 'nullable|array',
            'features.*'     => 'string',
            'is_popular'     => 'boolean',
            'status'         => 'required|in:1,0',
            'discount_type'  => 'nullable|in:percentage,fixed',
            'discount_value' => 'nullable|numeric|min:0',
            'trial_days'     => 'nullable|integer|min:0',
            'max_users'      => 'nullable|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'plan_name.required'     => 'Plan name is required',
            'price.required'         => 'Price is required',
            'price.numeric'          => 'Price must be a number',
            'billing_cycle.required' => 'Billing cycle is required',
            'billing_cycle.in'       => 'Billing cycle must be monthly, yearly or lifetime',
            'discount_type.in'       => 'Discount type must be percentage or fixed',
            'discount_value.numeric' => 'Discount value must be a number',
        ];
    }
    protected function prepareForValidation()
    {
        if ($this->has('features') && is_string($this->features)) {
            $this->merge([
                'features' => array_filter(
                    array_map('trim', preg_split('/[\r\n,]+/', $this->features))
                )
            ]);
        }
    }
}
