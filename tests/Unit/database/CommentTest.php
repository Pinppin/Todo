<?php

namespace Tests\Unit\Database;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use App\Models\{Comment};
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{


    use RefreshDatabase;

    /**
     * Teste les colonnes de la table correspondant au modèle Comment
     *
     * @return void
     */
    public function testCommentTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('comments', ["id", "user_id", "task_id", "text", "created_at", "updated_at"]), 1
        );
    }

    /**
     * Vérifie que la contrainte de clé étrangère pour l'utilisateur est bien prise en compte dans la table liée au modèle Comment
     *
     * @return void
     */
    public function testCommentDatabaseThrowsIntegrityConstraintExceptionOnNonExistingUserId() 
    {
        $this->expectException("Illuminate\Database\QueryException");
        $this->expectExceptionCode(23000);
        Comment::factory()->create(['user_id' =>0]);
    }

    /**
     * Vérifie que la contrainte de clé étrangère pour la tâche est bien prise en compte dans la table liée au modèle Comment
     *
     * @return void
     */
    public function testCommentDatabaseThrowsIntegrityConstraintExceptionOnNonExistingTaskId() 
    {
        $this->expectException("Illuminate\Database\QueryException");
        $this->expectExceptionCode(23000);
        Comment::factory()->create(['task_id' =>0]);
    }

    /**
     * Vérifie que le modèle est bien sauvé dans la base de donnée
     * 
     * @return void
     */
    public function testCommentIsSavedInDatabase() {
        $comment = Comment::factory()->create();
        $this->assertDatabaseHas('comments', $comment->attributesToArray());
    }

    /**
     * Vérifie que le modèle est bien supprimé de la base de donnée
     * 
     * @depends testCommentIsSavedInDatabase
     * @return void
     */
    public function testCommentIsDeletedFromDatabase() {
        $comment = Comment::factory()->create();
        $comment->delete();
        $this->assertDeleted($comment);
    }


}