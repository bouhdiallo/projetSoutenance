<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateAnnonceRequest;
use App\Http\Requests\UpdateAnnonceRequest;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            return response()->json([
              'status_code' =>200,
              'status_message' => 'la liste des annoances a été recuperé',
              'data'=>Annonce::all()
          ]);

        } catch(Exception $e){
            return response($e)->json($e);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateAnnonceRequest $request)
    {
        try {
            $annonce = new Annonce();
            
            $annonce->description = $request->description;
            $annonce->date_activite = $request->date_activite;
            $annonce->lieu = $request->lieu;
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);
                $annonce->images = $filename;  
            }
            //  dd($annonce);

            // $annonce->admin_id=1;
            $annonce->save();
    
            return response()->json([
                'status_code' =>200,
                'status_message' => 'l annonce a été ajouté avec succes',
                'data'=>$annonce
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
    public function update(UpdateAnnonceRequest $request, $id)
    {  
        {
        try {           
            //code qui permet de generer des erreurs
            if( Auth::guard('admin-api')->check())
            {
            $annonce = Annonce::findOrFail($id);
            $annonce->description = $request->description;
            $annonce->date_activite = $request->date_activite;
            $annonce->lieu = $request->lieu;

            // $annonce->admin_id=1;
            $annonce->update();
        }else{
            return response()->json([
                'status_code'=>422,
                'status_message'=>'Vous n\'etes pas autorisé a faire une modification'
            ]);
        } 
            return response()->json([
                'status_code' =>200,
                'status_message' => 'l annonce a été modifié',
                'data'=>$annonce
            ]);
     // code executé en cas d'erreur
           } catch (Exception $e) {
             
             return response()->json($e);
           }
          }
        }
    

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Annonce $annonce)
    { 
        try{
            if( Auth::guard('admin-api')->check())
    {  
            $annonce->delete();
    }else{
        return response()->json([
            'status_code'=>422,
            'status_message'=>'Vous n\'etes pas autorisé a faire une suppression'
        ]);
    }
            return response()->json([
              'status_code' =>200,
              'status_message' => 'l annonce a été supprimé',
              'data'=>$annonce
          ]);
      }catch(Exception $e){
          return response()->json($e);
      }
  }
}
