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
        if($user->save()){

          $user->notify(new UserRegisterMail());
          // dd($user);
      }
        return response()->json([
          'status_code' => 200,
          'status_message' => 'Insertion reussi',
          'data' => $user
      ]);
  }catch(\Exception $e){
    return response()->json(['error' => $e->getMessage()]);
  }
     }

    //  public function userlog(Request $request){

    //     // credentiels contient les infos d'identification extraite de la requete 
    //     $credentials = request(['email', 'password']);

    //     //cas ou l'authentification a echoué
    //     if (! $token = auth()->guard('user-api')->attempt($credentials)) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }

    //     return $token;
    //     }


    public function userlog(LogUserRequest $request)
{
    // credentiels contient les infos d'identification extraites de la requête 
    $credentials = request(['email', 'password']);

    // cas où l'authentification a échoué
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
}