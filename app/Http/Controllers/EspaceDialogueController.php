<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Espace_dialogue;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateEspaceDialogueRequest;
use App\Http\Requests\UpdateEspaceDialogueRequest;

class EspaceDialogueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         try{

             return response()->json([
               'status_code' =>200,
               'status_message' => 'la liste des diiscussions a été recuperé',
               'data'=>Espace_dialogue::all()
           ]);

         } catch(Exception $e){
            return response($e)->json($e);
      }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateEspaceDialogueRequest $request)
      {
            try {
                if( Auth::guard('user-api')->check()) {
                    $user = Auth::guard('user-api')->user();
    
                $discussion = new Espace_dialogue();
                
                 $discussion->contenu = $request->contenu;
                // $discussion->admin_id=1;
                $discussion->user_id = $user->id;
                // $discussion->user_id = $user->id;
    
                $discussion->save();
            }else{
                return response()->json([
                    'status_code'=>422,
                    'status_message'=>'Vous n\'etes pas autorisé a commenter, veuillez vous authentifier dabord'
                ]);
            }
        
                return response()->json([
                    'status_code' =>200,
                    'status_message' => 'le commentaire a été enregistré avec succes',
                    'data'=>$discussion
                ]);
        
               } catch (Exception $e) {
                 
                 return response()->json($e);
               }
              }






    /**
     * Store a newly created resource in storage.
     */
    public function delete(Espace_dialogue $discussion)
    
        { 
            try {
                if (Auth::guard('user-api')->check()) {
                    $user = Auth::guard('user-api')->user();
        
                    // Vérifier si l'utilisateur est l'auteur du bien et a le rôle 'user'
                    // if ($bien->user_id === $user->id && $user->role === 'user') 
                    if ($discussion->user_id === $user->id) 
                    {
                        $discussion->delete();
                        // dd($discussion);
        
                        return response()->json([
                            'status_code' => 200,
                            'status_message' => 'Le discussion a été supprimé',
                            'data' => $discussion
                        ]);
                    } else {
                        return response()->json([
                            'status_code' => 403,
                            'status_message' => 'Vous n\'êtes pas autorisé à effectuer la suppression de ce discussion'
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
    public function update(UpdateEspaceDialogueRequest $request, $id)
    {
        try {           
            if (Auth::guard('user-api')->check()) {
                $user = Auth::guard('user-api')->user();
    
                $discussion = Espace_dialogue::findOrFail($id);
    
                // Vérifier si l'utilisateur est l'auteur du discussionaire
                if ($discussion->user_id === $user->id) {
                    $discussion->contenu = $request->contenu;
                    // dd($user);
    
                    $discussion->update();
    
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'Le discussionaire a été modifié',
                        'data' => $discussion
                    ]);
                } else {
                    return response()->json([
                        'status_code' => 403,
                        'status_message' => 'Vous n\'êtes pas autorisé à effectuer une modification sur ce discussion'
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
