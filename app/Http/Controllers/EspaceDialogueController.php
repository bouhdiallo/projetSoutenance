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

            $discussion = new Espace_dialogue();
            
             $discussion->contenu = $request->contenu;
            // $comment->admin_id=1;
            $discussion->save();
        }else{
            return response()->json([
                'status_code'=>422,
                'status_message'=>'Vous n\'etes pas autorisé a participer a cette discussion, veuillez vous authentifier dabord'
            ]);
        }
    
            return response()->json([
                'status_code' =>200,
                'status_message' => 'la discussion a été enregistré avec succes',
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
       try{
            if( Auth::guard('user-api')->check())
    {  
            $discussion->delete();
               // dd($comment);
    }else{
        return response()->json([
            'status_code'=>422,
            'status_message'=>'Vous n\'etes pas autorisé a faire une suppression'
       ]);
    }
            return response()->json([
              'status_code' =>200,
              'status_message' => 'le commentaire a été supprimé',
              'data'=>$discussion
         ]);
     }catch(Exception $e){
         return response()->json($e);
      }
 }
    /**
     * Display the specified resource.
     */
    public function update(UpdateEspaceDialogueRequest $request, $id)
    {
         try {           
           //code qui permet de generer des erreurs
          if( Auth::guard('user-api')->check())
            {
            $discussion = Espace_dialogue::findOrFail($id);
            $discussion->contenu = $request->contenu;
           
             $discussion->update();
             // dd($discussion);
         }else{
             return response()->json([
                'status_code'=>422,
                'status_message'=>'Vous n\'etes pas autorisé a faire une modification'
             ]);
         } 
             return response()->json([
                'status_code' =>200,
                'status_message' => 'la discussion a été modifié',
                'data'=>$discussion
            ]);
      // code executé en cas d'erreur
            } catch (Exception $e) {
             
             return response()->json($e);
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
