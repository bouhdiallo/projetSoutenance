<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function userregister(Request $request){
        $user = new User();
        
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;


        $user->save();
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

//         public function userlogout()
// {
//     auth('user-api')->logout();

//     return response()->json(['message' => 'Déconnexion réussie']);
// }


  // on verifie si le mail correspond, si c le cas on pass le user pour une modification de son mot de pass.
  public function verifMail(Request $request){
   $user=User::where('email',$request->email)->first();
 // dd($user);
    if($user){
      return response()->json([
          'status_code' => 200,
          'status_message' => 'Utilisateur trouvé',
          'user' => $user,
      ]);
   }

  }
    public function resetPassword(Request $request,User $user){
    $user->password=$request->password;
   $user->save();
 //dd($user);
    if($user){
       return response()->json([
          'status_code' => 200,
          'status_message' => 'Votre mot de passe a été modifier',
          'user' => $user,
      ]);
  }

}

}