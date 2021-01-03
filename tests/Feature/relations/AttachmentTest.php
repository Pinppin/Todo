<?php

namespace Tests\Feature\Relations;

use Tests\TestCase;
use App\Models\{Attachment, User, Task};
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttachmentTest extends TestCase
{

    use RefreshDatabase;


    /**
     * Teste la relation entre le modèle Attachment et le modèle Task
     *
     * @return void
     */
    public function testAttachmentBelongsToATask()
    {
        $task    = Task::factory()->create(); 
        $attachment    = Attachment::factory()->create(['task_id' => $task->id]);
        
   
        // Méthode 1 : la tâche associée à la pièce jointe est un bien une instance de la classe Task
        $this->assertInstanceOf(Task::class, $attachment->task);
        
        // Méthode 2: Le nombre de tâche auquelles est associée la pièce jointe est bien égal à 1
        $this->assertEquals(1, $attachment->task()->count());

        //Aide : 
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\BelongsTo', $attachment->task());

    }


    /**
     * Teste la relation entre le modèle Attachment et le modèle User
     *
     * @return void
     */
    public function testAttachmentBelongsToAnUser()
    {
        $user    = User::factory()->create(); 
        $attachment    = Attachment::factory()->create(['user_id' => $user->id]);
        
   
        // Méthode 1 : l'utilisateur associé à la pièce jointe est un bien une instance de la classe User
        $this->assertInstanceOf(User::class, $attachment->user);
        
        // Méthode 2: Le nombre d'utilisateur auquels est associée la pièce jointe est bien égal à 1
        $this->assertEquals(1, $attachment->user()->count());

        //Aide : 
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\BelongsTo', $attachment->user());

    }

}
