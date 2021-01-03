<?php

namespace Tests\Feature\Relations;

use Tests\TestCase;
use App\Models\{User, Task, Comment};
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{


    use RefreshDatabase;

 



    //---------------- Relationship Testing -----------------------//

    /**
     * Teste la relation entre le modèle Comment et le modèle User
     *
     * @return void
     */
    public function testCommentBelongsToAnUser()
    {
        $user    = User::factory()->create(); 
        $comment    = Comment::factory()->create(['user_id' => $user->id]);
        
   
        // Méthode 1 : l'utilisateur associé au modèle est un bien une instance de la classe User
        $this->assertInstanceOf(User::class, $comment->user);
        
        // Méthode 2: Le nombre d'utilisateur auquels est associé le commentaire est bien égal à 1
        $this->assertEquals(1, $comment->user()->count());

        //Aide : 
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\BelongsTo', $comment->user());

    }


    /**
     * Teste la relation entre le modèle Comment et le modèle Task
     *
     * @return void
     */
    public function testCommentBelongsToATask()
    {
        $task    = Task::factory()->create(); 
        $comment    = Comment::factory()->create(['task_id' => $task->id]);
        
   
        // Méthode 1 : la tâche associée au commentaire est un bien une instance de la classe Task
        $this->assertInstanceOf(Task::class, $comment->task);
        
        // Méthode 2: Le nombre de tâche auquelles est associé le commentaire est bien égal à 1
        $this->assertEquals(1, $comment->task()->count());

        //Aide : 
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\BelongsTo', $comment->task());

    }



}