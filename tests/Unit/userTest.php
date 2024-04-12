<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class userTest extends TestCase
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
// public function test_user_can_login()

// }
public function test_inscription_user()
{

    $user = User::create([
        'nom' => 'ba',
        'prenom' => 'samba',
        'email' => 'user552mara@gmail.com',
        'password' => bcrypt('12345678'),
        'role'=> 'user'
    ]);
 
    // $existingUser = User::where('email', 'astou@gmail.com')->first();


    // Envoi de la requête de connexion
     $response = $this->postJson('/api/userregister');
    
    // Vérifications
    $response->assertStatus(200);
}

public function test_connexion_reussie()
{
 
    $existingUser = User::where('email', 'astou@gmail.com')->first();


    // Envoi de la requête de connexion
    $response = $this->postJson('/api/userlog', [
        'email' => 'astou@gmail.com',
        'password' => 12345678,
    ]);

    // Vérifications
    $response->assertStatus(200);
    // $this->assertArrayHasKey('token', $response->json());
}

public function test_deconnexion_reussie()
{
    // Assurez-vous qu'un utilisateur est authentifié avant de tenter la déconnexion
    $user = User::where('email', 'halima@gmail.com')->first();

    if (!$user) {
        $this->fail('Utilisateur non trouvé dans la base de données');
    }

    auth()->login($user, 'user-api');

    // Envoi de la requête de déconnexion
    $response = $this->postJson('/api/userlogout');

    // Vérifications
    $response->assertStatus(200);
}
}
