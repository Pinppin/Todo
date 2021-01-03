<?php

namespace Tests\Unit\Database;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{User, Board, BoardUser};

class BoardUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste les colonnes de la table correspondant au modèle BoardUser
     *
     * @return void
     */
    public function testBoardUserTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('board_user', 
                [
                    "id", "user_id", "board_id", 
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
    public function testBoardUserIsSavedInDatabase() {
        $board_user = BoardUser::factory()->create();
        $this->assertDatabaseHas('board_user', $board_user->attributesToArray());
    }


    /**
     * Vérifie que le modèle est bien supprimé de la base de donnée
     *
     * @depends testBoardUserIsSavedInDatabase
     * @return void
     */
    public function testBoardUserIsDeletedFromDatabase() {

        $board_user = BoardUser::factory()->create(); 
        $board_user->delete(); 
        $this->assertDeleted('board_user', $board_user->attributesToArray());
    }
        
    /**
     * Vérifie que la contrainte de clé étrangère pour l'utilisateur est bien prise en compte dans la table liée au modèle BoardUser
     *
     * @return void
     */
    public function testBoardUserDatabaseThrowsIntegrityConstraintExceptionOnNonExistingUserId() 
    {
        $this->expectException("Illuminate\Database\QueryException");
        $this->expectExceptionCode(23000);
        BoardUser::factory()->create(['user_id' =>0]);
    }
    
    /**
     * Vérifie que la contrainte de clé étrangère pour la tâche est bien prise en compte dans la table liée au modèle BoardUser
     *
     * @return void
     */
    public function testBoardUserDatabaseThrowsIntegrityConstraintExceptionOnNonExistingBoardId() 
    {
        $this->expectException("Illuminate\Database\QueryException");
        $this->expectExceptionCode(23000);
        BoardUser::factory()->create(['board_id' =>0]);
    }

    /**
     * Vérifie que la contrainte d'unicité est bien prise en compte dans la table liée au modèle BoardUser
     *
     * @return void
     */
    public function testBoardUserDatabaseThrowsIntegrityConstraintExceptionOnDuplicateEntry() 
    {

        $this->expectException("Illuminate\Database\QueryException");
        $this->expectExceptionCode(23000);
        $user    = User::factory()->create(); 
        $board    = Board::factory()->create(['user_id' => $user->id]);
        $boardUser = BoardUser::factory()->create(['board_id' => $board->id, 'user_id' => $user->id]);
        $boardUser2 = BoardUser::factory()->create(['board_id' => $board->id, 'user_id' => $user->id]);
    }
}