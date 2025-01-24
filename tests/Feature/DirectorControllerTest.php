<?php

namespace Tests\Feature;

use App\Models\Director;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;

class DirectorControllerTest extends TestCase
{
    public function test_admin_can_view_directors()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")->get('/api/directors');

        $response->assertStatus(200);
    }

    public function test_moderator_can_view_directors()
    {
        $user = User::factory()->create();
        $user->assignRole('moderator');

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")->get('/api/directors');

        $response->assertStatus(200);
    }

    public function test_reviewer_can_view_directors()
    {
        $user = User::factory()->create();
        $user->assignRole('reviewer');

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")->get('/api/directors');

        $response->assertStatus(200);
    }

    public function test_admin_can_show_director()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $token = $user->createToken('auth_token')->plainTextToken;

        $director = Director::factory()->create();

        $response = $this->withHeader('Authorization', "Bearer $token")->get("/api/directors/$director->id");

        $response->assertStatus(200);
    }

    public function test_moderator_can_show_director()
    {
        $user = User::factory()->create();
        $user->assignRole('moderator');

        $token = $user->createToken('auth_token')->plainTextToken;

        $director = Director::factory()->create();

        $response = $this->withHeader('Authorization', "Bearer $token")->get("/api/directors/$director->id");

        $response->assertStatus(200);
    }

    public function test_reviewer_can_show_director()
    {
        $user = User::factory()->create();
        $user->assignRole('reviewer');

        $token = $user->createToken('auth_token')->plainTextToken;

        $director = Director::factory()->create();

        $response = $this->withHeader('Authorization', "Bearer $token")->get("/api/directors/$director->id");

        $response->assertStatus(200);
    }

    public function test_admin_can_create_director()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $token = $user->createToken('auth_token')->plainTextToken;

        $directorData = Director::factory()->make()->toArray();

        $directorData['image'] = UploadedFile::fake()->image('product.jpg', 1000, 1500);

        $response = $this->withHeader('Authorization', "Bearer $token")->post('/api/directors',  $directorData);

        $response->assertStatus(201);
    }

    public function test_moderator_cant_create_director()
    {
        $user = User::factory()->create();
        $user->assignRole('moderator');

        $token = $user->createToken('auth_token')->plainTextToken;

        $directorData = Director::factory()->make()->toArray();

        $directorData['image'] = UploadedFile::fake()->image('product.jpg', 1000, 1500);

        $response = $this->withHeader('Authorization', "Bearer $token")->post('/api/directors',  $directorData);

        $response->assertStatus(403);
    }

    public function test_reviewer_cant_create_director()
    {
        $user = User::factory()->create();
        $user->assignRole('reviewer');

        $token = $user->createToken('auth_token')->plainTextToken;

        $directorData = Director::factory()->make()->toArray();

        $directorData['image'] = UploadedFile::fake()->image('product.jpg', 1000, 1500);

        $response = $this->withHeader('Authorization', "Bearer $token")->post('/api/directors',  $directorData);

        $response->assertStatus(403);
    }

    public function test_directors_image_is_required()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $token = $user->createToken('auth_token')->plainTextToken;

        $directorData = Director::factory()->make()->toArray();

        $response = $this->withHeader('Authorization', "Bearer $token")->post('/api/directors',  $directorData);

        $response->assertStatus(302);
    }
}
