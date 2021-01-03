<?php

namespace Tests\Unit\Database;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use App\Models\{ User, Board, Task, BoardUser};
use Illuminate\Foundation\Testing\RefreshDatabase;

class BoardTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Teste les colonnes de la table correspondant au modèle Board
     *
     * @return void
     */
    public function testBoardTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('boards', ["id", "title", "description", "user_id", "created_at", "updated_at"]), 1
        );
    }

    /**
     * Vérifie que le modèle est bien sauvé dans la base de donnée
     * 
     * @return void
     */
    public function testBoardIsSavedInDatabase() {
        $board = Board::factory()->create();
        $this->assertDatabaseHas('boards', $board->attributesToArray());
    }

    /**
     * Vérifie qu'un board peut être supprimée, même si elle est réferencée par d'autres modèles
     *
     * @depends testBoardIsSavedInDatabase
     * @return void
     */
    public function testBoardIsDeletedFromDatabase() {

        $board = Board::factory()->create(); 
        BoardUser::factory()->create(["board_id" => $board->id]);
        Task::factory()->create(["board_id" => $board->id]);
        $board->delete(); 
        $this->assertDeleted($board);
    }
    
    /**
     * Vérifie que la contrainte de clé étrangère pour l'utilisateur est bien prise en compte dans la table liée au modèle Board
     *
     * @return void
     */
    public function testBoardDatabaseThrowsIntegrityConstraintExceptionOnNonExistingUserId() 
    {
        $this->expectException("Illuminate\Database\QueryException");
        $this->expectExceptionCode(23000);
        Board::factory()->create(['user_id' =>0]);
    }
      
}
