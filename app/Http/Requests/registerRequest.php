<?php

namespace App\Http\Requests;

use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class registerRequest extends FormRequest
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
        return [
            'nom' => 'required|string',
            'prenom'=>'required|string',
            'email'=>'required|unique:users,email',
            'password'=>'required|min:6'
        ];
    }


          /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validatePassword($validator);
        });
    }

    /**
     * Validate password custom rules.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    protected function validatePassword($validator)
    {
        $password = $this->input('password');

        // Votre logique de validation personnalisée du mot de passe ici
        if (!preg_match('/(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{6,}/', $password)) {
            $validator->errors()->add('password', 'Le mot de passe doit contenir au moins une lettre, un chiffre et un caractère spécial.');
        }
    }
    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'success'=>false,
            'status_code'=>422,
            'error'=>true,
            'message'=>'Erreur de validation',
            'errorsList'=> $validator->errors()
        ]));
    }


    public function messages()
    {
        return [
            'nom.required' => 'Un nom doit être fourni.',
            'prenom.required' => 'Un prénom doit être fourni.',
            'email.required' => 'Une adresse email doit être fournie.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.required' => 'Un mot de passe doit être fourni.',
        ];
    }
}
