<?php

namespace Tests\Feature\Relations;

use Tests\TestCase;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{User, Task, TaskUser, Board};

class TaskUserTest extends TestCase
{
    //use RefreshDatabase;

    //---------------- Relationship Testing -----------------------//

    /**
     * Teste la relation entre le modèle TaskUser et le modèle User
     *
     * @return void
     */
    public function testTaskUserBelongsToAnUser()
    {
        $user    = User::factory()->create(); 
        $task_user    = TaskUser::factory()->create(['user_id' => $user->id]);
        
   
        // Méthode 1 : l'utilisateur associé au modèle est un bien une instance de la classe User
        $this->assertInstanceOf(User::class, $task_user->user);
        
        // Méthode 2: Le nombre d'utilisateur auquels est associée le modèle est bien égal à 1
        $this->assertEquals(1, $task_user->user()->count());

        //Aide : 
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\BelongsTo', $task_user->user());

    }


    /**
     * Teste la relation entre le modèle Comment et le modèle Task
     *
     * @return void
     */
    public function testTaskUserBelongsToATask()
    {
        $task    = Task::factory()->create(); 
        $task_user    = TaskUser::factory()->create(['task_id' => $task->id]);
        
   
        // Méthode 1 : la tâche associée au modèle est un bien une instance de la classe Task
        $this->assertInstanceOf(Task::class, $task_user->task);
        
        // Méthode 2: Le nombre de tâches auquelles est associé le modèle est bien égal à 1
        $this->assertEquals(1, $task_user->task()->count());

        //Aide : 
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\BelongsTo', $task_user->task());

    }


    /**
     * On ne peut pas assigner une tâche à un utilisateur si cet utilisateur ne participe pas au board auquel appartient la tâche
     *
     * @return void
     */
    public function testUserCannotBeAssignedToATaskIfHeIsNotInTheBoardTheTaskBelongsTo() {
        $user = User::factory()->create(); 
        $board = Board::factory()->create();
        $task = Task::factory()->create(['board_id' => $board->id]);

        $task_user = new TaskUser(); 
        $task_user->user_id =  $user->id; 
        $task_user->task_id = $task->id; 
        $task_user->save(); 

        $this->assertDatabaseMissing('task_user', $task_user->attributesToArray());

    }

}
