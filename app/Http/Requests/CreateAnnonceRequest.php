<?php

namespace App\Http\Requests;

use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateAnnonceRequest extends FormRequest
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
                     'description' => 'required',
                     'date_activite' => 'required|date',
                     'lieu' => 'required',
                     'images' => 'required|image'



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
                    'description.required' => 'une dscription doit etre fourni',
                    'date_acctivite.required' => 'la date de l activite doit etre fourni',
                    'lieu.required' => 'le lieu doit etre fourni',
                    'images.required' => 'fournissez une image pour l activite svp'


                ];
             }
}
