<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function userregister(Request $request){

        $user = User::create([
         
            'nom' =>$request->nom,
            'prenom' =>$request->prenom,
            'email' =>$request->email,
            'password' =>Hash::make($request->password)
        ]);
    
          if($user){
            return response()->json([$user,'status' => true]);
    
          }else {
            return response()->json(['status' => false]);
    
          }
     }

     public function userlog(Request $request){

        // credentiels contient les infos d'identification extraite de la requete 
        $credentials = request(['email', 'password']);

        //cas ou l'authentification a echoué
        if (! $token = auth()->guard('user-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $token;
        }

        public function me()
        {
            return response()->json(auth()->guard('user-api')->user());
        }
    
        /**
         * Log the user out (Invalidate the token).
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function userlogout()
        {
            auth()->guard('user-api')->logout();
    
            return response()->json(['message' => 'Successfully logged out']);
        }

}