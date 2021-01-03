<?php

namespace Tests\Feature\Relations;

use Tests\TestCase;
use App\Models\{Category};
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{

    use RefreshDatabase;


    //---------------- Relationship Testing -----------------------//

    /**
     * Teste la relation entre le modèle Category et le modèle Task 
     *
     * @return void
     */
    public function testCategoryHasManyTask() 
    {
        $nb = 3; 
        $category = Category::factory()->hasTasks($nb)->create();
        $this->assertEquals($category->tasks->count(), $nb);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $category->tasks);

        //Aide : 
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Relations\hasMany', $category->tasks());
    }
    

}
