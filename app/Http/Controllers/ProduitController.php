<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreatePrdoduitRequest;
use App\Http\Requests\UpdatePrdoduitRequest;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         try{

             return response()->json([
               'status_code' =>200,
               'status_message' => 'la liste des produits a été recuperé',
               'data'=>Produit::all()
           ]);

         } catch(Exception $e){
            return response($e)->json($e);
      }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreatePrdoduitRequest $request)
    {
        try {
            if (Auth::guard('user-api')->check()) {
                $user = Auth::guard('user-api')->user();
    
                $produit = new Produit();
                $produit->nom_produit = $request->nom_produit;
                $produit->prix = $request->prix;
                $produit->contact = $request->contact;
    
                if ($request->file('image')) {
                    $file = $request->file('image');
                    $filename = date('YmdHi') . $file->getClientOriginalName();
                    $file->move(public_path('images'), $filename);
                    $produit->images = $filename;  
                }
    
                // Assurez-vous d'associer le produit à l'utilisateur actuellement authentifié
                $produit->user_id = $user->id;
    
                $produit->save();
    
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Le produit a été ajouté avec succès',
                    'data' => $produit
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrdoduitRequest $request, $id)
    {
        try {           
            if (Auth::guard('user-api')->check()) {
                $user = Auth::guard('user-api')->user();
                // dd($user);

                // Vérifier si l'utilisateur est l'auteur du bien
                $produit = Produit::findOrFail($id);
                if ($produit->user_id === $user->id) {
                    $produit->nom_produit = $request->nom_produit;
                    $produit->prix = $request->prix;
                    $produit->contact = $request->contact;

                     // Gestion de l'image
                     if ($request->file('image')) {
                        $file = $request->file('image');
                        $filename = date('YmdHi') . $file->getClientOriginalName();
                        $file->move(public_path('images'), $filename);
                        $produit->images = $filename;  
                    }

                    // $produit->image = $request->imaage;
                    // $produit->admin_id=1;
                    $produit->update();
                    // dd($produit);
    
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'Le produit a été modifié',
                        'data' => $produit
                    ]);
                } else {
                    return response()->json([
                        'status_code' => 403,
                        'status_message' => 'Vous n\'êtes pas autorisé à effectuer une modification sur ce produit'
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
     public function delete(Produit $produit)
     { 
        try {
            if (Auth::guard('user-api')->check()) {
                $user = Auth::guard('user-api')->user();

                // Vérifier si l'utilisateur est l'auteur du bien et a le rôle 'user'
                // if ($produit->user_id === $user->id && $user->role === 'user')
                if ($produit->user_id === $user->id)

                 {
                    $produit->delete();
    
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'Le produit a été supprimé',
                        'data' => $produit
                    ]);
                } else {
                    return response()->json([
                        'status_code' => 403,
                        'status_message' => 'Vous n\'êtes pas autorisé à effectuer la suppression de ce produit'
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
