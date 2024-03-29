<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LogUserRequest;
use App\Http\Requests\registerRequest;
use App\Notifications\UserRegisterMail;

class UserController extends Controller
{
    //
    public function userregister(registerRequest $request)
    {
      try {
        $user = new User();
        
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;

         $user->save();
      //   if($user->save()){

      //     $user->notify(new UserRegisterMail());
      //     // dd($user);
      // }
        return response()->json([
          'status_code' => 200,
          'status_message' => 'Insertion reussi',
          'data' => $user
      ]);
  }catch(\Exception $e){
    return response()->json(['error' => $e->getMessage()]);
  }
     }

    public function userlog(LogUserRequest $request)
{
    // credentiels contient les infos d'identification extraites de la requête 
    $credentials = request(['email', 'password']);

    // cas où l'authentification a échoué
    //attempt() est utilisée pour tenter d'authentifier un utilisateur
    if (! $token = auth()->guard('user-api')->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // récupérer l'objet utilisateur
    $user = auth()->guard('user-api')->user();

    // retourner le token et l'objet utilisateur
    return response()->json(['token' => $token, 'user' => $user]);
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
            //auth()fonction qui permet d'accéder à l'instance du gestionnaire d'authentification
             auth()->guard('user-api')->logout();
    
             return response()->json(['message' => 'Successfully logged out']);
         }

//         public function userlogout()
// {
//     auth('user-api')->logout();

//     return response()->json(['message' => 'Déconnexion réussie']);
// }

public function index()
{
    try{

        return response()->json([
          'status_code' =>200,
          'status_message' => 'la liste des utilisateurs a été recuperé',
           'data'=>User::all()
      ]);

    } catch(Exception $e){
        return response($e)->json($e);
    }
} 


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

// public function refresh()    
//      { 
//        $user = auth()->user();        
//       return $this->respondWithToken(auth()->refresh(), $user);     
//      }


    
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }




}