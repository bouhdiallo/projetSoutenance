<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Annuaire;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class annuaireTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
    public function test_renvoi_liste_annuaire()
    {
        // Assurez-vous qu'il y a des annonces existantes dans la base de données
        $annuaire = Annuaire::all();

        if ($annuaire->isEmpty()) {
            $this->fail('Aucune annuaire trouvée dans la base de données.');
        }

        // Envoi de la requête pour obtenir la liste des annonces
        $response = $this->getJson('/api/listes_annuaires');
        // dump($response->getContent());


        // Vérifications
        $response->assertStatus(200)
                 ->assertJson([
                    'status_code' =>$response->json('status_code'),
                    'status_message' => $response->json('status_message'),
                    'data'=>$response->json('data'),
                 ]);
    }

    public function test_creation_annuaire()
    {
        // Récupérer un utilisateur admin existant dans la base de données
        $admin = User::where('role', 'admin')->first();

        // Assurez-vous qu'un utilisateur admin existe pour le test
        $this->assertNotNull($admin, 'Aucun utilisateur admin trouvé dans la base de données.');

        // Préparation des données de la requête
        $annuaireData = [ 

            'nom' => 'sdfghj',
            'adress' => '2023-02-05',
            'images' => '',
            'couriel' => 'ff'
            // Ajoutez d'autres champs de données selon vos besoins
        ];

        // Envoi de la requête pour créer une annonce
        $response = $this->actingAs($admin, 'user-api')
                         ->postJson('/api/annuaire/create', $annuaireData);

        // Vérifications
        $response->assertStatus(200);
                //  ->assertJson([
}

public function test_modification_annuaire()
{
    // Récupérer un utilisateur admin existant dans la base de données
    $admin = User::where('role', 'admin')->first();
    $this->actingAs($admin, 'user-api');

    // Assurez-vous qu'un utilisateur admin existe pour le test
    $this->assertNotNull($admin, 'Aucun utilisateur admin trouvé dans la base de données.');

    // Récupérer une annonce existante dans la base de données
    $annuaire = Annuaire::first();

    // Assurez-vous qu'une annuaire existe pour le test
    $this->assertNotNull($annuaire, 'Aucune annuaire trouvée dans la base de données.');

    // Préparation des données de la requête
    $updatedData = [
        'description' => 'Nouvelle description',
        'date_activite' => '2022-03-01',
        'lieu' => 'Nouveau lieu',
    ];

    // Envoi de la requête pour mettre à jour l'annuaire
    $response = $this->putJson('/api/annuaire/update/' . $annuaire->id, $updatedData);

    // Vérifications
    $response->assertStatus(200);
            //  ->assertJson([
            //     'status_code' => $response->json('status_code'),
            //     'status_message' => $response->json('status_message'),
 }

 public function test_suppression_annuaire()
    {
        // Récupérer un utilisateur admin existant dans la base de données
        $admin = User::where('role', 'admin')->first();
        $this->actingAs($admin, 'user-api');

        // Assurez-vous qu'un utilisateur admin existe pour le test
        $this->assertNotNull($admin, 'Aucun utilisateur admin trouvé dans la base de données.');

        // Récupérer une annonce existante dans la base de données
        $annuaire = Annuaire::first();

        // Assurez-vous qu'une annuaire existe pour le test
        $this->assertNotNull($annuaire, 'Aucune annuaire trouvée dans la base de données.');

        // Envoi de la requête pour supprimer l'annuaire
        $response = $this->deleteJson('/api/annuaire/' . $annuaire->id);

        // Vérifications
        $response->assertStatus(200);
                //  ->assertJson([
                //     'status_code' => $response->json('status_code'),
                //     'status_message' => $response->json('status_message'),
                //     'data' => $response->json('data')
                //  ]);

        // Vérifier que l'annonce a été correctement supprimée de la base de données
        // $this->assertDatabaseMissing('annonces', ['id' => $annonce->id]);
    }

}
