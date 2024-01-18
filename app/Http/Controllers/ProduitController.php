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

            // $annuaire->admin_id=1;
            $produit->save();
            // dd($produit);

            return response()->json([
                'status_code' =>200,
                'status_message' => 'le produit a été ajouté avec succes',
                'data'=>$produit
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
    public function update(UpdatePrdoduitRequest $request, $id)
    {
         try {           
           //code qui permet de generer des erreurs
          if( Auth::guard('user-api')->check())
            {
             $produit = Produit::findOrFail($id);
            $produit->nom_produit = $request->nom_produit;
            $produit->prix = $request->prix;
            $produit->contact = $request->contact;

            // $produit->image = $request->imaage;
            // $produit->admin_id=1;
             $produit->update();
             // dd($produit);
         }else{
             return response()->json([
                'status_code'=>422,
                'status_message'=>'Vous n\'etes pas autorisé a faire une modification'
             ]);
         } 
             return response()->json([
                'status_code' =>200,
                'status_message' => 'le produit a été modifié',
                'data'=>$produit
            ]);
      // code executé en cas d'erreur
            } catch (Exception $e) {
             
             return response()->json($e);
           }
         }
    

    /**
     * Remove the specified resource from storage.
     */
     public function delete(Produit $produit)
     { 
        try{
             if( Auth::guard('user-api')->check())
     {  
             $produit->delete();
             // dd($produit);
     }else{
         return response()->json([
             'status_code'=>422,
             'status_message'=>'Vous n\'etes pas autorisé a faire une suppression'
        ]);
     }
             return response()->json([
               'status_code' =>200,
               'status_message' => 'le produit a été supprimé',
               'data'=>$produit
          ]);
      }catch(Exception $e){
          return response()->json($e);
       }
  }
     }
