<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Annonce;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class annonceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    
        /** @test */
        public function renvoie_liste_annonce()
        {
            // Assurez-vous qu'il y a des annonces existantes dans la base de données
            $annonce = Annonce::all();
    
            if ($annonce->isEmpty()) {
                $this->fail('Aucune annonce trouvée dans la base de données.');
            }
    
            // Envoi de la requête pour obtenir la liste des annonces
            $response = $this->getJson('/api/liste_annonce');
            // dump($response->getContent());

    
            // Vérifications
            $response->assertStatus(200)
                     ->assertJson([
                        'status_code' =>$response->json('status_code'),
                        'status_message' => $response->json('status_message'),
                        'data'=>$response->json('data'),
                     ]);
        }

        public function test_creation_annonce()
    {
        // Récupérer un utilisateur admin existant dans la base de données
        $admin = User::where('role', 'admin')->first();

        // Assurez-vous qu'un utilisateur admin existe pour le test
        $this->assertNotNull($admin, 'Aucun utilisateur admin trouvé dans la base de données.');

        // Préparation des données de la requête
        $annonceData = [ 

            'description' => 'sdfghj',
            'date_activite' => '2023-02-05',
            'lieu' => 'bhh',
        ];

        // Envoi de la requête pour créer une annonce
        $response = $this->actingAs($admin, 'user-api')
                         ->postJson('/api/annonce/create', $annonceData);

        // Vérifications
        $response->assertStatus(200);
    }

public function test_modif_pour_annonce()
{
    // Récupérer un utilisateur admin existant dans la base de données
    $admin = User::where('role', 'admin')->first();
    //simulons l'authentification d'un utilisateur (methode actingAs)
    $this->actingAs($admin, 'user-api');

    // Assurez-vous qu'un utilisateur admin existe pour le test
    $this->assertNotNull($admin, 'Aucun utilisateur admin trouvé dans la base de données.');

    // Récupérer une annonce existante dans la base de données
    $annonce = Annonce::first();

    // Assurez-vous qu'une annonce existe pour le test
    $this->assertNotNull($annonce, 'Aucune annonce trouvée dans la base de données.');

    // Préparation des données de la requête
    $updatedData = [
        'description' => 'Nouvelle description',
        'date_activite' => '2022-03-01',
        'lieu' => 'Nouveau lieu',
    ];

    // Envoi de la requête pour mettre à jour l'annonce
    $response = $this->postJson('/api/annonce/update/' . $annonce->id, $updatedData);

    // Vérifications
    $response->assertStatus(200);
            //  ->assertJson([
            //     'status_code' => $response->json('status_code'),
            //     'status_message' => $response->json('status_message'),
            

}

public function test_suppression_annonce()
    {
        // Récupérer un utilisateur admin existant dans la base de données
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin, 'user-api');

        // Assurez-vous qu'un utilisateur admin existe pour le test
        $this->assertNotNull($admin, 'Aucun utilisateur admin trouvé dans la base de données.');

        // Récupérer une annonce existante dans la base de données
        $annonce = Annonce::first();

        // Assurez-vous qu'une annonce existe pour le test
        $this->assertNotNull($annonce, 'Aucune annonce trouvée dans la base de données.');

        // Envoi de la requête pour supprimer l'annonce
        $response = $this->deleteJson('/api/annonce/' . $annonce->id);

        // Vérifications
        $response->assertStatus(200);
                //  ->assertJson([
                //     'status_code' => $response->json('status_code'),
                //     'status_message' => $response->json('status_message'),
                //     'data' => $response->json('data')
                //  ]);

    }


}
