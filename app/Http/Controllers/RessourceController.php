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
            // Vérifier si l'utilisateur actuellement authentifié a le rôle "admin"
            if (Auth::guard('user-api')->check() && Auth::guard('user-api')->user()->role === 'admin') {
                 $user = Auth::guard('user-api')->user();
    
                $ressource = new Ressource();
    
                $ressource->nom = $request->nom;
                $ressource->nature = $request->nature;

                $ressource->user_id = $user->id;
                $ressource->save();
    
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'La ressource a été ajouté avec succès',
                    'data' => $ressource
                ]);
            } else {
                return response()->json([
                    'status_code' => 403,
                    'status_message' => 'Vous n\'avez pas les autorisations nécessaires pour créer une ressources en tant qu\'admin'
                ]);
            }
        } catch (Exception $e) {
            return response()->json(['status_code' => 500, 'error' => $e->getMessage()]);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function voirDetailsRessource($id)
{
    try {
        // Recherche du bien par son ID
        $ressource = Ressource::findOrFail($id);

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Détails ressource récupéré avec succès',
            'data' => $ressource
        ]);
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
    public function update(UpdateRessourceRequest $request, $id)
           {
            try {           
                if (Auth::guard('user-api')->check()) {
                    $user = Auth::guard('user-api')->user();
        
                    // Vérifier si l'utilisateur est l'auteur du bien
                    $ressource = Ressource::findOrFail($id);
                    // dd($ressource);
                    if ($ressource->user_id === $user->id && $user->role === 'admin') {
                        $ressource->nom = $request->nom;
                        $ressource->nature = $request->nature;
        
                        $ressource->update();
                        // dd($ressource);
        
                        return response()->json([
                            'status_code' => 200,
                            'status_message' => 'La ressource a été modifiée',
                            'data' => $ressource
                        ]);
                    } else {
                        return response()->json([
                            'status_code' => 403,
                            'status_message' => 'Vous n\'êtes pas autorisé à effectuer une modification sur ce ressource'
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
    public function delete(Ressource $ressource)
     { 
    try {
        if (Auth::guard('user-api')->check()) {
            $user = Auth::guard('user-api')->user();

            // Vérifier si l'utilisateur est l'auteur du annuaire et a le rôle 'admin'
             if ($ressource->user_id === $user->id && $user->role === 'admin') 
            // if ($annuaire->admin_id === $user->id) 
            //    dd($annuaire);
            {
                $ressource->delete();

                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'la ressource a été supprimé',
                    'data' => $ressource
                ]);
            } else {
                return response()->json([
                    'status_code' => 403,
                    'status_message' => 'Vous n\'êtes pas autorisé à effectuer la suppression de ce ressource'
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
 }
