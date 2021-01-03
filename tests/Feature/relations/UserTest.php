<?php

namespace Tests\Feature\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{User, Comment, Attachment, Task, TaskUser, Board};

class UserTest extends TestCase
{
    use RefreshDatabase;



    //---------------- Relationship Testing -----------------------//


    /**
     * Teste la relation entre le modèle User et le modèle Board, pour vérifier la relation de 'propriété' (appartenance)
     *
     * @return void
     */
    public function testUserHasManyOwnedBoard()
    {
        $nb = 3; 
        $user = User::factory()->hasOwnedBoards($nb)->create();
        $this->assertEquals($user->ownedBoards->count(), $nb);
        //On vérifie que la relation d'appartenance n'utilise pas le pivot
        $this->assertNull($user->ownedBoards->first()->pivot);
        //pour aide : les modèles sont liés par la bonne relation eloquent.
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\HasMany', $user->ownedBoards());
    }

    /**
     * Teste la relation entre le modèle User et le modèle Boards (les boards dans lesquels il participe)
     *
     * @return void
     */
    public function testUserHasManyBoards()
    {
        $nb         = 3; 
        $user       = User::factory()
                        ->hasBoards($nb)
                        ->create();

        // Les boards dont l'utilisateur est participant sont bien liés à la board et sont bien une collection.
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->boards);
        //pour aide : les modèles sont liés par la bonne relation eloquent.
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\BelongsToMany', $user->boards());
    }

    /**
     * Teste la relation entre le modèle User et le modèle Boards (les boards dans lesquels il participe)
     *
     * @return void
     */
    public function testUserBoardsCount()
    {
        $nb         = 3; 
        $user = null ; //TODO prepare dataset 
        $this->markTestIncomplete(
            'TODO : Ce test est pour plus tard.'
        );
        // Le nombre de board de l'utilisateur est bien égal à $nb (le jeu de données fourni dans la fonction).
       // $this->assertEquals($nb + 1, $user->boards->count());
    }

    /**
     * Teste la relation entre le modèle Task et le modèle User 
     * @todo
     * @return void
     */
    public function testUserHasManyAssignedTasks()
    {
        $nb         = 3; 
        $user = User::factory()->create(); 
        $board = Board::factory()->hasTasks($nb)->create(['user_id' => $user->id]);
        

        foreach($board->tasks as $task) {
            TaskUser::factory()->create(['user_id' => $user->id, 'task_id' => $task->id]);
        }

        // test 1: Le nombre de tâches assignées à l'utilisateurs est bien égal à $nb (le jeu de données fourni dans la fonction).
        $this->assertEquals($nb, $user->assignedTasks->count());

        // Test 2: Les tâches assignées sont bien liées à l'utilisateur et sont bien une collection.
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->assignedTasks);
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\BelongsToMany', $user->assignedTasks());
    }

    /**
     * Teste la relation entre le modèle Task et le modèle User 
     * @todo
     * @return void
     */
    public function testUserAllTasks()
    {
        $nb         = 3; 
        $user       = User::factory()
                        ->hasAllTasks($nb)
                        ->create();
        // Test 2: Les tâches assignées sont bien liées à l'utilisateur et sont bien une collection.
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->allTasks);
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\HasManyThrough', $user->allTasks());
    }

    /**
     * Teste la relation entre le modèle Task et le modèle User 
     * @todo
     * @return void
     */
    public function testUserAllTasksCount()
    {
        $nb         = 3; 
        $user       = User::factory()
                        ->hasAllTasks($nb)
                        ->create();
        $this->markTestIncomplete(
            'TODO : Ce test est pour plus tard.'
        );
        // Le nombre de tâches auquelles participent l'utilisateurs est bien égal à $nb (le jeu de données fourni dans la fonction).
        $this->assertEquals($nb, $user->allTasks->count());
    }

    /**
     * Teste la relation entre le modèle User et le modèle Comment 
     *
     * @return void
     */
    public function testUserHasManyComments()
    {
        
        $user    = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);
   
        // Méthode 1 : le commentaire existe dans la liste des commentaires de l'utilisateur
        $this->assertTrue($user->comments->contains($comment));
        
        // Méthode 2: Le nombre de commentaires de l'utilisateur est bien égal à 1 (le jeu de données fourni dans la fonction).
        $this->assertEquals(1, $user->comments->count());

        // Méthode 3: Les commentaires sont bien liés à l'utilisateur et sont bien une collection.
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->comments);

        //pour aide : les commentaires sont liés par la bonne relation eloquent.
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $user->comments());
    }

    /**
     * Teste la relation entre le modèle User et le modèle Attachment 
     *
     * @return void
     */
    public function testUserHasManyAttachments()
    {
        $user    = User::factory()->create();
        $attachment = Attachment::factory()->create(['user_id' => $user->id]);
   
        // Méthode 1 : la pièce jointe existe dans la liste des pièces jointes de l'utilisateur
        $this->assertTrue($user->attachments->contains($attachment));
        
        // Méthode 2: Le nombre de pièces jointes de l'utilisateur est bien égal à 1 (le jeu de données fourni dans la fonction).
        $this->assertEquals(1, $user->attachments->count());

        // Méthode 3: Les pièces jointes sont bien liés à l'utilisateur et sont bien une collection.
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->attachments);
        //pour aide : les modèles sont liés par la bonne relation eloquent.
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $user->comments());
    }

}
