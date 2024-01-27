<?php

namespace App\Http\Requests;

use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRessourceRequest extends FormRequest
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
        return   [
            'nom' => 'required|string',
            'nature' => 'required|string',

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
           'nom.required' => 'un nom pour la ressource doit etre fourni',
           'nature.required' => 'la nature doit etre fourni pour la ressource',

       ];
    }
}
