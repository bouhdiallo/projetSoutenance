<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function adminregister(Request $request){

        $admin = Admin::create([
         
            'nom' =>$request->nom,
            'prenom' =>$request->prenom,
            'email' =>$request->email,
            'password' =>Hash::make($request->password)
        ]);
    
          if($admin){
            return response()->json([$admin,'status' => true]);
    
          }else {
            return response()->json(['status' => false]);
    
          }
     }

     public function adminlog(Request $request){

        // credentiels contient les infos d'identification extraite de la requete 
        $credentials = request(['email', 'password']);

        //cas ou l'authentification a echoué
        if (! $token = auth()->guard('admin-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $token;
        }

        public function me()
        {
            return response()->json(auth()->guard('admin-api')->user());
        }
    
        /**
         * Log the user out (Invalidate the token).
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function adminlogout()
        {
            auth()->guard('admin-api')->logout();
    
            return response()->json(['message' => 'Successfully logged out']);
        }

}
