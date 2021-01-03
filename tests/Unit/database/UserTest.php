<?php

namespace Tests\Unit\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use App\Models\{User, Comment, Attachment, TaskUser, Board, BoardUser};

class UserTest extends TestCase
{
    use RefreshDatabase;

    //----------- Database Testing --------------//
    
    /**
     * Teste les colonnes de la table correspondant au modèle User
     *
     * @return void
     */
    public function testUserTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('users', 
                [
                    "id", "name", "email", "email_verified_at", "password",
                    "created_at", "updated_at"
                ]
            ), 1
        );
    }

    /**
     * Vérifie que le modèle est bien sauvé dans la base de donnée
     * 
     * @return void
     */
    public function testUserIsSavedInDatabase() {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', $user->attributesToArray());
    }

    /**
     * Vérifie qu'un utilisateur peut être supprimé, même s'il est réferencé par d'autres modèles
     * 
     * @depends testUserIsSavedInDatabase
     * @return void
     */
    public function testUserIsDeletedFromDatabase() {

        $user = User::factory()->create(); 
        Board::factory()->create(["user_id" => $user->id]);
        Attachment::factory()->create(["user_id" => $user->id]);
        Comment::factory()->create(["user_id" => $user->id]);
        BoardUser::factory()->create(["user_id" => $user->id]);
        TaskUser::factory()->create(["user_id" => $user->id]);

        $user->delete(); 
        $this->assertDeleted($user);
    }

 
}
