<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateAnnuaireRequest extends FormRequest
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
        return 
             [
                     'nom' => 'required|regex:/^[a-zA-Z]+$/',
                     'adress' => 'required',
                     'couriel' => 'required'


                ];

            }
            
            public function failedValidation(validator $validator){
                throw new HttpResponseException(response()->json([
                    'success'=>false,
                    'error'=>true,
                    'message'=> 'Erreur de validation',
                    'errorsList'=> $validator->errors()
                ]));
            }
             public function messages()
             {
                return [
                    'nom.required' => 'un nom doit etre fourni',
                    'adress.required' => 'un adress doit etre fourni',
                    'couriel.required' => 'un couriel doit etre fourni'

                ];
             }
}
