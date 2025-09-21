<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
    public function rules(): array
    {
        $id = $this->id; // for update case
        $rules = [
            'name'             => 'required|string|max:255',
            'logo'             => 'nullable|image|max:2048',
            'phone'            => 'nullable|string|max:30',
            'address'          => 'nullable|string|max:1000',
            'city'             => 'nullable|string|max:255',
            'state'            => 'nullable|string|max:255',
            'country'          => 'nullable|string|max:255',
            'zip'              => 'nullable|string|max:20',

            'owner_name'       => 'required|string|max:255',
            'owner_email'      => 'required|email|max:255',
            'owner_mobile'     => 'nullable|string|max:30',
            'owner_designation'=> 'nullable|string|max:255',

            'domain'           => 'nullable|string|max:255',
        ];

        if (!$id) {
            $rules['db_name'] = 'unique:companies,db_name';
            $rules['owner_email'] .= '|unique:users,email'; // owner user email unique
        }

        return $rules;
    }

    public function messages(): array
    {
        // dd($this->all());
        return [
            'name.required'        => 'Company name is required',
            'owner_name.required'  => 'Owner name is required',
            'owner_email.required' => 'Owner email is required',
            'owner_email.email'    => 'Enter a valid email address',
        ];
    }
}
