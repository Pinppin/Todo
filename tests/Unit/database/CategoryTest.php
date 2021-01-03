<?php

namespace Tests\Unit\Database;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\{Category};
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{

    use WithFaker, RefreshDatabase;
    //----------- Database Testing --------------//
    
    /**
     * Teste les colonnes de la table correspondant au modèle Category
     *
     * @return void
     */
    public function testCategoryTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('categories', ["id", "name", "created_at", "updated_at"]), 1
        );
    }


    /**
     * Vérifie que le modèle est bien sauvé dans la base de donnée
     * 
     * @return void
     */
    public function testCategoryIsSavedInDatabase() {
        $categorie = Category::factory()->create();
        $this->assertDatabaseHas('categories', $categorie->attributesToArray());
    }

    /**
     * Vérifie que le modèle est bien supprimé de la base de donnée
     * 
     * @depends testCategoryIsSavedInDatabase
     * @return void
     */
    public function testCategoryIsDeletedFromDatabase() {
        $categorie = Category::factory()->hasTasks()->create();
        $categorie->delete();
        $this->assertDeleted($categorie);
    }


}
