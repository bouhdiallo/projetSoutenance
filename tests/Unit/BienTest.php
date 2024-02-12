<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Bien;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BienTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function test_creation_bien_avec_authentication()
    {
        // Crée un utilisateur dans la base de données
        $user = User::create([
            'nom' => 'ba',
            'prenom' => 'samba',
            'email' => 'sdghdjk@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        // Simule l'authentification de l'utilisateur
        $this->actingAs($user, 'user-api');

        // Crée une requête simulée avec des données spécifiques à votre application
        $requestData = [
            'nom' => 'NomBien',
            'caracteristique' => 'Caractéristiques du Bien',
            'contact' => '778888888',
            'image' => UploadedFile::fake()->image('test_image.jpg'),
            'statut' => 'perdu',
        ];

        // Effectue la requête de création de bien
        $response = $this->json('POST', '/api/bien/create', $requestData);

        // Assurez-vous que la réponse est correcte
        $response->assertStatus(200)

        
             ->assertJson([

                'status_code' => $response->json('status_code'),
                'status_message' => $response->json('status_message'),
                'data' => $response->json('data')
               ]);   
    }


    public function testUpdateBienAvecAuthentication()
    {
        // Crée un utilisateur dans la base de données
        $user = User::create([
            'nom' => 'ba',
            'prenom' => 'samba',
            'email' => 'adxdfa@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        // Simule l'authentification de l'utilisateur
        $this->actingAs($user, 'user-api');

        // Crée un bien dans la base de données associé à l'utilisateur
        $bien = Bien::create([
            'nom' => 'NomBien',
            'caracteristique' => 'Caractéristiques du Bien',
            'contact' => '778888888',
            'images' => 'test_image.jpg',
            'statut' => 'perdu',
            'user_id' => $user->id,
        ]);

        // Crée une requête simulée avec des données de mise à jour
        $requestData = [
            'nom' => 'NouveauNom',
            'caracteristique' => 'Nouvelles Caractéristiques',
            'contact' => '999999999',
            'image' => UploadedFile::fake()->image('new_test_image.jpg'),
            'statut' => 'trouvé',
        ];

        // Effectue la requête de mise à jour du bien
        $response = $this->json('POST', '/api/bien/update/' . $bien->id, $requestData);  

        // Assurez-vous que la réponse est correcte
        $response->assertStatus(200);
        
            
        // Nettoyons la base de données après le test
         $bien->delete();
         $user->delete();
    }



    public function test_suppression_bien_avec_authentication()
    {
        // Crée un utilisateur dans la base de données
        $user = User::create([
            'nom' => 'ba',
            'prenom' => 'samba',
            'email' => 'kirddgikou@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        // Simule l'authentification de l'utilisateur
        $this->actingAs($user, 'user-api');

        // Crée un bien dans la base de données associé à l'utilisateur
        $bien = Bien::create([
            'nom' => 'NomBien',
            'caracteristique' => 'Caractéristiques du Bien',
            'contact' => '778888888',
            'images' => 'test_image.jpg',
            'statut' => 'perdu',
            'user_id' => $user->id,
        ]);

        // Effectue la requête de suppression du bien
        $response = $this->json('DELETE', '/api/bien/delete/' . $bien->id);
        // Assurez-vous que la réponse est correcte
        $response->assertStatus(200)
            ->assertJson([
                'status_code' => 200,
                'status_message' => 'Le bien a été supprimé',
            ]);

        // Facultatif : Nettoyez la base de données après le test
        $user->delete();
    }


    public function test_listage_bien()
    {
        // Crée quelques biens dans la base de données
        $bien1 = Bien::create([
            'nom' => 'NomBien1',
            'caracteristique' => 'Caractéristiques du Bien 1',
            'contact' => '778888888',
            'images' => 'test_image1.jpg',
            'statut' => 'perdu',
        ]);

        $bien2 = Bien::create([
            'nom' => 'NomBien2',
            'caracteristique' => 'Caractéristiques du Bien 2',
            'contact' => '779999999',
            'images' => 'test_image2.jpg',
            'statut' => 'retrouver',
        ]);

        // Effectue la requête de l'index des biens
        $response = $this->json('GET', '/api/listes_bien');

        // Assurez-vous que la réponse est correcte
        $response->assertStatus(200)
            ->assertJson([
                'status_code' => 200,
                'status_message' => 'la liste des biens a été recuperé',
                // Assurez-vous que les données de bien sont correctes
            ]);

      

        //Nettoyons la base de données après le test
        $bien1->delete();
        $bien2->delete();
    }



}
