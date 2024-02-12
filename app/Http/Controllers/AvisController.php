<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Avis;
use Illuminate\Http\Request;
use App\Http\Requests\CreateAvisRequest;

class AvisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
     {
         try{

             return response()->json([
               'status_code' =>200,
            'status_message' => 'la liste des avis a été recuperé',
                'data'=>Avis::all()
            ]);

          } catch(Exception $e){
           return response($e)->json($e);
       }
     }

    /**
     * Show the form for creating a new resource.
     */
public function create(CreateAvisRequest $request)
{
    try {
       

            $avis = new Avis();
            $avis->nom = $request->nom;
            $avis->email = $request->email;
            $avis->message = $request->message;
            $avis->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'L\'avis a été ajouté avec succès',
                'data' =>$avis
            ]);
       
        }
     catch (Exception $e) {
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
