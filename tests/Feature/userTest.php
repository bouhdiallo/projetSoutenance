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
// {
//     // Utiliser un utilisateur existant dans la base de données
//     $existingUser = User::where('email', 'astou@gmail.com')->first();

//     // Appeler la fonction userlog avec les identifiants de l'utilisateur existant
//     $response = $this->post(route('userlog'), [
//         'email' => $existingUser->email,
//         'password' => '12345678',
//     ]);

//     // dd($response->json());

//     // Vérifier que la réponse contient un jeton
//     $response->assertStatus(200);
//     $this->assertAuthenticatedAs($existingUser, 'api');
// }

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
    $user = User::where('email', 'astou@gmail.com')->first();

    if (!$user) {
        $this->fail('Utilisateur non trouvé dans la base de données');
    }

    auth()->login($user, 'user-api');

    // Envoi de la requête de déconnexion
    $response = $this->postJson('/api/userlogout');

    // Vérifications
    $response->assertStatus(200);
    $this->assertArrayHasKey('message', $response->json());
    $this->assertEquals('Successfully logged out', $response->json()['message']);
}


}
