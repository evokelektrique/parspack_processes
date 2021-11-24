<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class EndpointTest extends TestCase {

    use RefreshDatabase;

    private $username;

    public function before() {
        $this->clean_up_folders("evoke");
    }

    public function test_register() {
        // We could use faker here.
        $data = [
            "name" => "other_evoke",
            "email" => "other_email@email.com",
            "password" => "123456789",
            "password_confirmation" => "123456789"
        ];

        $response = $this->postJson("/api/register", $data);
        $response->assertStatus(201);
    }

    public function test_login() {
        // We could use faker here.
        $data = [
            "name" => "other_evoke",
            "password" => "123456789"
        ];

        $response = $this->postJson("/api/login", $data);
        $response->assertStatus(200);
    }

    public function test_user_information() {
        Sanctum::actingAs(
            User::factory()->create(),
            ['simple_token']
        );

        $response = $this->get("/api/user");
        $response->assertStatus(200);
    }

    public function test_list_processes() {
        Sanctum::actingAs(
            User::factory()->create(["name" => "evoke"]),
            ['simple_token']
        );

        $response = $this->get("/api/process");
        $response->assertStatus(200);
    }

    public function test_list_folders() {
        Sanctum::actingAs(
            User::factory()->create(["name" => "evoke"]),
            ['simple_token']
        );

        $response = $this->get("/api/directory");
        $response->assertStatus(200);
    }

    public function test_list_files() {
        Sanctum::actingAs(
            User::factory()->create(["name" => "evoke"]),
            ['simple_token']
        );

        $response = $this->get("/api/directory/files");
        $response->assertStatus(200);
    }

    public function test_create_directory() {

        Sanctum::actingAs(
            User::factory()->create(["name" => "evoke"]),
            ['simple_token']
        );

        $data = ["name" => "test_directory"];
        $response = $this->postJson("/api/directory", $data);
        $response->assertStatus(200);
    }

    public function test_create_file() {
        Sanctum::actingAs(
            User::factory()->create(["name" => "evoke"]),
            ['simple_token']
        );

        $data = ["name" => "test_file.txt"];
        $response = $this->postJson("/api/directory/files", $data);
        $response->assertStatus(200);
    }

    private function clean_up_folders($username) {
        $app_name = env("APP_NAME", "parspack_app");
        $path = "/opt/" . $app_name . "/" . $username . "/";

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }

        rmdir($path);
    }

}
