<?php

namespace Tests\Feature\Relations;

use Tests\TestCase;
use App\Models\{Category, User, Task, Comment, Attachment, Board, BoardUser, TaskUser};
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Teste la relation entre le modèle Task et le modèle User, pour vérifier qu'il y a bien un propriétaire 
     *
     * @return void
     */
    public function testTaskBelongsToABoard()
    {
        $board    = Board::factory()->create(); 
        $task    = Task::factory()->create(['board_id' => $board->id]);
        
   
        // Méthode 1 : le board qui contient la tâche est un bien une instance de la classe Board
        $this->assertInstanceOf(Board::class, $task->board);
        
        // Méthode 2: Le nombre de propiétaires de la tâche est bien égal à 1
        $this->assertEquals(1, $task->board()->count());

        //Aide : 
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\BelongsTo', $task->board());


    }

    /**
     * Teste la relation entre le modèle Task et le modèle Category, pour vérifier qu'il y a bien une catégorie assignée à la tâche 
     *
     * @return void
     */
    public function testTaskBelongsToACategory()
    {
        $category = Category::factory()->create(); 
        $task     = Task::factory()->create(['category_id' => $category->id]);
   
        // Méthode 1 : la catégorie de la tâche est un bien une instance de la classe Category
        $this->assertInstanceOf(Category::class, $task->category);
        
        // Méthode 2: Le nombre de catégorie de la tâche est bien égal à 1
        $this->assertEquals(1, $task->category()->count());

        //Aide : 
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\BelongsTo', $task->category());

    }


    /**
     * Teste la relation entre le modèle Task et le modèle User : 
     *
     * @return void
     */
    public function testTaskParticipants()
    {

        $nb         = 3; 
        $board      = Board::factory()->create();
        $boardUsers = BoardUser::factory()->count($nb)->create(['board_id' => $board->id]);
        $task = Task::factory()->create(['board_id' => $board->id]);

        // Test 2: Les utilisateurs sont bien liés à la tâche et sont bien une collection.
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $task->participants);
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\hasManyThrough', $task->participants());
    }


    /**
     * Teste le nombre de participant de la tâche
     * @return void
     */
    public function testTaskNbParticipants()
    {

        $this->markTestIncomplete(
            'TODO : Ce test est pour plus tard.'
        );
        $nb         = 3; 
        $board      = Board::factory()->create(); // Le propriétaire est directement ajouté au participant
        $boardUsers = BoardUser::factory()->count($nb)->create(['board_id' => $board->id]);
        $task = Task::factory()->create(['board_id' => $board->id]);

        // Test 1 : Le nombre d'utilisateur de la tâche est bien égal à $nb (le jeu de données fourni dans la fonction).
        $this->assertEquals($nb+1, $task->participants->count());


    }

    /**
     * Teste la relation entre le modèle Task et le modèle User 
     *
     * @return void
     */
    public function testTaskHasManyAssignedUsers()
    {
        $nb         = 3; 

        $user = User::factory()->create(); 
        $board = Board::factory()->hasUsers($nb-1)->create(['user_id' => $user->id]);
        $task = Task::factory()->create(['board_id' => $board->id]);

        foreach($board->users as $user) {
            TaskUser::factory()->create(['user_id' => $user->id, 'task_id' => $task->id]);
        }

        // test 1: Le nombre d'utilisateurs assignés à la tâche est bien égal à $nb (le jeu de données fourni dans la fonction).
        $this->assertEquals($nb, $task->assignedUsers->count());

        // Test 2: Les utilisateurs assignés sont bien liés à la tâche et sont bien une collection.
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $task->assignedUsers);

        //Aide : 
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\BelongsToMany', $task->assignedUsers());
    }


    /**
     * Teste la relation entre le modèle Task et le modèle Comment 
     *
     * @return void
     */
    public function testTaskHasManyComments()
    {
        
        $task    = Task::factory()->create();
        $comment = Comment::factory()->create(['task_id' => $task->id]);
   
        // Méthode 1 : le commentaire existe dans la liste des commentaires de la tâche
        $this->assertTrue($task->comments->contains($comment));
        
        // Méthode 2: Le nombre de commentaires de la tâche est bien égal à 1 (le jeu de données fourni dans la fonction).
        $this->assertEquals(1, $task->comments->count());

        // Méthode 3: Les commentaires sont bien liés à la tâche et sont bien une collection.
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $task->comments);

        // Méthode 4: pour aide : les commentaires sont liés par la bonne relation eloquent.
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\HasMany', $task->comments());
    }

    /**
     * Teste la relation entre le modèle Task et le modèle Attachment 
     *
     * @return void
     */
    public function testTaskHasManyAttachments()
    {
        $task    = Task::factory()->create();
        $attachment = Attachment::factory()->create(['task_id' => $task->id]);
   
        // Méthode 1 : la pièce jointe existe dans la liste des pièces jointes de la tâche
        $this->assertTrue($task->attachments->contains($attachment));
        
        // Méthode 2: Le nombre de pièces jointes de la tâche est bien égal à 1 (le jeu de données fourni dans la fonction).
        $this->assertEquals(1, $task->attachments->count());

        // Méthode 3: Les pièces jointes sont bien liés à la tâche et sont bien une collection.
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $task->attachments);
        // Méthode 4: pour aide : les modèles sont liés par la bonne relation eloquent.
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\HasMany', $task->attachments());
    }
    
    /**
     * Vérifie la présence du modèle pivot entre les utilisateurs et la table liée au modèle Task
     *
     * @return void
     */
    public function testTaskHasPivotClassForAssignedUsers() {
        $user = User::factory()->create(); 
        $board = Board::factory()->create(['user_id' => $user->id]);
        $task = Task::factory()->create(['board_id' => $board->id]);
        TaskUser::factory()->create(['user_id' => $user->id, 'task_id' => $task->id]);
        $this->assertInstanceOf('App\Models\TaskUser', $task->assignedUsers()->first()->pivot);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\Pivot', $task->assignedUsers()->first()->pivot);
    }


}
