<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateCommentaireRequest;
use App\Http\Requests\UpdateCommentaireRequest;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         try{

             return response()->json([
               'status_code' =>200,
               'status_message' => 'la liste des commentaires a été recuperé',
               'data'=>Commentaire::all()
           ]);

         } catch(Exception $e){
            return response($e)->json($e);
      }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateCommentaireRequest $request)
    {
        try {
            if( Auth::guard('user-api')->check()) {
                $user = Auth::guard('user-api')->user();

            $commentaire = new Commentaire();
            
             $commentaire->description = $request->description;
            // $commentaire->admin_id=1;
            $commentaire->user_id = $user->id;
            // $commentaire->user_id = $user->id;
            $commentaire->annonce_id = $request->annonce_id;


            $commentaire->save();
        }else{
            return response()->json([
                'status_code'=>422,
                'status_message'=>'Vous n\'etes pas autorisé a commenter, veuillez vous authentifier dabord'
            ]);
        }
    
            return response()->json([
                'status_code' =>200,
                'status_message' => 'le commentaire a été enregistré avec succes',
                'data'=>$commentaire
            ]);
    
           } catch (Exception $e) {
             
             return response()->json($e);
           }
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function delete(Commentaire $commentaire)
   
    { 
        try {
            if (Auth::guard('user-api')->check()) {
                $user = Auth::guard('user-api')->user();
                  dd($commentaire->user_id, $user->id);

                // Vérifier si l'utilisateur est l'auteur du bien et a le rôle 'user'
                if ($commentaire->user_id === $user->id ) 
                {
                     $commentaire->delete();

                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'Le commentaire a été supprimé',
                        'data' => $commentaire
                    ]);
                } else {
                    return response()->json([
                        'status_code' => 403,
                        'status_message' => 'Vous n\'êtes pas autorisé à effectuer la suppression de ce commentaire'
                    ]);
                }
            } else {
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'Vous n\'êtes pas autorisé à effectuer la suppression'
                ]);
            }
        } catch (Exception $e) {
            return response()->json(['status_code' => 500, 'error' => $e->getMessage()]);
        }
    }
    
  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentaireRequest $request, $id)
{
    try {           
        if (Auth::guard('user-api')->check()) {
            $user = Auth::guard('user-api')->user();

            $commentaire = Commentaire::findOrFail($id);

            // Vérifier si l'utilisateur est l'auteur du commentaire
            if ($commentaire->user_id === $user->id) {
                $commentaire->description = $request->description;
                // dd($user);

                $commentaire->update();

                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Le commentaire a été modifié',
                    'data' => $commentaire
                ]);
            } else {
                return response()->json([
                    'status_code' => 403,
                    'status_message' => 'Vous n\'êtes pas autorisé à effectuer une modification sur ce commentaire'
                ]);
            }
        } else {
            return response()->json([
                'status_code' => 422,
                'status_message' => 'Vous n\'êtes pas autorisé à effectuer une modification'
            ]);
        }
    } catch (Exception $e) {
        return response()->json(['status_code' => 500, 'error' => $e->getMessage()]);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
