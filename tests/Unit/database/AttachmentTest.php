<?php

namespace Tests\Unit\Database;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use App\Models\{Attachment};
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttachmentTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Teste les colonnes de la table correspondant au modèle Attachment
     *
     * @return void
     */
    public function testAttachmentTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('attachments', 
                [
                    "id", "user_id", "task_id", "file", "filename",
                    "size", "type", "created_at", "updated_at"
                ]
            ), 1
        );
    }

    /**
     * Vérifie que la contrainte de clé étrangère pour l'utilisateur est bien prise en compte dans la table liée au modèle Attachment
     *
     * @return void
     */
    public function testAttachmentDatabaseThrowsIntegrityConstraintExceptionOnNonExistingUserId() 
    {
        $this->expectException("Illuminate\Database\QueryException");
        $this->expectExceptionCode(23000);
        Attachment::factory()->create(['user_id' => 0]);
    }

    /**
     * Vérifie que la contrainte de clé étrangère pour la tâche est bien prise en compte dans la table liée au modèle Attachment
     *
     * @return void
     */
    public function testAttachmentDatabaseThrowsIntegrityConstraintExceptionOnNonExistingTaskId() 
    {
        $this->expectException("Illuminate\Database\QueryException");
        $this->expectExceptionCode(23000);
        Attachment::factory()->create(['task_id' => 0]);
    }

    /**
     * Vérifie que le modèle est bien sauvé dans la base de donnée
     * 
     * @return void
     */
    public function testAttachmentIsSavedInDatabase() {
        $attachment    = Attachment::factory()->create();
        $this->assertDatabaseHas('attachments', $attachment->attributesToArray());
    }

    /**
     * Vérifie que le modèle est bien supprimé de la base de donnée
     * 
     * @depends testAttachmentIsSavedInDatabase
     * @return void
     */
    public function testAttachmentIsDeletedFromDatabase() {
        $attachment = Attachment::factory()->create();
        $attachment->delete();
        $this->assertDeleted($attachment);
    }

}
