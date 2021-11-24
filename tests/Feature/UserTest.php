<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase {

    public function test_users_can_be_created() {
        $user = User::factory(["email" => "other@email.com"])->create();
        $this->assertModelExists($user);
        $this->assertDatabaseHas("users", ["name" => "parspack"]);
    }

    public function test_users_can_be_deleted() {
        $user = User::where("email", "other@email.com")->first();
        $user->delete();
        $this->assertDeleted($user);
    }
}
