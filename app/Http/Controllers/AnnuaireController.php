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
    // {
    //     try {
    //         if (Auth::guard('user-api')->check()) {
    //             $user = Auth::guard('user-api')->user();
    
    //             $bien = new Bien();
    //             $bien->nom = $request->nom;
    //             $bien->caracteristique = $request->caracteristique;
    //             $bien->contact = $request->contact;
    
    //             if ($request->file('image')) {
    //                 $file = $request->file('image');
    //                 $filename = date('YmdHi') . $file->getClientOriginalName();
    //                 $file->move(public_path('images'), $filename);
    //                 $bien->images = $filename;  
    //             }
    
    //             // Assurez-vous d'associer le bien à l'utilisateur actuellement authentifié
    //             $bien->user_id = $user->id;
    
    //             $bien->save();
    
    //             return response()->json([
    //                 'status_code' => 200,
    //                 'status_message' => 'Le bien a été ajouté avec succès',
    //                 'data' => $bien
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status_code' => 401,
    //                 'status_message' => 'Vous devez être authentifié pour créer un bien'
    //             ]);
    //         }
    //     } catch (Exception $e) {
    //         return response()->json(['status_code' => 500, 'error' => $e->getMessage()]);
    //     }
    // }





    public function create(CreateAnnuaireRequest $request)
 {
    try {
        // Vérifier si l'utilisateur actuellement authentifié a le rôle "admin"
        if (Auth::guard('user-api')->check() && Auth::guard('user-api')->user()->role === 'admin') {
             $user = Auth::guard('user-api')->user();

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
            $annuaire->user_id = $user->id;
            $annuaire->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'L\'annuaire a été ajouté avec succès',
                'data' => $annuaire
            ]);
        } else {
            return response()->json([
                'status_code' => 403,
                'status_message' => 'Vous n\'avez pas les autorisations nécessaires pour créer un annuaire en tant qu\'admin'
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
            if (Auth::guard('user-api')->check()) {
                $user = Auth::guard('user-api')->user();
    
                // Vérifier si l'utilisateur est l'auteur du bien
                $annuaire = Annuaire::findOrFail($id);
                // dd($annuaire);
                if ($annuaire->user_id === $user->id && $user->role === 'admin') {
                    $annuaire->nom = $request->nom;
                    $annuaire->adress = $request->adress;
                    $annuaire->couriel = $request->couriel;
    
                    // $annuaire->image = $request->imaage;
                    // $annuaire->admin_id=1;
                    $annuaire->update();
    
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'Le annuaire a été modifié',
                        'data' => $annuaire
                    ]);
                } else {
                    return response()->json([
                        'status_code' => 403,
                        'status_message' => 'Vous n\'êtes pas autorisé à effectuer une modification sur ce annuaire'
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
    public function delete(Annuaire $annuaire)
  { 
    try {
        if (Auth::guard('user-api')->check()) {
            $user = Auth::guard('user-api')->user();

            // Vérifier si l'utilisateur est l'auteur du annuaire et a le rôle 'admin'
             if ($annuaire->user_id === $user->id && $user->role === 'admin') 
            // if ($annuaire->admin_id === $user->id) 
            //    dd($annuaire);
            {
                $annuaire->delete();

                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'L\'annuaire a été supprimé',
                    'data' => $annuaire
                ]);
            } else {
                return response()->json([
                    'status_code' => 403,
                    'status_message' => 'Vous n\'êtes pas autorisé à effectuer la suppression de ce annuaire'
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
