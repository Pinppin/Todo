<?php

namespace Tests\Unit\Database;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use App\Models\{Category, User, Task, Comment, Attachment, TaskUser};
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Teste les colonnes de la table correspondant au modèle Task
     *
     * @return void
     */
    public function testTaskTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('tasks', ["id", "title", "description", 
                                "due_date", "state", "category_id", /*"user_id",*/ 
                                "board_id", "created_at", "updated_at"]), 1
        );
    }

    /**
     * Vérifie que le modèle est bien sauvé dans la base de donnée
     * 
     * @return void
     */
    public function testTaskIsSavedInDatabase() {
        $task = Task::factory()->create();
        $this->assertDatabaseHas('tasks', $task->attributesToArray());
    }

    /**
     * Vérifie qu'une tâche peut être supprimée, même si elle est réferencée par d'autres modèles
     *
     * @depends testTaskIsSavedInDatabase
     * @return void
     */
    public function testTaskIsDeletedFromDatabase() {

        $task = Task::factory()->create(); 
        Attachment::factory()->create(["task_id" => $task->id]);
        Comment::factory()->create(["task_id" => $task->id]);
        TaskUser::factory()->create(["task_id" => $task->id]);

        $task->delete(); 
        $this->assertDeleted($task);
    }
    
    /**
     * Vérifie que la contrainte de clé étrangère pour l'utilisateur est bien prise en compte dans la table liée au modèle Task
     *
     * @return void
     */
    public function testTaskDatabaseThrowsIntegrityConstraintExceptionOnNonExistingUserId() 
    {
        $this->expectException("Illuminate\Database\QueryException");
        $this->expectExceptionCode(23000);
        Task::factory()->create(['board_id' =>0]);
    }
    
    /**
     * Vérifie que la contrainte de clé étrangère pour la catégorie est bien prise en compte dans la table liée au modèle Task
     *
     * @return void
     */
    public function testTaskDatabaseThrowsIntegrityConstraintExceptionOnNonExistingCategoryId() 
    {
        $this->expectException("Illuminate\Database\QueryException");
        $this->expectExceptionCode(23000);
        Task::factory()->create(['category_id' =>0]);
    }
  
}
