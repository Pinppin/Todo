<?php

namespace Tests\Feature\Relations;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{User, Board, BoardUser};

class BoardUserTest extends TestCase
{
    use RefreshDatabase;

    //---------------- Relationship Testing -----------------------//

    /**
     * Teste la relation entre le modèle BoardUser et le modèle User
     *
     * @return void
     */
    public function testBoardUserBelongsToAnUser()
    {
        $user    = User::factory()->create(); 
        $board_user    = BoardUser::factory()->create(['user_id' => $user->id]);
        
   
        // Méthode 1 : l'utilisateur associé au modèle est un bien une instance de la classe User
        $this->assertInstanceOf(User::class, $board_user->user);
        
        // Méthode 2: Le nombre d'utilisateur auquels est associé le modèle est bien égal à 1
        $this->assertEquals(1, $board_user->user()->count());

        //Aide : 
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\BelongsTo', $board_user->user());

    }



    /**
     * Teste la relation entre le modèle BoardUser et le modèle Board
     *
     * @return void
     */
    public function testBoardUserBelongsToABoard()
    {
        $board    = Board::factory()->create(); 
        $board_user    = BoardUser::factory()->create(['board_id' => $board->id]);
        
   
        // Méthode 1 : la board associée au modèle est un bien une instance de la classe Board
        $this->assertInstanceOf(Board::class, $board_user->board);
        
         // Méthode 2: Le nombre de boards auquels est associée le modèle est bien égal à 1
        $this->assertEquals(1, $board_user->board()->count());
        
        //Aide : 
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\BelongsTo', $board_user->board());
    }

    /**
     * Teste la relation entre le modèle BoardUser et le modèle User
     *
     * @return void
     */
    public function testBoardUserHasManyTasks()
    {
        $nb = 3; 
        $board    = Board::factory()->hasTasks($nb)->create(); 
        $board_user    = BoardUser::factory()->create(['board_id' => $board->id]);
        
        // Test 1 : Le nombre de tâche liées au modèle est bien égal à $nb (le jeu de données fourni dans la fonction).
        $this->assertEquals($nb, $board_user->tasks->count());

        // Test 2: Les tâches sont bien liés au modèle et sont bien une collection.
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $board_user->tasks);

        //Aide : 
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\hasManyThrough', $board_user->tasks());
    }

}
