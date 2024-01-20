<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateRessourceRequest;
use App\Http\Requests\UpdateRessourceRequest;

class RessourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         try{

             return response()->json([
               'status_code' =>200,
               'status_message' => 'la liste des ressource a été recuperé',
               'data'=>Ressource::all()
           ]);

         } catch(Exception $e){
            return response($e)->json($e);
      }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateRessourceRequest $request)
    {
        try {
            $ressource = new Ressource();
            
            $ressource->nom = $request->nom;
            $ressource->nature = $request->nature;
            //  dd($ressource);

            // $ressource->admin_id=1;
            $ressource->save();
    
            return response()->json([
                'status_code' =>200,
                'status_message' => 'l ressource a été ajouté avec succes',
                'data'=>$ressource
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
    public function update(UpdateRessourceRequest $request, $id)
    {  
        
        try {           
            //code qui permet de generer des erreurs
            // if( Auth::guard('admin-api')->check())
            
            $ressource = Ressource::findOrFail($id);
            $ressource->nom = $request->nom;
            $ressource->nature = $request->nature;

            // $ressource->admin_id=1;
            $ressource->update();
               
            // return response()->json([
            //     'status_code'=>422,
            //     'status_message'=>'Vous n\'etes pas autorisé a faire une modification'
            // ]);
    
            return response()->json([
                'status_code' =>200,
                'status_message' => 'l ressource a été modifié',
                'data'=>$ressource
            ]);
     // code executé en cas d'erreur
           } catch (Exception $e) {
             
             return response()->json($e);
           }
           }
          
        

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Ressource $ressource)
     { 
        try{
             if( Auth::guard('admin-api')->check())
     {  
             $ressource->delete();
             // dd($produit);
     }else{
         return response()->json([
             'status_code'=>422,
             'status_message'=>'Vous n\'etes pas autorisé a faire une suppression'
        ]);
     }
             return response()->json([
               'status_code' =>200,
               'status_message' => 'la ressource a été supprimé',
               'data'=>$ressource
          ]);
      }catch(Exception $e){
          return response()->json($e);
       }
  }
}
