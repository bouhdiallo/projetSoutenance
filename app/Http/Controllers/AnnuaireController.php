<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Annuaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateAnnuaireRequest;
use App\Http\Requests\UpdateAnnuaireRequest;

class AnnuaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            return response()->json([
              'status_code' =>200,
              'status_message' => 'la liste des annuaires a été recuperé',
              'data'=>Annuaire::all()
          ]);

        } catch(Exception $e){
            return response($e)->json($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateAnnuaireRequest $request)
    {
        try {
            $annuaire = new Annuaire();
            
            $annuaire->nom = $request->nom;
            $annuaire->adress = $request->adress;
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);
                $annuaire->images = $filename;  
            }
            $annuaire->couriel = $request->couriel;


            // $annuaire->admin_id=1;
            // dd($annuaire);
            $annuaire->save();
    
            return response()->json([
                'status_code' =>200,
                'status_message' => 'l annuaire a été ajouté avec succes',
                'data'=>$annuaire
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnnuaireRequest $request, $id)
    {
        try {           
            //code qui permet de generer des erreurs
            if( Auth::guard('admin-api')->check())
            {
            $annuaire = Annuaire::findOrFail($id);
            $annuaire->nom = $request->nom;
            $annuaire->adress = $request->adress;
            // $annuaire->image = $request->imaage;
            $annuaire->couriel = $request->couriel;
            // $annuaire->admin_id=1;
            $annuaire->update();
            // dd($annuaire);
        }else{
            return response()->json([
                'status_code'=>422,
                'status_message'=>'Vous n\'etes pas autorisé a faire une modification'
            ]);
        } 
            return response()->json([
                'status_code' =>200,
                'status_message' => 'l annuaire a été modifié',
                'data'=>$annuaire
            ]);
     // code executé en cas d'erreur
           } catch (Exception $e) {
             
             return response()->json($e);
           }
          }
    

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Annuaire $annuaire)
    { 
        try{
            if( Auth::guard('admin-api')->check())
    {  
            $annuaire->delete();
            // dd($annuaire);
    }else{
        return response()->json([
            'status_code'=>422,
            'status_message'=>'Vous n\'etes pas autorisé a faire une suppression'
        ]);
    }
            return response()->json([
              'status_code' =>200,
              'status_message' => 'l annuaire a été supprimé',
              'data'=>$annuaire
          ]);
      }catch(Exception $e){
          return response()->json($e);
      }
  }
}
