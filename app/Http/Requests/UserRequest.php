<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'name' => 'required',
            'gender' => 'required',
            'firstname' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'matricule' => 'required|unique:users',
            'email'         => 'required|unique:users|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom est requis',
            'gender.required' => 'Le genre est requis',
            'firstname.required' => 'Le prénom est requis',
            'phone.required' => 'Le numero de téléphone est requis',
            'address.required' => 'Le numero de address est requis',
            'email.required' => 'Le mail est requis',
            'email.unique' => 'Un compte est déjà associer à cet mail',
        ];
    }
}
