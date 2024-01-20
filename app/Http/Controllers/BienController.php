<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateBienRequest;
use App\Http\Requests\UpdateBienRequest;

class BienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         try{

             return response()->json([
               'status_code' =>200,
               'status_message' => 'la liste des biens a été recuperé',
               'data'=>Bien::all()
           ]);

         } catch(Exception $e){
            return response($e)->json($e);
      }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateBienRequest $request)
    {
        try {
            $bien = new Bien();
            
            $bien->nom = $request->nom;
            $bien->caracteristique = $request->caracteristique;
            $bien->contact = $request->contact;

            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);
                $bien->images = $filename;  
            }
            // $bien->statut = $request->statut;

            // $annuaire->admin_id=1;
            $bien->save();
            // dd($bien);

            return response()->json([
                'status_code' =>200,
                'status_message' => 'le bien a été ajouté avec succes',
                'data'=>$bien
            ]);
           } catch (Exception $e) {
             return response()->json($e);
           }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function delete(Bien $bien)
     { 
        try{
             if( Auth::guard('user-api')->check())
     {  
             $bien->delete();
                // dd($bien);
     }else{
         return response()->json([
             'status_code'=>422,
             'status_message'=>'Vous n\'etes pas autorisé a faire une suppression'
        ]);
     }
             return response()->json([
               'status_code' =>200,
               'status_message' => 'le bien a été supprimé',
               'data'=>$bien
          ]);
      }catch(Exception $e){
          return response()->json($e);
       }
  }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBienRequest $request, $id)
    {
         try {           
           //code qui permet de generer des erreurs
          if( Auth::guard('user-api')->check())
            {
            $bien = Bien::findOrFail($id);
            $bien->nom = $request->nom;
            $bien->caracteristique = $request->caracteristique;
            $bien->contact = $request->contact;

            // $bien->image = $request->imaage;
            // $bien->admin_id=1;
             $bien->update();
             // dd($bien);
         }else{
             return response()->json([
                'status_code'=>422,
                'status_message'=>'Vous n\'etes pas autorisé a faire une modification'
             ]);
         } 
             return response()->json([
                'status_code' =>200,
                'status_message' => 'le bien a été modifié',
                'data'=>$bien
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
