<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Produit;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProduiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function testCreationProduitAvecAuthentication()
{
    // Crée un utilisateur dans la base de données
    $user = User::create([
        'nom' => 'ba',
        'prenom' => 'samba',
        'email' => 'creation1234@gmail.com',
        'password' => bcrypt('12345678'),
    ]);

    // Simule l'authentification de l'utilisateur
    $this->actingAs($user, 'user-api');

    // Crée une requête simulée avec des données spécifiques à votre application
    $requestData = [
        'nom_produit' => 'NomProduit',
        'prix' => 1999,
        'contact' => '778888888',
        'images' => UploadedFile::fake()->image('test_image.jpg'),
    ];

    // Effectue la requête de création de produit
    $response = $this->json('POST', '/api/produit/create', $requestData);

    // Assurez-vous que la réponse est correcte
    $response->assertStatus(200);
        // ->assertJson([
        //     'status_code' => $response->json('status_code'),
        //     'status_message' => $response->json('status_message'),
        //     'data' => $response->json('data')
        // ]);
}

    public function testModificationProduitAvecAuthentication()
{
    // Crée un utilisateur dans la base de données
    $user = User::create([
        'nom' => 'ba',
        'prenom' => 'samba',
        'email' => 'voila1@gmail.com',
        'password' => bcrypt('12345678'),
    ]);

    // Simule l'authentification de l'utilisateur
    $this->actingAs($user, 'user-api');

    // Crée un produit dans la base de données à mettre à jour
    $produit = Produit::create([
        'nom_produit' => 'NomProduitInitial',
        'prix' => 1999,
        'contact' => '778888888',
        'images' => 'C:\Users\simplon\projetSoutenance\public\images\202401181826télécharger (3).jpeg', 
        'user_id' => $user->id,
    ]);

    // Données de mise à jour du produit pour le test
    $updatedProduitData = [
        'nom_produit' => 'NomProduitModifie',
        'prix' => 29.99,
        'contact' => '779999999',
    ];

    // Effectue la requête de mise à jour du produit
    $response = $this->json('POST', "/api/produit/update/{$produit->id}", $updatedProduitData);

    // Assurez-vous que la réponse est correcte
    $response->assertStatus(200)
        ->assertJson([
            'status_code' => $response->json('status_code'),
            'status_message' => $response->json('status_message'),
            'data' => $response->json('data')
        ]);
}

public function testSuppressionProduitAvecAuthentication()
{
    // Crée un utilisateur dans la base de données
    $user = User::create([
        'nom' => 'ba',
        'prenom' => 'samba',
        'email' => 'cocacola1@gmail.com',
        'password' => bcrypt('12345678'),
    ]);

    // Simule l'authentification de l'utilisateur
    $this->actingAs($user, 'user-api');

    // Crée un produit dans la base de données à supprimer
    $produit = Produit::create([
        'nom_produit' => 'lampe solaire',
        'prix' => 2999,
        'contact' => '779999999',
        'images' => 'C:\Users\simplon\projetSoutenance\public\images\202401181826télécharger (3).jpeg',
        'user_id' => $user->id,
    ]);

    // Effectue la requête de suppression du produit
    $response = $this->json('DELETE', "/api/delete/{$produit->id}");

    // Assurez-vous que la réponse est correcte
    $response->assertStatus(200)
        ->assertJson([
            'status_code' => $response->json('status_code'),
            'status_message' => $response->json('status_message'),
            'data' => $response->json('data')
        ]);
} 



public function testListeProduit()
{
    // Crée quelques produits dans la base de données pour le test
    Produit::create([
        'nom_produit' => 'Produit1',
        'prix' => 2899,
        'contact' => '771111111',
        'images' => 'C:\Users\simplon\projetSoutenance\public\images\202401271423télécharger (1).jpeg',
    ]);

    Produit::create([
        'nom_produit' => 'Produit2',
        'prix' => 2999,
        'contact' => '772222222',
        'images' => 'C:\Users\simplon\projetSoutenance\public\images\202401181827télécharger (3).jpeg', 
    ]);

    // Effectue la requête pour récupérer la liste des produits sans authentification
    $response = $this->json('GET', '/api/listes_produit');

    // Assurez-vous que la réponse est correcte
    $response->assertStatus(200)
        ->assertJsonStructure([
            'status_code',
            'status_message',
            'data' => [
                '*' => [
                    'nom_produit',
                    'prix',
                    'contact',
                    'images'
                ],
            ],
        ]);

    
}


}