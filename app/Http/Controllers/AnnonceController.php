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
            // Vérifier si l'utilisateur actuellement authentifié a le rôle "admin"
            if (Auth::guard('user-api')->check() && Auth::guard('user-api')->user()->role === 'admin') {
                 $user = Auth::guard('user-api')->user();
    
                 $annonce = new Annonce();
            
                 $annonce->description = $request->description;
                 $annonce->date_activite = $request->date_activite;
                 $annonce->lieu = $request->lieu;

                 if ($request->file('images')) {
                    // dd('ok');
                    $file = $request->file('images');
                    $filename = date('YmdHi') . $file->getClientOriginalName();
                    $file->move(public_path('images'), $filename);
                    $annonce->images = $filename;  
                }
                // dd($annonce);


                $annonce->user_id = $user->id;
                // dd($annonce);

                $annonce->save();
    
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'L\'annonce a été ajouté avec succès',
                    'data' => $annonce
                ]);
            } else {
                return response()->json([
                    'status_code' => 403,
                    'status_message' => 'Vous n\'avez pas les autorisations nécessaires pour créer un annonce en tant qu\'admin'
                ]);
            }
        } catch (Exception $e) {
            return response()->json(['status_code' => 500, 'error' => $e->getMessage()]);
        }
    }
    


    
    // }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

/**
 * Display the details of a specific resource.
 */
public function voirDetailsAnnonce($id)
{
    try {
        // Recherche du bien par son ID
        $annonce = Annonce::findOrFail($id);

        return response()->json([
            'status_code' => 200,
            'status_message' => 'Détails de l\'annonce récupéré avec succès',
            'data' => $annonce
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
    public function update(UpdateAnnonceRequest $request, $id)
    {
        try {           
            if (Auth::guard('user-api')->check()) {
                $user = Auth::guard('user-api')->user();
    
                $annonce = Annonce::findOrFail($id);
    
                // Vérifier si l'utilisateur est l'auteur du annonceaire
                if ($annonce->user_id === $user->id && $user->role === 'admin')  {
                    // dd($annonce);

                    $annonce->description = $request->description;
                    $annonce->date_activite = $request->date_activite;
                    $annonce->lieu = $request->lieu;               
                        //   dd($user);

                    if ($request->file('images')) {
                            // dd('ok');
                            $file = $request->file('images');
                            $filename = date('YmdHi') . $file->getClientOriginalName();
                            $file->move(public_path('images'), $filename);
                            $annonce->images = $filename; 
                         }
    
                    $annonce->update();
    
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'L\'annonce a été modifié',
                        'data' => $annonce
                    ]);
                } else {
                    return response()->json([
                        'status_code' => 403,
                        'status_message' => 'Vous n\'êtes pas autorisé à effectuer une modification sur cette annonce'
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
    public function delete(Annonce $annonce)
    { 
        try {
            if (Auth::guard('user-api')->check()) {
                $user = Auth::guard('user-api')->user();
    
                // Vérifier si l'utilisateur est l'auteur du annuaire et a le rôle 'admin'
                 if ($annonce->user_id === $user->id && $user->role === 'admin') 
                // if ($annuaire->admin_id === $user->id) 
                //    dd($annuaire);
                {
                    $annonce->delete();
    
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'L\'annonce a été supprimé',
                        'data' => $annonce
                    ]);
                } else {
                    return response()->json([
                        'status_code' => 403,
                        'status_message' => 'Vous n\'êtes pas autorisé à effectuer la suppression de cette annonce'
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
