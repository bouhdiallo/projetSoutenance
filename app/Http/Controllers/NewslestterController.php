<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use App\Notifications\MailNewsletter;
use App\Http\Requests\StoreNewsletterRequest;

class NewslestterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         try{

             return response()->json([
               'status_code' =>200,
               'status_message' => 'la liste des emails a été recuperé',
               'data'=>Newsletter::all()
           ]);

         } catch(Exception $e){
            return response($e)->json($e);
      }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsletterRequest $request)
    {
        try {
            $newsletter = new Newsletter();
            // dd($newsletter);
            $newsletter->email = $request->email;
            if ($newsletter->save()) {
                $newsletter->notify(new MailNewsletter());
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Newsletter enregistrer avec success',
                    'data' => $newsletter
                ]);
                // dd($newsletter);

            } else {
                return abort('403');
            }
        } catch (\Exception $e) {

            return response()->json($e);
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
