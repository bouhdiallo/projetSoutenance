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
        if (Auth::guard('user-api')->check()) {
            $user = Auth::guard('user-api')->user();

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
            $bien->statut = $request->statut;

            // Assurez-vous d'associer le bien à l'utilisateur actuellement authentifié
            $bien->user_id = $user->id;

            $bien->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le bien a été ajouté avec succès',
                'data' => $bien
            ]);
        } else {
            return response()->json([
                'status_code' => 401,
                'status_message' => 'Vous devez être authentifié pour créer un bien'
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

public function delete(Bien $bien)
{ 
    try {
        if (Auth::guard('user-api')->check()) {
            $user = Auth::guard('user-api')->user();
            //  dd($user);
            // Vérifier si l'utilisateur est l'auteur du bien et a le rôle 'user'
            // if ($bien->user_id === $user->id && $user->role === 'user') 
            if ($bien->user_id === $user->id) 
            {
                $bien->delete();

                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Le bien a été supprimé',
                    'data' => $bien
                ]);
            } else {
                return response()->json([
                    'status_code' => 403,
                    'status_message' => 'Vous n\'êtes pas autorisé à effectuer la suppression de ce bien'
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

public function update(UpdateBienRequest $request, $id)
{
    try {           
        if (Auth::guard('user-api')->check()) {
            $user = Auth::guard('user-api')->user();

            // Vérifier si l'utilisateur est l'auteur du bien
            $bien = Bien::findOrFail($id);
            if ($bien->user_id === $user->id && $user->role === 'user') 
            // if ($annuaire->admin_id === $user->id && $user->role === 'admin') 
            {
                $bien->nom = $request->nom;
                $bien->caracteristique = $request->caracteristique;
                $bien->contact = $request->contact;

                    if ($request->file('image')) {
                        $file = $request->file('image');
                        $filename = date('YmdHi') . $file->getClientOriginalName();
                        $file->move(public_path('images'), $filename);
                        $bien->images = $filename;

                }

                // $bien->image = $request->imaage;
                // $bien->admin_id=1;
                $bien->update();

                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Le bien a été modifié',
                    'data' => $bien
                ]);
            } else {
                return response()->json([
                    'status_code' => 403,
                    'status_message' => 'Vous n\'êtes pas autorisé à effectuer une modification sur ce bien'
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
     * Update the specified resource in storage.
     */
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
