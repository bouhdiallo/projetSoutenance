<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ressource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RessourceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function test_renvoie_liste_ressource()
    {
        // Assurez-vous qu'il y a des annonces existantes dans la base de données
        $annonce = Ressource::all();

        if ($annonce->isEmpty()) {
            $this->fail('Aucune ressource trouvée dans la base de données.');
        }

        // Envoi de la requête pour obtenir la liste des annonces
        $response = $this->getJson('/api/liste_ressource');
        // dump($response->getContent());


        // Vérifications
        $response->assertStatus(200)
                 ->assertJson([
                    'status_code' =>$response->json('status_code'),
                    'status_message' => $response->json('status_message'),
                    'data'=>$response->json('data'),
                 ]);
    }

    public function testCreationRessource()
{
    // Crée un utilisateur administrateur dans la base de données
    $admin = User::create([
        'nom' => 'faye',
        'prenom' => 'alou',
        'email' => 'aocddlou@gmail.com',
        'password' => bcrypt('12345678'),
        'role' => 'admin',
    ]);

    // Simule l'authentification de l'utilisateur administrateur
    $this->actingAs($admin, 'user-api');

    // Crée une requête simulée avec des données spécifiques à votre application
    $requestData = [
        'nom' => 'sante',
        'nature' => 'relatif a la sante',
    ];

    // Effectue la requête de création de ressource
    $response = $this->json('POST', '/api/ressource/create', $requestData);

    // Assurez-vous que la réponse est correcte pour un administrateur
    $response->assertStatus(200);
   
}

public function testUpdateRessourceEnTantQuAdmin()
    {
        // Crée un utilisateur administrateur dans la base de données
        $admin = User::create([
            'nom' => 'Admin',
            'prenom' => 'Admin',
            'email' => 'aradmisn5@gmail.com',
            'password' => bcrypt('1234678'),
            'role' => 'admin',
        ]);

        // Crée une ressource dans la base de données
        $ressource = Ressource::create([
            'nom' => 'sante',
            'nature' => 'sanitaire',
            // autres champs nécessaires
        ]);

        // Simule l'authentification de l'utilisateur administrateur
        $this->actingAs($admin, 'user-api');

        // Effectue la requête de modification de la ressource
        $response = $this->json('PUT', "/api/ressource/update/{$ressource->id}", [
            'nom' => 'educatif',
            'nature' => 'education',
            // autres champs nécessaires
        ]);

        // Assurez-vous que la réponse est correcte pour un administrateur
        $response->assertStatus(200);
            // ->assertJson([
            //     'status_code' => 200,
            //     'status_message' => 'La ressource a été modifiée',
            //     'data' => [
            //         'nom' => 'educatif',
            //         'nature' => 'education',
            //     ],
            // ]);
 }
        }