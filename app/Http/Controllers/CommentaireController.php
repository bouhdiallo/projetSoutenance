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

            $comment = new Commentaire();
            
             $comment->description = $request->description;
            // $comment->admin_id=1;
            $comment->save();
        }else{
            return response()->json([
                'status_code'=>422,
                'status_message'=>'Vous n\'etes pas autorisé a commenter, veuillez vous authentifier dabord'
            ]);
        }
    
            return response()->json([
                'status_code' =>200,
                'status_message' => 'le commentaire a été enregistré avec succes',
                'data'=>$comment
            ]);
    
           } catch (Exception $e) {
             
             return response()->json($e);
           }
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function delete(Commentaire $comment)
    { 
       try{
            if( Auth::guard('user-api')->check())
    {  
            $comment->delete();
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
              'data'=>$comment
         ]);
     }catch(Exception $e){
         return response()->json($e);
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
           //code qui permet de generer des erreurs
          if( Auth::guard('user-api')->check())
            {
            $comment = Commentaire::findOrFail($id);
            $comment->description = $request->description;
           
             $comment->update();
             // dd($comment);
         }else{
             return response()->json([
                'status_code'=>422,
                'status_message'=>'Vous n\'etes pas autorisé a faire une modification'
             ]);
         } 
             return response()->json([
                'status_code' =>200,
                'status_message' => 'le commentaire a été modifié',
                'data'=>$comment
            ]);
      // code executé en cas d'erreur
            } catch (Exception $e) {
             
             return response()->json($e);
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
